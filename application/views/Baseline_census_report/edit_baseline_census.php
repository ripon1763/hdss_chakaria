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
                    <a class="btn btn-primary" href="<?php echo base_url() . $controller . '?baseID=' . $baseID ?>"><?php echo $shortName ?> List</a>
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
                    <form action="<?php echo base_url() . 'Baseline_census_report/update_baseline_census?baseID=' . $baseID ?>" id="myForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8">
                        <div id="asset" style="padding-left: 20px; padding-right: 20px">
                            <h4>Household Baseline Census Details</h4>
                            <!--                            <div class="row">
                                                            <div class="col-md-4">
                                                                <p>Household Code : <?php echo $householdcode ?></p>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <p>Round Number :  <?php echo $roundNo ?></p>
                                                            </div>
                                                        </div>-->

                            <div id="form-step-0" role="form" data-toggle="validator">
                                <fieldset class="scheduler-border">
                                    <legend class="scheduler-border">স্থায়ী ঠিকানাঃ</legend>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="upazilla_name">1. উপজেলার নাম (খানা প্রধানের জন্য প্রযোজ্য)<span style="color:red">*</span></label>

                                                <input value="<?php echo $baseline_record->upazilla_name; ?>" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || event.charCode === 32" type="text" name="upazilla_name" id="upazilla_name" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="division_id">2. বিভাগের নাম (খানা প্রধানের জন্য প্রযোজ্য)<span style="color:red">*</span></label>

                                                <select name="division_id" id="division_id" class="form-control" required>
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    if (!empty($divisions)) {
                                                        foreach ($divisions as $division) {
                                                            ?>
                                                            <option <?php if ($baseline_record->division_id == $division->id) echo " selected"; ?> <?php if ($division->name == 'Others') echo " style='display:none'"; ?>  value="<?php echo $division->id ?>"><?php echo $division->code . '-' . $division->name; ?></option>

                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                    <fieldset class="scheduler-border">
                                        <legend class="scheduler-border"> 3. আগমনের কারণ কি? <span style="color:red">*</span> </legend>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="checkbox">
                                                        <label><input <?php if ($baseline_record->looking_for_work > 0) echo ' checked'; ?> type="checkbox" id="looking_for_work" name="looking_for_work" value="1">কাজের খোঁজে (1)</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input <?php if ($baseline_record->for_earning_more_money > 0) echo ' checked'; ?> type="checkbox" id="for_earning_more_money" name="for_earning_more_money" value="2">বেশি টাকা উপার্জনের জন্য (2)</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input <?php if ($baseline_record->river_erosion > 0) echo ' checked'; ?> type="checkbox" id="river_erosion" name="river_erosion" value="3">নদী ভাঙ্গনের জন্য (3)</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input <?php if ($baseline_record->for_family > 0) echo ' checked'; ?> type="checkbox" id="for_family" name="for_family" value="4">পরিবারের জন্য (4)</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input <?php if ($baseline_record->for_children_education > 0) echo ' checked'; ?> type="checkbox" id="for_children_education" name="for_children_education" value="5">বাচ্চার লেখাপড়ার জন্য (5)</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input <?php if ($baseline_record->for_own_education > 0) echo ' checked'; ?> type="checkbox" id="for_own_education" name="for_own_education" value="6">নিজের শিক্ষার জন্য (06)</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input <?php if ($baseline_record->for_marriage > 0) echo ' checked'; ?> type="checkbox" id="for_marriage" name="for_marriage" value="7">বিয়ের জন্য (07)</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input <?php if ($baseline_record->na_as_birth_here > 0) echo ' checked'; ?> type="checkbox" id="na_as_birth_here" name="na_as_birth_here" value="88">প্রযোজ্য নয় (জন্ম এখানে) (88)</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input <?php if ($baseline_record->coming_reason_other > 0) echo ' checked'; ?> type="checkbox" id="coming_reason_other" name="coming_reason_other" value="99">অন্যান্য (99)</label>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-md-4 coming_reason_other_part">
                                                <div class="form-group">
                                                    <label for="coming_reason_other_specify">নির্দিষ্ট করে লিখুন <span style="color:red;">*</span></label>
                                                    <input value="<?php echo $baseline_record->coming_reason_other_specify; ?>" class="form-control" id="coming_reason_other_specify" name="coming_reason_other_specify">
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </fieldset>
                               <!-- <fieldset class="scheduler-border">
                                    <legend class="scheduler-border">বিবাহিত নারীর (বয়স ১২-৪৯) ক্ষেত্রে প্রযোজ্যঃ</legend>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="pregnancy_status">4. আপনি কি বর্তমানে গর্ভবতী ?<span style="color:red">*</span></label>

                                                <select name="pregnancy_status" id="pregnancy_status" class="form-control" required>
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    if (!empty($yes_no_dont_know)) {
                                                        foreach ($yes_no_dont_know as $yes_no_dont_know_single) {
                                                            ?>
                                                            <option <?php if ($baseline_record->pregnancy_status == $yes_no_dont_know_single->id) echo " selected"; ?> value="<?php echo $yes_no_dont_know_single->id ?>"><?php echo $yes_no_dont_know_single->code . '-' . $yes_no_dont_know_single->name; ?></option>

                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-md-6 pregnancy_status_since_when_part">
                                            <div class="form-group">
                                                <?php
                                                $pregnancy_status_since_when = "";
                                                if ($baseline_record->pregnancy_status_since_when != "") {
                                                    $partsRequire = explode('-', $baseline_record->pregnancy_status_since_when);
                                                    $pregnancy_status_since_when = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];
                                                }
                                                ?>
                                                <label for="pregnancy_status_since_when">কবে থেকে গর্ভবতী? <span style="color:red;">*</span></label>
                                                <input value="<?php if ($pregnancy_status_since_when != "") echo $pregnancy_status_since_when; ?>" type="text" autocomplete="off" class="date_format form-control" id="pregnancy_status_since_when" name="pregnancy_status_since_when">
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>-->
                                <fieldset class="scheduler-border">
                                    <legend class="scheduler-border">আর্থ-সামাজিক তথ্যঃ</legend>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="roof">7. আপনার ঘরের ছাদ কি দিয়ে তৈরি? <span style="color:red">*</span></label>

                                                <select name="roof" id="roof" class="form-control" required>
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    if (!empty($roof_build_with)) {
                                                        foreach ($roof_build_with as $roof_build_with_single) {
                                                            ?>
                                                            <option <?php if ($baseline_record->roof == $roof_build_with_single->id) echo " selected"; ?> value="<?php echo $roof_build_with_single->id ?>"><?php echo $roof_build_with_single->code . '-' . $roof_build_with_single->name ?></option>

                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-md-6 roof_other_part">
                                            <div class="form-group">
                                                <label for="roof_other">নির্দিষ্ট করে লিখুন <span style="color:red;">*</span></label>
                                                <input value="<?php echo $baseline_record->roof_other; ?>" type="text" class="form-control" id="roof_other" name="roof_other">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="wall">8.আপনার ঘরের দেয়াল কি দিয়ে তৈরি? <span style="color:red">*</span></label>

                                                <select name="wall" id="wall" class="form-control" required>
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    if (!empty($roof_build_with)) {
                                                        foreach ($roof_build_with as $roof_build_with_single) {
                                                            ?>
                                                            <option <?php if ($baseline_record->wall == $roof_build_with_single->id) echo " selected"; ?> value="<?php echo $roof_build_with_single->id ?>"><?php echo $roof_build_with_single->code . '-' . $roof_build_with_single->name ?></option>

                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-md-6 wall_other_part">
                                            <div class="form-group">
                                                <label for="wall_other">নির্দিষ্ট করে লিখুন <span style="color:red;">*</span></label>
                                                <input value="<?php echo $baseline_record->wall_other; ?>" type="text" class="form-control" id="wall_other" name="wall_other">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="floor">9. আপনার ঘরের মেঝে কি দিয়ে তৈরি? <span style="color:red">*</span></label>

                                                <select name="floor" id="floor" class="form-control" required >
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    if (!empty($floor_build_with)) {
                                                        foreach ($floor_build_with as $floor_build_with_single) {
                                                            ?>
                                                            <option <?php if ($baseline_record->floor == $floor_build_with_single->id) echo " selected"; ?> value="<?php echo $floor_build_with_single->id ?>"><?php echo $floor_build_with_single->code . '-' . $floor_build_with_single->name ?></option>

                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>

                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="room">10. আপনার খানায় বসবাসের (ঘুমানোর) জন্য কয়টি রুম আছে? <span style="color:red">*</span></label>

                                                <input value="<?php echo $baseline_record->room; ?>" onkeypress='return event.charCode >= 48 && event.charCode <= 57' name="room" type="text" id="room" class="form-control" required>

                                            </div>
                                        </div>
                                    </div>

                                    <fieldset class="scheduler-border">
                                        <legend class="scheduler-border">11.রুম আয়তন</legend>

                                        <fieldset class="scheduler-border">
                                            <legend class="scheduler-border">প্রথম রুম আয়তন কত? (বর্গ ফুট)</legend>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="room1l">দৈর্ঘ্য:<span style="color:red;">*</span></label>
                                                        <input value="<?php echo $baseline_record->room1l; ?>" type="text" class="allowDecimalOrInteger form-control" id="room1l" name="room1l" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="room1b">প্রস্থ:<span style="color:red;">*</span></label>
                                                        <input value="<?php echo $baseline_record->room1b; ?>" type="text" class="allowDecimalOrInteger form-control" id="room1b" name="room1b" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <fieldset class="scheduler-border">
                                            <legend class="scheduler-border">দ্বিতীয় রুম আয়তন কত? (বর্গ ফুট)</legend>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="room2l">দৈর্ঘ্য:</label>
                                                        <input value="<?php echo $baseline_record->room2l; ?>" type="text" class="allowDecimalOrInteger form-control" id="room2l" name="room2l">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="room2b">প্রস্থ:</label>
                                                        <input value="<?php echo $baseline_record->room2b; ?>" type="text" class="allowDecimalOrInteger form-control" id="room2b" name="room2b">
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <fieldset class="scheduler-border">
                                            <legend class="scheduler-border">তৃতীয় রুম আয়তন কত? (বর্গ ফুট)</legend>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="room3l">দৈর্ঘ্য:</label>
                                                        <input value="<?php echo $baseline_record->room3l; ?>" type="text" class="allowDecimalOrInteger form-control" id="room3l" name="room3l">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="room3b">প্রস্থ:</label>
                                                        <input value="<?php echo $baseline_record->room3b; ?>" type="text" class="allowDecimalOrInteger form-control" id="room3b" name="room3b">
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>

                                    </fieldset>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Q42A">12. আপনার পরিবারের মাসিক আয় কত? <span style="color:red">*</span></label>
                                                <input value="<?php echo $baseline_record->Q42A; ?>" type="text" name="Q42A" id="Q42A" class="allowDecimalOrInteger form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Q42B">13.আপনি গতমাসে খাবার বাবদ আপনার পরিবারে কত টাকা ব্যয় করেছেন?<span style="color:red">*</span></label>

                                                <input value="<?php echo $baseline_record->Q42B; ?>" type="text" name="Q42B" id="Q42B" class="allowDecimalOrInteger form-control" required>

                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset class="scheduler-border">
                                    <legend class="scheduler-border">পানির নিরাপত্তাঃ</legend>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="water">14. আপনার খানায় খাবার পানির প্রধান উৎস কি?<span style="color:red;">*</span></label>
                                                <select name="water" id="water" class="form-control" required >
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    if (!empty($water_source)) {
                                                        foreach ($water_source as $water_source_single) {
                                                            ?>
                                                            <option <?php if ($baseline_record->water == $water_source_single->id) echo " selected"; ?> value="<?php echo $water_source_single->id; ?>"><?php echo $water_source_single->code . '-' . $water_source_single->name ?></option>

                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="winside">15. আপনার খাবার পানির উৎসের অবস্থান কোথায়?<span style="color:red;">*</span></label>
                                                <select name="winside" id="winside" class="form-control" required >
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    if (!empty($water_source_location)) {
                                                        foreach ($water_source_location as $water_source_location_single) {
                                                            ?>
                                                            <option <?php if ($baseline_record->winside == $water_source_location_single->id) echo " selected"; ?> value="<?php echo $water_source_location_single->id; ?>"><?php echo $water_source_location_single->code . '-' . $water_source_location_single->name ?></option>

                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <fieldset class="time_to_bring_water scheduler-border">
                                        <legend class="scheduler-border">16. তাহলে পানি আনতে কত সময় ব্যয় হয়?</legend>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="wcol_time">যেতে আসতে সময়(মিনিট)<span style="color:red;">*</span></label>
                                                    <input value="<?php echo $baseline_record->wcol_time; ?>" onkeypress='return event.charCode >= 48 && event.charCode <= 57' type="text" class="form-control" id="wcol_time" name="wcol_time">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="wait_time">অপেক্ষামান সময়(মিনিট)<span style="color:red;">*</span></label>
                                                    <input value="<?php echo $baseline_record->wait_time; ?>" onkeypress='return event.charCode >= 48 && event.charCode <= 57' type="text" class="form-control" id="wait_time" name="wait_time">
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="wat_coll">17. পরিবারের কে পানি সংগ্রহ করে?<span style="color:red;">*</span></label>
                                                <select name="wat_coll" id="wat_coll" class="form-control" required >
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    if (!empty($water_collector)) {
                                                        foreach ($water_collector as $water_collector_single) {
                                                            ?>
                                                            <option <?php if ($baseline_record->wat_coll == $water_collector_single->id) echo " selected"; ?> value="<?php echo $water_collector_single->id; ?>"><?php echo $water_collector_single->code . '-' . $water_collector_single->name ?></option>

                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6 wat_coll_other_part">
                                            <div class="form-group">
                                                <label for="wat_coll_other">নির্দিষ্ট করে লিখুন <span style="color:red;">*</span></label>
                                                <input value="<?php echo $baseline_record->watcoloth; ?>" type="text" class="form-control" id="wat_coll_other" name="watcoloth">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="wshare">18. এই খাবার পানির প্রধান উৎসটি কি অন্য কোন পরিবার ব্যবহার করে?<span style="color:red;">*</span></label>
                                                <select name="wshare" id="wshare" class="form-control" required >
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    if (!empty($yes_no)) {
                                                        foreach ($yes_no as $yes_no_single) {
                                                            ?>
                                                            <option <?php if ($baseline_record->wshare == $yes_no_single->id) echo " selected"; ?> value="<?php echo $yes_no_single->id; ?>"><?php echo $yes_no_single->code . '-' . $yes_no_single->name ?></option>

                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 wsharef_part">
                                            <div class="form-group">
                                                <label for="wsharef">19. তাহলে কতগুলো পরিবার এই খাবার পানির প্রধান উৎস ব্যবহার করে?<span style="color:red;">*</span></label>
                                                <input value="<?php echo $baseline_record->wsharef; ?>" onkeypress='return event.charCode >= 48 && event.charCode <= 57' type="text" class="form-control" id="wsharef" name="wsharef">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="wat_supp">20. আপনার এলাকায় কারা এই পানি সরবরাহ করে?<span style="color:red;">*</span></label>
                                                <select name="wat_supp" id="wat_supp" class="form-control" required >
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    if (!empty($water_supplier)) {
                                                        foreach ($water_supplier as $water_supplier_single) {
                                                            ?>
                                                            <option <?php if ($baseline_record->wat_supp == $water_supplier_single->id) echo " selected"; ?> value="<?php echo $water_supplier_single->id; ?>"><?php echo $water_supplier_single->code . '-' . $water_supplier_single->name ?></option>

                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 wat_supp_other_part">
                                            <div class="form-group">
                                                <label for="wat_supp_other">নির্দিষ্ট করে লিখুন <span style="color:red;">*</span></label>
                                                <input value="<?php echo $baseline_record->w_suppoth; ?>" type="text" class="form-control" id="wat_supp_other" name="w_suppoth">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="w_safe">21. আপনি যে পানি পান করেন তা কি নিরাপদ?<span style="color:red;">*</span></label>
                                                <select name="w_safe" id="w_safe" class="form-control" required >
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    if (!empty($yes_no_dont_know)) {
                                                        foreach ($yes_no_dont_know as $yes_no_dont_know_single) {
                                                            ?>
                                                            <option <?php if ($baseline_record->w_safe == $yes_no_dont_know_single->id) echo " selected"; ?> value="<?php echo $yes_no_dont_know_single->id ?>"><?php echo $yes_no_dont_know_single->code . '-' . $yes_no_dont_know_single->name; ?></option>

                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="w_suff">22. আপনি কি আপনাদের পরিবারের জন্য পর্যাপ্ত পানি পান ?(যে কোন পানি-খাবার পানি,গোসলের পানি,রান্নার পানি ইত্যাদি)<span style="color:red;">*</span></label>
                                                <select name="w_suff" id="w_suff" class="form-control" required >
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    if (!empty($yes_no_dont_know)) {
                                                        foreach ($yes_no_dont_know as $yes_no_dont_know_single) {
                                                            ?>
                                                            <option <?php if ($baseline_record->w_suff == $yes_no_dont_know_single->id) echo " selected"; ?> value="<?php echo $yes_no_dont_know_single->id ?>"><?php echo $yes_no_dont_know_single->code . '-' . $yes_no_dont_know_single->name; ?></option>

                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset class="scheduler-border">
                                    <legend class="scheduler-border">পয়নিষ্কাশনঃ</legend>
                                    <fieldset class="scheduler-border">
                                        <legend class="scheduler-border">23. টয়লেটের ধরণ, ময়লা অপসারনের ধরণ</legend>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="toilet">টয়লেটের ধরণ<span style="color:red;">*</span></label>
                                                    <select name="toilet" id="toilet" class="form-control" required >
                                                        <option value="">Please Select</option>
                                                        <?php
                                                        if (!empty($toilet_type)) {
                                                            foreach ($toilet_type as $toilet_type_single) {
                                                                ?>
                                                                <option <?php if ($baseline_record->toilet == $toilet_type_single->id) echo " selected"; ?> value="<?php echo $toilet_type_single->id ?>"><?php echo $toilet_type_single->code . '-' . $toilet_type_single->name; ?></option>

                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="toilet_ct">ময়লা অপসারনের ধরণ<span style="color:red;">*</span></label>
                                                    <select name="toilet_ct" id="toilet_ct" class="form-control" required >
                                                        <option value="">Please Select</option>
                                                        <?php
                                                        if (!empty($dirt_removing_type)) {
                                                            foreach ($dirt_removing_type as $dirt_removing_type_single) {
                                                                ?>
                                                                <option <?php if ($baseline_record->toilet_ct == $dirt_removing_type_single->id) echo " selected"; ?> value="<?php echo $dirt_removing_type_single->id ?>"><?php echo $dirt_removing_type_single->code . '-' . $dirt_removing_type_single->name; ?></option>

                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 toilet_ct_ot_part">
                                                <div class="form-group">
                                                    <label for="toilet_ct_ot">নির্দিষ্ট করে লিখুন <span style="color:red;">*</span></label>
                                                    <input value="<?php echo $baseline_record->toilet_ct_ot; ?>" type="text" class="form-control" id="toilet_ct_ot" name="toilet_ct_ot">
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="toilte_mf">24. পুরুষ ও মহিলার জন্য আলাদা টয়লেট আছে কি?<span style="color:red;">*</span></label>
                                                <select name="toilte_mf" id="toilte_mf" class="form-control" required >
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    if (!empty($yes_no)) {
                                                        foreach ($yes_no as $yes_no_single) {
                                                            ?>
                                                            <option <?php if ($baseline_record->toilte_mf == $yes_no_single->id) echo " selected"; ?> value="<?php echo $yes_no_single->id; ?>"><?php echo $yes_no_single->code . '-' . $yes_no_single->name ?></option>

                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 tmf_usep_part">
                                            <div class="form-group">
                                                <label for="tmf_usep">25. তাহলে টয়লেগুলো পুরুষ ও মহিলার জন্য আলাদাভাবে ব্যবহার হয় কি?<span style="color:red;">*</span></label>
                                                <select name="tmf_usep" id="tmf_usep" class="form-control">
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    if (!empty($yes_no)) {
                                                        foreach ($yes_no as $yes_no_single) {
                                                            ?>
                                                            <option <?php if ($baseline_record->tmf_usep == $yes_no_single->id) echo " selected"; ?> value="<?php echo $yes_no_single->id; ?>"><?php echo $yes_no_single->code . '-' . $yes_no_single->name ?></option>

                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="toilet_cl">26. টয়লেট কে পরিস্কার পরিচ্ছন্ন করে?<span style="color:red;">*</span></label>
                                                <select name="toilet_cl" id="toilet_cl" class="form-control" required >
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    if (!empty($toilet_cleaner)) {
                                                        foreach ($toilet_cleaner as $toilet_cleaner_single) {
                                                            ?>
                                                            <option <?php if ($baseline_record->toilet_cl == $toilet_cleaner_single->id) echo " selected"; ?> value="<?php echo $toilet_cleaner_single->id; ?>"><?php echo $toilet_cleaner_single->code . '-' . $toilet_cleaner_single->name ?></option>

                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 toilet_coth_part">
                                            <div class="form-group">
                                                <label for="toilet_coth">নির্দিষ্ট করে লিখুন <span style="color:red;">*</span></label>
                                                <input value="<?php echo $baseline_record->toilet_coth; ?>" type="text" class="form-control" id="toilet_coth" name="toilet_coth">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="toilet_dis">27. টয়লেট এর ময়লা কে অপসারণ করে?<span style="color:red;">*</span></label>
                                                <select name="toilet_dis" id="toilet_dis" class="form-control" required >
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    if (!empty($toilet_dirt_remover)) {
                                                        foreach ($toilet_dirt_remover as $toilet_dirt_remover_single) {
                                                            ?>
                                                            <option <?php if ($baseline_record->toilet_dis == $toilet_dirt_remover_single->id) echo " selected"; ?> value="<?php echo $toilet_dirt_remover_single->id; ?>"><?php echo $toilet_dirt_remover_single->code . '-' . $toilet_dirt_remover_single->name ?></option>

                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 toilet_dot_part">
                                            <div class="form-group">
                                                <label for="toilet_dot">নির্দিষ্ট করে লিখুন <span style="color:red;">*</span></label>
                                                <input value="<?php echo $baseline_record->toilet_dot; ?>" type="text" class="form-control" id="toilet_dot" name="toilet_dot">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="tinside">28. আপনার টয়লেটটির অবস্থান কোথায়?<span style="color:red;">*</span></label>
                                                <select name="tinside" id="tinside" class="form-control" required >
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    if (!empty($water_source_location)) {
                                                        foreach ($water_source_location as $water_source_location_single) {
                                                            ?>
                                                            <option <?php if ($baseline_record->tinside == $water_source_location_single->id) echo " selected"; ?> value="<?php echo $water_source_location_single->id; ?>"><?php echo $water_source_location_single->code . '-' . $water_source_location_single->name ?></option>

                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="tshare">29. অন্য কোন পরিবার এই টয়লেট ব্যবহার করে কি?<span style="color:red;">*</span></label>
                                                <select name="tshare" id="tshare" class="form-control" required >
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    if (!empty($yes_no)) {
                                                        foreach ($yes_no as $yes_no_single) {
                                                            ?>
                                                            <option <?php if ($baseline_record->tshare == $yes_no_single->id) echo " selected"; ?> value="<?php echo $yes_no_single->id; ?>"><?php echo $yes_no_single->code . '-' . $yes_no_single->name ?></option>

                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 tsharef_part">
                                            <div class="form-group">
                                                <label for="tsharef">30. তাহলে কতগুলো পরিবার এই টয়লেট ব্যবহার করে?<span style="color:red;">*</span></label>
                                                <input value="<?php echo $baseline_record->tsharef; ?>" onkeypress='return event.charCode >= 48 && event.charCode <= 57' type="text" name="tsharef" id="tsharef" class="form-control">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="light">31. আপনার খানার বাতির/ আলোর উৎস কি?<span style="color:red;">*</span></label>
                                                <select name="light" id="light" class="form-control" required >
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    if (!empty($light_source)) {
                                                        foreach ($light_source as $light_source_single) {
                                                            ?>
                                                            <option <?php if ($baseline_record->light == $light_source_single->id) echo " selected"; ?> value="<?php echo $light_source_single->id; ?>"><?php echo $light_source_single->code . '-' . $light_source_single->name ?></option>

                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 light_oth_part">
                                            <div class="form-group">
                                                <label for="light_oth">নির্দিষ্ট করে লিখুন <span style="color:red;">*</span></label>
                                                <input value="<?php echo $baseline_record->light_oth; ?>" type="text" class="form-control" id="light_oth" name="light_oth">
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset class="scheduler-border">
                                    <legend class="scheduler-border">স্বাাস্থ্যবিধিঃ</legend>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Q61">32. আপনার খানায় হাত ধোয়ার ব্যবস্থা আছে কি?<span style="color:red;">*</span></label>
                                                <select name="Q61" id="Q61" class="form-control" required >
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    if (!empty($yes_no)) {
                                                        foreach ($yes_no as $yes_no_single) {
                                                            ?>
                                                            <option <?php if ($baseline_record->Q61 == $yes_no_single->id) echo " selected"; ?> value="<?php echo $yes_no_single->id; ?>"><?php echo $yes_no_single->code . '-' . $yes_no_single->name ?></option>

                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8 Q62_part">
                                            <div class="form-group">
                                                <label for="Q62">33. তাহলে আমাকে জায়গাটা দেখাতে পারবেন? (জায়গাটি পর্যবেক্ষন করুন)<span style="color:red;">*</span></label>
                                                <select name="Q62" id="Q62" class="form-control">
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    if (!empty($hand_washing_place)) {
                                                        foreach ($hand_washing_place as $hand_washing_place_single) {
                                                            ?>
                                                            <option <?php if ($baseline_record->Q62 == $hand_washing_place_single->id) echo " selected"; ?> value="<?php echo $hand_washing_place_single->id; ?>"><?php echo $hand_washing_place_single->code . '-' . $hand_washing_place_single->name ?></option>

                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-md-4 Q62oth_part">
                                            <div class="form-group">
                                                <label for="Q62oth">নির্দিষ্ট করে লিখুন <span style="color:red;">*</span></label>
                                                <input value="<?php echo $baseline_record->Q62oth; ?>" type="text" class="form-control" id="Q62oth" name="Q62oth">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Q63">34. টয়লেট থেকে আসার পরে হাত ধোয়ার জন্য কি ব্যবস্থা আছে? (জায়গাটি পর্যবেক্ষন করুন)<span style="color:red;">*</span></label>
                                                <select name="Q63" id="Q63" class="form-control" required >
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    if (!empty($hand_washing_arrangement)) {
                                                        foreach ($hand_washing_arrangement as $hand_washing_arrangement_single) {
                                                            ?>
                                                            <option <?php if ($baseline_record->Q63 == $hand_washing_arrangement_single->id) echo " selected"; ?> value="<?php echo $hand_washing_arrangement_single->id; ?>"><?php echo $hand_washing_arrangement_single->code . '-' . $hand_washing_arrangement_single->name ?></option>

                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 Q63oth_part">
                                            <div class="form-group">
                                                <label for="Q63oth">নির্দিষ্ট করে লিখুন <span style="color:red;">*</span></label>
                                                <input value="<?php echo $baseline_record->Q63oth; ?>" type="text" class="form-control" id="Q63oth" name="Q63oth">
                                            </div>
                                        </div>
                                    </div>
                                    <fieldset class="scheduler-border">
                                        <legend class="scheduler-border">35. পরিবারের সদস্যদের কোন কোন সময় হাত ধোয়ার প্রয়োজন তা বলতে পারেন?</legend>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="Q65A"> বাড়ির বাইরে থেকে আসার পর<span style="color:red;">*</span></label>
                                                    <select name="Q65A" id="Q65A" class="form-control" required >
                                                        <option value="">Please Select</option>
                                                        <?php
                                                        if (!empty($spontaneously_afterTelling_dontKnow)) {
                                                            foreach ($spontaneously_afterTelling_dontKnow as $spontaneously_afterTelling_dontKnow_single) {
                                                                ?>
                                                                <option <?php if ($baseline_record->Q65A == $spontaneously_afterTelling_dontKnow_single->id) echo " selected"; ?> value="<?php echo $spontaneously_afterTelling_dontKnow_single->id ?>"><?php echo $spontaneously_afterTelling_dontKnow_single->code . '-' . $spontaneously_afterTelling_dontKnow_single->name; ?></option>

                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="Q65B">খাওয়ার আগে<span style="color:red;">*</span></label>
                                                    <select name="Q65B" id="Q65B" class="form-control" required >
                                                        <option value="">Please Select</option>
                                                        <?php
                                                        if (!empty($spontaneously_afterTelling_dontKnow)) {
                                                            foreach ($spontaneously_afterTelling_dontKnow as $spontaneously_afterTelling_dontKnow_single) {
                                                                ?>
                                                                <option <?php if ($baseline_record->Q65B == $spontaneously_afterTelling_dontKnow_single->id) echo " selected"; ?> value="<?php echo $spontaneously_afterTelling_dontKnow_single->id ?>"><?php echo $spontaneously_afterTelling_dontKnow_single->code . '-' . $spontaneously_afterTelling_dontKnow_single->name; ?></option>

                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="Q65C"> টয়লেট থেকে এসে<span style="color:red;">*</span></label>
                                                    <select name="Q65C" id="Q65C" class="form-control" required >
                                                        <option value="">Please Select</option>
                                                        <?php
                                                        if (!empty($spontaneously_afterTelling_dontKnow)) {
                                                            foreach ($spontaneously_afterTelling_dontKnow as $spontaneously_afterTelling_dontKnow_single) {
                                                                ?>
                                                                <option <?php if ($baseline_record->Q65C == $spontaneously_afterTelling_dontKnow_single->id) echo " selected"; ?> value="<?php echo $spontaneously_afterTelling_dontKnow_single->id ?>"><?php echo $spontaneously_afterTelling_dontKnow_single->code . '-' . $spontaneously_afterTelling_dontKnow_single->name; ?></option>

                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="Q65D">শিশু পায়খানা পরিষ্কারের পর<span style="color:red;">*</span></label>
                                                    <select name="Q65D" id="Q65D" class="form-control" required >
                                                        <option value="">Please Select</option>
                                                        <?php
                                                        if (!empty($spontaneously_afterTelling_dontKnow)) {
                                                            foreach ($spontaneously_afterTelling_dontKnow as $spontaneously_afterTelling_dontKnow_single) {
                                                                ?>
                                                                <option <?php if ($baseline_record->Q65D == $spontaneously_afterTelling_dontKnow_single->id) echo " selected"; ?> value="<?php echo $spontaneously_afterTelling_dontKnow_single->id ?>"><?php echo $spontaneously_afterTelling_dontKnow_single->code . '-' . $spontaneously_afterTelling_dontKnow_single->name; ?></option>

                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="Q65E"> শিশুকে খাওয়ানোর আগে<span style="color:red;">*</span></label>
                                                    <select name="Q65E" id="Q65E" class="form-control" required >
                                                        <option value="">Please Select</option>
                                                        <?php
                                                        if (!empty($spontaneously_afterTelling_dontKnow)) {
                                                            foreach ($spontaneously_afterTelling_dontKnow as $spontaneously_afterTelling_dontKnow_single) {
                                                                ?>
                                                                <option <?php if ($baseline_record->Q65E == $spontaneously_afterTelling_dontKnow_single->id) echo " selected"; ?> value="<?php echo $spontaneously_afterTelling_dontKnow_single->id ?>"><?php echo $spontaneously_afterTelling_dontKnow_single->code . '-' . $spontaneously_afterTelling_dontKnow_single->name; ?></option>

                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="Q65F">খাবার তৈরীর আগে<span style="color:red;">*</span></label>
                                                    <select name="Q65F" id="Q65F" class="form-control" required >
                                                        <option value="">Please Select</option>
                                                        <?php
                                                        if (!empty($spontaneously_afterTelling_dontKnow)) {
                                                            foreach ($spontaneously_afterTelling_dontKnow as $spontaneously_afterTelling_dontKnow_single) {
                                                                ?>
                                                                <option <?php if ($baseline_record->Q65F == $spontaneously_afterTelling_dontKnow_single->id) echo " selected"; ?> value="<?php echo $spontaneously_afterTelling_dontKnow_single->id ?>"><?php echo $spontaneously_afterTelling_dontKnow_single->code . '-' . $spontaneously_afterTelling_dontKnow_single->name; ?></option>

                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="cook"> 36. আপনার খানায় রান্নার জন্য কি ধরণের জ্বালানী ব্যবহার করেন?<span style="color:red;">*</span></label>
                                                <select name="cook" id="cook" class="form-control" required >
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    if (!empty($fuel_type)) {
                                                        foreach ($fuel_type as $fuel_type_single) {
                                                            ?>
                                                            <option <?php if ($baseline_record->cook == $fuel_type_single->id) echo " selected"; ?> value="<?php echo $fuel_type_single->id ?>"><?php echo $fuel_type_single->code . '-' . $fuel_type_single->name; ?></option>

                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 cookoth_part">
                                            <div class="form-group">
                                                <label for="cookoth">নির্দিষ্ট করে লিখুন <span style="color:red;">*</span></label>
                                                <input value="<?php echo $baseline_record->cookoth; ?>" type="text" class="form-control" id="cookoth" name="cookoth">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="cinside">37. রান্নাঘরের অবস্থান কোথায়?<span style="color:red;">*</span></label>
                                                <select name="cinside" id="cinside" class="form-control" required >
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    if (!empty($water_source_location)) {
                                                        foreach ($water_source_location as $water_source_location_single) {
                                                            ?>
                                                            <option <?php if ($baseline_record->cinside == $water_source_location_single->id) echo " selected"; ?> value="<?php echo $water_source_location_single->id; ?>"><?php echo $water_source_location_single->code . '-' . $water_source_location_single->name ?></option>

                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="cshare"> 38. অন্য কোন পরিবার এই রান্নাঘর ব্যবহার করে কি?<span style="color:red;">*</span></label>
                                                <select name="cshare" id="cshare" class="form-control" required >
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    if (!empty($yes_no)) {
                                                        foreach ($yes_no as $yes_no_single) {
                                                            ?>
                                                            <option <?php if ($baseline_record->cshare == $yes_no_single->id) echo " selected"; ?> value="<?php echo $yes_no_single->id; ?>"><?php echo $yes_no_single->code . '-' . $yes_no_single->name ?></option>

                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 csharef_part">
                                            <div class="form-group">
                                                <label for="csharef">39. তাহলে কতগুলো পরিবার এই রান্নাঘর ব্যবহার করে?<span style="color:red;">*</span></label>
                                                <input value="<?php echo $baseline_record->csharef; ?>" type="text" name="csharef" id="csharef" class="allowDecimalOrInteger form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="garbage"> 40. আবর্জনা কোথা হতে নেওয়া হয়? (প্রধাণত কোথা নেওয়া হয়)<span style="color:red;">*</span></label>
                                                <select name="garbage" id="garbage" class="form-control" required >
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    if (!empty($dirt_taken_place)) {
                                                        foreach ($dirt_taken_place as $dirt_taken_place_single) {
                                                            ?>
                                                            <option <?php if ($baseline_record->garbage == $dirt_taken_place_single->id) echo " selected"; ?> value="<?php echo $dirt_taken_place_single->id ?>"><?php echo $dirt_taken_place_single->code . '-' . $dirt_taken_place_single->name; ?></option>

                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 garbageoth_part">
                                            <div class="form-group">
                                                <label for="garbageoth">নির্দিষ্ট করে লিখুন <span style="color:red;">*</span></label>
                                                <input value="<?php echo $baseline_record->garbageoth; ?>" type="text" class="form-control" id="garbageoth" name="garbageoth">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="gcollect">41. আবর্জনা কত ঘন ঘন এই জায়গা থেকে সংগ্রহ করে?<span style="color:red;">*</span></label>
                                                <select name="gcollect" id="gcollect" class="form-control" required >
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    if (!empty($dirt_collection_time)) {
                                                        foreach ($dirt_collection_time as $dirt_collection_time_single) {
                                                            ?>
                                                            <option <?php if ($baseline_record->gcollect == $dirt_collection_time_single->id) echo " selected"; ?> value="<?php echo $dirt_collection_time_single->id; ?>"><?php echo $dirt_collection_time_single->code . '-' . $dirt_collection_time_single->name ?></option>

                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="voterid"> 42. আপনার (উত্তরদাতা) ভোটার আই ডি কার্ড আছে কি?<span style="color:red;">*</span></label>
                                                <select name="voterid" id="voterid" class="form-control" required >
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    if (!empty($yes_no)) {
                                                        foreach ($yes_no as $yes_no_single) {
                                                            ?>
                                                            <option <?php if ($baseline_record->voterid == $yes_no_single->id) echo " selected"; ?> value="<?php echo $yes_no_single->id; ?>"><?php echo $yes_no_single->code . '-' . $yes_no_single->name ?></option>

                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 resp_ind_part">
                                            <div class="form-group">
                                                <label for="resp_ind">43. উত্তরদাতার ব্যক্তি নম্বর<span style="color:red;">*</span></label>
                                                <input value="<?php echo $baseline_record->resp_ind; ?>" type="text" name="resp_ind" id="resp_ind" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="imobile"> 44. উত্তরদাতার মোবাইল নম্বর<span style="color:red;">*</span></label>
                                                <input value="<?php echo $baseline_record->imobile; ?>" type="text" name="imobile" id="imobile" class="form-control" required >
                                            </div>
                                        </div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="ten_perceent"> 45. গৃহস্থালী তথ্য (শুধুমাত্র পরিবারের প্রধান এর জন্য)?</label>
												<select name="ten_perceent" id="ten_perceent" class="form-control" >
													<option value="">Please Select</option>
													<?php
													if (!empty($yes_no)) {
														foreach ($yes_no as $yes_no_house) {
															?>
															<option <?php if ($baseline_record->ten_perceent == $yes_no_house->id) echo " selected"; ?> value="<?php echo $yes_no_house->id; ?>"><?php echo $yes_no_house->code.'-'.$yes_no_house->name ?></option>

															<?php
														}
													}
													?>
												</select>
											</div>
										</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="remarks">46. বিশেষ দ্রষ্টব্য</label>
                                                <textarea name="remarks" id="remarks" class="form-control"><?php echo $baseline_record->remarks; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>

                        <div class="box-footer">
                            <input type="hidden" name="baselineID" value="<?php echo $baseline_record->id; ?>">
                            <input type="submit" class="btn btn-primary btnVisile" name="submit" value="Update" />
                            <input name="update_exit" type="submit" class="btn btn-primary" value="Update & Exit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    $('.allowDecimalOrInteger').keypress(function (event) {
        return isNumber(event, this)
    });

// THE SCRIPT THAT CHECKS IF THE KEY PRESSED IS A NUMERIC OR DECIMAL VALUE.
    function isNumber(evt, element) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (
                (charCode != 46 || $(element).val().indexOf('.') != -1) && // “.” CHECK DOT, AND ONLY ONE.
                (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

    $('.date_format').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy'
    });

    $("#winside").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");
            if (optionValue > 0 && optionValue != 349) {
                $("#wcol_time").prop('required', true);
                $("#wait_time").prop('required', true);
                $(".time_to_bring_water").show();
            } else {
                $("#wcol_time").prop('required', false);
                $("#wait_time").prop('required', false);
                $(".time_to_bring_water").hide();
            }
        });
    }).change();

    $("#coming_reason_other").change(function () {
        if ($("#coming_reason_other").is(":checked")) {
            $("#coming_reason_other_specify").prop('required', true);
            $(".coming_reason_other_part").show();
        } else {
            $("#coming_reason_other_specify").prop('required', false);
            $(".coming_reason_other_part").hide();
        }
    }).change();

    $("#pregnancy_status").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");

            if (optionValue == 331)
            {
                $("#pregnancy_status_since_when").prop('required', true);
                $(".pregnancy_status_since_when_part").show();
            } else {
                $("#pregnancy_status_since_when").prop('required', false);
                $(".pregnancy_status_since_when_part").hide();
            }


        });
    }).change();

    $("#roof").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");

            if (optionValue == 338)
            {
                $("#roof_other").prop('required', true);
                $(".roof_other_part").show();
            } else {
                $("#roof_other").prop('required', false);
                $(".roof_other_part").hide();
            }


        });
    }).change();

    $("#wall").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");

            if (optionValue == 338)
            {
                $("#wall_other").prop('required', true);
                $(".wall_other_part").show();
            } else {
                $("#wall_other").prop('required', false);
                $(".wall_other_part").hide();
            }


        });
    }).change();


    $("#wshare").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");
            if (optionValue == 1) {
                $("#wsharef").prop('required', true);
                $(".wsharef_part").show();
            } else {
                $("#wsharef").prop('required', false);
                $(".wsharef_part").hide();
            }
        });
    }).change();


    $("#wat_coll").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");

            if (optionValue == 357)
            {
                $("#wat_coll_other").prop('required', true);
                $(".wat_coll_other_part").show();
            } else {
                $("#wat_coll_other").prop('required', false);
                $(".wat_coll_other_part").hide();
            }


        });
    }).change();

    $("#wat_supp").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");

            if (optionValue == 363)
            {
                $("#wat_supp_other").prop('required', true);
                $(".wat_supp_other_part").show();
            } else {
                $("#wat_supp_other").prop('required', false);
                $(".wat_supp_other_part").hide();
            }


        });
    }).change();

    $("#toilet_ct").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");

            if (optionValue == 398)
            {
                $("#toilet_ct_ot").prop('required', true);
                $(".toilet_ct_ot_part").show();
            } else {
                $("#toilet_ct_ot").prop('required', false);
                $(".toilet_ct_ot_part").hide();
            }


        });
    }).change();


    $("#toilte_mf").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");
            if (optionValue == 1) {
                $("#tmf_usep").prop('required', true);
                $(".tmf_usep_part").show();
            } else {
                $("#tmf_usep").prop('required', false);
                $(".tmf_usep_part").hide();
            }
        });
    }).change();



    $("#toilet_cl").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");

            if (optionValue == 370)
            {
                $("#toilet_coth").prop('required', true);
                $(".toilet_coth_part").show();
            } else {
                $("#toilet_coth").prop('required', false);
                $(".toilet_coth_part").hide();
            }


        });
    }).change();

    $("#toilet_dis").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");

            if (optionValue == 377)
            {
                $("#toilet_dot").prop('required', true);
                $(".toilet_dot_part").show();
            } else {
                $("#toilet_dot").prop('required', false);
                $(".toilet_dot_part").hide();
            }


        });
    }).change();



    $("#tshare").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");
            if (optionValue == 1) {
                $("#tsharef").prop('required', true);
                $(".tsharef_part").show();
            } else {
                $("#tsharef").prop('required', false);
                $(".tsharef_part").hide();
            }
        });
    }).change();



    $("#light").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");

            if (optionValue == 382)
            {
                $("#light_oth").prop('required', true);
                $(".light_oth_part").show();
            } else {
                $("#light_oth").prop('required', false);
                $(".light_oth_part").hide();
            }


        });
    }).change();



    $("#Q61").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");
            if (optionValue == 1) {
                $("#Q62").prop('required', true);
                $(".Q62_part").show();
            } else {
                $("#Q62").prop('required', false);
                $(".Q62_part").hide();
                $('#Q62').val('').trigger('change');
            }
        });
    }).change();

    $("#Q62").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");

            if (optionValue == 385)
            {
                $("#Q62oth").prop('required', true);
                $(".Q62oth_part").show();
            } else {
                $("#Q62oth").prop('required', false);
                $(".Q62oth_part").hide();
            }


        });
    }).change();



    $("#Q63").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");

            if (optionValue == 404)
            {
                $("#Q63oth").prop('required', true);
                $(".Q63oth_part").show();
            } else {
                $("#Q63oth").prop('required', false);
                $(".Q63oth_part").hide();
            }


        });
    }).change();

    $("#cook").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");

            if (optionValue == 414)
            {
                $("#cookoth").prop('required', true);
                $(".cookoth_part").show();
            } else {
                $("#cookoth").prop('required', false);
                $(".cookoth_part").hide();
            }


        });
    }).change();


    $("#cshare").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");

            if (optionValue == 1)
            {
                $("#csharef").prop('required', true);
                $(".csharef_part").show();
            } else {
                $("#csharef").prop('required', false);
                $(".csharef_part").hide();
            }


        });
    }).change();


    $("#garbage").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");

            if (optionValue == 418)
            {
                $("#garbageoth").prop('required', true);
                $(".garbageoth_part").show();
            } else {
                $("#garbageoth").prop('required', false);
                $(".garbageoth_part").hide();
            }


        });
    }).change();

    // $("#voterid").change(function () {
        // $(this).find("option:selected").each(function () {
            // var optionValue = $(this).attr("value");

            // if (optionValue == 1)
            // {
                // $("#resp_ind").prop('required', true);
                // $(".resp_ind_part").show();
            // } else {
                // $("#resp_ind").prop('required', false);
                // $(".resp_ind_part").hide();
            // }


        // });
    // }).change();

</script>

