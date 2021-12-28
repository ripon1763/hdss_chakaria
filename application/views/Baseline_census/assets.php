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

                    <form action="<?php echo base_url().'Baseline_census/baseline_census_info?baseID='.$baseID ?>" id="myForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8">
                            <div id="asset" style="padding-left: 20px; padding-right: 20px">
                                <h4>Household Asset & Baseline Census</h4>
                                 <div class="row">
                                     <div class="col-md-4">
                                          <p>Household Code : <?php echo $householdcode ?></p>
                                     </div>
                                      <div class="col-md-4">
                                         <p>Round Number :  <?php echo $roundNo ?></p>
                                     </div>
                                </div>
                            </div>

                            <div class="assetHistory" style="padding-left: 20px; padding-right: 20px">

                                <h4 class="pull-left">Asset</h4>  <br/>
                                 <a href="<?php echo base_url().'Baseline_census/addEditAsset?household_master_id='.$household_master_id_sub.'&&baseID='.$baseID ?>#baseline_census_info" class="btn btn-info pull-right"><i class="fa fa-plus" aria-hidden="true"></i> Add Asset</a> <br/><br/>
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
                                         <td class="pull-right"><a href="<?php echo base_url().'Baseline_census/editAsset/'.$assetList->id.'?household_master_id='.$household_master_id_sub.'&&baseID='.$baseID ?>#baseline_census_info" class="btn btn-primary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> edit</a></td>
                                     </tr> 


                                    <?php } } ?>

                                 </table>
                              </div>
                                 
                            </div>
                        
                             <div class="baselineHistory" style="padding-left: 20px; padding-right: 20px">

                                <h4 class="pull-left">Baseline Census</h4> <br/>
                                 <a href="<?php echo base_url().'Baseline_census/addEditBaseline?household_master_id='.$household_master_id_sub.'&&baseID='.$baseID ?>#baseline_census_info" class="btn btn-info pull-right"><i class="fa fa-plus" aria-hidden="true"></i> Add Baseline Census</a> <br/><br/>
                                <div class="table-responsive">
                                 <table class="table table-striped table-bordered">
                                     <tr>
                                         <td>Round</td>
                                         <td>Division</td>
                                         <td>Upazilla</td>
                                         
                                         <td class="pull-right">Action</td>
                                     </tr>
                                     <?php if(!empty($baselineHistory)) 
                                     { 
                                       foreach ($baselineHistory as $baselineList) {
                                        ?>
                                     <tr>
                                         <td><?php echo $baselineList->roundNo ?></td>
                                         <td><?php echo $baselineList->division_name ?></td>
                                         <td><?php echo $baselineList->upazilla_name ?></td>
                                         
                                         <td class="pull-right"><a href="<?php echo base_url().'Baseline_census/editBaseline/'.$baselineList->id.'?household_master_id='.$household_master_id_sub.'&&baseID='.$baseID ?>#baseline_census_info" class="btn btn-primary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> edit</a></td>
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
                                <input type="submit" class="btn btn-success" name="submit" value="Complete" />
                            </div>
                     </form>

                    
                   
                  
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>

