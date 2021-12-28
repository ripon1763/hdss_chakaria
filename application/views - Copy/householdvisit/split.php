<script type="text/javascript">

$( document ).ready(function() {

    $("#splitType").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");

           
            if(optionValue == 1)
            {
               $(".number_of_household").prop('required',true);
               $(".split_date").prop('required',true);
               $(".splitYes").show();
               $(".btnHidein").show();
               $(".btnVisileno").show();
                $(".btnVisilein").hide();

            } else{

               $(".number_of_household").prop('required',false);
               $(".split_date").prop('required',false);
               $(".splitYes").hide();
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
    $is_household_split = 0;
    $no_of_new_household =0;
    $split_date ='';
    $interview_date ='';

    if (!empty($householdVisit)) 
    { 

       $householdvisitID = $householdVisit[0]->id; 
       $is_household_split = $householdVisit[0]->is_household_split; 
       $no_of_new_household = $householdVisit[0]->no_of_new_household; 
       $split_date = $householdVisit[0]->split_date; 
       $interview_date = $householdVisit[0]->interview_date; 

    } 

    ?>

                    <form action="<?php echo base_url().'householdvisit/split?baseID='.$baseID ?>" id="myForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8">

                    <!-- SmartWizard html -->
                  
                           
                     
                            <div id="split" style="padding-left: 20px; padding-right: 20px">
                                <h4>Household Split</h4>

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
                                        <label for="email">Any Household Split occur ?</label>
                                       
                                         <select name="splitType" class="form-control" id="splitType" required>
                                             <option value="">Please Select</option>
                                             <option <?php if ($is_household_split == 1) { echo "selected=selected"; } ?> value="1">Yes</option>
                                             <option <?php if ($is_household_split == 2) { echo "selected=selected"; } ?> value="2">No</option>
                                         </select>
                                       
                                    </div>

                                    <div class="form-group splitYes">
                                        <label for="email">Number of Household</label>
                                       
                                         <input type="number" value="<?php echo $no_of_new_household ?>" class="form-control number_of_household" placeholder="No of household" name="number_of_household">
                                       
                                    </div>

                                     <div class="form-group splitYes">
                                        <label for="email">Split Date</label>

                                         <?php 
                                                   if ($split_date != "")
                                                   {
                                                    $partsRequire = explode('-', $split_date);
                                                    $split_date = $partsRequire[2].'/'.$partsRequire[1].'/'.$partsRequire[0];
                                                   }
                                         ?>
                                       
                                         <input type="text" value="<?php echo $split_date ?>" class="form-control split_date" placeholder="Split Date" data-provide="datepicker-inline" name="split_date">
                                       
                                    </div>

                                </div>

                            </div>

                             <div class="box-footer" style="margin-left: 10px">
                                <input type="hidden" name="household_master_id_sub" value="<?php echo  $household_master_id_sub  ?>">
                                <input type="hidden" name="round_master_id" value="<?php echo  $round_master_id  ?>">
                                <input type="hidden" name="householdVisitID" value="<?php echo  $householdvisitID  ?>">
                                <input type="hidden" name="event" value="split">
                                <input type="submit" class="btn btn-primary btnVisileno" name="submit" value="Save" />
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

