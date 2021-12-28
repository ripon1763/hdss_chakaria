<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Householdvisit extends BaseController
{
    /**
     * This is default constructor of the class
     */
	 
	public $controller = "householdvisit";
	public $pageTitle = 'Household Visit';
	public $pageShortName = 'Household Visit';
	
	 
    public function __construct()
    {
        parent::__construct();
		$this->load->model('master_model','modelName');
        $this->load->model('member_model','memberModel');
        $this->load->model('householdVisit_model','visitModel');
        $this->load->model('Householdasset_model','assetModel');
        $this->load->model('memberEducation_model','educationModel');
        $this->load->model('memberOccupation_model','occupationModel');
        $this->load->model('memberRelation_model','relationModel');
        $this->load->model('memberDeath_model','deathModel');
        $this->load->model('memberConception_model','conceptionModel');
        $this->load->model('memberPregnancy_model','pregnancyModel');
        $this->load->model('memberMarriage_model','marriageModel');
        $this->load->model('memberMigration_model','migrationModel');
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
    
    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
            $baseID = $this->input->get('baseID', TRUE);
		    $this->global['menu'] =  $this->menuModel->getMenu($this->role);
	        
			$this->global['pageTitle'] = $this->config->item('prefix'). ' : ' .$this->pageTitle;
	        $data['pageTitle'] = $this->pageTitle;
			$data['controller'] = $this->controller;
			$data['addMethod'] = 'addNew';
			$data['editMethod'] = 'editOld';
			$data['shortName'] = $this->pageShortName;
			$data['boxTitle'] = 'List';

            // $this->$rountStatus = $this->getCurrentRound()[0]->active;
            //$this->$roundID =  $this->getCurrentRound()[0]->id;

               if ($this->getCurrentRound()[0]->active == 0)
               {

                  $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                  redirect($this->controller.'?baseID='.$baseID);
               }


            if( $this->input->post('search'))
            {

                   $householdcode = $this->input->post('householdcode', true);


                   if (strlen($householdcode) != 8)
                   {
                     redirect('householdvisit/visit?baseID='.$baseID);
                   }



                   $household_master_id_sub =0;
                   $data['household_master_id_sub'] = 0;

                  
                   $this->session->set_userdata('householdcode', $householdcode);
                   $household_master_id_sub = $this->input->post('householdid', true);
                   $this->session->set_userdata('household_master_id_sub', $household_master_id_sub);

                    $data['household_master_id_sub'] = $this->session->userdata('household_master_id_sub');

                    if ($data['household_master_id_sub'] > 0)
                    {
                         //  redirect('householdvisit/split?baseID='.$baseID.'#split');
                           redirect('householdvisit/member_info?baseID='.$baseID.'#memberinfo');

                    }

                
            }
            else
            {
                redirect('householdvisit/visit?baseID='.$baseID);
            }

            
			$data['addPerm']  =  $this->getPermission($baseID, $this->role, 'add');
			$data['editPerm'] =  $this->getPermission($baseID, $this->role, 'edit');
	
		    $this->load->view('includes/header', $this->global);
            $this->load->view('includes/wizard');
			$this->load->view($this->controller.'/householdvisit', $data);
			$this->load->view('includes/footer');
		
    }

    public function visit()
    {
            $baseID = $this->input->get('baseID', TRUE);
            $this->global['menu'] =  $this->menuModel->getMenu($this->role);
            
            $this->global['pageTitle'] = $this->config->item('prefix'). ' : ' .$this->pageTitle;
            $data['pageTitle'] = $this->pageTitle;
            $data['controller'] = $this->controller;
            $data['addMethod'] = 'addNew';
            $data['editMethod'] = 'editOld';
            $data['shortName'] = $this->pageShortName;
            $data['boxTitle'] = 'List';

            // $this->$rountStatus = $this->getCurrentRound()[0]->active;
            // $this->$roundID =  $this->getCurrentRound()[0]->id;

   
            
            $data['addPerm']  =  $this->getPermission($baseID, $this->role, 'add');
            $data['editPerm'] =  $this->getPermission($baseID, $this->role, 'edit');
    
            $this->load->view('includes/header', $this->global);
            $this->load->view('includes/script');
            $this->load->view($this->controller.'/index', $data);
            $this->load->view('includes/footer');
        
    }

    public function member_info()
    {
            $baseID = $this->input->get('baseID', TRUE);
            $this->global['menu'] =  $this->menuModel->getMenu($this->role);
            
            $this->global['pageTitle'] = $this->config->item('prefix'). ' : Household Split';
            $data['pageTitle'] = $this->pageTitle;
            $data['controller'] = $this->controller;
            $data['addMethod'] = 'addNew';
            $data['editMethod'] = 'editOld';
            $data['shortName'] = $this->pageShortName;
            $data['boxTitle'] = 'List';

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


            if( $this->input->post('submit'))
            {

                $household_master_id = $this->input->post('household_master_id_sub', true);
                $round_master_id = $this->input->post('round_master_id', true);
                $householdVisitID = $this->input->post('householdVisitID', true);
              
                $event = $this->input->post('event', true);


                if( ($this->input->post('submit') == 'Next'))
                 {
                   
                
                        if ($householdVisitID > 0)
                        {

                            $this->db->trans_start();

                            try
                            {

                                $visitData = array(
                                    'memberCheck' => 1,
                                    'transfer_complete' => 'No',
                                    'updateBy' => $this->vendorId,
                                    'updatedOn' => date('Y-m-d H:i:s')
                                );

                                $this->visitModel->edit($visitData,$householdVisitID,$this->config->item('householdVisitTable'));

                            }
                            catch(Exception $e)
                            {
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('error', 'Error occurred while save.');
                            }

                            $this->db->trans_commit(); 

                        }
                        else
                        {

                            $this->db->trans_start();

                            try
                            {

                                $visitData = array(
                                'household_master_id' => $household_master_id,
                                'round_master_id' => $round_master_id,
                                'memberCheck' => 1,
                                'transfer_complete' => 'No',
                                'insertedBy' => $this->vendorId,
                                'insertedOn' => date('Y-m-d H:i:s')
                            );

                                $insert = $this->visitModel->addNew($visitData,$this->config->item('householdVisitTable'));

                            }
                            catch(Exception $e)
                            {
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('error', 'Error occurred while save.');
                            }

                            $this->db->trans_commit();


                        }

                    
                    redirect('householdvisit/assets?baseID='.$baseID.'#asset');


                 }      

                
            }
           

          
            $data['householdVisit'] = $this->visitModel->getHouseholdVisitDet($this->config->item('householdVisitTable'),$data['household_master_id_sub'],$data['round_master_id']);

            $data['presentMemberList'] = $this->memberModel->getMemberMasterPresentListByHouseholdIds($data['household_master_id_sub']);

            $data['prevMemberRecords']  = $this->memberModel->getMemberMasterPreviousListByHouseholdIds($data['household_master_id_sub'],$data['round_master_id']);

            
            $data['addPerm']  =  $this->getPermission($baseID, $this->role, 'add');
            $data['editPerm'] =  $this->getPermission($baseID, $this->role, 'edit');
    
            $this->load->view('includes/header', $this->global);
            $this->load->view('includes/wizard', $data);
            $this->load->view($this->controller.'/member_info', $data);
            $this->load->view('includes/footer');
        
    }

  /*  public function split()
    {
            $baseID = $this->input->get('baseID', TRUE);
            $this->global['menu'] =  $this->menuModel->getMenu($this->role);
            
            $this->global['pageTitle'] = $this->config->item('prefix'). ' : Household Split';
            $data['pageTitle'] = $this->pageTitle;
            $data['controller'] = $this->controller;
            $data['addMethod'] = 'addNew';
            $data['editMethod'] = 'editOld';
            $data['shortName'] = $this->pageShortName;
            $data['boxTitle'] = 'List';

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


            if( $this->input->post('submit'))
            {

                $household_master_id = $this->input->post('household_master_id_sub', true);
                $round_master_id = $this->input->post('round_master_id', true);
                $householdVisitID = $this->input->post('householdVisitID', true);
                $number_of_household = $this->input->post('number_of_household', true);
                $splitType = $this->input->post('splitType', true);
                $split_date = $this->input->post('split_date', true);
                $split = $this->input->post('split', true);
                $event = $this->input->post('event', true);

                $new_split_date = null;

                if (!empty($split_date)) {

                        $parts1 = explode('/', $split_date);
                        $new_split_date = $parts1[2] . '-' . $parts1[1] . '-' . $parts1[0];
                }


                if($this->input->post('submit') == 'Save')
                 {

                            
                     if ($householdVisitID > 0)
                        {

                            $this->db->trans_start();

                            try
                            {

                                 $visitData = array(
                                    'is_household_split' => 1,
                                    'no_of_new_household' => $number_of_household,
                                    'split_date' => $new_split_date,
                                    'updateBy' => $this->vendorId,
                                    'updatedOn' => date('Y-m-d H:i:s')
                                );

                                $this->visitModel->edit($visitData,$householdVisitID,$this->config->item('householdVisitTable'));

                            }
                            catch(Exception $e)
                            {
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('error', 'Error occurred while save.');
                            }

                            $this->db->trans_commit();
                        }
                        else
                        {

                            $this->db->trans_start();

                            try
                            {

                                $visitData = array(
                                'household_master_id' => $household_master_id,
                                'round_master_id' => $round_master_id,
                                'is_household_split' => 1,
                                'no_of_new_household' => $number_of_household,
                                'split_date' => $new_split_date,
                                'transfer_complete' => 'No',
                                'insertedBy' => $this->vendorId,
                                'insertedOn' => date('Y-m-d H:i:s')
                            );

                                $this->visitModel->addNew($visitData,$this->config->item('householdVisitTable'));

                            }
                            catch(Exception $e)
                            {
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('error', 'Error occurred while save.');
                            }

                            $this->db->trans_commit();

                        }


                       // redirect('householdvisit/splitdetails?household_master_id='.$household_master_id.'&&number_of_household='.$number_of_household.'&&baseID='.$baseID.'#split');



                 }
                

                if( ($this->input->post('submit') == 'Save & Next'))
                 {
                   
                
                        if ($householdVisitID > 0)
                        {

                            $this->db->trans_start();

                            try
                            {

                                $visitData = array(
                                    'is_household_split' => 2,
                                    'transfer_complete' => 'No',
                                    'no_of_new_household' => 0,
                                    'split_date' => null,
                                    'updateBy' => $this->vendorId,
                                    'updatedOn' => date('Y-m-d H:i:s')
                                );

                                $this->visitModel->edit($visitData,$householdVisitID,$this->config->item('householdVisitTable'));

                            }
                            catch(Exception $e)
                            {
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('error', 'Error occurred while save.');
                            }

                            $this->db->trans_commit(); 

                        }
                        else
                        {

                            $this->db->trans_start();

                            try
                            {

                                $visitData = array(
                                'household_master_id' => $household_master_id,
                                'round_master_id' => $round_master_id,
                                'is_household_split' => 2,
                                'no_of_new_household' => 0,
                                'split_date' => null,
                                'transfer_complete' => 'No',
                                'insertedBy' => $this->vendorId,
                                'insertedOn' => date('Y-m-d H:i:s')
                            );

                                $insert = $this->visitModel->addNew($visitData,$this->config->item('householdVisitTable'));

                            }
                            catch(Exception $e)
                            {
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('error', 'Error occurred while save.');
                            }

                            $this->db->trans_commit();


                        }

                    
                    redirect('householdvisit/merge?baseID='.$baseID.'#merge');
                    

                    //visitModel, householdVisitTable

                 }

                 if( $this->input->post('submit') == 'Next')
                 {
                       $whereHouseholdAsset = array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id);
                       $countRow = $this->db->select('count(id) as countRow')->from($this->config->item('householdAssetTable'))->where($whereHouseholdAsset)->get()->row()->countRow;

                       if ($countRow == 0)
                       {
                         

                            $this->db->trans_start();

                            try
                            {

                                $visitData = array(
                                    'is_household_split' => 2,
                                    'transfer_complete' => 'No',
                                    'updateBy' => $this->vendorId,
                                    'updatedOn' => date('Y-m-d H:i:s')
                                );

                                $this->visitModel->edit($visitData,$householdVisitID,$this->config->item('householdVisitTable'));

                            }
                            catch(Exception $e)
                            {
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('error', 'Error occurred while save.');
                            }

                            $this->db->trans_commit(); 



                       }
                       redirect('householdvisit/merge?baseID='.$baseID.'#merge');

                 }
                   

                
            }
           

          
            $data['householdVisit'] = $this->visitModel->getHouseholdVisitDet($this->config->item('householdVisitTable'),$data['household_master_id_sub'],$data['round_master_id']);
            
            $data['addPerm']  =  $this->getPermission($baseID, $this->role, 'add');
            $data['editPerm'] =  $this->getPermission($baseID, $this->role, 'edit');
    
            $this->load->view('includes/header', $this->global);
            $this->load->view('includes/wizard', $data);
            $this->load->view($this->controller.'/split', $data);
            $this->load->view('includes/footer');
        
    }


    public function merge()
    {
            $baseID = $this->input->get('baseID', TRUE);
            $this->global['menu'] =  $this->menuModel->getMenu($this->role);
            
            $this->global['pageTitle'] = $this->config->item('prefix'). ' : Household Merge';
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

            if( $this->input->post('submit'))
            {
                $household_master_id = $this->input->post('household_master_id_sub', true);
                $round_master_id = $this->input->post('round_master_id', true);
                $householdVisitID = $this->input->post('householdVisitID', true);
                $mergeType = $this->input->post('mergeType', true);
                $event = $this->input->post('event', true);

                if( ($this->input->post('submit') == 'Save & Next'))
                 {


                    if ($householdVisitID > 0)
                    {

                        $this->db->trans_start();

                        try
                        {

                            $visitData = array(
                            'is_household_merge' => 2,
                            'transfer_complete' => 'No',
                            'updateBy' => $this->vendorId,
                            'updatedOn' => date('Y-m-d H:i:s')
                        );

                            $this->visitModel->edit($visitData,$householdVisitID,$this->config->item('householdVisitTable'));

                        }
                        catch(Exception $e)
                        {
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('error', 'Error occurred while save.');
                        }

                        $this->db->trans_commit();

                        
                    }

                    redirect('householdvisit/assets?baseID='.$baseID.'#asset');
                    
                

                 }

                 if( $this->input->post('submit') == 'Next')
                 {

                    if ($householdVisitID > 0)
                        {

                            $this->db->trans_start();

                            try
                            {

                                $visitData = array(
                                'is_household_merge' => 2,
                                'transfer_complete' => 'No',
                                'updateBy' => $this->vendorId,
                                'updatedOn' => date('Y-m-d H:i:s')
                            );
                             
                             

                                $this->visitModel->edit($visitData,$householdVisitID,$this->config->item('householdVisitTable'));

                            }
                            catch(Exception $e)
                            {
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('error', 'Error occurred while save.');
                            }

                            $this->db->trans_commit();



                        }
                   
                    redirect('householdvisit/assets?baseID='.$baseID.'#asset');

                 }
                   

                
            }
            
            $data['householdVisit'] = $this->visitModel->getHouseholdVisitDet($this->config->item('householdVisitTable'),$data['household_master_id_sub'],$data['round_master_id']);
            
            $data['addPerm']  =  $this->getPermission($baseID, $this->role, 'add');
            $data['editPerm'] =  $this->getPermission($baseID, $this->role, 'edit');
    
            $this->load->view('includes/header', $this->global);
            $this->load->view('includes/wizard', $data);
            $this->load->view($this->controller.'/marge', $data);
            $this->load->view('includes/footer');
        
    }*/

    public function assets()
    {
            $baseID = $this->input->get('baseID', TRUE);
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

            if( $this->input->post('submit'))
            {
                $household_master_id = $this->input->post('household_master_id_sub', true);
                $round_master_id = $this->input->post('round_master_id', true);
                $householdVisitID = $this->input->post('householdVisitID', true);
                $assetType = $this->input->post('assetType', true);
                $event = $this->input->post('event', true);

                 if( ($this->input->post('submit') == 'Save & Next'))
                 {

                       $whereHouseholdAsset = array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id);

                       $countRow = $this->db->select('count(id) as countRow')->from($this->config->item('householdAssetTable'))->where($whereHouseholdAsset)->get()->row()->countRow;

                       if ($countRow > 0)
                       {
                          $this->session->set_flashdata('error', 'Asset alreay exists for this round so you cannot marks as no.');
                          redirect('householdvisit/assets?baseID='.$baseID.'#asset');
                       }
                    

                        if ($householdVisitID > 0)
                        {

                            $this->db->trans_start();

                            try
                            {

                                $visitData = array(
                                    'any_asset' => 2,
                                    'transfer_complete' => 'No',
                                    'updateBy' => $this->vendorId,
                                    'updatedOn' => date('Y-m-d H:i:s')
                                );

                                $this->visitModel->edit($visitData,$householdVisitID,$this->config->item('householdVisitTable'));

                            }
                            catch(Exception $e)
                            {
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('error', 'Error occurred while save.');
                            }

                            $this->db->trans_commit();        
                            redirect('householdvisit/marriage_start?baseID='.$baseID.'#mstart'); 
                            
                        }
                        
                 }

                 if( $this->input->post('submit') == 'Next')
                 {


                       $whereHouseholdAsset = array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id);

                       $countRow = $this->db->select('count(id) as countRow')->from($this->config->item('householdAssetTable'))->where($whereHouseholdAsset)->get()->row()->countRow;

                       if ($countRow == 0)
                       {
                         

                            $this->db->trans_start();

                            try
                            {

                                $visitData = array(
                                    'any_asset' => 2,
                                    'transfer_complete' => 'No',
                                    'updateBy' => $this->vendorId,
                                    'updatedOn' => date('Y-m-d H:i:s')
                                );

                                $this->visitModel->edit($visitData,$householdVisitID,$this->config->item('householdVisitTable'));

                            }
                            catch(Exception $e)
                            {
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('error', 'Error occurred while save.');
                            }

                            $this->db->trans_commit(); 



                       }
                   
                       redirect('householdvisit/marriage_start?baseID='.$baseID.'#mstart'); 
 
                 }
                
            }
            
            $data['householdVisit'] = $this->visitModel->getHouseholdVisitDet($this->config->item('householdVisitTable'),$data['household_master_id_sub'],$data['round_master_id']);
            $data['assetHistory'] = $this->assetModel->getHouseholdAssetHistory($this->config->item('householdAssetTable'),$data['household_master_id_sub']);
            
        

            $data['addPerm']  =  $this->getPermission($baseID, $this->role, 'add');
            $data['editPerm'] =  $this->getPermission($baseID, $this->role, 'edit');
    
            $this->load->view('includes/header', $this->global);
            $this->load->view('includes/wizard', $data);
            $this->load->view($this->controller.'/assets', $data);
            $this->load->view('includes/footer');
        
    }


    public function migin()
    {
            $baseID = $this->input->get('baseID', TRUE);
            $this->global['menu'] =  $this->menuModel->getMenu($this->role);
            
            $this->global['pageTitle'] = $this->config->item('prefix'). ' : Migration in' ;
            $data['pageTitle'] = $this->pageTitle;
            $data['controller'] = $this->controller;
            $data['addMethod'] = 'addNew';
            $data['editMethod'] = 'editOld';
            $data['shortName'] = $this->pageShortName;
            $data['boxTitle'] = 'List';

            // $this->$rountStatus = $this->getCurrentRound()[0]->active;
            // $this->$roundID =  $this->getCurrentRound()[0]->id;

            $data['roundNo'] =  $this->getCurrentRound()[0]->roundNo;
            $data['round_master_id'] =  $this->getCurrentRound()[0]->id;
            $data['householdcode'] =  $this->session->userdata('householdcode');

            $data['household_master_id_sub'] = 0;
            $data['household_master_id_sub'] = $this->session->userdata('household_master_id_sub');

            if ($data['household_master_id_sub'] == 0)
            {
                redirect('householdvisit/visit?baseID='.$baseID);
            }

            if( $this->input->post('submit'))
            {
                $household_master_id = $this->input->post('household_master_id_sub', true);
                $round_master_id = $this->input->post('round_master_id', true);
                $householdVisitID = $this->input->post('householdVisitID', true);
                $miginType = $this->input->post('miginType', true);
                $event = $this->input->post('event', true);

                 if( ($this->input->post('submit') == 'Save & Next'))
                 {

                      

                       $whereHouseholdMig = array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id);

                       $countRow = $this->db->select('count(id) as countRow')->from($this->config->item('migrationInTable'))->where($whereHouseholdMig)->get()->row()->countRow;

                       if ($countRow > 0)
                       {
                          $this->session->set_flashdata('error', 'Movement/Migration in alreay exists for this round so you cannot marks as no.');
                          redirect('householdvisit/migin?baseID='.$baseID.'#migin');
                       }
                    
                    

                        if ($householdVisitID > 0)
                        {

                            $this->db->trans_start();

                            try
                            {

                                $visitData = array(
                                    'any_migration_in' => 2,
                                    'transfer_complete' => 'No',
                                    'updateBy' => $this->vendorId,
                                    'updatedOn' => date('Y-m-d H:i:s')
                                );

                                $this->visitModel->edit($visitData,$householdVisitID,$this->config->item('householdVisitTable'));

                            }
                            catch(Exception $e)
                            {
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('error', 'Error occurred while save.');
                            }

                            $this->db->trans_commit();        
                             redirect('householdvisit/marriage_end?baseID='.$baseID.'#mend');
                            
                        }
                        
                 }

                 if( $this->input->post('submit') == 'Next')
                 {

                       // need work here

                       $whereHouseholdAsset = array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id);

                       $countRow = $this->db->select('count(id) as countRow')->from($this->config->item('migrationInTable'))->where($whereHouseholdAsset)->get()->row()->countRow;

                       if ($countRow == 0)
                       {
                         

                            $this->db->trans_start();

                            try
                            {

                                $visitData = array(
                                    'any_migration_in' => 2,
                                    'transfer_complete' => 'No',
                                    'updateBy' => $this->vendorId,
                                    'updatedOn' => date('Y-m-d H:i:s')
                                );

                                $this->visitModel->edit($visitData,$householdVisitID,$this->config->item('householdVisitTable'));

                            }
                            catch(Exception $e)
                            {
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('error', 'Error occurred while save.');
                            }

                            $this->db->trans_commit(); 



                       }
                   
                       redirect('householdvisit/marriage_end?baseID='.$baseID.'#mend');
 
                 }
                
            }

            
            $data['householdVisit'] = $this->visitModel->getHouseholdVisitDet($this->config->item('householdVisitTable'),$data['household_master_id_sub'],$data['round_master_id']);

            $data['presentMemberList'] = $this->memberModel->getMemberMasterPresentListByHouseholdIds($data['household_master_id_sub']);

             // migration
             $data['minRecords']  = $this->migrationModel->getRoundwiseMigrationIn($data['household_master_id_sub'],$data['round_master_id']);
             
            

            $data['prevMemberRecords']  = $this->memberModel->getMemberMasterPreviousListByHouseholdIds($data['household_master_id_sub'],$data['round_master_id']);
            
            $data['addPerm']  =  $this->getPermission($baseID, $this->role, 'add');
            $data['editPerm'] =  $this->getPermission($baseID, $this->role, 'edit');
    
            $this->load->view('includes/header', $this->global);
            $this->load->view('includes/wizard', $data);
            $this->load->view($this->controller.'/migration_in', $data);
            $this->load->view('includes/footer');
        
    }

    public function migout()
    {
            $baseID = $this->input->get('baseID', TRUE);
            $this->global['menu'] =  $this->menuModel->getMenu($this->role);
            
            $this->global['pageTitle'] = $this->config->item('prefix'). ' : Migration out' ;
            $data['pageTitle'] = $this->pageTitle;
            $data['controller'] = $this->controller;
            $data['addMethod'] = 'addNew';
            $data['editMethod'] = 'editOld';
            $data['shortName'] = $this->pageShortName;
            $data['boxTitle'] = 'List';

            // $this->$rountStatus = $this->getCurrentRound()[0]->active;
            // $this->$roundID =  $this->getCurrentRound()[0]->id;

            $data['roundNo'] =  $this->getCurrentRound()[0]->roundNo;
            $data['round_master_id'] =  $this->getCurrentRound()[0]->id;
            $data['householdcode'] =  $this->session->userdata('householdcode');

            $data['household_master_id_sub'] = 0;
            $data['household_master_id_sub'] = $this->session->userdata('household_master_id_sub');

            if ($data['household_master_id_sub'] == 0)
            {
                redirect('householdvisit/visit?baseID='.$baseID);
            }

            if( $this->input->post('submit'))
            {
                $household_master_id = $this->input->post('household_master_id_sub', true);
                $round_master_id = $this->input->post('round_master_id', true);
                $householdVisitID = $this->input->post('householdVisitID', true);
                $migoutType = $this->input->post('migoutType', true);
                $event = $this->input->post('event', true);

                 if( ($this->input->post('submit') == 'Save & Next'))
                 {

                       // need change

                       $whereHouseholdMig = array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id);

                       $countRow = $this->db->select('count(id) as countRow')->from($this->config->item('migrationOutTable'))->where($whereHouseholdMig)->get()->row()->countRow;

                       if ($countRow > 0)
                       {
                          $this->session->set_flashdata('error', 'Movement/Migration out alreay exists for this round so you cannot marks as no.');
                          redirect('householdvisit/migout?baseID='.$baseID.'#migout');
                       }
                    

                        if ($householdVisitID > 0)
                        {

                            $this->db->trans_start();

                            try
                            {

                                $visitData = array(
                                    'any_migration_out' => 2,
                                    'transfer_complete' => 'No',
                                    'updateBy' => $this->vendorId,
                                    'updatedOn' => date('Y-m-d H:i:s')
                                );

                                $this->visitModel->edit($visitData,$householdVisitID,$this->config->item('householdVisitTable'));

                            }
                            catch(Exception $e)
                            {
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('error', 'Error occurred while save.');
                            }

                            $this->db->trans_commit();        
                            redirect('householdvisit/conception?baseID='.$baseID.'#consp');
                            
                        }
                        
                 }

                 if( $this->input->post('submit') == 'Next')
                 {

                       // need work here

                       $whereHouseholdMig = array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id);

                       $countRow = $this->db->select('count(id) as countRow')->from($this->config->item('migrationOutTable'))->where($whereHouseholdMig)->get()->row()->countRow;

                       if ($countRow == 0)
                       {
                         

                            $this->db->trans_start();

                            try
                            {

                                $visitData = array(
                                    'any_migration_out' => 2,
                                    'transfer_complete' => 'No',
                                    'updateBy' => $this->vendorId,
                                    'updatedOn' => date('Y-m-d H:i:s')
                                );

                                $this->visitModel->edit($visitData,$householdVisitID,$this->config->item('householdVisitTable'));

                            }
                            catch(Exception $e)
                            {
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('error', 'Error occurred while save.');
                            }

                            $this->db->trans_commit(); 



                       }
                   
                       redirect('householdvisit/conception?baseID='.$baseID.'#consp');
 
                 }
                
            }

            

            $data['householdVisit'] = $this->visitModel->getHouseholdVisitDet($this->config->item('householdVisitTable'),$data['household_master_id_sub'],$data['round_master_id']);

            $data['presentMemberList'] = $this->memberModel->getMemberMasterPresentListByHouseholdIds($data['household_master_id_sub']);

            $data['moutRecords']  = $this->migrationModel->getRoundwiseMigrationOut($data['household_master_id_sub'],$data['round_master_id']);

             $data['prevMemberRecords']  = $this->memberModel->getMemberMasterPreviousListByHouseholdIds($data['household_master_id_sub'],$data['round_master_id']);


           
            $data['addPerm']  =  $this->getPermission($baseID, $this->role, 'add');
            $data['editPerm'] =  $this->getPermission($baseID, $this->role, 'edit');
    
            $this->load->view('includes/header', $this->global);
            $this->load->view('includes/wizard', $data);
            $this->load->view($this->controller.'/migration_out', $data);
            $this->load->view('includes/footer');
        
    }

    public function marriage_start()
    {
            $baseID = $this->input->get('baseID', TRUE);
            $this->global['menu'] =  $this->menuModel->getMenu($this->role);
            
            $this->global['pageTitle'] = $this->config->item('prefix'). ' : Marriage Start' ;
            $data['pageTitle'] = $this->pageTitle;
            $data['controller'] = $this->controller;
            $data['addMethod'] = 'addNew';
            $data['editMethod'] = 'editOld';
            $data['shortName'] = $this->pageShortName;
            $data['boxTitle'] = 'List';

            // $this->$rountStatus = $this->getCurrentRound()[0]->active;
            // $this->$roundID =  $this->getCurrentRound()[0]->id;
            $data['roundNo'] =  $this->getCurrentRound()[0]->roundNo;
            $data['round_master_id'] =  $this->getCurrentRound()[0]->id;
            $data['householdcode'] =  $this->session->userdata('householdcode');

            $data['household_master_id_sub'] = 0;
            $data['household_master_id_sub'] = $this->session->userdata('household_master_id_sub');

            if ($data['household_master_id_sub'] == 0)
            {
                redirect('householdvisit/visit?baseID='.$baseID);
            }

            if( $this->input->post('submit'))
            {
                $household_master_id = $this->input->post('household_master_id_sub', true);
                $round_master_id = $this->input->post('round_master_id', true);
                $householdVisitID = $this->input->post('householdVisitID', true);
                $mstartType = $this->input->post('mstartType', true);
                $event = $this->input->post('event', true);

                 if( ($this->input->post('submit') == 'Save & Next'))
                 {

                       // check status

                       $whereHouseholdmStart = array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id);

                       $countRow = $this->db->select('count(id) as countRow')->from($this->config->item('marriageStartTable'))->where($whereHouseholdmStart)->get()->row()->countRow;

                       if ($countRow > 0)
                       {
                          $this->session->set_flashdata('error', 'Marriage is alreay exists for this round so you cannot marks as no.');
                          redirect('householdvisit/marriage_start?baseID='.$baseID.'#mstart');
                       }
                    

                        if ($householdVisitID > 0)
                        {

                            $this->db->trans_start();

                            try
                            {

                                $visitData = array(
                                    'any_marriage_start' => 2,
                                    'transfer_complete' => 'No',
                                    'updateBy' => $this->vendorId,
                                    'updatedOn' => date('Y-m-d H:i:s')
                                );

                                $this->visitModel->edit($visitData,$householdVisitID,$this->config->item('householdVisitTable'));

                            }
                            catch(Exception $e)
                            {
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('error', 'Error occurred while save.');
                            }

                            $this->db->trans_commit();        
                            redirect('householdvisit/migin?baseID='.$baseID.'#migin');
                            
                        }
                        
                 }

                 if( $this->input->post('submit') == 'Next')
                 {

                       // need work here

                       $whereHouseholdAsset = array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id);

                       $countRow = $this->db->select('count(id) as countRow')->from($this->config->item('marriageStartTable'))->where($whereHouseholdAsset)->get()->row()->countRow;

                       if ($countRow == 0)
                       {
                         

                            $this->db->trans_start();

                            try
                            {

                                $visitData = array(
                                    'any_marriage_start' => 2,
                                    'transfer_complete' => 'No',
                                    'updateBy' => $this->vendorId,
                                    'updatedOn' => date('Y-m-d H:i:s')
                                );

                                $this->visitModel->edit($visitData,$householdVisitID,$this->config->item('householdVisitTable'));

                            }
                            catch(Exception $e)
                            {
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('error', 'Error occurred while save.');
                            }

                            $this->db->trans_commit(); 



                       }
                   
                       redirect('householdvisit/migin?baseID='.$baseID.'#migin');
 
                 }
                
            }

            
            $data['householdVisit'] = $this->visitModel->getHouseholdVisitDet($this->config->item('householdVisitTable'),$data['household_master_id_sub'],$data['round_master_id']);

            $data['presentMemberList'] = $this->memberModel->getMemberMasterPresentListByHouseholdIdsnAge($data['household_master_id_sub']);

            $data['mstartRecords']  = $this->marriageModel->getRoundwiseMarriageStart($data['household_master_id_sub'],$data['round_master_id']);
           
            $data['prevMemberRecords']  = $this->memberModel->getMemberMasterPreviousListByHouseholdIds($data['household_master_id_sub'],$data['round_master_id']);



            
            $data['addPerm']  =  $this->getPermission($baseID, $this->role, 'add');
            $data['editPerm'] =  $this->getPermission($baseID, $this->role, 'edit');
    
            $this->load->view('includes/header', $this->global);
            $this->load->view('includes/wizard', $data);
            $this->load->view($this->controller.'/marriage_start', $data);
            $this->load->view('includes/footer');
        
    }


    public function marriage_end()
    {
            $baseID = $this->input->get('baseID', TRUE);
            $this->global['menu'] =  $this->menuModel->getMenu($this->role);
            
            $this->global['pageTitle'] = $this->config->item('prefix'). ' : Marriage End' ;
            $data['pageTitle'] = $this->pageTitle;
            $data['controller'] = $this->controller;
            $data['addMethod'] = 'addNew';
            $data['editMethod'] = 'editOld';
            $data['shortName'] = $this->pageShortName;
            $data['boxTitle'] = 'List';

            // $this->$rountStatus = $this->getCurrentRound()[0]->active;
            // $this->$roundID =  $this->getCurrentRound()[0]->id;

            $data['roundNo'] =  $this->getCurrentRound()[0]->roundNo;
            $data['round_master_id'] =  $this->getCurrentRound()[0]->id;
            $data['householdcode'] =  $this->session->userdata('householdcode');

            $data['household_master_id_sub'] = 0;
            $data['household_master_id_sub'] = $this->session->userdata('household_master_id_sub');

            if ($data['household_master_id_sub'] == 0)
            {
                redirect('householdvisit/visit?baseID='.$baseID);
            }

            if( $this->input->post('submit'))
            {
                $household_master_id = $this->input->post('household_master_id_sub', true);
                $round_master_id = $this->input->post('round_master_id', true);
                $householdVisitID = $this->input->post('householdVisitID', true);
                $mendType = $this->input->post('mendType', true);
                $event = $this->input->post('event', true);

                 if( ($this->input->post('submit') == 'Save & Next'))
                 {

                       // need change

                       $whereHouseholdEnd = array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id);

                       $countRow = $this->db->select('count(id) as countRow')->from($this->config->item('marriageEndTable'))->where($whereHouseholdEnd)->get()->row()->countRow;

                       if ($countRow > 0)
                       {
                          $this->session->set_flashdata('error', 'marriage end alreay exists for this round so you cannot marks as no.');
                          redirect('householdvisit/marriage_end?baseID='.$baseID.'#mend');
                       }
                    

                        if ($householdVisitID > 0)
                        {

                            $this->db->trans_start();

                            try
                            {

                                $visitData = array(
                                    'any_marriage_end' => 2,
                                    'transfer_complete' => 'No',
                                    'updateBy' => $this->vendorId,
                                    'updatedOn' => date('Y-m-d H:i:s')
                                );

                                $this->visitModel->edit($visitData,$householdVisitID,$this->config->item('householdVisitTable'));

                            }
                            catch(Exception $e)
                            {
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('error', 'Error occurred while save.');
                            }

                            $this->db->trans_commit();        
                          //  redirect('householdvisit/conception?baseID='.$baseID.'#consp');
                            redirect('householdvisit/migout?baseID='.$baseID.'#migout');
                            
                        }
                        
                 }

                 if( $this->input->post('submit') == 'Next')
                 {

                       // need work here

                       $whereHouseholdAsset = array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id);

                       $countRow = $this->db->select('count(id) as countRow')->from($this->config->item('marriageEndTable'))->where($whereHouseholdAsset)->get()->row()->countRow;

                       if ($countRow == 0)
                       {
                         

                            $this->db->trans_start();

                            try
                            {

                                $visitData = array(
                                    'any_marriage_end' => 2,
                                    'transfer_complete' => 'No',
                                    'updateBy' => $this->vendorId,
                                    'updatedOn' => date('Y-m-d H:i:s')
                                );

                                $this->visitModel->edit($visitData,$householdVisitID,$this->config->item('householdVisitTable'));

                            }
                            catch(Exception $e)
                            {
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('error', 'Error occurred while save.');
                            }

                            $this->db->trans_commit(); 



                       }
                   
                       redirect('householdvisit/migout?baseID='.$baseID.'#migout');
                 }
                
            }

            
            $data['householdVisit'] = $this->visitModel->getHouseholdVisitDet($this->config->item('householdVisitTable'),$data['household_master_id_sub'],$data['round_master_id']);

            $data['presentMemberList'] = $this->memberModel->getMemberMasterPresentMarriedListByHouseholdIds($data['household_master_id_sub'],$this->config->item('maritalStatusMarried'));

            $data['mstartRecords']  = $this->marriageModel->getRoundwiseMarriageEnd($data['household_master_id_sub'],$data['round_master_id']);


            $data['prevMemberRecords']  = $this->memberModel->getMemberMasterPreviousListByHouseholdIds($data['household_master_id_sub'],$data['round_master_id']);

            
            
            $data['addPerm']  =  $this->getPermission($baseID, $this->role, 'add');
            $data['editPerm'] =  $this->getPermission($baseID, $this->role, 'edit');
    
            $this->load->view('includes/header', $this->global);
            $this->load->view('includes/wizard', $data);
            $this->load->view($this->controller.'/marriage_end', $data);
            $this->load->view('includes/footer');
        
    }


    public function conception()
    {
            $baseID = $this->input->get('baseID', TRUE);
            $this->global['menu'] =  $this->menuModel->getMenu($this->role);
            
            $this->global['pageTitle'] = $this->config->item('prefix'). ' : Conception' ;
            $data['pageTitle'] = $this->pageTitle;
            $data['controller'] = $this->controller;
            $data['addMethod'] = 'addNew';
            $data['editMethod'] = 'editOld';
            $data['shortName'] = $this->pageShortName;
            $data['boxTitle'] = 'List';

            // $this->$rountStatus = $this->getCurrentRound()[0]->active;
            // $this->$roundID =  $this->getCurrentRound()[0]->id;

            $data['roundNo'] =  $this->getCurrentRound()[0]->roundNo;
            $data['round_master_id'] =  $this->getCurrentRound()[0]->id;
            $data['householdcode'] =  $this->session->userdata('householdcode');

            $data['household_master_id_sub'] = 0;
            $data['household_master_id_sub'] = $this->session->userdata('household_master_id_sub');

            if ($data['household_master_id_sub'] == 0)
            {
                redirect('householdvisit/visit?baseID='.$baseID);
            }

            if( $this->input->post('submit'))
            {
                $household_master_id = $this->input->post('household_master_id_sub', true);
                $round_master_id = $this->input->post('round_master_id', true);
                $householdVisitID = $this->input->post('householdVisitID', true);
                $conceptType = $this->input->post('conceptType', true);
                $event = $this->input->post('event', true);

                 if( ($this->input->post('submit') == 'Save & Next'))
                 {

                       // need change

                       $whereHouseholdConsep = array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id);

                       $countRow = $this->db->select('count(id) as countRow')->from($this->config->item('conceptionTable'))->where($whereHouseholdConsep)->get()->row()->countRow;

                       if ($countRow > 0)
                       {
                          $this->session->set_flashdata('error', 'Conception alreay exists for this round so you cannot marks as no.');
                          redirect('householdvisit/conception?baseID='.$baseID.'#consp');
                       }
                    

                        if ($householdVisitID > 0)
                        {

                            $this->db->trans_start();

                            try
                            {

                                $visitData = array(
                                    'any_concepton' => 2,
                                    'transfer_complete' => 'No',
                                    'updateBy' => $this->vendorId,
                                    'updatedOn' => date('Y-m-d H:i:s')
                                );

                                $this->visitModel->edit($visitData,$householdVisitID,$this->config->item('householdVisitTable'));

                            }
                            catch(Exception $e)
                            {
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('error', 'Error occurred while save.');
                            }

                            $this->db->trans_commit();        
                            redirect('householdvisit/pregnancy?baseID='.$baseID.'#pregnancy');
                            
                        }
                        
                 }

                 if( $this->input->post('submit') == 'Next')
                 {


                       $whereHouseholdAsset = array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id);

                       $countRow = $this->db->select('count(id) as countRow')->from($this->config->item('conceptionTable'))->where($whereHouseholdAsset)->get()->row()->countRow;

                       if ($countRow == 0)
                       {
                         

                            $this->db->trans_start();

                            try
                            {

                                $visitData = array(
                                    'any_concepton' => 2,
                                    'transfer_complete' => 'No',
                                    'updateBy' => $this->vendorId,
                                    'updatedOn' => date('Y-m-d H:i:s')
                                );

                                $this->visitModel->edit($visitData,$householdVisitID,$this->config->item('householdVisitTable'));

                            }
                            catch(Exception $e)
                            {
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('error', 'Error occurred while save.');
                            }

                            $this->db->trans_commit(); 



                       }
                   
                        redirect('householdvisit/pregnancy?baseID='.$baseID.'#pregnancy');
 
                 }
                
            }


            
            $data['householdVisit'] = $this->visitModel->getHouseholdVisitDet($this->config->item('householdVisitTable'),$data['household_master_id_sub'],$data['round_master_id']);

            $data['presentMemberList'] = $this->memberModel->getMemberMasterFemalePresentListByHouseholdIds($data['household_master_id_sub'],$this->config->item('femaleSexCode'));

             $data['conceptionRecords']  = $this->conceptionModel->getRoundwiseConception($data['household_master_id_sub'],$data['round_master_id']);
            
            $data['prevMemberRecords']  = $this->memberModel->getMemberMasterPreviousListByHouseholdIds($data['household_master_id_sub'],$data['round_master_id']);

            $data['addPerm']  =  $this->getPermission($baseID, $this->role, 'add');
            $data['editPerm'] =  $this->getPermission($baseID, $this->role, 'edit');
    
            $this->load->view('includes/header', $this->global);
            $this->load->view('includes/wizard', $data);
            $this->load->view($this->controller.'/conception', $data);
            $this->load->view('includes/footer');
        
    }

    public function pregnancy()
    {
            $baseID = $this->input->get('baseID', TRUE);
            $this->global['menu'] =  $this->menuModel->getMenu($this->role);
            
            $this->global['pageTitle'] = $this->config->item('prefix'). ' : Preganacy out' ;
            $data['pageTitle'] = $this->pageTitle;
            $data['controller'] = $this->controller;
            $data['addMethod'] = 'addNew';
            $data['editMethod'] = 'editOld';
            $data['shortName'] = $this->pageShortName;
            $data['boxTitle'] = 'List';

            // $this->$rountStatus = $this->getCurrentRound()[0]->active;
            // $this->$roundID =  $this->getCurrentRound()[0]->id;

            $data['roundNo'] =  $this->getCurrentRound()[0]->roundNo;
            $data['round_master_id'] =  $this->getCurrentRound()[0]->id;
            $data['householdcode'] =  $this->session->userdata('householdcode');

            $data['household_master_id_sub'] = 0;
            $data['household_master_id_sub'] = $this->session->userdata('household_master_id_sub');

            if ($data['household_master_id_sub'] == 0)
            {
                redirect('householdvisit/visit?baseID='.$baseID);
            }

            if( $this->input->post('submit'))
            {
                $household_master_id = $this->input->post('household_master_id_sub', true);
                $round_master_id = $this->input->post('round_master_id', true);
                $householdVisitID = $this->input->post('householdVisitID', true);
                $pregType = $this->input->post('pregType', true);
                $event = $this->input->post('event', true);

                 if( ($this->input->post('submit') == 'Save & Next'))
                 {

                       // need change

                       $whereHouseholdPreg = array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id);

                       $countRow = $this->db->select('count(id) as countRow')->from($this->config->item('pregnancyTable'))->where($whereHouseholdPreg)->get()->row()->countRow;

                       if ($countRow > 0)
                       {
                          $this->session->set_flashdata('error', 'Pregnancy alreay exists for this round so you cannot marks as no.');
                          redirect('householdvisit/pregnancy?baseID='.$baseID.'#pregnancy');
                       }
                    

                        if ($householdVisitID > 0)
                        {

                            $this->db->trans_start();

                            try
                            {

                                $visitData = array(
                                    'any_pregnancy' => 2,
                                    'transfer_complete' => 'No',
                                    'updateBy' => $this->vendorId,
                                    'updatedOn' => date('Y-m-d H:i:s')
                                );

                                $this->visitModel->edit($visitData,$householdVisitID,$this->config->item('householdVisitTable'));

                            }
                            catch(Exception $e)
                            {
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('error', 'Error occurred while save.');
                            }

                            $this->db->trans_commit();        
                            redirect('householdvisit/birth?baseID='.$baseID.'#birth');
                            
                        }
                        
                 }

                 if( $this->input->post('submit') == 'Next')
                 {

                       // need work here

                       $whereHouseholdPreg = array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id);

                       $countRow = $this->db->select('count(id) as countRow')->from($this->config->item('pregnancyTable'))->where($whereHouseholdPreg)->get()->row()->countRow;

                       if ($countRow == 0)
                       {
                         

                            $this->db->trans_start();

                            try
                            {

                                $visitData = array(
                                    'any_pregnancy' => 2,
                                    'transfer_complete' => 'No',
                                    'updateBy' => $this->vendorId,
                                    'updatedOn' => date('Y-m-d H:i:s')
                                );

                                $this->visitModel->edit($visitData,$householdVisitID,$this->config->item('householdVisitTable'));

                            }
                            catch(Exception $e)
                            {
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('error', 'Error occurred while save.');
                            }

                            $this->db->trans_commit(); 



                       }
                   
                        redirect('householdvisit/birth?baseID='.$baseID.'#birth');
 
                 }
                
            }

          
            
            $data['householdVisit'] = $this->visitModel->getHouseholdVisitDet($this->config->item('householdVisitTable'),$data['household_master_id_sub'],$data['round_master_id']);

            $data['currentPregList'] = $this->pregnancyModel->getRoundwisePregnancy($data['household_master_id_sub'],$data['round_master_id']);


             $data['presentMemberList']  = $this->memberModel->getMemberMasterFemaleConceptionListByHouseholdIds($data['household_master_id_sub'],$this->config->item('femaleSexCode'), $this->config->item('conceptionFollowpID'));

            $data['prevMemberRecords']  = $this->memberModel->getMemberMasterPreviousListByHouseholdIds($data['household_master_id_sub'],$data['round_master_id']);

            
            
            $data['addPerm']  =  $this->getPermission($baseID, $this->role, 'add');
            $data['editPerm'] =  $this->getPermission($baseID, $this->role, 'edit');
    
            $this->load->view('includes/header', $this->global);
            $this->load->view('includes/wizard', $data);
            $this->load->view($this->controller.'/pregnancy', $data);
            $this->load->view('includes/footer');
        
    }


    public function birth()
    {
            $baseID = $this->input->get('baseID', TRUE);
            $this->global['menu'] =  $this->menuModel->getMenu($this->role);
            
            $this->global['pageTitle'] = $this->config->item('prefix'). ' : Birth' ;
            $data['pageTitle'] = $this->pageTitle;
            $data['controller'] = $this->controller;
            $data['addMethod'] = 'addNew';
            $data['editMethod'] = 'editOld';
            $data['shortName'] = $this->pageShortName;
            $data['boxTitle'] = 'List';

            // $this->$rountStatus = $this->getCurrentRound()[0]->active;
            // $this->$roundID =  $this->getCurrentRound()[0]->id;

            $data['roundNo'] =  $this->getCurrentRound()[0]->roundNo;
            $data['round_master_id'] =  $this->getCurrentRound()[0]->id;
            $data['householdcode'] =  $this->session->userdata('householdcode');


            $data['household_master_id_sub'] = 0;
            $data['household_master_id_sub'] = $this->session->userdata('household_master_id_sub');

            if ($data['household_master_id_sub'] == 0)
            {
                redirect('householdvisit/visit?baseID='.$baseID);
            }

             if( $this->input->post('submit'))
            {
                $household_master_id = $this->input->post('household_master_id_sub', true);
                $round_master_id = $this->input->post('round_master_id', true);
                $householdVisitID = $this->input->post('householdVisitID', true);
                $birthType = $this->input->post('birthType', true);
                $event = $this->input->post('event', true);

                 if( ($this->input->post('submit') == 'Save & Next'))
                 {

                       // need change

                       $countRow = $this->memberModel->getMemberBirthListByHouseholdIdAndRoundId($data['household_master_id_sub'],$data['round_master_id']);

                       if (!empty($countRow))
                       {
                          $this->session->set_flashdata('error', 'Birth alreay exists for this round so you cannot marks as no.');
                          redirect('householdvisit/birth?baseID='.$baseID.'#birth');
                       }
                    

                        if ($householdVisitID > 0)
                        {

                            $this->db->trans_start();

                            try
                            {

                                $visitData = array(
                                    'any_birth' => 2,
                                    'transfer_complete' => 'No',
                                    'updateBy' => $this->vendorId,
                                    'updatedOn' => date('Y-m-d H:i:s')
                                );

                                $this->visitModel->edit($visitData,$householdVisitID,$this->config->item('householdVisitTable'));

                            }
                            catch(Exception $e)
                            {
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('error', 'Error occurred while save.');
                            }

                            $this->db->trans_commit();        
                            redirect('householdvisit/education?baseID='.$baseID.'#education');
                            
                        }
                        
                 }

                 if( $this->input->post('submit') == 'Next')
                 {

                       // need work here

                       $countRow = $this->memberModel->getMemberBirthListByHouseholdIdAndRoundId($data['household_master_id_sub'],$data['round_master_id']);

                       if (empty($countRow))
                       {
                         

                            $this->db->trans_start();

                            try
                            {

                                $visitData = array(
                                    'any_birth' => 2,
                                    'transfer_complete' => 'No',
                                    'updateBy' => $this->vendorId,
                                    'updatedOn' => date('Y-m-d H:i:s')
                                );

                                $this->visitModel->edit($visitData,$householdVisitID,$this->config->item('householdVisitTable'));

                            }
                            catch(Exception $e)
                            {
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('error', 'Error occurred while save.');
                            }

                            $this->db->trans_commit(); 



                       }
                   
                        redirect('householdvisit/education?baseID='.$baseID.'#education');
 
                 }
                
            }

            $data['householdVisit'] = $this->visitModel->getHouseholdVisitDet($this->config->item('householdVisitTable'),$data['household_master_id_sub'],$data['round_master_id']);
            $data['birthList'] = $this->memberModel->getMemberBirthListByHouseholdIdAndRoundId($data['household_master_id_sub'],$data['round_master_id']);
            

            
            $data['addPerm']  =  $this->getPermission($baseID, $this->role, 'add');
            $data['editPerm'] =  $this->getPermission($baseID, $this->role, 'edit');
    
            $this->load->view('includes/header', $this->global);
            $this->load->view('includes/wizard', $data);
            $this->load->view($this->controller.'/birth', $data);
            $this->load->view('includes/footer');
        
    }


    public function education()
    {
            $baseID = $this->input->get('baseID', TRUE);
            $this->global['menu'] =  $this->menuModel->getMenu($this->role);
            
            $this->global['pageTitle'] = $this->config->item('prefix'). ' : Education' ;
            $data['pageTitle'] = $this->pageTitle;
            $data['controller'] = $this->controller;
            $data['addMethod'] = 'addNew';
            $data['editMethod'] = 'editOld';
            $data['shortName'] = $this->pageShortName;
            $data['boxTitle'] = 'List';

            // $this->$rountStatus = $this->getCurrentRound()[0]->active;
            // $this->$roundID =  $this->getCurrentRound()[0]->id;

            $data['roundNo'] =  $this->getCurrentRound()[0]->roundNo;
            $data['round_master_id'] =  $this->getCurrentRound()[0]->id;
            $data['householdcode'] =  $this->session->userdata('householdcode');


            $data['household_master_id_sub'] = 0;
            $data['household_master_id_sub'] = $this->session->userdata('household_master_id_sub');

            if ($data['household_master_id_sub'] == 0)
            {
                redirect('householdvisit/visit?baseID='.$baseID);
            }

            if( $this->input->post('submit'))
            {
                $household_master_id = $this->input->post('household_master_id_sub', true);
                $round_master_id = $this->input->post('round_master_id', true);
                $householdVisitID = $this->input->post('householdVisitID', true);
                $eduType = $this->input->post('eduType', true);
                $event = $this->input->post('event', true);

                 if( ($this->input->post('submit') == 'Save & Next'))
                 {

                       // need change

                       $whereHouseholdEdu= array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id);

                       $countRow = $this->db->select('count(id) as countRow')->from($this->config->item('memberEducationTable'))->where($whereHouseholdEdu)->get()->row()->countRow;

                       if ($countRow > 0)
                       {
                          $this->session->set_flashdata('error', 'Education alreay exists for this round so you cannot marks as no.');
                          redirect('householdvisit/education?baseID='.$baseID.'#education');
                       }
                    

                        if ($householdVisitID > 0)
                        {

                            $this->db->trans_start();

                            try
                            {

                                $visitData = array(
                                    'any_education' => 2,
                                    'transfer_complete' => 'No',
                                    'updateBy' => $this->vendorId,
                                    'updatedOn' => date('Y-m-d H:i:s')
                                );

                                $this->visitModel->edit($visitData,$householdVisitID,$this->config->item('householdVisitTable'));

                            }
                            catch(Exception $e)
                            {
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('error', 'Error occurred while save.');
                            }

                            $this->db->trans_commit();        
                            redirect('householdvisit/occupation?baseID='.$baseID.'#occupation');
                            
                        }
                        
                 }

                 if( $this->input->post('submit') == 'Next')
                 {

                       // need work here

                       $whereHouseholdAsset = array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id);

                       $countRow = $this->db->select('count(id) as countRow')->from($this->config->item('memberEducationTable'))->where($whereHouseholdAsset)->get()->row()->countRow;

                       if ($countRow == 0)
                       {
                         

                            $this->db->trans_start();

                            try
                            {

                                $visitData = array(
                                    'any_education' => 2,
                                    'transfer_complete' => 'No',
                                    'updateBy' => $this->vendorId,
                                    'updatedOn' => date('Y-m-d H:i:s')
                                );

                                $this->visitModel->edit($visitData,$householdVisitID,$this->config->item('householdVisitTable'));

                            }
                            catch(Exception $e)
                            {
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('error', 'Error occurred while save.');
                            }

                            $this->db->trans_commit(); 



                       }
                   
                        redirect('householdvisit/occupation?baseID='.$baseID.'#occupation');
 
                 }
                
            }

            
            $data['householdVisit'] = $this->visitModel->getHouseholdVisitDet($this->config->item('householdVisitTable'),$data['household_master_id_sub'],$data['round_master_id']);
            $data['presentMemberList'] = $this->memberModel->getMemberMasterPresentListByHouseholdIds($data['household_master_id_sub']);
            $data['educationRecords']  = $this->educationModel->getRoundwiseEducation($data['household_master_id_sub'],$data['round_master_id']);
            
            
            $data['addPerm']  =  $this->getPermission($baseID, $this->role, 'add');
            $data['editPerm'] =  $this->getPermission($baseID, $this->role, 'edit');
    
            $this->load->view('includes/header', $this->global);
            $this->load->view('includes/wizard', $data);
            $this->load->view($this->controller.'/education', $data);
            $this->load->view('includes/footer');
        
    }

    public function occupation()
    {
            $baseID = $this->input->get('baseID', TRUE);
            $this->global['menu'] =  $this->menuModel->getMenu($this->role);
            
            $this->global['pageTitle'] = $this->config->item('prefix'). ' : Occupation' ;
            $data['pageTitle'] = $this->pageTitle;
            $data['controller'] = $this->controller;
            $data['addMethod'] = 'addNew';
            $data['editMethod'] = 'editOld';
            $data['shortName'] = $this->pageShortName;
            $data['boxTitle'] = 'List';

            // $this->$rountStatus = $this->getCurrentRound()[0]->active;
            // $this->$roundID =  $this->getCurrentRound()[0]->id;

            $data['roundNo'] =  $this->getCurrentRound()[0]->roundNo;
            $data['round_master_id'] =  $this->getCurrentRound()[0]->id;
            $data['householdcode'] =  $this->session->userdata('householdcode');


            $data['household_master_id_sub'] = 0;
            $data['household_master_id_sub'] = $this->session->userdata('household_master_id_sub');

            if ($data['household_master_id_sub'] == 0)
            {
                redirect('householdvisit/visit?baseID='.$baseID);
            }

            if( $this->input->post('submit'))
            {
                $household_master_id = $this->input->post('household_master_id_sub', true);
                $round_master_id = $this->input->post('round_master_id', true);
                $householdVisitID = $this->input->post('householdVisitID', true);
                $occuType = $this->input->post('occuType', true);
                $event = $this->input->post('event', true);

                 if( ($this->input->post('submit') == 'Save & Next'))
                 {

                       // check existing occupation

                       $whereHouseholdOccu= array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id);

                       $countRow = $this->db->select('count(id) as countRow')->from($this->config->item('memberOccupationTable'))->where($whereHouseholdOccu)->get()->row()->countRow;

                       if ($countRow > 0)
                       {
                          $this->session->set_flashdata('error', 'Occupation alreay exists for this round so you cannot marks as no.');
                          redirect('householdvisit/occupation?baseID='.$baseID.'#occupation');
                       }
                    

                        if ($householdVisitID > 0)
                        {

                            $this->db->trans_start();

                            try
                            {

                                $visitData = array(
                                    'any_occupation' => 2,
                                    'transfer_complete' => 'No',
                                    'updateBy' => $this->vendorId,
                                    'updatedOn' => date('Y-m-d H:i:s')
                                );

                                $this->visitModel->edit($visitData,$householdVisitID,$this->config->item('householdVisitTable'));

                            }
                            catch(Exception $e)
                            {
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('error', 'Error occurred while save.');
                            }

                            $this->db->trans_commit();        
                            redirect('householdvisit/relation?baseID='.$baseID.'#relation');
                            
                        }
                        
                 }

                 if( $this->input->post('submit') == 'Next')
                 {

                       // need work here

                       $whereHouseholdAsset = array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id);

                       $countRow = $this->db->select('count(id) as countRow')->from($this->config->item('memberOccupationTable'))->where($whereHouseholdAsset)->get()->row()->countRow;

                       if ($countRow == 0)
                       {
                         

                            $this->db->trans_start();

                            try
                            {

                                $visitData = array(
                                    'any_occupation' => 2,
                                    'transfer_complete' => 'No',
                                    'updateBy' => $this->vendorId,
                                    'updatedOn' => date('Y-m-d H:i:s')
                                );

                                $this->visitModel->edit($visitData,$householdVisitID,$this->config->item('householdVisitTable'));

                            }
                            catch(Exception $e)
                            {
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('error', 'Error occurred while save.');
                            }

                            $this->db->trans_commit(); 



                       }
                   
                       redirect('householdvisit/relation?baseID='.$baseID.'#relation');
 
                 }
                
            }

            
            $data['householdVisit'] = $this->visitModel->getHouseholdVisitDet($this->config->item('householdVisitTable'),$data['household_master_id_sub'],$data['round_master_id']);
            $data['presentMemberList'] = $this->memberModel->getMemberMasterPresentListByHouseholdIds($data['household_master_id_sub']);
            $data['occupaionRecords']  = $this->occupationModel->getRoundwiseOccupation($data['household_master_id_sub'],$data['round_master_id']);
            
            
            $data['addPerm']  =  $this->getPermission($baseID, $this->role, 'add');
            $data['editPerm'] =  $this->getPermission($baseID, $this->role, 'edit');
    
            $this->load->view('includes/header', $this->global);
            $this->load->view('includes/wizard', $data);
            $this->load->view($this->controller.'/occupation', $data);
            $this->load->view('includes/footer');
        
    }

    public function relation()
    {
            $baseID = $this->input->get('baseID', TRUE);
            $this->global['menu'] =  $this->menuModel->getMenu($this->role);
            
            $this->global['pageTitle'] = $this->config->item('prefix'). ' : Relation' ;
            $data['pageTitle'] = $this->pageTitle;
            $data['controller'] = $this->controller;
            $data['addMethod'] = 'addNew';
            $data['editMethod'] = 'editOld';
            $data['shortName'] = $this->pageShortName;
            $data['boxTitle'] = 'List';

            // $this->$rountStatus = $this->getCurrentRound()[0]->active;
            // $this->$roundID =  $this->getCurrentRound()[0]->id;

            $data['roundNo'] =  $this->getCurrentRound()[0]->roundNo;
            $data['round_master_id'] =  $this->getCurrentRound()[0]->id;
            $data['householdcode'] =  $this->session->userdata('householdcode');


            $data['household_master_id_sub'] = 0;
            $data['household_master_id_sub'] = $this->session->userdata('household_master_id_sub');

            if ($data['household_master_id_sub'] == 0)
            {
                redirect('householdvisit/visit?baseID='.$baseID);
            }

            if( $this->input->post('submit'))
            {
                $household_master_id = $this->input->post('household_master_id_sub', true);
                $round_master_id = $this->input->post('round_master_id', true);
                $householdVisitID = $this->input->post('householdVisitID', true);
                $relType = $this->input->post('relType', true);
                $event = $this->input->post('event', true);

                 if( ($this->input->post('submit') == 'Save & Next'))
                 {

                       // need change

                       $whereHouseholdRel = array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id);

                       $countRow = $this->db->select('count(id) as countRow')->from($this->config->item('memberRelationTable'))->where($whereHouseholdRel)->get()->row()->countRow;

                       if ($countRow > 0)
                       {
                          $this->session->set_flashdata('error', 'Relation change alreay exists for this round so you cannot marks as no.');
                          redirect('householdvisit/relation?baseID='.$baseID.'#relation');
                       }
                    

                        if ($householdVisitID > 0)
                        {

                            $this->db->trans_start();

                            try
                            {

                                $visitData = array(
                                    'any_relation' => 2,
                                    'transfer_complete' => 'No',
                                    'updateBy' => $this->vendorId,
                                    'updatedOn' => date('Y-m-d H:i:s')
                                );

                                $this->visitModel->edit($visitData,$householdVisitID,$this->config->item('householdVisitTable'));

                            }
                            catch(Exception $e)
                            {
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('error', 'Error occurred while save.');
                            }

                            $this->db->trans_commit();        
                            redirect('householdvisit/death?baseID='.$baseID.'#death');
                            
                        }
                        
                 }

                 if( $this->input->post('submit') == 'Next')
                 {

                       // need work here

                       $whereHouseholdRel = array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id);

                       $countRow = $this->db->select('count(id) as countRow')->from($this->config->item('memberRelationTable'))->where($whereHouseholdRel)->get()->row()->countRow;

                       if ($countRow == 0)
                       {
                         

                            $this->db->trans_start();

                            try
                            {

                                $visitData = array(
                                    'any_relation' => 2,
                                    'transfer_complete' => 'No',
                                    'updateBy' => $this->vendorId,
                                    'updatedOn' => date('Y-m-d H:i:s')
                                );

                                $this->visitModel->edit($visitData,$householdVisitID,$this->config->item('householdVisitTable'));

                            }
                            catch(Exception $e)
                            {
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('error', 'Error occurred while save.');
                            }

                            $this->db->trans_commit(); 



                       }
                   
                      redirect('householdvisit/death?baseID='.$baseID.'#death');
 
                 }
                
            }
  

            $data['householdVisit'] = $this->visitModel->getHouseholdVisitDet($this->config->item('householdVisitTable'),$data['household_master_id_sub'],$data['round_master_id']);
            $data['presentMemberList'] = $this->memberModel->getMemberMasterPresentListByHouseholdIds($data['household_master_id_sub']);

            $data['relationRecords']  = $this->relationModel->getRoundwiseRelation($data['household_master_id_sub'],$data['round_master_id']);
            
            
            $data['addPerm']  =  $this->getPermission($baseID, $this->role, 'add');
            $data['editPerm'] =  $this->getPermission($baseID, $this->role, 'edit');
    
            $this->load->view('includes/header', $this->global);
            $this->load->view('includes/wizard', $data);
            $this->load->view($this->controller.'/relation', $data);
            $this->load->view('includes/footer');
        
    }

    public function death()
    {
            $baseID = $this->input->get('baseID', TRUE);
            $this->global['menu'] =  $this->menuModel->getMenu($this->role);
            
            $this->global['pageTitle'] = $this->config->item('prefix'). ' : Death' ;
            $data['pageTitle'] = $this->pageTitle;
            $data['controller'] = $this->controller;
            $data['addMethod'] = 'addNew';
            $data['editMethod'] = 'editOld';
            $data['shortName'] = $this->pageShortName;
            $data['boxTitle'] = 'List';

            // $this->$rountStatus = $this->getCurrentRound()[0]->active;
            // $this->$roundID =  $this->getCurrentRound()[0]->id;

            $data['roundNo'] =  $this->getCurrentRound()[0]->roundNo;
            $data['round_master_id'] =  $this->getCurrentRound()[0]->id;
            $data['householdcode'] =  $this->session->userdata('householdcode');


            $data['household_master_id_sub'] = 0;
            $data['household_master_id_sub'] = $this->session->userdata('household_master_id_sub');

            if ($data['household_master_id_sub'] == 0)
            {
                redirect('householdvisit/visit?baseID='.$baseID);
            }

            if( $this->input->post('submit'))
            {
                $household_master_id = $this->input->post('household_master_id_sub', true);
                $round_master_id = $this->input->post('round_master_id', true);
                $householdVisitID = $this->input->post('householdVisitID', true);
                $deathType = $this->input->post('deathType', true);
                $event = $this->input->post('event', true);

                 if( ($this->input->post('submit') == 'Save & Next'))
                 {

                       // need change

                       $whereHouseholdDeath = array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id);

                       $countRow = $this->db->select('count(id) as countRow')->from($this->config->item('deathTable'))->where($whereHouseholdDeath)->get()->row()->countRow;

                       if ($countRow > 0)
                       {
                          $this->session->set_flashdata('error', 'Death alreay exists for this round so you cannot marks as no.');
                          redirect('householdvisit/death?baseID='.$baseID.'#death');
                       }
                    

                        if ($householdVisitID > 0)
                        {

                            $this->db->trans_start();

                            try
                            {

                                $visitData = array(
                                    'any_death' => 2,
                                    'transfer_complete' => 'No',
                                    'updateBy' => $this->vendorId,
                                    'updatedOn' => date('Y-m-d H:i:s')
                                );

                                $this->visitModel->edit($visitData,$householdVisitID,$this->config->item('householdVisitTable'));

                            }
                            catch(Exception $e)
                            {
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('error', 'Error occurred while save.');
                            }

                            $this->db->trans_commit();        
                            redirect('householdvisit/interview?baseID='.$baseID.'#interview');
                            
                        }
                        
                 }

                 if( $this->input->post('submit') == 'Next')
                 {

                       // need work here

                       $whereHouseholdDeath= array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id);

                       $countRow = $this->db->select('count(id) as countRow')->from($this->config->item('deathTable'))->where($whereHouseholdDeath)->get()->row()->countRow;

                       if ($countRow == 0)
                       {
                         

                            $this->db->trans_start();

                            try
                            {

                                $visitData = array(
                                    'any_death' => 2,
                                    'transfer_complete' => 'No',
                                    'updateBy' => $this->vendorId,
                                    'updatedOn' => date('Y-m-d H:i:s')
                                );

                                $this->visitModel->edit($visitData,$householdVisitID,$this->config->item('householdVisitTable'));

                            }
                            catch(Exception $e)
                            {
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('error', 'Error occurred while save.');
                            }

                            $this->db->trans_commit(); 



                       }
                   
                       redirect('householdvisit/interview?baseID='.$baseID.'#interview');
 
                 }
                
            }

            
            $data['householdVisit'] = $this->visitModel->getHouseholdVisitDet($this->config->item('householdVisitTable'),$data['household_master_id_sub'],$data['round_master_id']);
            $data['presentMemberList'] = $this->memberModel->getMemberMasterPresentListByHouseholdIds($data['household_master_id_sub']);

            $data['deathRecords']  = $this->deathModel->getRoundwiseDeath($data['household_master_id_sub'],$data['round_master_id']);
            
            
            $data['addPerm']  =  $this->getPermission($baseID, $this->role, 'add');
            $data['editPerm'] =  $this->getPermission($baseID, $this->role, 'edit');
    
            $this->load->view('includes/header', $this->global);
            $this->load->view('includes/wizard', $data);
            $this->load->view($this->controller.'/death', $data);
            $this->load->view('includes/footer');
        
    }

    public function interview()
    {
            $baseID = $this->input->get('baseID', TRUE);
            $this->global['menu'] =  $this->menuModel->getMenu($this->role);
            
            $this->global['pageTitle'] = $this->config->item('prefix'). ' : Interview' ;
            $data['pageTitle'] = $this->pageTitle;
            $data['controller'] = $this->controller;
            $data['addMethod'] = 'addNew';
            $data['editMethod'] = 'editOld';
            $data['shortName'] = $this->pageShortName;
            $data['boxTitle'] = 'List';

            // $this->$rountStatus = $this->getCurrentRound()[0]->active;
            // $this->$roundID =  $this->getCurrentRound()[0]->id;

            $data['roundNo'] =  $this->getCurrentRound()[0]->roundNo;
            $data['round_master_id'] =  $this->getCurrentRound()[0]->id;
            $data['householdcode'] =  $this->session->userdata('householdcode');


            $data['household_master_id_sub'] = 0;
            $data['household_master_id_sub'] = $this->session->userdata('household_master_id_sub');

            if ($data['household_master_id_sub'] == 0)
            {
                redirect('householdvisit/visit?baseID='.$baseID);
            }

            if( $this->input->post('submit'))
            {
                 

                 if( ($this->input->post('submit') == 'Save & Conmplete') || ($this->input->post('submit') == 'Save'))
                 {
                    $household_master_id = $this->input->post('household_master_id_sub', true);
                    $round_master_id = $this->input->post('round_master_id', true);
                    $householdVisitID = $this->input->post('householdVisitID', true);
                    $contactNumber = $this->input->post('contactNumber', true);
                    $remarks = $this->input->post('remarks', true);

                    $fk_responded_type = $this->input->post('fk_responded_type', true);
                    $respondent_code = $this->input->post('respondent_code', true);
                    $interview_date = $this->input->post('interview_date', true);
                    $fk_interviewer = $this->input->post('fk_interviewer', true);
                    $fk_interview_status = $this->input->post('fk_interview_status', true);

                       $new_interview_date = null;

                       if (!empty($interview_date)) {

                                $parts1 = explode('/', $interview_date);
                                $new_interview_date = $parts1[2] . '-' . $parts1[1] . '-' . $parts1[0];
                        }

                            $this->db->trans_start();

                            try
                            {

                                $visitData = array(
                                    'fk_responded_type' => $fk_responded_type,
                                    'respondent_code' => $respondent_code,
                                    'fk_interviewer' => $fk_interviewer,
                                    'fk_interview_status' => $fk_interview_status,
                                    'remarks' => $remarks,
                                    'interview_date' => $new_interview_date,
                                    'updateBy' => $this->vendorId,
                                    'updatedOn' => date('Y-m-d H:i:s')
                                );

                                $this->visitModel->edit($visitData,$householdVisitID,$this->config->item('householdVisitTable'));

                                $masterData = array(
                                    'contact_number' => $contactNumber,
                                    'updateBy' => $this->vendorId,
                                    'updatedOn' => date('Y-m-d H:i:s')
                                );

                                $this->visitModel->edit($masterData,$household_master_id,$this->config->item('householdMasterTable'));

                            }
                            catch(Exception $e)
                            {
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('error', 'Error occurred while save.');
                            }

                            $this->db->trans_commit(); 

                            $this->session->set_flashdata('success', 'interview saved successfully.');

                            if( $this->input->post('submit') == 'Save & Conmplete')
                             {
                               
                                $this->session->unset_userdata('household_master_id_sub');
                                redirect('householdvisit/visit?baseID='.$baseID);

                             }

                            redirect('householdvisit/interview?baseID='.$baseID.'#interview');
                 }

                 if( $this->input->post('submit') == 'Save & Conmplete')
                 {
                   
                    $this->session->unset_userdata('household_master_id_sub');
                    redirect('householdvisit/visit?baseID='.$baseID);

                 }
                   

                
            }
            
            $data['householdVisit'] = $this->visitModel->getHouseholdVisitDet($this->config->item('householdVisitTable'),$data['household_master_id_sub'],$data['round_master_id']);

            $data['presentMemberList'] = $this->memberModel->getMemberMasterPresentListByHouseholdIds($data['household_master_id_sub']);

             $data['interviewstatus'] = $this->modelName->getLookUpList($this->config->item('interviewstatus'));
             $data['interviewercode'] = $this->modelName->getLookUpList($this->config->item('interviewercode'));
             $data['respondent_typ'] = $this->modelName->getLookUpList($this->config->item('respondent_typ'));
            
           
            
            $data['addPerm']  =  $this->getPermission($baseID, $this->role, 'add');
            $data['editPerm'] =  $this->getPermission($baseID, $this->role, 'edit');
    
            $this->load->view('includes/header', $this->global);
            $this->load->view('includes/wizard', $data);
            $this->load->view($this->controller.'/interview', $data);
            $this->load->view('includes/footer');
        
    }

    
    
    
}

?>