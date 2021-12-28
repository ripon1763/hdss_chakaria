
<?php 
    $member_master_id = 0;
    $id = 0;
    $member_code = '';
    $member_name = '';
    $conception_date = '';
    $conceptOrder = '';

    if (!empty($memberInfo)) 
    { 

        $member_master_id = $memberInfo[0]->member_master_id; 
        $member_name = $memberInfo[0]->member_name; 
        $member_code = $memberInfo[0]->member_code; 
        $conception_date = $memberInfo[0]->conception_date; 
        $conceptOrder = $memberInfo[0]->conceptOrder; 
        $id = $memberInfo[0]->id; 

    } 

?>


<?php $baseID = $this->input->get('baseID',TRUE); ?>


                    <form action="<?php echo base_url().'memberBirth/addBirthDetails?baseID='.$baseID ?>" id="myForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8">

                    <!-- SmartWizard html -->
                  
                           
                     
                            <div id="birth" style="padding-left: 20px; padding-right: 20px">
                                <h4>Birth Details</h4>
                                 <div class="row">
                                     <div class="col-md-4">
                                          <p>Household Code : <?php echo $householdcode ?></p>
                                     </div>
                                      <div class="col-md-4">
                                         <p>Round Number :  <?php echo $roundNo ?></p>
                                     </div>
                                     
                                </div>

                                <div id="form-step-0" role="form" data-toggle="validator">

                                 <fieldset class="scheduler-border">
                                 <legend class="scheduler-border">Birth Information</legend>
                                    <div class="row">

                                        <div class="col-md-3">
											<div class="form-group">
												<label for="Item Name">Child Name <span style="color:red">*</span></label>
												<input type="text" class="form-control required" id="memberName"  name="memberName" maxlength="255" required="required">
											</div>
										</div>

									
										<div class="col-md-3">
											<div class="form-group">
												<label for="Active">Sex  <span style="color:red">*</span></label>
												<select class="form-control required" id="sexType" name="sexType" required>
													<option value="">Please Select</option>
												   <?php
													if(!empty($membersextype))
													{
														foreach ($membersextype as $membersex)
														{
															?>
															<option value="<?php echo $membersex->id ?>"><?php echo $membersex->code. '-' .$membersex->name ?></option>
															<?php
														}
													}
													?>
													
												</select>
											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group">
												<label for="Item Name">Birth Time <span style="color:red">*</span></label>
												<input type="text" class="form-control required" id="timepicker"  name="birth_time" maxlength="255" required="required">
											</div>
										</div> 
										
										<div class="col-md-3">
											<div class="form-group">
												<label for="Item Name">Birth Weight (KG) <span style="color:red">*</span></label>
												<input type="number" class="form-control required" id="birth_weight"  name="birth_weight" value="" step=".01" required="required">
											</div>
										</div> 
										
										<div class="col-md-3">
											<div class="form-group">
												<label for="Item Name">Birth weight status  <span style="color:red">*</span></label>
												
												<select class="form-control required" id="fk_birth_weight_size" name="fk_birth_weight_size" required>
													<option value="">Please Select</option>
												   <?php
													if(!empty($birth_weight_size))
													{
														foreach ($birth_weight_size as $birth_weight)
														{
															?>
															<option value="<?php echo $birth_weight->id ?>"><?php echo $birth_weight->code. '-' .$birth_weight->name ?></option>
															<?php
														}
													}
													?>
													
												</select>
											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group">
												<label for="Item Name">Father's RID  <span style="color:red">*</span></label>
												
												<select class="form-control required" id="fatherCode" name="fatherCode" required>
													<option value="">Please Select</option>
												   <?php
													if(!empty($maleList))
													{
														foreach ($maleList as $male)
														{
															?>
															<option value="<?php echo $male->id ?>"><?php echo $male->member_code. '-' .$male->member_name ?></option>
															<?php
														}
													}
													?>
													
												</select>
											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group">
												<label for="Item Name">Mother's RID <span style="color:red">*</span></label>
												 <select class="form-control required" id="motherCode" name="motherCode" required>
													<option value="">Please Select</option>
												   <?php
													if(!empty($femaleList))
													{
														foreach ($femaleList as $female)
														{
															?>
															<option value="<?php echo $female->id ?>"><?php echo $female->member_code. '-' .$female->member_name ?></option>
															<?php
														}
													}
													?>
													
												</select>
											</div>
										</div>
										
										<div class="col-md-3">
											<div class="form-group">
												<label for="Item Name">Pregnancy ourcome date <span style="color:red">*</span></label>
												 <select class="form-control required" id="outCodeDate" name="pregnancy_outcome_id" required>
													 <option value="">--- Select date ---</option>
													
												</select>
											</div>
										 </div>
										
										 <div class="col-md-3">
											<div class="form-group">
												<label for="Active">Relation with household head  <span style="color:red">*</span></label>
												<select class="form-control required" id="relationheadID" name="relationheadID" required>
													<option value="">Please Select</option>
												   <?php
													if(!empty($relationhhh))
													{
														foreach ($relationhhh as $relationhhh)
														{
															?>
															<option value="<?php echo $relationhhh->id ?>"><?php echo $relationhhh->code. '-' .$relationhhh->name ?></option>
															<?php
														}
													}
													?>
													
												</select>
											</div>
										</div>
  
								        <div class="col-md-3">
											<div class="form-group">
												<label for="Active">Entry type <span style="color:red">*</span></label>
												<select class="form-control required" id="entryType" name="entryType" required>
												   <!-- <option value="">Please Select</option>-->
												   <?php
													if(!empty($entryType))
													{
														foreach ($entryType as $entryType)
														{
															?>
															<option value="<?php echo $entryType->id ?>"><?php echo $entryType->code. '-' .$entryType->name ?></option>
															<?php
														}
													}
													?>
													
												</select>
											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group">
												<label for="Item Name">Entry Date <span style="color:red">*</span></label>
												<input type="text" class="form-control required" id="datepicker"  name="entryDate" maxlength="255" required="required">
											</div>
										</div> 
										
										<div class="col-md-3">
											<div class="form-group">
												<label for="Active">Present Marital status <span style="color:red">*</span></label>
												<select class="form-control required" id="maritalStatusType" name="maritalStatusType" required>
													
													 <?php
													if(!empty($maritalstatustyp))
													{
														foreach ($maritalstatustyp as $maritalstatu)
														{
															?>
															<option value="<?php echo $maritalstatu->id ?>"><?php echo $maritalstatu->code. '-' .$maritalstatu->name ?></option>
															<?php
														}
													}
													?>
													
												</select>
											</div>
										</div>
									

										<div class="col-md-3">
											<div class="form-group">
												<label for="Active">Religion <span style="color:red">*</span></label>
												<select class="form-control required" id="religionType" name="religionType" required>
													<option value="">Please Select</option>
													 <?php
													if(!empty($religion))
													{
														foreach ($religion as $religion)
														{
															?>
															<option value="<?php echo $religion->id ?>"><?php echo $religion->code. '-' .$religion->name ?></option>
															<?php
														}
													}
													?>
													
												</select>
											</div>
										</div>

										<div class="col-md-3">
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
															<option value="<?php echo $educationtyp->id ?>"><?php echo $educationtyp->code. '-' .$educationtyp->name ?></option>
															<?php
														}
													}
													?>
													
												</select>
											</div>
										</div>
										
									   
										<!--<div class="col-md-3">
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
															<option value="<?php echo $secularedutyp->id ?>"><?php echo $secularedutyp->code. '-' .$secularedutyp->name ?></option>
															<?php
														}
													}
													?>
													
												</select>
											</div>
										</div>
										<div class="col-md-3">
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
															<option value="<?php echo $religiousedu->id ?>"><?php echo $religiousedu->code. '-' .$religiousedu->name ?></option>
															<?php
														}
													}
													?>
													
												</select>
											</div>
										</div> -->
										<div class="col-md-3">
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
										
										<div class="col-md-3">
											<div class="form-group">
												<label for="Active">Mother live birth order </label>
												<select class="form-control required" id="fk_mother_live_birth_order" name="fk_mother_live_birth_order" required>
													
													 <?php
													if(!empty($mother_live_birth_order))
													{
														foreach ($mother_live_birth_order as $live_birth_order)
														{
															?>
															<option value="<?php echo $live_birth_order->id ?>"><?php echo $live_birth_order->code. '-' .$live_birth_order->name ?></option>
															<?php
														}
													}
													?>
													
												</select>
											</div>
										</div>

										<div class="col-md-3">
		                                    <div class="form-group">
		                                        <label for="Active">Birth registration done <span style="color:red">*</span></label>
		                                        <select class="form-control required" id="birstRegiType" name="birstRegiType" required>
		                                            <option value="">Please Select</option>
		                                             <?php
		                                            if(!empty($birthregistration))
		                                            {
		                                                foreach ($birthregistration as $birthregistration)
		                                                {
		                                                    ?>
		                                                    <option value="<?php echo $birthregistration->id ?>"><?php echo $birthregistration->code. '-' .$birthregistration->name ?></option>
		                                                    <?php
		                                                }
		                                            }
		                                            ?>
		                                            
		                                        </select>
		                                    </div>
		                                </div>
		                                <div class="col-md-3 birthRegi">
		                                    <div class="form-group">
		                                        <label for="Item Name">Registration date <span style="color:red">*</span></label>
		                                        <input type="text" class="form-control birthRegidate" id="birthRegidate"  name="birthRegidate" maxlength="255">
		                                    </div>
		                                </div>

		                                 <div class="col-md-3 notRegi">
		                                    <div class="form-group">
		                                        <label for="Active">why not registration <span style="color:red">*</span></label>
		                                        <select class="form-control whyNotRegi" id="whyNotRegi" name="whyNotRegi">
		                                            <option value="">Please Select</option>
		                                             <?php
		                                            if(!empty($whynotbirthreg))
		                                            {
		                                                foreach ($whynotbirthreg as $whynotbirthreg)
		                                                {
		                                                    ?>
		                                                    <option value="<?php echo $whynotbirthreg->id ?>"><?php echo $whynotbirthreg->code. '-' .$whynotbirthreg->name ?></option>
		                                                    <?php
		                                                }
		                                            }
		                                            ?>
		                                            
		                                        </select>
		                                    </div>
		                                </div>
										
										 <div class="col-md-4">
                                            <div class="form-group">
                                              
                                                 <label for="Active">Keep Follow up for Vaccination <span style="color:red">*</span></label>
                                                  <select class="form-control required" id="keep_follow_up" name="keep_follow_up" required>
                                                      <option value="1">Yes</option>
                                                      <option value="0">No</option>
                                                      
                                                  </select>
                                            </div>
                                          </div>
                                    </div>
                                    </fieldset>

                                        <fieldset class="scheduler-border">
                                           <legend class="scheduler-border">PNC-for Child</legend>
                                          <div class="row">
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="Active"> Birth of the child (name) is made to check-up within 42 days? </label>
                                                    <select class="form-control required" id="checkupTypeChild" name="checkupTypeChild">
                                                        <option value="0">Please Select</option>
                                                         <?php
                                                        if(!empty($onlyYesNo))
                                                        {
                                                            foreach ($onlyYesNo as $onlyync)
                                                            {
                                                                ?>
                                                                <option value="<?php echo $onlyync->id ?>"><?php echo $onlyync->code. '-' .$onlyync->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                        
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6 manyTimesChild">
                                                <div class="form-group">
                                                    <label for="Item Name">If yes, Total times <span style="color:red">*</span></label>
                                                    <input type="number" class="form-control afterTotalTimesChild" id="afterTotalTimesChild"  name="afterTotalTimesChild" placeholder="Total times">
                                                </div>
                                            </div>
											<div class="col-md-6 manyTimesChild">
                                                <div class="form-group">
                                                    <label for="Active"> Is post-natal visit conducted within 2 days or 48 hours of delivery? <span style="color:red">*</span></label>
                                                    <select class="form-control" id="fk_post_natal_visit" name="fk_post_natal_visit">
                                                        <option value="0">Please Select</option>
                                                         <?php
                                                        if(!empty($onlyYesNo))
                                                        {
                                                            foreach ($onlyYesNo as $onlyyn)
                                                            {
                                                                ?>
                                                                <option value="<?php echo $onlyyn->id ?>"><?php echo $onlyyn->code. '-' .$onlyyn->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                        
                                                    </select>
                                                </div>
                                            </div>

                                         </div> 
                                         <div class="row manyTimesChild">

										   <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Active">Who assist during PNC? (First visit)</label>
                                                    <select class="form-control required" id="childFirstVisitAsist" name="childFirstVisitAsist">
                                                        <option value="0">Please Select</option>
                                                         <?php
                                                        if(!empty($pncassisttyp))
                                                        {
                                                            foreach ($pncassisttyp as $pncassisttyp)
                                                            {
                                                                ?>
                                                                <option value="<?php echo $pncassisttyp->id ?>"><?php echo $pncassisttyp->code. '-' .$pncassisttyp->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                        
                                                    </select>
                                                </div>
                                            </div>

                                               <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Active"> Place of PNC visit (First visit)</label>
                                                    <select class="form-control required" id="childFirstVisit" name="childFirstVisit">
                                                        <option value="0">Please Select</option>
                                                         <?php
                                                        if(!empty($ancPncVisit))
                                                        {
                                                            foreach ($ancPncVisit as $childancPncVisit1)
                                                            {
                                                                ?>
                                                                <option value="<?php echo $childancPncVisit1->id ?>"><?php echo $childancPncVisit1->code. '-' .$childancPncVisit1->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    
                                                    <label for="Active">After days of delivery?(Days only)</label>
                                                    <input type="number" class="form-control " name="childFirstVisitDays" placeholder="Days only">
                                                </div>
                                            </div>
											<div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Active">Who assist during PNC? (Second visit)</label>
                                                    <select class="form-control required" id="childSecondVisitAsist" name="childSecondVisitAsist">
                                                        <option value="0">Please Select</option>
                                                         <?php
                                                        if(!empty($pncassisttyp1))
                                                        {
                                                            foreach ($pncassisttyp1 as $pncassisttyp1)
                                                            {
                                                                ?>
                                                                <option value="<?php echo $pncassisttyp1->id ?>"><?php echo $pncassisttyp1->code. '-' .$pncassisttyp1->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                             <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Active"> Place of PNC visit (Second visit </label>
                                                    <select class="form-control required" id="childSecondVisit" name="childSecondVisit" placeholder="Days only">
                                                        <option value="0">Please Select</option>
                                                         <?php
                                                        if(!empty($ancPncVisit))
                                                        {
                                                            foreach ($ancPncVisit as $childancPncVisit2)
                                                            {
                                                                ?>
                                                                <option value="<?php echo $childancPncVisit2->id ?>"><?php echo $childancPncVisit2->code. '-' .$childancPncVisit2->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    
                                                    <label for="Active">After days of delivery?(Days only)</label>
                                                    <input type="number" class="form-control " name="childSecondVisitDays" placeholder="Days only">
                                                </div>
                                            </div>

                                        </div>

                                      </fieldset>
 
                                </div>

                            </div>

                            
                            
							 
                             <div class="box-footer" style="margin-left: 10px">
                                <input type="hidden" name="household_master_id_sub" value="<?php echo  $household_master_id_sub  ?>">
                                <input type="hidden" name="round_master_id" value="<?php echo  $round_master_id  ?>">
                                <input type="submit" class="btn btn-primary btnVisile" name="submit" value="Save" />
                                <a class="btn btn-primary" href="<?php echo base_url().'householdvisit/birth?baseID='.$baseID.'#birth' ?>" class="">Back </a>
                               
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

  $('#timepicker').wickedpicker();
   $('#datepicker').datepicker({
     autoclose: true,
     format: 'dd/mm/yyyy'
   });

    $('#birthRegidate').datepicker({
     autoclose: true,
     format: 'dd/mm/yyyy'
   });



    $("#birstRegiType").change(function(){

        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");

            if(optionValue == 1)
            {
               $(".birthRegidate").prop('required',true);
               $(".whyNotRegi").prop('required',false);
               $(".birthRegi").show();
               $(".notRegi").hide();

            } else{

               $(".birthRegidate").prop('required',false);
               $(".whyNotRegi").prop('required',true);
               $(".birthRegi").hide();
               $(".notRegi").show();
            }
        });
    }).change();
   
   
     $('#motherCode').change(function(){
          var motherCode = $('#motherCode').val();
          if(motherCode != '')
          {
           $.ajax({
            url:"<?php echo base_url(); ?>api/getPrenancyListbyMother",
            method:"POST",
            data:{motherCode:motherCode},
            success:function(data)
            {
             $('#outCodeDate').html('');
             $('#outCodeDate').html(data);
            }
           });
          }
          else
          {
           $('#outCodeDate').html('<option value="">--- Select Date ---</option>');
          }
     });
   
   
      $('#educationType').val('45').trigger('change');
      $('#occupationType').val('54').trigger('change');



   $("#checkupTypeChild").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");

            if(optionValue == 1)
            {
               $(".afterTotalTimesChild").prop('required',true);
               $(".manyTimesChild").show();

            } else{

               $(".afterTotalTimesChild").prop('required',false);
               $(".manyTimesChild").hide();
            }
        });
    }).change();
  
   });

</script>

