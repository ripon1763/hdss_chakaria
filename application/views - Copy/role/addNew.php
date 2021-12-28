<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
	 <div class="row">
         <div class="col-xs-6 text-left header-margin ">
	        <h3>
			   Role Management
			  <small>Add, Edit</small>
		    </h3>
	     </div>
		  <div class="col-xs-6 text-right">
		     <div class="text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url().'role?baseID='.$baseID ?>"><i class="fa fa-bars" aria-hidden="true"></i> Role List</a>
                </div>
            </div>
		   </div>
	  </div>
    </section>
	
    <section class="content content-margin">

        
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Role Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
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
						
						<?php  
							if(isset($error_valid))
							{
						?>
						<div class="alert alert-success alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<?php echo $error_valid; ?>
						</div>
						<?php } ?>
						
						<div class="row">
							<div class="col-md-12">
								<?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
							</div>
						</div>
            
                    <form role="form" id="addUser" action="<?php echo base_url().'role/addNewRole?baseID='.$baseID ?>" method="post" role="form">
                        <div class="box-body">
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Item Name">Role Name</label>
                                        <input type="text" class="form-control required" id="role_name"  name="role_name" maxlength="255" required>
                                    </div>
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Item Name">Role Description</label>
										
                                        <input type="text" class="form-control required" id="description"  name="description" maxlength="255">
                                    </div>
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Item Name">Menu List &nbsp;</label> <input type="checkbox" id="checkAll"> All
										<hr/>
							<?php
				
								function createTreeView($array, $currentParent, $currLevel = 0, $prevLevel = -1) 
								{

									foreach ($array as $menu_id => $menu) 
									{
										
										if ($currentParent == $menu['parent_menu_id']) 
										{                       
											if ($currLevel > $prevLevel) echo " <ol class='tree'> "; 

											if ($currLevel == $prevLevel) echo " </li> ";

											echo '<li style="padding:5px; border-top:1px solid #ccc"> <label for="subfolder2">'.$menu['menu_name'].'</label>  <input value="'.$menu['id'].'" type="checkbox" name="chk[]"/> <span style="padding:5px; font-weight:bold">&nbsp;&nbsp;  View &nbsp;&nbsp; <input value="'.$menu['id'].'" type="checkbox" name="chkAdd[]"/>&nbsp;&nbsp; Add &nbsp;&nbsp;<input value="'.$menu['id'].'" type="checkbox" name="chkEdit[]"/>  Edit &nbsp;&nbsp;</span>';

											if ($currLevel > $prevLevel) { $prevLevel = $currLevel; }

											$currLevel++; 

											createTreeView ($array, $menu_id, $currLevel, $prevLevel);

											$currLevel--;               
										}   

									}

									if ($currLevel == $prevLevel) echo " </li>  </ol> ";
									
									

								}
								
								createTreeView($menuTree, 0);
								
								?>
								<hr/>
								   </div>
                                </div>
                            </div>
	
							<div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Active">Active</label>
                                        <select class="form-control required" id="role" name="active">
                                            <option value="1">Yes</option>
											<option value="0">No</option>
                                            
                                        </select>
                                    </div>
                                </div>    
                            </div>
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Save" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </div>
                    </form>
                </div>
            </div>
            
        </div>    
    </section>
    
</div>
<script>
  $(function () {
 $("#checkAll").click(function () {
			 $('input:checkbox').not(this).prop('checked', this.checked);
		 });
	});
  </script>