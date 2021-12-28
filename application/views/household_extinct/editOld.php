<?php


  // id, contact_number, fk_district_id, fk_thana_id, fk_slum_id, fk_slum_area_id, barino, bariwalla_name, household_code, household_head_name, longlivy, longlivm, leftpad, fk_entry_type, entry_date, round_master_id_entry_round, fk_migration_reason, migration_reason_oth, fk_country_id_from, fk_district_id_from, fk_thana_id_from, fk_extinct_type, extinct_date, round_master_id_extinct_round, fk_contract_type, fk_family_type, fk_study_design, location_id, location_split_id, member_master_id_last_head, transfer_complete, insertedBy, insertedOn, updateBy, updatedOn

$contact_number = '';
$household_head_name = '';
$migration_reason_oth = '';
$entry_date = '';
$barino = '';
$id = 0;
$fk_district_id = 0;
$bariwalla_name = '';
$fk_thana_id= 0;
$fk_slum_id= 0; 
$fk_slum_area_id = 0;
$longlivy = 0;
$longlivm = 0;
$leftpad = 0;
$fk_entry_type = 0;
$fk_migration_reason = 0;
$fk_country_id_from = 0;
$fk_district_id_from = 0;
$fk_thana_id_from = 0;
$fk_contract_type = 0;
$round_master_id_entry_round = 0;
$round_master_id_extinct_round = 0;
$fk_slum_id_from = 0;
$fk_slumArea_id_from = 0;
$household_code = '';


if(!empty($userInfo))
{
    foreach ($userInfo as $uf)
    {
        $contact_number = $uf->contact_number;
        $id = $uf->id;
        $fk_district_id = $uf->fk_district_id;
        $bariwalla_name = $uf->bariwalla_name;
        $barino = $uf->barino;
        $fk_thana_id = $uf->fk_thana_id;
        $fk_slum_id = $uf->fk_slum_id;
        $fk_slum_area_id = $uf->fk_slum_area_id;
        $household_head_name = $uf->household_head_name;
        $longlivy = $uf->longlivy;
        $longlivm = $uf->longlivm;
        $leftpad = $uf->leftpad;
        $fk_entry_type = $uf->fk_entry_type;
        $entry_date = $uf->entry_date;
        $fk_migration_reason = $uf->fk_migration_reason;
        $migration_reason_oth = $uf->migration_reason_oth;
        $fk_country_id_from = $uf->fk_country_id_from;
        $fk_district_id_from = $uf->fk_district_id_from;
        $fk_thana_id_from = $uf->fk_thana_id_from;
        $fk_contract_type = $uf->fk_contract_type;
        $round_master_id_entry_round = $uf->round_master_id_entry_round;
        $round_master_id_extinct_round = $uf->round_master_id_extinct_round;
        $household_code = $uf->household_code;
        $fk_slum_id_from = $uf->fk_slum_id_from;
        $fk_slumArea_id_from = $uf->fk_slumArea_id_from;
        
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

                    <?php if ($round_master_id_extinct_round > 0) : ?>

                        <p style="padding-left: 10px; color:red">This household is already extincted. You cannot change anything !!</p>

                    <?php endif; ?>
                    
                    <form role="form" action="<?php echo base_url().$controller.'/'.$actionMethod.'?baseID='.$baseID ?>" method="post" id="editUser" role="form">
                        <div class="box-body">
						<div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">District <span style="color:red">*</span></label>
                                        <input type="hidden" name="id" value="<?php echo $id ?>">
                                        <select class="form-control" id="districtID"  name="districtID" disabled>
                                           <option value="">--- Select District ---</option>
                                            <?php
                                            if(!empty($district))
                                            {
                                                foreach ($district as $district)
                                                {
                                                    ?>
                                                    <option <?php if($district->id == $fk_district_id) { echo "selected=selected";} ?> value="<?php echo $district->id ?>"><?php echo $district->code. '-' .$district->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Upazila <span style="color:red">*</span></label>

                                        <select  class="form-control required" id="thanaID" name="thanaID" disabled>
                                            <option value="">--- Select Upazila ---</option>
                                        </select>
                                    </div>
                                </div>

                               <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Slum <span style="color:red">*</span></label>
                                        
                                        <select class="form-control required" id="slumID" name="slumID" disabled>
                                           <option value="">--- Select Slum ---</option>
                                        </select>
                                    </div>
                                </div>

                                 <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Slum Area <span style="color:red">*</span></label>
                                        
                                        <select class="form-control required" id="slumAreaID" name="slumAreaID" disabled>
                                           <option value="">--- Select Slum Area ---</option>
                                           
                                        </select>
                                    </div>
                                </div>
								
								<div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Household Code</label>
                                        <input type="text" class="form-control required" id="household_code1"  name="household_code1" value="<?php echo $household_code ?>" disabled="disabled">
                                        <input type="hidden" class="form-control required" id="household_code"  name="household_code" value="<?php echo $household_code ?>">
                                    </div>
                                </div>
								
								<div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Name of Household head <span style="color:red">*</span></label>
                                        <input type="text" value="<?php echo $household_head_name ?>" class="form-control required" id="headName"  name="headName" maxlength="255" disabled="disabled">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Name of Bariwala <span style="color:red">*</span></label>
                                        <input type="text" class="form-control required" id="bariwallaName"  name="bariwallaName" value="<?php echo $bariwalla_name ?>" maxlength="255" disabled="disabled">
                                    </div>
                                </div>
                           
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Bari Number <span style="color:red">*</span></label>
                                        <input type="text" class="form-control required" id="bariNumber"  name="bariNumber" value="<?php echo $barino ?>" minlength="5" maxlength="10" size="10" disabled="disabled">
                                    </div>
                                </div>

                               <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Contact no <span style="color:red">*</span></label>
                                        <input type="text" class="form-control required" id="contactNumber" value="<?php echo $contact_number ?>"  name="contactNumber" maxlength="255" disabled="disabled">
                                    </div>
                                </div>

                           
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Active">Entry type <span style="color:red">*</span></label>
                                        <select class="form-control required" id="entryType" name="entryType" disabled="disabled">
                                            <option value="">Please Select</option>
                                           <?php
                                            if(!empty($entryType))
                                            {
                                                foreach ($entryType as $entryType)
                                                {
                                                    ?>
                                                    <option <?php if ($entryType->id == $fk_entry_type) { echo "selected=selected";} ?> value="<?php echo $entryType->id ?>"><?php echo $entryType->code. '-' .$entryType->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            
                                        </select>
                                    </div>
                                </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Entry Date <span style="color:red">*</span></label>

                                        <?php 
                                                   if ($entry_date != "")
                                                   {
                                                    $partsRequire = explode('-', $entry_date);
                                                    $entry_date = $partsRequire[2].'/'.$partsRequire[1].'/'.$partsRequire[0];
                                                   }
                                         ?>
                                        <input type="text" value="<?php echo $entry_date ?>" class="form-control required" id="datepicker4"  name="entryDate" maxlength="255" disabled="disabled">
                                    </div>
                                </div> 
                                
                              
								

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Entry Round no <span style="color:red">*</span></label>
                                        <input type="text" class="form-control required" id="round"  name="round_master_id" value="<?php echo $round_master_id_entry_round ?>" disabled="disabled">
                                    </div>
                                </div>
								
								<div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Active">Extinct Type <span style="color:red">*</span></label>
                                        <select class="form-control required" id="entryType" name="entryType" required>
                                            <option value="">Please Select</option>
                                           <?php
                                           
                                                foreach ($hh_extinct_typ as $extincttyp)
                                                {
                                                    ?>
                                                    <option value="<?php echo $extincttyp->id ?>"><?php echo $extincttyp->code. '-' .$extincttyp->name ?></option>
                                                    <?php
                                                }
                                            
                                            ?>
                                            
                                        </select>
                                    </div>
                                </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Extinct Date <span style="color:red">*</span></label>

                                        <?php 
                                                   // if ($entry_date != "")
                                                   // {
                                                    // $partsRequire = explode('-', $entry_date);
                                                    // $entry_date = $partsRequire[2].'/'.$partsRequire[1].'/'.$partsRequire[0];
                                                   // }
                                         ?>
                                        <input type="text" value="<?php echo $entry_date ?>" class="form-control required" id="datepicker"  name="entryDate" maxlength="255" required>
                                    </div>
                                </div> 
								
								

                                
                            </div>
						    
                        </div><!-- /.box-body -->
                         <?php if ($round_master_id_extinct_round == 0) : ?>
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Save" />
                          
                        </div>
                          <?php endif; ?>
                    </form>
                </div>
            </div>
            
        </div>    
    </section>
</div>
<script type="text/javascript">


    $(document).ready(function() {
		
		
 $(function () {
   $('#datepicker').datepicker({
     autoclose: true,
     format: 'dd/mm/yyyy'
   });
 });


    $('#districtID').change(function(){
          var districtID = $('#districtID').val();
          if(districtID != '')
          {
           $.ajax({
            url:"<?php echo base_url(); ?>api/getUpaZila",
            method:"POST",
            data:{districtID:districtID},
            success:function(data)
            {
             $('#thanaID').html('');
             $('#thanaID').html(data);
            //$('#city').html('<option value="">Select City</option>');
            }
           });
          }
          else
          {
           $('#thanaID').html('<option value="">--- Select Upazila ---</option>');
           $('#slumID').html('<option value="">--- Select Slum ---</option>');
          }
     });


    $('#thanaID').change(function(){
          var thanaID = $('#thanaID').val();
          if(thanaID != '')
          {
           $.ajax({
            url:"<?php echo base_url(); ?>api/getSlum",
            method:"POST",
            data:{thanaID:thanaID},
            success:function(data)
            {
             $('#slumID').html('');
             $('#slumID').html(data);

             $('#slumID').val('<?php echo $fk_slum_id; ?>').trigger('change');
            }
           });
          }
          else
          {
           $('#slumID').html('<option value="">--- Select Slum ---</option>');
           //$('#city').html('<option value="">Select City</option>');
          }
     });


    $('#slumID').change(function(){
          var slumID = $('#slumID').val();
          if(slumID != '')
          {
           $.ajax({
            url:"<?php echo base_url(); ?>api/getSlumArea",
            method:"POST",
            data:{slumID:slumID},
            success:function(data)
            {
             $('#slumAreaID').html('');
             $('#slumAreaID').html(data);

             $('#slumAreaID').val('<?php echo $fk_slum_area_id; ?>').trigger('change');
            }
           });
          }
          else
          {
           $('#slumAreaID').html('<option value="">--- Select Slum Area ---</option>');
           //$('#city').html('<option value="">Select City</option>');
          }
     });


    $('#migDistrictID').change(function(){
          var migDistrictID = $('#migDistrictID').val();
          if(migDistrictID != '')
          {
           $.ajax({
            url:"<?php echo base_url(); ?>api/getMigUpaZila",
            method:"POST",
            data:{migDistrictID:migDistrictID},
            success:function(data)
            {
             $('#migThanaID').html('');
             $('#migThanaID').html(data);
            //$('#city').html('<option value="">Select City</option>');
            }
           });
          }
          else
          {
           $('#migThanaID').html('<option value="">Please Select</option>');
          }
     });




   var seldistrictId = $('#districtID').val();  
    if (seldistrictId > 0)
    {

         var districtID = $('#districtID').val();
          if(districtID != '')
          {
           $.ajax({
            url:"<?php echo base_url(); ?>api/getUpaZila",
            method:"POST",
            data:{districtID:districtID},
            success:function(data)
            {
             $('#thanaID').html('');

             $('#thanaID').html(data);
             $('#thanaID').val('<?php echo $fk_thana_id; ?>').trigger('change');
            }
           });

          }   

    }

    var selThanaId = '<?php echo $fk_thana_id; ?>';

    if (selThanaId > 0)
    {

         var thanaID = selThanaId;
          if(thanaID != '')
          {
           $.ajax({
            url:"<?php echo base_url(); ?>api/getSlum",
            method:"POST",
            data:{thanaID:thanaID},
            success:function(data)
            {
             $('#slumID').html('');

             $('#slumID').html(data);
             $('#slumID').val('<?php echo $fk_slum_id; ?>').trigger('change');
            }
           });

          }   

    }

    var selSlumId = '<?php echo $fk_slum_id; ?>';

    if (selSlumId > 0)
    {

         var slumID = selSlumId;
          if(slumID != '')
          {
           $.ajax({
            url:"<?php echo base_url(); ?>api/getSlumArea",
            method:"POST",
            data:{slumID:slumID},
            success:function(data)
            {
             $('#slumAreaID').html('');

             $('#slumAreaID').html(data);
             $('#slumAreaID').val('<?php echo $fk_slum_area_id; ?>').trigger('change');
            }
           });

          }   

    }



   var migDistrictID = $('#migDistrictID').val();  
    if (migDistrictID > 0)
    {

         var migDistrictID = $('#migDistrictID').val();
          if(migDistrictID != '')
          {
           $.ajax({
            url:"<?php echo base_url(); ?>api/getMigUpaZila",
            method:"POST",
            data:{migDistrictID:migDistrictID},
            success:function(data)
            {
             $('#migThanaID').html('');

             $('#migThanaID').html(data);
             $('#migThanaID').val('<?php echo $fk_thana_id_from; ?>').trigger('change');
            }
           });

          }   

    }


    $('#migThanaID').change(function(){
          var thanaID = $('#migThanaID').val();
          if(thanaID != '')
          {
           $.ajax({
            url:"<?php echo base_url(); ?>api/getSlum",
            method:"POST",
            data:{thanaID:thanaID},
            success:function(data)
            {
             $('#slumIDFrom').html('');
             $('#slumIDFrom').html(data);
             $('#slumIDFrom').val('<?php echo $fk_slum_id_from; ?>').trigger('change');

            }
           });
          }
          else
          {
           $('#slumIDFrom').html('<option value="">--- Select Slum ---</option>');
          
          }
     });

    $('#slumIDFrom').change(function(){
          var slumID = $('#slumIDFrom').val();
          if(slumID != '')
          {
           $.ajax({
            url:"<?php echo base_url(); ?>api/getSlumArea",
            method:"POST",
            data:{slumID:slumID},
            success:function(data)
            {
             $('#slumAreaIDFrom').html('');
             $('#slumAreaIDFrom').html(data);
             $('#slumAreaIDFrom').val('<?php echo $fk_slumArea_id_from; ?>').trigger('change');

            }
           });
          }
          else
          {
           $('#slumAreaIDFrom').html('<option value="">--- Select Slum Area ---</option>');
          }
     });



 });


</script>