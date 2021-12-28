
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


                    <form action="<?php echo base_url().'memberRelation/addRelationDetails?baseID='.$baseID ?>" id="myForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8">

                    <!-- SmartWizard html -->
                  
                           
                     
                            <div id="relation" style="padding-left: 20px; padding-right: 20px">
                                <h4>Relation Details</h4>
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
                                         <div class="col-md-12">
											<div class="form-group">
												
												    <label for="Active">Relation with HHH <span style="color:red">*</span></label>
			                                        <select class="form-control required" id="relationType" name="relationType" required>
			                                            <option value="">Please Select</option>
			                                             <?php
			                                            if(!empty($relationhhh))
			                                            {
			                                                foreach ($relationhhh as $relation)
			                                                {
			                                                    ?>
			                                                    <option value="<?php echo $relation->id ?>"><?php echo $relation->code. '-' .$relation->name ?></option>
			                                                    <?php
			                                                }
			                                            }
			                                            ?>
			                                            
			                                        </select>
											</div>
										</div>
										
										<div class="col-md-6 changeCause">
                                            <div class="form-group">
                                                <label for="Active">Cause of head change <span style="color:red">*</span></label>
                                                  <select class="form-control fk_hhh_cause" id="fk_hhh_cause" name="fk_hhh_cause" >
                                                      <option value="">Please Select</option>
                                                       <?php
                                                      if(!empty($hh_change_reason))
                                                      {
                                                          foreach ($hh_change_reason as $hh_change)
                                                          {
                                                              ?>
                                                              <option <?php //if ($fk_relation == $hh_change->id) { echo "selected=selected"; } ?> value="<?php echo $hh_change->id ?>"><?php echo $hh_change->code. '-' .$hh_change->name ?></option>
                                                              <?php
                                                          }
                                                      }
                                                      ?>
                                                      
                                                  </select>
                                            </div>
                                          </div>

                                          <div class="col-md-6 hhefectiveDate">
                                              <div class="form-group">
                                                  <label for="Item Name">Effective date (If HHH) <span style="color:red">*</span></label>
                                                  <input type="text" class="form-control hhdate" id="hhdate"  name="hhdate" maxlength="255" >
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
                                <a class="btn btn-primary" href="<?php echo base_url().'householdvisit/relation?baseID='.$baseID.'#relation' ?>" class="">Back </a>
                               
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


   $('#hhdate').datepicker({
     autoclose: true,
     format: 'dd/mm/yyyy'
   });


     $("#relationType").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");

            if(optionValue == 27)
            {
               $(".fk_hhh_cause").prop('required',true);
               $(".hhdate").prop('required',true);
               $(".changeCause").show();
               $(".hhefectiveDate").show();

            } else{

               $(".fk_hhh_cause").prop('required',false);
               $(".hhdate").prop('required',false);
               $(".changeCause").hide();
               $(".hhefectiveDate").hide();
            }
        });
    }).change();

   });

</script>