<script type="text/javascript">

$( document ).ready(function() {

    $("#birthType").change(function(){
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
    $any_birth = 0;
    $interview_date = '';

    if (!empty($householdVisit)) 
    { 

        $householdvisitID = $householdVisit[0]->id; 
        $any_birth = $householdVisit[0]->any_birth; 
         $interview_date = $householdVisit[0]->interview_date; 

    } 

?>

                    <form action="<?php echo base_url().'householdvisit/birth?baseID='.$baseID ?>" id="myForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8">

                    <!-- SmartWizard html -->
                  
                           
                     
                            <div id="birth" style="padding-left: 20px; padding-right: 20px">
                                <h4>Member Birth</h4>
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
                                    <div class="form-group">
                                        <label for="email">Any birth occurred during this period?</label>
                                       
                                         <select name="birthType" id="birthType" class="form-control" required style="">
                                             <option value="">Please Select</option>
                                             <option <?php if ($any_birth == 1) { echo "selected=selected"; } ?> value="1">Yes</option>
                                             <option <?php if ($any_birth == 2) { echo "selected=selected"; } ?> value="2">No</option>
                                         </select>
                                       
                                    </div>
                                </div>

                                <div class="showYes">
                                <div>
                                 <a href="<?php echo base_url().'memberBirth/addBirth?household_master_id='.$household_master_id_sub.'&&baseID='.$baseID ?>#birth" class="btn btn-danger pull-right"><i class="fa fa-plus" aria-hidden="true"></i> Add New Birth</a> <br/>
                                </div>
                                <div style="padding-top: 20px">
                                <fieldset class="scheduler-border" >
                                <legend class="scheduler-border">Birth list during this round</legend>
                                <div class="table-responsive">
                                 <table class="table table-striped table-bordered">
                                    <?php if(!empty($birthList)) { ?>
                                    <tr>
                                        <td width="1%">#</td>
                                        <td> RID </td>
                                        <td> Name </td>
                                        <td> Realtion HHH </td>
                                        <td> Birth date </td>
                                        <td class="pull-right"> Action </td>

                                    </tr>
                                    <?php $i=1;
                                    foreach ($birthList as $presentMember): ?>
                                    <tr>
                                        <td><?php echo $i ?></td>
                                        <td> <?php echo $presentMember->member_code ?> </td>
                                        <td> <?php echo $presentMember->member_name ?> </td>
                                        <td> <?php echo $presentMember->relationHead ?> </td>
                                        <td> <?php echo date('j F Y', strtotime($presentMember->birth_date)); ?> </td>
                                         <td class="pull-right"> <a title="view/edit" href="<?php echo base_url().'memberBirth/addEditBirth/'.$presentMember->id.'?household_master_id='.$presentMember->household_master_id_hh.'&&baseID='.$baseID.'#birth'  ?>" class="btn btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> view/edit </a></td>

                                    </tr>
                                        
                                    <?php  $i = $i + 1;
                                    endforeach ?>
                                    <?php } ?>
                                 </table>
                                </div>
                                </fieldset>
                                </div>
                             </div>

                            </div>

                             <div class="box-footer" style="margin-left: 10px">
                                <input type="hidden" name="household_master_id_sub" value="<?php echo  $household_master_id_sub  ?>">
                                <input type="hidden" name="round_master_id" value="<?php echo  $round_master_id  ?>">
                                <input type="hidden" name="householdVisitID" value="<?php echo  $householdvisitID  ?>">
                                <input type="hidden" name="event" value="birth">
                                <a class="btn btn-success" href="<?php echo base_url().'householdvisit/pregnancy?baseID='.$baseID.'#pregnancy' ?>" class="">Previous </a>
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

