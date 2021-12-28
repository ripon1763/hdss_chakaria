<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Dashboard extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
		$this->load->model('menu_model');
		$this->load->model('member_model');
        $this->isLoggedIn();  

         $menu_key = 'home';
		 
		 $baseID = $this->input->get('baseID', TRUE);
		 
		 $baseID = isset($baseID) ?  1 : $baseID  ;
		 
		 
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
		$this->load->model('menu_model');

        $this->global['menu'] =  $this->menu_model->getMenu($this->role);
		
        $this->global['pageTitle'] = $this->config->item('prefix'). ' : Dashboard';

           

        //echo CI_VERSION; 
        $this->load->view('includes/header', $this->global);
        $this->load->view('dashboard');
        $this->load->view('includes/footer');
    }
	
	function logout() {
		$this->session->sess_destroy ();
		
		redirect ( 'login' );
	}
	
    
}

?>