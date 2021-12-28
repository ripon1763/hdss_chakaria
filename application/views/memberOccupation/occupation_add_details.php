
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


                    <form action="<?php echo base_url().'memberOccupation/addOccupationDetails?baseID='.$baseID ?>" id="myForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8">

                    <!-- SmartWizard html -->
                  
                           
                     
                            <div id="education" style="padding-left: 20px; padding-right: 20px">
                                <h4>Occupation Details</h4>
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
                        												
                        												                    <label for="Active">Main occupation <span style="color:red">*</span></label>
                        			                                        <select class="form-control required" id="occupationType" name="occupationType" required>
                        			                                            <option value="">Please Select</option>
                        			                                             <?php
                        			                                            if(!empty($occupationtyp))
                        			                                            {
                        			                                                foreach ($occupationtyp as $occupationtyp)
                        			                                                {
                        			                                                    ?>
                        			                                                    <option value="<?php echo $occupationtyp->id ?>"><?php echo $occupationtyp->code. '-' .$occupationtyp->name ?></option>
                        			                                                    <?php
                        			                                                }
                        			                                            }
                        			                                            ?>
                        			                                            
                        			                                        </select>
                        											</div>
									                     	</div>

                                         <div class="col-md-12 occupationOth">
                                              <div class="form-group">
                                                  <label for="Item Name">Specify Other Occupation <span style="color:red">*</span></label>
                                                  <input type="text" class="form-control main_occupation_oth" id="main_occupation_oth"  name="main_occupation_oth" maxlength="255" >
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
                                <a class="btn btn-primary" href="<?php echo base_url().'householdvisit/occupation?baseID='.$baseID.'#occupation' ?>" class="">Back </a>
                               
                            </div>
							
							
                       

                     </form>

                    
                   
                  
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">

    $(document).ready(function() {

       $("#occupationType").change(function(){
            $(this).find("option:selected").each(function(){
                var optionValue = $(this).attr("value");

                //alert(optionValue);

                if(optionValue == 166)
                {
                  
                   $(".main_occupation_oth").prop('required',true);
                   $(".occupationOth").show();

                } else{


                    $(".main_occupation_oth").prop('required',false);
                    $(".occupationOth").hide();
                }
            });
        }).change();

  });


</script>
