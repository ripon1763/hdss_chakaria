<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model
{
    
    /**
     * This function used to check the login credentials of the user
     * @param string $email : This is email of the user
     * @param string $password : This is encrypted password of the user
     */
    function loginMe($username, $ecryptPassword)
    {
        $this->db->select('BaseTbl.userId, BaseTbl.name, BaseTbl.roleId,
		BaseTbl.system_user,BaseTbl.username,  BaseTbl.employee_id, BaseTbl.job_title, 
		BaseTbl.department,BaseTbl.extension,BaseTbl.slum_id,BaseTbl.active');
        $this->db->from('tbl_users as BaseTbl');
       // $this->db->join('tbl_roles as Roles','Roles.roleId = BaseTbl.roleId');
        $this->db->where('BaseTbl.username', $username);
        $this->db->where('BaseTbl.password', $ecryptPassword);
		$this->db->where('BaseTbl.system_user', 1);
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('BaseTbl.active', 1);
        $query = $this->db->get();
        
        return $query->result();
    }
	
	function loginMeStaff($username)
    {
        $this->db->select('BaseTbl.userId, BaseTbl.name, BaseTbl.roleId, Roles.role, BaseTbl.system_user,BaseTbl.username, BaseTbl.employee_id, BaseTbl.job_title, BaseTbl.department,BaseTbl.extension');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->join('tbl_roles as Roles','Roles.roleId = BaseTbl.roleId');
        $this->db->where('BaseTbl.username', $username);
		$this->db->where('BaseTbl.system_user', 0);
        $this->db->where('BaseTbl.isDeleted', 0);
        $query = $this->db->get();
        
        return $query->result();
    }
	
	function CheckUser($username)
    {
        $this->db->select('employeeId, job_title, firstnames, lastname, username, email, department');
        $this->db->from('tbl_staff');
        $this->db->where('tbl_staff.username', $username);
        $query = $this->db->get();
        
        return $query->result();
    }
	
	function CheckUserInUsertable($username)
    {
        $this->db->select('employee_id,username');
        $this->db->from('tbl_users');
        $this->db->where('tbl_users.username', $username);
        $query = $this->db->get();
        
        return $query->result();
    }
	
	function UserInsert($UserInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_users', $UserInfo);
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
	
	function loginsert($logInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_log', $logInfo);
        $this->db->trans_complete();
    }
	
	function lastLoginInfo($userId)
    {
        $this->db->select('BaseTbl.createdDtm');
        $this->db->where('BaseTbl.userId', $userId);
        $this->db->order_by('BaseTbl.id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('tbl_log as BaseTbl');

        return $query->row();
    }
    
    
}

?>