
<?php 
    $member_master_id = 0;
    $member_code = '';
     $member_name = '';

    if (!empty($memberInfo)) 
    { 

        $member_master_id = $memberInfo[0]->id; 
        $member_name = $memberInfo[0]->member_name; 
        $member_code = $memberInfo[0]->member_code; 

    } 

?>


<?php $baseID = $this->input->get('baseID',TRUE); ?>


                    <form action="<?php echo base_url().'memberConception/addConceptionDetails?baseID='.$baseID ?>" id="myForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8">

                    <!-- SmartWizard html -->
                  
                           
                     
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
                                        

                                         <div class="col-md-4">
                                              <div class="form-group">
                                                  <label for="Item Name">Last menstruation/conception Date <span style="color:red">*</span></label>
                                                  <input type="text" class="form-control hhdate" id="conceptionDate"  name="conception_date" maxlength="255" required >
                                              </div>
                                          </div>
                                          <div class="col-md-4">
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
                                                              <option value="<?php echo $conceplan->id ?>"><?php echo $conceplan->code. '-' .$conceplan->name ?></option>
                                                              <?php
                                                          }
                                                      }
                                                      ?>
                                                      
                                                  </select>
                                            </div>
                                          </div>

                                          <div class="col-md-4">
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
                                                              <option value="<?php echo $conceporder->id ?>"><?php echo $conceporder->code. '-' .$conceporder->name ?></option>
                                                              <?php
                                                          }
                                                      }
                                                      ?>
                                                      
                                                  </select>
                                            </div>
                                          </div>

                                          <!-- <div class="col-md-4">
                                            <div class="form-group">
                                              
                                                 <label for="Active">Conception follow up status <span style="color:red">*</span></label>
                                                  <select class="form-control required" id="fk_conception_followup_status" name="fk_conception_followup_status" required>
                                                      <option value="">Please Select</option>
                                                       <?php
                                                      if(!empty($consp_follow_up_status))
                                                      {
                                                          foreach ($consp_follow_up_status as $follow_up_status)
                                                          {
                                                              ?>
                                                              <option value="<?php echo $follow_up_status->id ?>"><?php echo $follow_up_status->code. '-' .$follow_up_status->name ?></option>
                                                              <?php
                                                          }
                                                      }
                                                      ?>
                                                      
                                                  </select>
                                            </div>
                                          </div> -->

                                          
                                    </div>
 
                                </div>


                                    <fieldset class="scheduler-border">
                                     <legend class="scheduler-border">Previous conception</legend>
                                     <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <?php if(!empty($conceptionInfo)) { ?>
                                            <tr>
                                                <td width="1%">#</td>
                                                <td> HHNo </td>
                                                <td> Date </td>
                                                <td> Conception Order </td>
                                                <td> Result </td>
                                               
                                            </tr>
                                            <?php $p=1;
                                            foreach ($conceptionInfo as $prevRecords): ?>
                                            <tr>
                                                <td><?php echo $p ?></td>
                                                <td> <?php echo $prevRecords->household_code ?> </td>
                                                <td> <?php echo date('d/m/Y', strtotime($prevRecords->conception_date)); ?> </td>
                                                <td> <?php echo $prevRecords->conceptionOrderCode.'-'.$prevRecords->conceptionOrder ?> </td>
                                                <td> <?php echo $prevRecords->conceptionresultCode.'-'.$prevRecords->conceptionresult ?> </td>

                                            </tr>
                                                
                                            <?php  $p = $p + 1;
                                            endforeach ?>
                                            <?php } ?>
                                        </table>
                                    </div>
									 </fieldset>


                            </div>

                            
                            
							 
                             <div class="box-footer" style="margin-left: 10px">
                                <input type="hidden" name="household_master_id_sub" value="<?php echo  $household_master_id_sub  ?>">
                                <input type="hidden" name="round_master_id" value="<?php echo  $round_master_id  ?>">
                                <input type="hidden" name="member_master_id" value="<?php echo  $member_master_id  ?>">
                                <input type="submit" class="btn btn-primary btnVisile" name="submit" value="Save" />
                                <a class="btn btn-primary" href="<?php echo base_url().'householdvisit/conception?baseID='.$baseID.'#consp' ?>" class="">Back </a>
                               
                            </div>
							
							
                       

                     </form>

                    
                   
                  
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">

$( document ).ready(function() {


   $('#conceptionDate').datepicker({
     autoclose: true,
     format: 'dd/mm/yyyy'
   });

   });

</script>

