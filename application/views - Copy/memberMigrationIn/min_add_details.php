
<?php 
    $member_master_id = 0;
    $fk_marital_status = 0;
    $member_code = '';
    $member_name = '';
    $sexName = '';
    $sexCode = '';

    if (!empty($memberInfo)) 
    { 

        $member_master_id = $memberInfo[0]->id; 
        $member_name = $memberInfo[0]->member_name; 
        $member_code = $memberInfo[0]->member_code; 
        $sexCode = $memberInfo[0]->sexCode; 
        $sexName = $memberInfo[0]->sexName; 
        $fk_marital_status = $memberInfo[0]->fk_marital_status; 

    } 

?>


<?php $baseID = $this->input->get('baseID',TRUE); ?>


                    <form action="<?php echo base_url().'memberMigrationIn/addMigrationDetails?baseID='.$baseID ?>" id="myForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8">

                    <!-- SmartWizard html -->
                  
                           
                     
                            <div id="migin" style="padding-left: 20px; padding-right: 20px">
                                <h4>Movement/migration In details Details</h4>
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
															<option value="<?php echo $memberexittyp->id ?>"><?php echo $memberexittyp->code. '-' .$memberexittyp->name ?></option>
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
												<input type="text" class="form-control" data-provide="datepicker-inline" id="movement_date"  name="movement_date" required>
											</div>
										</div>
										
										
										
										
										<div class="col-md-3 internal">
											<div class="form-group">
												<label for="Active">Member code<input type="reset" id="reset" class="btn btn-danger" name="reset" value="Reset" /></label>
												 <input type="hidden" name="member_id" class="form-control" id="householdid" placeholder="member name">
												 <input type="hidden" name="member_code" class="form-control" id="householdcode" placeholder="member code">
												 <input type="text" name="member_master_id_bride_groom" class="form-control bride_groom_ID" id="bride_groom_ID" placeholder="Type member name or member code">
												 <input type="text" name="full_code" class="form-control bride_groom_ID_full" id="bride_groom_ID_full" placeholder="Type member name or member code">
											</div>
										</div>
										

										<div class="col-md-3 migration">
											<div class="form-group">
												<label for="Active">Member code<input type="reset" id="resetin" class="btn btn-danger" name="reset" value="Reset" /></label>
												 <input type="hidden" name="member_idin" class="form-control" id="householdidin" placeholder="member name">
												 <input type="hidden" name="member_codein" class="form-control" id="householdcodein" placeholder="member code">
												 <input type="text" name="member_master_id_bride_groomin" class="form-control bride_groom_IDin" id="bride_groom_IDin" placeholder="Type member name or member code">
												 <input type="text" name="full_codein" class="form-control bride_groom_ID_fullin" id="bride_groom_ID_fullin" placeholder="Type member name or member code">
											</div>
										</div>

										<div class="col-md-1 migration">
										   <label for="Item Name"> Member </label> <!--data-backdrop="static" data-keyboard="false"-->
										   <button title="Add Member" data-toggle="modal" data-target="#view-modal"  data-id="<?php echo $household_master_id_sub; ?>" id="addMember" class="btn btn-sm btn-success"><i class="fa fa-plus"></i></button>   
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
															<option value="<?php echo $internal_movement_cause->id ?>"><?php echo $internal_movement_cause->code. '-' .$internal_movement_cause->name ?></option>
															<?php
														}
													}
													?>
													
												</select>
											</div>
										</div>
										
										<div class="col-md-4 internal">
											<div class="form-group">
												<label for="Item Name">From Slum <span style="color:red">*</span></label>
												
												<select class="form-control required slumID" id="slumID" name="slumID">
													<option value="">Please Select</option>
												   <?php
													if(!empty($slumlist))
													{
														foreach ($slumlist as $slum)
														{
															?>
															<option value="<?php echo $slum->id ?>"><?php echo $slum->code. '-' .$slum->name ?></option>
															<?php
														}
													}
													?>
												</select>
											</div>
										</div>

										 <div class="col-md-4 internal">
											<div class="form-group">
												<label for="Item Name">From Slum Area <span style="color:red">*</span></label>
												
												<select class="form-control required slumAreaID" id="slumAreaID" name="slumAreaID">
												   <option value="">--- Select Slum Area ---</option>
												   
												</select>
											</div>
										</div>

										 <div class="col-md-4 internal">
											<div class="form-group">
												<label for="Item Name"> From Household Code <span style="color:red">*</span></label>
												
												<select class="form-control required househodID" id="househodID" name="househodID">
												   <option value="">--- Select Household ---</option>
												   
												</select>
											</div>
										</div>
										
										<div class="col-md-4 migration">
											<div class="form-group">
												<label for="Item Name">Cause of in-migration <span style="color:red">*</span></label>
												
												<select class="form-control fk_migration_cause" id="fk_migration_cause"  name="fk_migration_cause">
												   <option value="0">Select cause of in-migration</option>
													<?php
													if(!empty($outside_cause))
													{
														foreach ($outside_cause as $outsidecausegroup)
														{
															?>
															<option value="<?php echo $outsidecausegroup->id ?>"><?php echo $outsidecausegroup->code. '-' .$outsidecausegroup->name ?></option>
															<?php
														}
													}
													?>
												</select>
											</div>
										</div>
										
										<div class="col-md-4 migration">
											<div class="form-group">
												<label for="Item Name">Country From<span style="color:red">*</span></label>
												
												<select class="form-control countryID" id="countryID"  name="countryID">
												   <option value="0">--- Select Country ---</option>
													<?php
													if(!empty($countrylist))
													{
														foreach ($countrylist as $country)
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
										
										<div class="col-md-4 migration country">
											<div class="form-group">
												<label for="Item Name">Division From</label>
												
												<select class="form-control" id="divisionID"  name="divisionID">
												   <option value="0">--- Select Division ---</option>
													<?php
													if(!empty($divisionlist))
													{
														foreach ($divisionlist as $division)
														{
															?>
															<option value="<?php echo $division->id ?>"><?php echo $division->code. '-' .$division->name ?></option>
															<?php
														}
													}
													?>
												</select>
											</div>
										</div>
										
										<div class="col-md-4 migration country">
											<div class="form-group">
												<label for="Item Name">District From</label>
												
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
												<label for="Item Name">Upazila From</label>

												<select  class="form-control required" id="thanaID" name="thanaID">
													<option value="0">--- Select Upazila ---</option>
												</select>
											</div>
										</div>
										
										
										 <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="email">Remarks (if any)</span></label>
                                               
                                                <textarea  class="form-control" name="remarks"></textarea>
                                               
                                            </div>
                                        </div>
									 
									 </fieldset>

                                    </div>
 
                                </div>

                            </div>

                            
                            
							 
                             <div class="box-footer" style="margin-left: 10px">
                                <input type="hidden" name="household_master_id_sub" value="<?php echo  $household_master_id_sub  ?>">
                                <input type="hidden" name="round_master_id" value="<?php echo  $round_master_id  ?>">
                                <input type="submit" class="btn btn-primary btnVisile" name="submit" value="Save" />
                                <a class="btn btn-primary" href="<?php echo base_url().'householdvisit/migin?baseID='.$baseID.'#migin' ?>" class="">Back </a>
                               
                            </div>
							
							
                       
								<div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none; z-index:9999">
									<div class="modal-dialog"> 
										<div class="modal-content" style="margin-top:-60px;">  

											<div class="modal-header"> 
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
												<h4 class="modal-title">
													<i class="glyphicon glyphicon-plus"></i> Member Migration In
												</h4>
											</div> 

											<div class="modal-body" style="padding:0px">                     
												<div id="modal-loader" style="display: none; text-align: center;">
													<!-- ajax loader -->

												</div>

												<!-- mysql data will be load here -->                          
												<div id="mig-content"></div>
											</div> 

											<div class="modal-footer"> 
												<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>  
											</div> 

										</div> 
									</div>
								</div>
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
			
            if(optionValue == 134) // internal in
            {
               $(".fk_internal_cause").prop('required',true);
               $(".househodID").prop('required',true);
               $(".slumID").prop('required',true);
               $(".slumAreaID").prop('required',true);
			   $(".countryID").prop('required',false);
			   $(".fk_migration_cause").prop('required',false);
			  // $(".bride_groom_ID").prop('required',true);
               $(".bride_groom_ID").prop('required',true);

			   $(".bride_groom_IDin").prop('required',false);
             // $(".bride_groom_ID_fullin").prop('required',false);


               $(".internal").show();
			   $(".migration").hide();

            } 
			else if (optionValue == 22){  // migration in

               $(".countryID").prop('required',true);
               $(".bride_groom_IDin").prop('required',true);
               $(".bride_groom_ID").prop('required',false);
               //$(".bride_groom_ID_fullin").prop('required',true);

 			  // $(".bride_groom_ID").prop('required',false);
              // $(".bride_groom_ID_full").prop('required',false);


			   $("#fk_migration_cause").prop('required',true);
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
			   $(".fk_migration_cause").prop('required',false);
			   $(".bride_groom_IDin").prop('required',false);
               $(".bride_groom_ID_fullin").prop('required',false);
			   // internal
			   $(".bride_groom_ID").prop('required',false);
               $(".bride_groom_ID_full").prop('required',false);

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
             $('#househodID').html('');
             $('#househodID').html(data);

            }
           });
          }
          else
          {
           $('#househodID').html('<option value="">--- Select Household ---</option>');
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
			 $('#thanaID').html('<option value="">--- Select Upazila ---</option>');
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
             $('#thanaID').html('');
             $('#thanaID').html(data);
            }
           });
          }
          else
          {
           $('#thanaID').html('<option value="">--- Select Upazila ---</option>');
          }
     });



});


</script>

     <script type="text/javascript">
        $(document).ready(function(){
            $('#bride_groom_ID_full').hide();
			$('#reset').hide();
            $('#bride_groom_ID').autocomplete(
            {
                source: "<?php echo site_url('api/get_autocomplete_member_internal');?>",
                minLength: 3,
				
      
                select: function (event, ui) 
                {
                    //$(this).val(ui.item.member);
                    $('#householdid').val(ui.item.value);
                    $('#householdcode').val(ui.item.house);
					
					$('#bride_groom_ID').hide();
					$('#bride_groom_ID_full').show();
					$('#reset').show();
                    $('#bride_groom_ID_full').val(ui.item.label);
                }
            });
			
			$('#reset').on('click',function(e){
				e.preventDefault();
				$('#bride_groom_ID').show();
				$('#bride_groom_ID').val('');
				$('#householdid').val('');
                $('#householdcode').val('');
				$('#bride_groom_ID_full').val('');
				$('#bride_groom_ID_full').hide();
				$('#reset').hide();
			});
 
        });
		
		
		
		$(document).ready(function(){
            $('#bride_groom_ID_fullin').hide();
			$('#resetin').hide();
            $('#bride_groom_IDin').autocomplete(
            {
                source: "<?php echo site_url('api/get_autocomplete_member_in');?>",
                minLength: 3,
				
      
                select: function (event, ui) 
                {
                    //$(this).val(ui.item.member);
                    $('#householdidin').val(ui.item.value);
                    $('#householdcodein').val(ui.item.house);
					
					$('#bride_groom_IDin').hide();
					$('#bride_groom_ID_fullin').show();
					$('#resetin').show();
                    $('#bride_groom_ID_fullin').val(ui.item.label);
                }
            });
			
			$('#resetin').on('click',function(e){
				e.preventDefault();
				$('#bride_groom_IDin').show();
				$('#bride_groom_IDin').val('');
				$('#householdidin').val('');
                $('#householdcodein').val('');
				$('#bride_groom_ID_fullin').val('');
				$('#bride_groom_ID_fullin').hide();
				$('#resetin').hide();
			});
 
        });
		
		
    </script>
	
	
	<script type="text/JavaScript">
    $(document).ready(function(){

		$(document).on('click', '#addMember', function(e){

			e.preventDefault();

			var uid = $(this).data('id'); // get id of clicked row
			
			
			$('#mig-content').html(''); // leave this div blank
			//$('#modal-loader').show();      // load ajax loader on button click

			$.ajax({
				url: '<?php echo base_url() ?>memberMigration/addNew',
				type: 'POST',
				data: 'id='+uid,
				dataType: 'html'
			})
			.done(function(data){
				//console.log(data); 
				$('#mig-content').html(''); // blank before load.
				$('#mig-content').html(data); // load here
				//$('#modal-loader').hide(); // hide loader  
			})
			.fail(function(){
				$('#mig-content').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
				//$('#modal-loader').hide();
			});

		});
    
    });
</script>