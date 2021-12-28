
<?php $baseID = $this->input->get('baseID',TRUE); ?>
 <?php 
    $id = 0;
    $member_master_id = 0;
    $household_master_id = 0;
    $movement_date = '';
	$sexCode = '';
    $sexName = '';
	$roundNo = 0;
	$member_code = '';
    $member_name = '';
    $fk_movement_type = 0;
    $fk_internal_cause = 0;
    $slumIDTo = 0;
    $slumAreaIDTo = 0;
    $household_master_id_move_to = 0;
    $fk_outside_cause_group = 0;
    $remarks = '';
    $fk_type_of_group = 0;
    $fk_outside_cause_individual = 0;
    $countryIDMoveTo = 0;
    $divisionIDMoveTo = 0;
    $districtIDMoveTo = 0;
    $thanaIDMoveTo = 0;


    if (!empty($moutRecordRecord)) 
    { 

        $id = $moutRecordRecord[0]->id; 
		$sexCode = $moutRecordRecord[0]->sexCode; 
		$sexName = $moutRecordRecord[0]->sexName; 
		$member_code = $moutRecordRecord[0]->member_code; 
		$member_name = $moutRecordRecord[0]->member_name; 
        $roundNo = $moutRecordRecord[0]->roundNo; 
        $member_master_id = $moutRecordRecord[0]->member_master_id; 
        $household_master_id = $moutRecordRecord[0]->household_master_id; 
        $remarks = $moutRecordRecord[0]->remarks; 
        $movement_date = $moutRecordRecord[0]->movement_date; 
        $fk_movement_type = $moutRecordRecord[0]->fk_movement_type; 
        $fk_internal_cause = $moutRecordRecord[0]->fk_internal_cause; 
        $slumIDTo = $moutRecordRecord[0]->slumIDTo; 
        $slumAreaIDTo = $moutRecordRecord[0]->slumAreaIDTo; 
        $household_master_id_move_to = $moutRecordRecord[0]->household_master_id_move_to; 
        $fk_type_of_group = $moutRecordRecord[0]->fk_type_of_group; 
        $fk_outside_cause_individual = $moutRecordRecord[0]->fk_outside_cause_individual; 
        $fk_outside_cause_group = $moutRecordRecord[0]->fk_outside_cause_group; 
        $countryIDMoveTo = $moutRecordRecord[0]->countryIDMoveTo; 
        $divisionIDMoveTo = $moutRecordRecord[0]->divisionIDMoveTo; 
        $districtIDMoveTo = $moutRecordRecord[0]->districtIDMoveTo; 
        $thanaIDMoveTo = $moutRecordRecord[0]->thanaIDMoveTo; 
		

    } 

    ?>

                    <form action="<?php echo base_url().'memberMigrationOut/editMigrationDetails?baseID='.$baseID ?>" id="myForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8">

                    <!-- SmartWizard html -->
                  
                           
                     
                            <div id="migout" style="padding-left: 20px; padding-right: 20px">
                                <h4>Movement/Migration Details</h4>
                                 <div class="row">
                                     <div class="col-md-4">
                                          <p>Household Code : <?php echo $householdcode ?></p>
                                     </div>
                                      <div class="col-md-4">
                                         <p>Round Number :  <?php echo $roundNo ?></p>
                                     </div>
                                     
                                </div>

                                <div id="form-step-0" role="form" data-toggle="validator">
                                    <div class="row">

                                       <fieldset class="scheduler-border">
                                     <legend class="scheduler-border">Member Information</legend>


                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Active">Member code : </label>
                                                <?php echo $member_code ?>
                                            </div>
                                        </div>
										<div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Active">Member Name : </label>
                                                <?php echo $member_name ?>
                                            </div>
                                        </div>
										 <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Active">Member sex : </label>
                                                <?php echo $sexCode.'-'.$sexName ?>
                                            </div>
                                        </div>
										
									</fieldset>

									 <fieldset class="scheduler-border">
                                     <legend class="scheduler-border">Movement Information</legend>
									 
										<div class="col-md-4">
											<div class="form-group">
												<label for="Active">Movement type <span style="color:red">*</span></label>
												<select class="form-control required" id="fk_movement_type" name="fk_movement_type" required>
													<option value="">Please Select</option>
													 <?php
													if(!empty($memberexittyp))
													{
														foreach ($memberexittyp as $memberexittyp)
														{
															?>
															<option <?php if($fk_movement_type == $memberexittyp->id) { echo "selected=selected";} ?> value="<?php echo $memberexittyp->id ?>"><?php echo $memberexittyp->code. '-' .$memberexittyp->name ?></option>
															<?php
														}
													}
													?>
													
												</select>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="Item Name">Movement/Migration date <span style="color:red">*</span></label>
												<?php 
												if ($movement_date != "")
                                                   {
                                                    $partsRequire = explode('-', $movement_date);
                                                    $movement_date = $partsRequire[2].'/'.$partsRequire[1].'/'.$partsRequire[0];
                                                   }
												
												?>
												<input type="text" class="form-control" data-provide="datepicker-inline" value="<?php echo $movement_date ?>" id="movement_date"  name="movement_date" required>
											</div>
										</div>
										<div class="col-md-4 internal">
											<div class="form-group">
												<label for="Active">Cause internal of movement <span style="color:red">*</span></label>
												<select class="form-control required fk_internal_cause" id="fk_internal_cause" name="fk_internal_cause">
													<option value="">Please Select</option>
													 <?php
													if(!empty($internal_movement_cause))
													{
														foreach ($internal_movement_cause as $internal_movement_cause)
														{
															?>
															<option <?php if($fk_internal_cause == $internal_movement_cause->id) { echo "selected=selected";} ?> value="<?php echo $internal_movement_cause->id ?>"><?php echo $internal_movement_cause->code. '-' .$internal_movement_cause->name ?></option>
															<?php
														}
													}
													?>
													
												</select>
											</div>
										</div>
										
										<div class="col-md-4 internal">
											<div class="form-group">
												<label for="Item Name">To Slum <span style="color:red">*</span></label>
												
												<select class="form-control required slumID" id="slumID" name="slumID">
													<option value="">Please Select</option>
												   <?php
													if(!empty($slumlist))
													{
														foreach ($slumlist as $slum)
														{
															?>
															<option <?php if($slumIDTo == $slum->id) { echo "selected=selected";} ?> value="<?php echo $slum->id ?>"><?php echo $slum->code. '-' .$slum->name ?></option>
															<?php
														}
													}
													?>
												</select>
											</div>
										</div>

										 <div class="col-md-4 internal">
											<div class="form-group">
												<label for="Item Name">To Slum Area <span style="color:red">*</span></label>
												
												<select class="form-control required slumAreaID" id="slumAreaID" name="slumAreaID">
												   <option value="">--- Select Slum Area ---</option>
												   
												</select>
											</div>
										</div>

										 <div class="col-md-4 internal">
											<div class="form-group">
												<label for="Item Name"> To Household Code <span style="color:red">*</span></label>
												
												<select class="form-control required househodID" id="househodID2" name="househodID">
												   <option value="">--- Select Household ---</option>
												   
												</select>
											</div>
										</div>
										
										
										<div class="col-md-4 migration">
											<div class="form-group">
												<label for="Active">Type of group <span style="color:red">*</span></label>
												<select class="form-control required fk_type_of_group" id="fk_type_of_group" name="fk_type_of_group">
													<option value="">Select type of group</option>
													<?php
													if(!empty($movement_group_typ))
													{
														foreach ($movement_group_typ as $group_typ)
														{
															?>
															<option <?php if($fk_type_of_group == $group_typ->id) { echo "selected=selected";} ?> value="<?php echo $group_typ->id ?>"><?php echo $group_typ->code. '-' .$group_typ->name ?></option>
															<?php
														}
													}
													?>
												</select>
											</div>
										</div>
										
										<div class="col-md-4 migration">
											<div class="form-group">
												<label for="Item Name">Cause of outside (individual) <span style="color:red">*</span></label>
												
												<select class="form-control" id="fk_outside_cause_individual"  name="fk_outside_cause_individual">
												   <option value="0">Select Cause of outside</option>
													<?php
													if(!empty($outside_cause))
													{
														foreach ($outside_cause as $outsidecause)
														{
															?>
															<option <?php if($fk_outside_cause_individual == $outsidecause->id) { echo "selected=selected";} ?> value="<?php echo $outsidecause->id ?>"><?php echo $outsidecause->code. '-' .$outsidecause->name ?></option>
															<?php
														}
													}
													?>
												</select>
											</div>
										</div>
										
										<div class="col-md-4 migration">
											<div class="form-group">
												<label for="Item Name">Cause of outside (Group) <span style="color:red">*</span></label>
												
												<select class="form-control" id="fk_outside_cause_group"  name="fk_outside_cause_group">
												   <option value="0">Select Cause of outside</option>
													<?php
													if(!empty($outside_cause))
													{
														foreach ($outside_cause as $outsidecausegroup)
														{
															?>
															<option <?php if($fk_outside_cause_group == $outsidecausegroup->id) { echo "selected=selected";} ?> value="<?php echo $outsidecausegroup->id ?>"><?php echo $outsidecausegroup->code. '-' .$outsidecausegroup->name ?></option>
															<?php
														}
													}
													?>
												</select>
											</div>
										</div>
										
										<div class="col-md-4 migration">
											<div class="form-group">
												<label for="Item Name">Country <span style="color:red">*</span></label>
												
												<select class="form-control countryID" id="countryID"  name="countryID">
												   <option value="0">--- Select Country ---</option>
													<?php
													if(!empty($countrylist))
													{
														foreach ($countrylist as $country)
														{
															?>
															<option <?php if($countryIDMoveTo == $country->id) { echo "selected=selected";} ?> value="<?php echo $country->id ?>"><?php echo $country->code. '-' .$country->name ?></option>
															<?php
														}
													}
													?>
												</select>
											</div>
										</div>
										
										<div class="col-md-4 migration country">
											<div class="form-group">
												<label for="Item Name">Division</label>
												
												<select class="form-control" id="divisionID"  name="divisionID">
												   <option value="0">--- Select Division ---</option>
													<?php
													if(!empty($divisionlist))
													{
														foreach ($divisionlist as $division)
														{
															?>
															<option <?php if($divisionIDMoveTo == $division->id) { echo "selected=selected";} ?>  value="<?php echo $division->id ?>"><?php echo $division->code. '-' .$division->name ?></option>
															<?php
														}
													}
													?>
												</select>
											</div>
										</div>
										
										<div class="col-md-4 migration country">
											<div class="form-group">
												<label for="Item Name">District</label>
												
												<select class="form-control" id="districtID"  name="districtID">
												   <option value="0">--- Select District ---</option>
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

										<div class="col-md-4 migration country">
											<div class="form-group">
												<label for="Item Name">Upazila</label>

												<select  class="form-control required" id="thanaID2" name="thanaID">
													<option value="0">--- Select Upazila ---</option>
												</select>
											</div>
										</div>
										
										
										 <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="email">Remarks (if any)</span></label>
                                               
                                                <textarea  class="form-control" name="remarks"><?php echo $remarks ?></textarea>
                                               
                                            </div>
                                        </div>
									 
									 </fieldset>
									
                                        


                                    </div>
 
                                </div>

                            </div>

                            
                             <?php if ($id > 0) { ?>
							 
                             <div class="box-footer" style="margin-left: 10px">
                                <input type="hidden" name="household_master_id_sub" value="<?php echo  $household_master_id_sub  ?>">
                                <input type="hidden" name="round_master_id" value="<?php echo  $round_master_id  ?>">
                                <input type="hidden" name="member_master_id" value="<?php echo  $member_master_id  ?>">
                                <input type="hidden" name="migrationID" value="<?php echo  $id  ?>">
                                <input type="submit" class="btn btn-primary btnVisile" name="submit" value="Save" />
                                <a class="btn btn-primary" href="<?php echo base_url().'householdvisit/migout?baseID='.$baseID.'#migout' ?>" class="">Back </a>
                               
                            </div>
							
							 <?php } ?>
                           
                       

                     </form>

                    
                   
                  
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
$( document ).ready(function() {

    $("#fk_movement_type").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");
			
            if(optionValue == 135) // internal
            {
               $(".fk_internal_cause").prop('required',true);
               $(".househodID").prop('required',true);
               $(".slumID").prop('required',true);
               $(".slumAreaID").prop('required',true);
			   $(".countryID").prop('required',false);
			   $(".fk_type_of_group").prop('required',false);
               $(".internal").show();
			   $(".migration").hide();

            } 
			else if (optionValue == 79){  // migration

               $(".countryID").prop('required',true);
			   $(".fk_type_of_group").prop('required',true);
			   $(".fk_internal_cause").prop('required',false);
               $(".househodID").prop('required',false);
               $(".slumID").prop('required',false);
               $(".slumAreaID").prop('required',false);
               $(".internal").hide();
			   $(".migration").show();
            }
			else{
				
				// migration
			   $(".countryID").prop('required',false);
			   $(".fk_type_of_group").prop('required',false);
			   // internal
			   $(".fk_internal_cause").prop('required',false);
               $(".househodID").prop('required',false);
               $(".slumID").prop('required',false);
               $(".slumAreaID").prop('required',false);
				
				$(".internal").hide();
			    $(".migration").hide();
				
			}
        });
    }).change();
	
	
	$("#countryID").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");
			
			if(optionValue == 19)
            {
               $(".country").show();
            } 
			else{
				$(".country").hide();
			}

        });
    }).change();
	
	
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

            }
           });
          }
          else
          {
           $('#slumAreaID').html('<option value="">--- Select Slum Area ---</option>');
          }
     });
	 
	 
	     $('#divisionID').change(function(){
          var divisionID = $('#divisionID').val();
          if(divisionID != '')
          {
           $.ajax({
            url:"<?php echo base_url(); ?>api/getDistrict",
            method:"POST",
            data:{divisionID:divisionID},
            success:function(data)
            {
             $('#districtID').html('');
			 $('#thanaID2').html('<option value="">--- Select Upazila ---</option>');
             $('#districtID').html(data);
            }
           });
          }
          else
          {
           $('#districtID').html('<option value="">--- Select District ---</option>');
          }
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
             $('#thanaID2').html('');
             $('#thanaID2').html(data);
			 $('#thanaID2').val('<?php echo $thanaIDMoveTo; ?>').trigger('change');
            }
           });
          }
          else
          {
           $('#thanaID2').html('<option value="">--- Select Upazila ---</option>');
          }
        });
	 
	    var seldivisionID = $('#divisionID').val();  
		if (seldivisionID > 0)
		{

			 var divisionID = seldivisionID;
			  if(divisionID != '')
			  {
			   $.ajax({
				url:"<?php echo base_url(); ?>api/getDistrict",
				method:"POST",
				data:{divisionID:divisionID},
				success:function(data)
				{
				 $('#districtID').html('');

				 $('#districtID').html(data);
				 $('#districtID').val('<?php echo $districtIDMoveTo; ?>').trigger('change');
				 
				}
			   });

			  }   

		}
   

	    var seldistrictID = <?php echo $districtIDMoveTo; ?>;  
		if (seldistrictID > 0)
		{
			 var districtID = seldistrictID;
			  if(seldistrictID != '')
			  {
			   $.ajax({
				url:"<?php echo base_url(); ?>api/getUpaZila",
				method:"POST",
				data:{districtID:seldistrictID},
				success:function(data)
				{
				 $('#thanaID2').html('');

				 $('#thanaID2').html(data);
				 $('#thanaID2').val('<?php echo $thanaIDMoveTo; ?>').trigger('change');
				}
			   });

			  }   

		}
		
	    var selslumID = $('#slumID').val();  
		if (selslumID > 0)
		{
			 var slumID = selslumID;
			  if(selslumID != '')
			  {
			   $.ajax({
				url:"<?php echo base_url(); ?>api/getSlumArea",
				method:"POST",
				data:{slumID:selslumID},
				success:function(data)
				{
				 $('#slumAreaID').html('');
				 $('#slumAreaID').html(data);
				 $('#slumAreaID').val('<?php echo $slumAreaIDTo; ?>').trigger('change');
				}
			   });

			  }   

		}
		
	$('#slumAreaID').change(function(){
          var slumAreaID = $('#slumAreaID').val();
          if(slumAreaID != '')
          {
           $.ajax({
            url:"<?php echo base_url(); ?>api/getHousehold",
            method:"POST",
            data:{slumAreaID:slumAreaID},
            success:function(data)
            {
             //$('#househodID2').html('');
             $('#househodID2').html(data);
			 $('#househodID2').val('<?php echo $household_master_id_move_to; ?>').trigger('change');

            }
           });
          }
          else
          {
           $('#househodID2').html('<option value="">--- Select Household ---</option>');
          }
     });
		
		var selslumAreaID = <?php echo $slumAreaIDTo; ?>;  
		if (selslumAreaID > 0)
		{
			 var districtID = selslumAreaID;
			  if(selslumAreaID != '')
			  {
			   $.ajax({
				url:"<?php echo base_url(); ?>api/getHousehold",
				method:"POST",
				data:{slumAreaID:selslumAreaID},
				success:function(data)
				{
				 $('#househodID2').html('');
				 $('#househodID2').html(data);
				 $('#househodID2').val('<?php echo $household_master_id_move_to; ?>').trigger('change');
				}
			   });

			  }   

		}
		
		

		




});


</script>