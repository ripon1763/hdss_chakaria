
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


                    <form action="<?php echo base_url().'memberMarriageStart/addMarriageDetails?baseID='.$baseID ?>" id="myForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8">

                    <!-- SmartWizard html -->
                  
                           
                     
                            <div id="mstart" style="padding-left: 20px; padding-right: 20px">
                                <h4>Marriage Details</h4>
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
                                     <legend class="scheduler-border"><?php if ($sexCode==1) { echo "Husband ";} else { echo "Wife "; } ?> details</legend>


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
										
										<div class="col-md-6">
											<div class="form-group">
												<label for="Active">Previous marital status <span style="color:red">*</span></label>
												<select class="form-control required" id="fk_member_premarital_status" name="fk_member_premarital_status" required>
													<option value="">Please Select</option>
													 <?php
													if(!empty($maritalstatustyp))
													{
														foreach ($maritalstatustyp as $maritaltyp)
														{
															?>
															<option <?php if($fk_marital_status == $maritaltyp->id) { echo "selected=selected";} ?> value="<?php echo $maritaltyp->id ?>"><?php echo $maritaltyp->code. '-' .$maritaltyp->name ?></option>
															<?php
														}
													}
													?>
													
												</select>
											</div>
										</div>
										
										<div class="col-md-6">
											<div class="form-group">
												<label for="Active">Marriage order <span style="color:red">*</span></label>
												<select class="form-control required" id="fk_member_marital_order" name="fk_member_marital_order" required>
													<option value="">Please Select</option>
													 <?php
													if(!empty($marriage_order))
													{
														foreach ($marriage_order as $marriageorder)
														{
															?>
															<option value="<?php echo $marriageorder->id ?>"><?php echo $marriageorder->code. '-' .$marriageorder->name ?></option>
															<?php
														}
													}
													?>
													
												</select>
											</div>
										</div>
										
									</fieldset>
									 <fieldset class="scheduler-border">
                                     <legend class="scheduler-border"><?php if ($sexCode==1) { echo "Wife ";} else { echo "Husband "; } ?>details</legend>
									 
									
                                     
									 
									    <div class="col-md-4">
											<div class="form-group">
												<label for="Active"><?php if ($sexCode==1) { echo "Wife ";} else { echo "Husband "; } ?>Member code (blank if not DSS member) <input type="reset" id="reset" class="btn btn-danger" name="reset" value="Reset" /></label>
												 <input type="hidden" name="member_id" class="form-control" id="householdid" placeholder="member name">
												 <input type="hidden" name="member_code" class="form-control" id="householdcode" placeholder="member code">
												 <input type="text" name="member_master_id_bride_groom" class="form-control" id="bride_groom_ID" placeholder="Type member name or member code">
												 <input type="text" name="full_code" class="form-control" id="bride_groom_ID_full" placeholder="Type member name or member code">
											</div>
										</div>
										
										<div class="col-md-4">
											<div class="form-group">
												<label for="Item Name"><?php if ($sexCode==1) { echo "Wife ";} else { echo "Husband "; } ?>Name </label>
												<input type="text" class="form-control" id="membname"  name="name">
											</div>
										</div>
										
										<div class="col-md-4">
											<div class="form-group">
												<label for="Item Name"><?php if ($sexCode==1) { echo "Wife ";} else { echo "Husband "; } ?> Age </label>
												<input type="number" class="form-control" id="age"  name="age">
											</div>
										</div>
										
										<div class="col-md-4">
											<div class="form-group">
												<label for="Item Name"><?php if ($sexCode==1) { echo "Wife ";} else { echo "Husband "; } ?> Date of birth</label>
												<input type="text" class="form-control" data-provide="datepicker-inline" id="dob"  name="dob">
											</div>
										</div>
										
										
										<div class="col-md-4">
											<div class="form-group">
												<label for="Active"><?php if ($sexCode==1) { echo "Bride ";} else { echo "Groom "; } ?>Previous marital status <span style="color:red">*</span></label>
												<select class="form-control required" id="fk_bri_gem_premarital_status" name="fk_bri_gem_premarital_status" required>
													<option value="">Please Select</option>
													 <?php
													if(!empty($maritalstatustyp))
													{
														foreach ($maritalstatustyp as $maritaltypg)
														{
															?>
															<option  value="<?php echo $maritaltypg->id ?>"><?php echo $maritaltypg->code. '-' .$maritaltypg->name ?></option>
															<?php
														}
													}
													?>
													
												</select>
											</div>
										</div>
										
										<div class="col-md-4">
											<div class="form-group">
												<label for="Active"><?php if ($sexCode==1) { echo "Bride ";} else { echo "Groom "; } ?>Marriage order <span style="color:red">*</span></label>
												<select class="form-control required" id="fk_bri_gem_marital_order" name="fk_bri_gem_marital_order" required>
													<option value="">Please Select</option>
													 <?php
													if(!empty($marriage_order))
													{
														foreach ($marriage_order as $marriageorderg)
														{
															?>
															<option value="<?php echo $marriageorderg->id ?>"><?php echo $marriageorderg->code. '-' .$marriageorderg->name ?></option>
															<?php
														}
													}
													?>
													
												</select>
											</div>
										</div>
									 
									 </fieldset>
									 
									 <fieldset class="scheduler-border">
                                     <legend class="scheduler-border">Marriage Information</legend>
									 
										<div class="col-md-4">
											<div class="form-group">
												<label for="Item Name">Marriage date <span style="color:red">*</span></label>
												<input type="text" class="form-control" data-provide="datepicker-inline" id="marriage_date"  name="marriage_date" required>
											</div>
										</div>

									   
										<!--<div class="col-md-4">
											<div class="form-group">
												<label for="Active">Is kazi registered? <span style="color:red">*</span></label>
												<select class="form-control required" id="fk_kazi_registered" name="fk_kazi_registered" required>
													<option value="">Please Select</option>
													 <?php
													if(!empty($marriage_registration))
													{
														foreach ($marriage_registration as $marriageregistration)
														{
															?>
															<option value="<?php echo $marriageregistration->id ?>"><?php echo $marriageregistration->code. '-' .$marriageregistration->name ?></option>
															<?php
														}
													}
													?>
													
												</select>
											</div>
										</div>-->
										<!--<div class="col-md-4">
											<div class="form-group">
												<label for="Active">Is this marriage start event? <span style="color:red">*</span></label>
												<select class="form-control required" id="is_event" name="is_event" required>
													<option value="Yes">Yes</option>
													<option value="No">No</option>
													 
													
												</select>
											</div>
										</div> -->
										
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
                                <input type="hidden" name="member_master_id" value="<?php echo  $member_master_id  ?>">
                                <input type="submit" class="btn btn-primary btnVisile" name="submit" value="Save" />
                                <a class="btn btn-primary" href="<?php echo base_url().'householdvisit/marriage_start?baseID='.$baseID.'#mstart' ?>" class="">Back </a>
                               
                            </div>
							
							
                       

                     </form>

                    
                   
                  
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>

     <script type="text/javascript">
        $(document).ready(function(){
            $('#bride_groom_ID_full').hide();
			$('#reset').hide();
            $('#bride_groom_ID').autocomplete(
            {
                source: "<?php echo site_url('api/get_autocomplete_member');?>",
                minLength: 1,
				
      
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
		
		
    </script>