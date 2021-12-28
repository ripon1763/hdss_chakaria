<?php

$role = '';
$roleId = 0;
$active = '';
$description ='';


if(!empty($userInfo))
{
    foreach ($userInfo as $uf)
    {
    
        $role = $uf->role;
        $id = $uf->roleId;
        $active = $uf->active;
		$description = $uf->description;
		
    }
}


?>

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
            <div class="col-md-8">
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
					
					<div class="row">
						<div class="col-md-12">
							<?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
						</div>
					</div>
                    
                    <form role="form" action="<?php echo base_url().'role/editRole?baseID='.$baseID ?>" method="post" id="editUser" role="form">
                        <div class="box-body">
				
							<div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Item Name">Role Name</label>
                                        <input type="text" class="form-control required" id="role_name"  value="<?php echo $role  ?>" name="role_name" maxlength="255">
										<input type="hidden" class="form-control required" id="role_id" value="<?php echo $id  ?>"  name="role_id" maxlength="255">
                                    </div>
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Item Name">Role Description</label>
										
                                        <input type="text" class="form-control required" value="<?php echo $description  ?>" id="description"  name="description" maxlength="255">
                                    </div>
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Item Name">Menu List &nbsp;</label> <input type="checkbox" id="checkAll"> All
										<hr/>
							<?php
							
							        if(!empty($userMenuRolePerm))
									{  
								        $arr = array();
								        $add = array();
								        $edit = array();
										foreach ($userMenuRolePerm as $rowDta)
										{
											$arr[] = $rowDta->menu_id;
											$edit[] = $rowDta->edit.$rowDta->menu_id;
											$add[] = $rowDta->add.$rowDta->menu_id;
											
										}
									} 
				
								function createTreeView($array, $currentParent,$arr,$add,$edit, $currLevel = 0, $prevLevel = -1) 
								{

									foreach ($array as $menu_id => $menu) 
									{
										
										 
											
											if ($currentParent == $menu['parent_menu_id']) 
											{                       
												if ($currLevel > $prevLevel) echo " <ol class='tree'> "; 

												if ($currLevel == $prevLevel) echo " </li> ";

												echo '<li style="padding:5px; border-top:1px solid #ccc"> <label for="subfolder2">'.$menu['menu_name'].'</label>'; ?>  
												<input <?php  if (in_array($menu['id'], $arr)) { echo "checked=checked"; } ?>  value="<?php echo $menu['id'] ?>" type="checkbox" name="chk[]"/>
												<span style="padding:5px; font-weight:bold">&nbsp;&nbsp;  View &nbsp;&nbsp; 
												
												<?php 
											      
												//  $add = $this->db->from('tbl_user_role_menu')->where(array('menu_id' => $menu['id'], 'role_id' =>$current_role))->limit(1)->get()->row()->add; 
												 ?>
												
												<input <?php  if (in_array('1'.$menu['id'], $add)) { echo "checked=checked"; } ?> value="<?php echo $menu['id'] ?>" type="checkbox" name="chkAdd[]"/>
												&nbsp;&nbsp; Add &nbsp;&nbsp;
												<input <?php  if (in_array('1'.$menu['id'], $edit)) { echo "checked=checked"; } ?> value="<?php echo $menu['id'] ?>" type="checkbox" name="chkEdit[]"/>  Edit &nbsp;&nbsp;</span>
												<?php if ($currLevel > $prevLevel) { $prevLevel = $currLevel; }

												$currLevel++; 

												createTreeView ($array, $menu_id,$arr, $add, $edit,$currLevel, $prevLevel);

												$currLevel--;               
											} 
											
										
																		

									}

									if ($currLevel == $prevLevel) echo " </li>  </ol> ";
									
									

								}
								
								            createTreeView($menuTree, 0,$arr, $add,$edit);
										 
								
								//$arrayCategories = array();
								//if(!empty($result))
									//{
										//foreach ($result as $row)
										//{
										//	$arrayCategories[$row->menu_id] = array( 'menu_id' => $row->menu_id);  
											
										//}
										
											
										
									//} 
								//return $arrayCategories;
								
								
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
                                            <option value="1" <?php if($active == 1) {echo "selected=selected";}?>>Yes</option>
											<option value="0"  <?php if($active == 0) {echo "selected=selected";}?> >No</option>
                                            
                                        </select>
                                    </div>
                                </div>    
                            </div>
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Save" />
                          
                        </div>
                    </form>
                </div>
            </div>
			<div class="col-md-4">
			     <div class="box box-primary">
                    <div class="box-header">
					   <h3 class="box-title">Existing Permissions</h3>
					</div>
					<div class="box-body">
					 <?php 
					                if(!empty($userMenuRolePerm))
									{  
								       
										foreach ($userMenuRolePerm as $row)
										{
											
											echo "<div class='row'><div class='col-md-12'>";
											echo '<div style="padding:5px 0px 5px 0px; border-top:1px solid #ccc">'.$row->menu_name.'</div>'; 
											echo "</div></div>";
											
											
											
										}
										
										
										
									} 
					 ?>
					<div>
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