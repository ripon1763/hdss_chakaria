
<script type="text/javascript">

$( document ).ready(function() {

    $("#mergeType").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");

           
            if(optionValue == 1)
            {
               $(".btnHidein").show();
               $(".btnVisileno").show();
                $(".btnVisilein").hide();

            } else{

               $(".btnHidein").hide();
               $(".btnVisileno").hide();
               $(".btnVisilein").show();
            }
        });
    }).change();


});
</script>

<?php $baseID = $this->input->get('baseID',TRUE); ?>
 <?php 
    $householdvisitID = 0;
    $is_household_merge = 0;
    $interview_date = '';

    if (!empty($householdVisit)) 
    { 

        $householdvisitID = $householdVisit[0]->id; 
        $is_household_merge = $householdVisit[0]->is_household_merge; 
        $interview_date = $householdVisit[0]->interview_date; 

    } 

    ?>

                    <form action="<?php echo base_url().'householdvisit/merge?baseID='.$baseID ?>" id="myForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8">

                    <!-- SmartWizard html -->
                  
                           
                     
                            <div id="merge" style="padding-left: 20px; padding-right: 20px">
                                <h4>Household Marge</h4>
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
                                        <label for="email">Any Household marge occur ?</label>
                                       
                                         <select name="mergeType" id="mergeType" class="form-control" required style="">
                                             <option value="">Please Select</option>
                                             <option <?php if ($is_household_merge == 1) { echo "selected=selected"; } ?> value="1">Yes</option>
                                             <option <?php if ($is_household_merge == 2) { echo "selected=selected"; } ?> value="2">No</option>
                                         </select>
                                       
                                    </div>
                                </div>

                            </div>

                             <div class="box-footer" style="margin-left: 10px">
                                <input type="hidden" name="household_master_id_sub" value="<?php echo  $household_master_id_sub  ?>">
                                <input type="hidden" name="round_master_id" value="<?php echo  $round_master_id  ?>">
                                <input type="hidden" name="householdVisitID" value="<?php echo  $householdvisitID  ?>">
                                <input type="hidden" name="event" value="merge">
                                 <a class="btn btn-success" href="<?php echo base_url().'householdvisit/split?baseID='.$baseID.'#split' ?>" class="">Previous </a>
                                <input type="submit" class="btn btn-primary btnVisilein" name="submit" value="Save & Next" />
                                <input type="submit" class="btn btn-primary btnVisileno" name="submit" value="Save" />
                               
                                <input type="submit" class="btn btn-primary btnHidein" name="submit" value="Next" />
                            </div>
                           
                       

                     </form>
                   
                  
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>

