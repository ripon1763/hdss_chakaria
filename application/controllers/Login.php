<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Login extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
		//$this->load->library('session');
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $this->isLoggedIn();
    }
    
    /**
     * This function used to check the user is logged in or not
     */
    function isLoggedIn()
    {
        
		
		$isLoggedIn = $this->session->userdata('isLoggedIn');
        
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            $this->load->view('login');
        }
        else
        {
            redirect('/dashboard?baseID=1');
        }
    }
    
    
    /**
     * This function used to logged in user
     */
    public function loginMe()
    {
        
		
		
		$this->load->library('form_validation');
        
        $this->form_validation->set_rules('username', 'User Name', 'required|max_length[128]|xss_clean|trim');
        $this->form_validation->set_rules('password', 'Password', 'required');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->index();
        }
        else
        {
            
			//$option = $this->input->post('option');
			$username = $this->input->post('username');
            $password = $this->input->post('password');
            
            $ecryptPassword = md5($password);
			
							// user part
            
							$result = $this->login_model->loginMe($username, $ecryptPassword);
							
							if(count($result) > 0)
							{
								foreach ($result as $res)
								{
									
									$lastLogin = $this->login_model->lastLoginInfo($res->userId);
									
									if (empty($lastLogin))
									{
										$lastLoginDate  = date('Y-m-d H:i:s');
									}
									else
									{
										$lastLoginDate  = $lastLogin->createdDtm;
									}
									
									$process = 'Login';
									$processFunction = 'Login/LoginMe';
									$sessionArray = array('userId'=>$res->userId,                    
															'role'=>$res->roleId,
															'roleText'=>'',
															'system_user'=>$res->system_user,
															'name'=>$res->name,
															'username'=>$res->username,
															'extension' => $res->extension,
															'lastLogin'=> $lastLoginDate,
															'slumID'=> $res->slum_id,
															'employee_id'=> null,
															'isLoggedIn' => TRUE
													);
													
									$this->session->set_userdata($sessionArray);
								
                                    $this->logrecord($process,$processFunction);
									
									redirect('/dashboard?baseID=1');
								}
							}
							else
							{
								$this->session->set_flashdata('error', 'User Name or password mismatch');
								
								redirect('/login');
							}
						
					
				
				
			 
			 
        }
    }
}

?>