<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' ); 

/**
 * Class : BaseController
 * Base Class to control over all the classes
 */
class BaseController extends CI_Controller {
	protected $role = '';
	protected $vendorId = '';
	protected $employeeid = '';
	protected $department = '';
	protected $job_title = '';
	protected $name = '';
    protected $lastLogin = '';
	protected $roleText = '';
	protected $slumID = 0;
    protected $first_date = '';
	protected $last_date = '';
	protected $global = array ();
	
	/**
	 * Takes mixed data and optionally a status code, then creates the response
	 *
	 * @access public
	 * @param array|NULL $data
	 *        	Data to output to the user
	 *        	running the script; otherwise, exit
	 */
	public function response($data = NULL) {
		$this->output->set_status_header ( 200 )->set_content_type ( 'application/json', 'utf-8' )->set_output ( json_encode ( $data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) )->_display ();
		exit ();
	}
	
	/**
	 * This function used to check the user is logged in or not
	 */
	function isLoggedIn() 
	{
		$isLoggedIn = $this->session->userdata ('isLoggedIn' );
		
		if (! isset ( $isLoggedIn ) || $isLoggedIn != TRUE) {
			redirect ( 'login' );
		} else {
			
			$this->role = explode(',', $this->session->userdata('role'));
			$this->vendorId = $this->session->userdata('userId');
			$this->name = $this->session->userdata('name');
			$this->roleText = $this->session->userdata('roleText');
			$this->employeeid = $this->session->userdata('employee_id');
			$this->department = $this->session->userdata('department');
			$this->job_title = $this->session->userdata('job_title');
			$this->extension = $this->session->userdata('extension');
			$this->lastLogin = $this->session->userdata('lastLogin');
			$this->slumID = $this->session->userdata('slumID');
			
			$this->global ['name'] = $this->name;
			$this->global ['role'] = $this->role;
			$this->global ['role_text'] = $this->roleText;
			
			$this->first_date = date('01/m/Y'); 
			$this->last_date  = date('t/m/Y');


         
			


		}
	}
	
	/**
	 * This function is used to check the access
	 */
	function isAdmin() {
		if ($this->role == 1) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * This function is used to check the access
	 */
	function isTicketter() {
		if ($this->role != 1 || $this->role != 2) {
			return true;
		} else {
			return false;
		}
	}
	
	function isUriString ()
	{
		return uri_string();
	}

	function getHouseholdCode ($slumID,$slumAreaID)
	{
       $this->db->trans_start();

        try
        {

	        $whereSlum = array('id' =>$slumID);
	        $slumCode = $this->db->select('code')->from($this->config->item('slumTable'))->where($whereSlum)->get()->row()->code;

	        $whereSlumArea = array('id' =>$slumAreaID);
	        $slumAreaCode = $this->db->select('code')->from($this->config->item('slumAreaTable'))->where($whereSlumArea)->get()->row()->code;

	        $where = array('fk_slum_id' =>$slumID,'fk_slum_area_id' =>$slumAreaID);


	        $max_code = $this->db->select('max(houseCount) as max_code')->from( $this->config->item('householdMasterTable'))->where($where)->get()->row()->max_code + 1;

	        $totalCount = str_pad($max_code,4,'0',STR_PAD_LEFT); 
        }
	    catch(Exception $e)
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', 'Error occurred while creating household code.');
        }

        $this->db->trans_commit();

	        $householCode = $slumCode.''.$slumAreaCode.''.$totalCount;


	    $data=    array(
				    'householCode' => $householCode,
				    'houseCount' =>$max_code
				);

        return $data;
	}

	function getMemberCode ($household_master_id)
	{
		$this->db->trans_start();

        try
        { 
        
		    $whereHousehold = array('id' =>$household_master_id);
		    $household_code = $this->db->select('household_code')->from($this->config->item('householdMasterTable'))->where($whereHousehold)->get()->row()->household_code;


		    $where = array('Substring(MEMBER_CODE, 1, 8) like ' => $household_code);
		    $max_code = $this->db->select('( COALESCE( MAX( Substring( MEMBER_CODE, 9, 2 ) ), 0 ) + 1 ) max_code')->from( $this->config->item('memberMasterTable'))->where($where)->get()->row()->max_code;

		    $totalCount = str_pad($max_code,2,'0',STR_PAD_LEFT); 

        }
        catch(Exception $e)
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', 'Error occurred while creating member code.');
        }

        $this->db->trans_commit();

        $memberCode = $household_code.$totalCount;

        return $memberCode;
	}


	function getMemberCodebyCID ($household_master_id)
	{
		$this->db->trans_start();

        try
        { 
        
		    $whereHousehold = array('id' =>$household_master_id);
		    $household_code = $this->db->select('household_code')->from($this->config->item('householdMasterTable'))->where($whereHousehold)->get()->row()->household_code;


		    $where = array('Substring(current_indenttification_id, 1, 8) like ' => $household_code);
		    $max_code = $this->db->select('( COALESCE( MAX( Substring( current_indenttification_id, 9, 2 ) ), 0 ) + 1 ) max_code')->from( $this->config->item('memberHouseholdTable'))->where($where)->get()->row()->max_code;

		    $totalCount = str_pad($max_code,2,'0',STR_PAD_LEFT); 

        }
        catch(Exception $e)
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', 'Error occurred while creating member code.');
        }

        $this->db->trans_commit();

        $memberCode = $household_code.$totalCount;

        return $memberCode;
	}

    function getActiveHeadDetails ($household_master_id,$headTypeID )
	{
          $this->db->select('mm.id as member_master_id, mm.member_code');
          $this->db->from('tbl_member_master mm');
          $this->db->join('tbl_member_household mh', 'mh.id = mm.member_household_id_last','inner');
          $this->db->where('mm.household_master_id_hh',$household_master_id);
          $this->db->where('mm.fk_relation_with_hhh',$headTypeID );
          $this->db->where('mh.round_master_id_exit_round',0);

          $query = $this->db->get()->result();
        
          return $query;
    }

    function getLookUpDetailCode($id)
    {
        $this->db->select('code,internal_code');
        $this->db->from('tbl_lookup_details');
        $this->db->where('id', $id);
        $query = $this->db->get();
        
        return $query->result();
    }


	function getCurrentRound ()
	{
        
        $this->db->select('id, active,roundNo');
        $this->db->from('tbl_round_master');
        $this->db->order_by('id','desc');
        $this->db->limit(1);

        $query = $this->db->get()->result();
 

        return $query;
	}

	
	
	//permission check
	
	function loadThisForAccess($role_id,$menu_id,$menu_key) 
	{
		
		$this->db->select('DISTINCT(menu_id)');
        $this->db->from('tbl_user_role_menu');
		$this->db->where_in('role_id', $role_id);
		$this->db->where_in('menu_id', $menu_id);
        $ArryQuery = $this->db->get();
	    
		//$get_data = $this->db->get_where('tbl_user_role_menu', ['role_id' => $role_id, 'menu_id' => $menu_id]);
        $count = $ArryQuery->num_rows();
	
		if ($count >= 1)
		{
			
			$get_data_from_menu = $this->db->get_where('tbl_menu', ['status' => 1, 'id' => $menu_id, 'menu_key' => $menu_key]);
            $count_row = $get_data_from_menu->num_rows();
			if ($count_row == 1)
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
			
		    
		}
		else 
		{
			 return FALSE;
		}
		
		
	}
	
	
	function getPermission($menu_id, $role_id, $state) 
	{
		
	   if ($state == 'add')
	   {
		   
			$this->db->select('add');
			$this->db->from('tbl_user_role_menu');
			$this->db->where_in('role_id', $role_id);
			$this->db->where_in('menu_id', $menu_id);
			$addQuery = $this->db->get();
			
			$rows = $addQuery->num_rows();
			$add = $addQuery->row()->add;
			
			if ($rows > 0)
			{
				if ($add == 1)
				{
					return 1;   
				}
				else 
				{
					 return 0;
				}
				
			}
			else 
			{
				 return 0;
			}

	   }
	   else if ($state == 'edit')
	   {
		    $this->db->select('edit');
			$this->db->from('tbl_user_role_menu');
			$this->db->where_in('role_id', $role_id);
			$this->db->where_in('menu_id', $menu_id);
			$editQuery = $this->db->get();
			
			$rowsEdit = $editQuery->num_rows();
			$edit = $editQuery->row()->edit;
			
			if ($rowsEdit > 0)
			{
				if ($edit == 1)
				{
					return 1;   
				}
				else 
				{
					 return 0;
				}
				
			}
			else 
			{
				 return 0;
			}
		   
	   }
	   else
	   {
		   return 0;
	   }
		
	}
	
	
	
	/**
	 * This function is used to load the set of views
	 */
	function loadThis() {
		$this->global ['pageTitle'] = 'icddr,b : Access Denied';
		
		$this->load->view ( 'includes/header', $this->global );
		$this->load->view ( 'access' );
		$this->load->view ( 'includes/footer' );
	}
	
	/**
	 * This function is used to logged out user from system
	 */
	function logout() {
		$this->session->sess_destroy ();
		
		redirect ( 'login' );
	}
	
	/**
	 * This function used provide the pagination resources
	 * @param unknown $link
	 * @param number $count
	 * @return string[]|unknown[]
	 */
	function paginationCompress($link, $count, $perPage = 10) {
		$this->load->library ( 'pagination' );
	
		$config ['base_url'] = base_url () . $link;
		$config ['total_rows'] = $count;
		$config ['uri_segment'] = SEGMENT;
		$config ['per_page'] = $perPage;
		$config ['num_links'] = 5;
		$config ['full_tag_open'] = '<nav><ul class="pagination">';
		$config ['full_tag_close'] = '</ul></nav>';
		$config ['first_tag_open'] = '<li class="arrow">';
		$config ['first_link'] = 'First';
		$config ['first_tag_close'] = '</li>';
		$config ['prev_link'] = 'Previous';
		$config ['prev_tag_open'] = '<li class="arrow">';
		$config ['prev_tag_close'] = '</li>';
		$config ['next_link'] = 'Next';
		$config ['next_tag_open'] = '<li class="arrow">';
		$config ['next_tag_close'] = '</li>';
		$config ['cur_tag_open'] = '<li class="active"><a href="#">';
		$config ['cur_tag_close'] = '</a></li>';
		$config ['num_tag_open'] = '<li>';
		$config ['num_tag_close'] = '</li>';
		$config ['last_tag_open'] = '<li class="arrow">';
		$config ['last_link'] = 'Last';
		$config ['last_tag_close'] = '</li>';
	
		$this->pagination->initialize ( $config );
		$page = $config ['per_page'];
		$segment = $this->uri->segment ( SEGMENT );
	
		return array (
				"page" => $page,
				"segment" => $segment
		);
	}
	
	function datas()
	{
		$this->role = $this->session->userdata ( 'role' );
		$this->vendorId = $this->session->userdata ( 'userId' );
		$this->name = $this->session->userdata ( 'name' );
		$this->roleText = '';
		$this->lastLogin = $this->session->userdata ( 'lastLogin' );
		$this->status = $this->session->userdata ( 'status' );
		
		
		$this->global ['name'] = $this->name;
		$this->global ['role'] = $this->role;
		$this->global ['role_text'] = $this->roleText;
		$this->global ['last_login'] = $this->lastLogin;
		$this->global ['status'] = $this->status;
		
	}
	
	function logrecord($process,$processFunction){
		$this->datas();
		$logInfo = array("userId"=>$this->vendorId,
		"userName"=>$this->name,
		"process"=>$process,
		"processFunction"=>$processFunction,
		"userRoleId"=>$this->role,
		"userRoleText"=>$this->roleText,
		"userIp"=>$_SERVER['REMOTE_ADDR'],
		"userAgent"=>getBrowserAgent(),
		"agentString"=>$this->agent->agent_string(),
		"platform"=>$this->agent->platform(),
		"createdDtm" =>date('Y-m-d H:i:s')
		);
		
		$this->load->model('login_model');
		$this->login_model->loginsert($logInfo);
	}
}