<?php
$member_master_id = 0;
$member_code = '';
$member_name = '';

if (!empty($memberInfo)) {

    $member_master_id = $memberInfo[0]->id;
    $member_name = $memberInfo[0]->member_name;
    $member_code = $memberInfo[0]->member_code;
}
?>

<?php $baseID = $this->input->get('baseID', TRUE); ?>
<?php
$householdvisitID = 0;

if (!empty($householdVisit)) {

    $householdvisitID = $householdVisit[0]->id;
}
?>

<form action="<?php echo base_url() . 'Family_planning/editFPDetails?baseID=' . $baseID ?>" id="myForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8">
    <!-- SmartWizard html -->
    <div id="asset" style="padding-left: 20px; padding-right: 20px">
        <h4>Edit Family planning Details</h4>
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
                        <label for="maritial_status">12. উত্তরদাতার বৈবাহিক অবস্থা কি?<span style="color:red">*</span></label>
                        <input type="hidden" value="<?php echo $familyPlanningRecord->id; ?>" name="family_planning_id">
                        <select name="maritial_status" id="maritial_status" class="form-control" required>
                            <option value="">Please Select</option>
                            <?php
                            if (!empty($marital_status_typ)) {
                                foreach ($marital_status_typ as $marital_status_typ_single) {
                                    ?>
                                    <option <?php if ($familyPlanningRecord->maritial_status == $marital_status_typ_single->id) echo ' selected'; ?>  value="<?php echo $marital_status_typ_single->id ?>"><?php echo $marital_status_typ_single->code . '-' . $marital_status_typ_single->name ?></option>

                                    <?php
                                }
                            }
                            ?>
                        </select>

                    </div>
                </div>
            </div>
            <div class="">
                <div class="row">
                    <div class="col-md-4 martial_status_dependent_part">
                        <div class="form-group">
                            <label for="current_pregnancy_status">16. আপনি কি বর্তমানে গর্ভবতী?</label>

                            <select name="current_pregnancy_status" id="current_pregnancy_status" class="form-control">
                                <option value="">Please Select</option>
                                <?php
                                if (!empty($yes_no_dont_know)) {
                                    foreach ($yes_no_dont_know as $yes_no_dont_know_single) {
                                        ?>
                                        <option <?php if ($familyPlanningRecord->current_pregnancy_status == $yes_no_dont_know_single->id) echo ' selected'; ?> value="<?php echo $yes_no_dont_know_single->id ?>"><?php echo $yes_no_dont_know_single->code . '-' . $yes_no_dont_know_single->name ?></option>

                                        <?php
                                    }
                                }
                                ?>
                            </select>

                        </div>
                    </div>
                    <div class="col-md-4 martial_status_dependent_part current_pregnancy_status_non_yes_part">
                        <div class="form-group">
                            <label for="husband_living_place">17. আপনার স্বামী সচরাচর কোথায় বসবাস করেন?</label>

                            <select name="husband_living_place" id="husband_living_place" class="form-control">
                                <option value="">Please Select</option>
                                <?php
                                if (!empty($husband_staying_place)) {
                                    foreach ($husband_staying_place as $husband_staying_place_single) {
                                        ?>
                                        <option <?php if ($familyPlanningRecord->husband_living_place == $husband_staying_place_single->id) echo ' selected'; ?> value="<?php echo $husband_staying_place_single->id ?>"><?php echo $husband_staying_place_single->code . '-' . $husband_staying_place_single->name ?></option>

                                        <?php
                                    }
                                }
                                ?>
                            </select>

                        </div>
                    </div>
                    <div class="col-md-12 martial_status_dependent_part current_pregnancy_status_non_yes_part">
                        <div class="form-group">
                            <label for="birth_control_method_usage_status">18. আপনি বা আপনার স্বামী কি গর্ভধারণ বিলম্বিত বা গর্ভধারণ না করার জন্য বর্তমানে জন্ম নিয়ন্ত্রণের কোনো পদ্ধতি ব্যবহার করেন?  
                            </label>
                            <select name="birth_control_method_usage_status" id="birth_control_method_usage_status" class="form-control">
                                <option value="">Please Select</option>
                                <?php
                                if (!empty($yes_no)) {
                                    foreach ($yes_no as $yes_no_single) {
                                        ?>
                                        <option <?php if ($familyPlanningRecord->birth_control_method_usage_status == $yes_no_single->id) echo ' selected'; ?> value="<?php echo $yes_no_single->id ?>"><?php echo $yes_no_single->code . '-' . $yes_no_single->name ?></option>

                                        <?php
                                    }
                                }
                                ?>
                            </select>

                        </div>
                    </div>
                    <div class="col-md-12 martial_status_dependent_part current_pregnancy_status_non_yes_part birth_control_method_usage_status_yes_part">
                        <div class="form-group">
                            <label for="birth_control_method">19. কোন পদ্ধতি ব্যবহার করেন?   </label>

                            <select name="birth_control_method" id="birth_control_method" class="form-control">
                                <option value="">Please Select</option>
                                <?php
                                if (!empty($birth_control_method)) {
                                    foreach ($birth_control_method as $birth_control_method_single) {
                                        ?>
                                        <option <?php if ($familyPlanningRecord->birth_control_method == $birth_control_method_single->id) echo ' selected'; ?> value="<?php echo $birth_control_method_single->id ?>"><?php echo $birth_control_method_single->code . '-' . $birth_control_method_single->name ?></option>

                                        <?php
                                    }
                                }
                                ?>
                            </select>

                        </div>
                    </div>
                    <div style="display:none;" class="col-md-12 birth_control_method_other_part">
                        <div class="form-group">
                            <label for="birth_control_method_other_value">এখানে উল্লেখ করুন <span style="color:red">*</span></label>
                            <input value="<?php if (strlen($familyPlanningRecord->birth_control_method_other_value) > 0) echo $familyPlanningRecord->birth_control_method_other_value; ?>" name="birth_control_method_other_value" id="birth_control_method_other_value" class="form-control">

                        </div>
                    </div>
                    <div class="col-md-6 martial_status_dependent_part current_pregnancy_status_non_yes_part birth_control_method_usage_status_yes_part">
                        <div class="form-group">
                            <label for="how_long">20. একনাগারে কতদিন যাবৎ আপনারা বর্তমান পদ্ধতি ব্যবহার করছেন?</label>
                            <div class="row">
                                <div class="col-md-3">
                                    <input value="<?php if ($familyPlanningRecord->continuously_using_how_many_year > 0) echo $familyPlanningRecord->continuously_using_how_many_year; ?>" placeholder="বছর" name="continuously_using_how_many_year" id="continuously_using_how_many_year" class="form-control">

                                </div>
                                <div class="col-md-3">
                                    <input value="<?php if ($familyPlanningRecord->continuously_using_how_many_month > 0) echo $familyPlanningRecord->continuously_using_how_many_month; ?>" placeholder="মাস" name="continuously_using_how_many_month" id="continuously_using_how_many_month" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 martial_status_dependent_part current_pregnancy_status_non_yes_part birth_control_method_usage_status_yes_part">
                        <div class="form-group">
                            <label for="birth_control_method_suggestion_from_where">21. সর্বশেষবার কোথা থেকে আপনারা বর্তমান ব্যবহৃত পদ্ধতি সংগ্রহ করেছিলেন বা পরামর্শ পেয়েছিলেন? 
                            </label>

                            <select name="birth_control_method_suggestion_from_where" id="birth_control_method_suggestion_from_where" class="form-control">
                                <option value="">Please Select</option>
                                <?php
                                if (!empty($method_taken_from)) {
                                    foreach ($method_taken_from as $method_taken_from_single) {
                                        ?>
                                        <option <?php if ($familyPlanningRecord->birth_control_method_suggestion_from_where == $method_taken_from_single->id) echo ' selected'; ?> value="<?php echo $method_taken_from_single->id ?>"><?php echo $method_taken_from_single->code . '-' . $method_taken_from_single->name ?></option>

                                        <?php
                                    }
                                }
                                ?>
                            </select>

                        </div>
                    </div>
                    <div style="display:none;" class="col-md-12 birth_control_method_suggestion_from_where_other_part">
                        <div class="form-group">
                            <label for="birth_control_method_suggestion_from_where_other_value">এখানে উল্লেখ করুন <span style="color:red">*</span></label>
                            <input value="<?php if (strlen($familyPlanningRecord->birth_control_method_suggestion_from_where_other_value) > 0) echo $familyPlanningRecord->birth_control_method_suggestion_from_where_other_value; ?>" name="birth_control_method_suggestion_from_where_other_value" id="birth_control_method_suggestion_from_where_other_value" class="form-control">

                        </div>
                    </div>
                    <div class="col-md-12 martial_status_dependent_part current_pregnancy_status_non_yes_part birth_control_method_usage_status_yes_part">
                        <div class="form-group">
                            <label for="whose_decision">22. আপনারা যে জন্ম নিয়ন্ত্রন পদ্ধতি ব্যবহার করেন এই সিদ্ধান্ত: আপনার নাকি আপনার স্বামীর নাকি স্বামী স্ত্রীর দুজনের? </label>

                            <select name="whose_decision" id="whose_decision" class="form-control">
                                <option value="">Please Select</option>
                                <?php
                                if (!empty($birth_control_method_taking_decision)) {
                                    foreach ($birth_control_method_taking_decision as $birth_control_method_taking_decision_single) {
                                        ?>
                                        <option <?php if ($familyPlanningRecord->whose_decision == $birth_control_method_taking_decision_single->id) echo ' selected'; ?> value="<?php echo $birth_control_method_taking_decision_single->id ?>"><?php echo $birth_control_method_taking_decision_single->code . '-' . $birth_control_method_taking_decision_single->name ?></option>

                                        <?php
                                    }
                                }
                                ?>
                            </select>

                        </div>
                    </div>
                    <div style="display:none;" class="col-md-12 whose_decision_other_part">
                        <div class="form-group">
                            <label for="whose_decision_other_value">এখানে উল্লেখ করুন<span style="color:red">*</span></label>
                            <input value="<?php if (strlen($familyPlanningRecord->whose_decision_other_value) > 0) echo $familyPlanningRecord->whose_decision_other_value; ?>" name="whose_decision_other_value" id="whose_decision_other_value" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-12 martial_status_dependent_part current_pregnancy_status_non_yes_part whose_decision_part">
                        <div class="form-group">
                            <label for="reason_behind_not_using">23. আপনারা যে,বর্তমানে জন্ম নিয়ন্ত্রন পদ্ধতি ব্যবহার করছেন না তার প্রধান কারন কি?</label>

                            <select name="reason_behind_not_using" id="reason_behind_not_using" class="form-control">
                                <option value="">Please Select</option>
                                <?php
                                if (!empty($reason_behind_not_taking_birth_control_method)) {
                                    foreach ($reason_behind_not_taking_birth_control_method as $reason_behind_not_taking_birth_control_method_single) {
                                        ?>
                                        <option value="<?php echo $reason_behind_not_taking_birth_control_method_single->id ?>"><?php echo $reason_behind_not_taking_birth_control_method_single->code . '-' . $reason_behind_not_taking_birth_control_method_single->name ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>

                        </div>
                    </div>

                    <div style="display:none;" class="col-md-6 reason_behind_not_using_other_part">
                        <div class="form-group">
                            <label for="reason_behind_not_using_other_value">এখানে উল্লেখ করুন <span style="color:red">*</span></label>
                            <input value="<?php if (strlen($familyPlanningRecord->reason_behind_not_using_other_value) > 0) echo $familyPlanningRecord->reason_behind_not_using_other_value; ?>" name="reason_behind_not_using_other_value" id="reason_behind_not_using_other_value" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-6 martial_status_dependent_part whose_decision_part">
                        <div class="form-group">
                            <label for="future_desire">24. ভবিষ্যতে আপনাদের জন্মনিয়ন্ত্রন পদ্ধতি ব্যবহার করার ইচ্ছা আছে কি?</label>

                            <select name="future_desire" id="future_desire" class="form-control">
                                <option value="">Please Select</option>
                                <?php
                                if (!empty($yes_no_dont_know)) {
                                    foreach ($yes_no_dont_know as $yes_no_dont_know_single) {
                                        ?>
                                        <option <?php if ($familyPlanningRecord->future_desire == $yes_no_dont_know_single->id) echo ' selected'; ?> value="<?php echo $yes_no_dont_know_single->id ?>"><?php echo $yes_no_dont_know_single->code . '-' . $yes_no_dont_know_single->name ?></option>

                                        <?php
                                    }
                                }
                                ?>
                            </select>

                        </div>
                    </div>



                    <div class="col-md-6 martial_status_dependent_part reason_behind_not_having_future_desire_part">
                        <div class="form-group">
                            <label for="reason_behind_not_having_future_desire">25. ভবিষ্যতে আপনারা যে জন্মনিয়ন্ত্রন পদ্ধতি ব্যবহার করতে চান না তার প্রধান কারন কি?</label>
                            <select name="reason_behind_not_having_future_desire" id="reason_behind_not_having_future_desire" class="form-control">
                                <option value="">Please Select</option>
                                <?php
                                if (!empty($reason_behind_not_taking_birth_control_method)) {
                                    foreach ($reason_behind_not_taking_birth_control_method as $reason_behind_not_taking_birth_control_method_single) {
                                        ?>
                                        <option value="<?php echo $reason_behind_not_taking_birth_control_method_single->id ?>"><?php echo $reason_behind_not_taking_birth_control_method_single->code . '-' . $reason_behind_not_taking_birth_control_method_single->name ?></option>

                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div style="display:none;" class="col-md-6 reason_behind_not_having_future_desire_other_part">
                        <div class="form-group">
                            <label for="reason_behind_not_having_future_desire_other_value">এখানে উল্লেখ করুন <span style="color:red">*</span></label>
                            <input value="<?php if (strlen($familyPlanningRecord->reason_behind_not_having_future_desire_other_value) > 0) echo $familyPlanningRecord->reason_behind_not_having_future_desire_other_value; ?>" name="reason_behind_not_having_future_desire_other_value" id="reason_behind_not_having_future_desire_other_value" class="form-control">

                        </div>
                    </div>

                    <div class="col-md-6 martial_status_dependent_part whose_decision_part">
                        <div class="form-group">
                            <label for="do_you_know_from_where">26. পরিবার পরিকল্পনা পদ্ধতি কোথা থেকে পেতে পারেন,তা কি আপনি জানেন? </label>

                            <select name="do_you_know_from_where" id="do_you_know_from_where" class="form-control">
                                <option value="">Please Select</option>
                                <?php
                                if (!empty($yes_no)) {
                                    foreach ($yes_no as $yes_no_single) {
                                        ?>
                                        <option <?php if ($familyPlanningRecord->do_you_know_from_where == $yes_no_single->id) echo ' selected'; ?> value="<?php echo $yes_no_single->id ?>"><?php echo $yes_no_single->code . '-' . $yes_no_single->name ?></option>

                                        <?php
                                    }
                                }
                                ?>
                            </select>

                        </div>
                    </div>
                </div>
                <div class="row martial_status_dependent_part available_all_list whose_decision_part">
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border">27.কোথা থেকে নিতে পারেন? (একাধিক উত্তর হতে পারে)</legend>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email"></label>
                                <div class="checkbox">
                                    <label><input value="<?php if ($familyPlanningRecord->available_govt_hospital > 0) echo $familyPlanningRecord->available_govt_hospital;
                                else echo 1; ?>" name="available_govt_hospital" type="checkbox">সরকারি হাসপাতাল / মেডিকেল কলেজ হাসপাতাল</label>
                                </div>
                                <div class="checkbox">
                                    <label><input value="<?php if ($familyPlanningRecord->available_central_dist_hospital > 0) echo $familyPlanningRecord->available_central_dist_hospital;
                                else echo 2; ?>" name="available_central_dist_hospital" type="checkbox">জেলা সদর হাসপাতাল</label>
                                </div>
                                <div class="checkbox">
                                    <label><input value="<?php if ($familyPlanningRecord->available_matri_sonod > 0) echo $familyPlanningRecord->available_matri_sonod;
                                else echo 3; ?>" name="available_matri_sonod" type="checkbox">মাতৃসদন/মাতৃমঙ্গল/মেটারনিটি</label>
                                </div>
                                <div class="checkbox">
                                    <label><input value="<?php if ($familyPlanningRecord->available_ngo_facility > 0) echo $familyPlanningRecord->available_ngo_facility;
                                else echo 4; ?>" name="available_ngo_facility" type="checkbox">NGO facility supported by UPHCSDP</label>
                                </div>
                                <div class="checkbox">
                                    <label><input value="<?php if ($familyPlanningRecord->available_upazilla_sasthokendro > 0) echo $familyPlanningRecord->available_upazilla_sasthokendro;
                                else echo 5; ?>" name="available_upazilla_sasthokendro" type="checkbox">উপজেলা স্ব্যাস্থকেন্দ্র</label>
                                </div>
                                <div class="checkbox">
                                    <label><input value="<?php if ($familyPlanningRecord->available_union_sastho_poribar_kollan_kendro > 0) echo $familyPlanningRecord->available_union_sastho_poribar_kollan_kendro;
                                else echo 6; ?>" name="available_union_sastho_poribar_kollan_kendro" type="checkbox">ইউনিয়ন স্ব্যাস্থ ও পরিবারকল্যান কেন্দ্র</label>
                                </div>
                                <div class="checkbox">
                                    <label><input value="<?php if ($familyPlanningRecord->available_satellite_clinic > 0) echo $familyPlanningRecord->available_satellite_clinic;
                                else echo 7; ?>" name="available_satellite_clinic" type="checkbox">স্যাটেলাইটক্লিনিক/ইপিআই প্রোগ্রাম</label>
                                </div>
                                <div class="checkbox">
                                    <label><input value="<?php if ($familyPlanningRecord->available_community_clinic > 0) echo $familyPlanningRecord->available_community_clinic;
                                else echo 8; ?>" name="available_community_clinic" type="checkbox">কমিউনিটি ক্লিনিক</label>
                                </div>
                                <div class="checkbox">
                                    <label><input value="<?php if ($familyPlanningRecord->available_ngo_and_satellite_clinic > 0) echo $familyPlanningRecord->available_ngo_and_satellite_clinic;
                                else echo 9; ?>" name="available_ngo_and_satellite_clinic" type="checkbox">এনজিও স্যাটেলাইট ক্লিনিক</label>
                                </div>
                                <div class="checkbox">
                                    <label><input value="<?php if ($familyPlanningRecord->available_ngo_and_static_clinic > 0) echo $familyPlanningRecord->available_ngo_and_static_clinic;
                                else echo 10; ?>" name="available_ngo_and_static_clinic" type="checkbox">এনজিও স্ট্যাটিক ক্লিনিক</label>
                                </div>
                                <div class="checkbox">
                                    <label><input value="<?php if ($familyPlanningRecord->available_private_hospital > 0) echo $familyPlanningRecord->available_private_hospital;
                                else echo 11; ?>" name="available_private_hospital" type="checkbox">প্রাইভেট হাসপাতাল/ক্লিনিক</label>
                                </div>
                                <div class="checkbox">
                                    <label><input value="<?php if ($familyPlanningRecord->available_mbbs_doctor_chamber > 0) echo $familyPlanningRecord->available_mbbs_doctor_chamber;
                                else echo 12; ?>" name="available_mbbs_doctor_chamber" type="checkbox">এমবিবিএস ডাক্তার চেম্বার</label>
                                </div>
                                <div class="checkbox">
                                    <label><input value="<?php if ($familyPlanningRecord->available_doctor_without_degrees > 0) echo $familyPlanningRecord->available_doctor_without_degrees;
                                else echo 13; ?>" name="available_doctor_without_degrees" type="checkbox">ডিগ্রীধারি ডাক্তারের চেম্বারেনা</label>
                                </div>
                                <div class="checkbox">
                                    <label><input value="<?php if ($familyPlanningRecord->available_pharmacy > 0) echo $familyPlanningRecord->available_pharmacy;
                                else echo 14; ?>" name="available_pharmacy" type="checkbox">ফার্মেসী</label>
                                </div>
                                <div class="checkbox">
                                    <label><input value="<?php if ($familyPlanningRecord->available_other > 0) echo $familyPlanningRecord->available_other;
                                else echo 15; ?>" name="available_other" id="available_other" type="checkbox">অন্যান্য (উল্লেখ করুন)</label>
                                </div>
                            </div>
                        </div>
                        <div style="display:none;" class="col-md-6 available_other_part">
                            <div class="form-group">
                                <label for="available_other_value">এখানে উল্লেখ করুন <span style="color:red">*</span></label>
                                <input value="<?php if (strlen($familyPlanningRecord->available_other_value) > 0) echo $familyPlanningRecord->available_other_value; ?>" name="available_other_value" id="available_other_value" class="form-control">

                            </div>
                        </div>
                    </fieldset>
                </div>

                <div class="row">
                    <div class="col-md-6 martial_status_dependent_part">
                        <div class="form-group">
                            <label for="taking_desire_more_children">28. আপনার (আরও) ছেলেমেয়ে নেয়ার ইচ্ছা আছে কি?</label>

                            <select name="taking_desire_more_children" id="taking_desire_more_children" class="form-control">
                                <option value="">Please Select</option>
<?php
if (!empty($yes_no_pregnant_dont_know)) {
    foreach ($yes_no_pregnant_dont_know as $yes_no_pregnant_dont_know_single) {
        ?>
                                        <option <?php if ($familyPlanningRecord->taking_desire_more_children == $yes_no_pregnant_dont_know_single->id) echo ' selected'; ?> value="<?php echo $yes_no_pregnant_dont_know_single->id ?>"><?php echo $yes_no_pregnant_dont_know_single->code . '-' . $yes_no_pregnant_dont_know_single->name ?></option>

        <?php
    }
}
?>
                            </select>

                        </div>
                    </div>

                    <div class="col-md-6 martial_status_dependent_part taking_desire_more_children_after_year_part">
                        <div class="form-group">
                            <label for="taking_desire_more_children_after_year">29. যদি হ্যাঁ হয় কত বছর পর? (যদি বাচ্চা না চায় তাহলে বক্সে “0” লিখুন)<span style="color:red;">*</span></label>
                            <input value="<?php if ($familyPlanningRecord->taking_desire_more_children_after_year > 0) echo $familyPlanningRecord->taking_desire_more_children_after_year; ?>" placeholder="বছর" type="text" name="taking_desire_more_children_after_year" id="taking_desire_more_children_after_year" class="form-control">

                        </div>
                    </div>

                    <div class="col-md-12 martial_status_dependent_part">
                        <div class="form-group">
                            <label for="how_many_children_you_want"> 30. আপনি যতজন সন্তান চান আপনার স্বামী কি ততজনই সন্তান চান না কি তার চেয়ে বেশি চান নাকি তার চেয়ে কম চান?</label>

                            <select name="how_many_children_you_want" id="how_many_children_you_want" class="form-control">
                                <option value="">Please Select</option>
<?php
if (!empty($how_many_children)) {
    foreach ($how_many_children as $how_many_children_single) {
        ?>
                                        <option <?php if ($familyPlanningRecord->how_many_children_you_want == $how_many_children_single->id) echo ' selected'; ?> value="<?php echo $how_many_children_single->id ?>"><?php echo $how_many_children_single->code . '-' . $how_many_children_single->name ?></option>

                                        <?php
                                    }
                                }
                                ?>
                            </select>

                        </div>
                    </div>



                    <div class="col-md-6 martial_status_dependent_part">
                        <div class="form-group">
                            <label for="alive_children">31. আপনার কতজন জীবিত ছেলেমেয়ে আছে?</label>
                            <select name="alive_children" id="alive_children" class="form-control">
                                <option value="">Please Select</option>
<?php
if (!empty($alive_children)) {
    foreach ($alive_children as $alive_children_single) {
        ?>
                                        <option <?php if ($familyPlanningRecord->alive_children == $alive_children_single->id) echo ' selected'; ?> value="<?php echo $alive_children_single->id ?>"><?php echo $alive_children_single->code . '-' . $alive_children_single->name ?></option>

        <?php
    }
}
?>
                            </select>
                        </div>
                    </div>
                    <div style="display:none;" class="col-md-6 alive_boy_number_part">
                        <div class="form-group">
                            <label for="alive_boy_number">ছেলে সংখ্যা <span style="color:red;">*</span></label>
                            <input value="<?php if ($familyPlanningRecord->alive_boy_number > 0) echo $familyPlanningRecord->alive_boy_number; ?>" name="alive_boy_number" id="alive_boy_number" class="form-control">

                        </div>
                    </div>
                    <div style="display:none;" class="col-md-6 alive_girl_number_part">
                        <div class="form-group">
                            <label for="alive_girl_number">মেয়ে সংখ্যা <span style="color:red;">*</span></label>
                            <input value="<?php if ($familyPlanningRecord->alive_girl_number > 0) echo $familyPlanningRecord->alive_girl_number; ?>" name="alive_girl_number" id="alive_girl_number" class="form-control">

                        </div>
                    </div>

                    <div class="col-md-12 martial_status_dependent_part alive_children_yes_availability_part">
                        <div class="form-group">
                            <label for="alive_children_yes_availability">32. জীবিত ছেলে-মেয়ে আছে? আপনি যদি আপনার পূর্বের জীবনে ফিরে যেতে পারতেন,যখন আপনার কোন ছেলে-মেয়ে ছিল না এবং আপনি যদি সঠিক সংখ্যা নির্ধারণ করতে পারতেন তাহলে সারা জীবনে কতজন ছেলে-মেয়ে নিতেন?</label>

                            <select name="alive_children_yes_availability" id="alive_children_yes_availability" class="form-control">
                                <option value="">Please Select</option>
<?php
if (!empty($no_one_how_many_others)) {
    foreach ($no_one_how_many_others as $no_one_how_many_others_single) {
        ?>
                                        <option <?php if ($familyPlanningRecord->alive_children_yes_availability == $no_one_how_many_others_single->id) echo ' selected'; ?> value="<?php echo $no_one_how_many_others_single->id ?>"><?php echo $no_one_how_many_others_single->code . '-' . $no_one_how_many_others_single->name ?></option>

        <?php
    }
}
?>
                            </select>

                        </div>
                    </div>

                    <div style="display:none;" class="col-md-12 alive_children_yes_availability_other_part">
                        <div class="form-group">
                            <label for="alive_children_yes_availability_other_value">এখানে উল্লেখ করুন <span style="color:red">*</span></label>
                            <input value="<?php if (strlen($familyPlanningRecord->alive_children_yes_availability_other_value) > 0) echo $familyPlanningRecord->alive_children_yes_availability_other_value; ?>" placeholder="অন্যান্য" name="alive_children_yes_availability_other_value" id="alive_children_yes_availability_other_value" class="form-control">
                        </div>
                    </div>
                    <div style="display:none;" class="col-md-12 alive_children_yes_availability_how_many_part">
                        <div class="form-group">
                            <label for="alive_children_yes_availability_how_many">এখানে উল্লেখ করুন <span style="color:red">*</span></label>
                            <input value="<?php if ($familyPlanningRecord->alive_children_yes_availability_how_many > 0) echo $familyPlanningRecord->alive_children_yes_availability_how_many; ?>" placeholder="কতজন" name="alive_children_yes_availability_how_many" id="alive_children_yes_availability_how_many" class="form-control">

                        </div>
                    </div>

                    <div class="col-md-12 martial_status_dependent_part alive_children_no_availability_related_part alive_children_yes_availability_parts">
                        <div class="form-group">
                            <label for="alive_children_no_availability">33. জীবিত ছেলে-মেয়ে নাই? আপনি যদি সঠিক সংখ্যা নির্ধারণ করতে পারতেন তাহলে সারাজীবনে কতজন ছেলে-মেয়ে নিতেন?</label>
                            <select name="alive_children_no_availability" id="alive_children_no_availability" class="form-control">
                                <option value="">Please Select</option>
<?php
if (!empty($no_one_how_many_others)) {
    foreach ($no_one_how_many_others as $no_one_how_many_others_single) {
        ?>
                                        <option <?php if ($familyPlanningRecord->alive_children_no_availability == $no_one_how_many_others_single->id) echo ' selected'; ?> value="<?php echo $no_one_how_many_others_single->id ?>"><?php echo $no_one_how_many_others_single->code . '-' . $no_one_how_many_others_single->name ?></option>

        <?php
    }
}
?>
                            </select>
                        </div>
                    </div>

                    <div style="display:none;" class="col-md-12 alive_children_no_availability_other_part">
                        <div class="form-group">
                            <label for="alive_children_no_availability_other_value">এখানে উল্লেখ করুন <span style="color:red">*</span></label>
                            <input value="<?php if (strlen($familyPlanningRecord->alive_children_no_availability_other_value) > 0) echo $familyPlanningRecord->alive_children_no_availability_other_value; ?>" placeholder="অন্যান্য" name="alive_children_no_availability_other_value" id="alive_children_no_availability_other_value" class="form-control">

                        </div>
                    </div>

                    <div style="display:none;" class="col-md-12 alive_children_no_availability_how_many_part">
                        <div class="form-group">
                            <label for="alive_children_no_availability_how_many">এখানে উল্লেখ করুন <span style="color:red">*</span></label>
                            <input value="<?php if ($familyPlanningRecord->alive_children_no_availability_how_many > 0) echo $familyPlanningRecord->alive_children_no_availability_how_many; ?>" placeholder="কতজন" name="alive_children_no_availability_how_many" id="alive_children_no_availability_how_many" class="form-control">

                        </div>
                    </div>

                    <div class="col-md-12 martial_status_dependent_part alive_children_no_availability_non_related_part alive_children_no_availability_parts alive_children_yes_availability_parts">
                        <div class="form-group">
                            <label for="how_many_male_female_children">34. এদের মধ্যে কতজন ছেলে কতজন মেয়ে নিতেন,নাকি ছেলে-মেয়ে কোন ব্যাপার না</label>
                            <select name="how_many_male_female_children" id="how_many_male_female_children" class="form-control">
                                <option value="">Please Select</option>
<?php
if (!empty($boy_girl_anyone)) {
    foreach ($boy_girl_anyone as $boy_girl_anyone_single) {
        ?>
                                        <option <?php if ($familyPlanningRecord->how_many_male_female_children == $boy_girl_anyone_single->id) echo ' selected'; ?> value="<?php echo $boy_girl_anyone_single->id ?>"><?php echo $boy_girl_anyone_single->code . '-' . $boy_girl_anyone_single->name ?></option>

        <?php
    }
}
?>
                            </select>

                        </div>
                    </div>
                    <div style="display:none;" class="col-md-4 how_many_male_part">
                        <div class="form-group">
                            <label for="how_many_male">ছেলে সংখ্যা <span style="color:red;">*</span></label>
                            <input value="<?php if ($familyPlanningRecord->how_many_male > 0) echo $familyPlanningRecord->how_many_male; ?>" name="how_many_male" id="how_many_male" class="form-control">

                        </div>
                    </div>
                    <div style="display:none;" class="col-md-4 how_many_female_part">
                        <div class="form-group">
                            <label for="how_many_female">মেয়ে সংখ্যা <span style="color:red;">*</span></label>
                            <input value="<?php if ($familyPlanningRecord->how_many_female > 0) echo $familyPlanningRecord->how_many_female; ?>" name="how_many_female" id="how_many_female" class="form-control">

                        </div>
                    </div>
                    <div style="display:none;" class="col-md-4 how_many_any_part">
                        <div class="form-group">
                            <label for="how_many_any">যে কোন <span style="color:red;">*</span></label>
                            <input value="<?php if ($familyPlanningRecord->how_many_any > 0) echo $familyPlanningRecord->how_many_any; ?>" name="how_many_any" id="how_many_any" class="form-control">

                        </div>
                    </div>
                    <div style="display:none;" class="col-md-4 how_many_male_female_children_other_part">
                        <div class="form-group">
                            <label for="how_many_male_female_children_other_value">এখানে উল্লেখ করুন <span style="color:red">*</span></label>
                            <input value="<?php if (strlen($familyPlanningRecord->how_many_male_female_children_other_value) > 0) echo $familyPlanningRecord->how_many_male_female_children_other_value; ?>" name="how_many_male_female_children_other_value" id="how_many_male_female_children_other_value" class="form-control">

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="comment">বিশেষ দ্রষ্টব্য</label>
                        <textarea name="comment" id="comment" class="form-control"><?php echo $familyPlanningRecord->comment; ?></textarea>
                    </div>
                </div>
            </div>

        </div>

    </div>



    <div class="box-footer" style="margin-left: 10px">
        <input type="hidden" name="household_master_id_sub" value="<?php echo $household_master_id_sub ?>">
        <input type="hidden" name="round_master_id" value="<?php echo $round_master_id ?>">
        <input type="hidden" name="member_master_id" value="<?php echo $familyPlanningRecord->member_master_id; ?>">
        <input type="submit" class="btn btn-primary btnVisile" name="submit" value="Update" />
        <a class="btn btn-primary" href="<?php echo base_url() . 'Family_planning/family_planning_info?baseID=' . $baseID . '#family_planning_info' ?>" class="">Back </a>

    </div>



</form>




</div><!-- /.box-body -->
</div><!-- /.box -->
</div>
</div>
</section>
</div>


<script>
    $("#birth_control_method").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");
            if (optionValue == 455) {
                $("#birth_control_method_other_value").prop('required', true);
                $(".birth_control_method_other_part").show();
            } else {
                $("#birth_control_method_other_value").prop('required', false);
                $(".birth_control_method_other_part").hide();
            }
        });
    }).change();

    $("#birth_control_method_suggestion_from_where").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");
            if (optionValue == 470) {
                $("#birth_control_method_suggestion_from_where_other_value").prop('required', true);
                $(".birth_control_method_suggestion_from_where_other_part").show();
            } else {
                $("#birth_control_method_suggestion_from_where_other_value").prop('required', false);
                $(".birth_control_method_suggestion_from_where_other_part").hide();
            }
        });
    }).change();



    $("#available_other").change(function () {
        if ($('#available_other').is(":checked"))
        {

            $("#available_other_value").prop('required', true);
            $(".available_other_part").show();

        } else {
            $("#available_other_value").prop('required', false);
            $(".available_other_part").hide();
        }
    }).change();



    $("#alive_children").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");
            if (optionValue == 504) {

                $("#alive_girl_number").prop('required', false);
                $(".alive_girl_number_part").hide();
                $("#alive_boy_number").prop('required', false);
                $(".alive_boy_number_part").hide();
                $(".alive_children_yes_availability_part").hide();
                $(".alive_children_yes_availability_other_part").hide();


            } else if (optionValue == 502) {
                $("#alive_boy_number").prop('required', true);
                $(".alive_boy_number_part").show();
                $("#alive_girl_number").prop('required', false);
                $(".alive_girl_number_part").hide();
                $(".alive_children_yes_availability_part").show();
            } else if (optionValue == 503) {
                $("#alive_girl_number").prop('required', true);
                $(".alive_girl_number_part").show();
                $("#alive_boy_number").prop('required', false);
                $(".alive_boy_number_part").hide();
                $(".alive_children_yes_availability_part").show();
            } else if (optionValue == 512) {
                $("#alive_girl_number").prop('required', true);
                $(".alive_girl_number_part").show();
                $("#alive_boy_number").prop('required', true);
                $(".alive_boy_number_part").show();

                $(".alive_children_yes_availability_part").show();
            } else {
                $("#alive_girl_number").prop('required', false);
                $(".alive_girl_number_part").hide();
                $("#alive_boy_number").prop('required', false);
                $(".alive_boy_number_part").hide();
                $(".alive_children_yes_availability_part").show();
            }
        });
    }).change();



    $("#alive_children_yes_availability").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");
			
			//alert(optionValue);
            if (optionValue == 505 || optionValue == 507) {
                $(".alive_children_yes_availability_parts").hide();
                $(".alive_children_yes_availability_how_many_part").hide();

                $(".alive_children_no_availability_other_part").hide();
                $(".how_many_male_female_children_other_part").hide();

                if (optionValue == 507) {
                    $("#alive_children_yes_availability_other_value").prop('required', false);
                    $(".alive_children_yes_availability_other_part").show();
                } else {
                    $("#alive_children_yes_availability_other_value").prop('required', false);
                    $(".alive_children_yes_availability_other_part").hide();
                }
            } else if (optionValue == 506) {

                $(".alive_children_no_availability_related_part").hide();
                $(".alive_children_no_availability_non_related_part").show();
                $(".alive_children_yes_availability_how_many_part").show();
                $(".alive_children_yes_availability_other_part").hide();
                $(".alive_children_no_availability_other_part").hide();
            } else {
                $(".alive_children_yes_availability_parts").show();
                $("#alive_children_yes_availability_other_value").prop('required', false);
                $(".alive_children_yes_availability_other_part").hide();
                $(".alive_children_yes_availability_how_many_part").hide();

            }
        });
    }).change();



    $("#alive_children_no_availability").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");

            if (optionValue == 505 || optionValue == 507) {
                $(".alive_children_no_availability_parts").hide();
                $(".alive_children_no_availability_how_many_part").hide();
                $("#how_many_male_female_children").val('').trigger('change');
                $(".how_many_male_female_children_other_part").hide();


                if (optionValue == 507) {
                    $("#alive_children_no_availability_other_value").prop('required', true);
                    $(".alive_children_no_availability_other_part").show();
                } else {
                    $("#alive_children_no_availability_other_value").prop('required', false);
                    $(".alive_children_no_availability_other_part").hide();
                }
            } else if (optionValue == 506) {
                $(".alive_children_no_availability_parts").show();
                $(".alive_children_no_availability_how_many_part").show();
                $(".alive_children_no_availability_other_part").hide();
            } else {
                $(".alive_children_no_availability_parts").show();
                $("#alive_children_no_availability_other_value").prop('required', false);
                $(".alive_children_no_availability_other_part").hide();
                $(".alive_children_no_availability_how_many_part").hide();
                $("#how_many_male_female_children").val('').trigger('change');
                $(".how_many_male_female_children_other_part").hide();
            }
        });
    }).change();

    $("#reason_behind_not_having_future_desire").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");
            if (optionValue == 491) {
                $("#reason_behind_not_having_future_desire_other_value").prop('required', true);
                $(".reason_behind_not_having_future_desire_other_part").show();
            } else {
                $("#reason_behind_not_having_future_desire_other_value").prop('required', false);
                $(".reason_behind_not_having_future_desire_other_part").hide();
            }
        });
    }).change();

    $("#reason_behind_not_using").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");
            if (optionValue == 491) {
                $("#reason_behind_not_using_other_value").prop('required', true);
                $(".reason_behind_not_using_other_part").show();
            } else {
                $("#reason_behind_not_using_other_value").prop('required', false);
                $(".reason_behind_not_using_other_part").hide();
            }
        });
    }).change();



    $("#how_many_male_female_children").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");
            $("#how_many_male_female_children_other_value").prop('required', false);
            $(".how_many_male_female_children_other_part").hide();
            $("#how_many_male").prop('required', false);
            $(".how_many_male_part").hide();
            $("#how_many_female").prop('required', false);
            $(".how_many_female_part").hide();
            $("#how_many_any").prop('required', false);
            $(".how_many_any_part").hide();
            if (optionValue == 511) {
                $("#how_many_male_female_children_other_value").prop('required', true);
                $(".how_many_male_female_children_other_part").show();
            } else if (optionValue == 508) {
                $("#how_many_male").prop('required', true);
                $(".how_many_male_part").show();
            } else if (optionValue == 509) {
                $("#how_many_female").prop('required', true);
                $(".how_many_female_part").show();
            } else if (optionValue == 510) {
                $("#how_many_any").prop('required', true);
                $(".how_many_any_part").show();
            } else if (optionValue == 513) {
                $("#how_many_male").prop('required', true);
                $(".how_many_male_part").show();
                $("#how_many_female").prop('required', true);
                $(".how_many_female_part").show();
            }
        });
    }).change();



    $("#taking_desire_more_children").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");
            if (optionValue == 497 || optionValue == "") {
                $("#taking_desire_more_children_after_year").prop('required', false);
                $(".taking_desire_more_children_after_year_part").hide();
            } else {
                $("#taking_desire_more_children_after_year").prop('required', true);
                $(".taking_desire_more_children_after_year_part").show();
            }
        });
    }).change();











    $("#current_pregnancy_status").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");
            if (optionValue == 331) {
                $(".current_pregnancy_status_non_yes_part").hide();

                $(".birth_control_method_other_part").hide();
                $(".birth_control_method_suggestion_from_where_other_part").hide();
                $(".whose_decision_other_part").hide();
                $(".reason_behind_not_using_other_part").hide();


            } else {

                $(".current_pregnancy_status_non_yes_part").show();

                $('#birth_control_method_usage_status').val('<?php echo $familyPlanningRecord->birth_control_method_usage_status; ?>').trigger('change');

                $('#birth_control_method').val('<?php echo $familyPlanningRecord->birth_control_method; ?>').trigger('change');
                $('#birth_control_method_suggestion_from_where').val('<?php echo $familyPlanningRecord->birth_control_method_suggestion_from_where; ?>').trigger('change');
                $('#whose_decision').val('<?php echo $familyPlanningRecord->whose_decision; ?>').trigger('change');
                $('#reason_behind_not_using').val('<?php echo $familyPlanningRecord->reason_behind_not_using; ?>').trigger('change');

            }
        });
    }).change();



    $("#birth_control_method_usage_status").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");

            if (optionValue == 4) {
//                alert("NOOOOOOOOOO");
                $(".birth_control_method_usage_status_yes_part").hide();
                $(".birth_control_method_other_part").hide();
                $(".birth_control_method_suggestion_from_where_other_part").hide();
                $(".whose_decision_other_part").hide();
                $('#whose_decision').val('').trigger('change');



            } else {
//                   alert("TESTTTT"); 
                $(".birth_control_method_usage_status_yes_part").show();
            }
        });
    }).change();



    $("#future_desire").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");

            if (optionValue == 331) {
                $("#reason_behind_not_having_future_desire").prop('required', false);
                $(".reason_behind_not_having_future_desire_part").hide();
                $(".reason_behind_not_having_future_desire_other_part").hide();
            } else {

                $(".reason_behind_not_having_future_desire_part").show();
            }
        });
    }).change();

    $("#do_you_know_from_where").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");

            if (optionValue == 4) {
                $(".available_other_part").hide();
                $(".available_all_list").hide();
                $(".available_all_list :input").prop("checked", false);
            } else {

                $(".available_all_list").show();
            }
        });
    }).change();

    $("#whose_decision").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");

            if (optionValue == 474) {
                $("#whose_decision_other_value").prop('required', true);
                $(".whose_decision_other_part").show();
            } else {
                $("#whose_decision_other_value").prop('required', false);
                $(".whose_decision_other_part").hide();
            }

            if (optionValue > 0) {
                $(".whose_decision_part").hide();
                $(".reason_behind_not_using_other_part").hide();
                $(".reason_behind_not_having_future_desire_other_part").hide();
                $(".available_other_part").hide();

                $(".available_all_list :input").prop("checked", false);

            } else {
                $(".whose_decision_part").show();
//                $('#future_desire').val('').trigger('change');
            }
        });
    }).change();

    $("#maritial_status").change(function () { //end of interview
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");
            if (optionValue == 44 || optionValue == 109 || optionValue == 40) {
                $(".martial_status_dependent_part").hide();
                $("#martial_status_dependent_part :input").prop("disabled", true);
            } else {
                $(".martial_status_dependent_part").show();
                $("#martial_status_dependent_part :input").prop("disabled", false);

                $("#current_pregnancy_status").val('<?php echo $familyPlanningRecord->current_pregnancy_status; ?>').trigger('change');
                $("#birth_control_method_usage_status").val('<?php echo $familyPlanningRecord->birth_control_method_usage_status; ?>').trigger('change');
                $("#whose_decision").val('<?php echo $familyPlanningRecord->whose_decision; ?>').trigger('change');
                $("#future_desire").val('<?php echo $familyPlanningRecord->future_desire; ?>').trigger('change');
                $("#do_you_know_from_where").val('<?php echo $familyPlanningRecord->do_you_know_from_where; ?>').trigger('change');
                $("#alive_children").val('<?php echo $familyPlanningRecord->alive_children; ?>').trigger('change');
                $("#alive_children_yes_availability").val('<?php echo $familyPlanningRecord->alive_children_yes_availability; ?>').trigger('change');
                $("#alive_children_no_availability").val('<?php echo $familyPlanningRecord->alive_children_no_availability; ?>').trigger('change');

            }
        });
    }).change();

</script>
