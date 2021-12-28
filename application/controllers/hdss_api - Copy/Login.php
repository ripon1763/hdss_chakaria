<?php
   
require APPPATH . 'libraries/REST_Controller.php';
     
class Login extends REST_Controller {
    
	  /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();
       $this->load->database();
    }
       
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
	// public function index_get($id = 0)
	// {
        // if(!empty($id)){
            // $data = $this->db->get_where("tbl_users", ['userId' => $id])->row_array();
        // }else{
            // $data = $this->db->get("tbl_users")->result();
        // }
     
        // $this->response($data, REST_Controller::HTTP_OK);
	// }
	
	public function index_get($username = '', $password = '')
	{
        if(!empty($username)){
            $data = $this->db->select('userId,name,roleId,username')->get_where("tbl_users", ['username' => $username, 'password' => md5($password),'active'=> 1])->row_array();
        }else{
            $data = array();
        }
     
        $this->response($data, REST_Controller::HTTP_OK);
	}
      
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    // public function index_post()
    // {
        // $input = $this->input->post();
        // $this->db->insert('items',$input);
     
        // $this->response(['Item created successfully.'], REST_Controller::HTTP_OK);
    // } 
     
    // /**
     // * Get All Data from this method.
     // *
     // * @return Response
    // */
    // public function index_put($id)
    // {
        // $input = $this->put();
        // $this->db->update('items', $input, array('id'=>$id));
     
        // $this->response(['Item updated successfully.'], REST_Controller::HTTP_OK);
    // }
     
    	
}