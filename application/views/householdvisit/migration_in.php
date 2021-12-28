<script type="text/javascript">

$( document ).ready(function() {

    $("#miginType").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");

            if(optionValue == 1)
            {
               $(".btnVisilein").hide();
               $(".btnHidein").show();
               $(".showYes").show();

            } else{

              $(".btnVisilein").show();
              $(".btnHidein").hide();
              $(".showYes").hide();
            }
        });
    }).change();


});
</script>

<?php $baseID = $this->input->get('baseID',TRUE); ?>
<?php 
    $householdvisitID = 0;
    $any_migration_in = 0;
     $interview_date = '';
     $barino = '';

    if (!empty($householdVisit)) 
    { 

        $householdvisitID = $householdVisit[0]->id; 
        $any_migration_in = $householdVisit[0]->any_migration_in; 
        $interview_date = $householdVisit[0]->interview_date; 
        $barino = $householdVisit[0]->barino; 

    } 

?>

                    <form action="<?php echo base_url().'householdvisit/migin?baseID='.$baseID ?>" id="myForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8">

                    <!-- SmartWizard html -->
                  
                           
                     
                            <div id="migin" style="padding-left: 20px; padding-right: 20px">
                                <h4>Member migration in</h4>
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
                                    <div class="form-group">
                                        <label for="email">Any person in migrated/internal movement during this period?</label>
                                       
                                         <select name="miginType" id="miginType" class="form-control" required style="">
                                             <option value="">Please Select</option>
                                             <option <?php if ($any_migration_in == 1) { echo "selected=selected"; } ?> value="1">Yes</option>
                                             <option <?php if ($any_migration_in == 2) { echo "selected=selected"; } ?> value="2">No</option>
											 <option <?php if ($any_migration_in == 3) { echo "selected=selected"; } ?> value="3">Not available</option>
                                         </select>
                                       
                                    </div>
                                </div>

                                <div class="showYes">

                                <div class="clearfix" style="margin-bottom: 10px"><a href="<?php echo base_url().'memberMigrationIn/addMigrationIn?household_master_id='.$household_master_id_sub.'&&baseID='.$baseID ?>#migin" class="btn btn-info pull-right"><i class="fa fa-plus" aria-hidden="true"></i> new movement in</a> </div>

                               <fieldset class="scheduler-border">
                                <legend class="scheduler-border">Internal movement/migration in list during this round</legend>
                               <div class="table-responsive">
                                 <table class="table table-striped table-bordered">
                                    <?php if(!empty($minRecords)) { ?>
                                    <tr>
                                        <td width="1%">#</td>
                                        <td> RID </td>
                                        <td> CID </td>
                                        <td> Name </td>
                                        <td> Movement Type </td>
                                        <td> Date </td>
                                        <td> Action </td>

                                    </tr>
                                    <?php $i=1;
                                    foreach ($minRecords as $minR): ?>
                                    <tr>
                                        <td><?php echo $i ?></td>
                                        <td> <?php echo $minR->member_code ?> </td>
                                        <td> <?php echo $minR->current_indenttification_id ?> </td>
                                        <td> <?php echo $minR->member_name ?> </td>
                                        <td> <?php echo $minR->moveTypeCode.'-'.$minR->moveTypeName ?> </td>
                                        <td> <?php echo date('j F Y', strtotime($minR->movement_date)); ?> </td>
                                        <td class="pull-right"> <a title="view/edit" href="<?php echo base_url().'memberMigrationIn/addEditMigration/'.$minR->id.'?household_master_id='.$minR->household_master_id_hh.'&&member_master_id='.$minR->member_master_id.'&&baseID='.$baseID.'#migin'  ?>" class="btn btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> view/edit </a></td>

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
                                <input type="hidden" name="event" value="migin">
                                <a class="btn btn-success" href="<?php echo base_url().'householdvisit/assets?baseID='.$baseID.'#asset' ?>" class="">Previous </a>
                                <input type="submit" class="btn btn-primary btnVisilein" name="submit" value="Save & Next" />
                                <input type="submit" class="btn btn-primary btnHidein" name="submit" value="Next" />
                               
                               
                            </div>
                           
                       

                     </form>
                   
                  
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>

