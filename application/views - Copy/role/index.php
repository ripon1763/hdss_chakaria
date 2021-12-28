<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      
	  
	   <div class="row">
	     <div class="col-xs-6 text-left header-margin">
	        <h3> 
			   Role Management
			  <small>Add, Edit</small>
		    </h3>
	     </div>
            <div class="col-xs-6 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url() .'role/addNew?baseID='.$baseID ?>"><i class="fa fa-plus" aria-hidden="true"></i> Add New</a>
                </div>
            </div>
        </div>
		
    </section>
    <section class="content content-margin">
       
        <div class="row">
            <div class="col-xs-12">
              <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Role List</h3>
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
					<table id="UnitList" class="table table-bordered table-striped">
						<thead>
						<tr>
						  <th width="4%">Action</th>
						  <th>Role Name</th>
						  <th>Role Description</th>
						  <th>Active</th>
						  <th width="2%">#</th>
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
							  <a class="btn btn-primary" href="<?php echo base_url().'role/editOld/'.$record->roleId. '?baseID='.$baseID ?>"><i class="fa fa-pencil"></i></a>
							
						  </td>
						  <td><?php echo $record->role ?></td>
						  <td><?php echo $record->description ?></td>
						  
						  <td>  <?php if ($record->active == 1 ) { echo "Yes"; } else { echo "No"; } ?></td>
						  
						  <td><?php echo $record->roleId ?></td>
						</tr>
						<?php
							}
						}
						?>
						</tbody>
						<tfoot>
						<tr>
						  <th>Action</th>
						  <th>Role Name</th>
						  <th>Role Description</th>
						  <th>Active</th>
						  <th>#</th>
						</tr>
						</tfoot>
					  </table>
                </div>  
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>
   <script>
  $(function () {
        $("#UnitList").DataTable();
      });
  </script>                  
