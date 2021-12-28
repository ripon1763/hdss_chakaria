<?php
   
require APPPATH . 'libraries/REST_Controller.php';
     
class PullData extends REST_Controller {
    
	/**
     * Pull Data from the server.
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();
       $this->load->database();
    }

    public function index_get($userID = 0)
    {
        $data = array();
        // Taking single user info and extract slumID and slumAreaID
        $slumID = NULL;
        $slumAreaID = NULL;
        $userData = array();
        if(!empty($userID))
        {
            $userData = $this->db->select('slum_id, slum_area_id')->get_where("tbl_users", 
                [
                    'userID' => $userID,
                    'isDeleted' => 0,
                    'active' => 1
                ]
            )->row();

            if(!empty($userData)){
                $slumID = $userData->slum_id;
                $slumAreaID = $userData->slum_area_id;
            }
        }

        $roundId = $this->db->select('id, active,roundNo')->from('tbl_round_master')->order_by('id','desc')->limit(1)->get()->row()->id;

        // Get all household from slumID and slumAreaID
        if(isset($slumID) && isset($slumAreaID))
        {
            $data['household_master'] = $this->db->select('*')->get_where("household_master", 
                [
                    'fk_slum_id' => $slumID,
                    'fk_slum_area_id' => $slumAreaID
                ]
            )->result_array();
        }else{
            $data['household_master'] = array();
        }

        $household_master_ids = array();
        $household_asset_ids = array();
        $member_master_last_head_ids = array();

        foreach ($data['household_master'] as $hm) {
            $household_master_ids[] = $hm['id'];
            $household_asset_ids[] = $hm['household_asset_id_last'];
            $member_master_last_head_ids[] = $hm['member_master_id_last_head'];
        }

        //Get all member_master and household_assets from household Ids
        if(!empty($household_master_ids))
        {
            $data['member_master'] = $this->db->select('*')->from("tbl_member_master")->where_in("household_master_id_hh", $household_master_ids)->get()->result_array();

            $data['household_assets'] = $this->db->select('*')->from("tbl_household_assets")->where_in("id", $household_asset_ids)->get()->result_array();

            $data['household_visit'] = $this->db->select('*')->from("tbl_household_visit")->where("round_master_id", $roundId)->where_in("household_master_id", $household_master_ids)->get()->result_array();

            $data['baseline_census'] = $this->db->select('*')->from("tbl_baseline_census")->where("round_master_id", $roundId)->where_in("household_master_id", $household_master_ids)->get()->result_array();
        }else{
            $data['member_master'] = array();
            $data['household_assets'] = array();
            $data['household_visit'] = array();
            $data['baseline_census'] = array();
        }

        $member_master_ids = array();
        $fk_education_ids = array();
        $fk_member_relation_ids = array();
        $fk_occupation_ids = array();
        foreach ($data['member_master'] as $mm) {
            $member_master_ids[] = $mm['id'];
            $fk_education_ids[] = $mm['fk_education_id_last'];
            $fk_member_relation_ids[] = $mm['fk_member_relation_id_last'];
            $fk_occupation_ids[] = $mm['fk_occupation_id_last'];
        }

        //Get all household_visit data from member Ids
        if(!empty($member_master_ids))
        {
            $data['member_household'] = $this->db->select('*')->from("tbl_member_household")->where_in("member_master_id", $member_master_ids)->get()->result_array();
            
            $data['member_migration_in'] = $this->db->select('*')->from("tbl_member_migration_in")->where("round_master_id", $roundId)->where_in("member_master_id", $member_master_ids)->get()->result_array();

            $data['member_migration_out'] = $this->db->select('*')->from("tbl_member_migration_out")->where("round_master_id", $roundId)->where_in("member_master_id", $member_master_ids)->get()->result_array();

            $data['member_marriage_start'] = $this->db->select('*')->from("tbl_member_marriage_start")->where("round_master_id", $roundId)->where_in("member_master_id", $member_master_ids)->get()->result_array();

            $data['member_marriage_end'] = $this->db->select('*')->from("tbl_member_marriage_end")->where("round_master_id", $roundId)->where_in("member_master_id", $member_master_ids)->get()->result_array();

            // **No Round id**
            $data['member_conception'] = $this->db->select('*')->from("tbl_member_conception")->where_in("member_master_id", $member_master_ids)->get()->result_array();

            $data['member_pregnancy'] = $this->db->select('*')->from("tbl_member_pregnancy")->where("round_master_id", $roundId)->where_in("member_master_id", $member_master_ids)->get()->result_array();

            // **No Round id**
            $data['member_education'] = $this->db->select('*')->from("tbl_member_education")->where_in("id", $fk_education_ids)->get()->result_array();

            // **No Round id**
            $data['member_relation'] = $this->db->select('*')->from("tbl_member_relation")->where_in("id", $fk_member_relation_ids)->get()->result_array();

            $data['member_death'] = $this->db->select('*')->from("tbl_member_death")->where("round_master_id", $roundId)->where_in("member_master_id", $member_master_ids)->get()->result_array();

            // **No Round id**
            $data['member_occupation'] = $this->db->select('*')->from("tbl_member_occupation")->where_in("id", $fk_occupation_ids)->get()->result_array();

            $data['household_head'] = $this->db->select('*')->from("tbl_household_head")->where_in("id", $member_master_last_head_ids)->get()->result_array();

            $data['member_immunization'] = $this->db->select('*')->from("tbl_member_immunization")->where("round_master_id", $roundId)->where_in("member_master_id", $member_master_ids)->get()->result_array();

            $data['family_planning'] = $this->db->select('*')->from("tbl_member_family_planning")->where("round_master_id", $roundId)->where_in("member_master_id", $member_master_ids)->get()->result_array();

            $data['child_illness'] = $this->db->select('*')->from("tbl_member_child_illness")->where("round_master_id", $roundId)->where_in("member_master_id", $member_master_ids)->get()->result_array();
        }else{
            $data['member_household'] = array();
            $data['member_migration_in'] = array();
            $data['member_migration_out'] = array();
            $data['member_marriage_start'] = array();
            $data['member_marriage_end'] = array();
            $data['member_conception'] = array();
            $data['member_pregnancy'] = array();
            $data['member_education'] = array();
            $data['member_relation'] = array();
            $data['member_death'] = array();
            $data['member_occupation'] = array();
            $data['household_head'] = array();
            $data['member_immunization'] = array();

            $data['family_planning'] = array();
            $data['child_illness'] = array();
        }

        $this->response($data, REST_Controller::HTTP_OK);
    }
}