<?php

$name = '';
$description = '';
$code = '';
$id = 0;
$master_id = 0;
$display_order = '';
$internal_code = '';
$active = '';

if(!empty($userInfo))
{
    foreach ($userInfo as $uf)
    {
        $name = $uf->name;
        $id = $uf->id;
        $active = $uf->active;
        $code = $uf->code;
        $description = $uf->description;
        $display_order = $uf->display_order;
        $internal_code = $uf->internal_code;
        $master_id = $uf->lookup_master_id;
		
    }
}

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="row">
		    <div class="col-xs-6 text-left header-margin ">
	              <h3>
					<?php echo $pageTitle; ?>
					<small>(Add, Edit)</small>
					<?php $baseID = $this->input->get('baseID',TRUE); ?>
				  </h3>
               
            </div>
            <div class="col-xs-6 text-right">
                <div class="form-group margin5pxBot">
                         <a class="btn btn-primary" href="<?php echo base_url().$controller.'?baseID='.$baseID ?>"><?php echo $shortName ?> List</a>
                </div>
            </div>
        </div>
    </section>
    
    <section class="content content-margin">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title"><?php echo $shortName ?> Details</h3>
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
                    
                    <form role="form" action="<?php echo base_url().$controller.'/'.$actionMethod.'?baseID='.$baseID ?>" method="post" id="editUser" role="form">
                        <div class="box-body">
                           
							<div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Item Name">Lookup type *</label>
										<input type="hidden"  name="id" value="<?php echo $id ?>">
                                        <select class="form-control required" id="role" name="master_id" required>
                                           <option value="">Select Lookup type</option>
                                            <?php
                                            if(!empty($lookupMasterType))
                                            {
                                                foreach ($lookupMasterType as $type)
                                                {
                                                    ?>
                                                    <option <?php if ($master_id == $type->id) { echo 'selected=selected';} ?> value="<?php echo $type->id ?>"><?php echo $type->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                           
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Item Name">Name *</label>
										
                                        <input type="text" class="form-control required" id="name"  name="name" value="<?php echo $name ?>" maxlength="255">
                                    </div>
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Item Name">Code *</label>
                                        <input type="text" class="form-control required" id="code" value="<?php echo $code ?>"  name="code" maxlength="255" required="required">
                                    </div>
                                </div>
                           
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Item Name">Internal Code </label>
                                        <input type="text" class="form-control required" id="internal_code" value="<?php echo $internal_code ?>"  name="internal_code" maxlength="255">
                                    </div>
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Item Name">Description</label>
                                        <input type="text" class="form-control required" id="description" value="<?php echo $description ?>" name="description" maxlength="255">
                                    </div>
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Item Name">Display Order </label>
                                        <input type="text" class="form-control required" id="display_order" value="<?php echo $display_order ?>"  name="display_order" maxlength="255" required="required">
                                    </div>
                                </div>
                            
                                <div class="col-md-6">
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
