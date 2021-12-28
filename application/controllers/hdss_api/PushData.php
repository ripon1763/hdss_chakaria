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

   private function isValidDate($date = null){
    if (isset($date)) {
        $datetime_parts = array();
        $datetime_parts = explode(' ', $date);
        $date_parts = array();
        $date_parts = explode('-', $datetime_parts[0]);
        if (isset($date_parts[2])) {
            if (checkdate($date_parts[1], $date_parts[2], $date_parts[0])) {
                return true;
            } else {
                return false;
            }
        }
    } else {
        return false;
    }
}

private function insertSafe($tableName, $data){
    try{
        return $this->db->insert($tableName, $data);
    }
    catch(Exception $e)
    {
        return false;
    }
}

private function updateSafe($tableName, $whereClause, $data){
    try{
        $this->db->where('mobile_id', $whereClause)->update($tableName, $data);
        return $this->db->affected_rows() > 0;
    }
    catch(Exception $e)
    {
        return false;
    }
}

private function key_exists($columnName, $columnVal, $tableName)
{
    $this->db->where($columnName, $columnVal);
    $query = $this->db->get($tableName);
    if ($query->num_rows() > 0){
        return true;
    }
    else{
        return false;
    }
}

private function key_exists_household_round($tableName, $household_master_id, $round_master_id)
{
    $this->db->where('household_master_id', $household_master_id);
    $this->db->where('round_master_id', $round_master_id);
    $query = $this->db->get($tableName);
    if ($query->num_rows() > 0){
        return true;
    }
    else{
        return false;
    }
}


private function key_exists_member_round($tableName, $member_master_id, $round_master_id)
{
    $this->db->where('member_master_id', $member_master_id);
    $this->db->where('round_master_id', $round_master_id);
    $query = $this->db->get($tableName);
    if ($query->num_rows() > 0){
        return true;
    }
    else{
        return false;
    }
}

//insert or update all data of 20 tables
public function index_post()
{
    $inputs = json_decode(file_get_contents('php://input'), true);
    $response = array();

    $result = array();
        //Insert or update household_master table
    if (!empty($inputs['household_master'])) {
        foreach ($inputs['household_master'] as $data) {
            unset($data['lid']);

            $data['extinct_date'] = $this->isValidDate($data['extinct_date']) ? date('Y-m-d', strtotime($data['extinct_date'])) : null;
            $data['entry_date'] = date('Y-m-d', strtotime($data['entry_date']));
            $data['insertedOn'] = date('Y-m-d H:i:s', strtotime($data['insertedOn']));
            $data['updatedOn'] = $this->isValidDate($data['updatedOn']) ? date('Y-m-d H:i:s', strtotime($data['updatedOn'])) : null;

            if (isset($data['household_code'])) {
                $isExists = $this->key_exists('household_code', $data['household_code'], 'household_master');
                if ($isExists) {
                    //update
                    unset($data['household_code']);
                    $result[] = array(
                        'type' => 'update',
                        'mobile_id' => $data['mobile_id'],
                        'SyncStatus' => $this->updateSafe('household_master', $data['mobile_id'], $data)
                    );
                }else{
                    $result[] = array(
                        'type' => 'insert',
                        'mobile_id' => $data['mobile_id'],
                        'SyncStatus' => $this->insertSafe('household_master', $data)
                    );
                }
            }
            $response['household_master'] = $result;
        }    
    }else{
        $response['household_master'] = array();
    }

        //Insert or update member_master table
        $result = array();//reset result array
        if (!empty($inputs['member_master'])) {
            foreach ($inputs['member_master'] as $data) {
                unset($data['lid']);

                $data['birth_date'] = $this->isValidDate($data['birth_date']) ? date('Y-m-d', strtotime($data['birth_date'])) : null;
                $data['birth_registration_date'] = $this->isValidDate($data['birth_registration_date']) ? date('Y-m-d', strtotime($data['birth_registration_date'])) : null;
                $data['followup_exit_date'] = $this->isValidDate($data['followup_exit_date']) ? date('Y-m-d', strtotime($data['followup_exit_date'])) : null;
                $data['last_marriage_date'] = $this->isValidDate($data['last_marriage_date']) ? date('Y-m-d', strtotime($data['last_marriage_date'])) : null;
                $data['last_marriage_end_date'] = $this->isValidDate($data['last_marriage_end_date']) ? date('Y-m-d', strtotime($data['last_marriage_end_date'])) : null;
                
                $data['insertedOn'] = date('Y-m-d H:i:s', strtotime($data['insertedOn']));
                $data['updatedOn'] = $this->isValidDate($data['updatedOn']) ? date('Y-m-d H:i:s', strtotime($data['updatedOn'])) : null;

                if (isset($data['member_code'])) {
                    $isExists = $this->key_exists('member_code', $data['member_code'], 'tbl_member_master');
                    if ($isExists) {
                        //update
                        unset($data['member_code']);
                        $result[] = array(
                            'type' => 'update',
                            'mobile_id' => $data['mobile_id'],
                            'SyncStatus' => $this->updateSafe('tbl_member_master', $data['mobile_id'], $data)
                        );
                    }else{
                        $result[] = array(
                            'type' => 'insert',
                            'mobile_id' => $data['mobile_id'],
                            'SyncStatus' => $this->insertSafe('tbl_member_master', $data)
                        );
                    }
                }
                
                $response['member_master'] = $result;
            }    
        }else{
            $response['member_master'] = array();
        }


        //Insert or update member_household table
        $result = array();//reset result array
        if (!empty($inputs['member_household'])) {
            foreach ($inputs['member_household'] as $data) {
                unset($data['lid']);

                $data['entry_date'] = date('Y-m-d', strtotime($data['entry_date']));
                $data['exit_date'] = $this->isValidDate($data['exit_date']) ? date('Y-m-d', strtotime($data['exit_date'])) : null;
                
                $data['insertedOn'] = date('Y-m-d H:i:s', strtotime($data['insertedOn']));
                $data['updatedOn'] = $this->isValidDate($data['updatedOn']) ? date('Y-m-d H:i:s', strtotime($data['updatedOn'])) : null;
                
                if (isset($data['mobile_id'])) {
                    $isExists = $this->key_exists('mobile_id', $data['mobile_id'], 'tbl_member_household');
                    if ($isExists) {
                        //update
                        $result[] = array(
                            'type' => 'update',
                            'mobile_id' => $data['mobile_id'],
                            'SyncStatus' => $this->updateSafe('tbl_member_household', $data['mobile_id'], $data)
                        );
                    }else{
                        $result[] = array(
                            'type' => 'insert',
                            'mobile_id' => $data['mobile_id'],
                            'SyncStatus' => $this->insertSafe('tbl_member_household', $data)
                        );
                    }
                }
                $response['member_household'] = $result;
            }    
        }else{
            $response['member_household'] = array();
        }


        $result = array();//reset result
        //Insert or update household_assets table
        if (!empty($inputs['household_assets'])) {
            foreach ($inputs['household_assets'] as $data) {
                unset($data['lid']);
                
                $data['insertedOn'] = date('Y-m-d H:i:s', strtotime($data['insertedOn']));
                $data['updatedOn'] = $this->isValidDate($data['updatedOn']) ? date('Y-m-d H:i:s', strtotime($data['updatedOn'])) : null;

                if (isset($data['household_master_id']) && isset($data['round_master_id'])) {
                    $isExists = $this->key_exists_household_round('tbl_household_assets', $data['household_master_id'], $data['round_master_id']);
                    if ($isExists) {
                        //update
                        unset($data['household_master_id']);
                        unset($data['round_master_id']);
                        $result[] = array(
                            'type' => 'update',
                            'mobile_id' => $data['mobile_id'],
                            'SyncStatus' => $this->updateSafe('tbl_household_assets', $data['mobile_id'], $data)
                        );
                    }else{
                        $result[] = array(
                            'type' => 'insert',
                            'mobile_id' => $data['mobile_id'],
                            'SyncStatus' => $this->insertSafe('tbl_household_assets', $data)
                        );
                    }
                }
                $response['household_assets'] = $result;
            }    
        }else{
            $response['household_assets'] = array();
        }


        $result = array();//reset result
        //Insert or update member_migration_in table
        if (!empty($inputs['member_migration_in'])) {
            foreach ($inputs['member_migration_in'] as $data) {
                unset($data['lid']);
                
                $data['movement_date'] = date('Y-m-d H:i:s', strtotime($data['movement_date']));
                $data['insertedOn'] = date('Y-m-d H:i:s', strtotime($data['insertedOn']));
                $data['updatedOn'] = $this->isValidDate($data['updatedOn']) ? date('Y-m-d H:i:s', strtotime($data['updatedOn'])) : null;

                if (isset($data['member_master_id']) && isset($data['round_master_id'])) {
                    $isExists = $this->key_exists_member_round('tbl_member_migration_in', $data['member_master_id'], $data['round_master_id']);
                    if ($isExists) {
                        //update
                        unset($data['member_master_id']);
                        unset($data['round_master_id']);
                        $result[] = array(
                            'type' => 'update',
                            'mobile_id' => $data['mobile_id'],
                            'SyncStatus' => $this->updateSafe('tbl_member_migration_in', $data['mobile_id'], $data)
                        );
                    }else{
                        $result[] = array(
                            'type' => 'insert',
                            'mobile_id' => $data['mobile_id'],
                            'SyncStatus' => $this->insertSafe('tbl_member_migration_in', $data)
                        );
                    }
                }
                $response['member_migration_in'] = $result;
            }    
        }else{
            $response['member_migration_in'] = array();
        }


        $result = array();//reset result
        //Insert or update member_migration_out table
        if (!empty($inputs['member_migration_out'])) {
            foreach ($inputs['member_migration_out'] as $data) {
                unset($data['lid']);
                
                $data['movement_date'] = date('Y-m-d H:i:s', strtotime($data['movement_date']));
                $data['insertedOn'] = date('Y-m-d H:i:s', strtotime($data['insertedOn']));
                $data['updatedOn'] = $this->isValidDate($data['updatedOn']) ? date('Y-m-d H:i:s', strtotime($data['updatedOn'])) : null;

                if (isset($data['member_master_id']) && isset($data['round_master_id'])) {
                    $isExists = $this->key_exists_member_round('tbl_member_migration_out', $data['member_master_id'], $data['round_master_id']);
                    if ($isExists) {
                        //update
                        unset($data['member_master_id']);
                        unset($data['round_master_id']);
                        $result[] = array(
                            'type' => 'update',
                            'mobile_id' => $data['mobile_id'],
                            'SyncStatus' => $this->updateSafe('tbl_member_migration_out', $data['mobile_id'], $data)
                        );
                    }else{
                        $result[] = array(
                            'type' => 'insert',
                            'mobile_id' => $data['mobile_id'],
                            'SyncStatus' => $this->insertSafe('tbl_member_migration_out', $data)
                        );
                    }
                }
                $response['member_migration_out'] = $result;
            }    
        }else{
            $response['member_migration_out'] = array();
        }


        $result = array();//reset result
        //Insert or update member_marriage_start table
        if (!empty($inputs['member_marriage_start'])) {
            foreach ($inputs['member_marriage_start'] as $data) {
                unset($data['lid']);
                
                $data['marriage_date'] = date('Y-m-d H:i:s', strtotime($data['marriage_date']));
                $data['insertedOn'] = date('Y-m-d H:i:s', strtotime($data['insertedOn']));
                $data['updatedOn'] = $this->isValidDate($data['updatedOn']) ? date('Y-m-d H:i:s', strtotime($data['updatedOn'])) : null;

                if (isset($data['member_master_id']) && isset($data['round_master_id'])) {
                    $isExists = $this->key_exists_member_round('tbl_member_marriage_start', $data['member_master_id'], $data['round_master_id']);
                    if ($isExists) {
                        //update
                        unset($data['member_master_id']);
                        unset($data['round_master_id']);
                        $result[] = array(
                            'type' => 'update',
                            'mobile_id' => $data['mobile_id'],
                            'SyncStatus' => $this->updateSafe('tbl_member_marriage_start', $data['mobile_id'], $data)
                        );
                    }else{
                        $result[] = array(
                            'type' => 'insert',
                            'mobile_id' => $data['mobile_id'],
                            'SyncStatus' => $this->insertSafe('tbl_member_marriage_start', $data)
                        );
                    }
                }
                $response['member_marriage_start'] = $result;
            }    
        }else{
            $response['member_marriage_start'] = array();
        }


        $result = array();//reset result
        //Insert or update member_marriage_end table
        if (!empty($inputs['member_marriage_end'])) {
            foreach ($inputs['member_marriage_end'] as $data) {
                unset($data['lid']);
                
                $data['marriage_end_date'] = date('Y-m-d H:i:s', strtotime($data['marriage_end_date']));
                $data['insertedOn'] = date('Y-m-d H:i:s', strtotime($data['insertedOn']));
                $data['updatedOn'] = $this->isValidDate($data['updatedOn']) ? date('Y-m-d H:i:s', strtotime($data['updatedOn'])) : null;

                if (isset($data['member_master_id']) && isset($data['round_master_id'])) {
                    $isExists = $this->key_exists_member_round('tbl_member_marriage_end', $data['member_master_id'], $data['round_master_id']);
                    if ($isExists) {
                        //update
                        unset($data['member_master_id']);
                        unset($data['round_master_id']);
                        $result[] = array(
                            'type' => 'update',
                            'mobile_id' => $data['mobile_id'],
                            'SyncStatus' => $this->updateSafe('tbl_member_marriage_end', $data['mobile_id'], $data)
                        );
                    }else{
                        $result[] = array(
                            'type' => 'insert',
                            'mobile_id' => $data['mobile_id'],
                            'SyncStatus' => $this->insertSafe('tbl_member_marriage_end', $data)
                        );
                    }
                }
                $response['member_marriage_end'] = $result;
            }    
        }else{
            $response['member_marriage_end'] = array();
        }


        $result = array();//reset result
        //Insert or update member_conception table
        if (!empty($inputs['member_conception'])) {
            foreach ($inputs['member_conception'] as $data) {
                unset($data['lid']);
                
                $data['conception_date'] = date('Y-m-d H:i:s', strtotime($data['conception_date']));
                $data['insertedOn'] = date('Y-m-d H:i:s', strtotime($data['insertedOn']));
                $data['updatedOn'] = $this->isValidDate($data['updatedOn']) ? date('Y-m-d H:i:s', strtotime($data['updatedOn'])) : null;

                if (isset($data['mobile_id'])) {
                    $isExists = $this->key_exists('mobile_id', $data['mobile_id'], 'tbl_member_conception');
                    if ($isExists) {
                        //update
                        $result[] = array(
                            'type' => 'update',
                            'mobile_id' => $data['mobile_id'],
                            'SyncStatus' => $this->updateSafe('tbl_member_conception', $data['mobile_id'], $data)
                        );
                    }else{
                        $result[] = array(
                            'type' => 'insert',
                            'mobile_id' => $data['mobile_id'],
                            'SyncStatus' => $this->insertSafe('tbl_member_conception', $data)
                        );
                    }
                }
                $response['member_conception'] = $result;
            }    
        }else{
            $response['member_conception'] = array();
        }


        $result = array();//reset result
        //Insert or update member_pregnancy table
        if (!empty($inputs['member_pregnancy'])) {
            foreach ($inputs['member_pregnancy'] as $data) {
                unset($data['lid']);
                
                $data['pregnancy_outcome_date'] = date('Y-m-d H:i:s', strtotime($data['pregnancy_outcome_date']));
                $data['insertedOn'] = date('Y-m-d H:i:s', strtotime($data['insertedOn']));
                $data['updatedOn'] = $this->isValidDate($data['updatedOn']) ? date('Y-m-d H:i:s', strtotime($data['updatedOn'])) : null;

                if (isset($data['member_master_id']) && isset($data['round_master_id'])) {
                    $isExists = $this->key_exists_member_round('tbl_member_pregnancy', $data['member_master_id'], $data['round_master_id']);
                    if ($isExists) {
                        //update
                        unset($data['member_master_id']);
                        unset($data['round_master_id']);
                        $result[] = array(
                            'type' => 'update',
                            'mobile_id' => $data['mobile_id'],
                            'SyncStatus' => $this->updateSafe('tbl_member_pregnancy', $data['mobile_id'], $data)
                        );
                    }else{
                        $result[] = array(
                            'type' => 'insert',
                            'mobile_id' => $data['mobile_id'],
                            'SyncStatus' => $this->insertSafe('tbl_member_pregnancy', $data)
                        );
                    }
                }
                $response['member_pregnancy'] = $result;
            }    
        }else{
            $response['member_pregnancy'] = array();
        }


        $result = array();//reset result
        //Insert or update member_education table
        if (!empty($inputs['member_education'])) {
            foreach ($inputs['member_education'] as $data) {
                unset($data['lid']);
                
                $data['insertedOn'] = date('Y-m-d H:i:s', strtotime($data['insertedOn']));
                $data['updatedOn'] = $this->isValidDate($data['updatedOn']) ? date('Y-m-d H:i:s', strtotime($data['updatedOn'])) : null;

                if (isset($data['member_master_id']) && isset($data['round_master_id'])) {
                    $isExists = $this->key_exists_member_round('tbl_member_education', $data['member_master_id'], $data['round_master_id']);
                    if ($isExists) {
                        //update
                        unset($data['member_master_id']);
                        unset($data['round_master_id']);
                        $result[] = array(
                            'type' => 'update',
                            'mobile_id' => $data['mobile_id'],
                            'SyncStatus' => $this->updateSafe('tbl_member_education', $data['mobile_id'], $data)
                        );
                    }else{
                        $result[] = array(
                            'type' => 'insert',
                            'mobile_id' => $data['mobile_id'],
                            'SyncStatus' => $this->insertSafe('tbl_member_education', $data)
                        );
                    }
                }
                $response['member_education'] = $result;
            }    
        }else{
            $response['member_education'] = array();
        }


        $result = array();//reset result
        //Insert or update member_relation table
        if (!empty($inputs['member_relation'])) {
            foreach ($inputs['member_relation'] as $data) {
                unset($data['lid']);
                
                $data['insertedOn'] = date('Y-m-d H:i:s', strtotime($data['insertedOn']));
                $data['updatedOn'] = $this->isValidDate($data['updatedOn']) ? date('Y-m-d H:i:s', strtotime($data['updatedOn'])) : null;

                if (isset($data['member_master_id']) && isset($data['round_master_id'])) {
                    $isExists = $this->key_exists_member_round('tbl_member_relation', $data['member_master_id'], $data['round_master_id']);
                    if ($isExists) {
                        //update
                        unset($data['member_master_id']);
                        unset($data['round_master_id']);
                        $result[] = array(
                            'type' => 'update',
                            'mobile_id' => $data['mobile_id'],
                            'SyncStatus' => $this->updateSafe('tbl_member_relation', $data['mobile_id'], $data)
                        );
                    }else{
                        $result[] = array(
                            'type' => 'insert',
                            'mobile_id' => $data['mobile_id'],
                            'SyncStatus' => $this->insertSafe('tbl_member_relation', $data)
                        );
                    }
                }
                $response['member_relation'] = $result;
            }    
        }else{
            $response['member_relation'] = array();
        }


        $result = array();//reset result
        //Insert or update member_death table
        if (!empty($inputs['member_death'])) {
            foreach ($inputs['member_death'] as $data) {
                unset($data['lid']);
                
                $data['death_date'] = $this->isValidDate($data['death_date']) ? date('Y-m-d H:i:s', strtotime($data['death_date'])) : null;
                $data['insertedOn'] = date('Y-m-d H:i:s', strtotime($data['insertedOn']));
                $data['updatedOn'] = $this->isValidDate($data['updatedOn']) ? date('Y-m-d H:i:s', strtotime($data['updatedOn'])) : null;

                if (isset($data['member_master_id']) && isset($data['round_master_id'])) {
                    $isExists = $this->key_exists_member_round('tbl_member_death', $data['member_master_id'], $data['round_master_id']);
                    if ($isExists) {
                        //update
                        unset($data['member_master_id']);
                        unset($data['round_master_id']);
                        $result[] = array(
                            'type' => 'update',
                            'mobile_id' => $data['mobile_id'],
                            'SyncStatus' => $this->updateSafe('tbl_member_death', $data['mobile_id'], $data)
                        );
                    }else{
                        $result[] = array(
                            'type' => 'insert',
                            'mobile_id' => $data['mobile_id'],
                            'SyncStatus' => $this->insertSafe('tbl_member_death', $data)
                        );
                    }
                }
                $response['member_death'] = $result;
            }    
        }else{
            $response['member_death'] = array();
        }


        $result = array();//reset result
        //Insert or update member_occupation table
        if (!empty($inputs['member_occupation'])) {
            foreach ($inputs['member_occupation'] as $data) {
                unset($data['lid']);
                
                $data['insertedOn'] = date('Y-m-d H:i:s', strtotime($data['insertedOn']));
                $data['updatedOn'] = $this->isValidDate($data['updatedOn']) ? date('Y-m-d H:i:s', strtotime($data['updatedOn'])) : null;

                if (isset($data['member_master_id']) && isset($data['round_master_id'])) {
                    $isExists = $this->key_exists_member_round('tbl_member_occupation', $data['member_master_id'], $data['round_master_id']);
                    if ($isExists) {
                        //update
                        unset($data['member_master_id']);
                        unset($data['round_master_id']);
                        $result[] = array(
                            'type' => 'update',
                            'mobile_id' => $data['mobile_id'],
                            'SyncStatus' => $this->updateSafe('tbl_member_occupation', $data['mobile_id'], $data)
                        );
                    }else{
                        $result[] = array(
                            'type' => 'insert',
                            'mobile_id' => $data['mobile_id'],
                            'SyncStatus' => $this->insertSafe('tbl_member_occupation', $data)
                        );
                    }
                }
                $response['member_occupation'] = $result;
            }    
        }else{
            $response['member_occupation'] = array();
        }


        $result = array();//reset result
        //Insert or update household_head table
        if (!empty($inputs['household_head'])) {
            foreach ($inputs['household_head'] as $data) {
                unset($data['lid']);
                
                $data['change_date'] = date('Y-m-d H:i:s', strtotime($data['change_date']));
                $data['insertedOn'] = date('Y-m-d H:i:s', strtotime($data['insertedOn']));
                $data['updatedOn'] = $this->isValidDate($data['updatedOn']) ? date('Y-m-d H:i:s', strtotime($data['updatedOn'])) : null;

                if (isset($data['mobile_id'])) {
                    $isExists = $this->key_exists('mobile_id', $data['mobile_id'], 'tbl_household_head');
                    if ($isExists) {
                        //update
                        $result[] = array(
                            'type' => 'update',
                            'mobile_id' => $data['mobile_id'],
                            'SyncStatus' => $this->updateSafe('tbl_household_head', $data['mobile_id'], $data)
                        );
                    }else{
                        $result[] = array(
                            'type' => 'insert',
                            'mobile_id' => $data['mobile_id'],
                            'SyncStatus' => $this->insertSafe('tbl_household_head', $data)
                        );
                    }
                }
                $response['household_head'] = $result;
            }    
        }else{
            $response['household_head'] = array();
        }


        $result = array();//reset result
        //Insert or update member_immunization table
        if (!empty($inputs['member_immunization'])) {
            foreach ($inputs['member_immunization'] as $data) {
                unset($data['lid']);
                
                $data['BCG'] = $this->isValidDate($data['BCG']) ? date('Y-m-d H:i:s', strtotime($data['BCG'])) : null;
                $data['PENTA1'] = $this->isValidDate($data['PENTA1']) ? date('Y-m-d H:i:s', strtotime($data['PENTA1'])) : null;
                $data['PENTA2'] = $this->isValidDate($data['PENTA2']) ? date('Y-m-d H:i:s', strtotime($data['PENTA2'])) : null;
                $data['PENTA3'] = $this->isValidDate($data['PENTA3']) ? date('Y-m-d H:i:s', strtotime($data['PENTA3'])) : null;
                $data['PCV1'] = $this->isValidDate($data['PCV1']) ? date('Y-m-d H:i:s', strtotime($data['PCV1'])) : null;
                $data['PCV2'] = $this->isValidDate($data['PCV2']) ? date('Y-m-d H:i:s', strtotime($data['PCV2'])) : null;
                $data['PPV3'] = $this->isValidDate($data['PPV3']) ? date('Y-m-d H:i:s', strtotime($data['PPV3'])) : null;
                $data['OPV1'] = $this->isValidDate($data['OPV1']) ? date('Y-m-d H:i:s', strtotime($data['OPV1'])) : null;
                $data['OPV2'] = $this->isValidDate($data['OPV2']) ? date('Y-m-d H:i:s', strtotime($data['OPV2'])) : null;
                $data['OPV3'] = $this->isValidDate($data['OPV3']) ? date('Y-m-d H:i:s', strtotime($data['OPV3'])) : null;
                $data['MR1'] = $this->isValidDate($data['MR1']) ? date('Y-m-d H:i:s', strtotime($data['MR1'])) : null;
                $data['MR2'] = $this->isValidDate($data['MR2']) ? date('Y-m-d H:i:s', strtotime($data['MR2'])) : null;
                $data['FIPV1'] = $this->isValidDate($data['FIPV1']) ? date('Y-m-d H:i:s', strtotime($data['FIPV1'])) : null;
                $data['FIPV2'] = $this->isValidDate($data['FIPV2']) ? date('Y-m-d H:i:s', strtotime($data['FIPV2'])) : null;
                $data['FIPV3'] = $this->isValidDate($data['FIPV3']) ? date('Y-m-d H:i:s', strtotime($data['FIPV3'])) : null;
                $data['VITA1'] = $this->isValidDate($data['VITA1']) ? date('Y-m-d H:i:s', strtotime($data['VITA1'])) : null;
                $data['VITA2'] = $this->isValidDate($data['VITA2']) ? date('Y-m-d H:i:s', strtotime($data['VITA2'])) : null;

                $data['insertedOn'] = date('Y-m-d H:i:s', strtotime($data['insertedOn']));
                $data['updatedOn'] = $this->isValidDate($data['updatedOn']) ? date('Y-m-d H:i:s', strtotime($data['updatedOn'])) : null;

                if (isset($data['member_master_id']) && isset($data['round_master_id'])) {
                    $isExists = $this->key_exists_member_round('tbl_member_immunization', $data['member_master_id'], $data['round_master_id']);
                    if ($isExists) {
                        //update
                        unset($data['member_master_id']);
                        unset($data['round_master_id']);
                        $result[] = array(
                            'type' => 'update',
                            'mobile_id' => $data['mobile_id'],
                            'SyncStatus' => $this->updateSafe('tbl_member_immunization', $data['mobile_id'], $data)
                        );
                    }else{
                        $result[] = array(
                            'type' => 'insert',
                            'mobile_id' => $data['mobile_id'],
                            'SyncStatus' => $this->insertSafe('tbl_member_immunization', $data)
                        );
                    }
                }
                $response['member_immunization'] = $result;
            }    
        }else{
            $response['member_immunization'] = array();
        }


        $result = array();//reset result
        //Insert or update family_planning table
        if (!empty($inputs['family_planning'])) {
            foreach ($inputs['family_planning'] as $data) {
                unset($data['lid']);
                
                $data['insertedOn'] = date('Y-m-d H:i:s', strtotime($data['insertedOn']));
                $data['updatedOn'] = $this->isValidDate($data['updatedOn']) ? date('Y-m-d H:i:s', strtotime($data['updatedOn'])) : null;

                if (isset($data['member_master_id']) && isset($data['round_master_id'])) {
                    $isExists = $this->key_exists_member_round('tbl_member_family_planning', $data['member_master_id'], $data['round_master_id']);
                    if ($isExists) {
                        //update
                        unset($data['member_master_id']);
                        unset($data['round_master_id']);
                        $result[] = array(
                            'type' => 'update',
                            'mobile_id' => $data['mobile_id'],
                            'SyncStatus' => $this->updateSafe('tbl_member_family_planning', $data['mobile_id'], $data)
                        );
                    }else{
                        $result[] = array(
                            'type' => 'insert',
                            'mobile_id' => $data['mobile_id'],
                            'SyncStatus' => $this->insertSafe('tbl_member_family_planning', $data)
                        );
                    }
                }
                $response['family_planning'] = $result;
            }    
        }else{
            $response['family_planning'] = array();
        }


        $result = array();//reset result
        //Insert or update child_illness table
        if (!empty($inputs['child_illness'])) {
            foreach ($inputs['child_illness'] as $data) {
                unset($data['lid']);
                
                $data['diarrhoea_start_date'] = $this->isValidDate($data['diarrhoea_start_date']) ? date('Y-m-d H:i:s', strtotime($data['diarrhoea_start_date'])) : null;
                $data['pneumonia_start_date'] = $this->isValidDate($data['pneumonia_start_date']) ? date('Y-m-d H:i:s', strtotime($data['pneumonia_start_date'])) : null;
                $data['insertedOn'] = $this->isValidDate($data['insertedOn']) ? date('Y-m-d H:i:s', strtotime($data['insertedOn'])) : null;
                $data['updatedOn'] = $this->isValidDate($data['updatedOn']) ? date('Y-m-d H:i:s', strtotime($data['updatedOn'])) : null;

                if (isset($data['member_master_id']) && isset($data['round_master_id'])) {
                    $isExists = $this->key_exists_member_round('tbl_member_child_illness', $data['member_master_id'], $data['round_master_id']);
                    if ($isExists) {
                        //update
                        unset($data['member_master_id']);
                        unset($data['round_master_id']);
                        $result[] = array(
                            'type' => 'update',
                            'mobile_id' => $data['mobile_id'],
                            'SyncStatus' => $this->updateSafe('tbl_member_child_illness', $data['mobile_id'], $data)
                        );
                    }else{
                        $result[] = array(
                            'type' => 'insert',
                            'mobile_id' => $data['mobile_id'],
                            'SyncStatus' => $this->insertSafe('tbl_member_child_illness', $data)
                        );
                    }
                }
                $response['child_illness'] = $result;
            }    
        }else{
            $response['child_illness'] = array();
        }


        $result = array();//reset result
        //Insert or update household_visit table
        if (!empty($inputs['household_visit'])) {
            foreach ($inputs['household_visit'] as $data) {
                unset($data['lid']);
                
                $data['interview_date'] = $this->isValidDate($data['interview_date']) ? date('Y-m-d H:i:s', strtotime($data['interview_date'])) : null;
                $data['split_date'] = $this->isValidDate($data['split_date']) ? date('Y-m-d H:i:s', strtotime($data['split_date'])) : null;
                $data['merge_date'] = $this->isValidDate($data['merge_date']) ? date('Y-m-d H:i:s', strtotime($data['merge_date'])) : null;
                $data['insertedOn'] = date('Y-m-d H:i:s', strtotime($data['insertedOn']));
                $data['updatedOn'] = $this->isValidDate($data['updatedOn']) ? date('Y-m-d H:i:s', strtotime($data['updatedOn'])) : null;

                $this->db->where('household_master_id', $data['household_master_id']);
                $this->db->where('round_master_id', $data['round_master_id']);
                $query = $this->db->get('tbl_household_visit');
                if ($query->num_rows() > 0){
                    //update
                    unset($data['household_master_id']);
                    unset($data['round_master_id']);
                    $result[] = array(
                        'type' => 'update',
                        'mobile_id' => $data['mobile_id'],
                        'SyncStatus' => $this->updateSafe('tbl_household_visit', $data['mobile_id'], $data)
                    );
                }
                else{
                    $result[] = array(
                        'type' => 'insert',
                        'mobile_id' => $data['mobile_id'],
                        'SyncStatus' => $this->insertSafe('tbl_household_visit', $data)
                    );
                }
                $response['household_visit'] = $result;
            }    
        }else{
            $response['household_visit'] = array();
        }



        $result = array();//reset result
        //Insert or update baseline_census table
        if (!empty($inputs['baseline_census'])) {
            foreach ($inputs['baseline_census'] as $data) {
                unset($data['lid']);
                
                $data['pregnancy_status_since_when'] = $this->isValidDate($data['pregnancy_status_since_when']) ? date('Y-m-d H:i:s', strtotime($data['pregnancy_status_since_when'])) : null;
                $data['insertedOn'] = date('Y-m-d H:i:s', strtotime($data['insertedOn']));
                $data['updatedOn'] = $this->isValidDate($data['updatedOn']) ? date('Y-m-d H:i:s', strtotime($data['updatedOn'])) : null;
                
                if (isset($data['household_master_id']) && isset($data['round_master_id'])) {
                    $isExists = $this->key_exists_household_round('tbl_baseline_census', $data['household_master_id'], $data['round_master_id']);
                    if ($isExists) {
                        //update
                        unset($data['household_master_id']);
                        unset($data['round_master_id']);
                        $result[] = array(
                            'type' => 'update',
                            'mobile_id' => $data['mobile_id'],
                            'SyncStatus' => $this->updateSafe('tbl_baseline_census', $data['mobile_id'], $data)
                        );
                    }else{
                        $result[] = array(
                            'type' => 'insert',
                            'mobile_id' => $data['mobile_id'],
                            'SyncStatus' => $this->insertSafe('tbl_baseline_census', $data)
                        );
                    }
                }
                $response['baseline_census'] = $result;
            }    
        }else{
            $response['baseline_census'] = array();
        }

        $this->response($response, REST_Controller::HTTP_OK);
    }
}