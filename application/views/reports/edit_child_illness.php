<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
            <div class="col-xs-6 text-left header-margin ">
                <h3>
                    <?php echo $pageTitle; ?>
                    <small>(Edit)</small>
                    <?php $baseID = $this->input->get('baseID', TRUE); ?>
                </h3>

            </div>
            <div class="col-xs-6 text-right">
                <div class="form-group margin5pxBot">
                    <a class="btn btn-primary" href="<?php echo base_url() . $controller . '/child_illness?baseID=' . $baseID ?>"><?php echo $shortName ?> List</a>
                </div>
            </div>
        </div>
    </section>

    <section class="content content-margin">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">

                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title"><?php echo $shortName ?> Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if ($error) {
                        ?>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <?php echo $this->session->flashdata('error'); ?>                    
                        </div>
                    <?php } ?>
                    <?php
                    $success = $this->session->flashdata('success');
                    if ($success) {
                        ?>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <?php echo $this->session->flashdata('success'); ?>
                        </div>
                    <?php } ?>

                    <div class="row">
                        <div class="col-md-12">
                            <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                        </div>
                    </div>
                    <form role="form" action="<?php echo base_url() . $controller . '/' . $actionMethod . '?baseID=' . $baseID ?>" method="post" id="editUser" role="form">
                        <input type="hidden" name="child_illness_id" value="<?php echo $ChildIllnessRecord->id; ?>">
                        <input type="hidden" name="member_master_id" value="<?php echo $ChildIllnessRecord->member_master_id ?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <b>Household Code:</b> <?php echo $ChildIllnessRecord->household_code; ?>
                                </div>
                                <div class="col-md-3 form-group">
                                    <b>Round No:</b> <?php echo $ChildIllnessRecord->round_master_id; ?>
                                </div>
                                <div class="col-md-3 form-group">
                                    <b>Member Code:</b> <?php echo $ChildIllnessRecord->member_code; ?>
                                </div>
                                <div class="col-md-3 form-group">
                                    <b>Member Name:</b> <?php echo $ChildIllnessRecord->member_name; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <b>Gender:</b> <?php echo $ChildIllnessRecord->gender_code . '-' . $ChildIllnessRecord->gender_name; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="breastfeeding_ever">12. বাচ্চাটিকে কখনো বুকের দুধ খাওয়ানো হয়েছে কি?<span style="color:red">*</span></label>
                                        <input type="hidden" name="childIllnessID" value="<?php echo $ChildIllnessRecord->id; ?>">
                                        <select class="form-control" id="breastfeeding_ever" name="breastfeeding_ever" required>
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($yes_no)) {
                                                foreach ($yes_no as $yes_no_single) {
                                                    ?>
                                                    <option <?php
                                                    if ($ChildIllnessRecord->breastfeeding_ever == $yes_no_single->id) {
                                                        echo " selected";
                                                    }
                                                    ?> value="<?php echo $yes_no_single->id ?>"><?php echo $yes_no_single->code . '-' . $yes_no_single->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 breastfeeding_after_how_many_time_after_birth_part">
                                    <div class="form-group">
                                        <label for="breastfeeding_after_how_many_time_after_birth">13. বাচ্চাটি জন্মের কতক্ষণ পর বুকের দুধ দেওয়া হয়েছিল?
                                            (যদি এক ঘন্টার কম হয় তাহলে ঘন্টার ঘরে “০০” লিখুন, যদি ২৪ ঘন্টার কম হয় তাহলে ঘন্টায় লিখুন এবং ২৪ ঘন্টার বেশি হলে দিনে লিখুন)<span style="color:red">*</span></label>
                                        <select class="form-control" id="breastfeeding_after_how_many_time_after_birth" name="breastfeeding_after_how_many_time_after_birth">
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($instantly_hour_day)) {
                                                foreach ($instantly_hour_day as $instantly_hour_day_single) {
                                                    ?>
                                                    <option <?php
                                                    if ($ChildIllnessRecord->breastfeeding_after_how_many_time_after_birth == $instantly_hour_day_single->id) {
                                                        echo " selected";
                                                    }
                                                    ?> value="<?php echo $instantly_hour_day_single->id ?>"><?php echo $instantly_hour_day_single->code . '-' . $instantly_hour_day_single->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 breastfeeding_after_how_many_hour_after_birth_part">
                                    <div class="form-group">
                                        <label for="breastfeeding_after_how_many_hour_after_birth">এখানে উল্লেখ করুন <span style="color:red">*</span></label>
                                        <input value="<?php if ($ChildIllnessRecord->breastfeeding_after_how_many_hour_after_birth > 0) echo $ChildIllnessRecord->breastfeeding_after_how_many_hour_after_birth; ?>" placeholder="ঘন্টা" name="breastfeeding_after_how_many_hour_after_birth" id="breastfeeding_after_how_many_hour_after_birth" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12 breastfeeding_after_how_many_day_after_birth_part">
                                    <div class="form-group">
                                        <label for="breastfeeding_after_how_many_day_after_birth">এখানে উল্লেখ করুন <span style="color:red">*</span></label>
                                        <input value="<?php if ($ChildIllnessRecord->breastfeeding_after_how_many_day_after_birth > 0) echo $ChildIllnessRecord->breastfeeding_after_how_many_day_after_birth; ?>" placeholder="দিন" name="breastfeeding_after_how_many_day_after_birth" id="breastfeeding_after_how_many_day_after_birth" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="other_drink_except_breastfeeding">14. জন্মের পর প্রথম তিন দিনের মধ্যে (নামকে) বুকের দুধ ছাড়া অন্য কোন কিছু পান করতে দেওয়া হয়েছিল কি? 
                                            <span style="color:red">*</span></label>
                                        <select class="form-control" id="other_drink_except_breastfeeding" name="other_drink_except_breastfeeding" required>
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($yes_no)) {
                                                foreach ($yes_no as $yes_no_single) {
                                                    ?>
                                                    <option <?php
                                                    if ($ChildIllnessRecord->other_drink_except_breastfeeding == $yes_no_single->id) {
                                                        echo " selected";
                                                    }
                                                    ?> value="<?php echo $yes_no_single->id ?>"><?php echo $yes_no_single->code . '-' . $yes_no_single->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row all_drink_part">
                                <fieldset class="scheduler-border">
                                    <legend class="scheduler-border">15. (নামকে) কি কি পান করতে দেওয়া হয়েছিল ?

                                        (প্রত্যেকটি পড়ে শোনাান)

                                        (উল্লেখিত সকল তরল জাতীয় খাবার রেকর্ড করুন)</legend>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="checkbox">
                                                <label><input <?php if ($ChildIllnessRecord->drink_anything_else_except_breastfeeding > 0) echo ' checked'; ?> name="drink_anything_else_except_breastfeeding" type="checkbox" value="1">বুকের দুধ ছাড়া অন্য দুধ</label>
                                            </div>
                                            <div class="checkbox">
                                                <label><input <?php if ($ChildIllnessRecord->drink_just_water > 0) echo ' checked'; ?> name="drink_just_water" type="checkbox" value="2">শুধু পানি</label>
                                            </div>
                                            <div class="checkbox">
                                                <label><input <?php if ($ChildIllnessRecord->drink_sugar_or_glucose_water > 0) echo ' checked'; ?> name="drink_sugar_or_glucose_water" type="checkbox" value="3">চিনি বা গ্লুকোজ পানি</label>
                                            </div>
                                            <div class="checkbox">
                                                <label><input <?php if ($ChildIllnessRecord->drink_honey > 0) echo ' checked'; ?> name="drink_honey" type="checkbox" value="4">মধু</label>
                                            </div>
                                            <div class="checkbox">
                                                <label><input <?php if ($ChildIllnessRecord->drink_pipe_water > 0) echo ' checked'; ?> name="drink_pipe_water" type="checkbox" value="5">পাইপ ওয়াটার</label>
                                            </div>
                                            <div class="checkbox">
                                                <label><input <?php if ($ChildIllnessRecord->drink_sugar_or_salt_mixed_water > 0) echo ' checked'; ?> name="drink_sugar_or_salt_mixed_water" type="checkbox" value="6">চিনি অথবা লবণ মিশ্রিত পানি</label>
                                            </div>
                                            <div class="checkbox">
                                                <label><input <?php if ($ChildIllnessRecord->drink_fruit_juice > 0) echo ' checked'; ?> name="drink_fruit_juice" type="checkbox" value="7">ফলের রস</label>
                                            </div>
                                            <div class="checkbox">
                                                <label><input <?php if ($ChildIllnessRecord->drink_baby_food > 0) echo ' checked'; ?> name="drink_baby_food" type="checkbox" value="8">শিশু খাদ্য</label>
                                            </div>
                                            <div class="checkbox">
                                                <label><input <?php if ($ChildIllnessRecord->drink_tea_or_saline_in_vein > 0) echo ' checked'; ?> name="drink_tea_or_saline_in_vein" type="checkbox" value="9">চা / শিরায় স্যালাইন</label>
                                            </div>
                                            <div class="checkbox">
                                                <label><input <?php if ($ChildIllnessRecord->drink_coffee > 0) echo ' checked'; ?> name="drink_coffee" type="checkbox" value="10">কফি</label>
                                            </div>
                                            <div class="checkbox">
                                                <label><input <?php if ($ChildIllnessRecord->drink_dont_know > 0) echo ' checked'; ?> name="drink_dont_know" type="checkbox" value="77">জানি না</label>
                                            </div>
                                            <div class="checkbox">
                                                <label><input <?php if ($ChildIllnessRecord->drink_other > 0) echo ' checked'; ?> id="drink_other" name="drink_other" type="checkbox" value="99">অন্যান্য (নির্দিষ্ট করুন)</label>
                                            </div>

                                        </div>
                                    </div>
                                    <div style="display:none;" class="col-md-12 drink_other_value_part">
                                        <div class="form-group">
                                            <label for="drink_other_value">এখানে উল্লেখ করুন <span style="color:red">*</span></label>
                                            <input value="<?php echo $ChildIllnessRecord->drink_other_value; ?>" name="drink_other_value" id="drink_other_value" class="form-control">
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="breastfeeding_still_now">16. (নামকে) আপনি কি এখনো বুকের দুধ খাওয়াচ্ছেন ?
                                            <span style="color:red">*</span></label>
                                        <select class="form-control" id="breastfeeding_still_now" name="breastfeeding_still_now" required>
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($yes_no)) {
                                                foreach ($yes_no as $yes_no_single) {
                                                    ?>
                                                    <option <?php
                                                    if ($ChildIllnessRecord->breastfeeding_still_now == $yes_no_single->id) {
                                                        echo " selected";
                                                    }
                                                    ?> value="<?php echo $yes_no_single->id ?>"><?php echo $yes_no_single->code . '-' . $yes_no_single->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 breastfeeding_how_many_month_part">
                                    <div class="form-group">
                                        <label for="breastfeeding_how_many_month">17. (নামকে) আপনি কতমাস পর্যন্ত বুকের দুধ খাইয়েছেন ?
                                            <span style="color:red">*</span></label>
                                        <select class="form-control" id="breastfeeding_how_many_month" name="breastfeeding_how_many_month">
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($month_dont_know)) {
                                                foreach ($month_dont_know as $month_dont_know_single) {
                                                    ?>
                                                    <option <?php
                                                    if ($ChildIllnessRecord->breastfeeding_how_many_month == $month_dont_know_single->id) {
                                                        echo " selected";
                                                    }
                                                    ?> value="<?php echo $month_dont_know_single->id ?>"><?php echo $month_dont_know_single->code . '-' . $month_dont_know_single->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 breastfeeding_how_many_month_value_part">
                                    <div class="form-group">
                                        <label for="breastfeeding_how_many_month_value">এখানে উল্লেখ করুন <span style="color:red">*</span></label>
                                        <input value="<?php if ($ChildIllnessRecord->breastfeeding_how_many_month_value > 0) echo $ChildIllnessRecord->breastfeeding_how_many_month_value; ?>" placeholder="মাস" name="breastfeeding_how_many_month_value" id="breastfeeding_how_many_month_value" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <fieldset class="scheduler-border">
                                    <legend class="scheduler-border">18. আমি এখন আপনাকে জিজ্ঞেস করবো (নামকে) গতকাল দিনে এবং রাতে কি কি তরল খাবার খাওয়ানো হয়েছে ? </legend>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="yesterday_day_night_just_water">A) শুধু পানি
                                                <span style="color:red">*</span></label>
                                            <select class="form-control" id="yesterday_day_night_just_water" name="yesterday_day_night_just_water" required>
                                                <option value="">Please Select</option>
                                                <?php
                                                if (!empty($yes_no_dont_know)) {
                                                    foreach ($yes_no_dont_know as $yes_no_dont_know_single) {
                                                        ?>
                                                        <option <?php
                                                        if ($ChildIllnessRecord->yesterday_day_night_just_water == $yes_no_dont_know_single->id) {
                                                            echo " selected";
                                                        }
                                                        ?> value="<?php echo $yes_no_dont_know_single->id ?>"><?php echo $yes_no_dont_know_single->code . '-' . $yes_no_dont_know_single->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="yesterday_day_night_juice">B) জুস
                                                <span style="color:red">*</span></label>
                                            <select class="form-control" id="yesterday_day_night_juice" name="yesterday_day_night_juice" required>
                                                <option value="">Please Select</option>
                                                <?php
                                                if (!empty($yes_no_dont_know)) {
                                                    foreach ($yes_no_dont_know as $yes_no_dont_know_single) {
                                                        ?>
                                                        <option <?php
                                                        if ($ChildIllnessRecord->yesterday_day_night_juice == $yes_no_dont_know_single->id) {
                                                            echo " selected";
                                                        }
                                                        ?> value="<?php echo $yes_no_dont_know_single->id ?>"><?php echo $yes_no_dont_know_single->code . '-' . $yes_no_dont_know_single->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="yesterday_day_night_soup_fruit_juice">C) সুপ / ফলের রস
                                                <span style="color:red">*</span></label>
                                            <select class="form-control" id="yesterday_day_night_soup_fruit_juice" name="yesterday_day_night_soup_fruit_juice" required>
                                                <option value="">Please Select</option>
                                                <?php
                                                if (!empty($yes_no_dont_know)) {
                                                    foreach ($yes_no_dont_know as $yes_no_dont_know_single) {
                                                        ?>
                                                        <option <?php
                                                        if ($ChildIllnessRecord->yesterday_day_night_soup_fruit_juice == $yes_no_dont_know_single->id) {
                                                            echo " selected";
                                                        }
                                                        ?> value="<?php echo $yes_no_dont_know_single->id ?>"><?php echo $yes_no_dont_know_single->code . '-' . $yes_no_dont_know_single->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="yesterday_day_night_tin_milk_power_milk_cow_milk">D) টিনজাত দুধ, পাউডার দুধ বা গরুর দুধ
                                                <span style="color:red">*</span></label>
                                            <select class="form-control" id="yesterday_day_night_tin_milk_power_milk_cow_milk" name="yesterday_day_night_tin_milk_power_milk_cow_milk" required>
                                                <option value="">Please Select</option>
                                                <?php
                                                if (!empty($yes_no_dont_know)) {
                                                    foreach ($yes_no_dont_know as $yes_no_dont_know_single) {
                                                        ?>
                                                        <option <?php
                                                        if ($ChildIllnessRecord->yesterday_day_night_tin_milk_power_milk_cow_milk == $yes_no_dont_know_single->id) {
                                                            echo " selected";
                                                        }
                                                        ?> value="<?php echo $yes_no_dont_know_single->id ?>"><?php echo $yes_no_dont_know_single->code . '-' . $yes_no_dont_know_single->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="yesterday_day_night_baby_food">E) শিশু খাদ্য
                                                <span style="color:red">*</span></label>
                                            <select class="form-control" id="yesterday_day_night_baby_food" name="yesterday_day_night_baby_food" required>
                                                <option value="">Please Select</option>
                                                <?php
                                                if (!empty($yes_no_dont_know)) {
                                                    foreach ($yes_no_dont_know as $yes_no_dont_know_single) {
                                                        ?>
                                                        <option <?php
                                                        if ($ChildIllnessRecord->yesterday_day_night_baby_food == $yes_no_dont_know_single->id) {
                                                            echo " selected";
                                                        }
                                                        ?> value="<?php echo $yes_no_dont_know_single->id ?>"><?php echo $yes_no_dont_know_single->code . '-' . $yes_no_dont_know_single->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="yesterday_day_night_other">F) এছাড়া অন্য কোন তরল খাবার
                                                <span style="color:red">*</span></label>
                                            <select class="form-control" id="yesterday_day_night_other" name="yesterday_day_night_other" required>
                                                <option value="">Please Select</option>
                                                <?php
                                                if (!empty($yes_no_dont_know)) {
                                                    foreach ($yes_no_dont_know as $yes_no_dont_know_single) {
                                                        ?>
                                                        <option <?php
                                                        if ($ChildIllnessRecord->yesterday_day_night_other == $yes_no_dont_know_single->id) {
                                                            echo " selected";
                                                        }
                                                        ?> value="<?php echo $yes_no_dont_know_single->id ?>"><?php echo $yes_no_dont_know_single->code . '-' . $yes_no_dont_know_single->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 yesterday_day_night_other_value_part">
                                        <div class="form-group">
                                            <label for="yesterday_day_night_other_value">এখানে উল্লেখ করুন <span style="color:red">*</span></label>
                                            <input value="<?php echo $ChildIllnessRecord->yesterday_day_night_other_value; ?>" name="yesterday_day_night_other_value" id="yesterday_day_night_other_value" class="form-control">
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="yesterday_day_night_hard_half_hard_soft_food">19. (নামকে) গতকাল দিনে এবং রাতে কোন শক্ত খাবার, আধা শক্ত খাবার বা নরম খাবার খাওয়ানো হয়েছে কি ?
                                            যদি হ্যাঁ হয় তাহলে যাচাই করুন কি ধরণের খাবার (শক্ত/আধা শক্ত/নরম) খাওয়ানো হয়েছে ?
                                            <span style="color:red">*</span></label>
                                        <select class="form-control" id="yesterday_day_night_hard_half_hard_soft_food" name="yesterday_day_night_hard_half_hard_soft_food" required>
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($yes_no)) {
                                                foreach ($yes_no as $yes_no_single) {
                                                    ?>
                                                    <option <?php
                                                    if ($ChildIllnessRecord->yesterday_day_night_hard_half_hard_soft_food == $yes_no_single->id) {
                                                        echo " selected";
                                                    }
                                                    ?> value="<?php echo $yes_no_single->id ?>"><?php echo $yes_no_single->code . '-' . $yes_no_single->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 hard_half_hard_soft_food_since_how_many_month_part">
                                    <div class="form-group">
                                        <label for="hard_half_hard_soft_food_since_how_many_month">20. আপনি আপনার (নামকে) কতমাস বয়স থেকে শক্ত/আধা শক্ত/নরম খাবার দেওয়া শুরু করেছেন ?
                                            <span style="color:red">*</span></label>
                                        <select class="form-control" id="hard_half_hard_soft_food_since_how_many_month" name="hard_half_hard_soft_food_since_how_many_month" required>
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($month_dont_know)) {
                                                foreach ($month_dont_know as $month_dont_know_single) {
                                                    ?>
                                                    <option <?php
                                                    if ($ChildIllnessRecord->hard_half_hard_soft_food_since_how_many_month == $month_dont_know_single->id) {
                                                        echo " selected";
                                                    }
                                                    ?> value="<?php echo $month_dont_know_single->id ?>"><?php echo $month_dont_know_single->code . '-' . $month_dont_know_single->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 hard_half_hard_soft_food_since_how_many_month_value_part">
                                    <div class="form-group">
                                        <label for="hard_half_hard_soft_food_since_how_many_month_value">এখানে উল্লেখ করুন <span style="color:red">*</span></label>
                                        <input value="<?php if ($ChildIllnessRecord->hard_half_hard_soft_food_since_how_many_month_value > 0) echo $ChildIllnessRecord->hard_half_hard_soft_food_since_how_many_month_value; ?>" name="hard_half_hard_soft_food_since_how_many_month_value" id="hard_half_hard_soft_food_since_how_many_month_value" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <fieldset class="scheduler-border">
                                    <legend class="scheduler-border">Diarrhoea (Last 14 days)</legend>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="diarrhoea_happened">21. (নামের) গত ১৪ দিনের মধ্যে কোন ডায়রিয়া হয়েছিল কি?
                                                <span style="color:red">*</span></label>
                                            <select class="form-control" id="diarrhoea_happened" name="diarrhoea_happened" required>
                                                <option value="">Please Select</option>
                                                <?php
                                                if (!empty($diarrhea_happened)) {
                                                    foreach ($diarrhea_happened as $diarrhea_happened_single) {
                                                        ?>
                                                        <option <?php
                                                        if ($ChildIllnessRecord->diarrhoea_happened == $diarrhea_happened_single->id) {
                                                            echo " selected";
                                                        }
                                                        ?> value="<?php echo $diarrhea_happened_single->id ?>"><?php echo $diarrhea_happened_single->code . '-' . $diarrhea_happened_single->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 diarrhoea_happened_day_number_part">
                                        <div class="form-group">
                                            <label for="diarrhoea_happened_day_number">এখানে উল্লেখ করুন <span style="color:red">*</span></label>
                                            <input value="<?php if ($ChildIllnessRecord->diarrhoea_happened_day_number > 0) echo $ChildIllnessRecord->diarrhoea_happened_day_number; ?>" placeholder="দিনের সংখ্যা" name="diarrhoea_happened_day_number" id="diarrhoea_happened_day_number" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6 diarrhoea_happened_related_part">
                                        <div class="form-group">
                                            <label for="diarrhoea_type">22. ডায়রিয়া কি ধরণের ছিল ?
                                                <span style="color:red">*</span></label>
                                            <select required class="form-control" id="diarrhoea_type" name="diarrhoea_type">
                                                <option value="">Please Select</option>
                                                <?php
                                                if (!empty($diarrhea_type)) {
                                                    foreach ($diarrhea_type as $diarrhea_type_single) {
                                                        ?>
                                                        <option <?php
                                                        if ($ChildIllnessRecord->diarrhoea_type == $diarrhea_type_single->id) {
                                                            echo " selected";
                                                        }
                                                        ?> value="<?php echo $diarrhea_type_single->id ?>"><?php echo $diarrhea_type_single->code . '-' . $diarrhea_type_single->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 diarrhoea_happened_related_part">
                                        <div class="form-group">
                                            <label for="diarrhoea_treatment_type">23. ডায়রিয়ার জন্য কি ধরণের চিকিৎসা দেওয়া হয়েছিল ?
                                                <span style="color:red">*</span></label>
                                            <select required class="form-control" id="diarrhoea_treatment_type" name="diarrhoea_treatment_type">
                                                <option value="">Please Select</option>
                                                <?php
                                                if (!empty($diarrhea_treatment_type)) {
                                                    foreach ($diarrhea_treatment_type as $diarrhea_treatment_type_single) {
                                                        ?>
                                                        <option <?php
                                                        if ($ChildIllnessRecord->diarrhoea_treatment_type == $diarrhea_treatment_type_single->id) {
                                                            echo " selected";
                                                        }
                                                        ?> value="<?php echo $diarrhea_treatment_type_single->id ?>"><?php echo $diarrhea_treatment_type_single->code . '-' . $diarrhea_treatment_type_single->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 diarrhoea_happened_related_part">
                                        <div class="form-group">
                                            <label for="diarrhoea_treatment_from">24. ডায়রিয়ার জন্য কার কাছ থেকে বা কোথা থেকে চিকিৎসা নিয়েছিলেন ?
                                                <span style="color:red">*</span></label>
                                            <select required class="form-control" id="diarrhoea_treatment_from" name="diarrhoea_treatment_from">
                                                <option value="">Please Select</option>
                                                <?php
                                                if (!empty($treatment_taken_from)) {
                                                    foreach ($treatment_taken_from as $treatment_taken_from_single) {
                                                        ?>
                                                        <option <?php
                                                        if ($ChildIllnessRecord->diarrhoea_treatment_from == $treatment_taken_from_single->id) {
                                                            echo " selected";
                                                        }
                                                        ?> value="<?php echo $treatment_taken_from_single->id ?>"><?php echo $treatment_taken_from_single->code . '-' . $treatment_taken_from_single->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div style="display:none;" class="col-md-6 diarrhoea_treatment_from_other_value_part">
                                        <div class="form-group">
                                            <label for="diarrhoea_treatment_from_other_value">এখানে উল্লেখ করুন <span style="color:red">*</span></label>
                                            <input value="<?php echo $ChildIllnessRecord->diarrhoea_treatment_from_other_value; ?>" name="diarrhoea_treatment_from_other_value" id="diarrhoea_treatment_from_other_value" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6 diarrhoea_happened_related_part">
                                        <div class="form-group">
                                            <?php
                                            $diarrhoea_start_date = "";
                                            if ($ChildIllnessRecord->diarrhoea_start_date != "") {
                                                $partsRequire = explode('-', $ChildIllnessRecord->diarrhoea_start_date);
                                                $diarrhoea_start_date = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];
                                            }
                                            ?>
                                            <label for="diarrhoea_start_date">25. (নামের) কোন তারিখে ডায়রিয়া হয়েছিল ?
                                                <span style="color:red">*</span></label>
                                            <input required value="<?php if ($diarrhoea_start_date != "") echo $diarrhoea_start_date; ?>" type="text" class="form-control date_format" id="diarrhoea_start_date" name="diarrhoea_start_date">
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="row">
                                <fieldset class="scheduler-border">
                                    <legend class="scheduler-border">Pneumonia / ARI</legend>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">26. (নামের) গত ১৪ দিনের মধে নিউমোনিয়ার কি কি লক্ষণ ছিল ? 
                                                <span style="color:red">*</span></label>
                                            <div class="checkbox">
                                                <label><input <?php if ($ChildIllnessRecord->pneumonia_symptom_no_symptom > 0) echo ' checked'; ?> name="pneumonia_symptom_no_symptom" id="pneumonia_symptom_no_symptom" type="checkbox" value="1">কোন লক্ষল ছিল না</label>
                                            </div>
                                            <div class="checkbox">
                                                <label><input <?php if ($ChildIllnessRecord->pneumonia_symptom_fever > 0) echo ' checked'; ?> name="pneumonia_symptom_fever" type="checkbox" value="2">জ্বর</label>
                                            </div>
                                            <div class="checkbox">
                                                <label><input <?php if ($ChildIllnessRecord->pneumonia_symptom_cold_cough > 0) echo ' checked'; ?> name="pneumonia_symptom_cold_cough" type="checkbox" value="3">স্বর্দি এবং কাঁশি</label>
                                            </div>
                                            <div class="checkbox">
                                                <label><input <?php if ($ChildIllnessRecord->pneumonia_symptom_breath_shortness_frequent_breathing > 0) echo ' checked'; ?> name="pneumonia_symptom_breath_shortness_frequent_breathing" type="checkbox" value="4">শ্বাসকষ্ট / ঘন ঘন শ্বাস নেওয়া</label>
                                            </div>
                                            <div class="checkbox">
                                                <label><input <?php if ($ChildIllnessRecord->pneumonia_symptom_chest_going_down > 0) echo ' checked'; ?> name="pneumonia_symptom_chest_going_down" type="checkbox" value="5">বুকের খাঁচা ডেবে যাওয়া</label>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-6 pneumonia_symptom_no_symptom_related_part">
                                        <div class="form-group">
                                            <label for="antibiotic_for_pneumonia">27.নিউমোনিয়ার জন্য কোন এন্টিবায়োটিক দেওয়া হয়েছিল কি ? 
                                                <span style="color:red">*</span></label>
                                            <select required class="form-control" id="antibiotic_for_pneumonia" name="antibiotic_for_pneumonia">
                                                <option value="">Please Select</option>
                                                <?php
                                                if (!empty($antibiotic_for_pneumonia)) {
                                                    foreach ($antibiotic_for_pneumonia as $antibiotic_for_pneumonia_single) {
                                                        ?>
                                                        <option <?php
                                                        if ($ChildIllnessRecord->antibiotic_for_pneumonia == $antibiotic_for_pneumonia_single->id) {
                                                            echo " selected";
                                                        }
                                                        ?> value="<?php echo $antibiotic_for_pneumonia_single->id ?>"><?php echo $antibiotic_for_pneumonia_single->code . '-' . $antibiotic_for_pneumonia_single->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 pneumonia_symptom_no_symptom_related_part">
                                        <div class="form-group">
                                            <label for="pneumonia_treatment_taken_from">28. নিউমোনিয়ার জন্য কার কাছ থেকে বা কোথা থেকে চিকিৎসা নিয়েছিলেন? 
                                                <span style="color:red">*</span></label>
                                            <select required class="form-control" id="pneumonia_treatment_taken_from" name="pneumonia_treatment_taken_from">
                                                <option value="">Please Select</option>
                                                <?php
                                                if (!empty($treatment_taken_from)) {
                                                    foreach ($treatment_taken_from as $treatment_taken_from_single) {
                                                        ?>
                                                        <option <?php
                                                        if ($ChildIllnessRecord->pneumonia_treatment_taken_from == $treatment_taken_from_single->id) {
                                                            echo " selected";
                                                        }
                                                        ?> value="<?php echo $treatment_taken_from_single->id ?>"><?php echo $treatment_taken_from_single->code . '-' . $treatment_taken_from_single->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div style="display:none;" class="col-md-12 pneumonia_treatment_taken_from_other_value_part">
                                        <div class="form-group">
                                            <label for="pneumonia_treatment_taken_from_other_value">এখানে উল্লেখ করুন <span style="color:red">*</span></label>
                                            <input value="<?php echo $ChildIllnessRecord->pneumonia_treatment_taken_from_other_value; ?>" name="pneumonia_treatment_taken_from_other_value" id="pneumonia_treatment_taken_from_other_value" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6 pneumonia_symptom_no_symptom_related_part">
                                        <div class="form-group">
                                            <?php
                                            $pneumonia_start_date = "";
                                            if ($ChildIllnessRecord->pneumonia_start_date != "") {
                                                $partsRequire = explode('-', $ChildIllnessRecord->pneumonia_start_date);
                                                $pneumonia_start_date = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];
                                            }
                                            ?>
                                            <label for="pneumonia_start_date">29. (নামের) কোন তারিখে নিউমোনিয়া হয়েছিল ?
                                                <span style="color:red">*</span></label>
                                            <input required value="<?php if ($pneumonia_start_date != "") echo $pneumonia_start_date; ?>" type="text" class="form-control date_format" id="pneumonia_start_date" name="pneumonia_start_date">

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="interview_status">30.ইন্টারভিউ স্ট্যাটাস
                                                <span style="color:red">*</span></label>
                                            <select class="form-control" id="interview_status" name="interview_status" required>
                                                <option value="">Please Select</option>
                                                <?php
                                                if (!empty($interview_status_child_illness)) {
                                                    foreach ($interview_status_child_illness as $interview_status_child_illness_single) {
                                                        ?>
                                                        <option <?php
                                                        if ($ChildIllnessRecord->interview_status == $interview_status_child_illness_single->id) {
                                                            echo " selected";
                                                        }
                                                        ?> value="<?php echo $interview_status_child_illness_single->id ?>"><?php echo $interview_status_child_illness_single->code . '-' . $interview_status_child_illness_single->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>        
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Update"> <input name="update_exit" type="submit" class="btn btn-primary" value="Update & Exit">
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>
</div>



<script type="text/javascript">

    $(document).ready(function () {
        $('.date_format').datepicker({
            autoclose: true,
            format: 'dd/mm/yyyy'
        });

    });

    $("#breastfeeding_ever").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");

            if (optionValue == 1)
            {
                $("#breastfeeding_after_how_many_time_after_birth").prop('required', true);
                $(".breastfeeding_after_how_many_time_after_birth_part").show();
            } else {
                $("#breastfeeding_after_how_many_time_after_birth").prop('required', false);
                $(".breastfeeding_after_how_many_time_after_birth_part").hide();
            }


        });
    }).change();

    $("#breastfeeding_after_how_many_time_after_birth").change(function () {
        $(this).find("option:selected").each(function () {
            $("#breastfeeding_after_how_many_hour_after_birth").prop('required', false);
            $(".breastfeeding_after_how_many_hour_after_birth_part").hide();
            $("#breastfeeding_after_how_many_day_after_birth").prop('required', false);
            $(".breastfeeding_after_how_many_day_after_birth_part").hide();

            var optionValue = $(this).attr("value");

            if (optionValue == 515)
            {
                $("#breastfeeding_after_how_many_hour_after_birth").prop('required', true);
                $(".breastfeeding_after_how_many_hour_after_birth_part").show();
            } else if (optionValue == 516) {
                $("#breastfeeding_after_how_many_day_after_birth").prop('required', true);
                $(".breastfeeding_after_how_many_day_after_birth_part").show();
            }
        });
    }).change();

    $("#other_drink_except_breastfeeding").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");

            if (optionValue == 1)
            {
                $(".all_drink_part").show();
            } else {
                $(".all_drink_part").hide();
            }



        });
    }).change();

    $("#drink_other").change(function () {
        if ($('#drink_other').is(":checked"))
        {
            $("#drink_other").prop('required', true);
            $(".drink_other_value_part").show();
        } else {
            $("#drink_other").prop('required', false);
            $(".drink_other_value_part").hide();
        }

    }).change();

    $("#breastfeeding_still_now").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");

            if (optionValue == 1)
            {
                $("#breastfeeding_how_many_month").prop('required', true);
                $(".breastfeeding_how_many_month_part").show();
            } else {
                $("#breastfeeding_how_many_month").prop('required', false);
                $(".breastfeeding_how_many_month_part").hide();
                $('#breastfeeding_how_many_month').val('').trigger('change');
            }

        });
    }).change();
    $("#breastfeeding_how_many_month").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");

            if (optionValue == 529)
            {
                $("#breastfeeding_how_many_month_value").prop('required', true);
                $(".breastfeeding_how_many_month_value_part").show();
            } else {
                $("#breastfeeding_how_many_month_value").prop('required', false);
                $(".breastfeeding_how_many_month_value_part").hide();
            }

        });
    }).change();
    $("#yesterday_day_night_other").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");

            if (optionValue == 331)
            {
                $("#yesterday_day_night_other_value").prop('required', true);
                $(".yesterday_day_night_other_value_part").show();
            } else {
                $("#yesterday_day_night_other_value").prop('required', false);
                $(".yesterday_day_night_other_value_part").hide();
            }

        });
    }).change();

    $("#yesterday_day_night_hard_half_hard_soft_food").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");

            if (optionValue == 1)
            {
                $("#hard_half_hard_soft_food_since_how_many_month").prop('required', true);
                $(".hard_half_hard_soft_food_since_how_many_month_part").show();
            } else {
                $("#hard_half_hard_soft_food_since_how_many_month").prop('required', false);
                $(".hard_half_hard_soft_food_since_how_many_month_part").hide();
                $('#hard_half_hard_soft_food_since_how_many_month').val('').trigger('change');
            }

        });
    }).change();

    $("#hard_half_hard_soft_food_since_how_many_month").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");

            if (optionValue == 529)
            {
                $("#hard_half_hard_soft_food_since_how_many_month_value").prop('required', true);
                $(".hard_half_hard_soft_food_since_how_many_month_value_part").show();
            } else {
                $("#hard_half_hard_soft_food_since_how_many_month_value").prop('required', false);
                $(".hard_half_hard_soft_food_since_how_many_month_value_part").hide();
            }

        });
    }).change();

    $("#diarrhoea_happened").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");
            $("#diarrhoea_happened_day_number").prop('required', false);
            $(".diarrhoea_happened_day_number_part").hide();
            $(".diarrhoea_happened_related_part").show();
            $("#diarrhoea_type").prop('required', true);
            $("#diarrhoea_treatment_type").prop('required', true);
            $("#diarrhoea_treatment_from").prop('required', true);
            $("#diarrhoea_start_date").prop('required', true);

            if (optionValue == 532)
            {
                $("#diarrhoea_happened_day_number").prop('required', true);
                $(".diarrhoea_happened_day_number_part").show();
            } else if (optionValue == 531) {
                $(".diarrhoea_happened_related_part").hide();
                $("#diarrhoea_type").prop('required', false);
                $("#diarrhoea_treatment_type").prop('required', false);
                $("#diarrhoea_treatment_from").prop('required', false);
                $("#diarrhoea_start_date").prop('required', false);
                $("#diarrhoea_treatment_from").val('').trigger('change');
            }

        });
    }).change();
    $("#diarrhoea_treatment_from").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");

            if (optionValue == 549)
            {
                $("#diarrhoea_treatment_from_other_value").prop('required', true);
                $(".diarrhoea_treatment_from_other_value_part").show();
            } else {
                $("#diarrhoea_treatment_from_other_value").prop('required', false);
                $(".diarrhoea_treatment_from_other_value_part").hide();
            }

        });
    }).change();

    $("#pneumonia_treatment_taken_from").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");

            if (optionValue == 549)
            {
                $("#pneumonia_treatment_taken_from_other_value").prop('required', true);
                $(".pneumonia_treatment_taken_from_other_value_part").show();
            } else {
                $("#pneumonia_treatment_taken_from_other_value").prop('required', false);
                $(".pneumonia_treatment_taken_from_other_value_part").hide();
            }

        });
    }).change();

    $("#pneumonia_symptom_no_symptom").change(function () {
        if ($('#pneumonia_symptom_no_symptom').is(":checked"))
        {
            $(".pneumonia_symptom_no_symptom_related_part").hide();
            $("#antibiotic_for_pneumonia").prop('required', false);
            $("#pneumonia_treatment_taken_from").prop('required', false);
            $("#pneumonia_start_date").prop('required', false);
            $("#pneumonia_treatment_taken_from").val('').trigger('change');


        } else {
            $(".pneumonia_symptom_no_symptom_related_part").show();
            $("#antibiotic_for_pneumonia").prop('required', true);
            $("#pneumonia_treatment_taken_from").prop('required', true);
            $("#pneumonia_start_date").prop('required', true);
        }
    }).change();

    $('.allowInteger').keypress(function (event) {
        return isNumber(event, this)
    });

// THE SCRIPT THAT CHECKS IF THE KEY PRESSED IS A NUMERIC OR DECIMAL VALUE.
    function isNumber(evt, element) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode < 48 || charCode > 57)
            return false;
        return true;
    }

</script>

