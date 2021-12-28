<?php $baseID = $this->input->get('baseID',TRUE); ?>
<?php 
    $householdvisitID = 0;
    $fk_interview_status = 0;
    $fk_interviewer = 0;
    $fk_responded_type = 0;
    $interview_date = '';
    $respondent_code = '';
    $contact_number = '';
    $remarks = '';
    $barino = '';

    if (!empty($householdVisit)) 
    { 

        $householdvisitID = $householdVisit[0]->id; 
        $interview_date = $householdVisit[0]->interview_date; 
        $fk_interview_status = $householdVisit[0]->fk_interview_status; 
        $fk_interviewer = $householdVisit[0]->fk_interviewer; 
        $fk_responded_type = $householdVisit[0]->fk_responded_type; 
        $respondent_code = $householdVisit[0]->respondent_code; 
        $contact_number = $householdVisit[0]->contact_number; 
        $remarks = $householdVisit[0]->remarks; 
        $barino = $householdVisit[0]->barino; 

    } 

?>

                    <form action="<?php echo base_url().'householdvisit/interview?baseID='.$baseID ?>" id="myForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8">

                    <!-- SmartWizard html -->
                  
                           
                     
                            <div id="interview" style="padding-left: 20px; padding-right: 20px">
                                <h4>Household Interview</h4>
                                <div class="row">
                                     <div class="col-md-3">
                                          <p>Household Code : <?php echo $householdcode ?></p>
                                     </div>
									  <div class="col-md-3">
                                         <p>Bari Number :  <?php echo $barino ?></p>
                                     </div>
                                      <div class="col-md-3">
                                         <p>Round Number :  <?php echo $roundNo ?></p>
                                     </div>
                                      <div class="col-md-3">
                                         <p>Last Interview Date : <?php if(!empty($interview_date)) { echo date('j F Y', strtotime($interview_date)) ;} ?></p>
                                     </div>
                                </div>

                                <div id="form-step-0" role="form" data-toggle="validator">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="email">Interview Status <span style="color:red">*</span></label>
                                               
                                                 <select name="fk_interview_status" class="form-control" required style="" required="required">
                                                     <option value="">Please Select</option>
                                                    <?php
                                                        if(!empty($interviewstatus))
                                                        {
                                                            foreach ($interviewstatus as $status)
                                                            {
                                                                ?>
                                                                <option <?php if ($fk_interview_status == $status->id) { echo 'selected=selected';} ?> value="<?php echo $status->id ?>"><?php echo $status->code.'-'.$status->name ?></option>
                                                                <?php
                                                            }
                                                            
                                                        }
                                                        ?>
                                                 </select>
                                               
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="email">Interviewer Name <span style="color:red">*</span></label>
                                               
                                                 <select name="fk_interviewer" class="form-control" required style="" required="required">
                                                     <option value="">Please Select</option>
                                                      <?php
                                                        if(!empty($interviewercode))
                                                        {
                                                            foreach ($interviewercode as $interviewercode)
                                                            {
                                                                ?>
                                                                <option <?php if ($fk_interviewer == $interviewercode->id) { echo 'selected=selected';} ?> value="<?php echo $interviewercode->id ?>"><?php echo $interviewercode->code.'-'.$interviewercode->name ?></option>
                                                                <?php
                                                            }
                                                            
                                                        }
                                                        ?>
                                                 </select>
                                               
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="email">Interview Date <span style="color:red">*</span></label>
                                                 <?php 
                                                   if ($interview_date != "")
                                                   {
                                                    $partsRequire = explode('-', $interview_date);
                                                    $interview_date = $partsRequire[2].'/'.$partsRequire[1].'/'.$partsRequire[0];
                                                   }
                                                   else{
                                                    $interview_date = date('d').'/'.date('m').'/'.date('Y');
                                                   }
                                                  ?>
                                               
                                                <input class="form-control" type="text" value="<?php echo $interview_date ?>" data-provide="datepicker-inline" name="interview_date_disable" disabled>
                                                <input class="form-control" type="hidden" value="<?php echo $interview_date ?>" data-provide="datepicker-inline" name="interview_date">
                                               
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="email">Respondent code <span style="color:red">*</span> </label>
                                               
                                                 <select name="respondent_code" class="form-control" required style="" required="required">
                                                     <option value="">Please Select</option>

                                                      <?php
                                                        if(!empty($presentMemberList))
                                                        {
                                                            foreach ($presentMemberList as $member)
                                                            {
                                                                ?>
                                                                <option <?php if ($respondent_code == $member->member_code) { echo 'selected=selected';} ?> value="<?php echo $member->member_code ?>"><?php echo $member->member_code.'-'.$member->member_name ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                            <option <?php if ($respondent_code == '99') { echo 'selected=selected';}  ?> value="99">99-Out of Household</option>
                                                            <?php 
                                                        }
                                                        ?>
                                                 </select>
                                               
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="email">Respondent Type <span style="color:red">*</span> </label>
                                               
                                                 <select name="fk_responded_type" class="form-control" required style="" required="required">
                                                     <option value="">Please Select</option>
                                                     <?php
                                                        if(!empty($respondent_typ))
                                                        {
                                                            foreach ($respondent_typ as $respondenttyp)
                                                            {
                                                                ?>
                                                                <option <?php if ($fk_responded_type == $respondenttyp->id) { echo 'selected=selected';} ?> value="<?php echo $respondenttyp->id ?>"><?php echo $respondenttyp->code.'-'.$respondenttyp->name ?></option>
                                                                <?php
                                                            }
                                                            
                                                        }
                                                        ?>
                                                 </select>
                                               
                                            </div>
                                        </div>
                                         <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="email">Contact Number <span style="color:red">*</span></label>
                                               
                                                <input class="form-control" type="text" name="contactNumber" value="<?php echo  $contact_number ?>" required="required">
                                               
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="email">Remarks (if any)</span></label>
                                               
                                                <textarea  class="form-control" name="remarks"><?php echo  $remarks ?></textarea>
                                               
                                            </div>
                                        </div>
                                    </div>
                                    
									
									
                                </div>

                            </div>

                             <div class="box-footer" style="margin-left: 10px">
                                <input type="hidden" name="household_master_id_sub" value="<?php echo  $household_master_id_sub  ?>">
                                <input type="hidden" name="round_master_id" value="<?php echo  $round_master_id  ?>">
                                <input type="hidden" name="householdVisitID" value="<?php echo  $householdvisitID  ?>">
                                <input type="hidden" name="event" value="interview">
                               <!-- <a class="btn btn-success" href="<?php echo base_url().'householdvisit/child_illness?baseID='.$baseID.'#child_illness' ?>" class="">Previous </a>-->
								<a class="btn btn-success" href="<?php echo base_url().'householdvisit/member_info?baseID='.$baseID.'#memberinfo' ?>" class="">Previous </a>
                                <input type="submit" class="btn btn-info" name="submit" value="Save" />
								<input type="submit" class="btn btn-primary" name="submit" value="Save & Next" />
                                <input type="submit" class="btn btn-danger" name="submit" value="Save & Conmplete" />
                               
                               
                            </div>
                           
                       

                     </form>
                   
                  
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>

