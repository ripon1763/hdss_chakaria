
<script type="text/javascript">

$( document ).ready(function() {

     $("#educationType").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");

            if(optionValue == 45)
            {
               $(".yearOfEdu").prop('required',false);
               $(".yearEdu").hide();

            } else{

               $(".yearOfEdu").prop('required',true);
               $(".yearEdu").show();
            }
        });
    }).change();
 });

</script>


<?php $baseID = $this->input->get('baseID',TRUE); ?>
 <?php 
    $id = 0;
	$fk_religious_edu = 0;
	$fk_secular_edu = 0;
	$fk_education_type = 0;
	$year_of_education = 0;
    $member_master_id = 0;
    $household_master_id = 0;
    $roundNo = 0;
	$member_code = '';
    $member_name = '';


    if (!empty($educationRecord)) 
    { 

        $id = $educationRecord[0]->id; 
		$fk_religious_edu = $educationRecord[0]->fk_religious_edu; 
		$fk_secular_edu = $educationRecord[0]->fk_secular_edu; 
		$member_code = $educationRecord[0]->member_code; 
		$fk_education_type = $educationRecord[0]->fk_education_type; 
		$year_of_education = $educationRecord[0]->year_of_education; 
		$member_name = $educationRecord[0]->member_name; 
        $roundNo = $educationRecord[0]->roundNo; 
        $member_master_id = $educationRecord[0]->member_master_id; 
        $household_master_id = $educationRecord[0]->household_master_id; 
		

    } 

    ?>

                    <form action="<?php echo base_url().'memberEducation/editEducationDetails?baseID='.$baseID ?>" id="myForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8">

                    <!-- SmartWizard html -->
                  
                           
                     
                            <div id="education" style="padding-left: 20px; padding-right: 20px">
                                <h4>Education Details</h4>
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
												<label for="Active">Type of education <span style="color:red">*</span></label>
												<select class="form-control required" id="educationType" name="educationType" required>
													<option value="">Please Select</option>
													 <?php
													if(!empty($educationtyp))
													{
														foreach ($educationtyp as $educationtyp)
														{
															?>
															<option <?php if($fk_education_type ==$educationtyp->id ) { echo "selected=selected";} ?> value="<?php echo $educationtyp->id ?>"><?php echo $educationtyp->code. '-' .$educationtyp->name ?></option>
															<?php
														}
													}
													?>
													
												</select>
											</div>
										</div>
										<div class="col-md-12 yearEdu">
											<div class="form-group">
												<label for="Item Name">Year of Education <span style="color:red">*</span></label>
												<input type="text" value="<?php echo $year_of_education ?>" class="form-control yearOfEdu" id="yearOfEdu"  name="yearOfEdu" maxlength="255" >
											</div>
										</div>

									   
										<!--<div class="col-md-12">
											<div class="form-group">
												<label for="Active">Secular education</label>
												<select class="form-control required" id="secularEduType" name="secularEduType" required>
													<option value="">Please Select</option>
													 <?php
													if(!empty($secularedutyp))
													{
														foreach ($secularedutyp as $secularedutyp)
														{
															?>
															<option <?php if($fk_secular_edu ==$secularedutyp->id ) { echo "selected=selected";} ?> value="<?php echo $secularedutyp->id ?>"><?php echo $secularedutyp->code. '-' .$secularedutyp->name ?></option>
															<?php
														}
													}
													?>
													
												</select>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="Active">Religious education </label>
												<select class="form-control required" id="religiousEduType" name="religiousEduType" required>
													<option value="">Please Select</option>
													 <?php
													if(!empty($religiousedutype))
													{
														foreach ($religiousedutype as $religiousedu)
														{
															?>
															<option <?php if($fk_religious_edu ==$religiousedu->id ) { echo "selected=selected";} ?> value="<?php echo $religiousedu->id ?>"><?php echo $religiousedu->code. '-' .$religiousedu->name ?></option>
															<?php
														}
													}
													?>
													
												</select>
											</div>
										</div> -->


                                    </div>
 
                                </div>

                            </div>

                            
                             <?php if ($id > 0) { ?>
							 
                             <div class="box-footer" style="margin-left: 10px">
                                <input type="hidden" name="household_master_id_sub" value="<?php echo  $household_master_id_sub  ?>">
                                <input type="hidden" name="round_master_id" value="<?php echo  $round_master_id  ?>">
                                <input type="hidden" name="member_master_id" value="<?php echo  $member_master_id  ?>">
                                <input type="hidden" name="educationID" value="<?php echo  $id  ?>">
                                <input type="submit" class="btn btn-primary btnVisile" name="submit" value="Save" />
                                <a class="btn btn-primary" href="<?php echo base_url().'householdvisit/education?baseID='.$baseID.'#education' ?>" class="">Back </a>
                               
                            </div>
							
							 <?php } ?>
                           
                       

                     </form>

                    
                   
                  
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>

