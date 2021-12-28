<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Access extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
		$this->load->model('menu_model');
		$this->load->library('pagination');
        $this->isLoggedIn();
		
    }

    /**
     * This function used to load the first screen of the user
     */

	public function index()
    {
       
		$this->global['menu'] =  $this->menu_model->getMenu($this->role);
		
		$this->global ['pageTitle'] = 'icddr,b : Access Denied';
		
		$this->load->view ( 'includes/header', $this->global );
		$this->load->view ( 'access' );
		$this->load->view ( 'includes/footer' );
		
		redirect('dashboard?baseID=1');
    }
	

}

?>