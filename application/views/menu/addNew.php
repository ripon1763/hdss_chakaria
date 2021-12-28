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
	
	<?php 
	
	
	function buildTree(Array $data, $parent = 0) {
    $tree = array();
    foreach ($data as $d) {
        if ($d['parent'] == $parent) {
            $children = buildTree($data, $d['id']);
            // set a trivial key
            if (!empty($children)) {
                $d['_children'] = $children;
            }
            $tree[] = $d;
        }
    }
    return $tree;
}


$tree = buildTree($menuListDropdown);
// print_r($tree);

function printTree($tree, $r = 0, $p = null) {
    foreach ($tree as $i => $t) {
        $dash = ($t['parent'] == 0) ? '' : str_repeat('-', $r) .' ';
        printf("\t<option value='%d'>%s%s</option>\n", $t['id'], $dash, $t['name']);
        if ($t['parent'] == $p) {
            // reset $r
            $r = 0;
        }
        if (isset($t['_children'])) {
            printTree($t['_children'], ++$r, $t['parent']);
        }
    }
}


	?>
    
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
            
                    <form role="form" id="addUser" action="<?php echo base_url().'menu/addNewMenu?baseID='.$baseID ?>" method="post" role="form">
                        <div class="box-body">
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Item Name">Menu Name *</label>
                                        <input type="text" class="form-control required" id="menu_name"  name="menu_name" maxlength="255" required="reuired">
                                    </div>
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Item Name">Menu Key *</label>
                                        <input type="text" class="form-control required" id="menu_key"  name="menu_key" maxlength="55" required="reuired">
                                    </div>
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Item Name">Menu Description</label>
                                        <input type="text" class="form-control required" id="description"  name="description" maxlength="255">
                                    </div>
                                </div>
                            </div>
							 <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="role">Parent Name</label>
										<?php 
										echo "<select class='form-control required' id='role' name='parent_id'>\n";
										echo "<option value='0'> Select Parent Menu </option>";
										             printTree($tree);
										echo "</select>"; 
										?>
                                        
                                    </div>
                                </div>
                            </div>
							
							<div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Item Name">Menu URL *</label>
                                        <input type="text" class="form-control required" id="menu_url"  name="menu_url" maxlength="255" required="reuired">
                                    </div>
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Item Name">Menu Icon</label>
                                        <input type="text" class="form-control required" id="menu_icon"  name="menu_icon" maxlength="255">
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
