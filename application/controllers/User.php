<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class User extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('master_model');
		$this->load->model('menu_model');
        $this->isLoggedIn();  

         $baseID = $this->input->get('baseID', TRUE);
		 if ($baseID == 1)
		 {			 
		      $menu_key = 'home';
		 }
		 else {
			  $menu_key = 'um';
		 }	 
		 $result = $this->loadThisForAccess($this->role,$baseID,$menu_key);
		 if ($result != true) 
		 {
			 redirect('access');
		 }
		 	
    }
    

    /**
     * This function is used to load the user list
     */
    function index()
    {
      
            $data['baseID'] = $this->input->get('baseID', TRUE);
			
            $this->global['menu'] =  $this->menu_model->getMenu($this->role);

            $data['userRecords'] = $this->user_model->userListing();
            
            $this->global['pageTitle'] = $this->config->item('prefix'). ' : User Listing';
            $this->load->view('includes/header', $this->global);
            $this->load->view('users', $data);
            $this->load->view('includes/footer');
        
    }

    /**
     * This function is used to load the add new form
     */
    function addNew()
    {
        
			$data['baseID'] = $this->input->get('baseID', TRUE);
			$this->global['menu'] =  $this->menu_model->getMenu($this->role);
			
			$data['roles'] = $this->user_model->getUserRoles();
            $data['store'] = $this->master_model->getListType($this->config->item('slumTable'));
			
            $this->global['pageTitle'] = $this->config->item('prefix'). ' : Add New User';
            $this->load->view('includes/header', $this->global);
            $this->load->view('addNew', $data);
            $this->load->view('includes/footer');
        
    }
    
    /**
     * This function is used to add new user to the system
     */
    function addNewUser()
    {
        
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]|xss_clean');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|xss_clean|max_length[128]');
            $this->form_validation->set_rules('password','Password','required|max_length[20]');
            $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]|max_length[20]');
            //$this->form_validation->set_rules('role','Role','trim|required|numeric');
			$this->form_validation->set_rules('username','User Name','trim|required|xss_clean');
            $this->form_validation->set_rules('job_title','Job Title','trim|required|xss_clean');
			
            $this->form_validation->set_rules('mobile','Mobile Number','required|xss_clean');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->addNew();
            }
            else
            {
                $data['baseID'] = $this->input->get('baseID', TRUE);
				$name = $this->input->post('fname');
                $email = $this->input->post('email');
                $password = $this->input->post('password');
                $roleId = $this->input->post('role');
                $mobile = $this->input->post('mobile');
				$username = $this->input->post('username');
                $job_title = $this->input->post('job_title');
                $slum_id = $this->input->post('slum_id');
                $active = $this->input->post('active');
				
				$roleId_pg = implode(",",$roleId);
                
                $userInfo = array('email'=>$email, 'password'=>md5($password), 'roleId'=>$roleId_pg, 'name'=> $name,'username'=>$username, 
								  'job_title'=>$job_title,'employee_id'=>'','slum_id'=>$slum_id,'active'=>$active,
                                  'system_user'=>1, 'mobile'=>$mobile, 'createdBy'=>$this->vendorId, 'createdDtm'=>date('Y-m-d H:i:s'));
                
                $result = $this->user_model->addNewUser($userInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New User created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'User creation failed');
                }
                
                redirect('user/addNew'.'?baseID='.$data['baseID']);
            }
        
    }

    
    /**
     * This function is used load user edit information
     * @param number $userId : Optional : This is user id
     */
    function editOld($userId = NULL)
    {
        
            if($userId == null)
            {
                redirect('user');
            }
			
			$this->global['menu'] =  $this->menu_model->getMenu($this->role);
            
            $data['roles'] = $this->user_model->getUserRoles();
            $data['userInfo'] = $this->user_model->getUserInfo($userId);

			$data['store'] = $this->master_model->getListType($this->config->item('slumTable'));
			
			
            $data['baseID'] = $this->input->get('baseID', TRUE);
            $this->global['pageTitle'] = $this->config->item('prefix'). ' : Edit User';
            $this->load->view('includes/header', $this->global);
            $this->load->view('editOld', $data);
            $this->load->view('includes/footer');
        
    }
    
    
    /**
     * This function is used to edit the user information
     */
    function editUser()
    {
        
            $this->load->library('form_validation');
            
            $userId = $this->input->post('userId');
			$data['baseID'] = $this->input->get('baseID', TRUE);
            
            $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]|xss_clean');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|xss_clean|max_length[128]');
            $this->form_validation->set_rules('password','Password','matches[cpassword]|max_length[20]');
            $this->form_validation->set_rules('cpassword','Confirm Password','matches[password]|max_length[20]');
            //$this->form_validation->set_rules('role','Role','trim|required|numeric');
            //$this->form_validation->set_rules('mobile','Mobile Number','required|xss_clean');
			$this->form_validation->set_rules('username','User Name','trim|required|xss_clean');
            $this->form_validation->set_rules('job_title','Job Title','trim|required|xss_clean');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editOld($userId);
            }
            else
            {
                $name = $this->input->post('fname');
                $email = $this->input->post('email');
                $password = $this->input->post('password');
                $roleId = $this->input->post('role');
                $mobile = $this->input->post('mobile');
				
				$roleId_pg = implode(",",$roleId);
				
				$username = $this->input->post('username');
                $job_title = $this->input->post('job_title');
				$slum_id = $this->input->post('slum_id');
				$active = $this->input->post('active');
                
                $userInfo = array();
                
                if(empty($password))
                {
                    $userInfo = array('email'=>$email, 'roleId'=>$roleId_pg, 'name'=>$name,'username'=>$username, 
                                    'job_title'=>$job_title,'slum_id'=>$slum_id,'active'=>$active,
                                      'mobile'=>$mobile, 'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
                }
                else
                {
                    $userInfo = array('email'=>$email,'username'=>$username, 'job_title'=>$job_title, 
									  'password'=>md5($password), 'roleId'=>$roleId_pg, 'name'=>ucwords($name),'slum_id'=>$slum_id,'active'=>$active,
									  'mobile'=>$mobile, 'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
                }
                
                $result = $this->user_model->editUser($userInfo, $userId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'User updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'User updation failed');
                }
				
                
                redirect('user'.'?baseID='.$data['baseID']);
            }
        
    }


    /**
     * This function is used to delete the user using userId
     * @return boolean $result : TRUE / FALSE
     */
    function deleteUser()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $userId = $this->input->post('userId');
            $userInfo = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
			$data['baseID'] = $this->input->get('baseID', TRUE);
            
            $result = $this->user_model->deleteUser($userId, $userInfo);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }
    
    /**
     * This function is used to load the change password screen
     */
    function loadChangePass()
    {
        $this->global['pageTitle'] = $this->config->item('prefix'). ' : Change Password';
		$this->load->model('menu_model');
		$this->global['menu'] =  $this->menu_model->getMenu($this->role);
		$data['baseID'] = $this->input->get('baseID', TRUE);
        
        $this->load->view('includes/header', $this->global);
        $this->load->view('changePassword');
        $this->load->view('includes/footer');
    }
    
    
    /**
     * This function is used to change the password of the user
     */
    function changePassword()
    {
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('oldPassword','Old password','required|max_length[20]');
        $this->form_validation->set_rules('newPassword','New password','required|max_length[20]');
        $this->form_validation->set_rules('cNewPassword','Confirm new password','required|matches[newPassword]|max_length[20]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->loadChangePass();
        }
        else
        {
            $oldPassword = $this->input->post('oldPassword');
            $newPassword = $this->input->post('newPassword');
            
            $resultPas = $this->user_model->matchOldPassword($this->vendorId, md5($oldPassword));
			$data['baseID'] = $this->input->get('baseID', TRUE);
            
            if(empty($resultPas))
            {
                $this->session->set_flashdata('nomatch', 'Your old password not correct');
                redirect('user/loadChangePass?baseID=1');
            }
            else
            {
                $usersData = array('password'=>md5($newPassword), 'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
                
                $result = $this->user_model->changePassword($this->vendorId, $usersData);
                
                if($result > 0) { $this->session->set_flashdata('success', 'Password updated successful'); }
                else { $this->session->set_flashdata('error', 'Password update failed'); }
                
                redirect('user/loadChangePass?baseID=1');
            }
        }
    }
	
	
	
}

?>