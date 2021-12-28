
<script type="text/javascript">

$( document ).ready(function() {

    $("#assetType").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");

           
            if(optionValue == 1)
            {
              // $(".number_of_household").prop('required',true);
              // $(".split_date").prop('required',true);
              $(".btnVisile").hide();
              $(".assetHistory").show();
               $(".btnHide").show();

            } else{

               //$(".number_of_household").prop('required',false);
              // $(".split_date").prop('required',false);
              // $(".splitYes").hide();
              $(".btnVisile").show();
              $(".assetHistory").hide();
              $(".btnHide").hide();
            }
        });
    }).change();


});
</script>
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

                    <form action="<?php echo base_url().'householdvisit/assets?baseID='.$baseID ?>" id="myForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8">

                    <!-- SmartWizard html -->
                  
                           
                     
                            <div id="asset" style="padding-left: 20px; padding-right: 20px">
                                <h4>Household Asset</h4>
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
                                        <label for="email">Any Asset add during this period?</label>
                                       
                                         <select name="assetType" id="assetType" class="form-control" required style="">
                                             <option value="">Please Select</option>
                                             <option <?php if ($any_asset == 1) { echo "selected=selected"; } ?> value="1">Yes</option>
                                             <option <?php if ($any_asset == 2) { echo "selected=selected"; } ?> value="2">No</option>
                                         </select>
                                       
                                    </div>
                                </div>

                            </div>

                            <div class="assetHistory" style="padding-left: 20px; padding-right: 20px">

                                <h4 class="pull-left">Asset History</h4>
                                 <a href="<?php echo base_url().'householdassets/addEditAsset?household_master_id='.$household_master_id_sub.'&&baseID='.$baseID ?>#asset" class="btn btn-info pull-right"><i class="fa fa-plus" aria-hidden="true"></i> Add Asset</a> <br/><br/>
                                <div class="table-responsive">
                                 <table class="table table-striped table-bordered">
                                     <tr>
                                         <td>Round</td>
                                         <td>Own Land</td>
                                         <td>Own House</td>
                                         <td class="pull-right">Action</td>
                                     </tr>
                                     <?php if(!empty($assetHistory)) 
                                     { 
                                       foreach ($assetHistory as $assetList) {
                                        ?>
                                     <tr>
                                         <td><?php echo $assetList->roundNo ?></td>
                                         <td><?php echo $assetList->ownerland_name ?></td>
                                         <td><?php echo $assetList->ownerhouse_name ?></td>
                                         <td class="pull-right"><a href="<?php echo base_url().'householdassets/editAsset/'.$assetList->id.'?household_master_id='.$household_master_id_sub.'&&baseID='.$baseID ?>#asset" class="btn btn-primary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> edit</a></td>
                                     </tr> 


                                    <?php } } ?>

                                 </table>
                              </div>
                                 
                            </div>

                             <div class="box-footer" style="margin-left: 10px">
                                <input type="hidden" name="household_master_id_sub" value="<?php echo  $household_master_id_sub  ?>">
                                <input type="hidden" name="round_master_id" value="<?php echo  $round_master_id  ?>">
                                <input type="hidden" name="householdVisitID" value="<?php echo  $householdvisitID  ?>">
                                <input type="hidden" name="event" value="asset">
                                <a class="btn btn-success" href="<?php echo base_url().'householdvisit/member_info?baseID='.$baseID.'#memberinfo' ?>" class="">Previous </a>
                                <input type="submit" class="btn btn-primary btnVisile" name="submit" value="Save & Next" />
                                
                                <input type="submit" class="btn btn-primary btnHide" name="submit" value="Next" />
                               
                            </div>
                           
                       

                     </form>

                    
                   
                  
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>

