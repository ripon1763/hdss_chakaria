<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Search extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('visitor_model');
		$this->load->library('pagination');
        $this->isLoggedIn(); 
    }
	
	public function index()
	{
        $json = [];
			
			//$query = $this->db->select('employeeId as id,firstnames as text')
			//			->limit(10)
			//			->get('tbl_staff');
			//$json = $query->result();
			
			$SQL = "SELECT employeeId as id, CONCAT_WS(' ', employeeId, firstnames, lastname) as text FROM tbl_staff 
		WHERE firstnames LIKE '%".$this->input->get('q')."%' or lastname LIKE '%".$this->input->get('q')."%' or 
		employeeId LIKE '%".$this->input->get('q')."%'
		LIMIT 10";
		
            $query = $this->db->query($SQL);
			$json = $query->result();
		
		echo json_encode($json);
	}

}