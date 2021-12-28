<script type="text/javascript">
 $(function () {
   $('#datepicker').datepicker({
     autoclose: true,
     format: 'dd/mm/yyyy'
   });
 });

$( document ).ready(function() {

    $("#entryType").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");

           //alert (optionValue);
            if(optionValue == 14)
            {
               $(".migrationReason").prop('required',false);
               $(".migreasonOth").prop('required',false);
               $(".migration").hide();
               $(".migrationOth").hide();
               $(".internal").hide();

            }
            else if(optionValue == 15)
            {
               $(".migrationReason").prop('required',true);
               $(".migreasonOth").prop('required',false);
               $(".mig").show();
               $(".migration").show();
               $(".migin").show();
               $(".internal").hide();
			   $(".intn").hide();
			   
			   $('#countryID').val('').trigger('change');

            } 
			else if(optionValue == 17)
            {
               $(".migrationReason").prop('required',false);
               $(".migreasonOth").prop('required',false);
               $(".migration").hide();
               $(".migrationOth").hide();
               $(".internal").hide();
			 

            }
            else {

               $(".migrationReason").prop('required',false);
               $(".migreasonOth").prop('required',false);
			   $(".intn").show();
			   $('#countryID').val('19').trigger('change');
			   $(".migration").show();
               $(".internal").show();
			   $(".mig").hide();
			   $(".migin").hide();
            }
        });
    }).change();

    $("#migrationReason").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");

            if(optionValue == 12)
            {
              // $(".migrationReason").prop('required',fals 
               $(".migreasonOth").prop('required',true);
               $(".migrationOth").show();

            } else{

               $(".migreasonOth").prop('required',false);
               $(".migrationOth").hide();
            }
        });
    }).change();

});
</script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <div class="row">
		    <div class="col-xs-7 text-left header-margin ">
	              <h3>
					<?php echo $pageTitle; ?>
					
					<?php $baseID = $this->input->get('baseID',TRUE); ?>
				  </h3>
               
            </div>
            <div class="col-xs-5 text-right">
                <div class="form-group margin5pxBot">
                        <a class="btn btn-primary" href="<?php echo base_url().$controller.'?baseID='.$baseID ?>"><?php echo $shortName ?> List</a>
                </div>
            </div>
        </div>
    </section>
    
    <section class="content content-margin">    
        <div class="row">
           
            <div class="col-md-12">
              <!-- general form elements -->
                
                
                
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
                    <?php if($roundStstus == 0) : ?>
                     <h4 style="padding-left:10px; color:red"> Round is closed now, You can't add any household </h4>

                     <?php endif; ?>
            
                    <form role="form" id="addUser" action="<?php echo base_url().$controller.'/'.$actionMethod.'?baseID='.$baseID?>" method="post" role="form">
                        <div class="box-body">
                            <div class="row">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">District <span style="color:red">*</span></label>
                                        
                                        <select class="form-control" id="districtID"  name="districtID" required>
                                           <option value="">--- Select District ---</option>
                                            <?php
                                            if(!empty($district))
                                            {
                                                foreach ($district as $district)
                                                {
                                                    ?>
                                                    <option value="<?php echo $district->id ?>"><?php echo $district->code. '-' .$district->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">City area <span style="color:red">*</span></label>

                                        <select  class="form-control required" id="thanaID" name="thanaID" required>
                                            <option value="">--- Select City area ---</option>
                                        </select>
                                    </div>
                                </div>

                               <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Slum Name<span style="color:red">*</span></label>
                                        
                                        <select class="form-control required" id="slumID" name="slumID" required>
                                           <option value="">--- Select Slum Name---</option>
                                        </select>
                                    </div>
                                </div>

                                 <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Slum Area <span style="color:red">*</span></label>
                                        
                                        <select class="form-control required" id="slumAreaID" name="slumAreaID" required>
                                           <option value="">--- Select Slum Area ---</option>
                                           
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Name of Bariwala <span style="color:red">*</span></label>
                                        <input type="text" class="form-control required" id="bariwallaName" placeholder="Name of Bariwalla" name="bariwallaName" maxlength="255" required="required">
                                    </div>
                                </div>
                           
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Bari Number <span style="color:red">*</span></label>
                                        <input type="text" class="form-control required" id="bariNumber" placeholder="Bari Number"  name="bariNumber" minlength="4" maxlength="5" size="10" required="required">
                                    </div>
                                </div>

                                 <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Name of Household head <span style="color:red">*</span></label>
                                        <input type="text" class="form-control required" id="headName" placeholder="Name of Household head"  name="headName" maxlength="255" required="required">
                                    </div>
                                </div>

                                 <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">How long living here (Year)</label>
                                        <input type="text" class="form-control required" id="livingYear" placeholder="Living Year"  name="livingYear" minlength="1" maxlength="2" size="10" >
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">How long living here (Month)</label>
                                        <input type="text" class="form-control required" id="livingMonth" placeholder="Living Month"  name="livingMonth" minlength="1" maxlength="2" size="10" >
                                    </div>
                                </div>
             
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Active">Entry type <span style="color:red">*</span></label>
                                        <select class="form-control required" id="entryType" name="entryType" required>
                                            <option value="">Please Select</option>
                                           <?php
                                            if(!empty($entryType))
                                            {
                                                foreach ($entryType as $entryType)
                                                {
                                                    ?>
                                                    <option value="<?php echo $entryType->id ?>"><?php echo $entryType->code. '-' .$entryType->name ?></option>
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
                                        <input type="text" class="form-control required" id="datepicker" placeholder="Entry Date"  name="entryDate" maxlength="255" required="required">
                                    </div>
                                </div> 
								<div class="col-md-3 migin">
                                    <div class="form-group">
                                        <label for="Item Name">How long ago left from Permanent address </label>
                                        <input type="text" class="form-control required" id="leftSlum" placeholder="Month"  name="leftSlum" minlength="1" maxlength="2" size="10" >
                                    </div>
                                </div>
                                <div class="col-md-3 migration" >
                                    <div class="form-group">
                                        <label for="Active"><span class="mig">Migration cause</span> <span class="intn">Internal cause</span></label>
                                        <select class="form-control required migrationReason" id="migrationReason" name="migrationReason">
                                            <option value="">Please Select</option>
                                            <?php
                                            if(!empty($migrationReason))
                                            {
                                                foreach ($migrationReason as $mig)
                                                {
                                                    ?>
                                                    <option value="<?php echo $mig->id ?>"><?php echo $mig->code. '-' .$mig->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            
                                        </select>
                                    </div>
                                </div>  
                                <div class="col-md-3 migration">
                                    <div class="form-group">
                                        <label for="Active"><span class="mig">Migrated</span> <span class="intn">Internal</span> from country</label>
                                        <select class="form-control required" id="countryID" name="countryID">
                                            <option value="">Please Select</option>
                                           <?php
                                            if(!empty($country))
                                            {
                                                foreach ($country as $country)
                                                {
                                                    ?>
                                                    <option value="<?php echo $country->id ?>"><?php echo $country->code. '-' .$country->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            
                                        </select>
                                    </div>
                                </div> 
                                <div class="col-md-3 migration">
                                    <div class="form-group">
                                        <label for="Active"><span class="mig">Migrated</span> <span class="intn">Internal</span> from district</label>
                                        <select class="form-control required" id="migDistrictID" name="migDistrictID" >
                                            <option value="">Please Select</option>
                                            <?php
                                            if(!empty($district2))
                                            {
                                                foreach ($district2 as $dist)
                                                {
                                                    ?>
                                                    <option value="<?php echo $dist->id ?>"><?php echo $dist->code. '-' .$dist->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 migration">
                                    <div class="form-group">
                                        <label for="Active"><span class="mig">Migrated</span> <span class="intn">Internal</span> from upazila</label>

                                         <select  class="form-control required" id="migThanaID" name="migThanaID">
                                            <option value="">Please Select</option>
                                        </select>
                                        
                                    </div>
                                </div>

                                

                                <div class="col-md-12 migrationOth">
                                    <div class="form-group">
                                        <label for="Item Name"><span class="mig">Migrated</span> <span class="intn">Internal</span> reason (Others)</label>
                                        <input type="text" class="form-control migreasonOth" id="migreasonOth"  name="migreasonOth" maxlength="255">
                                    </div>
                                </div>

                                <div class="col-md-3 internal">
                                    <div class="form-group">
                                        <label for="Item Name">Slum Name From <span style="color:red">*</span></label>
                                        
                                        <select class="form-control required" id="slumIDFrom" name="slumIDFrom">
                                           <option value="">--- Select Slum Name---</option>
                                        </select>
                                    </div>
                                </div>

                                 <div class="col-md-3 internal">
                                    <div class="form-group">
                                        <label for="Item Name">Slum Area From<span style="color:red">*</span></label>
                                        
                                        <select class="form-control required" id="slumAreaIDFrom" name="slumAreaIDFrom">
                                           <option value="">--- Select Slum Area ---</option>
                                           
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Current Round no <span style="color:red">*</span></label>
                                        <input type="text" class="form-control required" id="round"  name="round_master_id" value="<?php echo $roundid ?>" disabled="disabled">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Contact no <span style="color:red">*</span></label>
                                        <input type="text" class="form-control required" id="contactNumber" placeholder="Contact no"  name="contactNumber" maxlength="11" required="required">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Active">Contact source type <span style="color:red">*</span></label>
                                        <select class="form-control required" id="contactSource" name="contactSource" required>
                                            <option value="">Please Select</option>
                                             <?php
                                            if(!empty($hhcontacttyp))
                                            {
                                                foreach ($hhcontacttyp as $contact)
                                                {
                                                    ?>
                                                    <option value="<?php echo $contact->id ?>"><?php echo $contact->code. '-' .$contact->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            
                                        </select>
                                    </div>
                                </div>



                            </div>
                        </div><!-- /.box-body -->
                       <?php if($roundStstus == 1) : ?>
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Save" />
                            <input type="reset" class="btn btn-default" value="Reset" />
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
           $('#thanaID').html('<option value="">--- Select City area ---</option>');
           $('#slumID').html('<option value="">--- Select Slum Name---</option>');
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

            //$('#city').html('<option value="">Select City</option>');
            }
           });
          }
          else
          {
           $('#slumID').html('<option value="">--- Select Slum Name---</option>');
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

             //console.log(data);
            //$('#city').html('<option value="">Select City</option>');
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



    $("#livingYear").keydown(function(event) {
        // Allow only backspace and delete
        if ( event.keyCode == 46 || event.keyCode == 8 ) {
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.keyCode < 48 || event.keyCode > 57 ) {
                event.preventDefault(); 
            }   
        }
    });

    $("#livingMonth").keydown(function(event) {
        // Allow only backspace and delete
        if ( event.keyCode == 46 || event.keyCode == 8 ) {
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.keyCode < 48 || event.keyCode > 57 ) {
                event.preventDefault(); 
            }   
        }
    });

    $("#leftSlum").keydown(function(event) {
        // Allow only backspace and delete
        if ( event.keyCode == 46 || event.keyCode == 8 ) {
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.keyCode < 48 || event.keyCode > 57 ) {
                event.preventDefault(); 
            }   
        }
    });


    $("#countryID").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");
            
            if(optionValue == 19)
            {
                $("#migDistrictID").prop("disabled", false);
                $("#migThanaID").prop("disabled", false);

            } 
            else{

                
                $("#migDistrictID").prop("disabled", true);
                $("#migThanaID").prop("disabled", true);
            }

        });
    }).change();




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

            }
           });
          }
          else
          {
           $('#slumIDFrom').html('<option value="">--- Select Slum Name---</option>');
          
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