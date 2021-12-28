<?php

$menu_name = '';
$id = 0;
$status = '';
$parent_menu_id = 0;
$url = '';
$icon = '';
$description ='';
$menu_key ='';



if(!empty($userInfo))
{
    foreach ($userInfo as $uf)
    {
    
        $menu_name = $uf->menu_name;
        $id = $uf->id;
        $active = $uf->status;
		
		$parent_menu_id = $uf->parent_menu_id;
        $url = $uf->url;
        $icon = $uf->icon;
		$description = $uf->description;
		$menu_key = $uf->menu_key;
		
		
		
    }
}


?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
		    <div class="col-xs-6 text-left header-margin ">
				<h3>
				   Menu Management
				  <small>Add, Edit</small>
				</h3>
	        </div>
            <div class="col-xs-6 text-right">
                <div class="form-group">
                     <a class="btn btn-primary" href="<?php echo base_url().'menu?baseID='.$baseID ?>"> <i class="fa fa-bars" aria-hidden="true"></i> Menu List</a>
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
                        <h3 class="box-title">Enter Menu Details</h3>
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
                    
                    <form role="form" action="<?php echo base_url().'menu/editMenu?baseID='.$baseID ?>" method="post" id="editUser" role="form">
                        <div class="box-body">
						
						    <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Item Name">Menu Name *</label>
                                        <input type="text" class="form-control required" id="menu_name" value="<?php echo $menu_name  ?>"  name="menu_name" maxlength="255" required="reuired">
										<input type="hidden" class="form-control required" id="menu_id" value="<?php echo $id  ?>"  name="menu_id" maxlength="255">
                                    </div>
                                </div>
                            </div>
							<!--<div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Item Name">Menu Key *</label>
                                        <input type="text" class="form-control required" id="menu_key" value="<?php echo $menu_key  ?>"  name="menu_key" maxlength="55" required="reuired">
                                    </div>
                                </div>
                            </div>-->
							<div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Item Name">Menu Description</label>
                                        <input type="text" class="form-control required" id="description" value="<?php echo $description ?>" name="description" maxlength="255">
                                    </div>
                                </div>
                            </div>
							 <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="role">Parent Name</label>
										
										
										<select class="form-control required" id="role" name="parent_id">
                                            <option value="0">Select Parent Menu</option>
                                            <?php
                                            if(!empty($menuList))
                                            {
                                                foreach ($menuList as $menuList)
                                                {
                                                    ?>
                                                    <option value="<?php echo $menuList->id ?>" <?php if($menuList->id == $parent_menu_id) {echo "selected=selected";} ?> ><?php echo $menuList->menu_name ?>	</option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                        
                                    </div>
                                </div>
                            </div>
                             
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Item Name">Menu URL *</label>
                                        <input type="text" class="form-control required" id="menu_url" value="<?php echo $url ?>"   name="menu_url" maxlength="255" required="reuired">
                                    </div>
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Item Name">Menu Icon</label>
                                        <input type="text" class="form-control required" id="menu_icon"  value="<?php echo $icon ?>" name="menu_icon" maxlength="255">
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
            
        </div>    
    </section>
</div>
