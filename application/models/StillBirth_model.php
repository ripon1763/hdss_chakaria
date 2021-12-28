<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class StillBirth_model extends CI_Model {
    
    function getLookUpInfo()
    {
        $this->db->select('a.ID as id, a.CODE as code, a.NAME as name');
        $this->db->from('lookup_details_va as a');
        $this->db->where('a.ACTIVE', 'Yes');
        $this->db->order_by('a.DISPLAY_ORDER', 'asc');
        $query = $this->db->get()->result();

        foreach($query as $key=> $value)
        {
            $data[$value->id] = json_encode(['name'=>$value->name,'code'=>$value->code]);
        }

       return $data;
    }

    function listing($tableName) {
        $this->db->from($tableName);
        $query = $this->db->get();

        return $query->result();
    }
    
    function UpdateInfo($IDInfo,$id, $table) {
        $this->db->where('ID', $id);
        return $this->db->update($table, $IDInfo);
    }
    
    function getLookUpList($lookup_master_code)
    {
        $this->db->select('a.ID as id, a.CODE as code, a.NAME as name');
        $this->db->from('lookup_details_va as a');
        $this->db->join('lookup_master_va b', 'b.ID = a.LOOKUP_MASTER_ID', 'inner');
        $this->db->where('b.CODE', $lookup_master_code);
        $this->db->where('a.ACTIVE', 'Yes');
        $this->db->order_by('a.DISPLAY_ORDER', 'asc');
       
        $query = $this->db->get();
		
        return $query->result();
    }
    
    function getListInfo($id,$tableName){
        $this->db->from($tableName);
        $this->db->where('id',$id);
        $query = $this->db->get();

        return $query->row();
    }
    
    function stillBirthListing($tableName)
    {

        // $columnsArray = ['MEMBER_CODE','MEMBER_NAME','BIRTH_DATE','HOUSEHOLD_CODE','NAME','DEATH_DATE','Q1_1_N1','Q1_1_N2','Q1_1_N3','Q1_1_R1','Q1_1_R2','Q1_1_R3','Q1_1_P1','Q1_1_P2','Q1_1_P3','Q1_1_R1_other','Q1_1_R2_other','Q1_1_R3_other','Q1_2_LINE','Q1_2_SEX','Q1_3_REL','Q1_3_REL_OTHER','Q1_4_AGE','Q1_5_EDU','Q1_6','Q1_6a','Q1_6_1','Q1_6_2','Q1_6_2_DAY_OR_MONTH','Q2_1_INTV_NAME','Q2_1_INTV_CODE','Q2_1_INTV_LANGUAGE','Q2_2_INTV_DATE','Q2_3_1ST_INTV_DATE','Q2_4_2ND_INTV_DATE','Q3_1_DNAME','Q3_2_RID','Q3_2_CID','Q3_2_1_NID','Q3_3_V_NAME','Q3_4_B_CODE','Q3_4_B_NAME','Q3_5_DOB','Q3_6_DOD','Q3_7_AGE_Y','Q3_8_SEX','Q3_9_MSTATUS','Q3_9_1_MD','Q3_9_2_DOM','Q3_10_EDU','Q3_10_1','Q3_10_2_ES','Q3_11_CODE','Q4_1_death_reasons','Q4_2_A','Q4_2_B','Q4_2_C','Q4_2_D','Q4_2_E','Q4_2_F','Q4_2_F_SPECIFY','Q4_2_G','Q4_2_H','Q4_2_I','Q4_2_J','Q4_2_K','Q4_2_L','Q4_2_M','Q4_2_N','Q4_2_O','Q4_2_P','Q4_2_Q','Q4_2_R','Q4_2_S','Q4_2_T','Q4_2_U','Q4_2_V','Q4_2_W','Q4_2_X','Q4_2_Y','Q4_2_Z','Q4_2_Z_OTHER','Q4_3_M','Q4_3_D','Q4_4','Q5_1','Q5_1_1','Q5_1_1_OTHER','Q5_1_2','Q5_1_2_OTHER','Q5_1_3','Q5_1_3_OTHER','Q5_1_4_D','Q5_1_4_H','Q5_1_5','Q5_1_8','Q6_1','Q6_1_1','Q6_1_2','Q6_1_3','Q6_1_4_D','Q6_1_5','Q6_1_6','Q6_1_7','Q6_1_8','Q6_1_8_OTHER','Q6_1_9_0','Q6_1_9_1','Q6_1_9_2','Q6_1_9_3_alive','Q6_1_9_3_dead','Q6_1_9_3_Normal_delivery','Q6_1_9_4','Q6_1_9_5','Q6_2_1','Q6_2_2_M','Q6_2_2_D','Q6_2_3','Q6_2_4','Q6_2_5','Q6_2_6','Q6_2_7','Q6_3_1','Q6_3_2_M','Q6_3_2_D','Q6_3_3','Q6_3_3_OTHER','Q6_3_4','Q6_3_4_OTHER','Q6_3_5','Q6_3_6','Q6_3_6_OTHER','Q6_3_7','Q6_3_8','Q6_3_9','Q6_3_10_A','Q6_3_10_B','Q6_3_10_C','Q6_3_10_D','Q6_3_10_E','Q6_3_10_E_OTHER','Q6_3_11','Q6_3_12','Q6_3_13','Q6_3_14','Q6_3_15_A','Q6_3_15_B','Q6_3_15_C','Q6_3_15_D','Q6_3_15_E','Q6_3_15_F','Q6_3_15_F_OTHER','Q6_3_16_Y','Q6_3_16_M','Q6_3_17','Q6_3_18_Y','Q6_3_18_M','Q6_3_19','Q6_3_20','Q6_3_20_OTHER','Q6_3_21','Q6_3_22','Q6_3_22_OTHER','Q6_3_23','Q6_4','Q6_4a','Q6_4b','Q6_4c','Q6_4d_M','Q6_4d_D','Q6_4_1','Q6_4_2','Q6_4_3','Q6_4_4_M','Q6_4_4_D','Q6_4_5_A','Q6_4_5_B','Q6_4_5_C','Q6_4_5_D','Q6_4_5_E','Q6_4_5_F','Q6_4_5_G','Q6_4_5_G_OTHER','Q6_4_6','Q6_5_1','Q6_5_1_1','Q6_5_2_M','Q6_5_2_D','Q6_5_3','Q6_5_4','Q6_5_5','Q6_6_1','Q6_6_2_A','Q6_6_2_B','Q6_6_2_C','Q6_6_2_D','Q6_6_2_E','Q6_6_2_F','Q6_6_2_F_OTHER','Q6_6_3','Q6_6_3_OTHER','Q6_6_3_1','Q6_6_3_2_M','Q6_6_3_2_D','Q6_6_4_A','Q6_6_4_B','Q6_6_4_C','Q6_6_4_D','Q6_6_4_E','Q6_6_4_E_OTHER','Q6_6_5_M','Q6_6_5_D','Q6_6_6','Q6_6_7','Q6_7_1','Q6_7_1a','Q6_7_2_M','Q6_7_2_D','Q6_7_3','Q6_7_4','Q6_7_5','Q6_7_6','Q6_7_7','Q6_8_1','Q6_8_2_M','Q6_8_2_D','Q6_8_3','Q6_8_4_M','Q6_8_4_D','Q6_8_4_1','Q6_8_4_2_M','Q6_8_4_2_D','Q6_8_5','Q6_8_6','Q6_8_7','Q6_8_8','Q6_8_9','Q6_8_10','Q6_8_11','Q6_8_12','Q6_8_13','Q6_8_14','Q6_9_1','Q6_9_2','Q6_9_3','Q6_9_4','Q6_9_5','Q6_9_6','Q6_9_6_1','Q6_9_7','Q6_9_8','Q6_9_8_OTHER','Q6_10_1','Q6_10_2_D','Q6_10_2_H','Q6_10_3','Q6_10_3_OTHER','Q6_10_4','Q6_11_1','Q6_11_2','Q6_11_2_OTHER','Q6_11_3','Q6_11_3_OTHER','Q6_11_4','Q6_11_5_D','Q6_11_5_H','Q6_12_1','Q6_12_1a','Q6_12_2_D','Q6_12_2_H','Q6_12_3','Q6_12_4','Q6_13_1','Q6_13_2','Q6_13_2_OTHER','Q6_13_3','Q6_14_1','Q6_14_2','Q6_14_3_M','Q6_14_3_D','Q6_15_1','Q6_15_2','Q6_15_3_M','Q6_15_3_D','Q6_15_4','Q6_15_5','Q6_16','Q6_16a','Q6_16b','Q6_16_1','Q6_16_2','Q6_16_3','Q6_16_4','Q6_17_1','Q6_17_2_D','Q6_17_2_H','Q6_17_3','Q6_17_4_D','Q6_17_4_H','Q6_17_5','Q6_17_6','Q6_18_1','Q6_18_2','Q6_18_2_OTHER','Q6_18_3_Y','Q6_18_3_M','Q6_18_3_D','Q6_19_1','Q6_19_2','Q6_19_3','Q6_20_1','Q6_20_2','Q6_20_3','Q6_20_4a','Q6_20_4b','Q6_20_5_A','Q6_20_5_B','Q6_20_5_C','Q6_20_5_D','Q6_20_5_D_OTHER','Q6_21_1','Q6_21_2_M','Q6_21_2_D','Q6_21_3','Q7_1','Q7_1_1_A','Q7_1_1_A_OTHER','Q7_1_1_B','Q7_1_1_B_OTHER','Q7_1_1_C','Q7_1_1_C_OTHER','Q7_1_1_D','Q7_1_1_D_OTHER','Q7_1_2','Q7_1_2_OTHER','Q7_1_3_A','Q7_1_3_B','Q7_1_3_C','Q7_1_3_D','Q7_1_3_E','Q7_1_3_F','Q7_1_3_F_OTHER','Q7_1_4','Q7_2','Q7_2_1_1_HCODE','Q7_2_1_1_DATE','Q7_2_1_1_CAUSE','Q7_2_1_2_HCODE','Q7_2_1_2_DATE','Q7_2_1_2_CAUSE','Q7_2_1_3_HCODE','Q7_2_1_3_DATE','Q7_2_1_3_CAUSE','Q7_2_2','Q7_2_3_A','Q7_2_3_B','Q7_2_3_C','Q7_2_3_D','Q7_2_3_D_OTHER','Q7_2_4','Q7_2_5','Q7_2_6','Q7_2_7','Q7_3','Q7_3_OTHER','Q7_3_1_Hname_Haddress','Q7_3_2','Q7_3_3','Q7_3_3_OTHER','Q7_3_4','Q8_1','Q8_1_1','Q8_1_1_SYMP','Q8_1_1_DIAG','Q8_1_1_TRET','Q8_1_2_weight_1','Q8_1_2_weight_2','Q8_1_3_A','Q8_1_3_B','Q8_1_3_C','Q8_1_3_D','Q8_1_3_E','Q8_1_3_F','Q8_1_3_G','Q8_1_3_H','Q8_1_3_I','Q8_1_3_J','Q8_1_3_J_OTHER','Q8_2_1','Q8_2_2_ICAUSE','Q8_2_2_ICODE','Q8_2_2_ACAUSE','Q8_2_2_ACODE','Q8_2_2_UCAUSE','Q8_2_2_UCODE','Q8_2_2_CCAUSE','Q8_2_2_CCODE','Q8_2_3','Q8_2_4','Q8_2_5','Q8_3','Q8_3_1','Q8_3_2','Q8_3_3','Q10_INTERVIEW','Q10_CSQ','Q10_AOC','Q10_SO','Q10_DOE','Q10_SUP_CODE'];
        $columnsArray = ['a.id','member_pregnancy_id','member_code','member_name','birth_date','household_code','NAME','Q1_1_N1','Q1_6','Q1_7','Q1_8','Q1_1_CID','Q1_1_LPODT','Q1_2','Q1_3','Q1_4','Q1_4_DAY_OR_MONTH','Q1_5a','Q1_5b','Q1_9','Q1_10','Q1_11','Q1_12','Q1_13','Q1_13_kg','Q1_14','Q1_15','Q1_15_OTHER','Q2_A','Q2_B','Q2_C','Q2_D','Q2_E','Q2_F','Q2_G','Q2_G_OTHER','Q2_1_1','Q2_1_2','Q2_1_3','Q2_1_4','Q2_1_5','Q2_1_6','Q2_1_7','Q2_1_8','Q2_1_9','Q2_1_10','Q2_1_11','Q2_1_12','Q2_1_13','Q2_1_14','Q2_1_15','Q2_1_16','Q2_1_17','Q2_1_18','Q2_1_19','Q2_1_20','Q2_1_21','Q2_1_22','Q2_1_23','Q2_1_23_OTHER','Q2_2','Q2_3','Q2_4_A','Q2_4_B','Q2_4_C','Q2_5_alive','Q2_5_dead','Q2_5_mr','Q2_6_DATE','Q2_7','Q2_8','Q2_9','Q2_10','Q2_10_DAY_OR_HOUR','Q2_11','Q2_12','Q2_12_OTHER','Q2_13','Q2_14','Q2_14_comment','Q2_14_DOE','Q2_14_SUP_CODE'];

        // $columns = implode(',', $columnsArray );
        // $this->db->select($columns);
        // $this->db->from($tableName .' as a');
        // $this->db->join('member_master as m','m.id= a.MEMBER_MASTER_ID');
        // $this->db->join('household_master as h','h.id= a.HOUSEHOLD_MASTER_ID');
        // $this->db->join('member_death_extended as de','de.member_death_id= a.ID');
        // $this->db->join('user_info as ui','ui.ID= a.CREATED_BY');
        // $this->db->where('a.VA_TYPE',4);
        // $query = $this->db->get();
        // return $query->result();

        $columns = implode(',', $columnsArray );
        $this->db->select($columns);
        $this->db->from($tableName .' as a');
        $this->db->join('tbl_member_pregnancy as mp','mp.id= a.member_pregnancy_id');
        $this->db->join('tbl_member_master as m','m.id= mp.member_master_id');
        $this->db->join('household_master as h','h.id= mp.household_master_id');
        $this->db->join('tbl_users as ui','ui.userId= a.insertedBy');
        $query = $this->db->get();
        return $query->result();
    }


    function getstillBirthFields()
    {
       $data = ['Q1_1_N1','Q1_6','Q1_7','Q1_8','Q1_1_CID','Q1_1_LPODT','Q1_2','Q1_3','Q1_4','Q1_4_DAY_OR_MONTH','Q1_5a','Q1_5b','Q1_9','Q1_10','Q1_11','Q1_12','Q1_13','Q1_13_kg','Q1_14','Q1_15','Q1_15_OTHER','Q2_A','Q2_B','Q2_C','Q2_D','Q2_E','Q2_F','Q2_G','Q2_G_OTHER','Q2_1_1','Q2_1_2','Q2_1_3','Q2_1_4','Q2_1_5','Q2_1_6','Q2_1_7','Q2_1_8','Q2_1_9','Q2_1_10','Q2_1_11','Q2_1_12','Q2_1_13','Q2_1_14','Q2_1_15','Q2_1_16','Q2_1_17','Q2_1_18','Q2_1_19','Q2_1_20','Q2_1_21','Q2_1_22','Q2_1_23','Q2_1_23_OTHER','Q2_2','Q2_3','Q2_4_A','Q2_4_B','Q2_4_C','Q2_5_alive','Q2_5_dead','Q2_5_mr','Q2_6_DATE','Q2_7','Q2_8','Q2_9','Q2_10','Q2_10_DAY_OR_HOUR','Q2_11','Q2_12','Q2_12_OTHER','Q2_13','Q2_14','Q2_14_comment','Q2_14_DOE','Q2_14_SUP_CODE'];
       return $data;
    }

    function getstillBirthExtFields()
    {
        $data = ['Q1_1_CID','Q1_1_LPODT','Q1_2','Q1_3','Q1_4','Q1_4_DAY_OR_MONTH','Q1_5a','Q1_5b','Q1_9','Q1_10','Q1_11','Q1_12','Q1_13','Q1_13_kg','Q1_14','Q1_15','Q1_15_OTHER','Q2_A','Q2_B','Q2_C','Q2_D','Q2_E','Q2_F','Q2_G','Q2_G_OTHER','Q2_1_1','Q2_1_2','Q2_1_3','Q2_1_4','Q2_1_5','Q2_1_6','Q2_1_7','Q2_1_8','Q2_1_9','Q2_1_10','Q2_1_11','Q2_1_12','Q2_1_13','Q2_1_14','Q2_1_15','Q2_1_16','Q2_1_17','Q2_1_18','Q2_1_19','Q2_1_20','Q2_1_21','Q2_1_22','Q2_1_23','Q2_1_23_OTHER','Q2_2','Q2_3','Q2_4_A','Q2_4_B','Q2_4_C','Q2_5_alive','Q2_5_dead','Q2_5_mr','Q2_6_DATE','Q2_7','Q2_8','Q2_9','Q2_10','Q2_10_DAY_OR_HOUR','Q2_11','Q2_12','Q2_12_OTHER','Q2_13','Q2_14','Q2_14_comment','Q2_14_DOE','Q2_14_SUP_CODE'];
        return $data;
    }

    function getstillBirthTextField()
    {
        $text = ['Q1_1_N1','Q1_1_CID','Q1_1_LPODT','Q1_15_OTHER','Q2_G_OTHER','Q2_1_23_OTHER','Q2_3','Q2_5_alive','Q2_5_dead','Q2_5_mr','Q2_7','Q2_11','Q2_12_OTHER','Q2_14_DOE','Q1_4_DAY_OR_MONTH','Q1_13_kg','Q2_10_DAY_OR_HOUR'];
        return $text;
    }

    function getstillBirthDropdown($fieldsData,$textfield,$dateField,$textarea)
    {
        $dropdown = [];

        foreach ($fieldsData as $key => $value) {

             if(!in_array($value, $textfield) && !in_array($value, $dateField) && !in_array($value, $textarea)){
                $dropdown[] = $value;
            }
        }

        return $dropdown;
    }

    function getstillBirthDateFields()
    {
        $dateField = ['Q2_6_DATE','Q2_14_DOE'];

        return $dateField;
    }

}
