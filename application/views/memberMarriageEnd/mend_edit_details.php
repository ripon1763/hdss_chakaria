
<?php $baseID = $this->input->get('baseID',TRUE); ?>
 <?php 
    $id = 0;
    $member_master_id = 0;
    $household_master_id = 0;
    $fk_marriage_end_type = 0;
    $fk_marriage_end_cause_one = 0;
    $fk_marriage_end_cause_two = 0;
    $fk_marriage_end_cause_three = 0;

    $member_master_id_bride_groom = 0;
    $roundNo = 0;
	$member_code = '';
    $member_name = '';
    $sexCode = '';
    $sexName = '';
    $marriage_end_date = '';
    $is_event = '';
    $remarks = '';
    $spauseCode = '';
    $spauseName = '';
	
	$name = '';
    $dob = '';
    $age = 0;


    if (!empty($mendRecordRecord)) 
    { 

        $id = $mendRecordRecord[0]->id; 
		$sexCode = $mendRecordRecord[0]->sexCode; 
		$sexName = $mendRecordRecord[0]->sexName; 
		$member_code = $mendRecordRecord[0]->member_code; 
		$member_name = $mendRecordRecord[0]->member_name; 
        $roundNo = $mendRecordRecord[0]->roundNo; 
        $member_master_id = $mendRecordRecord[0]->member_master_id; 
        $household_master_id = $mendRecordRecord[0]->household_master_id; 
        $fk_marriage_end_type = $mendRecordRecord[0]->fk_marriage_end_type; 
        $fk_marriage_end_cause_one = $mendRecordRecord[0]->fk_marriage_end_cause_one; 
        $fk_marriage_end_cause_two = $mendRecordRecord[0]->fk_marriage_end_cause_two; 
        $fk_marriage_end_cause_three = $mendRecordRecord[0]->fk_marriage_end_cause_three; 

        $marriage_end_date = $mendRecordRecord[0]->marriage_end_date; 
        $member_master_id_bride_groom = $mendRecordRecord[0]->member_master_id_bride_groom; 
        $is_event = $mendRecordRecord[0]->is_event; 
        $remarks = $mendRecordRecord[0]->remarks; 
        $spauseCode = $mendRecordRecord[0]->spauseCode; 
        $spauseName = $mendRecordRecord[0]->spauseName; 
		
		$name = $mendRecordRecord[0]->name; 
        $age = $mendRecordRecord[0]->age; 
        $dob = $mendRecordRecord[0]->dob; 
		

    } 

    ?>

                    <form action="<?php echo base_url().'memberMarriageEnd/editMarriageDetails?baseID='.$baseID ?>" id="myForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8">

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
                                     <legend class="scheduler-border"><?php if ($sexCode==1) { echo "Wife ";} else { echo "Husband "; } ?>details</legend>


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
                                     <legend class="scheduler-border"><?php if ($sexCode==1) { echo "Wife ";} else { echo "Husband "; } ?>details</legend>
									 
									
                                     
									 
									    <div class="col-md-3">
											<div class="form-group">
												<label for="Active"><?php if ($sexCode==1) { echo "Wife ";} else { echo "Husband "; } ?>Member code (blank if not DSS member) </label>
												 <input type="hidden" name="fk_spouse_id" class="form-control" id="fk_spouse_id" value="<?php echo $member_master_id_bride_groom ?>" >
												 <input type="text" name="spouse_code" class="form-control" id="spouse_code" value="<?php echo $spauseCode.' - '. $spauseName ?>" disabled>
											</div>
										</div>
										
										<div class="col-md-3">
											<div class="form-group">
												<label for="Item Name"><?php if ($sexCode==1) { echo "Wife ";} else { echo "Husband "; } ?>Name </label>
												<input type="text" class="form-control" id="membname" value="<?php echo $name ?>"  name="name">
											</div>
										</div>
										
										<div class="col-md-3">
											<div class="form-group">
												<label for="Item Name"><?php if ($sexCode==1) { echo "Wife ";} else { echo "Husband "; } ?> Age </label>
												<input type="number" class="form-control" id="age" value="<?php echo $age; ?>"  name="age">
											</div>
										</div>
										
										<div class="col-md-3">
											<div class="form-group">
												<label for="Item Name"><?php if ($sexCode==1) { echo "Wife ";} else { echo "Husband "; } ?> Date of birth</label>
												
												<?php 
												
												$dob_date = '';
												if ($dob != "")
                                                   {
                                                    $partsRequire = explode('-', $dob);
                                                    $dob_date = $partsRequire[2].'/'.$partsRequire[1].'/'.$partsRequire[0];
                                                   }
												
												?>
												
												<input type="text" class="form-control" data-provide="datepicker-inline" id="dob"  value="<?php echo $dob_date; ?>" name="dob">
											</div>
										</div>
										
										
									 </fieldset>
									 
									 <fieldset class="scheduler-border">
                                     <legend class="scheduler-border">Marriage Information</legend>
									 
										<div class="col-md-4">
											<div class="form-group">
												<label for="Active">Marriage end type <span style="color:red">*</span></label>
												<select class="form-control required" id="fk_marriage_end_type" name="fk_marriage_end_type" required>
													<option value="">Please Select</option>
													 <?php
													if(!empty($marriage_end_typ))
													{
														foreach ($marriage_end_typ as $marriageendtyp)
														{
															?>
															<option <?php if($fk_marriage_end_type == $marriageendtyp->id) { echo "selected=selected";} ?> value="<?php echo $marriageendtyp->id ?>"><?php echo $marriageendtyp->code. '-' .$marriageendtyp->name ?></option>
															<?php
														}
													}
													?>
													
												</select>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="Item Name">Marriage end date <span style="color:red">*</span></label>
												<?php 
												if ($marriage_end_date != "")
                                                   {
                                                    $partsRequire = explode('-', $marriage_end_date);
                                                    $marriage_end_date = $partsRequire[2].'/'.$partsRequire[1].'/'.$partsRequire[0];
                                                   }
												
												?>
												<input type="text" class="form-control" data-provide="datepicker-inline" id="marriage_end_date"  name="marriage_end_date" value="<?php echo $marriage_end_date ?>" required>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="Active">Marriage end cause - 1 </label>
												<select class="form-control required" id="fk_marriage_end_cause_one" name="fk_marriage_end_cause_one">
													<option value="">Please Select</option>
													 <?php
													if(!empty($marriage_end_cause))
													{
														foreach ($marriage_end_cause as $marriageendcause)
														{
															?>
															<option <?php if($fk_marriage_end_cause_one == $marriageendcause->id) { echo "selected=selected";} ?> value="<?php echo $marriageendcause->id ?>"><?php echo $marriageendcause->code. '-' .$marriageendcause->name ?></option>
															<?php
														}
													}
													?>
													
												</select>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="Active">Marriage end cause - 2 </label>
												<select class="form-control required" id="fk_marriage_end_cause_two" name="fk_marriage_end_cause_two">
													<option value="">Please Select</option>
													 <?php
													if(!empty($marriage_end_cause))
													{
														foreach ($marriage_end_cause as $marriageendcause2)
														{
															?>
															<option <?php if($fk_marriage_end_cause_two == $marriageendcause2->id) { echo "selected=selected";} ?> value="<?php echo $marriageendcause2->id ?>"><?php echo $marriageendcause2->code. '-' .$marriageendcause2->name ?></option>
															<?php
														}
													}
													?>
													
												</select>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="Active">Marriage end cause - 3 </label>
												<select class="form-control required" id="fk_marriage_end_cause_three" name="fk_marriage_end_cause_three">
													<option value="">Please Select</option>
													 <?php
													if(!empty($marriage_end_cause))
													{
														foreach ($marriage_end_cause as $marriageendcaus3)
														{
															?>
															<option <?php if($fk_marriage_end_cause_three == $marriageendcaus3->id) { echo "selected=selected";} ?> value="<?php echo $marriageendcaus3->id ?>"><?php echo $marriageendcaus3->code. '-' .$marriageendcaus3->name ?></option>
															<?php
														}
													}
													?>
													
												</select>
											</div>
										</div>
										<!--<div class="col-md-4">
											<div class="form-group">
												<label for="Active">Is this marriage end event? <span style="color:red">*</span></label>
												<select class="form-control required" id="is_event" name="is_event" required>
													<option <?php if($is_event == 'Yes') { echo "selected=selected";} ?> value="Yes">Yes</option>
													<option <?php if($is_event == 'No') { echo "selected=selected";} ?> value="No">No</option>
													 
													
												</select>
											</div>
										</div>-->
										
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
                                <input type="hidden" name="marriageID" value="<?php echo  $id  ?>">
                                <input type="submit" class="btn btn-primary btnVisile" name="submit" value="Save" />
                                <a class="btn btn-primary" href="<?php echo base_url().'householdvisit/marriage_end?baseID='.$baseID.'#mend' ?>" class="">Back </a>
                               
                            </div>
							
							 <?php } ?>
                           
                       

                     </form>

                    
                   
                  
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>

