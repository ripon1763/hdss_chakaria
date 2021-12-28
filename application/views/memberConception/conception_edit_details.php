
<?php $baseID = $this->input->get('baseID',TRUE); ?>
 <?php 
    $id = 0;
	$fk_conception_order = 0;
    $fk_conception_plan = 0;
    $fk_conception_followup_status = 0;
    $member_master_id = 0;
    $household_master_id = 0;
    $roundNo = 0;
	  $member_code = '';
    $member_name = '';
    $conception_date = '';
    $death_time = '';


    if (!empty($conspRecord)) 
    { 

        $id = $conspRecord[0]->id; 
		$fk_conception_order = $conspRecord[0]->fk_conception_order; 
        $fk_conception_plan = $conspRecord[0]->fk_conception_plan; 
        $fk_conception_followup_status = $conspRecord[0]->fk_conception_followup_status; 
		$member_name = $conspRecord[0]->member_name; 
		$member_code = $conspRecord[0]->member_code; 
        $roundNo = $conspRecord[0]->roundNo; 
        $member_master_id = $conspRecord[0]->member_master_id; 
        $household_master_id = $conspRecord[0]->household_master_id; 
        $conception_date = $conspRecord[0]->conception_date; 
		

    } 

    ?>

                    <form action="<?php echo base_url().'memberConception/editConceptionDetails?baseID='.$baseID ?>" id="myForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8">

                     
                            <div id="consp" style="padding-left: 20px; padding-right: 20px">
                                <h4>Conception Details</h4>
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

                                         
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="Active">Member Information : </label>
                                                <?php echo $member_code.'-'.$member_name ?>
                                            </div>
                                        </div>
                                      
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label for="Item Name">Last menstruation/conception Date <span style="color:red">*</span></label>

                                                   <?php 
                                                   if ($conception_date != "")
                                                   {
                                                    $partsRequire = explode('-', $conception_date);
                                                    $conception_date = $partsRequire[2].'/'.$partsRequire[1].'/'.$partsRequire[0];
                                                   }
                                                  ?>
                                                  <input type="text" class="form-control hhdate" value="<?php echo $conception_date; ?>" id="deathdate"  name="conception_date" maxlength="255" required >
                                              </div>
                                          </div>

                                         <div class="col-md-6">
                                            <div class="form-group">
                                              
                                                 <label for="Active">Conception Plan <span style="color:red">*</span></label>
                                                  <select class="form-control required" id="fk_conception_plan" name="fk_conception_plan" required>
                                                      <option value="">Please Select</option>
                                                       <?php
                                                      if(!empty($conception_plan))
                                                      {
                                                          foreach ($conception_plan as $conceplan)
                                                          {
                                                              ?>
                                                              <option <?php if ($fk_conception_plan == $conceplan->id) { echo "selected=selected"; } ?> value="<?php echo $conceplan->id ?>"><?php echo $conceplan->code. '-' .$conceplan->name ?></option>
                                                              <?php
                                                          }
                                                      }
                                                      ?>
                                                      
                                                  </select>
                                            </div>
                                          </div>

                                          <div class="col-md-6">
                                            <div class="form-group">
                                              
                                                 <label for="Active">Conception Order <span style="color:red">*</span></label>
                                                  <select class="form-control required" id="fk_conception_order" name="fk_conception_order" required>
                                                      <option value="">Please Select</option>
                                                       <?php
                                                      if(!empty($conception_order))
                                                      {
                                                          foreach ($conception_order as $conceporder)
                                                          {
                                                              ?>
                                                              <option <?php if ($fk_conception_order == $conceporder->id) { echo "selected=selected"; } ?> value="<?php echo $conceporder->id ?>"><?php echo $conceporder->code. '-' .$conceporder->name ?></option>
                                                              <?php
                                                          }
                                                      }
                                                      ?>
                                                      
                                                  </select>
                                            </div>
                                          </div>

                                          <div class="col-md-6">
                                            <div class="form-group">
                                              
                                                 <label for="Active">Conception follow up status <span style="color:red">*</span></label>
                                                  <select class="form-control required" id="fk_conception_followup_status" name="fk_conception_followup_status" disabled>
                                                      <option value="">Please Select</option>
                                                       <?php
                                                      if(!empty($consp_follow_up_status))
                                                      {
                                                          foreach ($consp_follow_up_status as $follow_up_status)
                                                          {
                                                              ?>
                                                              <option <?php if ($fk_conception_followup_status == $follow_up_status->id) { echo "selected=selected"; } ?>  value="<?php echo $follow_up_status->id ?>"><?php echo $follow_up_status->code. '-' .$follow_up_status->name ?></option>
                                                              <?php
                                                          }
                                                      }
                                                      ?>
                                                      
                                                  </select>
                                            </div>
                                          </div>



                                           

                                    </div>
 
                                </div>

                            </div>

                            
                             <?php if ($id > 0) { ?>
							 
                             <div class="box-footer" style="margin-left: 10px">
                                <input type="hidden" name="household_master_id_sub" value="<?php echo  $household_master_id_sub  ?>">
                                <input type="hidden" name="round_master_id" value="<?php echo  $round_master_id  ?>">
                                <input type="hidden" name="member_master_id" value="<?php echo  $member_master_id  ?>">
                                <input type="hidden" name="conceptionID" value="<?php echo  $id  ?>">
                                <input type="submit" class="btn btn-primary btnVisile" name="submit" value="Save" />
                                <a class="btn btn-primary" href="<?php echo base_url().'householdvisit/conception?baseID='.$baseID.'#consp' ?>" class="">Back </a>
                               
                            </div>
							
							 <?php } ?>
                           
                       

                     </form>

                    
                   
                  
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>


<script type="text/javascript">

$( document ).ready(function() {


   $('#deathdate').datepicker({
     autoclose: true,
     format: 'dd/mm/yyyy'
   });

   });

</script>

