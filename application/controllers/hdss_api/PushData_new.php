<?php
   
require APPPATH . 'libraries/REST_Controller.php';
     
class PushData extends REST_Controller {
    
	/**
     * Push Data to the server.
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();
       $this->load->database();
    }

    private function isValidDate($date = null){
        if ($date != '') {
            $date_parts = array();
            $date_parts = explode('-', $date );
            if (isset($date_parts[2])) {
                if(checkdate( $date_parts[1], $date_parts[2], $date_parts[0] )){
                    return true;
                }else{
                    return false;
                }   
            }
        }else{
            return false;
        }
    }

    //insert all data of 20 tables
    public function index_post()
    {
        $inputs = json_decode(file_get_contents('php://input'), true);
        $result = array();
        $response = array();

        //Insert or update household_master table
        if (!empty($inputs['household_master'])) {
            foreach ($inputs['household_master'] as $data) {
                unset($data['id']);

                $data['extinct_date'] = $this->isValidDate($data['extinct_date']) ? date('Y-m-d', strtotime($data['extinct_date'])) : null;
                $data['entry_date'] = date('Y-m-d', strtotime($data['entry_date']));
                $data['insertedOn'] = date('Y-m-d H:i:s', strtotime($data['insertedOn']));
                $data['updatedOn'] = $this->isValidDate($data['updatedOn']) ? date('Y-m-d H:i:s', strtotime($data['updatedOn'])) : null;
                
                if ($data['updateBy'] <= 0) {
                    $result = array(
                        'type' => 'insert',
                        'mobile_id' => $data['mobile_id'],
                        'SyncStatus' => $this->db->insert('household_master', $data)
                    );
                }else{
                    unset($data['household_code']);
                    $this->db->where('mobile_id', $data['mobile_id'])->update('household_master', $data);
                    $result = array(
                        'type' => 'update',
                        'mobile_id' => $data['mobile_id'],
                        'SyncStatus' => $this->db->affected_rows() > 0 ? true :false
                    );
                }
                $response['household_master'] = $result;
            }    
        }else{
            $response['household_master'] = array();
        }

        //Insert or update member_master table
        if (!empty($inputs['member_master'])) {
            foreach ($inputs['member_master'] as $data) {
                unset($data['id']);

                $data['birth_date'] = $this->isValidDate($data['birth_date']) ? date('Y-m-d', strtotime($data['birth_date'])) : null;
                $data['birth_registration_date'] = $this->isValidDate($data['birth_registration_date']) ? date('Y-m-d', strtotime($data['birth_registration_date'])) : null;
                $data['followup_exit_date'] = $this->isValidDate($data['followup_exit_date']) ? date('Y-m-d', strtotime($data['followup_exit_date'])) : null;
                $data['last_marriage_date'] = $this->isValidDate($data['last_marriage_date']) ? date('Y-m-d', strtotime($data['last_marriage_date'])) : null;
                $data['last_marriage_end_date'] = $this->isValidDate($data['last_marriage_end_date']) ? date('Y-m-d', strtotime($data['last_marriage_end_date'])) : null;
                
                $data['insertedOn'] = date('Y-m-d H:i:s', strtotime($data['insertedOn']));
                $data['updatedOn'] = $this->isValidDate($data['updatedOn']) ? date('Y-m-d H:i:s', strtotime($data['updatedOn'])) : null;
                
                if ($data['updateBy'] <= 0) {
                    $result = array(
                        'type' => 'insert',
                        'mobile_id' => $data['mobile_id'],
                        'SyncStatus' => $this->db->insert('tbl_member_master', $data)
                    );
                }else{
                    unset($data['member_code']);
                    $this->db->where('mobile_id', $data['mobile_id'])->update('tbl_member_master', $data);
                    $result = array(
                        'type' => 'update',
                        'mobile_id' => $data['mobile_id'],
                        'SyncStatus' => $this->db->affected_rows() > 0 ? true :false
                    );
                }
                $response['member_master'] = $result;
            }    
        }else{
            $response['member_master'] = array();
        }

        //Insert or update household_assets table
        if (!empty($inputs['household_assets'])) {
            foreach ($inputs['household_assets'] as $data) {
                unset($data['id']);
                
                $data['insertedOn'] = date('Y-m-d H:i:s', strtotime($data['insertedOn']));
                $data['updatedOn'] = $this->isValidDate($data['updatedOn']) ? date('Y-m-d H:i:s', strtotime($data['updatedOn'])) : null;
                
                if ($data['updateBy'] <= 0) {
                    $result = array(
                        'type' => 'insert',
                        'mobile_id' => $data['mobile_id'],
                        'SyncStatus' => $this->db->insert('tbl_household_assets', $data)
                    );
                }else{
                    $this->db->where('mobile_id', $data['mobile_id'])->update('tbl_household_assets', $data);
                    $result = array(
                        'type' => 'update',
                        'mobile_id' => $data['mobile_id'],
                        'SyncStatus' => $this->db->affected_rows() > 0 ? true :false
                    );
                }
                $response['household_assets'] = $result;
            }    
        }else{
            $response['household_assets'] = array();
        }

        $this->response($response, REST_Controller::HTTP_OK);
    }
}