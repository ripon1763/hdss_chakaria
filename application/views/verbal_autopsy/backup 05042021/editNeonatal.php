<script type="text/javascript">

    $(function () {

        $('.datepicker').datepicker({autoclose: true});
    });

</script>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
            <div class="col-xs-6 text-left header-margin ">
                <h3>
                    Neonate Verbal Autopsy
                    <small>(Add, Edit)</small>
                    <?php $baseID = $this->input->get('baseID', TRUE); ?>
                </h3>

            </div>
            <div class="col-xs-6 text-right">
                <div class="form-group margin5pxBot">
                    <a class="btn btn-primary" href="<?php echo base_url() . $controller . '?baseID=' . $baseID ?>"><?php echo $shortName ?> List</a>
                    <a class="btn btn-primary" href="<?php echo base_url() . $controller . '/neonate?baseID=' . $baseID ?>">Neonate List</a>
                </div>
            </div>
        </div>
    </section>

    <section class="content content-margin">
        <div class="row">

            <div class="col-md-12">

                <div class="box box-primary">


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

                    <div class="row">
                        <div class="col-md-12">
                            <h4 style="text-align: center;"><b>Verbal Autopsy Questionnaire</b><br/>
                                Part 1: Neonatal Deaths (0-28 days old)
                            </h4>
                        </div>
                    </div>

                    <form role="form" action="<?php echo base_url() . $controller . '/' . $actionMethod . '?baseID=' . $baseID ?>" method="post">
                        <input type="hidden" name="ID" value="<?php echo $userInfo->ID; ?>">
                        <input id="FK_SEX" type="hidden" name="FK_SEX" value="<?php echo $userInfo->FK_SEX; ?>">
                        <input id="household_master_id" type="hidden" name="household_master_id" value="<?php echo $userInfo->HOUSEHOLD_MASTER_ID; ?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <b>I. IDENTIFICATION OF THE RESPONDENT</b>
                                </div>
                                <br/>
                                <div class="col-md-12">
                                    <br/>
                                    <b>1.1</b>  সাক্ষাতের সময় যারা উপস্থিত আছেন, তাদের মধ্যে কারা শেষ অসুখের সময় উপস্থিত ছিলেন?
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group col-md-4">
                                        <label for="Item Name">1. সাক্ষাৎকার গ্রহনের সময় উপস্থিত ব্যক্তির নাম:</label>
                                        <select name="Q1_1_N1" class="form-control" id="Q1_1_N1">
                                            <option id="" value="">নির্বাচন করুন</option>
                                            <?php
                                            foreach ($household_member as $household) {
                                                ?>
                                                <option <?php
                                                if ($userInfo->Q1_1_N1 == $household->MEMBER_CODE) {
                                                    echo 'selected=selected';
                                                }
                                                ?> value="<?php echo $household->MEMBER_CODE; ?>"><?php echo $household->MEMBER_CODE . '-' . $household->MEMBER_NAME; ?></option>
                                                    <?php
                                                }
                                                ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">

                                        <label for="Item Name">মৃত শিশুর সাথে সম্পর্ক</label>
                                        <select onchange="showHide(this.id, 'Q1_1_R1_off')" name="Q1_1_R1" class="form-control" id="Q1_1_R1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Relation as $VA_Relation_single) {
                                                ?>
                                                <option <?php
                                                if ($userInfo->Q1_1_R1 == $VA_Relation_single->id)
                                                    echo ' selected';

                                                if ($VA_Relation_single->code == 7)
                                                    echo " id='Q1_1_R1_root'";
                                                else
                                                    echo " id='Q1_1_R1_" . $i . "'";
                                                ?> value="<?php echo $VA_Relation_single->id; ?>"><?php echo $VA_Relation_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input <?php if (strlen($userInfo->Q1_1_R1_other) > 0 == false) echo " style='display:none;'"; ?> value="<?php echo $userInfo->Q1_1_R1_other; ?>" id="Q1_1_R1_off" type="text" name="Q1_1_R1_other" class="form-control">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="Item Name">অসুস্থকালীন উপস্থিত ছিলেন?</label>
                                        <select name="Q1_1_P1" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($va_yes_no as $va_yes_no_single) { ?>
                                                <option <?php if ($userInfo->Q1_1_P1 == $va_yes_no_single->id) echo ' selected'; ?> value="<?php echo $va_yes_no_single->id; ?>"><?php echo $va_yes_no_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group col-md-4">
                                        <label for="Item Name">2. সাক্ষাৎকার গ্রহনের সময় উপস্থিত ব্যক্তির নাম:</label>
                                        <select name="Q1_1_N2" class="form-control" id="Q1_1_N2">
                                            <option id="" value="">নির্বাচন করুন</option>
                                            <?php
                                            foreach ($household_member as $household2) {
                                                ?>
                                                <option <?php
                                                if ($userInfo->Q1_1_N2 == $household2->MEMBER_CODE) {
                                                    echo 'selected=selected';
                                                }
                                                ?> value="<?php echo $household2->MEMBER_CODE; ?>"><?php echo $household2->MEMBER_CODE . '-' . $household2->MEMBER_NAME; ?></option>
                                                    <?php
                                                }
                                                ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="Item Name">মৃত শিশুর সাথে সম্পর্ক</label>
                                        <select onchange="showHide(this.id, 'Q1_1_R2_off')" name="Q1_1_R2" class="form-control" id="Q1_1_R2">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Relation as $VA_Relation_single) {
                                                ?>
                                                <option <?php
                                                if ($userInfo->Q1_1_R2 == $VA_Relation_single->id)
                                                    echo ' selected';

                                                if ($VA_Relation_single->code == 7)
                                                    echo " id='Q1_1_R2_root'";
                                                else
                                                    echo " id='Q1_1_R2_" . $i . "'";
                                                ?> value="<?php echo $VA_Relation_single->id; ?>"><?php echo $VA_Relation_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select><br/>
                                        <input value="<?php echo $userInfo->Q1_1_R2_other; ?>" <?php if (strlen($userInfo->Q1_1_R2_other) > 0 == false) echo " style='display:none;'"; ?> id="Q1_1_R2_off" type="text" name="Q1_1_R2_other" class="form-control">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="Item Name">অসুস্থকালীন উপস্থিত ছিলেন?</label>
                                        <select name="Q1_1_P2" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($va_yes_no as $va_yes_no_single) { ?>
                                                <option <?php if ($userInfo->Q1_1_P2 == $va_yes_no_single->id) echo ' selected'; ?> value="<?php echo $va_yes_no_single->id; ?>"><?php echo $va_yes_no_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group col-md-4">
                                        <label for="Item Name">3. সাক্ষাৎকার গ্রহনের সময় উপস্থিত ব্যক্তির নাম:</label>
                                        <select name="Q1_1_N3" class="form-control" id="Q1_1_N3">
                                            <option id="" value="">নির্বাচন করুন</option>
                                            <?php
                                            foreach ($household_member as $household3) {
                                                ?>
                                                <option <?php
                                                if ($userInfo->Q1_1_N3 == $household3->MEMBER_CODE) {
                                                    echo 'selected=selected';
                                                }
                                                ?> value="<?php echo $household3->MEMBER_CODE; ?>"><?php echo $household3->MEMBER_CODE . '-' . $household3->MEMBER_NAME; ?></option>
                                                    <?php
                                                }
                                                ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="Item Name">মৃত শিশুর সাথে সম্পর্ক</label>
                                        <select onchange="showHide(this.id, 'Q1_1_R3_off')" name="Q1_1_R3" class="form-control" id="Q1_1_R3">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Relation as $VA_Relation_single) {
                                                ?>
                                                <option <?php
                                                if ($userInfo->Q1_1_R3 == $VA_Relation_single->id)
                                                    echo ' selected';

                                                if ($VA_Relation_single->code == 7)
                                                    echo " id='Q1_1_R3_root'";
                                                else
                                                    echo " id='Q1_1_R3_" . $i . "'";
                                                ?> value="<?php echo $VA_Relation_single->id; ?>"><?php echo $VA_Relation_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select><br/>
                                        <input value="<?php echo $userInfo->Q1_1_R3_other; ?>" <?php if (strlen($userInfo->Q1_1_R3_other) > 0 == false) echo " style='display:none;'"; ?> id="Q1_1_R3_off" type="text" name="Q1_1_R3_other" class="form-control">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="Item Name">অসুস্থকালীন উপস্থিত ছিলেন?</label>
                                        <select name="Q1_1_P3" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($va_yes_no as $va_yes_no_single) { ?>
                                                <option <?php if ($userInfo->Q1_1_P3 == $va_yes_no_single->id) echo ' selected'; ?> value="<?php echo $va_yes_no_single->id; ?>"><?php echo $va_yes_no_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>1.2) প্রধান উত্তরদাতার লাইন# :</label>
                                        <input value="<?php if ($userInfo->Q1_2_LINE > 0) echo $userInfo->Q1_2_LINE; ?>" min="1" max="3" name="Q1_2_LINE" type="number" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>লিঙ্গ:</label> 
                                        <select name="Q1_2_SEX" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($va_gender as $va_gender_single) { ?>
                                                <option <?php if ($userInfo->Q1_2_SEX == $va_gender_single->id) echo ' selected'; ?> value="<?php echo $va_gender_single->id; ?>"><?php echo $va_gender_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>1.3) মৃত ব্যক্তির সাথে উত্তরদাতার সম্পর্ক</label>
                                        <select onchange="showHide(this.id, 'Q1_3_REL_off')" name="Q1_3_REL" class="form-control" id="Q1_3_REL">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Relation as $VA_Relation_single) {
                                                ?>
                                                <option <?php
                                                if ($userInfo->Q1_3_REL == $VA_Relation_single->id)
                                                    echo ' selected';

                                                if ($VA_Relation_single->code == 7)
                                                    echo " id='Q1_3_REL_root'";
                                                else
                                                    echo " id='Q1_3_REL_" . $i . "'";
                                                ?> value="<?php echo $VA_Relation_single->id; ?>"><?php echo $VA_Relation_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select><br/>
                                        <input value="<?php echo $userInfo->Q1_3_REL_OTHER; ?>" <?php if (strlen($userInfo->Q1_3_REL_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q1_3_REL_off" type="text" name="Q1_3_REL_OTHER" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>1.4) প্রধান উত্তরদাতার বয়স (বছরে): </label>
                                    <input value="<?php if ($userInfo->Q1_4_AGE > 0) echo $userInfo->Q1_4_AGE; ?>" name="Q1_4_AGE" type="text" class="form-control">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>1.5) তিনি কত বৎসরের প্রাতিষ্ঠানিক শিক্ষা সম্পন্ন করেছেন?</label>
                                    <input value="<?php if ($userInfo->Q1_5_EDU > 0) echo $userInfo->Q1_5_EDU; ?>" name="Q1_5_EDU" type="text" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="Item Name"><b>1.6</b> যদি মৃত শিশুর মা উপস্থিত না থাকেন, তিনি কি এখনও বেঁচে আছেন?</label>
                                    <select class="form-control" name="Q1_6">
                                        <option id="0" value="">নির্বাচন করুন</option>
                                        <?php foreach ($VA_Yes_No_Reluctant_NotApplicable_Unknown as $VA_Yes_No_Reluctant_NotApplicable_Unknown_single) { ?>
                                            <option <?php if ($userInfo->Q1_6 == $VA_Yes_No_Reluctant_NotApplicable_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_NotApplicable_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_NotApplicable_Unknown_single->name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4"> 
                                    <label for="Item Name"><b>1.7</b> মৃত শিশুটির মা মারা গিয়ে থাকলে উনি প্রসব কালে না প্রসবের পরে মারা গিয়েছেন?</label>
                                    <select class="form-control" name="Q1_7">
                                        <option id="0" value="">নির্বাচন করুন</option>
                                        <?php foreach ($VA_Mother_Death_When as $VA_Mother_Death_When_single) { ?>
                                            <option <?php if ($userInfo->Q1_7 == $VA_Mother_Death_When_single->id) echo ' selected'; ?> value="<?php echo $VA_Mother_Death_When_single->id; ?>"><?php echo $VA_Mother_Death_When_single->name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="Item Name"><b>1.8</b> প্রসবের কতক্ষন পরে মা মারা গেছেন?<br/>
                                        <span>(২৪ ঘন্টার কম হলে=০০ দিন, মাস হিসাব করতে ১ মাস=৩০ দিন,এই হিসাবে গননা করুন)।</span>
                                    </label> 

                                    <select onchange="showHide(this.id, 'Q1_8_off')" class="form-control" id="Q1_8" name="Q1_8">
                                        <option id="0" value="">নির্বাচন করুন</option>
                                        <?php
                                        $i = 1;
                                        foreach ($VA_Day_Month_Reluctant_Unknown as $VA_Day_Month_Reluctant_Unknown_single) {
                                            ?>
                                            <option <?php if ($userInfo->Q1_8 == $VA_Day_Month_Reluctant_Unknown_single->id) echo ' selected'; ?> <?php
                                            if ($VA_Day_Month_Reluctant_Unknown_single->code == 1 || $VA_Day_Month_Reluctant_Unknown_single->code == 2)
                                                echo " id='Q1_8_root'";
                                            else
                                                echo " id='Q1_8_" . $i . "'";
                                            ?> value="<?php echo $VA_Day_Month_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Day_Month_Reluctant_Unknown_single->name; ?></option>
                                                <?php
                                                $i++;
                                            }
                                            ?>
                                    </select><br/>
                                    <input value="<?php echo $userInfo->Q1_8_DAY_OR_MONTH; ?>" <?php if ($userInfo->Q1_8_DAY_OR_MONTH > 0 == false) echo " style='display:none;'"; ?> type="number" id="Q1_8_off" name="Q1_8_DAY_OR_MONTH" class="form-control">

                                </div>

                                <div class="box-footer col-md-12" style="margin-left:20px;margin-right:20px">
                                    <input type="submit" class="btn btn-primary" value="Update">
                                </div>

                                <div class="col-md-12">
                                    <b>II. BACKGROUND INFORMATION ABOUT THE INTERVIEWER</b>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>2.1) সাক্ষাৎকার গ্রহনকারীর নাম:</label>

                                    <?php
                                    if ($userInfo->Q2_1_INTV_NAME == '') {

                                        $name = $name;
                                    } else {

                                        $name = $userInfo->Q2_1_INTV_NAME;
                                    }

                                    if ($userInfo->Q2_1_INTV_CODE == 0) {

                                        $intervcode = $intervcode;
                                    } else {

                                        $intervcode = $userInfo->Q2_1_INTV_CODE;
                                    }
                                    ?>


                                    <input value="<?php echo $name; ?>" name="Q2_1_INTV_NAME" type="text" class="form-control">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>কোড:</label>
                                    <input value="<?php echo $intervcode; ?>" name="Q2_1_INTV_CODE" type="text" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="Item Name">ভাষা</label>
                                    <input value="<?php echo $userInfo->Q2_1_INTV_LANGUAGE; ?>" name="Q2_1_INTV_LANGUAGE" type="text" class="form-control">
                                </div>

                                <?php
                                $Q2_2_INTV_DATE = '';
                                $Q2_3_1ST_INTV_DATE = '';
                                $Q2_4_2ND_INTV_DATE = '';


                                if (!empty($userInfo->Q2_2_INTV_DATE)) {

                                    $partsRequire = explode('-', $userInfo->Q2_2_INTV_DATE);
                                    $Q2_2_INTV_DATE = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];
                                }
                                if (!empty($userInfo->Q2_3_1ST_INTV_DATE)) {

                                    $partsRequire = explode('-', $userInfo->Q2_3_1ST_INTV_DATE);
                                    $Q2_3_1ST_INTV_DATE = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];
                                }
                                if (!empty($userInfo->Q2_4_2ND_INTV_DATE)) {

                                    $partsRequire = explode('-', $userInfo->Q2_4_2ND_INTV_DATE);
                                    $Q2_4_2ND_INTV_DATE = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];
                                }
                                ?>


                                <div class="col-md-4 form-group">
                                    <label>2.2) সাক্ষাতের তারিখ (দিন/মাস/বছর):</label>

                                    <input value="<?php if ($userInfo->Q2_2_INTV_DATE != "0000-00-00") echo $Q2_2_INTV_DATE; ?>" autocomplete="off" name="Q2_2_INTV_DATE" type="text" class="datepicker form-control">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>2.3) ১ম সাক্ষাতের তারিখ (দিন/মাস/বছর):</label>
                                    <input value="<?php if ($userInfo->Q2_3_1ST_INTV_DATE != "0000-00-00") echo $Q2_3_1ST_INTV_DATE; ?>" autocomplete="off" name="Q2_3_1ST_INTV_DATE" type="text" class="datepicker form-control">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>2.4) ২য় সাক্ষাতের তারিখ (দিন/মাস/বছর):</label>
                                    <input value="<?php if ($userInfo->Q2_4_2ND_INTV_DATE != "0000-00-00") echo $Q2_4_2ND_INTV_DATE; ?>" autocomplete="off" name="Q2_4_2ND_INTV_DATE" type="text" class="datepicker form-control">
                                </div>

                                <div class="col-md-12">
                                    <b>III. IDENTIFICATION & DEMOGRAPHIC DATA OF THE DECEASED</b>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>3.1) মৃতের নাম:</label>
                                        <input value="<?php echo $userInfo->MEMBER_NAME; ?>" name="Q3_1_DNAME" type="text" class="form-control" disabled>
                                    </div> 
                                    <div class="col-md-4 form-group">
                                        <label>3.2) RMID: </label>
                                        <input value="<?php echo $userInfo->MEMBER_CODE; ?>" name="Q3_2_RID" type="text" class="form-control" disabled>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>CHID</label>
                                        <input value="<?php echo $userInfo->HOUSEHOLD_CODE; ?>" name="Q3_2_CID" type="text" class="form-control" disabled>
                                    </div>
                                </div>

                                <?php
                                $Q3_5_DOB = '';
                                $Q3_6_DOD = '';
                                $Q3_9_2_DOM = '';

                                if (!empty($userInfo->Q3_5_DOB)) {
                                    $partsRequire = explode('-', $userInfo->Q3_5_DOB);
                                    $Q3_5_DOB = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];
                                }
                                if (!empty($userInfo->Q3_6_DOD)) {
                                    $partsRequire = explode('-', $userInfo->Q3_6_DOD);
                                    $Q3_6_DOD = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];
                                }
                                if (!empty($userInfo->Q3_9_2_DOM)) {
                                    $partsRequire = explode('-', $userInfo->Q3_9_2_DOM);
                                    $Q3_9_2_DOM = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];
                                }



                                $partsRequire = explode('-', $userInfo->BIRTH_DATE);
                                $BIRTH_DATE = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];

                                $partsRequire = explode('-', $userInfo->DEATH_DATE);
                                $DEATH_DATE = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];


                                $date1 = strtotime($userInfo->BIRTH_DATE);
                                $date2 = strtotime($userInfo->DEATH_DATE);

                                $diff = abs($date2 - $date1);
                                $years = floor($diff / (365 * 60 * 60 * 24));

                                $year1 = floor($diff / (60 * 60 * 24));
                                ?>

                                <div class="col-md-4 form-group">
                                    <label>3.5) শিশুর জন্ম তারিখ (দিন/মাস/বছর):</label>
                                    <input value="<?php echo $BIRTH_DATE; ?>" autocomplete="off" name="Q3_5_DOB" type="text" class="datepicker form-control" disabled>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>3.6) মৃতের মৃত্যু তারিখ (দিন/মাস/বছর):</label>
                                    <input value="<?php echo $DEATH_DATE; ?>" autocomplete="off" name="Q3_6_DOD" type="text" class="datepicker form-control" disabled>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="Item Name"><b>3.8</b> মৃত্যুকালে বয়স (দিন)</label>
                                    <input value="<?php echo $year1 ?>" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="Item Name"><b>3.9</b> শিশুর লিঙ্গ</label>
                                    <select name="Q3_8_SEX" class="form-control" disabled>
                                        <option id="0" value="">নির্বাচন করুন</option>
                                        <?php foreach ($va_gender as $va_gender_single) { ?>
                                            <option <?php if ($userInfo->FK_SEX == $va_gender_single->id) echo ' selected'; ?> value="<?php echo $va_gender_single->id; ?>"><?php echo $va_gender_single->name; ?></option>
                                        <?php } ?>
                                    </select> 
                                </div>


                                <div class="col-md-12">
                                    <b>IV. RESPONDENT'S ACCOUNT OF ILLNESS/EVENTS LEADING TO DEATH</b>
                                </div>

                                <div class="form-group col-md-12">
                                    <label>
                                        <b>4.1</b> মৃত্যুর আগের শিশুটির সর্বশেষ অসুস্থতা সম্পর্কে আপনি আমাকে দয়া করে কিছূ বলবেন কি?
                                        <!-- সাক্ষাৎকার গ্রহনকারীর প্রতি নির্দেশিকা উত্তরদাতাকে তার নিজের ভাষায় বলার জন্য সহায়তা করুন।
                                        উত্তরদাতার বলার পর, যতক্ষণ পর্যন্ত না বলে যে আর কিছু বলার নেই ততক্ষন পর্যন্ত
                                        জিজ্ঞাসা করতে থাকুন আরও কিছু ছিল কি না।   -->
                                        উত্তরদাতার স্বতস্ফুর্তভাবে বলা রোগের লক্ষণগুলো লিপিবদ্ধ করুন ও অপরিচিত কোন শব্দ থাকলে তার নীচে লাইন টেনে চিহ্নিত করুন।
                                    </label>
                                </div>

                                <div class="form-group col-md-12">
                                    <div class="col-md-12 form-group">
                                        <label>কি কারণে তার মৃত্যু হয়েছিল বলে আপনি মনে করেন? কারণ সমূহ লিখুনঃ (অনিচ্ছা=7)</label>
                                        <textarea name="Q4_1_death_reasons" rows="5" class="form-control"><?php echo $userInfo->Q4_1_death_reasons; ?></textarea>
                                    </div>
                                </div>

                                <div class="box-footer col-md-12" style="margin-left:20px;margin-right:20px">
                                    <input type="submit" class="btn btn-primary" value="Update">
                                </div>
                                <div class="col-md-12">
                                    <b>V. আঘাত বা দুর্ঘটনা (INJURY OR ACCIDENT)</b>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group col-md-4">
                                        <label><b>5.1</b> সে কি কোন আঘাত বা দূর্ঘটনায় মারা গিয়েছিল?</label>
                                        <select class="form-control" id="Q5_1" name="Q5_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q5_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> <?php echo " id='QQ5_1_" . $i . "'"; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                <?php
                                                $i++;
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q5_1 != 1576) echo " style='display:none;'" ?> class="form-group col-md-4 Q5_1_yes">
                                        <label><b>5.1.1</b>&nbsp;কি ধরনের দুর্ঘটনা বা আঘাত? </label>
                                        <select onchange="showHide(this.id, 'Q5_1_1_off')" id="Q5_1_1" class="form-control" name="Q5_1_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_INJURY_OR_ACCIDENT_TYPE as $VA_INJURY_OR_ACCIDENT_TYPE_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q5_1_1 == $VA_INJURY_OR_ACCIDENT_TYPE_single->id) echo ' selected'; ?> <?php
                                                if ($VA_INJURY_OR_ACCIDENT_TYPE_single->code == 17)
                                                    echo " id='Q5_1_1_root'";
                                                else
                                                    echo " id='Q5_1_1_" . $i . "'";
                                                ?> value="<?php echo $VA_INJURY_OR_ACCIDENT_TYPE_single->id; ?>"><?php echo $VA_INJURY_OR_ACCIDENT_TYPE_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select><br/>
                                        <input value="<?php echo $userInfo->Q5_1_1_OTHER; ?>" <?php if (strlen($userInfo->Q5_1_1_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q5_1_1_off" type="text" name="Q5_1_1_OTHER" class="form-control">
                                    </div>
                                    <div <?php if ($userInfo->Q5_1 != 1576) echo " style='display:none;'" ?> class="form-group col-md-4 Q5_1_yes">
                                        <label><b>5.1.2</b> আঘাত বা দুর্ঘটনা টি কি অন্যের দ্বারা হয়েছে?</label>
                                        <select id="Q5_1_2" class="form-control" name="Q5_1_2">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q5_1_2 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div <?php if ($userInfo->Q5_1 != 1576) echo " style='display:none;'" ?> class="col-md-12 Q5_1_yes">
                                    <div class="form-group col-md-4">
                                        <label><b>5.1.3</b> সে কি দুর্ঘটনা বা আঘাত প্রাপ্তিস্থলে মারা গিয়েছিল?</label>
                                        <select id="Q5_1_3" class="form-control" name="Q5_1_3">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q5_1_3 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="form-group col-md-4 Q5_1_3_no_reluctant_unknown">
                                        <label><b>5.1.4</b> আঘাতপ্রাপ্তি বা দুর্ঘটনার পর কতদিন/ঘন্টা শিশুটি বেচেঁছিল? (Code: 99 = অজানা)</label>
                                        <input value="<?php echo $userInfo->Q5_1_4_D; ?>" id="Q5_1_4_D"  name="Q5_1_4_D" style="width:50%;float:left;" placeholder="দিন" type="text" class="form-control">
                                        <input value="<?php echo $userInfo->Q5_1_4_H; ?>" id="Q5_1_4_H" name="Q5_1_4_H" style="width:50%;float:left;" placeholder="ঘন্টা" type="text" class="form-control">
                                    </div>
                                    <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="form-group col-md-4 Q5_1_3_no_reluctant_unknown">
                                        <label><b>5.1.5</b> শিশুটি কি মৃত্যুর আগে চিকিৎসা পেয়েছিল?</label>
                                        <select id="Q5_1_5" class="form-control" name="Q5_1_5">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q5_1_5 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <h4><b>Note: If died within 48 hours after injury Skip to Q. 8.1 in MEDICAL CONSULTATION</b></h4>
                                </div>
                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <b>VI. PREGNANCY AND DELIVERY HISTORIES</b>
                                </div>
                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="form-group col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <b>6.1</b>
                                    <table class="table table-bordered table-striped">
                                        <tr>
                                            <td colspan="2">গর্ভাবস্থায় মায়ের নিম্মের অসুস্থতাগুলোর কোনটি ছিল কি না জিজ্ঞাসা করুন (একাধিক উত্তর হতে পারে)
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;উচ্চ রক্তচাপ (Hypertension)</td>
                                            <td>
                                                <select id="Q6_1_A" class="form-control" name="Q6_1_A">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q6_1_A == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;হৃদ রোগ (Heart diseases)</td>
                                            <td>
                                                <select id="Q6_1_B" class="form-control" name="Q6_1_B">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q6_1_B == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;ডায়াবেটিস (Diabetes)</td>
                                            <td>
                                                <select id="Q6_1_C" class="form-control" name="Q6_1_C">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q6_1_C == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;যক্ষা (TB)</td>
                                            <td>
                                                <select id="Q6_1_D" class="form-control" name="Q6_1_D">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q6_1_D == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;মৃগীরোগ/খিঁচুনী (Epilepsy/Convulsion)</td>
                                            <td>
                                                <select id="Q6_1_E" class="form-control" name="Q6_1_E">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q6_1_E == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;শরীরের দানা/লালচে গোটা/জ্বর (Rash/Fever) গর্ভাব¯হায়</td>
                                            <td>
                                                <select id="Q6_1_F" class="form-control" name="Q6_1_F">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q6_1_F == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;অন্যান্য রোগ (উল্লেখ করুন)</td>
                                            <td>
                                                <select onchange="showHide(this.id, 'Q6_1_G_off')" class="form-control" id="Q6_1_G" name="Q6_1_G">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) {
                                                        ?>
                                                        <option <?php if ($userInfo->Q6_1_G == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> <?php
                                                        if ($VA_Yes_No_Reluctant_Unknown_single->code == 1)
                                                            echo " id='Q6_1_G_root'";
                                                        else
                                                            echo " id='Q6_1_G_" . $i . "'";
                                                        ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                            <?php
                                                            $i++;
                                                        }
                                                        ?>
                                                </select><br/>
                                                <input value="<?php echo $userInfo->Q6_1_G_OTHER; ?>" <?php if (strlen($userInfo->Q6_1_G_OTHER) > 0 == false) echo " style='display:none;'"; ?> type="text" id="Q6_1_G_off" name="Q6_1_G_OTHER" class="form-control">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="box-footer col-md-12" style="margin-left:20px;margin-right:20px">
                                    <input type="submit" class="btn btn-primary" value="Update">
                                </div>
                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <label><b>6.2.1</b> এই মায়ের কতগুলো জীবিত জন্ম (এই শিশু সহ),মৃত জন্ম এবং গর্ভপাত হয়েছিল?</label>
                                    <br/>
                                </div>
                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <div class="col-md-3 form-group">
                                        <label>
                                            জীবিত সন্তান
                                        </label>
                                        <input value="<?php echo $userInfo->Q6_2_1_A; ?>" type="text" id="Q6_2_1_A" name="Q6_2_1_A" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>মৃত সন্তান</label>
                                        <input value="<?php echo $userInfo->Q6_2_1_B; ?>" type="text" id="Q6_2_1_B" name="Q6_2_1_B" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-group">                     
                                        <label>গর্ভপাত (স্বতঃস্ফুর্তভাবে)</label>    
                                        <input value="<?php echo $userInfo->Q6_2_1_C; ?>" type="text" id="Q6_2_1_C" name="Q6_2_1_C" class="form-control">  

                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>গর্ভপাত/এমআর (উদ্দেশ্য প্রনোদিত)
                                        </label>
                                        <input value="<?php echo $userInfo->Q6_2_1_D; ?>" type="text" id="Q6_2_1_D" name="Q6_2_1_D" class="form-control">
                                    </div>
                                </div>

                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label><b>6.2.2</b> এই মায়ের মোট কয়জন শিশুর (এই শিশু সহ) মৃত্যু হয়েছিল?</label>
                                        <input value="<?php echo $userInfo->Q6_2_2_N; ?>" id="Q6_2_2_N" name="Q6_2_2_N" type="number" min="0" placeholder="সংখ্যা" class="form-control">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label><b>6.2.3</b> মৃত শিশুটির জন্মক্রম (Birth order) সংখ্যা কত ছিল?</label>
                                        <input value="<?php echo $userInfo->Q6_2_3_BIRTH_ORDER; ?>" id="Q6_2_3_BIRTH_ORDER" name="Q6_2_3_BIRTH_ORDER" type="number" placeholder="সংখ্যা" class="form-control">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label><b>6.2.3.1</b>&nbsp;যদি যমজ জন্ম হয়, তাহলে এই শিশুটির জন্মক্রম (Birth order) কত ছিল?</label>
                                        <select id="Q6_2_3_1_BIRTH_ORDER" class="form-control" name="Q6_2_3_1_BIRTH_ORDER">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Birth_Order as $VA_Birth_Order_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_3_1_BIRTH_ORDER == $VA_Birth_Order_single->id) echo ' selected'; ?> value="<?php echo $VA_Birth_Order_single->id; ?>"><?php echo $VA_Birth_Order_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <?php
                                $Q6_2_4_DATE = '';
                                if (!empty($userInfo->Q6_2_4_DATE)) {
                                    $partsRequire = explode('-', $userInfo->Q6_2_4_DATE);
                                    $Q6_2_4_DATE = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];
                                }
                                ?>
                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <div class="form-group col-md-4">
                                        <label><b>6.2.4</b> তার সর্বশেষ মাসিক এর তারিখ (দিন/মাস/বছর)</label>
                                        <input value="<?php if ($userInfo->Q6_2_4_DATE != "0000-00-00") echo $Q6_2_4_DATE; ?>" autocomplete="off" id="Q6_2_4_DATE" name="Q6_2_4_DATE" type="text" class="datepicker form-control">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <br/>
                                        <label><b>6.2.5</b> তিনি (মা) কতমাস যাবৎ গর্ভবর্তী ছিলেন?</label>
                                        <input value="<?php echo $userInfo->Q6_2_5_M; ?>" id="Q6_2_5_M" name="Q6_2_5_M" type="number" min="0" placeholder="মাস" class="form-control">
                                    </div>
                                    <div class="form-group col-md-4"> 
                                        <label><b>6.2.6</b> গর্ভাবস্থা কি সময়ের আগে, ঠিক সময়ে, না বিলম্বে শেষ হয়েছিল?</label>
                                        <select id="Q6_2_6" class="form-control" name="Q6_2_6">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Pregnancy_Ending_Time as $VA_Pregnancy_Ending_Time_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_6 == $VA_Pregnancy_Ending_Time_single->id) echo ' selected'; ?> value="<?php echo $VA_Pregnancy_Ending_Time_single->id; ?>"><?php echo $VA_Pregnancy_Ending_Time_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <div class="form-group col-md-4"> 
                                        <label><b>6.2.6.1</b> EDD এর কত সপ্তাহ আগে শিশুটির জন্ম হয়েছিল?</label>
                                        <select onchange="showHide(this.id, 'Q6_2_6_1_off')" id="Q6_2_6_1" class="form-control" name="Q6_2_6_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                             $i = 1;
                                            foreach ($VA_Related_To_EDD as $VA_Related_To_EDD_single) { ?>
                                                <option <?php
                                                if ($VA_Related_To_EDD_single->code == 1)
                                                    echo " id='Q6_2_6_1_root'";
                                                else
                                                    echo " id='Q6_2_6_1_" . $i . "'";
                                                ?> <?php if ($userInfo->Q6_2_6_1 == $VA_Related_To_EDD_single->id) echo ' selected'; ?> value="<?php echo $VA_Related_To_EDD_single->id; ?>"><?php echo $VA_Related_To_EDD_single->name; ?></option>
                                                <?php ++$i; } ?>
                                        </select><br/>
                                        <input value="<?php if ($userInfo->Q6_2_6_1_week> 0 == true) echo $userInfo->Q6_2_6_1_week; ?>" <?php if ($userInfo->Q6_2_6_1_week> 0 == false) echo " style='display:none'"; ?> type="number" min="1" id="Q6_2_6_1_off" name="Q6_2_6_1_week" class="form-control">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label><b>6.2.7</b> প্রসবের আগে শেষের কয়েকদিন শিশুটি কি পেটে নড়াচড়া করছিল?</label>
                                        <select id="Q6_2_7" class="form-control" name="Q6_2_7">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_7 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4"> 
                                        <label><b>6.2.8</b> আপনি (মা) সর্বশেষ কখন বাচ্চার নড়াচড়া অনুভব করতে পেরেছিলেন?</label>
                                        <select onchange="showHide(this.id, 'Q6_2_8_off')" id="Q6_2_8" class="form-control" name="Q6_2_8">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Baby_Movement_Feeling as $VA_Baby_Movement_Feeling_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q6_2_8 == $VA_Baby_Movement_Feeling_single->id) echo ' selected'; ?>
                                                <?php
                                                if ($VA_Baby_Movement_Feeling_single->code == 1 || $VA_Baby_Movement_Feeling_single->code == 2)
                                                    echo " id='Q6_2_8_root'";
                                                else
                                                    echo " id='Q6_2_8_" . $i . "'";
                                                ?>
                                                    value="<?php echo $VA_Baby_Movement_Feeling_single->id; ?>"><?php echo $VA_Baby_Movement_Feeling_single->name; ?></option>
                                                    <?php
                                                    ++$i;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q6_2_8_DAY_MONTH; ?>" <?php if ($userInfo->Q6_2_8_DAY_MONTH > 0 == false) echo " style='display:none;'"; ?> type="text" id="Q6_2_8_off" name="Q6_2_8_DAY_MONTH" class="form-control">
                                    </div>
                                </div>
                                <div class="box-footer col-md-12" style="margin-left:20px;margin-right:20px">
                                    <input type="submit" class="btn btn-primary" value="Update">
                                </div>
                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <div class="form-group col-md-12">
                                        <b>6.3</b>
                                        <table class="table table-bordered table-striped">
                                            <tr><td colspan="2">মায়ের সর্বশেষ গর্ভাবস্থায় বা প্রসবে মায়ের কি কি জটিলতা হয়েছিল?</td></tr>
                                            <tr><td style="text-align: left;">1. খিঁচুনী (Convulsions)</td>
                                                <td>
                                                    <select id="Q6_3_A" class="form-control" name="Q6_3_A">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_3_A == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">2. রক্তপাত (Antenatal bleeding in 3rd trimester)</td>
                                                <td>
                                                    <select id="Q6_3_B" class="form-control" name="Q6_3_B">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_3_B == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">3. প্রসবপূর্ব বাচ্চার নড়াচড়া বন্ধ/কমে যাওয়া</td>
                                                <td>
                                                    <select id="Q6_3_C" class="form-control" name="Q6_3_C">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_3_C == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">4. গর্ভাবস্থায় জ্বর (Fever/Febrile illness during pregnancy)</td>
                                                <td>
                                                    <select id="Q6_3_D" class="form-control" name="Q6_3_D">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_3_D == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">5. প্রসবকালীন/প্রসবোত্তর অতিরিক্ত রক্তপাত (Excessive bleeding)</td>
                                                <td>
                                                    <select id="Q6_3_E" class="form-control" name="Q6_3_E">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_3_E == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">6. প্রসব ব্যথা শুরুর ১ দিন বা তার আগে পানি ভাঙ্গা</td>
                                                <td>
                                                    <select id="Q6_3_F" class="form-control" name="Q6_3_F">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_3_F == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">7. পানি ভাঙ্গা-পানি বাদামী/সবুজ/হলুদ রংয়ের/দুর্গন্ধযুক্ত</td>
                                                <td>
                                                    <select id="Q6_3_G" class="form-control" name="Q6_3_G">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_3_G == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">8. মারাত্মক রক্তস্বল্পতা</td>
                                                <td>
                                                    <select id="Q6_3_H" class="form-control" name="Q6_3_H">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_3_H == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">9. দীর্ঘায়িত/কষ্টদায়ক প্রসব (২৪ ঘন্টা +)</td>
                                                <td>
                                                    <select id="Q6_3_I" class="form-control" name="Q6_3_I">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_3_I == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">10. উল্টা প্রসব (Breech)</td>
                                                <td>
                                                    <select id="Q6_3_J" class="form-control" name="Q6_3_J">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_3_J == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">11. প্রসবের পূর্বে হাত আগে আসা (Hand prolapse)</td>
                                                <td>
                                                    <select id="Q6_3_K" class="form-control" name="Q6_3_K">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_3_K == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">12. বাচ্চা আড়াআড়ি থাকা (Tranverse lie)</td>
                                                <td>
                                                    <select id="Q6_3_L" class="form-control" name="Q6_3_L">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_3_L == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">13. নাড়ী (Umbilical cord) আগে আসা (প্রসব কালে) </td>
                                                <td>
                                                    <select id="Q6_3_M" class="form-control" name="Q6_3_M">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_3_M == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">14. নাড়ী শিশুর গলায় পেচাঁনো </td>
                                                <td>
                                                    <select id="Q6_3_N" class="form-control" name="Q6_3_N">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_3_N == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">15. পা ফোলা/মুখ ফোলা</td>
                                                <td>
                                                    <select id="Q6_3_O" class="form-control" name="Q6_3_O">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_3_O == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">16. জন্ডিস</td>
                                                <td>
                                                    <select id="Q6_3_P" class="form-control" name="Q6_3_P">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_3_P == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">17. গর্ভাবস্থায় দেখতে ফ্যাকাশে এবং ঘনঘন শ্বাস (উভয়ই) নেওয়া</td>
                                                <td>
                                                    <select id="Q6_3_Q" class="form-control" name="Q6_3_Q">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_3_Q == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">18. গর্ভাবস্থায় মাথা ব্যথা (In 3rd trimester)</td>
                                                <td>
                                                    <select id="Q6_3_R" class="form-control" name="Q6_3_R">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_3_R == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">19. গর্ভাবস্থায় ঝাপসা দেখা (3m)</td>
                                                <td>
                                                    <select id="Q6_3_S" class="form-control" name="Q6_3_S">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_3_S == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">20. যোনী পথে গন্ধযুক্ত সাদা স্রাব নির্গত হওয়া</td>
                                                <td>
                                                    <select id="Q6_3_T" class="form-control" name="Q6_3_T">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_3_T == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">21. মারাত্বক পেটব্যথা (প্রসব ব্যথা নয়)</td>
                                                <td>
                                                    <select id="Q6_3_U" class="form-control" name="Q6_3_U">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_3_U == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">22. প্রসব ব্যথার দিন জ্বর</td>
                                                <td>
                                                    <select id="Q6_3_V" class="form-control" name="Q6_3_V">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_3_V == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">23. অন্যান্য  (উল্লেখ করুন)</td>
                                                <td>
                                                    <select onchange="showHide(this.id, 'Q6_3_W_off')" id="Q6_3_W" class="form-control" name="Q6_3_W">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php
                                                        $i = 1;
                                                        foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) {
                                                            ?>
                                                            <option <?php if ($userInfo->Q6_3_W == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?>
                                                            <?php
                                                            if ($VA_Yes_No_Reluctant_Unknown_single->code == 1)
                                                                echo " id='Q6_3_W_root'";
                                                            else
                                                                echo " id='Q6_3_W_" . $i . "'";
                                                            ?>
                                                                value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                                <?php
                                                                ++$i;
                                                            }
                                                            ?>
                                                    </select>
                                                    <br/>
                                                    <input value="<?php echo $userInfo->Q6_3_W_OTHER; ?>" <?php if (strlen($userInfo->Q6_3_W_OTHER) > 0 == false) echo " style='display:none;'"; ?> type="text" id="Q6_3_W_off" name="Q6_3_W_OTHER" class="form-control">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="box-footer col-md-12" style="margin-left:20px;margin-right:20px">
                                        <input type="submit" class="btn btn-primary" value="Update">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <br/> 
                                        <label><b>6.3.1</b> পানি ভাঙ্গার কত ঘন্টা পর শিশুটি জন্মে ছিল?</label>
                                        <select id="Q6_3_1" class="form-control" name="Q6_3_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Water_Broken as $VA_Water_Broken_single) { ?>
                                                <option <?php if ($userInfo->Q6_3_1 == $VA_Water_Broken_single->id) echo ' selected'; ?> value="<?php echo $VA_Water_Broken_single->id; ?>"><?php echo $VA_Water_Broken_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label><b>6.3.2</b> প্রসব ব্যথা কত ঘন্টা ছিল? (প্রসব ব্যাথা ছিলনা=00)</label>
                                        <input value="<?php echo $userInfo->Q6_3_2; ?>" id="Q6_3_2" name="Q6_3_2" type="text" class="form-control" placeholder="ঘন্টা">
                                    </div>
                                </div>

                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <div class="form-group col-md-4">
                                        <label><b>6.4</b> শিশুটি কি ভাবে ভূমিষ্ট হয়েছিল?</label>
                                        <select id="Q6_4" class="form-control" name="Q6_4">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Delivery_Method as $VA_Delivery_Method_single) { ?>
                                                <option <?php if ($userInfo->Q6_4 == $VA_Delivery_Method_single->id) echo ' selected'; ?> value="<?php echo $VA_Delivery_Method_single->id; ?>"><?php echo $VA_Delivery_Method_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label><b>6.5</b> তার ডেলিভারী কোথায় হয়েছিল?</label>
                                        <select onchange="showHide(this.id, 'Q6_5_off')" id="Q6_5" class="form-control" name="Q6_5">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Delivery_Place as $VA_Delivery_Place_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q6_5 == $VA_Delivery_Place_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Delivery_Place_single->code == 11)
                                                    echo " id='QQ6_5_root'";
                                                else
                                                    echo " id='QQ6_5_" . $i . "'";
                                                ?> value="<?php echo $VA_Delivery_Place_single->id; ?>"><?php echo $VA_Delivery_Place_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select><br/>
                                        <input value="<?php echo $userInfo->Q6_5_OTHER; ?>" <?php if (strlen($userInfo->Q6_5_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q6_5_off" type="text" name="Q6_5_OTHER" class="form-control">
                                    </div>
                                    <div <?php if ($userInfo->Q6_5 == 1650 || $userInfo->Q6_5 == 1659) echo " style='display:none;'" ?> class="form-group col-md-4 Q6_5_1_part">
                                        <label>
                                            <b>6.5.1</b> যদি কোন স্বাস্থ্যসেবা প্রতিষ্ঠানে ডেলিভারী  হয়ে থাকে তা হলে তার নাম ও ঠিকানা লিখুন
                                        </label>
                                        <textarea id="Q6_5_1" name="Q6_5_1" class="form-control"><?php echo $userInfo->Q6_5_1; ?></textarea>
                                    </div>
                                </div>
                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="form-group col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <label>
                                        <b>6.5.2</b> যদি প্রসবকার্য বাড়ীতে/পথিমধ্যে হয়ে থাকে তাহলে প্রধানত কে কে জড়িত ছিল? (একাধিক উত্তর)
                                    </label>
                                    <table class="table table-bordered table-striped">

                                        <tr><td style="text-align: left;">&nbsp;ডাক্তার</td>
                                            <td>
                                                <select id="Q6_5_2_A" class="form-control" name="Q6_5_2_A">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q6_5_2_A == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;নার্স/MW/LFPV/FWV/SACMO/MA</td>
                                            <td>
                                                <select id="Q6_5_2_B" class="form-control" name="Q6_5_2_B">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q6_5_2_B == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;CSBA (FWA/HA trained)</td>
                                            <td>
                                                <select id="Q6_5_2_C" class="form-control" name="Q6_5_2_C">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q6_5_2_C == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;টিবিএ (Trained)</td>
                                            <td>
                                                <select id="Q6_5_2_D" class="form-control" name="Q6_5_2_D">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q6_5_2_D == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;টিবিএ (Untrained)</td>
                                            <td>
                                                <select id="Q6_5_2_E" class="form-control" name="Q6_5_2_E">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q6_5_2_E == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;আত্মীয়/প্রতিবেশী</td>
                                            <td>
                                                <select id="Q6_5_2_F" class="form-control" name="Q6_5_2_F">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q6_5_2_F == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;গ্রাম ডাক্তার/পল্লী চিকিৎসক </td>
                                            <td>
                                                <select id="Q6_5_2_G" class="form-control" name="Q6_5_2_G">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q6_5_2_G == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;কবিরাজ/হাকীম/হোমিওপ্যাথ</td>
                                            <td>
                                                <select id="Q6_5_2_H" class="form-control" name="Q6_5_2_H">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q6_5_2_H == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;ধর্মীয়/আধ্যাত্মীক (ঝাড়-ফুক)</td>
                                            <td>
                                                <select id="Q6_5_2_I" class="form-control" name="Q6_5_2_I">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q6_5_2_I == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;নিজে</td>
                                            <td>
                                                <select id="Q6_5_2_J" class="form-control" name="Q6_5_2_J">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q6_5_2_J == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;অন্যান্য (উল্লেখ করুন)</td>
                                            <td>
                                                <select onchange="showHide(this.id, 'Q6_5_2_K_off')" id="Q6_5_2_K" class="form-control" name="Q6_5_2_K">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) {
                                                        ?>
                                                        <option <?php if ($userInfo->Q6_5_2_K == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?>
                                                        <?php
                                                        if ($VA_Yes_No_Reluctant_Unknown_single->code == 1)
                                                            echo " id='Q6_5_2_K_root'";
                                                        else
                                                            echo " id='Q6_5_2_K_" . $i . "'";
                                                        ?>
                                                            value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                            <?php
                                                            ++$i;
                                                        }
                                                        ?>
                                                </select>
                                                <br/>
                                                <input value="<?php echo $userInfo->Q6_5_2_K_OTHER; ?>" <?php if (strlen($userInfo->Q6_5_2_K_OTHER) > 0 == false) echo " style='display:none;'"; ?> type="text" id="Q6_5_2_K_off" name="Q6_5_2_K_OTHER" class="form-control">
                                            </td>
                                        </tr>
                                    </table>

                                </div>

                                <div class="box-footer col-md-12" style="margin-left:20px;margin-right:20px">
                                    <input type="submit" class="btn btn-primary" value="Update">
                                </div>

                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="form-group col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <label>
                                        <b>6.5.3</b> মহল্লা বা এলাকার নার্স/মিডওয়াইফ ডেলিভারী করালে তার নাম ও ঠিকানা লিখুন।
                                    </label>
                                    <input value="<?php echo $userInfo->Q6_5_3_NAME; ?>" name="Q6_5_3_NAME" type="text" class="form-control" placeholder="নাম">
                                    <br/>
                                    <textarea id="Q6_5_3_ADDRESS" name="Q6_5_3_ADDRESS" placeholder="ঠিকানা" class="form-control"><?php echo $userInfo->Q6_5_3_ADDRESS; ?></textarea>
                                </div>
                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="form-group col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <label><b>6.5.4</b> প্রসব করানোর জন্য কোন বিশেষ ব্যব¯হা/পদ্ধতি ব্যবহার করেছিল কি? (একাধিক উত্তর)</label>
                                    <table class="table table-bordered table-striped">
                                        <tr><td style="text-align: left;">&nbsp;জরায়ুতে হাত ঢুকিয়েছিল</td>
                                            <td>
                                                <select id="Q6_5_4_A" class="form-control" name="Q6_5_4_A">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q6_5_4_A == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;ঔষধ খাইয়েছিল</td>
                                            <td>
                                                <select id="Q6_5_4_B" class="form-control" name="Q6_5_4_B">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q6_5_4_B == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;মাংসে ইনজেকশন দিয়েছিল</td>
                                            <td>
                                                <select id="Q6_5_4_C" class="form-control" name="Q6_5_4_C">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q6_5_4_C == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;শিরায় ইনজেকশন দিয়েছিল</td>
                                            <td>
                                                <select id="Q6_5_4_D" class="form-control" name="Q6_5_4_D">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q6_5_4_D == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;পেটে চাপ দিয়েছিল</td>
                                            <td>
                                                <select id="Q6_5_4_E" class="form-control" name="Q6_5_4_E">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q6_5_4_E == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;মুখে চুলের গোছা দিয়েছিল</td>
                                            <td>
                                                <select id="Q6_5_4_F" class="form-control" name="Q6_5_4_F">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q6_5_4_F == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;হলুদ খাইয়েছিল</td>
                                            <td>
                                                <select id="Q6_5_4_G" class="form-control" name="Q6_5_4_G">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q6_5_4_G == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;ঝাড়ফুঁক করেছিল</td>
                                            <td>
                                                <select id="Q6_5_4_H" class="form-control" name="Q6_5_4_H">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q6_5_4_H == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;কাঁচা ডিম/অন্য পিচ্ছিল কিছু জরায়ুর পথে দিয়েছিল</td>
                                            <td>
                                                <select id="Q6_5_4_I" class="form-control" name="Q6_5_4_I">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q6_5_4_I == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>

                                        <tr><td style="text-align: left;">&nbsp;কোন কিছুর প্রয়োজন হয়নি</td>
                                            <td>
                                                <select id="Q6_5_4_J" class="form-control" name="Q6_5_4_J">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q6_5_4_J == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>

                                        <tr><td style="text-align: left;">&nbsp;অন্যান্য (উল্লেখ করুন)</td>
                                            <td>
                                                <select onchange="showHide(this.id, 'Q6_5_4_K_off')" id="Q6_5_4_K" class="form-control" name="Q6_5_4_K">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) {
                                                        ?>
                                                        <option <?php if ($userInfo->Q6_5_4_K == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?>
                                                        <?php
                                                        if ($VA_Yes_No_Reluctant_Unknown_single->code == 1)
                                                            echo " id='Q6_5_4_K_root'";
                                                        else
                                                            echo " id='Q6_5_4_K_" . $i . "'";
                                                        ?>
                                                            value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                            <?php
                                                            ++$i;
                                                        }
                                                        ?>
                                                </select>
                                                <br/>
                                                <input value="<?php echo $userInfo->Q6_5_4_K_OTHER; ?>" <?php if (strlen($userInfo->Q6_5_4_K_OTHER) > 0 == false) echo " style='display:none;'"; ?> type="text" id="Q6_5_4_K_off" name="Q6_5_4_K_OTHER" class="form-control">
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="box-footer col-md-12" style="margin-left:20px;margin-right:20px">
                                    <input type="submit" class="btn btn-primary" value="Update">
                                </div>
                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <div class="form-group col-md-4">
                                        <label><b>6.5.5</b> মা কি প্রসব পূর্ব সেবা নিয়েছিল?</label>
                                        <select id="Q6_5_5" class="form-control" name="Q6_5_5">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_5_5 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label><b>6.5.6</b> মা কি কি টিকা নিয়েছিল? (Any vaccinations since reaching adulthood and during this pregnancy)</label>
                                        <table class="table table-bordered table-striped">

                                            <tr><td style="text-align: left;">&nbsp;TT</td>
                                                <td>
                                                    <select id="Q6_5_6_A" class="form-control" name="Q6_5_6_A">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_5_6_A == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;HPV</td>
                                                <td>
                                                    <select id="Q6_5_6_B" class="form-control" name="Q6_5_6_B">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_5_6_B == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;Typhoid</td>
                                                <td>
                                                    <select id="Q6_5_6_C" class="form-control" name="Q6_5_6_C">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_5_6_C == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;Hepatitis-B</td>
                                                <td>
                                                    <select id="Q6_5_6_D" class="form-control" name="Q6_5_6_D">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_5_6_D == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;MMR or MR</td>
                                                <td>
                                                    <select id="Q6_5_6_E" class="form-control" name="Q6_5_6_E">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_5_6_E == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;Other specify</td>
                                                <td>
                                                    <select onchange="showHide(this.id, 'Q6_5_6_F_off')" id="Q6_5_6_F" class="form-control" name="Q6_5_6_F">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php
                                                        $i = 1;
                                                        foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) {
                                                            ?>
                                                            <option <?php if ($userInfo->Q6_5_6_F == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?>
                                                            <?php
                                                            if ($VA_Yes_No_Reluctant_Unknown_single->code == 1)
                                                                echo " id='Q6_5_6_F_root'";
                                                            else
                                                                echo " id='Q6_5_6_F_" . $i . "'";
                                                            ?>
                                                                value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                                <?php
                                                                ++$i;
                                                            }
                                                            ?>
                                                    </select>
                                                    <br/>
                                                    <input value="<?php echo $userInfo->Q6_5_6_F_OTHER; ?>" <?php if (strlen($userInfo->Q6_5_6_F_OTHER) > 0 == false) echo " style='display:none;'"; ?> type="text" id="Q6_5_6_F_off" name="Q6_5_6_F_OTHER" class="form-control">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="box-footer col-md-12" style="margin-left:20px;margin-right:20px">
                                    <input type="submit" class="btn btn-primary" value="Update">
                                </div>
                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <b>CONDITIONS OF THE BABY SOON AFTER BIRTH</b>
                                </div>
                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label><b>6.6</b>&nbsp;শিশুটি কি একক বা জমজ না কি দুইয়ের অধিক জন্মে ছিল?</label>
                                        <select id="Q6_6" class="form-control" name="Q6_6">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Baby_Single_Double as $VA_Baby_Single_Double_single) { ?>
                                                <option <?php if ($userInfo->Q6_6 == $VA_Baby_Single_Double_single->id) echo ' selected'; ?> value="<?php echo $VA_Baby_Single_Double_single->id; ?>"><?php echo $VA_Baby_Single_Double_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label><b>6.6.1</b>&nbsp;জন্মের পর বাচ্চাটির গায়ে কি থেঁতলানো বা আঘাতের কালো দাগ/চিহ্ন ছিল?</label>
                                        <select id="Q6_6_1" class="form-control" name="Q6_6_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_6_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label><b>6.6.2</b>&nbsp;বাচ্চাটির চামড়ায় (শরীরে) কোন নরম, ফুলা বা বিবর্ণ এবং চামড়া উঠে যেত কি না?</label>
                                        <table class="table table-bordered table-striped">
                                            <tr><td style="text-align: left;">&nbsp;নরম</td>
                                                <td>
                                                    <select id="Q6_6_2_A" class="form-control" name="Q6_6_2_A">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_6_2_A == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;ফুলা</td>
                                                <td>
                                                    <select id="Q6_6_2_B" class="form-control" name="Q6_6_2_B">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_6_2_B == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;বর্বিণ</td>
                                                <td>
                                                    <select id="Q6_6_2_C" class="form-control" name="Q6_6_2_C">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_6_2_C == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;চামড়া উঠে যাওয়া</td>
                                                <td>
                                                    <select id="Q6_6_2_D" class="form-control" name="Q6_6_2_D">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_6_2_D == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="box-footer col-md-12" style="margin-left:20px;margin-right:20px">
                                    <input type="submit" class="btn btn-primary" value="Update">
                                </div>
                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.6.3</b>&nbsp;জন্মের সময় বাচ্চাটির কি কোন অঙ্গ বিকৃতি ছিল?
                                            (যেমন- ঠোঁট কাটা, পা বাঁকা, খুব ছোট/বড় মাথা,পিছনে ফোলা)
                                        </label>
                                        <select id="Q6_6_3" class="form-control" name="Q6_6_3">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_6_3 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q6_6_3 != 1576) echo " style='display:none;'" ?> class="col-md-4 form-group Q6_6_4_part">
                                        <label>
                                            <b>6.6.4</b>&nbsp;সংক্ষেপে বর্ণনা দিন
                                        </label>
                                        <textarea id="Q6_6_4" name="Q6_6_4" class="form-control" rows="4" style="resize: none;"><?php echo $userInfo->Q6_6_4; ?></textarea>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.6.5</b>&nbsp;জন্ম ওজন (কেজিতে) ৭২ ঘন্টার মধ্যে
                                            (Code: 98 = ওজন নেয়নি, 99 = অজানা)
                                            Note : (স্বাস্থ্যকার্ড দেখে ওজন লিখুন, কার্ড না পেলে মায়ের তথ্য অনুযায়ী লিখুন)
                                        </label>
                                        <input value="<?php echo $userInfo->Q6_6_5; ?>" id="Q6_6_5" name="Q6_6_5" type="number" class="form-control" placeholder="কেজি">
                                    </div>
                                </div>
                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.6.6</b>&nbsp;জন্মের সময় শিশুটির আকার কিরূপ ছিল? (পড়ে শুনান)
                                        </label> 
                                        <select id="Q6_6_6" class="form-control" name="Q6_6_6">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Baby_Weight as $VA_Baby_Weight_single) { ?>
                                                <option <?php if ($userInfo->Q6_6_6 == $VA_Baby_Weight_single->id) echo ' selected'; ?> value="<?php echo $VA_Baby_Weight_single->id; ?>"><?php echo $VA_Baby_Weight_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.6.7</b>&nbsp;জন্মের পর পর শিশুটি কি স্বাভাবিক শ্বাস নিচ্ছিল?
                                        </label>
                                        <select id="Q6_6_7" class="form-control" name="Q6_6_7">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_6_7 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.6.8</b>&nbsp;জন্মের সাথে সাথে শ্বাস-প্রশ্বাস চালুর জন্য কোন ব্যবস্থা নেওয়া হয়েছিল কি?
                                        </label>
                                        <select id="Q6_6_8" class="form-control" name="Q6_6_8">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_6_8 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.6.9</b>&nbsp;জন্মের পর পর সে কি আপনা আপনি কাঁদতে পেরেছিল? (সামান্য চেষ্টা করে কাদাঁনো)
                                        </label>
                                        <select id="Q6_6_9" class="form-control" name="Q6_6_9">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_6_9 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q6_6_9 != 1576) echo " style='display:none;'" ?> class="col-md-4 form-group Q6_6_10_part">
                                        <label>
                                            <b>6.6.10</b>&nbsp;জন্মের কতক্ষন (মিনিট) পরে কেঁদেছিল?<br/>(Code: 99 = অজানা)
                                        </label>
                                        <input value="<?php echo $userInfo->Q6_6_10; ?>" id="Q6_6_10" name="Q6_6_10" type="text" class="form-control" placeholder="মিনিট">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.6.11</b>&nbsp;নাড়ী কাটার ¯হানে কোনকিছু দিয়েছিল কি?
                                        </label>
                                        <select id="Q6_6_11" class="form-control" name="Q6_6_11">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_6_11 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <div <?php if ($userInfo->Q6_6_11 != 1576) echo " style='display:none;'" ?> class="col-md-4 form-group Q6_6_12_part">
                                        <label>
                                            <b>6.6.12</b>&nbsp;কি দিয়েছিল? উল্লেখ করুন:
                                        </label>
                                        <textarea name="Q6_6_12" id="Q6_6_12" class="form-control"><?php echo $userInfo->Q6_6_12; ?></textarea>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.6.13</b>&nbsp;জন্মের পর পর শিশুটির গায়ের বর্ণ কেমন ছিল?
                                        </label> 
                                        <select class="form-control" id="Q6_6_13" name="Q6_6_13">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Baby_Body_Color as $VA_Baby_Body_Color_single) { ?>
                                                <option <?php if ($userInfo->Q6_6_13 == $VA_Baby_Body_Color_single->id) echo ' selected'; ?> value="<?php echo $VA_Baby_Body_Color_single->id; ?>"><?php echo $VA_Baby_Body_Color_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <br/>
                                    <b>VII NEONATAL ILLNESS HISTORY</b>
                                </div>
                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label><b>7.1</b> &nbsp;মারাত্মক অসুখটি শুরু হওয়ার সময় শিশুটির বয়স কত দিন ছিল?</label>
                                        <input value="<?php echo $userInfo->Q7_1; ?>" id="Q7_1" name="Q7_1" type="text" class="form-control" placeholder="দিন">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label><b>7.1.0</b>&nbsp;অসুখটি শুরু হওয়ার আগে শিশুটি কি স্বাভাবিক ভাবে বাড়তেছিল /বড় হচ্ছলি?</label>
                                        <select id="Q7_1_0" class="form-control" name="Q7_1_0">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_1_0 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group clearfix">
                                        <label><b>7.1.1</b>&nbsp;মৃত্যুর আগে শিশুটি কতদিন/ঘন্টা যাবৎ অসুস্থ ছিল?</label>

                                        <input value="<?php echo $userInfo->Q7_1_1_D; ?>" id="Q7_1_1_D" name="Q7_1_1_D" type="text" style="width: 50%;float: left;" class="form-control" placeholder="দিন">

                                        <input value="<?php echo $userInfo->Q7_1_1_H; ?>" id="Q7_1_1_H" name="Q7_1_1_H" type="text" style="width: 50%;float: left;" class="form-control" placeholder="ঘন্টা">

                                    </div>
                                </div>

                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>7.2</b>&nbsp;শেষ অসুস্থতার সময় তার কি খিঁচুনী ছিল?
                                        </label>
                                        <select id="Q7_2" class="form-control" name="Q7_2">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_2 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_2 != 1576) echo " style='display:none;'" ?> class="col-md-4 form-group Q7_2_yes_part">
                                        <label>
                                            <b>7.2.1</b>&nbsp;খিঁচুনীর সময় শরীর শক্ত এবং ধনুকের মত বাঁকা হয়ে যেত কি না?
                                        </label>
                                        <select id="Q7_2_1" class="form-control" name="Q7_2_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_2_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_2 != 1576) echo " style='display:none;'" ?> class="col-md-4 form-group Q7_2_yes_part">
                                        <label>
                                            <b>7.2.2</b>&nbsp;জন্মের কতদিন পর খিঁচুনী শুরুহয়েছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_2_2; ?>" id="Q7_2_2" name="Q7_2_2" type="text" class="form-control" placeholder="দিন">
                                    </div>
                                </div>
                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>7.3</b>&nbsp;সর্বশেষ অসুস্থতার সময় শিশুটি কি অনুভুূতিহীন (Unresponsive) বা অজ্ঞান হয়েছিল?
                                        </label>
                                        <select id="Q7_3" class="form-control" name="Q7_3">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_3 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_3 != 1576) echo " style='display:none;'" ?> class="col-md-4 form-group Q7_3_yes_part">
                                        <label>
                                            <b>7.3a</b>&nbsp;শিশুটি কি জন্মের পর পর ২৪ ঘন্টার মধ্যে অনুভ‚তিহীন বা অজ্ঞান হয়ে গিয়েছিল?
                                        </label>
                                        <select id="Q7_3a" class="form-control" name="Q7_3a">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_3a == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_3 != 1576) echo " style='display:none;'" ?> class="col-md-4 form-group Q7_3_yes_part">
                                        <label>
                                            <b>7.3b</b>&nbsp;শিশুটি কি জন্মের ২৪ ঘন্টা পরে অনূভ‚তিহীন বা অজ্ঞান হয়ে গিয়েছিল?
                                        </label>
                                        <select id="Q7_3b" class="form-control" name="Q7_3b">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_3b == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <div <?php if ($userInfo->Q7_3 != 1576) echo " style='display:none;'" ?> class="col-md-4 form-group Q7_3_yes_part">
                                        <label>
                                            <b>7.3.1</b>&nbsp;জন্মের কতদিন পর শিশুটি অনুভূতিহীন (Unresponsive) বা অজ্ঞান হয়েছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_3_1; ?>" id="Q7_3_1" name="Q7_3_1" type="number" class="form-control" placeholder="দিন">
                                    </div>
                                    <div class="col-md-4 form-group">

                                        <label>
                                            <b>7.4</b>&nbsp;শেষ অসুস্থতার সময় তার মাথার চাঁদি কি ফুলেছিল? বা ডেবে গিয়েছিল?
                                        </label> 
                                        <select id="Q7_4" class="form-control" name="Q7_4">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Pate_Status as $VA_Pate_Status_single) { ?>
                                                <option <?php if ($userInfo->Q7_4 == $VA_Pate_Status_single->id) echo ' selected'; ?> value="<?php echo $VA_Pate_Status_single->id; ?>"><?php echo $VA_Pate_Status_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_4 != 1903) echo " style='display:none;'" ?> class="col-md-4 form-group Q7_4_1_part">
                                        <label>
                                            <b>7.4.1</b>&nbsp;জন্মের কত দিন পর মাথার চাঁদি ফুলে গিয়েছিল?<br/>(Code: 00 = জন্ম থেকে)
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_4_1; ?>" id="Q7_4_1" name="Q7_4_1" type="text" class="form-control" placeholder="দিন">
                                    </div>
                                </div>
                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>7.5</b>&nbsp;সর্বশেষ অসুস্থতার সময় শিশুটির কি কাঁশি ছিল?
                                        </label>
                                        <select id="Q7_5" class="form-control" name="Q7_5">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_5 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_5 != 1576) echo " style='display:none;'" ?> class="col-md-4 form-group Q7_5_yes_part">
                                        <label>
                                            <b>7.5.1</b>&nbsp;জন্মের কতদিন পর থেকে কাঁশি ছিল?<br/>(Code: 99 = অজানা)
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_5_1; ?>" id="Q7_5_1" name="Q7_5_1" type="text" class="form-control" placeholder="দিন">
                                    </div>
                                    <div <?php if ($userInfo->Q7_5 != 1576) echo " style='display:none;'" ?> class="col-md-4 form-group Q7_5_yes_part">
                                        <label>
                                            <b>7.5.2</b>&nbsp;কাশির সময় হুপিং শব্দ (whooping sound) হতো কি না?
                                        </label>
                                        <select id="Q7_5_2" class="form-control" name="Q7_5_2">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Pate_Status as $VA_Pate_Status_single) { ?>
                                                <option <?php if ($userInfo->Q7_5_2 == $VA_Pate_Status_single->id) echo ' selected'; ?> value="<?php echo $VA_Pate_Status_single->id; ?>"><?php echo $VA_Pate_Status_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>7.6</b>&nbsp;সর্বশেষ অসুস্থতার সময় শিশুটি কি ঘন ঘন শ্বাস (Fast Breathing) ফেলত?
                                        </label>
                                        <select id="Q7_6" class="form-control" name="Q7_6">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_6 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_6 != 1576) echo " style='display:none;'" ?> class="col-md-4 form-group Q7_6_yes_part">
                                        <label>
                                            <b>7.6.0</b>&nbsp;ঘন ঘন শ্বাস ফেলা কতদিন স্থায়ী হয়েছিল?<br/>(১ দিনের কম হলে - ০০)
                                        </label>
                                        <select onchange="showHide(this.id, 'Q7_6_0_off')" id="Q7_6_0" class="form-control" name="Q7_6_0">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Frequently_Breathing as $VA_Frequently_Breathing_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q7_6_0 == $VA_Frequently_Breathing_single->id) echo ' selected'; ?>
                                                <?php
                                                if ($VA_Frequently_Breathing_single->code == 1)
                                                    echo " id='Q7_6_0_root'";
                                                else
                                                    echo " id='Q7_6_0_" . $i . "'";
                                                ?>
                                                    value="<?php echo $VA_Frequently_Breathing_single->id; ?>"><?php echo $VA_Frequently_Breathing_single->name; ?></option>
                                                    <?php
                                                    ++$i;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q7_6_0_D; ?>" <?php if ($userInfo->Q7_6_0_D > 0 == false) echo " style='display:none;'"; ?> type="text" id="Q7_6_0_off" name="Q7_6_0_D" class="form-control">
                                    </div>
                                    <div <?php if ($userInfo->Q7_6 != 1576) echo " style='display:none;'" ?> class="col-md-4 form-group Q7_6_yes_part">

                                        <label> <b>7.6.1</b>&nbsp;জন্মের কতদিন/ঘন্টা পর ঘন ঘন শ্বাস ফেলতো?<br/>(Code: 99 = অজানা)</label>
                                        <input value="<?php echo $userInfo->Q7_6_1_D; ?>" id="Q7_6_1_D" name="Q7_6_1_D" type="text" style="width: 50%;" class="form-control col-md-6" placeholder="দিন">
                                        <input value="<?php echo $userInfo->Q7_6_1_H; ?>" id="Q7_6_1_H" name="Q7_6_1_H" type="text" style="width: 50%;" class="form-control col-md-6" placeholder="ঘন্টা">
                                    </div>
                                </div>
                                <div class="box-footer col-md-12" style="margin-left:20px;margin-right:20px">
                                    <input type="submit" class="btn btn-primary" value="Update">
                                </div>
                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>7.7</b>&nbsp;সর্বশেষ অসুস্থতার সময় তার কি শ্বাসকষ্ট (diffcult breathing) হয়েছিল?
                                        </label>
                                        <select id="Q7_7" class="form-control" name="Q7_7">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_7 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_7 != 1576) echo " style='display:none;'" ?> class="col-md-4 form-group Q7_7_yes_part">
                                        <label>
                                            <b>7.7.1</b>&nbsp;জন্মের কত দিন/ঘন্টা পর তার শ্বাসকষ্ট শুরু হয়েছিল?(Code: 99 = অজানা)
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_7_1_D; ?>" id="Q7_7_1_D" name="Q7_7_1_D" type="text" style="width: 50%;float: left;" class="form-control" placeholder="দিন">
                                        <input value="<?php echo $userInfo->Q7_7_1_H; ?>" id="Q7_7_1_H" name="Q7_7_1_H" type="text" style="width: 50%;float: left;" class="form-control" placeholder="ঘন্টা">
                                    </div>
                                    <div <?php if ($userInfo->Q7_7 != 1576) echo " style='display:none;'" ?> class="col-md-4 form-group Q7_7_yes_part">
                                        <label>
                                            <b>7.7.2</b>&nbsp;শ্বাস কষ্ট কতদিন স্থায়ী হয়েছিল?<br/>(১ দিনের কম হলে - ০০)
                                        </label>
                                        <select onchange="showHide(this.id, 'Q7_7_2_off')" id="Q7_7_2" class="form-control" name="Q7_7_2">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Frequently_Breathing as $VA_Frequently_Breathing_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q7_7_2 == $VA_Frequently_Breathing_single->id) echo ' selected'; ?>
                                                <?php
                                                if ($VA_Frequently_Breathing_single->code == 1)
                                                    echo " id='Q7_7_2_root'";
                                                else
                                                    echo " id='Q7_7_2_" . $i . "'";
                                                ?>
                                                    value="<?php echo $VA_Frequently_Breathing_single->id; ?>"><?php echo $VA_Frequently_Breathing_single->name; ?></option>
                                                    <?php
                                                    ++$i;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q7_7_2_D; ?>" <?php if ($userInfo->Q7_7_2 != 1826) echo " style='display:none;'"; ?> type="text" id="Q7_7_2_off" name="Q7_7_2_D" class="form-control">
                                    </div>
                                </div>

                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>7.7.3</b>&nbsp;শিশুটির কি উর্ধ্বশ্বাস (breathlessness) উঠেছিল??
                                        </label>
                                        <select id="Q7_7_3" class="form-control" name="Q7_7_3">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_7_3 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_7_3 != 1576) echo " style='display:none;'" ?> class="col-md-4 form-group Q7_7_4_part">
                                        <label>
                                            <b>7.7.4</b>&nbsp;উর্ধ্বশ্বাস হয়ে থাকলে তা কত  দিন/ঘন্টা স্থায়ী ছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_7_4_D; ?>" id="Q7_7_4_D" name="Q7_7_4_D" type="text" style="width: 50%;float: left;" class="form-control" placeholder="দিন">
                                        <input value="<?php echo $userInfo->Q7_7_4_H; ?>" id="Q7_7_4_H" name="Q7_7_4_H" type="text" style="width: 50%;float: left;" class="form-control" placeholder="ঘন্টা">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <br/>
                                        <label>
                                            <b>7.8</b>&nbsp;সর্বশেষ অসুস্থতার সময় শ্বাস ফেলতে বুকের খাচাঁ বেশী ডেবে (severe chest indrawing) যেত?
                                        </label>
                                        <select id="Q7_8" class="form-control" name="Q7_8">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_8 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>7.9</b>&nbsp;শ্বাস-প্রশ্বাসের সময় তার গলায় ঘোত ঘোত শব্দ/অস্বাভাবিক শব্দ হতো কি? (Grunting/wheezing/stridor)
                                        </label>
                                        <select id="Q7_9" class="form-control" name="Q7_9">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_9 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>7.9.1</b>&nbsp;শিশুটির কি নাসারন্ধ্র/নাকের পাতা কেঁপেছিল?
                                        </label>
                                        <select id="Q7_9_1" class="form-control" name="Q7_9_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_9_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>7.9.2</b>&nbsp;কখনো শিশুটির ক্ষনিকের জন্য শ্বাস থেমে থেমে আবার কি শ্বাস চালু হয়েছিল?
                                        </label>
                                        <select id="Q7_9_2" class="form-control" name="Q7_9_2">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_9_2 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>7.10</b>&nbsp;যে অসুখে সে মারা গেল, সেই সময় কিছুক্ষন স্বাভাবিক থাকার পর কি শিশুটির লাই লাই ভাব (Lethergic) দেখা যেত?
                                        </label>
                                        <select id="Q7_10" class="form-control" name="Q7_10">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_10 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <br/>
                                        <label>
                                            <b>7.11</b>&nbsp;শেষ অসুস্থতার সময় তার কি জ্বর ছিল?
                                        </label>
                                        <select id="Q7_11" class="form-control" name="Q7_11">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_11 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_11 != 1576) echo " style='display:none;'" ?> class="col-md-4 form-group Q7_11_yes_part">
                                        <label>
                                            <b>7.11.1</b>&nbsp;জন্মের কত দিন পর জ্বর শুরু হয়েছিল?<br/>(Code: 99 = অজানা)
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_11_1; ?>" id="Q7_11_1" name="Q7_11_1" type="text" class="form-control" placeholder="দিন">
                                    </div>
                                </div>
                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <div <?php if ($userInfo->Q7_11 != 1576) echo " style='display:none;'" ?> class="col-md-4 form-group Q7_11_yes_part">
                                        <label>
                                            <b>7.11.2</b>&nbsp;কত  দিন/ঘন্টা জ্বর স্থায়ী হয়েছিল?<br/> (Code: 99 = অজানা)
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_11_2_D; ?>" id="Q7_11_2_D" name="Q7_11_2_D" type="text" style="width: 50%;float: left;" class="form-control" placeholder="দিন">
                                        <input value="<?php echo $userInfo->Q7_11_2_H; ?>" id="Q7_11_2_H" name="Q7_11_2_H" type="text" style="width: 50%;float: left;" class="form-control" placeholder="ঘন্টা">
                                    </div>
                                    <div class="col-md-4 form-group">

                                        <label>
                                            <b>7.12</b>&nbsp;শেষ অসুস্থতার সময় বাচ্চার শরীরে হাত দিলে শরীর কি ঠান্ডা মনে হতো?
                                        </label>
                                        <select id="Q7_12" class="form-control" name="Q7_12">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_12 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_12 != 1576) echo " style='display:none;'" ?> class="col-md-4 form-group Q7_12_yes_part">
                                        <label>
                                            <b>7.12.1</b>&nbsp;মৃত্যুর কত দিন/ঘন্টা আগে থেকে শরীর ঠান্ডা ছিল? (Code: 99 = অজানা)
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_12_1_D; ?>" id="Q7_12_1_D" name="Q7_12_1_D" type="number" style="width: 50%;float: left;" class="form-control" placeholder="দিন">
                                        <input value="<?php echo $userInfo->Q7_12_1_H; ?>" id="Q7_12_1_H" name="Q7_12_1_H" type="number" style="width: 50%;float: left;" class="form-control" placeholder="ঘন্টা">
                                    </div>
                                </div>
                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <div <?php if ($userInfo->Q7_12 != 1576) echo " style='display:none;'" ?> class="col-md-4 form-group Q7_12_yes_part">
                                        <label>
                                            <b>7.12.2</b>&nbsp;কত দিন(দিন/ঘন্টা) বয়সে শরীর ঠান্ডা হওয়া শুরু হয়েছিল?
                                        </label>
                                        <select id="Q7_12_2" class="form-control" name="Q7_12_2">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Frequently_Breathing as $VA_Frequently_Breathing_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q7_12_2 == $VA_Frequently_Breathing_single->id) echo ' selected'; ?>
                                                <?php
                                                echo " id='Q7_12_2_" . $i . "'";
                                                ?>
                                                    value="<?php echo $VA_Frequently_Breathing_single->id; ?>"><?php echo $VA_Frequently_Breathing_single->name; ?></option>
                                                    <?php
                                                    ++$i;
                                                }
                                                ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_12_2 != 1908) echo " style='display:none;'" ?> class="col-md-4 form-group Q7_12_2_day_part">
                                        <input value="<?php echo $userInfo->Q7_12_2_D; ?>" id="Q7_12_2_D" name="Q7_12_2_D" type="text" class="form-control" placeholder="দিন">
                                        <br/>
                                        <input value="<?php echo $userInfo->Q7_12_2_H; ?>" id="Q7_12_2_H" name="Q7_12_2_H" type="text" class="form-control" placeholder="ঘন্টা">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>7.13</b>&nbsp;শিশুটির কান থেকে কি পুঁজ বের হতো?
                                        </label>
                                        <select id="Q7_13" class="form-control" name="Q7_13">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_13 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="box-footer col-md-12" style="margin-left:20px;margin-right:20px">
                                    <input type="submit" class="btn btn-primary" value="Update">
                                </div>

                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>7.14</b>&nbsp;সে কি কাঁদা বন্ধ করে দিয়েছিল?
                                        </label> 
                                        <select id="Q7_14" class="form-control" name="Q7_14">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Baby_Cry as $VA_Baby_Cry_single) { ?>
                                                <option <?php if ($userInfo->Q7_14 == $VA_Baby_Cry_single->id) echo ' selected'; ?> value="<?php echo $VA_Baby_Cry_single->id; ?>"><?php echo $VA_Baby_Cry_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_14 != 1911) echo " style='display:none;'" ?> class="col-md-4 form-group Q7_14_1_part">
                                        <label>
                                            <b>7.14.1</b>&nbsp;মৃত্যুর কতক্ষণ(দিন) আগে কাঁদা বন্ধ করে দিয়েছিল?<br/>(Code: 99 = অজানা)
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_14_1; ?>" id="Q7_14_1" name="Q7_14_1" type="number" class="form-control" placeholder="দিন">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>7.15</b>&nbsp;জন্মের পর শিশুটি কি স্বাভাবিক ভাবে বুকের দুধ/বোতলের দুধ পান বন্ধ করে দিয়েছিলো?
                                        </label> 
                                        <select id="Q7_15" class="form-control" name="Q7_15">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Baby_Milk as $VA_Baby_Milk_single) { ?>
                                                <option <?php if ($userInfo->Q7_15 == $VA_Baby_Milk_single->id) echo ' selected'; ?> value="<?php echo $VA_Baby_Milk_single->id; ?>"><?php echo $VA_Baby_Milk_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <div <?php if ($userInfo->Q7_15 != 1916) echo " style='display:none;'" ?> class="col-md-4 form-group Q7_15_1_part Q7_15_1_option_3_hide_part">
                                        <label>
                                            <b>7.15.1</b>&nbsp;দুধপান বন্ধ হলে বাচ্চাটি কি তার মুখ খুলতে পেরেছিল?
                                        </label>
                                        <select id="Q7_15_1" class="form-control" name="Q7_15_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_15_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_15== 1918) echo " style='display:none;'" ?> class="col-md-4 form-group Q7_15_1_option_3_hide_part">
                                        <label>
                                            <b>7.15.2</b>&nbsp;জন্মের কতক্ষন(দিন/ঘন্টা) পর শিশুটি শুধু বুকের/বোতলের দুধপান করেছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_15_2_D; ?>" id="Q7_15_2_D" name="Q7_15_2_D" type="text" style="width: 50%;float: left;" class="form-control" placeholder="দিন">
                                        <input value="<?php echo $userInfo->Q7_15_2_H; ?>" id="Q7_15_2_H" name="Q7_15_2_H" type="text" style="width: 50%;float: left;" class="form-control" placeholder="ঘন্টা">
                                    </div>
                                    <div <?php if ($userInfo->Q7_15== 1918) echo " style='display:none;'" ?> class="col-md-4 form-group Q7_15_1_option_3_hide_part">
                                        <label>
                                            <b>7.15.3</b>&nbsp;জন্মের কতদিন পর শিশুটি দুধ পান বন্ধ করে দিয়েছিল? (Code: 99 = অজানা)
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_15_3; ?>" id="Q7_15_3" name="Q7_15_3" type="number" class="form-control" placeholder="দিন">
                                    </div>
                                </div>
                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <div <?php if ($userInfo->Q7_15== 1918) echo " style='display:none;'" ?> class="col-md-4 form-group Q7_15_1_option_3_hide_part">
                                        <label>
                                            <b>7.15.4</b>&nbsp;বাচ্চাটি মৃত্যুর কতক্ষন আগে দুধপান বন্ধ করে দিয়েছিল?
                                        </label> 
                                        <select id="Q7_15_4" class="form-control" name="Q7_15_4">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Baby_Drinking_Milk_Shut_Down as $VA_Baby_Drinking_Milk_Shut_Down_single) { ?>
                                                <option <?php if ($userInfo->Q7_15_4 == $VA_Baby_Drinking_Milk_Shut_Down_single->id) echo ' selected'; ?> value="<?php echo $VA_Baby_Drinking_Milk_Shut_Down_single->id; ?>"><?php echo $VA_Baby_Drinking_Milk_Shut_Down_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_15== 1918) echo " style='display:none;'" ?> class="col-md-4 form-group Q7_15_1_option_3_hide_part">
                                        <label>
                                            <b>7.15.5</b>&nbsp;শিশুটি কি শুধু বুকের দুধ পান করেছিল(ORS বা ঔষধ সহ)?
                                        </label>
                                        <select id="Q7_15_5" class="form-control" name="Q7_15_5">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_15_5 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>7.16</b>&nbsp;শেষ অসুস্থতার সময় কি তার হাতের তালু বা পায়ের তলা/চামড়া হলুদ বর্ণের হয়ে গিয়েছিল?
                                        </label>
                                        <select id="Q7_16" class="form-control" name="Q7_16">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_16 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <div <?php if ($userInfo->Q7_16 != 1576) echo " style='display:none;'" ?> class="col-md-4 form-group Q7_16_yes_part">
                                        <label>
                                            <b>7.16.1</b>&nbsp;জন্মের কতদিন পর শিশুটি দুধ পান বন্ধ করে দিয়েছিল? (Code: 99 = অজানা)
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_16_1; ?>" id="Q7_16_1" name="Q7_16_1" type="number" class="form-control" placeholder="দিন">
                                    </div>
                                    <div <?php if ($userInfo->Q7_16 != 1576) echo " style='display:none;'" ?> class="col-md-4 form-group Q7_16_yes_part">
                                        <label>
                                            <b>7.16.2</b>&nbsp;কতদিন যাবৎ হাতের তালু বা পায়ের তলা হলদে হয়েছিল?(Code: 99 = অজানা)
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_16_2; ?>" id="Q7_16_2" name="Q7_16_2" type="number" class="form-control" placeholder="দিন">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>7.17</b>&nbsp;সর্বশেষ অসু¯হতার সময় তার চক্ষুদ্বয় হলুদ হয়ে গিয়েছিল কি?
                                        </label>
                                        <select id="Q7_17" class="form-control" name="Q7_17">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_16 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>7.18</b>&nbsp;শেষ অসুস্থতার সময় কি তার নাভী লাল হয়েছিল বা নাভী দিয়ে পূঁজ পড়ত?
                                        </label>
                                        <select id="Q7_18" class="form-control" name="Q7_18">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_18 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>7.18.0</b>&nbsp;শিশুটির গায়ে কোন দানা (rash) উঠেছিল?
                                        </label>
                                        <select id="Q7_18_0" class="form-control" name="Q7_18_0">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_18_0 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>7.18.1</b>&nbsp;নাভীরজ্জুর এই রক্তিম ভাব পেটের চামড়া পর্যন্ত ছড়িয়েছিল?
                                        </label>
                                        <select id="Q7_18_1" class="form-control" name="Q7_18_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_18_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>7.18.2</b>&nbsp;সর্বশেষ অসুখের সময় শিশুটির শরীরে কোন ক্ষত [Ulcers(pits)] ছিল?
                                        </label> 
                                        <select id="Q7_18_2" class="form-control" name="Q7_18_2">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Leg_Wound as $VA_Leg_Wound_single) { ?>
                                                <option <?php if ($userInfo->Q7_18_2 == $VA_Leg_Wound_single->id) echo ' selected'; ?> value="<?php echo $VA_Leg_Wound_single->id; ?>"><?php echo $VA_Leg_Wound_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>7.18.3</b>&nbsp;যে অসুখে সে মারা গেল, সেই সময় শিশুটির চামড়ার কোন অংশ লাল হয়ে ফুলে ছিল কিনা ?
                                        </label>
                                        <select id="Q7_18_3" class="form-control" name="Q7_18_3">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_18_3 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>7.18.4</b>&nbsp;সর্বশেষ অসুখের সময় চামড়ার কিছু অংশ কাল হয়ে গিয়েছিল কি না?
                                        </label>
                                        <select id="Q7_18_4" class="form-control" name="Q7_18_4">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_18_4 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>7.19</b>&nbsp;শেষ অসুস্থতার সময় কি চামড়ায় ফোসকা বা পুঁজভর্তি গোটা হয়েছিল?
                                        </label>
                                        <select id="Q7_19" class="form-control" name="Q7_19">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_19 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>7.20</b>&nbsp;শেষ অসুস্থতার সময় তার শরীরের কোন স্থান হতে রক্তপাত হয়েছিল কি?
                                        </label>
                                        <select id="Q7_20" class="form-control" name="Q7_20">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_20 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_20 != 1576) echo " style='display:none;'" ?> class="col-md-4 form-group Q7_20_1_part">
                                        <label>
                                            <b>7.20.1</b>&nbsp; কোথা থেকে? (একাধিক উত্তর হতে পারে)
                                        </label>
                                        <table class="table table-bordered table-striped">
                                            <tr><td style="text-align: left;">&nbsp;মুখ</td>
                                                <td>
                                                    <select id="Q7_20_1_A" class="form-control" name="Q7_20_1_A">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q7_20_1_A == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;নাক</td>
                                                <td>
                                                    <select id="Q7_20_1_B" class="form-control" name="Q7_20_1_B">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q7_20_1_B == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;নাভী</td>
                                                <td>
                                                    <select id="Q7_20_1_C" class="form-control" name="Q7_20_1_C">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q7_20_1_C == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;পায়ুপথ</td>
                                                <td>
                                                    <select id="Q7_20_1_D" class="form-control" name="Q7_20_1_D">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q7_20_1_D == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;অন্যান্য উল্লেখ করুন</td>
                                                <td>
                                                    <select onchange="showHide(this.id, 'Q7_20_1_E_off')" class="form-control" id="Q7_20_1_E" name="Q7_20_1_E">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php
                                                        $i = 1;
                                                        foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) {
                                                            ?>
                                                            <option <?php if ($userInfo->Q7_20_1_E == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> <?php
                                                            if ($VA_Yes_No_Reluctant_Unknown_single->code == 1)
                                                                echo " id='Q7_20_1_E_root'";
                                                            else
                                                                echo " id='Q7_20_1_E_" . $i . "'";
                                                            ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                                <?php
                                                                $i++;
                                                            }
                                                            ?>
                                                    </select><br/>
                                                    <input value="<?php echo $userInfo->Q7_20_1_E_OTHER; ?>" <?php if (strlen($userInfo->Q7_20_1_E_OTHER) > 0 == false) echo " style='display:none;'"; ?> type="text" id="Q7_20_1_E_off" name="Q7_20_1_E_OTHER" class="form-control">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="box-footer col-md-12" style="margin-left:20px;margin-right:20px">
                                    <input type="submit" class="btn btn-primary" value="Update">
                                </div>

                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label> 
                                            <b>7.21</b>&nbsp;সর্বশেষ অসুস্থতার সময় তার কি ডায়রিয়া (ঘন ঘন পাতলা পায়খানা)/আমাশয় হয়েছিল?
                                        </label>
                                        <select id="Q7_21" class="form-control" name="Q7_21">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Diarrhea_Situation as $VA_Diarrhea_Situation_single) { ?>
                                                <option <?php if ($userInfo->Q7_21 == $VA_Diarrhea_Situation_single->id) echo ' selected'; ?> value="<?php echo $VA_Diarrhea_Situation_single->id; ?>"><?php echo $VA_Diarrhea_Situation_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_21 != 1926) echo " style='display:none;'" ?> class="col-md-4 form-group Q7_21_yes_part">
                                        <label>
                                            <b>7.21.1</b>&nbsp;ডায়রিয়া কতদিন স্থায়ী হয়েছিল? (Code: 99 = অজানা)
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_21_1; ?>" id="Q7_21_1" name="Q7_21_1" type="number" class="form-control" placeholder="দিন">
                                    </div>
                                    <div <?php if ($userInfo->Q7_21 != 1926) echo " style='display:none;'" ?> class="col-md-4 form-group Q7_21_yes_part">
                                        <label>
                                            <b>7.21.2</b>&nbsp;ডায়রিয়া যখন মারাত্মক ছিল সর্বোচ্চ কতবার পায়খানা হয়েছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_21_2; ?>" id="Q7_21_2" name="Q7_21_2" type="number" class="form-control" placeholder="বার">
                                    </div>
                                </div>
                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <div <?php if ($userInfo->Q7_21 != 1926) echo " style='display:none;'" ?> class="col-md-4 form-group Q7_21_yes_part">
                                        <label>
                                            <b>7.21.3</b>&nbsp;পায়খানার সাথে রক্ত যেত কি?
                                        </label>
                                        <select id="Q7_21_3" class="form-control" name="Q7_21_3">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_21_3 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>7.22</b>&nbsp;শেষ অসুস্থতার সময় তার কি বমি হয়েছিল?
                                        </label>
                                        <select id="Q7_22" class="form-control" name="Q7_22">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_22 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div <?php if ($userInfo->Q7_22 != 1576) echo " style='display:none;'" ?> class="col-md-4 form-group Q7_22_yes_part">
                                        <label> 
                                            <b>7.22.1</b>&nbsp;যদি বমি করে তাহলে বমির রং কি ছিল?
                                        </label>
                                        <select id="Q7_22_1" class="form-control" name="Q7_22_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Baby_Vomit_Looks_Like as $VA_Baby_Vomit_Looks_Like_single) { ?>
                                                <option <?php if ($userInfo->Q7_22_1 == $VA_Baby_Vomit_Looks_Like_single->id) echo ' selected'; ?> value="<?php echo $VA_Baby_Vomit_Looks_Like_single->id; ?>"><?php echo $VA_Baby_Vomit_Looks_Like_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <div <?php if ($userInfo->Q7_22 != 1576) echo " style='display:none;'" ?> class="col-md-4 form-group Q7_22_yes_part">
                                        <label>
                                            <b>7.22.2</b>&nbsp;জন্মের কতদিন পর বমি করা শুরু হয়েছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_22_2; ?>" id="Q7_22_2" name="Q7_22_2" type="text" class="form-control" placeholder="দিন">
                                    </div>
                                    <div <?php if ($userInfo->Q7_22 != 1576) echo " style='display:none;'" ?> class="col-md-4 form-group Q7_22_yes_part">
                                        <label>
                                            <b>7.22.3</b>&nbsp;বমি করা যখন মারাত্বক ছিল, সর্বোচ্চ কতবার বমি করেছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_22_3; ?>" id="Q7_22_3" name="Q7_22_3" type="text" class="form-control" placeholder="বার">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>7.23</b>&nbsp;সর্বশেষ অসুস্থতার সময় তার কি পেট ফেঁপে/ফুলে গিয়েছিল?
                                        </label>
                                        <select id="Q7_23" class="form-control" name="Q7_23">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_23 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="box-footer col-md-12" style="margin-left:20px;margin-right:20px">
                                    <input type="submit" class="btn btn-primary" value="Update">
                                </div>

                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <div <?php if ($userInfo->Q7_23 != 1576) echo " style='display:none;'" ?> class="col-md-4 form-group Q7_23_1_part">
                                        <label>
                                            <b>7.23.1</b>&nbsp;কতদিন/ঘন্টা ধরে এই পেট ফাঁপা/ফোলা ছিল? <br/>(Code: 99 = অজানা)
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_23_1_D; ?>" id="Q7_23_1_D" name="Q7_23_1_D" type="text" style="width: 50%;float: left;" class="form-control" placeholder="দিন">
                                        <input value="<?php echo $userInfo->Q7_23_1_H; ?>" id="Q7_23_1_H" name="Q7_23_1_H" type="text" style="width: 50%;float: left;" class="form-control" placeholder="ঘন্টা">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>7.24</b>&nbsp;মৃত্যুর আগে শিশুটির শরীরে কোন অপারেশন করা হয়েছিল কি?
                                        </label>
                                        <select id="Q7_24" class="form-control" name="Q7_24">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_24 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_24 != 1576) echo " style='display:none;'" ?> class="col-md-4 form-group Q7_24_yes_part">
                                        <label>
                                            <b>7.24.1</b>&nbsp;মৃত্যুর কতদিন আগে শিশুটির শরীরে অপারেশন করা হয়েছিল? (Code: 99 = অজানা)
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_24_1; ?>" id="Q7_24_1" name="Q7_24_1" type="text" class="form-control" placeholder="দিন">
                                    </div>
                                </div>

                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <div <?php if ($userInfo->Q7_24 != 1576) echo " style='display:none;'" ?> class="col-md-4 form-group Q7_24_yes_part">
                                        <label>
                                            <b>7.24.2</b>&nbsp;শরীরের কোন স্থানে অপারেশন করা হয়েছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_24_2; ?>" id="Q7_24_2" name="Q7_24_2" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>7.25</b>&nbsp;শিশুটিকে কি সুস্থ দেখাচ্ছিল তার পর হঠাৎ করে মারা গেল?
                                        </label>
                                        <select id="Q7_25" class="form-control" name="Q7_25">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_25 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="box-footer col-md-12" style="margin-left:20px;margin-right:20px">
                                    <input type="submit" class="btn btn-primary" value="Update">
                                </div>

                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <br/>
                                    <b>VIII MEDICAL CONSULTATIONS</b>
                                </div>
                                <div <?php if ($userInfo->Q5_1_3 == 1576) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown">
                                    <div class="col-md-6 form-group">
                                        <label>
                                            <b>8.0</b>&nbsp;শিশুটিকে কোন টীকা দেয়া হয়েছিল? According to vacccionation card
                                        </label>
                                        <table class="table table-bordered table-striped">
                                            <tr><td style="text-align: left;">&nbsp;BCG</td>
                                                <td>
                                                    <select id="Q8_0_A" class="form-control" name="Q8_0_A">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q8_0_A == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;OPV</td>
                                                <td>
                                                    <select id="Q8_0_B" class="form-control" name="Q8_0_B">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q8_0_B == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;Hepatitis-B</td>
                                                <td>
                                                    <select id="Q8_0_C" class="form-control" name="Q8_0_C">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q8_0_C == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>8.1</b>&nbsp;যে অসুস্থতার জন্য শিশুটি মারা গিয়েছিল, সে অসুখের কোন চিকিৎসা হয়েছিল কি?
                                        </label>
                                        <select id="Q8_1" class="form-control" name="Q8_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q8_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="box-footer col-md-12" style="margin-left:20px;margin-right:20px">
                                    <input type="submit" class="btn btn-primary" value="Update">
                                </div>
                                <div <?php if ($userInfo->Q5_1_3 == 1576 || $userInfo->Q8_1 == 1577 || $userInfo->Q8_1 == 1578 || $userInfo->Q8_1 == 1579) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown Q8_1_yes_part">
                                    <label>
                                        8.1.1 &nbsp;শিশুটির মৃত্যুকালীন অসুস্থতার সময় কে কে তার চিকিৎসা করেছিলেন?
                                        নির্দেশাবলী: উত্তরদাতার উত্তর দেওয়া শেষ হওয়ার সাথে সাথে জিজ্ঞাসা করুন: আর কোথাও থেকে চিকিৎসা নিয়েছিল কি?
                                        জিজ্ঞাসা করতে থাকুন, যতক্ষন না পর্যন্ত উত্তরদাতা বলেন যে, আর কোথাও থেকে চিকিৎসা নেয়নি।
                                    </label>
                                </div>
                                <div <?php if ($userInfo->Q5_1_3 == 1576 || $userInfo->Q8_1 == 1577 || $userInfo->Q8_1 == 1578 || $userInfo->Q8_1 == 1579) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown Q8_1_yes_part">
                                    <div class="col-md-3 form-group">
                                        <label>
                                            a. 1st Provider
                                        </label>
                                        <select onchange="showHide(this.id, 'Q8_1_1_A_off')" name="Q8_1_1_A" class="form-control" id="Q8_1_1_A">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Treatment_Provider as $VA_Treatment_Provider_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q8_1_1_A == $VA_Treatment_Provider_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Treatment_Provider_single->code == 11)
                                                    echo " id='Q8_1_1_A_root'";
                                                else
                                                    echo " id='Q8_1_1_A_" . $i . "'";
                                                ?> value="<?php echo $VA_Treatment_Provider_single->id; ?>"><?php echo $VA_Treatment_Provider_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q8_1_1_A_OTHER; ?>" <?php if (strlen($userInfo->Q8_1_1_A_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q8_1_1_A_off" type="text" name="Q8_1_1_A_OTHER" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>
                                            b. 2nd Provider
                                        </label>

                                        <select onchange="showHide(this.id, 'Q8_1_1_B_off')" name="Q8_1_1_B" class="form-control" id="Q8_1_1_B">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Treatment_Provider as $VA_Treatment_Provider_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q8_1_1_B == $VA_Treatment_Provider_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Treatment_Provider_single->code == 11)
                                                    echo " id='Q8_1_1_B_root'";
                                                else
                                                    echo " id='Q8_1_1_B_" . $i . "'";
                                                ?> value="<?php echo $VA_Treatment_Provider_single->id; ?>"><?php echo $VA_Treatment_Provider_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q8_1_1_B_OTHER; ?>" <?php if (strlen($userInfo->Q8_1_1_B_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q8_1_1_B_off" type="text" name="Q8_1_1_B_OTHER" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>
                                            c. 3rd Provider
                                        </label>
                                        <select onchange="showHide(this.id, 'Q8_1_1_C_off')" name="Q8_1_1_C" class="form-control" id="Q8_1_1_C">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Treatment_Provider as $VA_Treatment_Provider_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q8_1_1_C == $VA_Treatment_Provider_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Treatment_Provider_single->code == 11)
                                                    echo " id='Q8_1_1_C_root'";
                                                else
                                                    echo " id='Q8_1_1_C_" . $i . "'";
                                                ?> value="<?php echo $VA_Treatment_Provider_single->id; ?>"><?php echo $VA_Treatment_Provider_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q8_1_1_C_OTHER; ?>" <?php if (strlen($userInfo->Q8_1_1_C_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q8_1_1_C_off" type="text" name="Q8_1_1_C_OTHER" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>
                                            d. 4th/last Provider
                                        </label>
                                        <select onchange="showHide(this.id, 'Q8_1_1_D_off')" name="Q8_1_1_D" class="form-control" id="Q8_1_1_D">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Treatment_Provider as $VA_Treatment_Provider_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q8_1_1_D == $VA_Treatment_Provider_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Treatment_Provider_single->code == 11)
                                                    echo " id='Q8_1_1_D_root'";
                                                else
                                                    echo " id='Q8_1_1_D_" . $i . "'";
                                                ?> value="<?php echo $VA_Treatment_Provider_single->id; ?>"><?php echo $VA_Treatment_Provider_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q8_1_1_D_OTHER; ?>" <?php if (strlen($userInfo->Q8_1_1_D_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q8_1_1_D_off" type="text" name="Q8_1_1_D_OTHER" class="form-control">
                                    </div>
                                </div>

                                <div <?php if ($userInfo->Q5_1_3 == 1576 || $userInfo->Q8_1 == 1577 || $userInfo->Q8_1 == 1578 || $userInfo->Q8_1 == 1579) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown Q8_1_yes_part">
                                    <div class="col-md-4 form-group">
                                        <label><b>8.1.2</b>&nbsp;সর্বশেষ অসুখের সময় আপনি শিশুটিকে কোথায় চিকিৎসার জন্য নিয়েছিলেন?(একাধিক উত্তর হতে পারে)</label>
                                        <select onchange="showHide(this.id, 'Q8_1_2_off')" id="Q8_1_2" class="form-control" name="Q8_1_2">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Delivery_Place as $VA_Delivery_Place_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q8_1_2 == $VA_Delivery_Place_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Delivery_Place_single->code == 11)
                                                    echo " id='Q8_1_2_root'";
                                                else
                                                    echo " id='Q8_1_2_" . $i . "'";
                                                ?> value="<?php echo $VA_Delivery_Place_single->id; ?>"><?php echo $VA_Delivery_Place_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select><br/>
                                        <input value="<?php echo $userInfo->Q8_1_2_OTHER; ?>" <?php if (strlen($userInfo->Q8_1_2_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q8_1_2_off" type="text" name="Q8_1_2_OTHER" class="form-control">
                                    </div>
                                    <div <?php if ($userInfo->Q8_1_2 == 1938) echo " style='display:none;'" ?> class="col-md-12 form-group Q8_1_2_NoWhereTaken_part">
                                        <label>
                                            <b>8.1.3</b>
                                            &nbsp;কি ধরনের চিকিৎসা পেয়েছিল?
                                        </label>
                                        <table class="table table-bordered table-striped">
                                            <tr><td style="text-align: left;">&nbsp;Antiretroviral therapy for HIV(ART drug)</td>
                                                <td>
                                                    <select id="Q8_1_3_A" class="form-control" name="Q8_1_3_A">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q8_1_3_A == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;ORS</td>
                                                <td>
                                                    <select id="Q8_1_3_B" class="form-control" name="Q8_1_3_B">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q8_1_3_B == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;I/V Fluid</td>
                                                <td>
                                                    <select id="Q8_1_3_C" class="form-control" name="Q8_1_3_C">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q8_1_3_C == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;রক্ত সঞ্চালন</td>
                                                <td>
                                                    <select id="Q8_1_3_D" class="form-control" name="Q8_1_3_D">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q8_1_3_D == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;নাকের ভিতর টিউব দিয়ে চিকিৎসা বা খাওয়ানো</td>
                                                <td>
                                                    <select id="Q8_1_3_E" class="form-control" name="Q8_1_3_E">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q8_1_3_E == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;এন্টিবায়োটি ইনজেকশন</td>
                                                <td>
                                                    <select id="Q8_1_3_F" class="form-control" name="Q8_1_3_F">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q8_1_3_F == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;অন্যান্য চিকিৎসা</td>
                                                <td>
                                                    <select onchange="showHide(this.id, 'Q8_1_3_G_off')" id="Q8_1_3_G" class="form-control" name="Q8_1_3_G">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php
                                                        $i = 1;
                                                        foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) {
                                                            ?>
                                                            <option <?php if ($userInfo->Q8_1_3_G == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> <?php
                                                            if ($VA_Yes_No_Reluctant_Unknown_single->code == 1)
                                                                echo " id='Q8_1_3_G_root'";
                                                            else
                                                                echo " id='Q8_1_3_G_" . $i . "'";
                                                            ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                                <?php
                                                                $i++;
                                                            }
                                                            ?>
                                                    </select><br/>
                                                    <input value="<?php echo $userInfo->Q8_1_3_G_OTHER; ?>" <?php if (strlen($userInfo->Q8_1_3_G_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q8_1_3_G_off" type="text" name="Q8_1_3_G_OTHER" class="form-control">
                                                </td>
                                            </tr>
                                            <tr><td colspan="2"><b>Note:</b>  বাড়ীতে চিকিৎসা হলে (Skip to 8.3)</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div <?php if ($userInfo->Q5_1_3 == 1576 || $userInfo->Q8_1_2 == 1938 || $userInfo->Q8_1 == 1577 || $userInfo->Q8_1 == 1578 || $userInfo->Q8_1 == 1579) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown Q8_1_yes_part Q8_1_2_NoWhereTaken_part">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>8.1.4</b>&nbsp;স্বাস্থ্য সেবা প্রতিষ্ঠানে যেতে মোটরযান ব্যবহার করা হয়েছিল?
                                        </label>
                                        <select id="Q8_1_4" class="form-control" name="Q8_1_4">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q8_1_4 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>8.2</b>&nbsp;মৃত্যুর আগে শিশুটিকে হাসপাতালে/ক্লিনিকে ভর্তি করানো হয়েছিল কি?
                                        </label>
                                        <select id="Q8_2" class="form-control" name="Q8_2">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q8_2 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <?php
                                $Q8_2_1_DATE_ADMISSION_1 = '';
                                $Q8_2_1_DATE_ADMISSION_2 = '';
                                $Q8_2_1_DATE_ADMISSION_3 = '';
                                if (!empty($userInfo->Q8_2_1_DATE_ADMISSION_1)) {

                                    $partsRequire = explode('-', $userInfo->Q8_2_1_DATE_ADMISSION_1);
                                    $Q8_2_1_DATE_ADMISSION_1 = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];
                                }
                                if (!empty($userInfo->Q8_2_1_DATE_ADMISSION_2)) {
                                    $partsRequire = explode('-', $userInfo->Q8_2_1_DATE_ADMISSION_2);
                                    $Q8_2_1_DATE_ADMISSION_2 = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];
                                }
                                if (!empty($userInfo->Q8_2_1_DATE_ADMISSION_3)) {
                                    $partsRequire = explode('-', $userInfo->Q8_2_1_DATE_ADMISSION_3);
                                    $Q8_2_1_DATE_ADMISSION_3 = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];
                                }
                                ?>
                                <div <?php if ($userInfo->Q5_1_3 == 1576 || $userInfo->Q8_1_2 == 1938 || $userInfo->Q8_1 == 1577 || $userInfo->Q8_1 == 1578 || $userInfo->Q8_1 == 1579 || $userInfo->Q8_2 == 1577 || $userInfo->Q8_2 == 1578 || $userInfo->Q8_2 == 1579) echo " style='display:none;'" ?> class="col-md-12 form-group Q5_1_3_no_reluctant_unknown Q8_1_yes_part Q8_1_2_NoWhereTaken_part Q8_2_yes_part">
                                    <label>
                                        <b>8.2.1</b>&nbsp;হাসপাতালে ভর্তির তালিকা লিখুন: (অতি সাম্প্রতিক থেকে শুরু করুন)
                                    </label>
                                    <table  class="table table-bordered table-striped">
                                        <thead>
                                        <th style="text-align: center">স্বাস্থ্য সেবা প্রতিষ্ঠানের নাম</th>
                                        <th style="text-align: center"> হাসপাতালে ভর্তির তারিখ</th>
                                        <th style="text-align: center"> হাসপাতালে ভর্তির কারণ সমূহ</th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><input value="<?php echo $userInfo->Q8_2_1_HOSPITAL_1; ?>" id="Q8_2_1_HOSPITAL_1" name="Q8_2_1_HOSPITAL_1" type="text" class="form-control"></td>
                                                <td><input value="<?php if ($userInfo->Q8_2_1_DATE_ADMISSION_1 != "0000-00-00") echo $Q8_2_1_DATE_ADMISSION_1; ?>" id="Q8_2_1_DATE_ADMISSION_1" name="Q8_2_1_DATE_ADMISSION_1" type="text" class="form-control datepicker"></td>
                                                <td><input value="<?php echo $userInfo->Q8_2_1_REASON_1; ?>" id="Q8_2_1_REASON_1" name="Q8_2_1_REASON_1" type="text" class="form-control"></td>
                                            </tr>
                                            <tr>
                                                <td><input value="<?php echo $userInfo->Q8_2_1_HOSPITAL_2; ?>" id="Q8_2_1_HOSPITAL_2" name="Q8_2_1_HOSPITAL_2" type="text" class="form-control"></td>
                                                <td><input value="<?php if ($userInfo->Q8_2_1_DATE_ADMISSION_2 != "0000-00-00") echo $Q8_2_1_DATE_ADMISSION_2; ?>" id="Q8_2_1_DATE_ADMISSION_2" name="Q8_2_1_DATE_ADMISSION_2" type="text" class="form-control datepicker"></td>
                                                <td><input value="<?php echo $userInfo->Q8_2_1_REASON_2; ?>" id="Q8_2_1_REASON_2" name="Q8_2_1_REASON_2" type="text" class="form-control"></td>
                                            </tr>
                                            <tr>
                                                <td><input value="<?php echo $userInfo->Q8_2_1_HOSPITAL_3; ?>" id="Q8_2_1_HOSPITAL_3" name="Q8_2_1_HOSPITAL_3" type="text" class="form-control"></td>
                                                <td><input value="<?php if ($userInfo->Q8_2_1_DATE_ADMISSION_3 != "0000-00-00") echo $Q8_2_1_DATE_ADMISSION_3; ?>" id="Q8_2_1_DATE_ADMISSION_3" name="Q8_2_1_DATE_ADMISSION_3" type="text" class="form-control datepicker"></td>
                                                <td><input value="<?php echo $userInfo->Q8_2_1_REASON_3; ?>" id="Q8_2_1_REASON_3" name="Q8_2_1_REASON_3" type="text" class="form-control"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div <?php if ($userInfo->Q5_1_3 == 1576 || $userInfo->Q8_1_2 == 1938 || $userInfo->Q8_1 == 1577 || $userInfo->Q8_1 == 1578 || $userInfo->Q8_1 == 1579 || $userInfo->Q8_2 == 1577 || $userInfo->Q8_2 == 1578 || $userInfo->Q8_2 == 1579) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown Q8_1_yes_part Q8_1_2_NoWhereTaken_part Q8_2_yes_part">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>8.2.2</b>&nbsp;শিশুটিকে কি খুব অসুস্থ অবস্থায়ই ছাড়পত্র দেয়া হয়েছিল?
                                        </label>
                                        <select id="Q8_2_2" class="form-control" name="Q8_2_2">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q8_2_2 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <label>
                                            <b>8.2.3</b> &nbsp;হাসপাতালে ভর্তি হতে এবং সেবা পেতে এরূপ কোন সমস্যা হয়েছিল?
                                        </label>
                                        <table class="table table-bordered table-striped">
                                            <tr><td style="text-align: left;">&nbsp;ভর্তি ও বিছানা পেতে বিলম্ব</td>
                                                <td>
                                                    <select id="Q8_2_3_A" class="form-control" name="Q8_2_3_A">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q8_2_3_A == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;রোগ নির্নয় ও চিকিৎসা পেতে বিলম্ব</td>
                                                <td>
                                                    <select id="Q8_2_3_B" class="form-control" name="Q8_2_3_B">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q8_2_3_B == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;অমার্জিত আচরন</td>
                                                <td>
                                                    <select id="Q8_2_3_C" class="form-control" name="Q8_2_3_C">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q8_2_3_C == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;হাসপাতালে পোঁছাতে দুই ঘন্টার বেশী সময় লাগা</td>
                                                <td>
                                                    <select id="Q8_2_3_D" class="form-control" name="Q8_2_3_D">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q8_2_3_D == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;প্রয়োজনীয় চিকিৎসা সেবা নিয়ে সন্দেহ</td>
                                                <td>
                                                    <select id="Q8_2_3_E" class="form-control" name="Q8_2_3_E">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q8_2_3_E == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>

                                        </table>
                                    </div>

                                    <div class="box-footer col-md-12" style="margin-left:20px;margin-right:20px">
                                        <input type="submit" class="btn btn-primary" value="Update">
                                    </div>

                                </div>


                                <div <?php if ($userInfo->Q5_1_3 == 1576 || $userInfo->Q8_1_2 == 1938 || $userInfo->Q8_1 == 1577 || $userInfo->Q8_1 == 1578 || $userInfo->Q8_1 == 1579 || $userInfo->Q8_2 == 1577 || $userInfo->Q8_2 == 1578 || $userInfo->Q8_2 == 1579) echo " style='display:none;'" ?> class="col-md-12 Q5_1_3_no_reluctant_unknown Q8_1_yes_part Q8_1_2_NoWhereTaken_part Q8_2_yes_part">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>8.2.4</b>&nbsp;মৃত্যুর আগের কয়েকদিনে চিকিৎসায় সহযোগিতার জন্য কেউ ফোন করেছিল?
                                        </label>
                                        <select id="Q8_2_4" class="form-control" name="Q8_2_4">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q8_2_4 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>8.2.5</b>&nbsp;মৃত্যুর আগের কয়েকদিনে প্রয়োজনীয় চিকিৎসা সেবা নিয়ে কোন সন্দেহ ছিল?
                                        </label>
                                        <select id="Q8_2_5" class="form-control" name="Q8_2_5">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q8_2_5 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>8.2.6</b>&nbsp;মৃত্যুর আগের কয়েকদিনে  Traditional medicine (প্রচলিত বা দেশীয় চিকিৎসা) ব্যবহৃত হয়েছিল?
                                        </label>
                                        <select id="Q8_2_6" class="form-control" name="Q8_2_6">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q8_2_6 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div <?php if ($userInfo->Q5_1_3 == 1576 || $userInfo->Q8_1_2 == 1938 || $userInfo->Q8_1 == 1577 || $userInfo->Q8_1 == 1578 || $userInfo->Q8_1 == 1579 || $userInfo->Q8_2 == 1577 || $userInfo->Q8_2 == 1578 || $userInfo->Q8_2 == 1579) echo " style='display:none;'" ?> class="col-md-4 form-group Q5_1_3_no_reluctant_unknown Q8_1_yes_part Q8_1_2_NoWhereTaken_part Q8_2_yes_part">
                                        <label>
                                            <b>8.2.7</b>&nbsp;শিশুটির চিকিৎসা ব্যয়ের/অন্যান্য পারিবারিক খরচ মিটাতে সমস্যা হয়েছিল?
                                        </label>
                                        <select id="Q8_2_7" class="form-control" name="Q8_2_7">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q8_2_7 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>8.3</b>&nbsp;মৃত্যুর স্থান:
                                        </label>
                                        <select onchange="showHide(this.id, 'Q8_3_off')" name="Q8_3" class="form-control" id="Q8_3">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Death_Place as $VA_Death_Place_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q8_3 == $VA_Death_Place_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Death_Place_single->code == 5)
                                                    echo " id='QQ8_3_root'";
                                                else
                                                    echo " id='QQ8_3_" . $i . "'";
                                                ?> value="<?php echo $VA_Death_Place_single->id; ?>"><?php echo $VA_Death_Place_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q8_3_OTHER; ?>" <?php if (strlen($userInfo->Q8_3_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q8_3_off" type="text" name="Q8_3_OTHER" class="form-control">
                                    </div>
                                </div>
                                <div <?php
                                if ($userInfo->Q8_3 == 1825 || $userInfo->Q8_3 == 1827)
                                    echo " style='display:block;'";
                                else
                                    echo " style='display:none;'";
                                ?> class="col-md-12 Q8_3_1_part">
                                    <b>8.3.1</b>&nbsp;যদি বাড়ীতে/পথিমধ্যে মারা গিয়ে থাকে তা হলে ব্লক এর নাম ও কোড নাম্বার লিখুনঃ
                                </div>
                                <div <?php
                                if ($userInfo->Q8_3 == 1825 || $userInfo->Q8_3 == 1827)
                                    echo " style='display:block;'";
                                else
                                    echo " style='display:none;'";
                                ?> class="col-md-12 Q8_3_1_part">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            গ্রামের নাম
                                        </label>
                                        <input value="<?php echo $userInfo->Q8_3_1_VILL_NAME; ?>" id="Q8_3_1_VILL_NAME" name="Q8_3_1_VILL_NAME" type="text" class="form-control" placeholder="গ্রামের নাম">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            ব্লকের নাম
                                        </label>
                                        <input value="<?php echo $userInfo->Q8_3_1_BLOCK_NAME; ?>" id="Q8_3_1_BLOCK_NAME" name="Q8_3_1_BLOCK_NAME" type="text" class="form-control" placeholder="ব্লকের নাম">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            ব্লক কোড
                                        </label>
                                        <input value="<?php echo $userInfo->Q8_3_1_BLOCK_CODE; ?>" id="Q8_3_1_BLOCK_CODE" name="Q8_3_1_BLOCK_CODE" type="text" class="form-control" placeholder="ব্লক কোড">
                                    </div>
                                </div>

                                <div <?php
                                if ($userInfo->Q8_3 == 1826)
                                    echo " style='display:block;'";
                                else
                                    echo " style='display:none;'";
                                ?> class="col-md-8 form-group Q8_3_2_part">
                                    <label>
                                        <b>8.3.2</b>&nbsp;যদি শিশুটি কোন স্বাস্থ্যসেবা প্রতিষ্ঠানে মারা যায় তা হলে, উহার নাম ও ঠিকানা লিখুন:
                                    </label>
                                    <input value="<?php echo $userInfo->Q8_3_2_HOSPITAL_NAME; ?>" id="Q8_3_2_HOSPITAL_NAME" name="Q8_3_2_HOSPITAL_NAME" type="text" class="form-control" placeholder="নাম">
                                    <br/>
                                    <textarea class="form-control" id="Q8_3_2_HOSPITAL_ADDRESS" name="Q8_3_2_HOSPITAL_ADDRESS" placeholder="ঠিকানা"><?php echo $userInfo->Q8_3_2_HOSPITAL_ADDRESS; ?></textarea>
                                </div>

                                <div <?php if ($userInfo->Q8_3 == 1828 || $userInfo->Q8_3 == 1936) echo " style='display:none;'" ?> class="col-md-4 form-group Q8_4_part">
                                    <label>
                                        <b>8.4</b>&nbsp;হাসপাতাল থেকে কেহ কি আপনাকে মৃত্যুর কারণটি বলেছিল?
                                    </label>
                                    <select id="Q8_4" class="form-control" name="Q8_4">
                                        <option id="0" value="">নির্বাচন করুন</option>
                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                            <option <?php if ($userInfo->Q8_4 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div <?php if ($userInfo->Q8_3 == 1828 || $userInfo->Q8_3 == 1936 || $userInfo->Q8_4 == 1577 || $userInfo->Q8_4 == 1578 || $userInfo->Q8_4 == 1579 || $userInfo->Q8_4 == 0) echo " style='display:none;'" ?> class="col-md-4 form-group Q8_4_yes_part">
                                    <label>
                                        <b>8.4.1</b>&nbsp;কে কারণটি বলে ছিল?
                                    </label> 
                                    <select onchange="showHide(this.id, 'Q8_4_1_off')" name="Q8_4_1" class="form-control" id="Q8_4_1">
                                        <option id="0" value="">নির্বাচন করুন</option>
                                        <?php
                                        $i = 1;
                                        foreach ($VA_Reason_Teller as $VA_Reason_Teller_single) {
                                            ?>
                                            <option <?php if ($userInfo->Q8_4_1 == $VA_Reason_Teller_single->id) echo ' selected'; ?> <?php
                                            if ($VA_Reason_Teller_single->code == 3)
                                                echo " id='Q8_4_1_root'";
                                            else
                                                echo " id='Q8_4_1_" . $i . "'";
                                            ?> value="<?php echo $VA_Reason_Teller_single->id; ?>"><?php echo $VA_Reason_Teller_single->name; ?></option>
                                                <?php
                                                $i++;
                                            }
                                            ?>
                                    </select>
                                    <br/>
                                    <input value="<?php echo $userInfo->Q8_4_1_OTHER; ?>" <?php if (strlen($userInfo->Q8_4_1_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q8_4_1_off" type="text" name="Q8_4_1_OTHER" class="form-control">
                                </div>

                                <div <?php if ($userInfo->Q8_3 == 1828 || $userInfo->Q8_3 == 1936 || $userInfo->Q8_4 == 1577 || $userInfo->Q8_4 == 1578 || $userInfo->Q8_4 == 1579 || $userInfo->Q8_4 == 0) echo " style='display:none;'" ?> class="col-md-6 form-group Q8_4_yes_part">
                                    <label>
                                        <b>8.4.2</b>&nbsp;তিনি মৃত্যুর  কি কারণ বলেছিলেন? (কারণ সমূহ লিখুন)
                                    </label>
                                    <textarea id="Q8_4_2" class="form-control" name="Q8_4_2"><?php echo $userInfo->Q8_4_2; ?></textarea>
                                </div>

                                <div class="box-footer col-md-12" style="margin-left:20px;margin-right:20px">
                                    <input type="submit" class="btn btn-primary" value="Update">
                                </div>

                                <div class="col-md-12">
                                    <br/>
                                    <b>IX স্বাস্থ্য তথ্য/ব্যবস্থাপত্র (HEALTH RECORDS/PRESCRIPTION)</b>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label><b>9.1</b>&nbsp;শিশুটির কোন স্বাস্থ্য তথ্য বা ব্যবস্থাপত্র আছে কি?</label>
                                        <select id="Q9_1" class="form-control" name="Q9_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q9_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q9_1 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q9_1_no_reluctant_unknown">
                                        <label><b>9.2</b>&nbsp;আমি স্বাস্থ্য তথ্যখানা বা ব্যবস্থাপত্র  দেখতে পারি কি?</label>
                                        <select id="Q9_2" class="form-control" name="Q9_2">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q9_2 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <?php
                                $Q9_2_VDATE = '';
                                if (!empty($userInfo->Q9_2_VDATE)) {
                                    $partsRequire = explode('-', $userInfo->Q9_2_VDATE);
                                    $Q9_2_VDATE = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];
                                }
                                ?>

                                <div <?php if ($userInfo->Q9_2 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q9_2_part">
                                    (তথ্যখানা থেকে  Date, height, weight in kg written at the most recent visit, Symptoms, diagnosis and treatment লিখুন / সংযুক্ত করূন)<br><br>
                                </div>

                                <div <?php if ($userInfo->Q9_2 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q9_2_part">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            Date
                                        </label>
                                        <input id="Q9_2_VDATE" value="<?php if ($userInfo->Q9_2_VDATE != "0000-00-00") echo $Q9_2_VDATE; ?>" type="text" name="Q9_2_VDATE" autocomplete="off" class="datepicker form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            Height (cm)
                                        </label>

                                        <input id="Q9_2_HIGH" value="<?php echo $userInfo->Q9_2_HIGH; ?>" name="Q9_2_HIGH" type="number" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            Weight (kg)
                                        </label>

                                        <input id="Q9_2_WEIG" value="<?php echo $userInfo->Q9_2_WEIG; ?>" name="Q9_2_WEIG" type="number" class="form-control">
                                    </div>
                                </div>      
                                <div <?php if ($userInfo->Q9_2 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q9_2_part">
                                    <div class="col-md-4 form-group">

                                        <label>
                                            Symptoms
                                        </label>

                                        <input id="Q9_2_SYMP" value="<?php echo $userInfo->Q9_2_SYMP; ?>" name="Q9_2_SYMP" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            Diagnosis
                                        </label>

                                        <input id="Q9_2_DIAG" value="<?php echo $userInfo->Q9_2_DIAG; ?>" name="Q9_2_DIAG" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            Treatment
                                        </label>
                                        <input id="Q9_2_TRET" value="<?php echo $userInfo->Q9_2_TRET; ?>" name="Q9_2_TRET" type="text" class="form-control">
                                    </div>
                                </div>

                                <div <?php
                                if ($userInfo->Q9_1 == 1577 || $userInfo->Q9_1 == 1578 || $userInfo->Q9_1 == 1579 || $userInfo->Q9_2 == 1577 || $userInfo->Q9_2 == 1578 || $userInfo->Q9_2 == 1579)
                                    echo " style='display:block;'";
                                else
                                    echo " style='display:none;'";
                                ?> class="col-md-4 Q9_3_part">
                                    <br/>
                                    <label><b>9.3</b> &nbsp;শিশুটির মৃত্যু প্রত্যায়ন পত্র  (Death Certificate) আছে কি?</label>
                                    <select id="Q9_3" class="form-control" name="Q9_3">
                                        <option id="0" value="">নির্বাচন করুন</option>
                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                            <option <?php if ($userInfo->Q9_3 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div <?php if ($userInfo->Q9_3 != 1576) echo " style='display:none;'"; ?> class="col-md-4 Q9_3_no_reluctant_unknown">
                                    <br/>
                                    <label><b>9.4</b> &nbsp;আপনি (Interviewer) কি মৃত্যু প্রত্যায়ন পত্র দেখতে পেয়েছিলেন?</label>
                                    <select id="Q9_4" name="Q9_4" class="form-control">
                                        <option id="0" value="">নির্বাচন করুন</option>
                                        <?php foreach ($va_yes_no as $va_yes_no_single) { ?>
                                            <option <?php if ($userInfo->Q9_4 == $va_yes_no_single->id) echo ' selected'; ?> value="<?php echo $va_yes_no_single->id; ?>"><?php echo $va_yes_no_single->name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div <?php if ($userInfo->Q9_3 != 1576) echo " style='display:none;'"; ?> class="col-md-4 Q9_3_no_reluctant_unknown">
                                    <b>9.5</b> &nbsp;প্রত্যায়ন পত্র থেকে মৃত্যুর কারন লিপিবদ্ধ করুন:</div>
                                <div <?php if ($userInfo->Q9_3 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q9_3_no_reluctant_unknown">
                                    <div class="col-md-3 form-group">
                                        <label> a. Immediate cause </label>
                                        <input value="<?php echo $userInfo->Q9_5_ICAUSE; ?>" id="Q9_5_ICAUSE" name="Q9_5_ICAUSE" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>Code</label> 
                                        <input value="<?php echo $userInfo->Q9_5_ICODE; ?>" id="Q9_5_ICODE" name="Q9_5_ICODE" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label> b. Antecedent cause </label>
                                        <input value="<?php echo $userInfo->Q9_5_ACAUSE; ?>" id="Q9_5_ACAUSE" name="Q9_5_ACAUSE" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>Code</label>
                                        <input value="<?php echo $userInfo->Q9_5_ACODE; ?>" id="Q9_5_ACODE" name="Q9_5_ACODE" type="text" class="form-control">
                                    </div>
                                </div>      
                                <div <?php if ($userInfo->Q9_3 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q9_3_no_reluctant_unknown">
                                    <div class="col-md-3 form-group">
                                        <label>c. Underlying cause</label> 
                                        <input value="<?php echo $userInfo->Q9_5_UCAUSE; ?>" id="Q9_5_UCAUSE" name="Q9_5_UCAUSE" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>Code</label>
                                        <input value="<?php echo $userInfo->Q9_5_UCODE; ?>" id="Q9_5_UCODE" name="Q9_5_UCODE" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>d. Contributing cause</label> 
                                        <input value="<?php echo $userInfo->Q9_5_CCAUSE; ?>" id="Q9_5_CCAUSE" name="Q9_5_CCAUSE" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label> Code</label> 
                                        <input value="<?php echo $userInfo->Q9_5_CCODE; ?>" id="Q9_5_CCODE" name="Q9_5_CCODE" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label><b>9.6</b> &nbsp;মৃত শিশুর মায়ের HIV জীবাণুর জন্য কখনো রক্ত পরীক্ষা করা হয়েছিল কি?</label>
                                        <select id="Q9_6" class="form-control" name="Q9_6">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q9_6 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q9_6 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q9_6_yes_part">
                                        <label><b>9.7</b> &nbsp;HIV জীবাণুর পরীক্ষায় মায়ের রক্তে কখনো পজিটিভ ধরা পড়েছিল?</label>
                                        <select id="Q9_7" class="form-control" name="Q9_7">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q9_7 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q9_6 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q9_6_yes_part">
                                        <label><b>9.8</b> &nbsp;কোন স্বাস্থ্যকর্মী কি মাকে বলেছিল যে, মায়ের কখনো এইডস (AIDS) রোগ আছে?</label>
                                        <select id="Q9_8" class="form-control" name="Q9_8">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q9_8 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-3 form-group">
                                        <label><b>9.9</b> &nbsp;মৃত্যু নিবন্ধণ করা হয়েছিল?<br/>
                                            (Civil Registration by Union Parishad/ Paurosova)</label>
                                        <select id="Q9_9" class="form-control" name="Q9_9">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q9_9 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q9_9 != 1576) echo " style='display:none;'"; ?> class="col-md-3 form-group 9_9_no_reluctant_unknown">
                                        <label><b>9.9.1</b> &nbsp;আপনি কি নিবন্ধণপত্র দেখেছেন?<br/>
                                            (Don't ask the Respondent)</label>
                                        <select id="Q9_9_1" name="Q9_9_1" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($va_yes_no as $va_yes_no_single) { ?>
                                                <option <?php if ($userInfo->Q9_9_1 == $va_yes_no_single->id) echo ' selected'; ?> value="<?php echo $va_yes_no_single->id; ?>"><?php echo $va_yes_no_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <?php
                                    $Q9_9_2 = '';
                                    if (!empty($userInfo->Q9_9_2)) {
                                        $partsRequire = explode('-', $userInfo->Q9_9_2);
                                        $Q9_9_2 = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];
                                    }
                                    ?>
                                    <div <?php if ($userInfo->Q9_9_1 != 1567) echo " style='display:none;'"; ?> class="col-md-3 form-group Q9_9_1_no_reluctant_unknown">
                                        <label><b>9.9.2</b> &nbsp;নিবন্ধণের তারিখ লিখুন</label>
                                        <input value="<?php if ($userInfo->Q9_9_2 != "0000-00-00") echo $Q9_9_2; ?>" id="Q9_9_2" name="Q9_9_2" type="text" class="datepicker form-control">
                                    </div>
                                    <div <?php if ($userInfo->Q9_9_1 != 1567) echo " style='display:none;'"; ?> class="col-md-3 form-group Q9_9_1_no_reluctant_unknown">
                                        <label><b>9.9.3</b> &nbsp;নিবন্ধণ নাম্বার লিখুন</label>
                                        <input value="<?php echo $userInfo->Q9_9_3; ?>" id="Q9_9_3" name="Q9_9_3" type="text" class="form-control">
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <br/>
                                    <h4 style="text-align: center;font-weight: bold;">উত্তর দাতাকে সহযোগিতার জন্য ধন্যবাদ জানান</h4>
                                </div>

                                <div class="col-md-12">
                                    <label>
                                        X) সাক্ষাৎকার গ্রহনকারীর মন্তব্য এবং পর্যবেক্ষনঃ (মৃত্যুর কারণ সম্পর্কে সন্দেহ থাকলে তাও লিখুন)
                                    </label>
                                    <textarea name="Q10_INTERVIEW" rows="5" class="form-control"><?php echo $userInfo->Q10_INTERVIEW; ?></textarea>
                                </div>    
                                <div class="col-md-12">
                                    <label>Comments on specific questions:</label>
                                    <textarea name="Q10_CSQ" rows="5" class="form-control"><?php echo $userInfo->Q10_CSQ; ?></textarea>
                                </div>      
                                <div class="col-md-12">
                                    <label>
                                        Any other comments:
                                    </label>

                                    <textarea name="Q10_AOC" rows="5" class="form-control"><?php echo $userInfo->Q10_AOC; ?></textarea>
                                </div>
                                <div class="col-md-12">
                                    <label>
                                        Supervisor Observation:
                                    </label>

                                    <textarea name="Q10_SO" rows="5" class="form-control"><?php echo $userInfo->Q10_SO; ?></textarea>
                                </div>
                                <?php
                                $Q10_DOE = '';
                                if (!empty($userInfo->Q10_DOE)) {
                                    $partsRequire = explode('-', $userInfo->Q10_DOE);
                                    $Q10_DOE = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];
                                }
                                ?>
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            Date of editing questionnaire
                                        </label>

                                        <input value="<?php if ($userInfo->Q10_DOE != "0000-00-00") echo $Q10_DOE; ?>" name="Q10_DOE" type="text" autocomplete="off" class="datepicker form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>By Supervisor</label>
                                        <select name="Q10_SUP_CODE" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Supervisor_List as $VA_Supervisor_List_single) { ?>
                                                <option <?php if ($userInfo->Q10_SUP_CODE == $VA_Supervisor_List_single->id) echo ' selected'; ?> value="<?php echo $VA_Supervisor_List_single->id; ?>"><?php echo $VA_Supervisor_List_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>Interview Status</label>

                                        <select name="inv_status" class="form-control">
                                            <option <?php
                                            if ($userInfo->inv_status == 0) {
                                                echo "selected=selected";
                                            }
                                            ?>  value="0">incomplete</option>
                                            <option <?php
                                            if ($userInfo->inv_status == 1) {
                                                echo "selected=selected";
                                            }
                                            ?> value="1">complete</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Update">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script src="<?php echo base_url(); ?>assets/js/NeonateJS.js"></script>
    <script>
                                        function showHide(id, dp_id) {

                                            var x = $("#" + id).children(":selected").attr("id");

                                            if (x.includes("root")) {
                                                $("#" + dp_id).show();
                                                $('#' + dp_id).attr('disabled', false);
                                                $('#' + dp_id).prop('required', true);
                                            } else {
                                                $("#" + dp_id).hide();
                                                $('#' + dp_id).attr('disabled', true);
                                                $('#' + dp_id).prop('required', false);
                                            }
                                        }
                                        function showHideMultiple(id, dp_class) {

                                            var x = $("#" + id).children(":selected").attr("id");

                                            if (x.includes("root")) {
                                                $("." + dp_class).show();
                                                $('.' + dp_class).attr('disabled', false);
                                                $('.' + dp_class).prop('required', true);
                                            } else {
                                                $("." + dp_class).hide();
                                                $('.' + dp_class).attr('disabled', true);
                                                $('.' + dp_class).prop('required', false);

                                            }
                                        }
    </script>
</div>