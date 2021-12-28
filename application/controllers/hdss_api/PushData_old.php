<?php
   
require APPPATH . 'libraries/REST_Controller.php';
     
class PushData extends REST_Controller {
    
	/**
     * Push Data to the server.
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();
       $this->load->database();
    }

    public function insertUpdateHousehold_post()
    {
        $inputs = json_decode(file_get_contents('php://input'), true);
        $result = array();
        $response = array();

        if (!empty($inputs)) {
            foreach ($inputs as $data) {
                unset($data['id']);

                $data['extinct_date'] = date('Y-m-d', strtotime($data['extinct_date']));
                $data['entry_date'] = date('Y-m-d', strtotime($data['entry_date']));
                $data['insertedOn'] = date('Y-m-d H:i:s', strtotime($data['insertedOn']));
                $data['updatedOn'] = date('Y-m-d H:i:s', strtotime($data['updatedOn']));
                
                if ($data['updateBy'] <= 0) {
                    $result = array(
                        'type' => 'insert',
                        'mobile_id' => $data['mobile_id'],
                        'SyncStatus' => $this->db->insert('household_master', $data)
                    );
                }else{
                    unset($data['household_code']);
                    $this->db->where('mobile_id', $data['mobile_id'])->update('household_master', $data);
                    $result = array(
                        'type' => 'update',
                        'mobile_id' => $data['mobile_id'],
                        'SyncStatus' => $this->db->affected_rows() > 0 ? true :false
                    );
                }

                $response[] = $result;
            }    
        }

        $this->response($response, REST_Controller::HTTP_OK);
    }
}