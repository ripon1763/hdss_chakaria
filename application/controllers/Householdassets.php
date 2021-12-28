<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Householdassets extends BaseController
{
    /**
     * This is default constructor of the class
     */
	 
	public $controller = "householdassets";
	public $pageTitle = 'Household Assets';
	public $pageShortName = 'Household Assets';
	
	 
    public function __construct()
    {
        parent::__construct();
		$this->load->model('master_model','modelName');
        $this->load->model('member_model','memberModel');
        $this->load->model('householdVisit_model','visitModel');
        $this->load->model('Householdasset_model','assetModel');
		$this->load->model('menu_model','menuModel');
		$this->load->library('pagination');
        $this->isLoggedIn(); 
		 $menu_key = 'visit';
         $baseID = $this->input->get('baseID',TRUE);
		 $result = $this->loadThisForAccess($this->role,$baseID,$menu_key);
		 if ($result != true) 
		 {
			 redirect('access');
		 }

      
			
    }
    

    public function addEditAsset()
    {
            $baseID = $this->input->get('baseID', TRUE);
            $household_master_id_current = $this->input->get('household_master_id', TRUE);
            $this->global['menu'] =  $this->menuModel->getMenu($this->role);
            
            $this->global['pageTitle'] = $this->config->item('prefix'). ' : Household Assets' ;
            $data['pageTitle'] = $this->pageTitle;
            $data['controller'] = $this->controller;
            $data['addMethod'] = 'addNew';
            $data['editMethod'] = 'editOld';
            $data['shortName'] = $this->pageShortName;
            $data['boxTitle'] = 'List';

            // $this->$rountStatus = $this->getCurrentRound()[0]->active;
            // $this->$roundID =  $this->getCurrentRound()[0]->id;

            if ($this->getCurrentRound()[0]->active == 0)
            {

              $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
              redirect($this->controller.'?baseID='.$baseID);
            }

            // $this->$rountStatus = $this->getCurrentRound()[0]->active;
            $data['roundNo'] =  $this->getCurrentRound()[0]->roundNo;
            $data['round_master_id'] =  $this->getCurrentRound()[0]->id;
            $data['householdcode'] =  $this->session->userdata('householdcode');

            $data['household_master_id_sub'] = 0;

            $data['household_master_id_sub'] = $this->session->userdata('household_master_id_sub');

            if ($data['household_master_id_sub'] == 0)
            {
                redirect('householdvisit/visit?baseID='.$baseID);
            }
          
            
            $data['householdVisit'] = $this->visitModel->getHouseholdVisitDet($this->config->item('householdVisitTable'),$data['household_master_id_sub'],$data['round_master_id']);

            $data['assetYesNo'] = $this->modelName->getLookUpList($this->config->item('asset_yes_no'));
            $data['house_owner'] = $this->modelName->getLookUpList($this->config->item('house_owner'));
            $data['land_owner'] = $this->modelName->getLookUpList($this->config->item('land_owner'));
            
            $data['addPerm']  =  $this->getPermission($baseID, $this->role, 'add');
            $data['editPerm'] =  $this->getPermission($baseID, $this->role, 'edit');
    
            $this->load->view('includes/header', $this->global);
             $this->load->view('includes/wizard', $data);
            $this->load->view($this->controller.'/assets_details', $data);
            $this->load->view('includes/footer');
        
    }

    function addNewAsset()
    {
          
          //  print_r($this->input->post()); die();


            $household_master_id = $this->input->post('household_master_id_sub',true);
            $round_master_id = $this->input->post('round_master_id',true);
            $householdvisitID = $this->input->post('householdvisitID',true);

            $this->load->library('form_validation');
            $this->form_validation->set_rules('fk_owner_land','Land Owner','trim|required|numeric');
            $this->form_validation->set_rules('fk_owner_house','House Owner','trim|required|numeric');
            $this->form_validation->set_rules('fk_chair','Chair','trim|required|numeric');
            $this->form_validation->set_rules('fk_dining_table','Dining Table','trim|required|numeric');
            $this->form_validation->set_rules('fk_khat','Khat','trim|required|numeric');
            $this->form_validation->set_rules('fk_chowki','Chowki','trim|required|numeric');
            $this->form_validation->set_rules('fk_almirah','Almirah','trim|required|numeric');
            $this->form_validation->set_rules('fk_sofa','Sofa','trim|required|numeric');
            $this->form_validation->set_rules('fk_radio','Radio','trim|required|numeric');

            $this->form_validation->set_rules('fk_tv','TV','trim|required|numeric');
            $this->form_validation->set_rules('fk_freeze','Fridge','trim|required|numeric');

            $this->form_validation->set_rules('fk_mobile','Entry Date','trim|required|numeric');
            $this->form_validation->set_rules('fk_electric_fan','Electric_Fan','trim|required|numeric');
            $this->form_validation->set_rules('fk_hand_watch','Hand Watch','trim|required|numeric');
            $this->form_validation->set_rules('fk_rickshow','Rikshaw','trim|required|numeric');
            $this->form_validation->set_rules('fk_computer','Computer','trim|required|numeric');
            $this->form_validation->set_rules('fk_sewing_machine','Sewing machine','trim|required|numeric');
            $this->form_validation->set_rules('fk_cycle','By Cycle','trim|required|numeric');
            $this->form_validation->set_rules('fk_motor_cycle','Motor Cycle','trim|required|numeric');
           
              
            $baseID = $this->input->get('baseID', TRUE);
           
           if($this->form_validation->run() == FALSE)
            {
                redirect('householdassets/addEditAsset?household_master_id='.$household_master_id.'&&baseID='.$baseID.'#asset');
            }
            else
            {

               if ($this->getCurrentRound()[0]->active == 0)
               {

                  $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                  redirect('householdvisit/visit?baseID='.$baseID);
               }

               $whereHouseholdAsset = array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id);

               $countRow = $this->db->select('count(id) as countRow')->from($this->config->item('householdAssetTable'))->where($whereHouseholdAsset)->get()->row()->countRow;

               if ($countRow > 0)
               {
                  $this->session->set_flashdata('error', 'Asset already exists for this round.');
                  redirect('householdvisit/assets?baseID='.$baseID.'#asset');
               }

                
                $fk_owner_land = $this->input->post('fk_owner_land',true);
                $fk_owner_house = $this->input->post('fk_owner_house',true);
                $fk_chair = $this->input->post('fk_chair',true);
                $fk_dining_table = $this->input->post('fk_dining_table',true);
                $fk_khat = $this->input->post('fk_khat',true);
                $fk_chowki = $this->input->post('fk_chowki',true);
                $fk_almirah = $this->input->post('fk_almirah',true);
                $fk_sofa = $this->input->post('fk_sofa',true);
                $fk_radio = $this->input->post('fk_radio',true);
                $fk_tv = $this->input->post('fk_tv',true);
                $fk_freeze = $this->input->post('fk_freeze',true);
                $fk_mobile = $this->input->post('fk_mobile',true);
                $fk_electric_fan = $this->input->post('fk_electric_fan',true);
                $fk_hand_watch = $this->input->post('fk_hand_watch',true);
                $fk_rickshow = $this->input->post('fk_rickshow',true);
                $fk_computer = $this->input->post('fk_computer',true);
                $fk_sewing_machine = $this->input->post('fk_sewing_machine',true);
                $fk_cycle = $this->input->post('fk_cycle',true);
                $fk_motor_cycle = $this->input->post('fk_motor_cycle',true);

                $round_master_id_entry_round =  $this->getCurrentRound()[0]->id;

                $this->db->trans_start();

                try
                { 

                    

                    $IdInfo = array(
                        'fk_owner_land'=>$fk_owner_land, 
                        'fk_owner_house'=>$fk_owner_house, 
                        'fk_chair'=>$fk_chair, 
                        'fk_dining_table'=>$fk_dining_table, 
                        'fk_khat'=>$fk_khat, 
                        'fk_chowki'=>$fk_chowki, 
                        'fk_almirah'=>$fk_almirah, 
                        'fk_radio'=>$fk_radio, 
                        'fk_tv'=>$fk_tv, 
                        'fk_freeze'=>$fk_freeze, 
                        'fk_sofa'=>$fk_sofa, 
                        'fk_mobile'=>$fk_mobile, 
                        'fk_electric_fan'=>$fk_electric_fan, 
                        'fk_hand_watch'=>$fk_hand_watch, 
                        'fk_rickshow'=>$fk_rickshow, 
                        'fk_computer'=>$fk_computer, 
                        'fk_sewing_machine'=>$fk_sewing_machine, 
                        'fk_cycle'=>$fk_cycle, 
                        'fk_motor_cycle'=>$fk_motor_cycle, 
                        'round_master_id'=>$round_master_id_entry_round, 
                        'household_master_id'=>$household_master_id, 
                        'insertedBy'=>$this->vendorId, 
                        'insertedOn'=>date('Y-m-d H:i:s')
                    );
                        
                    $resultID = $this->assetModel->addNew($IdInfo,$this->config->item('householdAssetTable'));

                    $masterData = array(
                                'household_asset_id_last' => $resultID,
                                'updateBy' => $this->vendorId,
                                'updatedOn' => date('Y-m-d H:i:s')
                            );

                    $this->assetModel->edit($masterData,$household_master_id,$this->config->item('householdMasterTable'));

                    // visit
                    $whereHouseholdVisit = array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id);

                     $countVisit = $this->db->select('count(id) as countVisit')->from($this->config->item('householdVisitTable'))->where($whereHouseholdVisit)->get()->row()->countVisit;

                     if ($countVisit > 0)
                     {

                        $visitID = $this->db->select('id')->from($this->config->item('householdVisitTable'))->where($whereHouseholdVisit)->get()->row()->id;

                        $householdVisit= array(
                        'any_asset'=>1, 
                        'transfer_complete'=>'No',  
                        'updateBy'=>$this->vendorId, 
                        'updatedOn'=>date('Y-m-d H:i:s')
                        );

                        $this->modelName->editList($householdVisit,$visitID,$this->config->item('householdVisitTable'));

                     }

                    
                    
                }
                catch(Exception $e)
                {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('error', 'Error occurred while creating household Asset.');
                }

                $this->db->trans_commit();
                $this->session->set_flashdata('success','Household Asset created successfully.');
                
                redirect('householdvisit/assets?baseID='.$baseID.'#asset');
            }
        
    }


    public function editAsset($id)
    {
            $baseID = $this->input->get('baseID', TRUE);
            $household_master_id_current = $this->input->get('household_master_id', TRUE);
            $this->global['menu'] =  $this->menuModel->getMenu($this->role);
            
            $this->global['pageTitle'] = $this->config->item('prefix'). ' : Household Assets' ;
            $data['pageTitle'] = $this->pageTitle;
            $data['controller'] = $this->controller;
            $data['addMethod'] = 'addNew';
            $data['editMethod'] = 'editOld';
            $data['shortName'] = $this->pageShortName;
            $data['boxTitle'] = 'List';

            // $this->$rountStatus = $this->getCurrentRound()[0]->active;
            // $this->$roundID =  $this->getCurrentRound()[0]->id;

            if ($this->getCurrentRound()[0]->active == 0)
            {

              $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
              redirect($this->controller.'?baseID='.$baseID);
            }

            // $this->$rountStatus = $this->getCurrentRound()[0]->active;
            $data['roundNo'] =  $this->getCurrentRound()[0]->roundNo;
            $data['round_master_id'] =  $this->getCurrentRound()[0]->id;
            $data['householdcode'] =  $this->session->userdata('householdcode');

            $data['household_master_id_sub'] = 0;

            $data['household_master_id_sub'] = $this->session->userdata('household_master_id_sub');

            if ($data['household_master_id_sub'] == 0)
            {
                redirect('householdvisit/visit?baseID='.$baseID);
            }

            $data['assetrecord'] = $this->assetModel->getAssetDetails($this->config->item('householdAssetTable'),$data['household_master_id_sub'],$id);
          

            $data['assetYesNo'] = $this->modelName->getLookUpList($this->config->item('asset_yes_no'));
            $data['house_owner'] = $this->modelName->getLookUpList($this->config->item('house_owner'));
            $data['land_owner'] = $this->modelName->getLookUpList($this->config->item('land_owner'));
            
            $data['addPerm']  =  $this->getPermission($baseID, $this->role, 'add');
            $data['editPerm'] =  $this->getPermission($baseID, $this->role, 'edit');
    
            $this->load->view('includes/header', $this->global);
             $this->load->view('includes/wizard', $data);
            $this->load->view($this->controller.'/assets_details_edit', $data);
            $this->load->view('includes/footer');
        
    }


    function editAssetDetails()
    {
          
          //  print_r($this->input->post()); die();


            $household_master_id = $this->input->post('household_master_id_sub',true);
            $round_master_id = $this->input->post('round_master_id',true);
            $assetID = $this->input->post('assetID',true);

            $this->load->library('form_validation');
            $this->form_validation->set_rules('fk_owner_land','Land Owner','trim|required|numeric');
            $this->form_validation->set_rules('fk_owner_house','House Owner','trim|required|numeric');
            $this->form_validation->set_rules('fk_chair','Chair','trim|required|numeric');
            $this->form_validation->set_rules('fk_dining_table','Dining Table','trim|required|numeric');
            $this->form_validation->set_rules('fk_khat','Khat','trim|required|numeric');
            $this->form_validation->set_rules('fk_chowki','Chowki','trim|required|numeric');
            $this->form_validation->set_rules('fk_almirah','Almirah','trim|required|numeric');
            $this->form_validation->set_rules('fk_sofa','Sofa','trim|required|numeric');
            $this->form_validation->set_rules('fk_radio','Radio','trim|required|numeric');

            $this->form_validation->set_rules('fk_tv','TV','trim|required|numeric');
            $this->form_validation->set_rules('fk_freeze','Fridge','trim|required|numeric');

            $this->form_validation->set_rules('fk_mobile','Entry Date','trim|required|numeric');
            $this->form_validation->set_rules('fk_electric_fan','Electric_Fan','trim|required|numeric');
            $this->form_validation->set_rules('fk_hand_watch','Hand Watch','trim|required|numeric');
            $this->form_validation->set_rules('fk_rickshow','Rikshaw','trim|required|numeric');
            $this->form_validation->set_rules('fk_computer','Computer','trim|required|numeric');
            $this->form_validation->set_rules('fk_sewing_machine','Sewing machine','trim|required|numeric');
            $this->form_validation->set_rules('fk_cycle','By Cycle','trim|required|numeric');
            $this->form_validation->set_rules('fk_motor_cycle','Motor Cycle','trim|required|numeric');
           
              
            $baseID = $this->input->get('baseID', TRUE);
           
           if($this->form_validation->run() == FALSE)
            {
                redirect('householdassets/editAsset/'. $assetID.'?household_master_id='.$household_master_id.'&&baseID='.$baseID.'#asset');

            }
            else
            {

               if ($this->getCurrentRound()[0]->active == 0)
               {

                  $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                  redirect('householdvisit/visit?baseID='.$baseID);
               }

                
                $fk_owner_land = $this->input->post('fk_owner_land',true);
                $fk_owner_house = $this->input->post('fk_owner_house',true);
                $fk_chair = $this->input->post('fk_chair',true);
                $fk_dining_table = $this->input->post('fk_dining_table',true);
                $fk_khat = $this->input->post('fk_khat',true);
                $fk_chowki = $this->input->post('fk_chowki',true);
                $fk_almirah = $this->input->post('fk_almirah',true);
                $fk_sofa = $this->input->post('fk_sofa',true);
                $fk_radio = $this->input->post('fk_radio',true);
                $fk_tv = $this->input->post('fk_tv',true);
                $fk_freeze = $this->input->post('fk_freeze',true);
                $fk_mobile = $this->input->post('fk_mobile',true);
                $fk_electric_fan = $this->input->post('fk_electric_fan',true);
                $fk_hand_watch = $this->input->post('fk_hand_watch',true);
                $fk_rickshow = $this->input->post('fk_rickshow',true);
                $fk_computer = $this->input->post('fk_computer',true);
                $fk_sewing_machine = $this->input->post('fk_sewing_machine',true);
                $fk_cycle = $this->input->post('fk_cycle',true);
                $fk_motor_cycle = $this->input->post('fk_motor_cycle',true);

                $this->db->trans_start();

                try
                { 

                    $IdInfo = array(
                        'fk_owner_land'=>$fk_owner_land, 
                        'fk_owner_house'=>$fk_owner_house, 
                        'fk_chair'=>$fk_chair, 
                        'fk_dining_table'=>$fk_dining_table, 
                        'fk_khat'=>$fk_khat, 
                        'fk_chowki'=>$fk_chowki, 
                        'fk_almirah'=>$fk_almirah, 
                        'fk_radio'=>$fk_radio, 
                        'fk_sofa'=>$fk_sofa, 
                        'fk_tv'=>$fk_tv, 
                        'fk_freeze'=>$fk_freeze, 
                        'fk_mobile'=>$fk_mobile, 
                        'fk_electric_fan'=>$fk_electric_fan, 
                        'fk_hand_watch'=>$fk_hand_watch, 
                        'fk_rickshow'=>$fk_rickshow, 
                        'fk_computer'=>$fk_computer, 
                        'fk_sewing_machine'=>$fk_sewing_machine, 
                        'fk_cycle'=>$fk_cycle, 
                        'fk_motor_cycle'=>$fk_motor_cycle, 
                        'updateBy'=>$this->vendorId, 
                        'updatedOn'=>date('Y-m-d H:i:s')
                    );
                        
                    $resultID = $this->assetModel->edit($IdInfo,$assetID, $this->config->item('householdAssetTable'));
                    
                }
                catch(Exception $e)
                {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('error', 'Error occurred while updating household Asset.');
                }

                $this->db->trans_commit();
                $this->session->set_flashdata('success','Household Asset updated successfully.');
                
                redirect('householdvisit/assets?baseID='.$baseID.'#asset');
            }
        
    }

  
    
    
}

?>