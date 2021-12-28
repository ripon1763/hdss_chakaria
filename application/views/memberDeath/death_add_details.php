
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


                    <form action="<?php echo base_url().'memberDeath/addDeathDetails?baseID='.$baseID ?>" id="myForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8">

                    <!-- SmartWizard html -->
                  
                           
                     
                            <div id="death" style="padding-left: 20px; padding-right: 20px">
                                <h4>Death Details</h4>
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
                                                  <label for="Item Name">Death Date <span style="color:red">*</span></label>
                                                  <input type="text" class="form-control hhdate" id="deathdate"  name="deathDate" maxlength="255" required >
                                              </div>
                                          </div>

                                           <div class="col-md-4">
                                              <div class="form-group">
                                                  <label for="Item Name">Death Time <span style="color:red">*</span></label>
                                                  <input type="text" class="form-control hhdate" id="deathTime"  name="deathtime" maxlength="255" required >
                                              </div>
                                          </div>

                                          <div class="col-md-4">
                                            <div class="form-group">
                                              
                                                 <label for="Active">Death Plcae <span style="color:red">*</span></label>
                                                  <select class="form-control required" id="fk_death_place" name="fk_death_place" required>
                                                      <option value="">Please Select</option>
                                                       <?php
                                                      if(!empty($member_death_place))
                                                      {
                                                          foreach ($member_death_place as $place)
                                                          {
                                                              ?>
                                                              <option value="<?php echo $place->id ?>"><?php echo $place->code. '-' .$place->name ?></option>
                                                              <?php
                                                          }
                                                      }
                                                      ?>
                                                      
                                                  </select>
                                            </div>
                                          </div>

                                          <div class="col-md-4">
                                            <div class="form-group">
                                              
                                                 <label for="Active">Death Cause <span style="color:red">*</span></label>
                                                  <select class="form-control required" id="fk_death_cause" name="fk_death_cause" required>
                                                      <option value="">Please Select</option>
                                                       <?php
                                                      if(!empty($member_death_cause))
                                                      {
                                                          foreach ($member_death_cause as $cause)
                                                          {
                                                              ?>
                                                              <option value="<?php echo $cause->id ?>"><?php echo $cause->code. '-' .$cause->name ?></option>
                                                              <?php
                                                          }
                                                      }
                                                      ?>
                                                      
                                                  </select>
                                            </div>
                                          </div>

                                           <div class="col-md-4">
                                            <div class="form-group">
                                              
                                                 <label for="Active">Type of death <span style="color:red">*</span></label>
                                                  <select class="form-control required" id="fk_death_type" name="fk_death_type" required>
                                                      <option value="">Please Select</option>
                                                       <?php
                                                      if(!empty($type_of_death))
                                                      {
                                                          foreach ($type_of_death as $type)
                                                          {
                                                              ?>
                                                              <option value="<?php echo $type->id ?>"><?php echo $type->code. '-' .$type->name ?></option>
                                                              <?php
                                                          }
                                                      }
                                                      ?>
                                                      
                                                  </select>
                                            </div>
                                          </div>

                                           <div class="col-md-4">
                                            <div class="form-group">
                                              
                                                 <label for="Active">Death confirm by <span style="color:red">*</span></label>
                                                  <select class="form-control required" id="fk_death_confirmby" name="fk_death_confirmby" required>
                                                      <option value="">Please Select</option>
                                                       <?php
                                                      if(!empty($death_confirm_by))
                                                      {
                                                          foreach ($death_confirm_by as $confirm)
                                                          {
                                                              ?>
                                                              <option value="<?php echo $confirm->id ?>"><?php echo $confirm->code. '-' .$confirm->name ?></option>
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

                            
                            
							 
                             <div class="box-footer" style="margin-left: 10px">
                                <input type="hidden" name="household_master_id_sub" value="<?php echo  $household_master_id_sub  ?>">
                                <input type="hidden" name="round_master_id" value="<?php echo  $round_master_id  ?>">
                                <input type="hidden" name="member_master_id" value="<?php echo  $member_master_id  ?>">
                                <input type="submit" class="btn btn-primary btnVisile" name="submit" value="Save" />
                                <a class="btn btn-primary" href="<?php echo base_url().'householdvisit/death?baseID='.$baseID.'#death' ?>" class="">Back </a>
                               
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


   $('#deathdate').datepicker({
     autoclose: true,
     format: 'dd/mm/yyyy'
   });

   });

</script>

