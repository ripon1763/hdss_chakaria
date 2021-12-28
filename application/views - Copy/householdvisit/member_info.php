
 <?php $baseID = $this->input->get('baseID',TRUE); ?>
 <?php 
    $householdvisitID = 0;
    $interview_date ='';

    if (!empty($householdVisit)) 
    { 

       $householdvisitID = $householdVisit[0]->id; 
       $interview_date = $householdVisit[0]->interview_date; 

    } 

    ?>

                    <form action="<?php echo base_url().'householdvisit/member_info?baseID='.$baseID ?>" id="myForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8">

                    <!-- SmartWizard html -->
                  
                           
                     
                            <div id="memberinfo" style="padding-left: 20px; padding-right: 20px">
                                <h4>Household Member Information</h4>

                                <div class="row">
                                     <div class="col-md-4">
                                          <p>Household Code : <?php echo $householdcode ?></p>
                                     </div>
                                      <div class="col-md-4">
                                         <p>Round Number :  <?php echo $roundNo ?></p>
                                     </div>
                                      <div class="col-md-4">
                                         <p>Last Interview Date : <?php if(!empty($interview_date)) { echo date('j F Y', strtotime($interview_date)) ;} ?></p>
                                     </div>
                                </div>
                               
                               


                                <div id="form-step-0" role="form" data-toggle="validator">
                                    

                                <fieldset class="scheduler-border">
									<legend class="scheduler-border">Present member list</legend>
                  <div class="table-responsive">
									 <table class="table table-striped table-bordered">
										<?php if(!empty($presentMemberList)) { ?>
										
										<tr>
											<td width="1%">#</td>
											<td> RID</td>
                      <td> CID</td>
											<td> Name </td>
											<td> Marital Status </td>
											<td> Birth date </td>
											<td> Relation to HH </td>
											

										</tr>
										<?php $i=1;
										foreach ($presentMemberList as $presentMember): ?>
										<tr>
											<td><?php echo $i ?></td>
											<td> <?php echo $presentMember->member_code ?> </td>
                      <td> <?php echo $presentMember->current_indenttification_id ?> </td>
											<td> <?php echo $presentMember->member_name ?> </td>
											<td> <?php echo $presentMember->marriageCode.'-'.$presentMember->marriageName ?> </td>
											<td> <?php echo date('j F Y', strtotime($presentMember->birth_date)); ?> </td>
											<td> <?php echo $presentMember->relationHead; ?> </td>
											
										</tr>
											
										<?php  $i = $i + 1;
										endforeach ?>
										<?php } ?>
									 </table>
                  </div>
                                </fieldset>

                                <fieldset class="scheduler-border">
                                <legend class="scheduler-border">Previous member list( Exit this round ) </legend>
                               <div class="table-responsive">
                                 <table class="table table-striped table-bordered">
                                    <?php if(!empty($prevMemberRecords)) { ?>
                                    <tr>
                                        <td width="1%">#</td>
                                        <td> RID </td>
                                        <td> Name </td>
                                        <td> Birth date </td>
                                        <td> Exit date </td>
                                        <td> Exit Type </td>

                                    </tr>
                                    <?php $p=1;
                                    foreach ($prevMemberRecords as $prevRecords): ?>
                                    <tr>
                                        <td><?php echo $p ?></td>
                                        <td> <?php echo $prevRecords->member_code ?> </td>
                                        <td> <?php echo $prevRecords->member_name ?> </td>
                                        <td> <?php echo date('j F Y', strtotime($prevRecords->birth_date)); ?> </td>
                                        <td> <?php echo date('j F Y', strtotime($prevRecords->exit_date)); ?> </td>
                                        <td> <?php echo $prevRecords->exitTypeCode.'-'.$prevRecords->exitTypeName ?> </td>

                                    </tr>
                                        
                                    <?php  $p = $p + 1;
                                    endforeach ?>
                                    <?php } ?>
                                 </table>
                               </div>
                                </fieldset>

                                </div>

                            </div>

                             <div class="box-footer" style="margin-left: 10px">
                                <input type="hidden" name="household_master_id_sub" value="<?php echo  $household_master_id_sub  ?>">
                                <input type="hidden" name="round_master_id" value="<?php echo  $round_master_id  ?>">
                                <input type="hidden" name="householdVisitID" value="<?php echo  $householdvisitID  ?>">
                                <input type="hidden" name="event" value="member_info">
                                <input type="submit" class="btn btn-primary" name="submit" value="Next" />
                               
                            </div>
                           
                       

                     </form>
                   
                  
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>

