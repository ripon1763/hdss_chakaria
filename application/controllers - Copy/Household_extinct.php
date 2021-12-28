<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Household_extinct extends BaseController
{
    /**
     * This is default constructor of the class
     */
	 
	public $controller = "household_extinct";
	public $pageTitle = 'Household Extinct';
	public $pageShortName = 'Household Extinct';
	
	 
    public function __construct()
    {
        parent::__construct();
		$this->load->model('master_model','modelName');
        $this->load->model('household_model','householdModel');
		$this->load->model('menu_model','menuModel');
		$this->load->library('pagination');
        $this->isLoggedIn(); 
		 $menu_key = 'extinct';
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
			$data['editMethod'] = 'extinctHousehold';
			$data['shortName'] = $this->pageShortName;
			$data['boxTitle'] = 'List';

            $data['district_id'] = '';
            $data['thana_id'] = '';
            $data['slum_id'] = '';
            $data['slumarea_id'] = '';
            $district_id = '';
            $thana_id = '';
            $slum_id = '';
            $slumarea_id = '';
                
            if($this->input->post('Clear'))
            {
                $this->session->unset_userdata('district_id'); 
                $data['district_id'] = '';
                $this->session->unset_userdata('thana_id'); 
                $data['thana_id'] = '';
                $this->session->unset_userdata('slum_id'); 
                $data['slum_id'] = '';
                $this->session->unset_userdata('slumarea_id'); 
                $data['slumarea_id'] = '';
            }
            
            
            
            $district_id = $this->input->post('district_id');
            $thana_id = $this->input->post('thana_id');
            $slum_id = $this->input->post('slum_id');
            $slumarea_id = $this->input->post('slumarea_id');

            $data['district_id'] = $this->session->userdata('district_id');
            $data['thana_id'] = $this->session->userdata('thana_id');
            $data['slum_id'] = $this->session->userdata('slum_id');
            $data['slumarea_id'] = $this->session->userdata('slumarea_id');
            
            if($this->input->post('search'))
            {
            
             $this->session->set_userdata('district_id', $district_id);
             $data['district_id'] = $this->session->userdata('district_id');

             $this->session->set_userdata('thana_id', $thana_id);
             $data['thana_id'] = $this->session->userdata('thana_id');

             $this->session->set_userdata('slum_id', $slum_id);
             $data['slum_id'] = $this->session->userdata('slum_id');

             $this->session->set_userdata('slumarea_id', $slumarea_id);
             $data['slumarea_id'] = $this->session->userdata('slumarea_id');

            }


            $data['district'] = $this->modelName->getListType($this->config->item('districtTable'));

            if ( ($data['district_id'] > 0) &&  ($data['thana_id'] > 0) && ($data['slum_id'] > 0))
            {

                 $data['userRecords'] = $this->householdModel->listingHousehold($this->config->item('householdMasterTable'), $data['district_id'],$data['thana_id'], $data['slum_id'],$data['slumarea_id']);
            }

           
            
			$data['addPerm']  =  $this->getPermission($baseID, $this->role, 'add');
			$data['editPerm'] =  $this->getPermission($baseID, $this->role, 'edit');
	
		    $this->load->view('includes/header', $this->global);
			$this->load->view('includes/script');
			$this->load->view($this->controller.'/index', $data);
			$this->load->view('includes/footer');
		
    }
    

    function extinctHousehold($id = NULL)
    {
			$baseID = $this->input->get('baseID', TRUE);
			
            if($id == null)
            {
                $this->session->set_flashdata('error', "Someting went wrong!! Please try Again");
				redirect($this->controller.'?baseID='.$baseID);
            }
			
			$editPerm =  $this->getPermission($baseID, $this->role, 'edit');
			if($editPerm == 0)
            {
                $this->session->set_flashdata('error', "Unauthorized Access");
				redirect($this->controller.'?baseID='.$baseID);
            }
			
            
		    $this->global['menu'] =  $this->menuModel->getMenu($this->role);
            $data['userInfo'] = $this->householdModel->getListInfo($id,$this->config->item('householdMasterTable'));


             //$data['division'] = $this->modelName->getListType($this->config->item('divTable'));
            $data['district'] = $this->modelName->getListType($this->config->item('districtTable'));
            $data['district2'] = $this->modelName->getListType($this->config->item('districtTable'));
            $data['country'] = $this->modelName->getListType($this->config->item('countryTable'));
           // $data['thana']    = $this->modelName->getListType($this->config->item('upazilaTable'));
            //$data['slum']     = $this->modelName->getListType($this->config->item('slumTable'));
           // $data['slumarea'] = $this->modelName->getListType($this->config->item('slumAreaTable'));

            $data['entryType'] = $this->modelName->getLookUpListSpecific($this->config->item('hhentrytype'), array('bls','min','intin'));
            $data['hh_extinct_typ'] = $this->modelName->getLookUpList($this->config->item('hh_extinct_typ'));
            $data['hhcontacttyp'] = $this->modelName->getLookUpList($this->config->item('hhcontacttyp'));

			
			$this->global['pageTitle'] = $this->config->item('prefix'). ' : ' .$this->pageTitle;
	        $data['pageTitle'] = $this->pageTitle;
			$data['controller'] = $this->controller;
			$data['actionMethod'] = 'editList';
			$data['shortName'] = $this->pageShortName;
			$data['boxTitle'] = 'Edit';
			
			
            $this->load->view('includes/header', $this->global);
            $this->load->view($this->controller.'/editOld', $data);
            $this->load->view('includes/footer');
    }
    
    
    /**
     * This function is used to edit information
     */
    function editList()
    {
            $this->load->library('form_validation');
            
            $id = $this->input->post('id');
			$baseID = $this->input->get('baseID', TRUE);
	
            //$this->form_validation->set_rules('districtID','District Name','trim|required|numeric');
           // $this->form_validation->set_rules('thanaID','Upazila Name','trim|required|numeric');
           // $this->form_validation->set_rules('slumID','Slum Name','trim|required|numeric');
           // $this->form_validation->set_rules('slumAreaID','Slum Area Name','trim|required|numeric');
            $this->form_validation->set_rules('bariwallaName','Bariwalla Name','trim|required|max_length[255]|xss_clean');
            $this->form_validation->set_rules('bariNumber','Bari Number','trim|required|max_length[10]|xss_clean');
            $this->form_validation->set_rules('headName','Head Name','trim|required|max_length[255]|xss_clean');
            $this->form_validation->set_rules('livingYear','Living Year','trim|required|max_length[2]|xss_clean');
            $this->form_validation->set_rules('livingMonth','Living Month','trim|required|max_length[2]|xss_clean');

            $this->form_validation->set_rules('leftSlum','Left Slum','trim|required|numeric');
            $this->form_validation->set_rules('entryType','Entry Type','trim|required|numeric');

            $this->form_validation->set_rules('entryDate','Entry Date','trim|required');
            $this->form_validation->set_rules('contactNumber','Contact Number','trim|required|max_length[100]|xss_clean');
            $this->form_validation->set_rules('contactSource','Contact Source','trim|required|numeric');
        
            if($this->form_validation->run() == FALSE)
            {
                $this->editOld($id);
            }
            else
            {
                
			   // $districtID = $this->input->post('districtID',true);
               // $thanaID = $this->input->post('thanaID',true);
               // $slumID = $this->input->post('slumID',true);
                //$slumAreaID = $this->input->post('slumAreaID',true);
                $bariwallaName = $this->input->post('bariwallaName',true);
                $bariNumber = $this->input->post('bariNumber',true);
                $headName = $this->input->post('headName',true);
                $livingYear = $this->input->post('livingYear',true);
                $livingMonth = $this->input->post('livingMonth',true);
                $leftSlum = $this->input->post('leftSlum',true);
                $entryType = $this->input->post('entryType',true);
                $entryDate = $this->input->post('entryDate',true);
                $contactNumber = $this->input->post('contactNumber',true);
                $contactSource = $this->input->post('contactSource',true);
                $household_code = $this->input->post('household_code',true);


                if (!empty($entryDate)) {
                    $parts1 = explode('/', $entryDate);
                    $new_entryDate = $parts1[2] . '-' . $parts1[1] . '-' . $parts1[0];
                }

                
                $migrationReason = 0;
                $countryID =0;
                $migDistrictID = 0;
                $migThanaID = 0;
                $slumIDFrom = 0;
                $slumAreaIDFrom =0;

                $migreasonOth = '';



                if ( $entryType == $this->config->item('HHEntyMigIn')) // migration in
                {
                    $migrationReason = $this->input->post('migrationReason',true);
                    $countryID = $this->input->post('countryID',true);
                    $migDistrictID = $this->input->post('migDistrictID',true);
                    $migThanaID = $this->input->post('migThanaID',true);

                    if ($migrationReason == 12)
                    {
                        $migreasonOth = $this->input->post('migreasonOth',true);
                    }
                }

                
                if ( $entryType == $this->config->item('HHEntyIntIn')) // int in
                {
                    $migrationReason = $this->input->post('migrationReason',true);
                    $countryID = $this->input->post('countryID',true);
                    $migDistrictID = $this->input->post('migDistrictID',true);
                    $migThanaID = $this->input->post('migThanaID',true);

                    $slumIDFrom = $this->input->post('slumIDFrom',true);
                    $slumAreaIDFrom = $this->input->post('slumAreaIDFrom',true);

                    if ($migrationReason == 12)
                    {
                        $migreasonOth = $this->input->post('migreasonOth',true);
                    }
                }


                $this->db->trans_start();

                try
                { 


                    $IdInfo = array(
                        'contact_number'=>$contactNumber, 
                       // 'fk_district_id'=>$districtID, 
                       // 'fk_thana_id'=>$thanaID, 
                       // 'fk_slum_id'=>$slumID, 
                       // 'fk_slum_area_id'=>$slumAreaID, 
                        'barino'=>$bariNumber, 
                        'bariwalla_name'=>$bariwallaName, 
                        'household_head_name'=>$headName, 
                        'longlivy'=>$livingYear, 
                        'longlivm'=>$livingMonth, 
                        'leftpad'=>$leftSlum, 
                        'fk_entry_type'=>$entryType, 
                        'entry_date'=>$new_entryDate, 
                        'fk_migration_reason'=>$migrationReason, 
                        'migration_reason_oth'=>$migreasonOth, 
                        'fk_country_id_from'=>$countryID, 
                        'fk_district_id_from'=>$migDistrictID, 
                        'fk_thana_id_from'=>$migThanaID, 
                        'fk_slum_id_from'=>$slumIDFrom, 
                        'fk_slumArea_id_from'=>$slumAreaIDFrom, 
                        'fk_contract_type'=>$contactSource, 
                        'updateBy'=>$this->vendorId, 
                        'updatedOn'=>date('Y-m-d H:i:s')
                    );
                        
                    $result = $this->modelName->editList($IdInfo,$id,$this->config->item('householdMasterTable'));

                    
                }
                catch(Exception $e)
                {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('error', 'Error occurred while updating household.');
                }

                $this->db->trans_commit();
                $this->session->set_flashdata('success', $this->pageShortName.' ( '. $household_code .' ) updated successfully');
                
                redirect($this->controller.'?baseID='.$baseID);


            }
        
    }
    
    
}

?>