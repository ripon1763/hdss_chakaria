<?php
   
require APPPATH . 'libraries/REST_Controller.php';
     
class Lookup extends REST_Controller {
    
	  /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();
       $this->load->database();
    }
       
	
	public function index_get($lookVar = '')
	{
        if(!empty($lookVar)){
			
			$countR = $this->db->select('count(id) as countR')->get_where("tbl_lookup_master", ['code' => $lookVar,'active'=> 1])->row()->countR;
			if ($countR > 0)
			{
				$id = $this->db->select('id')->get_where("tbl_lookup_master", ['code' => $lookVar,'active'=> 1])->row()->id;
                $data = $this->db->select('id,code,name')->get_where("tbl_lookup_details", ['lookup_master_id' => $id,'active'=> 1])->result_array();
			}
			else 
			{
				$data = array();
			}
			
        }else{
            $data = array();
        }
     
        $this->response($data, REST_Controller::HTTP_OK);
	}
      
    	
}