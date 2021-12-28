<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
	    <div class="row">
		    <div class="col-xs-6 text-left header-margin ">
				<h3>
				   User Management
				  <small>Add, Edit</small>
				</h3>
	        </div>
            <div class="col-xs-6 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url().'user/addNew?baseID='.$baseID ?>"><i class="fa fa-plus" aria-hidden="true"></i> Add New</a>
                </div>
            </div>
        </div>
    </section>
    <section class="content content-margin">
        
        <div class="row">
            <div class="col-xs-12">
              <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Users List</h3>
					
					<?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
					?>
					<div class="alert alert-danger alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<?php echo $this->session->flashdata('error'); ?>                    
					</div>
					<?php } ?>
					<?php  
						$success = $this->session->flashdata('success');
						if($success)
						{
					?>
					<div class="alert alert-success alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<?php echo $this->session->flashdata('success'); ?>
					</div>
					<?php } ?>
					
					<div class="row">
						<div class="col-md-12">
							<?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
						</div>
					</div>
                </div><!-- /.box-header -->
                <div class="box-body">
                   <table id="userList" class="table table-bordered table-striped">
					<thead>
                    <tr>
                      <th>Action</th>
                      <th>Name</th>
					  <th>User Name</th>
                      <th>Email</th>
                      <th>Mobile</th>
                      <th>Role</th>
                      <th>#</th>
                    </tr>
					</thead>
					<tbody>
                    <?php
                    if(!empty($userRecords))
                    {
                        foreach($userRecords as $record)
                        {
                    ?>
                    <tr>
					  <td>
                          <a class="btn btn-primary" href="<?php echo base_url().'user/editOld/'.$record->userId .'?baseID='.$baseID ?>"><i class="fa fa-pencil"></i></a>
                      </td>
                      <td><?php echo $record->name ?></td>
					  <td><?php echo $record->username ?></td>
                      <td><?php echo $record->email ?></td>
                      <td><?php echo $record->mobile ?></td>
                      <td><?php //echo $record->roleId ?>
					  
					                    <?php 
										   
										   if ($record->roleId != '')
											   {
												   $array_roleId = explode( ',', $record->roleId);
												   $loopCount = count($array_roleId);
												   
												   for ($i=0; $i < $loopCount; $i++)
												   {
													  $role = $this->db->from('tbl_roles')->where(array('roleId' => $array_roleId[$i]))->get()->row()->role;
													  echo  '<i style="color:red" class="fa fa-angle-double-right" aria-hidden="true"></i> '.$role.'<br/>';
													  
												   }
											   }
										   
										   ?>
					  
					  
					  </td>
                      
                      <td><?php echo $record->userId ?></td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
					</tbody>
					<tfoot>
					<tr>
                      <th>Action</th>
                      <th>Name</th>
					  <th>User Name</th>
                      <th>Email</th>
                      <th>Mobile</th>
                      <th>Role</th>
                      <th>#</th>
                    </tr>
					</tfoot>
                  </table>
                  
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
   $(function () {
        $("#userList").DataTable();
      });
  </script>
