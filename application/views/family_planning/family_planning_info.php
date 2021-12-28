<?php $baseID = $this->input->get('baseID',TRUE); ?>
 <?php 
    $householdvisitID = 0;
    $any_asset = 0;
    $interview_date = '';

    if (!empty($householdVisit)) 
    { 

        $householdvisitID = $householdVisit[0]->id; 
        $any_asset = $householdVisit[0]->any_asset; 
        $interview_date = $householdVisit[0]->interview_date; 

    } 

    ?>

                    <form action="<?php echo base_url().'Family_planning/family_planning_info?baseID='.$baseID ?>" id="myForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8">
                            <div id="asset" style="padding-left: 20px; padding-right: 20px">
                                <h4></h4>
                                 <div class="row">
                                     <div class="col-md-4">
                                          <p>Household Code : <?php echo $householdcode ?></p>
                                     </div>
                                      <div class="col-md-4">
                                         <p>Round Number :  <?php echo $roundNo ?></p>
                                     </div>
                                </div>
                            </div>

                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border">Family planning list during this round</legend>
                               <div class="table-responsive">
                                 <table class="table table-striped table-bordered">
                                    <?php if(!empty($familyPlanningRecords)) { ?>
                                    <tr>
                                        <td width="1%">#</td>
                                        <td> RID </td>
                                        <td> Name </td>
                                        <td> Birth date </td>
                                        <td> Marital status  </td>
                                        <td class="pull-right"> Action </td>

                                    </tr>
                                    <?php $i=1;
                                    foreach ($familyPlanningRecords as $familyPlanningList): ?>
                                    <tr>
                                        <td><?php echo $i ?></td>
                                        <td> <?php echo $familyPlanningList->member_code ?> </td>
                                        <td> <?php echo $familyPlanningList->member_name ?> </td>
                                        <td> <?php echo date('j F Y', strtotime($familyPlanningList->birth_date)); ?> </td>
                                        <td> <?php echo $familyPlanningList->maritial_status_name; ?> </td>

                                         <td class="pull-right"> <a title="view/edit" href="<?php echo base_url().'Family_planning/addEditFP/'.$familyPlanningList->id.'?household_master_id='.$familyPlanningList->household_master_id.'&&member_master_id='.$familyPlanningList->member_master_id.'&&baseID='.$baseID.'#familyPlanning'  ?>" class="btn btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> view/edit </a></td>

                                    </tr>
                                        
                                    <?php  $i = $i + 1;
                                    endforeach ?>
                                    <?php } ?>
                                 </table>
                                </div>
                                </fieldset>

                                <fieldset class="scheduler-border">
                                <legend class="scheduler-border">Present member list</legend>

                                <div class="table-responsive">
                                 <table class="table table-striped table-bordered">
                                    <?php if(!empty($presentMemberList)) { ?>
                                    
                                    <tr>
                                        <td width="1%">#</td>
                                        <td> RID </td>
                                        <td> CID </td>
                                        <td> Name </td>
                                        <td> Marital Status </td>
                                        <td> Birth date </td>
                                        <td class="pull-right"> Action </td>

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
                                        <td class="pull-right"> <a title="Add Family Planning" href="<?php echo base_url().'Family_planning/add_family_planning/'.$presentMember->id.'?household_master_id='.$presentMember->household_master_id_hh.'&&baseID='.$baseID.'#familyPlanning'  ?>" class="btn btn-info"> <i class="fa fa-plus" aria-hidden="true"></i> Family planning </a>

                                         </td>

                                    </tr>
                                        
                                    <?php  $i = $i + 1;
                                    endforeach ?>
                                    <?php } ?>
                                 </table>
                                </div>
                                </fieldset>

                             <div class="box-footer" style="margin-left: 10px">
                                <input type="hidden" name="household_master_id_sub" value="<?php echo  $household_master_id_sub  ?>">
                                <input type="hidden" name="round_master_id" value="<?php echo  $round_master_id  ?>">
                                <input type="hidden" name="householdVisitID" value="<?php echo  $householdvisitID  ?>">
                                <input type="hidden" name="event" value="asset">
                                <input type="submit" class="btn btn-success" name="submit" value="Complete" />
                            </div>
                     </form>

                    
                   
                  
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>



