
<?php 
    $member_master_id = 0;
    $fk_marital_status = 0;
    $fk_spouse_id = 0;
    $member_code = '';
    $member_name = '';
    $sexName = '';
    $sexCode = '';
    $spouse_code = '';
    $spouseName = '';

    if (!empty($memberInfo)) 
    { 

        $member_master_id = $memberInfo[0]->id; 
        $member_name = $memberInfo[0]->member_name; 
        $member_code = $memberInfo[0]->member_code; 
        $sexCode = $memberInfo[0]->sexCode; 
        $sexName = $memberInfo[0]->sexName; 
        $fk_spouse_id = $memberInfo[0]->fk_spouse_id; 
        $fk_marital_status = $memberInfo[0]->fk_marital_status; 
        $spouse_code = $memberInfo[0]->spouse_code; 
        $spouseName = $memberInfo[0]->spouseName; 

    } 

?>


<?php $baseID = $this->input->get('baseID',TRUE); ?>


                    <form action="<?php echo base_url().'memberMarriageEnd/addMarriageDetails?baseID='.$baseID ?>" id="myForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8">

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
                                     <legend class="scheduler-border"><?php if ($sexCode==1) { echo "Bride ";} else { echo "Groom "; } ?>details</legend>
									 
									
                                     
									 
									    <div class="col-md-4">
											<div class="form-group">
												<label for="Active"><?php if ($sexCode==1) { echo "Bride ";} else { echo "Groom "; } ?>Member code (blank if not DSS member) </label>
												 <input type="hidden" name="fk_spouse_id" class="form-control" id="fk_spouse_id" value="<?php echo $fk_spouse_id ?>" >
												 <input type="text" name="spouse_code" class="form-control" id="spouse_code" value="<?php echo $spouse_code.' - '. $spouseName ?>" disabled>
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
															<option value="<?php echo $marriageendtyp->id ?>"><?php echo $marriageendtyp->code. '-' .$marriageendtyp->name ?></option>
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
												<input type="text" class="form-control" data-provide="datepicker-inline" id="marriage_end_date"  name="marriage_end_date" required>
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
															<option value="<?php echo $marriageendcause->id ?>"><?php echo $marriageendcause->code. '-' .$marriageendcause->name ?></option>
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
															<option value="<?php echo $marriageendcause2->id ?>"><?php echo $marriageendcause2->code. '-' .$marriageendcause2->name ?></option>
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
															<option value="<?php echo $marriageendcaus3->id ?>"><?php echo $marriageendcaus3->code. '-' .$marriageendcaus3->name ?></option>
															<?php
														}
													}
													?>
													
												</select>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="Active">Is this marriage end event? <span style="color:red">*</span></label>
												<select class="form-control required" id="is_event" name="is_event" required>
													<option value="Yes">Yes</option>
													<option value="No">No</option>
													 
													
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
                                <input type="hidden" name="member_master_id" value="<?php echo  $member_master_id  ?>">
                                <input type="submit" class="btn btn-primary btnVisile" name="submit" value="Save" />
                                <a class="btn btn-primary" href="<?php echo base_url().'householdvisit/marriage_end?baseID='.$baseID.'#mend' ?>" class="">Back </a>
                               
                            </div>
							
							
                       

                     </form>

                    
                   
                  
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>
