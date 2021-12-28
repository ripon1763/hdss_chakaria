
<?php $baseID = $this->input->get('baseID',TRUE); ?>
 <?php 
    $id = 0;
	$conception_id = 0;
	$breast_milk_day = 0;
    $breast_milk_hour = 0;
    $keep_follow_up = 0;
    $member_master_id = 0;
    $household_master_id = 0;
    $spontaneous_abortion = 0;
    $induced_abortion = 0;
    $fk_conception_result = 0;
    $still_birth = 0;
    $live_birth = 0;
    $roundNo = 0;
	$member_code = '';
    $member_name = '';
    $conception_date = '';
    $pregnancy_outcome_date = '';
    $conceptOrder = '';
	$fk_delivery_methodology = 0;
	$fk_delivery_assist_type = 0;
	$fk_delivery_term_place = 0;
	$given_six_hour_birth = '';
	$fk_health_problem_id = 0;
	$fk_high_pressure_id = 0;
	$fk_diabetis_id = 0;
	$fk_preaklampshia_id = 0;
	$fk_lebar_birth_id = 0;
	$fk_vomiting_id = 0;
	$fk_amliotic_id = 0;
	$fk_membrane_id = 0;
	$fk_malposition_id = 0;
	$fk_headache_id = 0;

 $fk_routine_anc_chkup_mother_id= 0;
 $routine_anc_chkup_mother_times= 0;
 $fk_anc_first_visit_id= 0;
 $anc_first_visit_months= 0;
 $fk_anc_second_visit_id= 0;
 $anc_second_visit_months= 0;
 $fk_anc_third_visit_id= 0;
 $anc_third_visit_months= 0;
 $fk_anc_fourth_visit_id= 0;
 $anc_fourth_visit_months= 0;
 $fk_anc_fifth_visit_id= 0;
 $anc_fifth_visit_months= 0; 
 $fk_pnc_chkup_mother_id= 0; 
 $pnc_chkup_mother_times= 0;
 $fk_pnc_first_visit_id= 0;
 $pnc_first_visit_days= 0;
 $fk_pnc_second_visit_id= 0; 
 $pnc_second_visit_days = 0;

    if (!empty($pregRecord)) 
    { 

        $id = $pregRecord[0]->id; 
		    $conception_id = $pregRecord[0]->conception_id; 
		    $breast_milk_day = $pregRecord[0]->breast_milk_day; 
        $breast_milk_hour = $pregRecord[0]->breast_milk_hour; 
        $keep_follow_up = $pregRecord[0]->keep_follow_up; 
		    $member_name = $pregRecord[0]->member_name; 
		    $member_code = $pregRecord[0]->member_code; 
        $roundNo = $pregRecord[0]->roundNo; 
        $member_master_id = $pregRecord[0]->member_master_id; 
        $household_master_id = $pregRecord[0]->household_master_id; 
        $conception_date = $pregRecord[0]->conception_date; 
        $pregnancy_outcome_date = $pregRecord[0]->pregnancy_outcome_date; 
        $conceptOrder = $pregRecord[0]->conceptOrder; 
        $spontaneous_abortion = $pregRecord[0]->spontaneous_abortion; 
        $induced_abortion = $pregRecord[0]->induced_abortion; 
        $live_birth = $pregRecord[0]->live_birth; 
        $still_birth = $pregRecord[0]->still_birth; 
        $fk_conception_result = $pregRecord[0]->fk_conception_result; 
        $fk_delivery_methodology = $pregRecord[0]->fk_delivery_methodology; 
        $fk_delivery_assist_type = $pregRecord[0]->fk_delivery_assist_type; 
        $fk_delivery_term_place = $pregRecord[0]->fk_delivery_term_place; 
        $given_six_hour_birth = $pregRecord[0]->given_six_hour_birth; 
        $fk_health_problem_id = $pregRecord[0]->fk_health_problem_id; 
        $fk_high_pressure_id = $pregRecord[0]->fk_high_pressure_id; 
        $fk_diabetis_id = $pregRecord[0]->fk_diabetis_id; 
        $fk_preaklampshia_id = $pregRecord[0]->fk_preaklampshia_id; 
        $fk_lebar_birth_id = $pregRecord[0]->fk_lebar_birth_id; 
        $fk_vomiting_id = $pregRecord[0]->fk_vomiting_id; 
        $fk_amliotic_id = $pregRecord[0]->fk_amliotic_id; 
        $fk_membrane_id = $pregRecord[0]->fk_membrane_id; 
        $fk_malposition_id = $pregRecord[0]->fk_malposition_id; 
        $fk_headache_id = $pregRecord[0]->fk_headache_id; 

         $fk_routine_anc_chkup_mother_id= $pregRecord[0]->fk_routine_anc_chkup_mother_id; 
         $routine_anc_chkup_mother_times= $pregRecord[0]->routine_anc_chkup_mother_times; 
         $fk_anc_first_visit_id= $pregRecord[0]->fk_anc_first_visit_id; 
         $anc_first_visit_months= $pregRecord[0]->anc_first_visit_months; 
         $fk_anc_second_visit_id= $pregRecord[0]->fk_anc_second_visit_id; 
         $anc_second_visit_months= $pregRecord[0]->anc_second_visit_months; 
         $fk_anc_third_visit_id= $pregRecord[0]->fk_anc_third_visit_id; 
         $anc_third_visit_months= $pregRecord[0]->anc_third_visit_months; 
         $fk_anc_fourth_visit_id= $pregRecord[0]->fk_anc_fourth_visit_id; 
         $anc_fourth_visit_months= $pregRecord[0]->anc_fourth_visit_months; 
         $fk_anc_fifth_visit_id= $pregRecord[0]->fk_anc_fifth_visit_id; 
         $anc_fifth_visit_months= $pregRecord[0]->anc_fifth_visit_months;  

         $fk_pnc_chkup_mother_id= $pregRecord[0]->fk_pnc_chkup_mother_id;  
         $pnc_chkup_mother_times= $pregRecord[0]->pnc_chkup_mother_times; 
         $fk_pnc_first_visit_id= $pregRecord[0]->fk_pnc_first_visit_id; 
         $pnc_first_visit_days= $pregRecord[0]->pnc_first_visit_days; 
         $fk_pnc_second_visit_id= $pregRecord[0]->fk_pnc_second_visit_id; 
         $pnc_second_visit_days = $pregRecord[0]->pnc_second_visit_days; 
		

    } 

    ?>

                    <form action="<?php echo base_url().'memberPregnancy/editPregnancyDetails?baseID='.$baseID ?>" id="myForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8">

                     
                            <div id="pregnancy" style="padding-left: 20px; padding-right: 20px">
                                <h4>Pregnancy Details</h4>
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
                                         
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Active">Member Information : </label>
                                                <?php echo $member_code.'-'.$member_name ?>
                                            </div>
                                        </div>
										                   <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Active">Conception Date : </label>
                                                <?php echo date('j F Y', strtotime($conception_date)) ?>
                                            </div>
                                        </div>
										                   <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Active">Conception Order : </label>
                                                <?php echo $conceptOrder ?>
                                            </div>
                                        </div>
                                      </div>


                                      
                                      <div class="row">

                                         <div class="col-md-4">
                                              <div class="form-group">
                                                  <label for="Item Name">Preg outcome date <span style="color:red">*</span></label>
												  
												                           <?php 
                                                   if ($pregnancy_outcome_date != "")
                                                   {
                                                    $partsRequire = explode('-', $pregnancy_outcome_date);
                                                    $pregnancy_outcome_date = $partsRequire[2].'/'.$partsRequire[1].'/'.$partsRequire[0];
                                                   }
                                                  ?>
                                                  <input type="text" class="form-control hhdate" id="conceptionDate" value="<?php echo $pregnancy_outcome_date; ?>"  name="pregnancy_outcome_date" maxlength="255" required >
                                              </div>
                                          </div>
                                          

                                          <div class="col-md-4">
                                            <div class="form-group">
                                              
                                                 <label for="Active">Spontaneous abortion <span style="color:red">*</span></label>
                                                  <select class="form-control required" id="spontaneous_abortion" name="spontaneous_abortion" required>
                                                      <option <?php if ($spontaneous_abortion == 0) { echo "selected=selected"; } ?> value="0">0</option>
                                                      <option <?php if ($spontaneous_abortion == 1) { echo "selected=selected"; } ?> value="1">1</option>

 
                                                  </select>
                                            </div>
                                          </div>
										  
										                      <div class="col-md-4">
                                            <div class="form-group">
                                              
                                                 <label for="Active">Induced abortion <span style="color:red">*</span></label>
                                                  <select class="form-control required" id="induced_abortion" name="induced_abortion" required>
                                                      <option <?php if ($induced_abortion == 0) { echo "selected=selected"; } ?> value="0">0</option>
                                                      <option <?php if ($induced_abortion == 1) { echo "selected=selected"; } ?> value="1">1</option>
                                                      
                                                  </select>
                                            </div>
                                          </div>
										                      <div class="col-md-4">
                                            <div class="form-group">
                                              
                                                 <label for="Active">Still birth <span style="color:red">*</span></label>
                                                  <select class="form-control required" id="still_birth" name="still_birth" required>
                                                      <option <?php if ($still_birth == 0) { echo "selected=selected"; } ?> value="0">0</option>
                                                      <option <?php if ($still_birth == 1) { echo "selected=selected"; } ?> value="1">1</option>
                                                      <option <?php if ($still_birth == 2) { echo "selected=selected"; } ?> value="2">2</option>
                                                      <option <?php if ($still_birth == 3) { echo "selected=selected"; } ?> value="3">3</option>
                                                      
                                                  </select>
                                            </div>
                                          </div>
										  
										                      <div class="col-md-4">
                                            <div class="form-group">
                                              
                                                 <label for="Active">Live birth <span style="color:red">*</span></label>
                                                  <select class="form-control required" id="live_birth" name="live_birth" required>
                                                      <option <?php if ($live_birth == 0) { echo "selected=selected"; } ?> value="0">0</option>
                                                      <option <?php if ($live_birth == 1) { echo "selected=selected"; } ?> value="1">1</option>
                                                      <option <?php if ($live_birth == 2) { echo "selected=selected"; } ?> value="2">2</option>
                                                      <option <?php if ($live_birth == 3) { echo "selected=selected"; } ?> value="3">3</option>
                                                      <option <?php if ($live_birth == 4) { echo "selected=selected"; } ?> value="4">4</option>
                                                      
                                                  </select>
                                            </div>
                                          </div>
										  
										                     <div class="col-md-4">
                                            <div class="form-group">
                                              
                                                 <label for="Active">Result of Pregnancy? <span style="color:red">*</span></label>
                                                  <select class="form-control required" id="fk_conception_result" name="fk_conception_result" required>
                                                      <option value="">Please select</option>
                                                      <?php
                                                      if(!empty($pregnancy_result))
                                                      {
                                                          foreach ($pregnancy_result as $pregnancyrelt)
                                                          {
                                                              ?>
                                                              <option <?php if ($fk_conception_result == $pregnancyrelt->id) { echo "selected=selected"; } ?> value="<?php echo $pregnancyrelt->id ?>"><?php echo $pregnancyrelt->code. '-' .$pregnancyrelt->name ?></option>
                                                              <?php
                                                          }
                                                      }
                                                      ?>
                                                      
                                                  </select>
                                            </div>
                                          </div>
										  
										                     <div class="col-md-4">
                                            <div class="form-group">
                                              
                                                 <label for="Active">Delivery section/type ? <span style="color:red">*</span></label>
                                                  <select class="form-control required" id="fk_delivery_methodology" name="fk_delivery_methodology" required>
                                                      <option value="">Please select</option>
                                                      <?php
                                                      if(!empty($delivery_methodology))
                                                      {
                                                          foreach ($delivery_methodology as $delivery)
                                                          {
                                                              ?>
                                                              <option <?php if ($fk_delivery_methodology == $delivery->id) { echo "selected=selected"; } ?> value="<?php echo $delivery->id ?>"><?php echo $delivery->code. '-' .$delivery->name ?></option>
                                                              <?php
                                                          }
                                                      }
                                                      ?>
                                                      
                                                  </select>
                                            </div>
                                          </div>
										  
										                      <div class="col-md-4">
                                            <div class="form-group">
                                              
                                                 <label for="Active">Assistance during preg termination ? <span style="color:red">*</span></label>
                                                  <select class="form-control required" id="fk_delivery_assist_type" name="fk_delivery_assist_type" required>
                                                     <option value="">Please select</option>
                                                      <?php
                                                      if(!empty($preg_term_assist))
                                                      {
                                                          foreach ($preg_term_assist as $pregtermassist)
                                                          {
                                                              ?>
                                                              <option <?php if ($fk_delivery_assist_type == $pregtermassist->id) { echo "selected=selected"; } ?> value="<?php echo $pregtermassist->id ?>"><?php echo $pregtermassist->code. '-' .$pregtermassist->name ?></option>
                                                              <?php
                                                          }
                                                      }
                                                      ?>
                                                      
                                                  </select>
                                            </div>
                                          </div>
										  
										 
										  
										                      <div class="col-md-4">
                                            <div class="form-group">
                                              
                                                 <label for="Active">Place of preg termination ? <span style="color:red">*</span></label>
                                                  <select class="form-control required" id="fk_delivery_term_place" name="fk_delivery_term_place" required>
                                                     <option value="">Please select</option>
                                                      <?php
                                                      if(!empty($preg_term_place))
                                                      {
                                                          foreach ($preg_term_place as $pregtermplace)
                                                          {
                                                              ?>
                                                              <option <?php if ($fk_delivery_term_place == $pregtermplace->id) { echo "selected=selected"; } ?> value="<?php echo $pregtermplace->id ?>"><?php echo $pregtermplace->code. '-' .$pregtermplace->name ?></option>
                                                              <?php
                                                          }
                                                      }
                                                      ?>
                                                      
                                                  </select>
                                            </div>
                                          </div>
										  
										                     <div class="col-md-4">
                                            <div class="form-group">
                                              
                                                 <label for="Active">What was given to baby within six hour of birth first (ff) ?</label>
                                                  <input type="text" value="<?php echo $given_six_hour_birth ?>" class="form-control required" name="given_six_hour_birth" >
                                            </div>
                                          </div>
										  
										                     <div class="col-md-4">
                                            <div class="form-group">
                                              
                                                 <label for="Active">Breast milk was given first after birth (fbm): day (number) ? <span style="color:red">*</span></label>
                                                  <input type="number" class="form-control required" value="<?php echo $breast_milk_day ?>" name="breast_milk_day" >
                                            </div>
                                          </div>
										  
										                     <div class="col-md-4">
                                            <div class="form-group">
                                              
                                                 <label for="Active">Breast milk was given first after birth (fbm): hour (number) ? <span style="color:red">*</span></label>
                                                  <input type="number" class="form-control required" value="<?php echo $breast_milk_hour ?>" name="breast_milk_hour" >
                                            </div>
                                          </div>
										  
										                       <div class="col-md-4">
                                            <div class="form-group">
                                              
                                                 <label for="Active">প্রসবের সময় (স্বাস্থ্য সম্পর্কিত) কোন জটিলতা হয়েছিল? <span style="color:red">*</span></label>
                                                  <select class="form-control required" id="healthProb" name="fk_health_problem_id" required>
                                                      <option value="">Please select</option>
													                         <?php
                                                      if(!empty($yes_no_miss_not_app))
                                                      {
                                                          foreach ($yes_no_miss_not_app as $yesnomissnotapp)
                                                          {
                                                              ?>
                                                              <option <?php if ($fk_health_problem_id == $yesnomissnotapp->id) { echo "selected=selected"; } ?> value="<?php echo $yesnomissnotapp->id ?>"><?php echo $yesnomissnotapp->code. '-' .$yesnomissnotapp->name ?></option>
                                                              <?php
                                                          }
                                                      }
                                                      ?>
                                                      
                                                  </select>
                                            </div>
                                          </div>
										                     <div class="col-md-4">
                                            <div class="form-group">
                                              
                                                 <label for="Active">উচ্চরক্তচাপ হয়েছিল কিনা?  </label>
                                                  <select class="form-control required" id="highPressure" name="fk_high_pressure_id">
                                                     <option value="0">Please select</option>
													                          <?php
                                                      if(!empty($yes_no_miss_not_app))
                                                      {
                                                          foreach ($yes_no_miss_not_app as $yesnohigh)
                                                          {
                                                              ?>
                                                              <option <?php if ($fk_high_pressure_id == $yesnohigh->id) { echo "selected=selected"; } ?> value="<?php echo $yesnohigh->id ?>"><?php echo $yesnohigh->code. '-' .$yesnohigh->name ?></option>
                                                              <?php
                                                          }
                                                      }
                                                      ?>
                                                      
                                                  </select>
                                            </div>
                                          </div>
										  
										                      <div class="col-md-4">
                                            <div class="form-group">
                                              
                                                 <label for="Active">ডায়াবেটিস হয়েছিল কিনা?  </label>
                                                  <select class="form-control required" id="diabetic" name="fk_diabetis_id">
                                                      <option value="0">Please select</option>
													                          <?php
                                                      if(!empty($yes_no_miss_not_app))
                                                      {
                                                          foreach ($yes_no_miss_not_app as $yesnodia)
                                                          {
                                                              ?>
                                                              <option <?php if ($fk_diabetis_id == $yesnodia->id) { echo "selected=selected"; } ?> value="<?php echo $yesnodia->id ?>"><?php echo $yesnodia->code. '-' .$yesnodia->name ?></option>
                                                              <?php
                                                          }
                                                      }
                                                      ?>
                                                      
                                                  </select>
                                            </div>
                                          </div>
										  
										                       <div class="col-md-4">
                                            <div class="form-group">
                                              
                                                 <label for="Active">প্রি-এক্লাম্পসিয়া হয়েছিল কিনা?  </label>
                                                  <select class="form-control required" id="ekclapshia" name="fk_preaklampshia_id">
                                                      <option value="0">Please select</option>
													                         <?php
                                                      if(!empty($yes_no_miss_not_app))
                                                      {
                                                          foreach ($yes_no_miss_not_app as $yesnopre)
                                                          {
                                                              ?>
                                                              <option <?php if ($fk_preaklampshia_id == $yesnopre->id) { echo "selected=selected"; } ?> value="<?php echo $yesnopre->id ?>"><?php echo $yesnopre->code. '-' .$yesnopre->name ?></option>
                                                              <?php
                                                          }
                                                      }
                                                      ?>
                                                      
                                                  </select>
                                            </div>
                                          </div>
										  
										                     <div class="col-md-4">
                                            <div class="form-group">
                                              
                                                 <label for="Active">প্রিটার্ম লেবার এন্ড বার্থ হয়েছিল কিনা? </label>
                                                  <select class="form-control required" id="pretermlab" name="fk_lebar_birth_id">
                                                      <option value="0">Please select</option>
													                            <?php
                                                      if(!empty($yes_no_miss_not_app))
                                                      {
                                                          foreach ($yes_no_miss_not_app as $yesnoprelab)
                                                          {
                                                              ?>
                                                              <option <?php if ($fk_lebar_birth_id == $yesnoprelab->id) { echo "selected=selected"; } ?> value="<?php echo $yesnoprelab->id ?>"><?php echo $yesnoprelab->code. '-' .$yesnoprelab->name ?></option>
                                                              <?php
                                                          }
                                                      }
                                                      ?>
                                                      
                                                  </select>
                                            </div>
                                          </div>
										  
										                      <div class="col-md-4">
                                            <div class="form-group">
                                              
                                                 <label for="Active">  তীব্র ক্রমাগত বমি বমি ভাব এবং বমি হয়েছিল কিনা?</label>
                                                  <select class="form-control required" id="bomitic" name="fk_vomiting_id">
                                                      <option value="0">Please select</option>
													                          <?php
                                                      if(!empty($yes_no_miss_not_app))
                                                      {
                                                          foreach ($yes_no_miss_not_app as $yesnobim)
                                                          {
                                                              ?>
                                                              <option  <?php if ($fk_vomiting_id == $yesnobim->id) { echo "selected=selected"; } ?> value="<?php echo $yesnobim->id ?>"><?php echo $yesnobim->code. '-' .$yesnobim->name ?></option>
                                                              <?php
                                                          }
                                                      }
                                                      ?>
                                                      
                                                  </select>
                                            </div>
                                          </div>
										  
										                      <div class="col-md-4">
                                            <div class="form-group">
                                              
                                                 <label for="Active">  অমনিওটিক ফ্লুইডের স্বল্পতা হয়েছিল কিনা? </label>
                                                  <select class="form-control required" id="amentic" name="fk_amliotic_id">
                                                     <option value="0">Please select</option>
													                         <?php
                                                      if(!empty($yes_no_miss_not_app))
                                                      {
                                                          foreach ($yes_no_miss_not_app as $yesnofluid)
                                                          {
                                                              ?>
                                                              <option <?php if ($fk_amliotic_id == $yesnofluid->id) { echo "selected=selected"; } ?> value="<?php echo $yesnofluid->id ?>"><?php echo $yesnofluid->code. '-' .$yesnofluid->name ?></option>
                                                              <?php
                                                          }
                                                      }
                                                      ?>
                                                      
                                                  </select>
                                            </div>
                                          </div>
										  
										                      <div class="col-md-4">
                                            <div class="form-group">
                                              
                                                 <label for="Active"> মেমব্রেন ছিড়ে গিয়েছিল এবং ৬ ঘন্টার বেশী সময় ব্যাথা ? </label>
                                                  <select class="form-control required" id="membren" name="fk_membrane_id">
                                                     <option value="0">Please select</option>
													                           <?php
                                                      if(!empty($yes_no_miss_not_app))
                                                      {
                                                          foreach ($yes_no_miss_not_app as $yesnomem)
                                                          {
                                                              ?>
                                                              <option <?php if ($fk_membrane_id == $yesnomem->id) { echo "selected=selected"; } ?> value="<?php echo $yesnomem->id ?>"><?php echo $yesnomem->code. '-' .$yesnomem->name ?></option>
                                                              <?php
                                                          }
                                                      }
                                                      ?>
                                                      
                                                  </select>
                                            </div>
                                          </div>
										  
										                      <div class="col-md-4">
                                            <div class="form-group">
                                              
                                                 <label for="Active">ম্যালপজিশন এন্ড ম্যালপ্রেজেন্টেশন হয়েছিল কিনা? </label>
                                                  <select class="form-control required" id="malposition" name="fk_malposition_id">
                                                      <option value="0">Please select</option>
													                          <?php
                                                      if(!empty($yes_no_miss_not_app))
                                                      {
                                                          foreach ($yes_no_miss_not_app as $yesnomal)
                                                          {
                                                              ?>
                                                              <option <?php if ($fk_malposition_id == $yesnomal->id) { echo "selected=selected"; } ?> value="<?php echo $yesnomal->id ?>"><?php echo $yesnomal->code. '-' .$yesnomal->name ?></option>
                                                              <?php
                                                          }
                                                      }
                                                      ?>
                                                      
                                                  </select>
                                            </div>
                                          </div>
										  
										                      <div class="col-md-4">
                                            <div class="form-group">
                                              
                                                 <label for="Active">তীব্র মাথা ব্যাথার সাথে ঝাপসা দৃষ্টি ছিল কিনা?</label>
                                                  <select class="form-control required" id="headeache" name="fk_headache_id">
                                                      <option value="0">Please select</option>
													                        <?php
                                                      if(!empty($yes_no_miss_not_app))
                                                      {
                                                          foreach ($yes_no_miss_not_app as $yesnohead)
                                                          {
                                                              ?>
                                                              <option <?php if ($fk_headache_id == $yesnohead->id) { echo "selected=selected"; } ?> value="<?php echo $yesnohead->id ?>"><?php echo $yesnohead->code. '-' .$yesnohead->name ?></option>
                                                              <?php
                                                          }
                                                      }
                                                      ?>
                                                      
                                                  </select>
                                            </div>
                                          </div>
										
										                     <!-- <div class="col-md-4">
                                            <div class="form-group">
                                              
                                                 <label for="Active">Keep Follow up for PNC <span style="color:red">*</span></label>
                                                  <select class="form-control required" id="keep_follow_up" name="keep_follow_up" required>
                                                      <option <?php if ($keep_follow_up == 1) { echo "selected=selected"; } ?> value="1">Yes</option>
                                                      <option <?php if ($keep_follow_up == 0) { echo "selected=selected"; } ?> value="0">No</option>
                                                      
                                                  </select>
                                            </div>
                                          </div> -->

                                    </div>

                                    <fieldset class="scheduler-border">
                                           <legend class="scheduler-border">ANC for Mother</legend>
                                          <div class="row">
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="Active"> Routine check-up in pregnancy  for mother <span style="color:red">*</span></label>
                                                    <select class="form-control required" id="checkupTypeRoutine" name="checkupTypeRoutine" required>
                                                        <option value="">Please Select</option>
                                                         <?php
                                                        if(!empty($onlyYesNo))
                                                        {
                                                            foreach ($onlyYesNo as $onlyynr)
                                                            {
                                                                ?>
                                                                <option <?php if ($fk_routine_anc_chkup_mother_id == $onlyynr->id) { echo "selected=selected"; } ?> value="<?php echo $onlyynr->id ?>"><?php echo $onlyynr->code. '-' .$onlyynr->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                        
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6 manyTimesRoutine">
                                                <div class="form-group">
                                                    <label for="Item Name">If yes, Total times <span style="color:red">*</span></label>
                                                    <input type="number" class="form-control afterTotalTimesRoutine" id="afterTotalTimesRoutine"  name="afterTotalTimesRoutine" value="<?php echo $routine_anc_chkup_mother_times ?>">
                                                </div>
                                            </div>

                                         </div> 
                                         <div class="row manyTimesRoutine">

                                               <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="Active"> First Visit</label>
                                                    <select class="form-control required" id="routineFirstVisit" name="routineFirstVisit">
                                                        <option value="0">Please Select</option>
                                                         <?php
                                                        if(!empty($ancPncVisit))
                                                        {
                                                            foreach ($ancPncVisit as $rutancPncVisit1)
                                                            {
                                                                ?>
                                                                <option <?php if ($fk_anc_first_visit_id == $rutancPncVisit1->id) { echo "selected=selected"; } ?> value="<?php echo $rutancPncVisit1->id ?>"><?php echo $rutancPncVisit1->code. '-' .$rutancPncVisit1->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    
                                                    <label for="Active">Number of months visit(month only)</label>
                                                    <input type="number" class="form-control" placeholder="months" name="routineFirstVisitMonthss" value="<?php echo $anc_first_visit_months ?>">
                                                </div>
                                            </div>
                                             <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="Active"> Second Visit </label>
                                                    <select class="form-control required" id="routineSecondVisit" name="routineSecondVisit">
                                                        <option value="0">Please Select</option>
                                                         <?php
                                                        if(!empty($ancPncVisit))
                                                        {
                                                            foreach ($ancPncVisit as $rutancPncVisit2)
                                                            {
                                                                ?>
                                                                <option <?php if ($fk_anc_second_visit_id == $rutancPncVisit2->id) { echo "selected=selected"; } ?> value="<?php echo $rutancPncVisit2->id ?>"><?php echo $rutancPncVisit2->code. '-' .$rutancPncVisit2->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    
                                                    <label for="Active">Number of months visit(month only)</label>
                                                    <input type="number" class="form-control " placeholder="months" name="routineSecondVisitMonths" value="<?php echo $anc_second_visit_months ?>">
                                                </div>
                                            </div>

                                            <!-- third-->
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="Active"> Third Visit </label>
                                                    <select class="form-control required" id="routineThirdVisit" name="routineThirdVisit">
                                                        <option value="0">Please Select</option>
                                                         <?php
                                                        if(!empty($ancPncVisit))
                                                        {
                                                            foreach ($ancPncVisit as $rutancPncVisit3)
                                                            {
                                                                ?>
                                                                <option <?php if ($fk_anc_third_visit_id == $rutancPncVisit3->id) { echo "selected=selected"; } ?> value="<?php echo $rutancPncVisit3->id ?>"><?php echo $rutancPncVisit3->code. '-' .$rutancPncVisit3->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    
                                                    <label for="Active">Number of months visit(month only)</label>
                                                    <input type="number" class="form-control " placeholder="months" name="routineThirdVisitMonths" value="<?php echo $anc_third_visit_months ?>">
                                                </div>
                                            </div>
                                            <!-- fourth-->
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="Active"> Fourth Visit </label>
                                                    <select class="form-control required" id="routineSecFourthVisit" name="routineFourthVisit">
                                                        <option value="0">Please Select</option>
                                                         <?php
                                                        if(!empty($ancPncVisit))
                                                        {
                                                            foreach ($ancPncVisit as $rutancPncVisit4)
                                                            {
                                                                ?>
                                                                <option <?php if ($fk_anc_fourth_visit_id == $rutancPncVisit4->id) { echo "selected=selected"; } ?> value="<?php echo $rutancPncVisit4->id ?>"><?php echo $rutancPncVisit4->code. '-' .$rutancPncVisit4->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    
                                                    <label for="Active">Number of months visit(month only)</label>
                                                    <input type="number" class="form-control " placeholder="months" name="routineFourthVisitMonths" value="<?php echo $anc_fourth_visit_months ?>">
                                                </div>
                                            </div>
                                            <!-- fifth-->
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="Active"> Fifth Visit </label>
                                                    <select class="form-control required" id="routineFifthVisit" name="routineFifthVisit">
                                                        <option value="0">Please Select</option>
                                                         <?php
                                                        if(!empty($ancPncVisit))
                                                        {
                                                            foreach ($ancPncVisit as $rutancPncVisit5)
                                                            {
                                                                ?>
                                                                <option <?php if ($fk_anc_fifth_visit_id == $rutancPncVisit5->id) { echo "selected=selected"; } ?> value="<?php echo $rutancPncVisit5->id ?>"><?php echo $rutancPncVisit5->code. '-' .$rutancPncVisit5->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    
                                                    <label for="Active">Number of months visit(month only)</label>
                                                    <input type="number" class="form-control " placeholder="months" name="routineFifthVisitMonths" value="<?php echo $anc_fifth_visit_months ?>">
                                                </div>
                                            </div>

                                        </div>

                                      </fieldset>

                                     <fieldset class="scheduler-border">
                                           <legend class="scheduler-border">PNC-for Mother</legend>
                                          <div class="row">
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="Active"> Within 42 days of the birth of the baby you ever had a check-up? <span style="color:red">*</span></label>
                                                    <select class="form-control required" id="checkupType" name="checkupType" required>
                                                        <option value="">Please Select</option>
                                                         <?php
                                                        if(!empty($onlyYesNo))
                                                        {
                                                            foreach ($onlyYesNo as $onlyyn)
                                                            {
                                                                ?>
                                                                <option <?php if ($fk_pnc_chkup_mother_id == $onlyyn->id) { echo "selected=selected"; } ?> value="<?php echo $onlyyn->id ?>"><?php echo $onlyyn->code. '-' .$onlyyn->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                        
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6 manyTimes">
                                                <div class="form-group">
                                                    <label for="Item Name">If yes, Total times <span style="color:red">*</span></label>
                                                    <input type="number" class="form-control afterTotalTimes" id="afterTotalTimes"  name="afterTotalTimes" value="<?php echo $pnc_chkup_mother_times ?>">
                                                </div>
                                            </div>

                                         </div> 
                                         <div class="row manyTimes">

                                               <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="Active"> First Visit</label>
                                                    <select class="form-control required" id="firstVisit" name="firstVisit">
                                                        <option value="0">Please Select</option>
                                                         <?php
                                                        if(!empty($ancPncVisit))
                                                        {
                                                            foreach ($ancPncVisit as $ancPncVisit1)
                                                            {
                                                                ?>
                                                                <option <?php if ($fk_pnc_first_visit_id == $ancPncVisit1->id) { echo "selected=selected"; } ?> value="<?php echo $ancPncVisit1->id ?>"><?php echo $ancPncVisit1->code. '-' .$ancPncVisit1->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    
                                                    <label for="Active">Number of days visit(Days only)</label>
                                                    <input type="number" class="form-control " name="firstVisitDays" value="<?php echo $pnc_first_visit_days ?>">
                                                </div>
                                            </div>
                                             <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="Active"> Second Visit </label>
                                                    <select class="form-control required" id="secondVisit" name="secondVisit">
                                                        <option value="0">Please Select</option>
                                                         <?php
                                                        if(!empty($ancPncVisit))
                                                        {
                                                            foreach ($ancPncVisit as $ancPncVisit2)
                                                            {
                                                                ?>
                                                                <option <?php if ($fk_pnc_second_visit_id == $ancPncVisit2->id) { echo "selected=selected"; } ?> value="<?php echo $ancPncVisit2->id ?>"><?php echo $ancPncVisit2->code. '-' .$ancPncVisit2->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    
                                                    <label for="Active">Number of days visit(Days only)</label>
                                                    <input type="number" class="form-control " name="secondVisitDays" value="<?php echo $pnc_second_visit_days ?>">
                                                </div>
                                            </div>

                                        </div>

                                      </fieldset>
 
                                </div>

                            </div>

                            
                             <?php if ($id > 0) { ?>
							 
                             <div class="box-footer" style="margin-left: 10px">
                                <input type="hidden" name="household_master_id_sub" value="<?php echo  $household_master_id_sub  ?>">
                                <input type="hidden" name="round_master_id" value="<?php echo  $round_master_id  ?>">
                                <input type="hidden" name="member_master_id" value="<?php echo  $member_master_id  ?>">
                                <input type="hidden" name="pregnancyID" value="<?php echo  $id  ?>">
                                <input type="hidden" name="conceptionID" value="<?php echo  $conception_id  ?>">
								<input type="hidden" name="conceptionDate" value="<?php echo  $conception_date  ?>">
                                <input type="submit" class="btn btn-primary btnVisile" name="submit" value="Save" />
                                <a class="btn btn-primary" href="<?php echo base_url().'householdvisit/pregnancy?baseID='.$baseID.'#pregnancy' ?>" class="">Back </a>
                               
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


   $('#conceptionDate').datepicker({
     autoclose: true,
     format: 'dd/mm/yyyy'
   });
   
   
   
   $("#healthProb").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");

           
            if(optionValue == 105)
            {
			  
			  $('#highPressure').val(0).trigger('change');
			  $('#headeache').val(0).trigger('change');
			  $('#diabetic').val(0).trigger('change');
			  $('#malposition').val(0).trigger('change');
			  $('#membren').val(0).trigger('change');
			  $('#amentic').val(0).trigger('change');
			  $('#ekclapshia').val(0).trigger('change');
			  $('#bomitic').val(0).trigger('change');
			  $('#pretermlab').val(0).trigger('change');

            }
			else if (optionValue == 106){

              $('#highPressure').val('108').trigger('change');
			  $('#headeache').val('108').trigger('change');
			  $('#diabetic').val('108').trigger('change');
			  $('#malposition').val('108').trigger('change');
			  $('#membren').val('108').trigger('change');
			  $('#amentic').val('108').trigger('change');
			  $('#ekclapshia').val('108').trigger('change');
			  $('#bomitic').val('108').trigger('change');
			  $('#pretermlab').val('108').trigger('change');
            }
			else if (optionValue == 107){

              $('#highPressure').val('108').trigger('change');
			  $('#headeache').val('108').trigger('change');
			  $('#diabetic').val('108').trigger('change');
			  $('#malposition').val('108').trigger('change');
			  $('#membren').val('108').trigger('change');
			  $('#amentic').val('108').trigger('change');
			  $('#ekclapshia').val('108').trigger('change');
			  $('#bomitic').val('108').trigger('change');
			  $('#pretermlab').val('108').trigger('change');
            }
			else if (optionValue == 108){

              $('#highPressure').val('108').trigger('change');
			  $('#headeache').val('108').trigger('change');
			  $('#diabetic').val('108').trigger('change');
			  $('#malposition').val('108').trigger('change');
			  $('#membren').val('108').trigger('change');
			  $('#amentic').val('108').trigger('change');
			  $('#ekclapshia').val('108').trigger('change');
			  $('#bomitic').val('108').trigger('change');
			  $('#pretermlab').val('108').trigger('change');
            }
        });
    }).change();


      $("#checkupType").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");

            if(optionValue == 1)
            {
               $(".afterTotalTimes").prop('required',true);
               $(".manyTimes").show();

            } else{

               $(".afterTotalTimes").prop('required',false);
               $(".manyTimes").hide();
            }
        });
    }).change();



   $("#checkupTypeRoutine").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");

            if(optionValue == 1)
            {
               $(".afterTotalTimesRoutine").prop('required',true);
               $(".manyTimesRoutine").show();

            } else{

               $(".afterTotalTimesRoutine").prop('required',false);
               $(".manyTimesRoutine").hide();
            }
        });
    }).change();
   

   });

</script>

