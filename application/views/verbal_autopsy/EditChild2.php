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
                    <?php echo $pageTitle; ?>
                    <small>(Add, Edit)</small>
                    <?php $baseID = $this->input->get('baseID', TRUE); ?>
                </h3>

            </div>
            <div class="col-xs-6 text-right">
                <div class="form-group margin5pxBot">
                    <a class="btn btn-primary" href="<?php echo base_url() . 'dashboard?baseID=' . $baseID ?>"> Go Back</a>
                </div>
            </div>
        </div>
    </section>
    <section class="content content-margin">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Child Details</h3>
                    </div>
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

                    <form role="form" action="<?php echo base_url() . $controller . '/' . $actionMethod . '?baseID=' . $baseID ?>" method="post">
                        <input type="hidden" name="ID" value="<?php echo $userInfo->ID; ?>">
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
                                        <input value="<?php echo $userInfo->Q1_1_N1; ?>" name="Q1_1_N1" type="text" class="form-control">
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
                                        <input value="<?php echo $userInfo->Q1_1_N2; ?>" name="Q1_1_N2" type="text" class="form-control">
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
                                        <input value="<?php echo $userInfo->Q1_1_N3; ?>" name="Q1_1_N3" type="text" class="form-control">
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

                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>1.4) প্রধান উত্তরদাতার বয়স (বছরে): </label>
                                        <input value="<?php if ($userInfo->Q1_4_AGE > 0) echo $userInfo->Q1_4_AGE; ?>" name="Q1_4_AGE" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>1.5) তিনি কত বৎসরের প্রাতিষ্ঠানিক শিক্ষা সম্পন্ন করেছেন?</label>
                                        <input value="<?php if ($userInfo->Q1_5_EDU > 0) echo $userInfo->Q1_5_EDU; ?>" name="Q1_5_EDU" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="Item Name"><b>1.6</b> &nbsp;শিশুটির বয়স কি এক বছরের কম?</label>
                                        <select id="Q1_6" name="Q1_6" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($va_yes_no as $va_yes_no_single) { ?>
                                                <option <?php if ($userInfo->Q1_6 == $va_yes_no_single->id) echo ' selected'; ?> value="<?php echo $va_yes_no_single->id; ?>"><?php echo $va_yes_no_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 Q1_6_yes">
                                    <div class="form-group col-md-4">
                                        <label for="Item Name"><b>1.6a</b> যদি মৃত শিশুর মা উপস্থিত না থাকেন, তিনি কি এখনও বেঁচে আছেন?</label>
                                        <select id="Q1_6a" class="form-control" name="Q1_6a">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_NotApplicable_Unknown as $VA_Yes_No_Reluctant_NotApplicable_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q1_6a == $VA_Yes_No_Reluctant_NotApplicable_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_NotApplicable_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_NotApplicable_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4 Q1_6a_yes"> 
                                        <label for="Item Name"><b>1.6.1</b> মৃত শিশুটির মা মারা গিয়ে থাকলে উনি প্রসব কালে না প্রসবের পরে মারা গিয়েছেন?</label>
                                        <select id="Q1_6_1" class="form-control" name="Q1_6_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Mother_Death_When as $VA_Mother_Death_When_single) { ?>
                                                <option <?php if ($userInfo->Q1_6_1 == $VA_Mother_Death_When_single->id) echo ' selected'; ?> value="<?php echo $VA_Mother_Death_When_single->id; ?>"><?php echo $VA_Mother_Death_When_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q1_6_2 == 0) echo " style='display:none;'"; ?> class="form-group Q1_6_2_part col-md-4 Q1_6a_yes">
                                        <label for="Item Name"><b>1.6.2</b> প্রসবের কতক্ষন পরে মা মারা গেছেন?<br/>
                                            <span>(২৪ ঘন্টার কম হলে=০০ দিন, মাস হিসাব করতে ১ মাস=৩০ দিন,এই হিসাবে গননা করুন)।</span>
                                        </label> 

                                        <select onchange="showHide(this.id, 'Q1_6_2_off')" class="form-control" id="Q1_6_2" name="Q1_6_2">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Day_Month_Reluctant_Unknown as $VA_Day_Month_Reluctant_Unknown_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q1_6_2 == $VA_Day_Month_Reluctant_Unknown_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Day_Month_Reluctant_Unknown_single->code == 1 || $VA_Day_Month_Reluctant_Unknown_single->code == 2)
                                                    echo " id='Q1_6_2_root'";
                                                else
                                                    echo " id='Q1_6_2_" . $i . "'";
                                                ?> value="<?php echo $VA_Day_Month_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Day_Month_Reluctant_Unknown_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select><br/>
                                        <input value="<?php echo $userInfo->Q1_6_2_DAY_OR_MONTH; ?>" <?php if ($userInfo->Q1_6_2_DAY_OR_MONTH == 0) echo " style='display:none;'"; ?> type="number" id="Q1_6_2_off" name="Q1_6_2_DAY_OR_MONTH" class="form-control">
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <br/>
                                    <b>II. BACKGROUND INFORMATION ABOUT THE INTERVIEWER</b>
                                </div>

                                <div class="col-md-4 form-group">
                                    <label>2.1) সাক্ষাৎকার গ্রহনকারীর নাম:</label>
                                    <input value="<?php echo $userInfo->Q2_1_INTV_NAME; ?>" name="Q2_1_INTV_NAME" type="text" class="form-control">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>কোড:</label>
                                    <input value="<?php echo $userInfo->Q2_1_INTV_CODE; ?>" name="Q2_1_INTV_CODE" type="text" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="Item Name">ভাষা</label>
                                    <input value="<?php echo $userInfo->Q2_1_INTV_LANGUAGE; ?>" name="Q2_1_INTV_LANGUAGE" type="text" class="form-control">
                                </div>

                                <?php
                                $partsRequire = explode('-', $userInfo->Q2_2_INTV_DATE);
                                $Q2_2_INTV_DATE = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];

                                $partsRequire = explode('-', $userInfo->Q2_3_1ST_INTV_DATE);
                                $Q2_3_1ST_INTV_DATE = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];

                                $partsRequire = explode('-', $userInfo->Q2_4_2ND_INTV_DATE);
                                $Q2_4_2ND_INTV_DATE = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];
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
                                    <br/>
                                    <b>III. IDENTIFICATION & DEMOGRAPHIC DATA OF THE DECEASED</b>
                                </div>
                                <div class="col-md-4">
                                    <br/>
                                    <label for="Item Name"><b>3.1</b>&nbsp;শিশুর নাম</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <br/>
                                    <label for="Item Name">RID</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <br/>
                                    <label for="Item Name">CID</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <br/>
                                    <label for="Item Name"><b>3.2</b>&nbsp;মায়ের নাম</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <br/>
                                    <label for="Item Name">CID</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <br/>
                                    <label for="Item Name"><b>3.3</b>&nbsp;পিতার নাম</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <br/>
                                    <label for="Item Name">CID</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <br/>
                                    <label for="Item Name"><b>3.4</b>&nbsp;গ্রামের নাম</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <br/>
                                    <label for="Item Name"><b>3.5</b>&nbsp;বাড়ির নাম</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <br/>
                                    <label for="Item Name">বাড়ির কোড</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <br/>
                                    <label for="Item Name"><b>3.6</b>&nbsp;শিশুর জন্ম তারিখ (দিন/মাস/বছর)</label>
                                    <input type="date" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <br/>
                                    <label for="Item Name"><b>3.7</b>&nbsp;শিশুর মৃত্যু তারিখ (দিন/মাস/বছর)</label>
                                    <input type="date" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <br/>
                                    <label for="Item Name"><b>3.8</b>&nbsp;মৃত্যুকালে বয়স (বছর-মাস-দিন)</label>
                                    <input type="date" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <br/>
                                    <label for="Item Name"><b>3.9</b>&nbsp;শিশুর লিঙ্গ</label>
                                    <select class="form-control" id="sel1">
                                        <option value="1">পুরুষ</option>
                                        <option value="2">মহিলা</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <br/>
                                    <label for="Item Name"><b>3.10</b>&nbsp;শিশুর প্রাতিষ্ঠানিক শিক্ষা কত বছরের?</label>
                                    <select class="form-control" id="sel1">
                                        <option value="97">কখনো যায়নি</option>
                                        <option value="98">বয়স ৫ বছরের নীচে</option>
                                        <option value="99">অঁজানা</option>
                                        <option value="00">স্কুল শুরু করেছে</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <br/>
                                    <label for="Item Name"><b>3.11</b>&nbsp;শিক্ষার ধরন</label>
                                    <select class="form-control" id="sel1">
                                        <option value="1">সাধারন</option>
                                        <option value="2">ধর্মীয় </option>
                                        <option value="7">অনিচ্ছা </option>
                                        <option value="8">প্রযোজ্য নয়</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <br/> <br/>
                                    <label for="Item Name"><b>3.11.1</b>&nbsp;..কি পড়তে এবং লিখতে পারতো</label>
                                    <select class="form-control" id="">
                                        <option value="1">হ্যাঁ</option>
                                        <option value="2">না  </option>
                                        <option value="7">অনিচ্ছা </option>
                                        <option value="9">অজানা </option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <br/>
                                    <label for="Item Name"><b>3.12</b>&nbsp;তাহার পেশা কি ছিল?<br/>(যদি মৃতের বয়স ৬-১২ বছর হয়)</label>
                                    <select class="form-control" id="">
                                        <option value="1">ছাত্র </option>
                                        <option value="2">কাজ-পরিবারের জন্য</option>
                                        <option value="3">কাজ-রোজগারের জন্য </option>
                                        <option value="4">কিছুই করে না</option>
                                        <option value="7">অনিচ্ছা</option>
                                        <option value="8">প্রযোজ্য নয়</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <br/>
                                    <label for="Item Name"><b>3.13</b>&nbsp;তাহার বৈবাহিক অব¯হা কি? <br/>
                                        (যদি মৃত শিশুর বয়স ১০-১২ বছর এবং মেয়ে হয়)</label>
                                    <select class="form-control" id="">
                                        <option value="1">অবিবাহিত </option>
                                        <option value="2">বিবাহিত </option>
                                        <option value="3">তালাকপ্রাপ্ত/বিধবা</option>
                                        <option value="7">অনিচ্ছা</option>
                                        <option value="8">প্রযোজ্য নয়</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <br/>
                                    <label for="Item Name"><b>3.13.1</b>&nbsp;বিবাহিত হলে, বিয়ের তারিখ </label>
                                    <input type="date" class="form-control">
                                </div>
                                <div class="col-md-12">
                                    <br/>
                                    <b>4.1</b>&nbsp;&nbsp;মৃত্যুর আগের শিশুটির সর্বশেষ অসুস্থতা সম্পর্কে আপনি আমাকে দয়া করে কিছূ বলবেন কি?<br/><br/>
                                    সাক্ষাৎকার গ্রহনকারীর প্রতি নির্দেশিকা: উত্তরদাতাকে তার নিজের ভাষায় বলার জন্য সহায়তা করুন। উত্তরদাতার বলার পর, যতক্ষণ পর্যন্ত না বলে যে আর কিছু বলার নেই ততক্ষন পর্যন্ত  জিজ্ঞাসা করতে থাকুন আরও কিছু ছিল কি না। উত্তরদাতার স্বতস্ফুর্তভাবে বলা রোগের লক্ষণগুলো লিপিবদ্ধ করুন ও অপরিচিত কোন শব্দ থাকলে তার নীচে লাইন টেনে চিহ্নিত করুন।
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-12 form-group">
                                        <br/>
                                        <label>কি কারণে তার মৃত্যু হয়েছিল বলে আপনি মনে করেন? কারণ সমূহ লিখুনঃ (অনিচ্ছা=7)</label>
                                        <textarea name="Q4_1_death_reasons" rows="5" class="form-control"><?php echo $userInfo->Q4_1_death_reasons; ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <br/>
                                    I would like to ask you some questions concerning the contexts and previously known medical
                                    conditions the deceased had; injuries and accidents that the deceased suffered; and signs and
                                    symptoms that the deceased had/showed when s/he was ill. Some of these questions may not to be directly related to his/her death. Please bear with me and answer all
                                    the questions.They will help us to get a clear picture of all possible symptoms that the deceased had.
                                </div>
                                <div class="col-md-12">
                                    <br/>
                                    আমি আপনাকে অসুস্থকালীন সময়ে রোগের লক্ষণ ও উপসর্গ/আঘাত/দূর্ঘটনা প্রসঙ্গে কিছু প্রশ্ন করব যাতে এই শিশুটি মৃত্যুর পূর্বে
                                    ভুগেছিল/সম্মুখীন হয়েছিল। কিছু প্রশ্ন শিশুটির মৃত্যুর সাথে সরাসরি সম্পর্কিত নাও হতে পারে। অনুগ্রহ পূর্বক আমার সাথে থাকুন এবং
                                    প্রশ্নগুলির উত্তর দিন। সেগুলি মৃতব্যক্তির সম্ভাব্য লক্ষণ সম্বন্ধে একটি চিত্র পেতে আমাদের সাহায্য করবে এবং শিশুটির এ রোগ নির্ণয় মৃত্যুর
                                    পূর্বে কোন একজন ডাক্তার, স্বাস্থ্যকর্মী বা অন্য কোন স্বাস্থ্যপেশাজীবির দ্বারা নির্ণীত হয়েছে)
                                </div>
                                <div class="col-md-12">
                                    <br/>
                                    <b>Context and History of Previous Known Conditions</b>
                                </div>
                                <div class="form-group col-md-12">
                                    <b> 4.2</b>
                                    <table style="width: 100%;text-align:center;border-collapse: collapse;border-color: lightgray;" border="1">
                                        <tr>
                                            <td colspan="2">মৃত শিশুর নিম্মের অসুস্থতাগুলোর কোনটি ছিল কিনা জিজ্ঞাসা করুন: (একাধিক উত্তর হতে পারে)
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;উচ্চ রক্তচাপ (High Blood Pressure) </td>
                                            <td>
                                                <select class="form-control" name="Q4_2_A">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q4_2_A == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;হৃদ রোগ (Heart diseases)</td>
                                            <td>
                                                <select class="form-control" name="Q4_2_B">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q4_2_B == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;স্ট্রোক (Stroke)</td>
                                            <td>
                                                <select class="form-control" name="Q4_2_C">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q4_2_C == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;বহুমুত্র (Diabetes)</td>
                                            <td>
                                                <select class="form-control" name="Q4_2_D">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q4_2_D == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;মৃগী রোগ (Epilepsy)</td>
                                            <td>
                                                <select class="form-control" name="Q4_2_E">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q4_2_E == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;ক্যানসার (Cancer) নির্দিষ্ট করুন</td>
                                            <td>
                                                <select onchange="showHide(this.id, 'Q4_2_F_SPECIFY_off')" id="Q4_2_F" class="form-control" name="Q4_2_F">
                                                    <option  id="0" value="">নির্বাচন করুন</option>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) {
                                                        ?>
                                                        <option <?php
                                                        if ($userInfo->Q4_2_F == $VA_Yes_No_Reluctant_Unknown_single->id)
                                                            echo ' selected';
                                                        if ($VA_Yes_No_Reluctant_Unknown_single->code == 1)
                                                            echo " id='Q4_2_F_root'";
                                                        else
                                                            echo " id='Q4_2_F_" . $i . "'";
                                                        ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                            <?php
                                                            $i++;
                                                        }
                                                        ?>
                                                </select><br/>
                                                <input value="<?php echo $userInfo->Q4_2_F_SPECIFY; ?>" <?php if (strlen($userInfo->Q4_2_F_SPECIFY) > 0 == false) echo " style='display:none;'"; ?> id="Q4_2_F_SPECIFY_off" name="Q4_2_F_SPECIFY" type="text" class="form-control">
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;হাঁপানী (Asthma)</td>
                                            <td>
                                                <select class="form-control" name="Q4_2_G">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q4_2_G == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;COPD (Chronic Pulmonary Obstructive Disease)</td>
                                            <td>
                                                <select class="form-control" name="Q4_2_H">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q4_2_H == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>

                                        <tr><td style="text-align: left;">&nbsp;যক্ষা (TB)</td>
                                            <td>
                                                <select class="form-control" name="Q4_2_I">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q4_2_I == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;মারাত্মক অপুষ্টি (Severe malnutrition)</td>
                                            <td>
                                                <select class="form-control" name="Q4_2_J">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q4_2_J == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;গিটে ব্যথা (Arthritis swelling of large joints)</td>
                                            <td>
                                                <select class="form-control" name="Q4_2_K">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q4_2_K == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;কিডনীর রোগ (Kidney disease)</td>
                                            <td>
                                                <select class="form-control" name="Q4_2_L">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q4_2_L == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;লিভারের রোগ (Hepatitis or liver disease)</td>
                                            <td>
                                                <select class="form-control" name="Q4_2_M">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q4_2_M == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;রক্তের রোগ (Thalassemia, haemolytic/sickle cell anaemia etc)</td>
                                            <td>
                                                <select class="form-control" name="Q4_2_N">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q4_2_N == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;পেপটিক আলসার (Gastric)</td>
                                            <td>
                                                <select class="form-control" name="Q4_2_O">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q4_2_O == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;মানসিক প্রতিবন্ধি (Mental handicap)</td>
                                            <td>
                                                <select class="form-control" name="Q4_2_P">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q4_2_P == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;শারীরিক প্রতিবন্ধি (Physical handicap)</td>
                                            <td>
                                                <select class="form-control" name="Q4_2_Q">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q4_2_Q == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;পুনরায় আক্রান্ত নিউমোনিয়া (Repeated pneumonia)</td>
                                            <td>
                                                <select class="form-control" name="Q4_2_R">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q4_2_R == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;ম্যালেরিয়া (Malaria)</td>
                                            <td>
                                                <select class="form-control" name="Q4_2_S">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q4_2_S == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;মানসিক রোগ (Depression)</td>
                                            <td>
                                                <select class="form-control" name="Q4_2_T">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q4_2_T == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;ডিমেনশিয়া (Dementia)</td>
                                            <td>
                                                <select class="form-control" name="Q4_2_U">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q4_2_U == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;এইডস/এইচ আইভি (AIDS or HIV)</td>
                                            <td>
                                                <select class="form-control" name="Q4_2_V">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q4_2_V == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;আর্সেনিকজনিত রোগ (Arsenicosis)</td>
                                            <td>
                                                <select class="form-control" name="Q4_2_W">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q4_2_W == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;ডেঙ্গু(Dengu Fever)</td>
                                            <td>
                                                <select class="form-control" name="Q4_2_X">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q4_2_X == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;চিকুনগুনিয়া(Chikungunya)</td>
                                            <td>
                                                <select class="form-control" name="Q4_2_Y">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q4_2_Y == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;অন্যান্য রোগ</td>
                                            <td>
                                                <select onchange="showHide(this.id, 'Q4_2_Z_OTHER_off')" id="Q4_2_Z" class="form-control" name="Q4_2_Z">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) {
                                                        ?>
                                                        <option <?php if ($userInfo->Q4_2_Z == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> <?php
                                                        if ($VA_Yes_No_Reluctant_Unknown_single->code == 1)
                                                            echo " id='Q4_2_Z_root'";
                                                        else
                                                            echo " id='Q4_2_Z_" . $i . "'";
                                                        ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                            <?php
                                                            $i++;
                                                        }
                                                        ?>
                                                </select><br/>
                                                <input value="<?php echo $userInfo->Q4_2_Z_OTHER; ?>" <?php if (strlen($userInfo->Q4_2_Z_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q4_2_Z_OTHER_off" name="Q4_2_Z_OTHER" type="text" class="form-control">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-4">
                                    <label><b>4.3</b>&nbsp;মৃত্যুর পুর্বে  কত মাস/দিন যাবৎ শিশুটি অসুস্থ্য ছিল?</label>
                                    <input value="<?php echo $userInfo->Q4_3_M; ?>" name="Q4_3_M" style="width:50%;float:left;" placeholder="মাস" type="text" class="form-control">
                                    <input value="<?php echo $userInfo->Q4_3_D; ?>" name="Q4_3_D" style="width:50%;float:left;" placeholder="দিন" type="text" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <br/>
                                    <label><b>4.4</b>&nbsp;শিশুটি কি হঠাৎ করে মারা গিয়েছিল?</label>
                                    <select class="form-control" name="Q4_4">
                                        <option id="0" value="">নির্বাচন করুন</option>
                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                            <option <?php if ($userInfo->Q4_4 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    V. আঘাত বা দুর্ঘটনা (INJURY OR ACCIDENT)<br><br>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>5.1) সে কি কোন আঘাত বা দুর্ঘটনায় পতিত হয়েছিল যা তাকে মৃত্যুর দিকে ঠেলে দেয়? 
                                        </label>

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
                                    <div <?php if ($userInfo->Q5_1 == 1492 || $userInfo->Q5_1 == 1493 || $userInfo->Q5_1 == 1494) echo " style='display:none'"; ?> class="col-md-4 form-group Q5_1_no_reluctant_unknown">
                                        <label>
                                            5.1.1) কি ধরনের দুর্ঘটনা বা আঘাত? উত্তরদাতাকে নিজ থেকে বলতে দিন।
                                        </label>
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
                                    <div <?php if ($userInfo->Q5_1 == 1492 || $userInfo->Q5_1 == 1493 || $userInfo->Q5_1 == 1494) echo " style='display:none'"; ?> class="col-md-4 form-group Q5_1_no_reluctant_unknown">
                                        <label> 
                                            5.1.2) সড়ক/জলযান দুর্ঘটনায় মারা গেলে উহা কি ধরনের বা কি আকারের যান ছিল?
                                        </label>
                                        <select onchange="showHide(this.id, 'Q5_1_2_off')" id="Q5_1_2" class="form-control" name="Q5_1_2">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Road_OR_Water_Vehicle_Type as $VA_Road_OR_Water_Vehicle_Type_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q5_1_2 == $VA_Road_OR_Water_Vehicle_Type_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Road_OR_Water_Vehicle_Type_single->code == 5)
                                                    echo " id='Q5_1_2_root'";
                                                else
                                                    echo " id='Q5_1_2_" . $i . "'";
                                                ?> value="<?php echo $VA_Road_OR_Water_Vehicle_Type_single->id; ?>"><?php echo $VA_Road_OR_Water_Vehicle_Type_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select><br/>
                                        <input value="<?php echo $userInfo->Q5_1_2_OTHER; ?>"  <?php if (strlen($userInfo->Q5_1_2_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q5_1_2_off" type="text" name="Q5_1_2_OTHER" class="form-control">
                                    </div>
                                </div>

                                <div <?php if ($userInfo->Q5_1 == 1492 || $userInfo->Q5_1 == 1493 || $userInfo->Q5_1 == 1494) echo " style='display:none'"; ?> class="col-md-12 Q5_1_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            5.1.3) বিষ বা ঔষধ-এর ক্রিয়ায় মারা গেলে উহা কি ছিল? (কি ধরনের ঔষধ বা বিষ ছিল)
                                        </label>  
                                        <select onchange="showHide(this.id, 'Q5_1_3_off')" id="Q5_1_3" class="form-control" name="Q5_1_3">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Medicine_Or_Poison_Type as $VA_Medicine_Or_Poison_Type_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q5_1_3 == $VA_Medicine_Or_Poison_Type_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Medicine_Or_Poison_Type_single->code == 3)
                                                    echo " id='Q5_1_3_root'";
                                                else
                                                    echo " id='Q5_1_3_" . $i . "'";
                                                ?> value="<?php echo $VA_Medicine_Or_Poison_Type_single->id; ?>"><?php echo $VA_Medicine_Or_Poison_Type_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select><br/>
                                        <input value="<?php echo $userInfo->Q5_1_3_OTHER; ?>" <?php if (strlen($userInfo->Q5_1_3_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q5_1_3_off" type="text" name="Q5_1_3_OTHER" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>5.1.4) আঘাত বা দুর্ঘটনাটি অন্যের দ্বারা হয়েছে কি?
                                        </label>
                                        <select id="Q5_1_4" class="form-control" name="Q5_1_4">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q5_1_4 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            5.1.5) আপনি কি মনে করেন সে আত্মহত্যা করেছে?
                                        </label> 
                                        <select id="Q5_1_5" class="form-control" name="Q5_1_5">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q5_1_5 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div <?php if ($userInfo->Q5_1 == 1492 || $userInfo->Q5_1 == 1493 || $userInfo->Q5_1 == 1494) echo " style='display:none'"; ?> class="col-md-12 Q5_1_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            5.1.6) সে কি দুর্ঘটনা বা আহত হওয়ার জায়গায় মারা গিয়েছিলেন?
                                        </label>
                                        <select id="Q5_1_6"  class="form-control" name="Q5_1_6">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q5_1_6 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            5.1.7) দুর্ঘটনায় আহত হওয়ার পর শিশুটি কত দিন/ঘন্টা বেঁচে ছিলেন?
                                        </label>
                                        <input value="<?php echo $userInfo->Q5_1_7_D; ?>" id="Q5_1_7_D"  name="Q5_1_7_D" style="width:50%;float:left;" placeholder="দিন" type="text" class="form-control">
                                        <input value="<?php echo $userInfo->Q5_1_7_H; ?>" id="Q5_1_7_H" name="Q5_1_7_H" style="width:50%;float:left;" placeholder="ঘন্টা" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            5.1.8) শিশুটি কি মৃত্যুর আগে চিকিৎসা পেয়েছিলেন?
                                        </label>
                                        <select id="Q5_1_8" class="form-control" name="Q5_1_8">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q5_1_8 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <b>If Died within 48 hours after accident skip to Q. 7.1</b><br/>
                                    <b>VI. QUESTION ON SYMPTOMS & SIGNS NOTED DURING THE FINAL ILLNESS</b>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label><b>6.1</b>&nbsp;মৃত শিশুর বয়স কি ১৮ মাসের কম?</label>
                                        <select id="Q6_1" class="form-control" name="Q6_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label><b>6.1.1</b> &nbsp;মৃত শিশুর মা কত মাস গর্ভবতী ছিলেন?</label>
                                        <input value="<?php echo $userInfo->Q6_1_1; ?>" name="Q6_1_1" type="number" placeholder="মাস" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label><b>6.1.2</b>&nbsp;শিশুটির জন্মওজন কত ছিল?</label>
                                        <select id="Q6_1_2" class="form-control" name="Q6_1_2">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Baby_Weight as $VA_Baby_Weight_single) { ?>
                                                <option <?php if ($userInfo->Q6_1_2 == $VA_Baby_Weight_single->id) echo ' selected'; ?> value="<?php echo $VA_Baby_Weight_single->id; ?>"><?php echo $VA_Baby_Weight_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label><b>6.1.3</b>&nbsp;শিশুটির মাথার চাঁদি ফুলে ছিল কি?</label>
                                        <select id="Q6_1_3" class="form-control" name="Q6_1_3">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_1_3 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label><b>6.1.4</b>&nbsp;মৃত্যুর কত দিন আগে চাঁদি ফুলে ছিল?<br/>
                                            Code: 00 = জন্ম থেকে)</label>
                                        <input value="<?php echo $userInfo->Q6_1_4_D; ?>" name="Q6_1_4_D" type="number" placeholder="দিন" class="form-control">
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label><b>6.1.5</b>&nbsp;চাঁদি ডেবে গিয়েছিল?</label>
                                        <select id="Q6_1_5" class="form-control" name="Q6_1_5">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_1_5 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label><b>6.1.6</b>&nbsp;শিশুটি কি জমজ হিসেবে জন্মেছিল?</label>
                                        <select id="Q6_1_6" class="form-control" name="Q6_1_6">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_1_6 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label><b>6.1.7</b>&nbsp;শিশুটির জন্মক্রম কি ছিল?</label>
                                        <select id="Q6_1_7" class="form-control" name="Q6_1_7">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Birth_Order as $VA_Birth_Order_single) { ?>
                                                <option <?php if ($userInfo->Q6_1_7 == $VA_Birth_Order_single->id) echo ' selected'; ?> value="<?php echo $VA_Birth_Order_single->id; ?>"><?php echo $VA_Birth_Order_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label><b>6.1.8</b>&nbsp;শিশুটি কোথায় জন্মেছিল?
                                            (মৃত্যুকালে শিশুর বয়স একবছরের কম হলে জিজ্ঞেস করুন)</label>
                                        <select onchange="showHide(this.id, 'Q6_1_8_off')" id="Q6_1_8" class="form-control" name="Q6_1_8">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Delivery_Place as $VA_Delivery_Place_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q6_1_8 == $VA_Delivery_Place_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Delivery_Place_single->code == 11)
                                                    echo " id='Q6_1_8_root'";
                                                else
                                                    echo " id='Q6_1_8_" . $i . "'";
                                                ?> value="<?php echo $VA_Delivery_Place_single->id; ?>"><?php echo $VA_Delivery_Place_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select><br/>
                                        <input value="<?php echo $userInfo->Q6_1_8_OTHER; ?>" <?php if (strlen($userInfo->Q6_1_8_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q6_1_8_off" type="text" name="Q6_1_8_OTHER" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.1.9.0</b>&nbsp;ডেলিভারীর সময় কি প্রশক্ষিণপ্রাপ্ত স্বাস্থ্য র্কমীর সেবা পেয়েছিলেন?
                                            (মৃত্যুকালে শিশুর বয়স একবছরের কম হলে জিজ্ঞেস করুন)
                                        </label>
                                        <select id="Q6_1_9_0" class="form-control" name="Q6_1_9_0">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_1_9_0 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.1.9.1</b>&nbsp;গর্ভাবস্থার শেষ ৩ মাসে মায়ের কোন জটিলতা ছিল কিনা?
                                        </label>
                                        <select id="Q6_1_9_1" class="form-control" name="Q6_1_9_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_1_9_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.1.9.2</b> &nbsp;প্রসবব্যথা চলাকালীন বা ডেলিভারীতে কোন জটিলতা হয়েছিল কি?
                                        </label>
                                        <select id="Q6_1_9_2" class="form-control" name="Q6_1_9_2">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_1_9_2 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.1.9.3</b>&nbsp;আপনার (মায়ের) কতগুলো জীবিতজন্ম, মৃতজন্ম এবং গর্ভপাত হয়েছিল?
                                            (কোডঃ ০০=একটিও না, প্রযোজ্য নয়=৮৮,৯৯=অজানা)
                                        </label>
                                        <input type="text" value="<?php echo $userInfo->Q6_1_9_3_alive; ?>" name="Q6_1_9_3_alive" style="width: 33%;float: left;" placeholder="জীবিতজন্ম" class="form-control">
                                        <input type="text" value="<?php echo $userInfo->Q6_1_9_3_dead; ?>" name="Q6_1_9_3_dead" style="width: 33%;float: left;" placeholder="মৃত সন্তান" class="form-control">
                                        <input type="text" value="<?php echo $userInfo->Q6_1_9_3_Normal_delivery; ?>" name="Q6_1_9_3_Normal_delivery" style="width: 33%;float: left;" placeholder="গর্ভপাত (স্বতঃস্ফুর্তভাবে/ইচ্ছাকৃত)" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.1.9.4</b>&nbsp;শিশুটির জন্মওজন স্বস্থ্যকার্ড দেখে গ্রামে লিখুন। কার্ড না পেলে
                                            মায়ের উত্তর অনুযায়ী লিখুন।
                                        </label>
                                        <input value="<?php echo $userInfo->Q6_1_9_4; ?>" name="Q6_1_9_4" type="text" placeholder="গ্রাম" class="form-control">&nbsp;&nbsp;(১ কেজি = ১০০০ গ্রাম)
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.1.9.5</b>&nbsp;জন্মওজন এর উৎস।
                                        </label> 
                                        <select id="Q6_1_9_5" class="form-control" name="Q6_1_9_5">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Birth_Weight_Source as $VA_Birth_Weight_Source_single) { ?>
                                                <option <?php if ($userInfo->Q6_1_9_5 == $VA_Birth_Weight_Source_single->id) echo ' selected'; ?> value="<?php echo $VA_Birth_Weight_Source_single->id; ?>"><?php echo $VA_Birth_Weight_Source_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <b>6.2 জ্বর (FEVER)</b>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.2.1</b>&nbsp;সর্বশেষ অসুখের সময় তার কি জ্বর ছিল?
                                        </label>
                                        <select id="Q6_2_1" class="form-control" name="Q6_2_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.2.2</b>&nbsp;তার কতদিন/মাস যাবৎ জ্বর ছিল?
                                            <br/>(Code: 99 = অজানা)
                                        </label>
                                        <input value="<?php echo $userInfo->Q6_2_2_M; ?>" name="Q6_2_2_M" type="number" style="width: 50%;float: left;" placeholder="মাস" class="form-control">
                                        <input value="<?php echo $userInfo->Q6_2_2_D; ?>" name="Q6_2_2_D" type="number" style="width: 50%;float: left;" placeholder="দিন" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.2.3</b>&nbsp;জ্বরের মাত্রা কেমন ছিল?
                                        </label>
                                        <select id="Q6_2_3" class="form-control" name="Q6_2_3">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Fever_Dimension as $VA_Fever_Dimension_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_3 == $VA_Fever_Dimension_single->id) echo ' selected'; ?> value="<?php echo $VA_Fever_Dimension_single->id; ?>"><?php echo $VA_Fever_Dimension_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-3 form-group">
                                        <label>
                                            <b>6.2.4</b>&nbsp;জ্বর  কি ধরনের ছিল?
                                        </label>
                                        <select id="Q6_2_4" class="form-control" name="Q6_2_4">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Fever_Type as $VA_Fever_Type_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_4 == $VA_Fever_Type_single->id) echo ' selected'; ?> value="<?php echo $VA_Fever_Type_single->id; ?>"><?php echo $VA_Fever_Type_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>
                                            <b>6.2.5</b>&nbsp;জ্বরের সাথে তার  কি শীত শীত ভাব/কাঁপুনী ছিল?
                                        </label>
                                        <select id="Q6_2_5" class="form-control" name="Q6_2_5">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_5 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>
                                            <b>6.2.6</b>&nbsp;জ্বর কি মৃত্যু পর্যন্ত অব্যাহত ছিল?
                                        </label>
                                        <select id="Q6_2_6" class="form-control" name="Q6_2_6">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_6 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-3 form-group">
                                        <label>
                                            <b>6.2.7</b>&nbsp;রাতের বেলায় শরীর ঘামতো?
                                        </label>
                                        <select id="Q6_2_7" class="form-control" name="Q6_2_7">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_7 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <b>6.3 দানা/লালচে গোটা (RASH)</b>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.3.1</b> &nbsp;তার গায়ে কি দানা/লালচে গোটা ছিল?
                                        </label>
                                        <select id="Q6_3_1" class="form-control" name="Q6_3_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_3_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.3.2</b>&nbsp;কতদিন যাবৎ গায়ে দানা/লালচে গোটা ছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q6_3_2_M; ?>" name="Q6_3_2_M" type="text" style="width: 50%;float: left;" placeholder="মাস" class="form-control">
                                        <input value="<?php echo $userInfo->Q6_3_2_D; ?>" name="Q6_3_2_D" type="text" style="width: 50%;float: left;" placeholder="দিন" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.3.3</b> &nbsp;শরীরের কোথায় দানা ছিল?
                                        </label>
                                        <select onchange="showHide(this.id, 'Q6_3_3_off')" name="Q6_3_3" class="form-control" id="Q6_3_3">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Body_Where as $VA_Body_Where_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q6_3_3 == $VA_Body_Where_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Body_Where_single->code == 5)
                                                    echo " id='Q6_3_3_root'";
                                                else
                                                    echo " id='Q6_3_3_" . $i . "'";
                                                ?> value="<?php echo $VA_Body_Where_single->id; ?>"><?php echo $VA_Body_Where_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q6_3_3_OTHER; ?>" <?php if (strlen($userInfo->Q6_3_3_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q6_3_3_off" type="text" name="Q6_3_3_OTHER" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.3.4</b>&nbsp;শরীরের কোন স্থান থেকে দানা ওঠা শুরু হয়েছিল?
                                        </label>
                                        <select onchange="showHide(this.id, 'Q6_3_4_off')" name="Q6_3_4" class="form-control" id="Q6_3_4">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Body_Where as $VA_Body_Where_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q6_3_4 == $VA_Body_Where_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Body_Where_single->code == 5)
                                                    echo " id='Q6_3_4_root'";
                                                else
                                                    echo " id='Q6_3_4_" . $i . "'";
                                                ?> value="<?php echo $VA_Body_Where_single->id; ?>"><?php echo $VA_Body_Where_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q6_3_4_OTHER; ?>" <?php if (strlen($userInfo->Q6_3_4_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q6_3_4_off" type="text" name="Q6_3_4_OTHER" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.3.5</b>&nbsp;মৃত্যুকালীন অসুখের সময় চামড়া উঠে যেত কি?
                                        </label>
                                        <select id="Q6_3_5" class="form-control" name="Q6_3_5">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_3_5 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.3.6</b>&nbsp;দানাগুলো দেখতে কেমন ছিল?
                                        </label>
                                        <select onchange="showHide(this.id, 'Q6_3_6_off')" name="Q6_3_6" class="form-control" id="Q6_3_6">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Grain_Type as $VA_Grain_Type_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q6_3_6 == $VA_Grain_Type_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Grain_Type_single->code == 4)
                                                    echo " id='Q6_3_6_root'";
                                                else
                                                    echo " id='Q6_3_6_" . $i . "'";
                                                ?> value="<?php echo $VA_Grain_Type_single->id; ?>"><?php echo $VA_Grain_Type_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q6_3_6_OTHER; ?>" <?php if (strlen($userInfo->Q6_3_6_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q6_3_6_off" type="text" name="Q6_3_6_OTHER" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.3.7</b>&nbsp;দানাগুলো যদি হামের জন্য না হয়ে থাকে, তা হলে গত তিন মাসে শিশুটির হাম হয়েছিল কি?
                                        </label>
                                        <select id="Q6_3_7" class="form-control" name="Q6_3_7">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_3_7 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.3.8</b>&nbsp;মৃত্যুকালীন অসুখের সময় তার শরীরের চামড়ার কিছু অংশ কাল হয়ে গিয়েছিল?
                                        </label>
                                        <select id="Q6_3_8" class="form-control" name="Q6_3_8">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_3_8 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.3.9</b>&nbsp;কখনো গায়ে চামড়ায় ব্যথাযুক্ত ফোস্কা/Herpes-zoster উঠেছিল?
                                        </label>
                                        <select id="Q6_3_9" class="form-control" name="Q6_3_9">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_3_9 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <label>
                                        <b>6.3.10</b>&nbsp;মৃত শিশুটির শরীরের উলে­খিত কোন কোন জায়গা থেকে রক্তক্ষরন হয়েছিল?
                                    </label>
                                    <table style="width: 100%;text-align:center;border-collapse: collapse;border-color: lightgray;" border="1">

                                        <tr><td style="text-align: left;">&nbsp;নাক</td>
                                            <td>
                                                <select id="Q6_3_10_A" class="form-control" name="Q6_3_10_A">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q6_3_10_A == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;মুখ</td>
                                            <td>
                                                <select id="Q6_3_10_B" class="form-control" name="Q6_3_10_B">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q6_3_10_B == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;মাড়ি</td>
                                            <td>
                                                <select id="Q6_3_10_C" class="form-control" name="Q6_3_10_C">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q6_3_10_C == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;পায়ুপথ</td>
                                            <td>
                                                <select id="Q6_3_10_D" class="form-control" name="Q6_3_10_D">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                        <option <?php if ($userInfo->Q6_3_10_D == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td style="text-align: left;">&nbsp;অন্যান্য (উল্লেখ করুন)</td>
                                            <td>
                                                <select onchange="showHide(this.id, 'Q6_3_10_E_off')" name="Q6_3_10_E" class="form-control" id="Q6_3_10_E">
                                                    <option id="0" value="">নির্বাচন করুন</option>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) {
                                                        ?>
                                                        <option <?php if ($userInfo->Q6_3_10_E == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> <?php
                                                        if ($VA_Yes_No_Reluctant_Unknown_single->code == 1)
                                                            echo " id='Q6_3_10_E_root'";
                                                        else
                                                            echo " id='Q6_3_10_E_" . $i . "'";
                                                        ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                            <?php
                                                            $i++;
                                                        }
                                                        ?>
                                                </select>
                                                <br/>
                                                <input value="<?php echo $userInfo->Q6_3_10_E_OTHER; ?>" <?php if (strlen($userInfo->Q6_3_10_E_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q6_3_10_E_off" type="text" name="Q6_3_10_E_OTHER" class="form-control">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.3.11</b>&nbsp;তার চোখ লাল ছিল কি?
                                        </label>
                                        <select id="Q6_3_11" class="form-control" name="Q6_3_11">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_3_11 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.3.12</b>&nbsp;তার কি মুখে/জিহবায় ঘা বা সাদা জ্যাবড়া/ছোপ ছোপ
                                        </label>
                                        <select id="Q6_3_12" class="form-control" name="Q6_3_12">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_3_12 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <br/>
                                        <label>
                                            <b>6.3.13</b>&nbsp;জ্যাবড়া/ছোপ ছোপ দাগ কত দিন ছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q6_3_13; ?>" name="Q6_3_13" type="text" placeholder="দিন" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <b>চামড়ায় অন্যান্য পরিবর্তন (OTHER SKIN CHANGES)</b>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.3.14</b>&nbsp;মৃতব্যক্তির শরীরে ছিট ছিট সাদা/কালো দাগ/গুটি ছিল কিনা?
                                        </label>
                                        <select id="Q6_3_14" class="form-control" name="Q6_3_14">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_3_14 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <label>
                                            <b>6.3.15</b>&nbsp;কোথায় কোথায় ছিল? (একাধিক উত্তর হতে পারে)
                                        </label>
                                        <table style="width: 100%;text-align:center;border-collapse: collapse;border-color: lightgray;" border="1">

                                            <tr><td style="text-align: left;">&nbsp;হাতের তালুতে</td>
                                                <td>
                                                    <select id="Q6_3_15_A" class="form-control" name="Q6_3_15_A">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_3_15_A == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;বুকে/পেটে</td>
                                                <td>
                                                    <select id="Q6_3_15_B" class="form-control" name="Q6_3_15_B">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_3_15_B == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;পিঠে</td>
                                                <td>
                                                    <select id="Q6_3_15_C" class="form-control" name="Q6_3_15_C">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_3_15_C == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;পায়ের তলায়</td>
                                                <td>
                                                    <select id="Q6_3_15_D" class="form-control" name="Q6_3_15_D">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_3_15_D == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;সমস্ত শরীরে</td>
                                                <td>
                                                    <select id="Q6_3_15_E" class="form-control" name="Q6_3_15_E">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_3_15_E == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;অন্যান্য (উল্লেখ করুন)</td>
                                                <td>
                                                    <select onchange="showHide(this.id, 'Q6_3_15_F_off')" name="Q6_3_15_F" class="form-control" id="Q6_3_15_F">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php
                                                        $i = 1;
                                                        foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) {
                                                            ?>
                                                            <option <?php if ($userInfo->Q6_3_15_F == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> <?php
                                                            if ($VA_Yes_No_Reluctant_Unknown_single->code == 1)
                                                                echo " id='Q6_3_15_F_root'";
                                                            else
                                                                echo " id='Q6_3_15_F_" . $i . "'";
                                                            ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                                <?php
                                                                $i++;
                                                            }
                                                            ?>
                                                    </select>
                                                    <br/>
                                                    <input value="<?php echo $userInfo->Q6_3_15_F_OTHER; ?>" <?php if (strlen($userInfo->Q6_3_15_F_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q6_3_15_F_off" type="text" name="Q6_3_15_F_OTHER" class="form-control">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.3.16</b>&nbsp;কত মাস/বছর যাবৎ ছিটছিটে সাদা/কালো দাগ/গুটি ছিল?
                                            (Code: 99 = অজানা)
                                        </label>
                                        <input value="<?php echo $userInfo->Q6_3_16_Y; ?>" name="Q6_3_16_Y" type="text" style="width: 50%;float: left;" placeholder="বছর" class="form-control">
                                        <input value="<?php echo $userInfo->Q6_3_16_M; ?>" name="Q6_3_16_M" type="text" style="width: 50%;float: left;" placeholder="মাস" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.3.17</b>&nbsp;মৃত ব্যক্তির হাতের তালু ও পায়ের তলার চামড়ায় শক্ত/গুটিগুটি হয়েছিল কিনা?
                                        </label>
                                        <select id="Q6_3_17" class="form-control" name="Q6_3_17">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_3_17 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.3.18</b>&nbsp;কত মাস/বছর যাবৎ হাতের তালু ও পাঁয়ের তলায় শক্ত/গুটিগুটি এই দাগগুলি ছিল?
                                            (Code: 99 = অজানা)
                                        </label>
                                        <input value="<?php echo $userInfo->Q6_3_18_Y; ?>" name="Q6_3_18_Y" type="text" style="width: 50%;float: left;" placeholder="বছর" class="form-control">
                                        <input value="<?php echo $userInfo->Q6_3_18_M; ?>" name="Q6_3_18_M" type="text" style="width: 50%;float: left;" placeholder="মাস" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.3.19</b>&nbsp;আপনি কি জানেন, মৃত ব্যক্তি আর্সেনিক সংক্রান্ত জটিলতায় ভুগছিলেন কি না?
                                        </label>
                                        <select id="Q6_3_19" class="form-control" name="Q6_3_19">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_3_19 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.3.20</b>&nbsp;কোথায় প্রথম আর্সেনিকজনিত অসুস্থতা নির্নয় হয়েছিল?
                                        </label>
                                        <select onchange="showHide(this.id, 'Q6_3_20_off')" name="Q6_3_20" class="form-control" id="Q6_3_20">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Arsenic_Identification_Hospital as $VA_Arsenic_Identification_Hospital_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q6_3_20 == $VA_Arsenic_Identification_Hospital_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Arsenic_Identification_Hospital_single->code == 6)
                                                    echo " id='Q6_3_20_root'";
                                                else
                                                    echo " id='Q6_3_20_" . $i . "'";
                                                ?> value="<?php echo $VA_Arsenic_Identification_Hospital_single->id; ?>"><?php echo $VA_Arsenic_Identification_Hospital_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q6_3_20_OTHER; ?>" <?php if (strlen($userInfo->Q6_3_20_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q6_3_20_off" type="text" name="Q6_3_20_OTHER" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.3.21</b>&nbsp;চামড়ার পরিবর্তনের সাথে/চামড়ায় ক্ষত/দগদগে ঘা ছিল কিনা?
                                        </label>
                                        <select id="Q6_3_21" class="form-control" name="Q6_3_21">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_3_21 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.3.22</b>&nbsp;(যদি হ্যাঁ হয়) শরীরের কোন কোন জায়গায় ছিল?
                                        </label>
                                        <select onchange="showHide(this.id, 'Q6_3_22_off')" name="Q6_3_22" class="form-control" id="Q6_3_22">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Body_Where as $VA_Body_Where_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q6_3_22 == $VA_Body_Where_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Body_Where_single->code == 5)
                                                    echo " id='Q6_3_22_root'";
                                                else
                                                    echo " id='Q6_3_22_" . $i . "'";
                                                ?> value="<?php echo $VA_Body_Where_single->id; ?>"><?php echo $VA_Body_Where_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q6_3_22_OTHER; ?>" <?php if (strlen($userInfo->Q6_3_22_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q6_3_22_off" type="text" name="Q6_3_22_OTHER" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.3.23</b>&nbsp;পায়ের তলা ছাড়া শরীরের অন্য কোথাও
                                            (Ulcers, abscess or sores) ক্ষত ছিল?
                                        </label>
                                        <select id="Q6_3_23" class="form-control" name="Q6_3_23">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_3_23 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <b>6.4 শারীরিক বৃদ্ধি (PHYSICAL GROWTH/IMPAIRMENTS)</b>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.4.0</b>&nbsp;মৃত্যুর সময় শিশুটির বয়স কত ছিল ?
                                        </label> 
                                        <select id="Q6_4" class="form-control" name="Q6_4">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Child_Age as $VA_Child_Age_single) { ?>
                                                <option <?php if ($userInfo->Q6_4 == $VA_Child_Age_single->id) echo ' selected'; ?> value="<?php echo $VA_Child_Age_single->id; ?>"><?php echo $VA_Child_Age_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.4a</b> &nbsp;শিশুটি কি জন্মের ২৪ ঘন্টার মধ্যে বুকের বা বোতলের দূধপান করতে পেরেছিল?
                                        </label>
                                        <select id="Q6_4a" class="form-control" name="Q6_4a">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_4a == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.4b</b>&nbsp;শিশুটি কি কখনো স্বাভাবিকভাবে দুধপান করতে পেরেছিল?
                                        </label>
                                        <select id="Q6_4b" class="form-control" name="Q6_4b">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_4b == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.4c</b>&nbsp;শিশুটি কি দূধপান বন্ধ করে দিয়েছিল?
                                        </label>
                                        <select id="Q6_4c" class="form-control" name="Q6_4c">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_4c == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.4d</b>&nbsp;জন্মের কত দিন পর দুধপান বন্ধ করে দিয়েছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q6_4d_M; ?>" name="Q6_4d_M" type="text" style="width: 50%;float: left;" placeholder="মাস" class="form-control">
                                        <input value="<?php echo $userInfo->Q6_4d_D; ?>" name="Q6_4d_D" type="text" style="width: 50%;float: left;" placeholder="দিন" class="form-control">
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.4.1</b>&nbsp;শিশুটি কি বয়স অনুপাতে স্বাভাবিকভাবে বাড়ছিল?
                                        </label>
                                        <select id="Q6_4_1" class="form-control" name="Q6_4_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_4_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.4.2</b>&nbsp;মৃত্যুর আগে শিশুটি কি খুব শুকিয়ে গিয়েছিল এবং দেখতে কি বুড়ো মানুষের মত দেখাতো?
                                        </label>
                                        <select id="Q6_4_2" class="form-control" name="Q6_4_2">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_4_2 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.4.3</b> &nbsp;তাহার ওজন কি মারাত্মক ভাবে কমে গিয়েছিল?
                                        </label>
                                        <select id="Q6_4_3" class="form-control" name="Q6_4_3">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_4_3 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.4.4</b>&nbsp;কত মাস/দিন যাবৎ তার ওজন কমে গিয়েছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q6_4_4_M; ?>" name="Q6_4_4_M" type="text" style="width: 50%;float: left;" placeholder="মাস" class="form-control">
                                        <input value="<?php echo $userInfo->Q6_4_4_D; ?>" name="Q6_4_4_D" type="text" style="width: 50%;float: left;" placeholder="দিন" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-8 form-group">
                                        <label>
                                            <b>6.4.5</b>&nbsp;জন্মের সময় শিশুটির কি কোন অঙ্গবিকৃতি ছিল?
                                            (যদি সবগুলি প্রশ্নের উত্তরই ”না” হয় স্কিপ করের 6.5.1)
                                        </label>
                                        <table style="width: 100%;text-align:center;border-collapse: collapse;border-color: lightgray;" border="1">

                                            <tr><td style="text-align: left;">&nbsp;ঠোট কাটা</td>
                                                <td>
                                                    <select id="Q6_4_5_A" class="form-control" name="Q6_4_5_A">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_4_5_A == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;পা বাঁকা</td>
                                                <td>
                                                    <select id="Q6_4_5_B" class="form-control" name="Q6_4_5_B">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_4_5_B == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;মাথা - খুব ছোট</td>
                                                <td>
                                                    <select id="Q6_4_5_C" class="form-control" name="Q6_4_5_C">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_4_5_C == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;মাথা - খুব বড়</td>
                                                <td>
                                                    <select id="Q6_4_5_D" class="form-control" name="Q6_4_5_D">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_4_5_D == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;মেরুদন্ডে বা পিছনে ফোলা</td>
                                                <td>
                                                    <select id="Q6_4_5_E" class="form-control" name="Q6_4_5_E">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_4_5_E == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;কানের গঠনে ত্রæটি</td>
                                                <td>
                                                    <select id="Q6_4_5_F" class="form-control" name="Q6_4_5_F">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_4_5_F == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;অন্যান্য</td>
                                                <td>
                                                    <select onchange="showHide(this.id, 'Q6_4_5_G_off')" id="Q6_4_5_G" class="form-control" name="Q6_4_5_G">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php
                                                        $i = 1;
                                                        foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) {
                                                            ?>
                                                            <option <?php if ($userInfo->Q6_4_5_G == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> <?php
                                                            if ($VA_Yes_No_Reluctant_Unknown_single->code == 1)
                                                                echo " id='Q6_4_5_G_root'";
                                                            else
                                                                echo " id='Q6_4_5_G_" . $i . "'";
                                                            ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                                <?php
                                                                $i++;
                                                            }
                                                            ?>
                                                    </select><br/>
                                                    <input value="<?php echo $userInfo->Q6_4_5_G_OTHER; ?>" <?php if (strlen($userInfo->Q6_4_5_G_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q6_4_5_G_off" type="text" name="Q6_4_5_G_OTHER" class="form-control">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.4.6</b>&nbsp;অঙ্গবিকৃতির জন্য তার কি কোন অসুবিধা হয়েছিল?
                                        </label>
                                        <select id="Q6_4_6" class="form-control" name="Q6_4_6">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_4_6 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <b> 6.5 ফ্যাকাশে/জন্ডিস (PALLOR/JAUNDICE)</b>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.5.1</b>&nbsp;মৃত্যুর আগে তাকে কি (রোগা/রক্তের অভাব) ফ্যাকাশে দেখাত বা
                                            তার হাতের তালু, চোখ বা নখ ফ্যাকাশে দেখাত?
                                        </label>
                                        <select id="Q6_5_1" class="form-control" name="Q6_5_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_5_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.5.1.1</b>&nbsp;সর্বশেষ অসুখের সময় কি মুখের ভিতর বা জিহবা ফ্যাকাশে হয়ে গিয়েছিল?
                                        </label>
                                        <select id="Q6_5_1_1" class="form-control" name="Q6_5_1_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_5_1_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.5.2</b>&nbsp;কত দিন যাবৎ তাকে ফ্যাকাশে দেখাচ্ছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q6_5_2_M; ?>" name="Q6_5_2_M" type="text" style="width: 50%;float: left;" placeholder="মাস" class="form-control">
                                        <input value="<?php echo $userInfo->Q6_5_2_D; ?>" name="Q6_5_2_D" type="text" style="width: 50%;float: left;" placeholder="দিন" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.5.3</b> &nbsp;তার চোখ/শরীরের রঙ হলদে (Jaundice) হয়েছিল কি?
                                        </label>
                                        <select id="Q6_5_3" class="form-control" name="Q6_5_3">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_5_3 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.5.4</b>&nbsp;কত দিন তাকে হলদে দেখাত?
                                        </label>
                                        <input value="<?php echo $userInfo->Q6_5_4; ?>" type="text" name="Q6_5_4" placeholder="দিন" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.5.5</b>&nbsp;তার চুলের বর্ন কি লালচে/হলদে হয়ে গিয়ে ছিল?
                                        </label>
                                        <select id="Q6_5_5" class="form-control" name="Q6_5_5">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_5_5 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <b> 6.6 শোথ/ফোলা (OEDEMATOUS  SWELLING/`LUMP OR MASS)</b>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.6.1</b>&nbsp;তার কি শরীরের কোথাও পানি জনিত (oedema) ফুলা ছিল?
                                        </label>
                                        <select id="Q6_6_1" class="form-control" name="Q6_6_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_6_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <label>
                                            <b>6.6.2</b>&nbsp;কোথায় এ পানি ফোলা ছিল? (একাধিক উত্তর হতে পারে)
                                        </label>
                                        <table style="width: 100%;text-align:center;border-collapse: collapse;border-color: lightgray;" border="1">

                                            <tr><td style="text-align: left;">&nbsp;গিট</td>
                                                <td>
                                                    <select id="Q6_6_2_A" class="form-control" name="Q6_6_2_A">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_6_2_A == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;পায়ের গোড়ালী</td>
                                                <td>
                                                    <select id="Q6_6_2_B" class="form-control" name="Q6_6_2_B">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_6_2_B == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;পেটে</td>
                                                <td>
                                                    <select id="Q6_6_2_C" class="form-control" name="Q6_6_2_C">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_6_2_C == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;মুখ</td>
                                                <td>
                                                    <select id="Q6_6_2_D" class="form-control" name="Q6_6_2_D">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_6_2_D == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;সমস্ত শরীরে</td>
                                                <td>
                                                    <select id="Q6_6_2_E" class="form-control" name="Q6_6_2_E">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_6_2_E == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;অন্যান্য</td>
                                                <td>
                                                    <select onchange="showHide(this.id, 'Q6_6_2_F_off')" id="Q6_6_2_F" class="form-control" name="Q6_6_2_F">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php
                                                        $i = 1;
                                                        foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) {
                                                            ?>
                                                            <option <?php if ($userInfo->Q6_6_2_F == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> <?php
                                                            if ($VA_Yes_No_Reluctant_Unknown_single->code == 1)
                                                                echo " id='Q6_6_2_F_root'";
                                                            else
                                                                echo " id='Q6_6_2_F_" . $i . "'";
                                                            ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                                <?php
                                                                $i++;
                                                            }
                                                            ?>
                                                    </select><br/>
                                                    <input value="<?php echo $userInfo->Q6_6_2_F_OTHER; ?>" <?php if (strlen($userInfo->Q6_6_2_F_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q6_6_2_F_off" type="text" name="Q6_6_2_F_OTHER" class="form-control">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.6.3</b>&nbsp;তার কোন অঙ্গ প্রথম ফুলেছিল?
                                        </label>
                                        <select onchange="showHide(this.id, 'Q6_6_3_off')" name="Q6_6_3" class="form-control" id="Q6_6_3">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Swollen_Body_Part as $VA_Swollen_Body_Part_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q6_6_3 == $VA_Swollen_Body_Part_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Swollen_Body_Part_single->code == 7)
                                                    echo " id='Q6_6_3_root'";
                                                else
                                                    echo " id='Q6_6_3_" . $i . "'";
                                                ?> value="<?php echo $VA_Swollen_Body_Part_single->id; ?>"><?php echo $VA_Swollen_Body_Part_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q6_6_3_OTHER; ?>" <?php if (strlen($userInfo->Q6_6_3_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q6_6_3_off" type="text" name="Q6_6_3_OTHER" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.6.3.1</b>&nbsp;মৃত্যুকালীন অসুস্থতার সময় তার পা বা পায়ের তলা ফুলে গিয়েছিল কি?
                                        </label>
                                        <select id="Q6_6_3_1" class="form-control" name="Q6_6_3_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_6_3_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.6.3.2</b>&nbsp;এই ফুলা কত মাস / দিন স্থায়ী হয়েছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q6_6_3_2_M; ?>" name="Q6_6_3_2_M" type="text" style="width: 50%;float: left;" placeholder="মাস" class="form-control">
                                        <input value="<?php echo $userInfo->Q6_6_3_2_D; ?>" name="Q6_6_3_2_D" type="text" style="width: 50%;float: left;" placeholder="দিন" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <b>গ্রন্থি ফোলা/গ্রন্থিতে চাকা (GLANDULAR SWELLING/MASS)</b>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-8 form-group">
                                        <label>
                                            <b>6.6.4</b>&nbsp;তার গ্রন্থিতে ফোলা বা চাকা (পিচলী) ছিল কি? হ্যাঁ হলে কোথায়?
                                            (উত্তর যদি ”না” বা "অজানা" হয় তবে skip to 6.6.6)
                                        </label>
                                        <table style="width: 100%;text-align:center;border-collapse: collapse;border-color: lightgray;" border="1">

                                            <tr><td style="text-align: left;">&nbsp;বগল</td>
                                                <td>
                                                    <select id="Q6_6_4_A" class="form-control" name="Q6_6_4_A">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_6_4_A == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;কুঁচকি</td>
                                                <td>
                                                    <select id="Q6_6_4_B" class="form-control" name="Q6_6_4_B">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_6_4_B == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;ঘাড়</td>
                                                <td>
                                                    <select id="Q6_6_4_C" class="form-control" name="Q6_6_4_C">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_6_4_C == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;পিঠে</td>
                                                <td>
                                                    <select id="Q6_6_4_D" class="form-control" name="Q6_6_4_D">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q6_6_4_D == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;অন্যান্য</td>
                                                <td>
                                                    <select onchange="showHide(this.id, 'Q6_6_4_E_off')" name="Q6_6_4_E" class="form-control" id="Q6_6_4_E">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php
                                                        $i = 1;
                                                        foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) {
                                                            ?>
                                                            <option <?php if ($userInfo->Q6_6_4_E == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> <?php
                                                            if ($VA_Yes_No_Reluctant_Unknown_single->code == 1)
                                                                echo " id='Q6_6_4_E_root'";
                                                            else
                                                                echo " id='Q6_6_4_E_" . $i . "'";
                                                            ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                                <?php
                                                                $i++;
                                                            }
                                                            ?>
                                                    </select>
                                                    <br/>
                                                    <input value="<?php echo $userInfo->Q6_6_4_E_OTHER; ?>" <?php if (strlen($userInfo->Q6_6_4_E_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q6_6_4_E_off" type="text" name="Q6_6_4_E_OTHER" class="form-control">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.6.5</b>&nbsp;কত মাস/ দিন গ্রন্থি ফোলা/গ্রন্থিতে চাকা ছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q6_6_5_M; ?>" name="Q6_6_5_M" type="text" style="width: 50%;float: left;" placeholder="মাস" class="form-control">
                                        <input value="<?php echo $userInfo->Q6_6_5_D; ?>" name="Q6_6_5_D" type="text" style="width: 50%;float: left;" placeholder="দিন" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.6.6</b>&nbsp;মুখের ভিতর কোন চাকা বা ক্ষত ছিল?
                                        </label>
                                        <select id="Q6_6_6" class="form-control" name="Q6_6_6">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_6_6 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.6.7</b>&nbsp;........ কি তরল পান করতে গলায় ব্যথা হতো?
                                        </label>
                                        <select id="Q6_6_7" class="form-control" name="Q6_6_7">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_6_7 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <b>6.7 কাশি (COUGH) </b>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.7.1</b>&nbsp;সর্বশেষ অসুস্থতার সময় তার কি কাঁশি ছিল?
                                        </label>
                                        <select id="Q6_7_1" class="form-control" name="Q6_7_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_7_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.7.1a</b>&nbsp;কাশির সময় কি কফ বের হতো?
                                        </label>
                                        <select id="Q6_7_1a" class="form-control" name="Q6_7_1a">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_7_1a == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.7.2</b>&nbsp;তার কত দিন/মাস যাবৎ কাঁশি ছিল?<br/>(Code: 99 = অজানা)
                                        </label>
                                        <input value="<?php echo $userInfo->Q6_7_2_M; ?>" name="Q6_7_2_M" type="text" style="width: 50%;float: left;" placeholder="মাস" class="form-control">
                                        <input value="<?php echo $userInfo->Q6_7_2_D; ?>" name="Q6_7_2_D" type="text" style="width: 50%;float: left;" placeholder="দিন" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.7.3</b>&nbsp;কাশি কি মারাত্বক ছিল?
                                        </label>
                                        <select id="Q6_7_3" class="form-control" name="Q6_7_3">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_7_3 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.7.4</b> &nbsp;কাশির পর সে কি বমি করত?
                                        </label>
                                        <select id="Q6_7_4" class="form-control" name="Q6_7_4">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_7_4 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.7.5</b>&nbsp;কাশির সাথে কি রক্ত যেত?
                                        </label>
                                        <select id="Q6_7_5" class="form-control" name="Q6_7_5">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_7_5 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.7.6</b> &nbsp;কাশি কখন বেশী হতো?
                                        </label>
                                        <select id="Q6_7_6" class="form-control" name="Q6_7_6">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Breathing_Problem_When as $VA_Breathing_Problem_When_single) { ?>
                                                <option <?php if ($userInfo->Q6_7_6 == $VA_Breathing_Problem_When_single->id) echo ' selected'; ?> value="<?php echo $VA_Breathing_Problem_When_single->id; ?>"><?php echo $VA_Breathing_Problem_When_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.7.7</b>...কাশির সময় হুপিং শব্দ (Whooping Sound) হতো কিনা?
                                        </label>
                                        <select id="Q6_7_7" class="form-control" name="Q6_7_7">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_7_7 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <b>6.8 শ্বাসকষ্ট (RESPIRATORY PROBLEMS)</b>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.8.1</b>&nbsp;তার কি শ্বাস(difficult breathing) কষ্ট ছিল?
                                        </label>
                                        <select id="Q6_8_1" class="form-control" name="Q6_8_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_8_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.8.2</b>&nbsp;কত দিন যাবৎ শ্বাস কষ্ট ছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q6_8_2_M; ?>" name="Q6_8_2_M" type="text" style="width: 50%;float: left;" placeholder="মাস" class="form-control">
                                        <input value="<?php echo $userInfo->Q6_8_2_D; ?>" name="Q6_8_2_D" type="text" style="width: 50%;float: left;" placeholder="দিন" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.8.3</b>&nbsp;সর্বশেষ অসুস্থতার সময় সে কি দ্রুত শ্বাস(fast breathing) নিত?
                                        </label>
                                        <select id="Q6_8_3" class="form-control" name="Q6_8_3">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_8_3 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.8.4</b>&nbsp;কত দিন যাবৎ সে দ্রুত শ্বাস নিয়েছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q6_8_4_M; ?>" name="Q6_8_4_M" type="text" style="width: 50%;float: left;" placeholder="মাস" class="form-control">
                                        <input value="<?php echo $userInfo->Q6_8_4_D; ?>" name="Q6_8_4_D" type="text" style="width: 50%;float: left;" placeholder="দিন" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.8.4.1</b>&nbsp;শিশুটির  কি রুদ্ধশ্বাস/থেমে থেমে শ্বাস নেয়া (Breathlessness)
                                        </label>
                                        <select id="Q6_8_4_1" class="form-control" name="Q6_8_4_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_8_4_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.8.4.2</b>&nbsp;রুদ্ধশ্বাস / থেমে থেমে শ্বাস নেয়া  ভুগে থাকলে তা কতদিন স্থায়ী ছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q6_8_4_2_M; ?>" name="Q6_8_4_2_M" type="text" style="width: 50%;float: left;" placeholder="মাস" class="form-control">
                                        <input value="<?php echo $userInfo->Q6_8_4_2_D; ?>" name="Q6_8_4_2_D" type="text" style="width: 50%;float: left;" placeholder="দিন" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <br/>
                                        <label>
                                            <b>6.8.5</b>&nbsp;তিনি কি শ্বাসকষ্টের জন্য দৈনন্দিন কাজকর্ম করতে পারতোনা?
                                        </label>
                                        <select id="Q6_8_5" class="form-control" name="Q6_8_5">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_8_5 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.8.6</b>&nbsp;তার কি নিঃশ্বাস ছাড়ার বা নেওয়ার সময় অস্বাভাবিক (ঘোত ঘোত/সা সা) শব্দ হতো?
                                            (Stridor, grunting or wheezing demonstrate)
                                        </label>
                                        <select id="Q6_8_6" class="form-control" name="Q6_8_6">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_8_6 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.8.7</b>&nbsp;শ্বাস নেয়ার সময় তার বুকে ব্যাথা হতো কি?
                                        </label>
                                        <select id="Q6_8_7" class="form-control" name="Q6_8_7">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_8_7 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.8.8</b>&nbsp;শ্বাস নেয়ার সময় বুকের খাঁচা ডেবে যেত কি?
                                        </label>
                                        <select id="Q6_8_8" class="form-control" name="Q6_8_8">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_8_8 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.8.9</b>&nbsp;শ্বাস নেয়ার সময় সে কি নীল হয়ে যেত?
                                        </label>
                                        <select id="Q6_8_9" class="form-control" name="Q6_8_9">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_8_9 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <b>হৃদপিন্ডের সমস্যা (CARDIAC PROBLEM)</b>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.8.10</b>&nbsp;তার বসার বিশেষ কোন ধরণ ছিল কি?
                                        </label> 
                                        <select id="Q6_8_10" class="form-control" name="Q6_8_10">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Sitting_Style as $VA_Sitting_Style_single) { ?>
                                                <option <?php if ($userInfo->Q6_8_10 == $VA_Sitting_Style_single->id) echo ' selected'; ?> value="<?php echo $VA_Sitting_Style_single->id; ?>"><?php echo $VA_Sitting_Style_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.8.11</b>&nbsp;কান্নার সময় নীল হয়ে যেত কি?
                                        </label>
                                        <select id="Q6_8_11" class="form-control" name="Q6_8_11">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_8_11 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.8.12</b>&nbsp;তার বুক ধড়ফড় করত কি? (বয়স ৪ বছরের বেশী হলে জিজ্ঞেস করুন)
                                        </label>
                                        <select id="Q6_8_12" class="form-control" name="Q6_8_12">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_NotApplicable_Unknown as $VA_Yes_No_Reluctant_NotApplicable_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_8_12 == $VA_Yes_No_Reluctant_NotApplicable_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_NotApplicable_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_NotApplicable_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.8.13</b>&nbsp;তার বুকে কি শন শন শব্দ হতো?
                                        </label>
                                        <select id="Q6_8_13" class="form-control" name="Q6_8_13">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_8_13 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <br/>
                                        <label>
                                            <b>6.8.14</b>&nbsp;তার ঘাড়ের কোন শিরা কি খুব ফুলে থাকতো?
                                        </label>
                                        <select id="Q6_8_14" class="form-control" name="Q6_8_14">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_8_14 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <b>6.9 ডায়রিয়া (DIARRHOEA)</b>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.9.1</b>&nbsp;তার কি ডায়রিয়া/আমাশয় হয়ে ছিল?
                                        </label>
                                        <select id="Q6_9_1" class="form-control" name="Q6_9_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_9_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.9.2</b>&nbsp;তার কত দিন ডায়রিয়া ছিল? (Code: 99 = অজানা)
                                        </label>
                                        <input value="<?php echo $userInfo->Q6_9_2; ?>" name="Q6_9_2" type="text" placeholder="দিন" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.9.3</b>&nbsp;পায়খানা কি ধরনের ছিল?
                                        </label>
                                        <select id="Q6_9_3" class="form-control" name="Q6_9_3">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Stool_Type as $VA_Stool_Type_single) { ?>
                                                <option <?php if ($userInfo->Q6_9_3 == $VA_Stool_Type_single->id) echo ' selected'; ?> value="<?php echo $VA_Stool_Type_single->id; ?>"><?php echo $VA_Stool_Type_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.9.4</b>&nbsp;ডায়রিয়া যখন মারাত্বক ছিল, তখন দিনে কত বার পায়খানা হয়েছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q6_9_4; ?>" name="Q6_9_4" type="text"  placeholder="বার " class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.9.5</b>&nbsp;তার কি পায়খানার সাথে রক্ত যেত?
                                        </label>
                                        <select id="Q6_9_5" class="form-control" name="Q6_9_5">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_9_5 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.9.6</b> &nbsp;তার কি চোখ ডেবে গিয়েছিল?
                                        </label>
                                        <select id="Q6_9_6" class="form-control" name="Q6_9_6">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_9_6 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.9.6.1</b>&nbsp;...কি স্বাভাবিকের তুলনায় প্রচুর পানি পান করতো?
                                        </label>
                                        <select id="Q6_9_6_1" class="form-control" name="Q6_9_6_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_9_6_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.9.7</b>&nbsp;ঘন ঘন পাতলা পায়খানা/রক্তযুক্ত পায়খানা কি মৃত্যু পর্যন্ত অব্যাহত ছিল?
                                        </label>
                                        <select id="Q6_9_7" class="form-control" name="Q6_9_7">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_9_7 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.9.8</b>&nbsp;মৃত্যুর কতদিন আগে ঘন ঘন পাতলা পায়খানা বন্ধ হয়েছিল?
                                        </label>  
                                        <select onchange="showHide(this.id, 'Q6_9_8_off')" name="Q6_9_8" class="form-control" id="Q6_9_8">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($va_dysentery_stop_situation as $va_dysentery_stop_situation_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q6_9_8 == $va_dysentery_stop_situation_single->id) echo ' selected'; ?> <?php
                                                if ($va_dysentery_stop_situation_single->code == 11)
                                                    echo " id='Q6_9_8_root'";
                                                else
                                                    echo " id='Q6_9_8_" . $i . "'";
                                                ?> value="<?php echo $va_dysentery_stop_situation_single->id; ?>"><?php echo $va_dysentery_stop_situation_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q6_9_8_OTHER; ?>" <?php if (strlen($userInfo->Q6_9_8_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q6_9_8_off" type="text" name="Q6_9_8_OTHER" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <b>6.10 বমি (VOMITING) </b>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-3 form-group">
                                        <label>
                                            <b>6.10.1</b>&nbsp;তার কি বমি হতো?
                                        </label>
                                        <select id="Q6_10_1" class="form-control" name="Q6_10_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_10_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>
                                            <b>6.10.2</b> &nbsp;তার কত দিন/ঘন্টা বমি ছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q6_10_2_D; ?>" name="Q6_10_2_D" type="text" style="width: 50%;float: left;" placeholder="দিন" class="form-control">
                                        <input value="<?php echo $userInfo->Q6_10_2_H; ?>" name="Q6_10_2_H" type="text" style="width: 50%;float: left;" placeholder="ঘন্টা " class="form-control">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>
                                            <b>6.10.3</b>&nbsp;বমি দেখতে কিরূপ ছিল?
                                        </label>
                                        <select onchange="showHide(this.id, 'Q6_10_3_off')" name="Q6_10_3" class="form-control" id="Q6_10_3">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Vomit_Looks_Like as $VA_Vomit_Looks_Like_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q6_10_3 == $VA_Vomit_Looks_Like_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Vomit_Looks_Like_single->code == 7)
                                                    echo " id='Q6_10_3_root'";
                                                else
                                                    echo " id='Q6_10_3_" . $i . "'";
                                                ?> value="<?php echo $VA_Vomit_Looks_Like_single->id; ?>"><?php echo $VA_Vomit_Looks_Like_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q6_10_3_OTHER; ?>" <?php if (strlen($userInfo->Q6_10_3_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q6_10_3_off" type="text" name="Q6_10_3_OTHER" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>
                                            <b>6.10.4</b>&nbsp;বমি যখন মারাত্বক ছিল তখন দিনে কত বার বমি করছিল?
                                            (Code:  98 = অসংখ্যবার)
                                        </label>
                                        <input value="<?php echo $userInfo->Q6_10_4; ?>" name="Q6_10_4" type="text"  placeholder="বার" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <b>6.11 পেট ব্যথা (ABDOMINAL PAIN)</b>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.11.1</b>&nbsp;সর্বশেষ অসুখের সময় তার কি পেট ব্যথা ছিল?
                                        </label>
                                        <select id="Q6_11_1" class="form-control" name="Q6_11_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_11_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.11.2</b>&nbsp;এটা কি ধরনের ব্যথা ছিল?
                                        </label>
                                        <select onchange="showHide(this.id, 'Q6_11_2_off')" name="Q6_11_2" class="form-control" id="Q6_11_2">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Abdominal_Pain_Type as $VA_Abdominal_Pain_Type_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q6_11_2 == $VA_Abdominal_Pain_Type_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Abdominal_Pain_Type_single->code == 4)
                                                    echo " id='Q6_11_2_root'";
                                                else
                                                    echo " id='Q6_11_2_" . $i . "'";
                                                ?> value="<?php echo $VA_Abdominal_Pain_Type_single->id; ?>"><?php echo $VA_Abdominal_Pain_Type_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q6_11_2_OTHER; ?>" <?php if (strlen($userInfo->Q6_11_2_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q6_11_2_off" type="text" name="Q6_11_2_OTHER" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.11.3</b>&nbsp;ব্যথাটি কোন জায়গায় ছিল?
                                        </label>
                                        <select onchange="showHide(this.id, 'Q6_11_3_off')" name="Q6_11_3" class="form-control" id="Q6_11_3">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Abdominal_Pain_Where as $VA_Abdominal_Pain_Where_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q6_11_3 == $VA_Abdominal_Pain_Where_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Abdominal_Pain_Where_single->code == 5)
                                                    echo " id='Q6_11_3_root'";
                                                else
                                                    echo " id='Q6_11_3_" . $i . "'";
                                                ?> value="<?php echo $VA_Abdominal_Pain_Where_single->id; ?>"><?php echo $VA_Abdominal_Pain_Where_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q6_11_3_OTHER; ?>" <?php if (strlen($userInfo->Q6_11_3_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q6_11_3_off" type="text" name="Q6_11_3_OTHER" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.11.4</b>&nbsp;ব্যথাটা কতটুকু মারাত্মক ছিল?
                                        </label>
                                        <select id="Q6_11_4" name="Q6_11_4" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Pain_Dimension as $VA_Pain_Dimension_single) { ?>
                                                <option <?php if ($userInfo->Q6_11_4 == $VA_Pain_Dimension_single->id) echo ' selected'; ?> value="<?php echo $VA_Pain_Dimension_single->id; ?>"><?php echo $VA_Pain_Dimension_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.11.5</b>&nbsp;তার পেটব্যথা কতদিন / ঘন্টা ছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q6_11_5_D; ?>" name="Q6_11_5_D" type="text" style="width: 50%;float: left;" placeholder="দিন" class="form-control">
                                        <input value="<?php echo $userInfo->Q6_11_5_H; ?>" name="Q6_11_5_H" type="text" style="width: 50%;float: left;" placeholder="ঘন্টা " class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <b>6.12 পেট ফাঁপা/ফোলা (ABDOMINAL DISTENSION) </b>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.12.1</b> &nbsp;তার কি পেট ফাঁপা/ফুলে গিয়েছিল?
                                        </label>
                                        <select id="Q6_12_1" class="form-control" name="Q6_12_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_12_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.12.1a</b>&nbsp;পেট ফাঁপা/ফোলা কি ধীরে ধীরে না তাড়াতাড়ি শুরু হয়েছিল?
                                        </label>
                                        <select id="Q6_12_1a" class="form-control" name="Q6_12_1a">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_12_1a == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.12.2</b>&nbsp;কত দিন/ঘন্টা যাবৎ এ ফুলা ছিল?
                                            (Code: 99 = অজানা)
                                        </label>
                                        <input value="<?php echo $userInfo->Q6_12_2_D; ?>" name="Q6_12_2_D" type="text" style="width: 50%;float: left;" placeholder="দিন" class="form-control">
                                        <input value="<?php echo $userInfo->Q6_12_2_H; ?>" name="Q6_12_2_H" type="text" style="width: 50%;float: left;" placeholder="ঘন্টা " class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.12.3</b>&nbsp;পেট ফাঁপা/ফোলা অবস্থায় শিশুটি কি এক বা একাধিক দিন পায়খানা করতে পারতো না?
                                        </label>
                                        <select id="Q6_12_3" class="form-control" name="Q6_12_3">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_12_3 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.12.4</b>&nbsp;মৃত্যুর আগে কত দিন যাবৎ তার পায়খানা হতো না?
                                            (Code: 99 = অজানা)
                                        </label>
                                        <input value="<?php echo $userInfo->Q6_12_4; ?>" name="Q6_12_4" type="text" placeholder="দিন" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <b>6.13 মাংশ পিন্ড/শক্ত চাকা (MASS)</b>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-3 form-group">
                                        <label>
                                            <b>6.13.1</b>&nbsp;তার পেটে কি কোন শক্ত চাকা ছিল?
                                        </label>
                                        <select id="Q6_13_1" class="form-control" name="Q6_13_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_13_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>
                                            <b>6.13.2</b>&nbsp;শক্ত চাকাটি কোথায় ছিল?
                                        </label>
                                        <select onchange="showHide(this.id, 'Q6_13_2_off')" name="Q6_13_2" class="form-control" id="Q6_13_2">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_MASS_in_Abdomen_Strong_Wheel_Position as $VA_MASS_in_Abdomen_Strong_Wheel_Position_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q6_13_2 == $VA_MASS_in_Abdomen_Strong_Wheel_Position_single->id) echo ' selected'; ?> <?php
                                                if ($VA_MASS_in_Abdomen_Strong_Wheel_Position_single->code == 6)
                                                    echo " id='Q6_13_2_root'";
                                                else
                                                    echo " id='Q6_13_2_" . $i . "'";
                                                ?> value="<?php echo $VA_MASS_in_Abdomen_Strong_Wheel_Position_single->id; ?>"><?php echo $VA_MASS_in_Abdomen_Strong_Wheel_Position_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q6_13_2_OTHER; ?>" <?php if (strlen($userInfo->Q6_13_2_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q6_13_2_off" type="text" name="Q6_13_2_OTHER" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>
                                            <b>6.13.3</b>&nbsp;শক্ত চাকাটি ব্যথা যুক্ত ছিল?
                                        </label>
                                        <select id="Q6_13_3" class="form-control" name="Q6_13_3">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_13_3 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>
                                            <b>6.13.4</b> &nbsp;কত দিন যাবৎ চাকাটি ছিল?(Code: 99 = অজানা)
                                        </label>
                                        <input type="text"  placeholder="দিন" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <b>6.14 মাথা ব্যথা (MASS)<br/>Note: মৃত শিশুর বয়স পাঁচ বছরের বেশী হলে জিজ্ঞেস করুন।</b></div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.14.1</b>&nbsp;তার কি মাথা ব্যথা ছিল?
                                        </label>
                                        <select id="Q6_14_1" class="form-control" name="Q6_14_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_NotApplicable_Unknown as $VA_Yes_No_Reluctant_NotApplicable_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_14_1 == $VA_Yes_No_Reluctant_NotApplicable_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_NotApplicable_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_NotApplicable_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.14.2</b>&nbsp;মাথা ব্যথা কতটুকু মারাত্বক ছিল?
                                        </label>
                                        <select id="Q6_14_2" name="Q6_14_2" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Pain_Dimension as $VA_Pain_Dimension_single) { ?>
                                                <option <?php if ($userInfo->Q6_14_2 == $VA_Pain_Dimension_single->id) echo ' selected'; ?> value="<?php echo $VA_Pain_Dimension_single->id; ?>"><?php echo $VA_Pain_Dimension_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.14.3</b> &nbsp;কত দিন তার মাথা ব্যথা ছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q6_14_3_M; ?>" name="Q6_14_3_M" type="text" style="width: 50%;float: left;" placeholder="মাস" class="form-control">
                                        <input value="<?php echo $userInfo->Q6_14_3_D; ?>" name="Q6_14_3_D" type="text" style="width: 50%;float: left;" placeholder="দিন" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <b>6.15 ঘাড় শক্ত বা ঘাড় ব্যথা (STIFF NECK OR PAINFUL NECK) </b></div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.15.1</b>&nbsp;...কি সারা শরীর শক্ত হয়ে গিয়েছিল বা মুখ খুলতে পারতোনা?
                                        </label>
                                        <select id="Q6_15_1" class="form-control" name="Q6_15_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_15_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.15.2</b>&nbsp;সর্বশেষ অসুখের সময় তার কি ঘাড় শক্ত বা ঘাড় ব্যথা হয়ে ছিল?
                                        </label>
                                        <select id="Q6_15_2" class="form-control" name="Q6_15_2">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_15_2 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.15.3</b>&nbsp;কত মাস/দিন ঘাড় শক্ত বা ঘাড় ব্যথা ছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q6_15_3_M; ?>" name="Q6_15_3_M" type="text" style="width: 50%;float: left;" placeholder="মাস" class="form-control">
                                        <input value="<?php echo $userInfo->Q6_15_3_D; ?>" name="Q6_15_3_D" type="text" style="width: 50%;float: left;" placeholder="দিন" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.15.4</b> &nbsp;সমস্ত শরীর কি ধনুকের মত বাঁকা হয়ে খিঁচুনী হতো? (মৃত্যুকালে শিশুর বয়স এক বছরের কম হলে)
                                        </label> 
                                        <select id="Q6_15_4" class="form-control" name="Q6_15_4">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Body_Curves_Like_Bow as $VA_Body_Curves_Like_Bow_single) { ?>
                                                <option <?php if ($userInfo->Q6_15_4 == $VA_Body_Curves_Like_Bow_single->id) echo ' selected'; ?> value="<?php echo $VA_Body_Curves_Like_Bow_single->id; ?>"><?php echo $VA_Body_Curves_Like_Bow_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            <b>6.15.5</b>&nbsp;মৃত্যুকালীন অসুখের সময় মাথার চাঁদি ফুলে গিয়েছিল? (১ বছর বয়সের কম হলে)
                                        </label>
                                        <select class="form-control" name="Q6_15_5">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_NotApplicable_Unknown as $VA_Yes_No_Reluctant_NotApplicable_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_15_5 == $VA_Yes_No_Reluctant_NotApplicable_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_NotApplicable_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_NotApplicable_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                        <b>6.16 ও খিঁচুনী (CONVULSION)</b>
                                    </div>

                                    <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                        <div class="col-md-4 form-group">
                                            <label>
                                                <b>6.16.0</b>&nbsp;মৃত্যুর সময় শিশুটির বয়স কত ছিল ?
                                            </label>
                                            <select class="form-control" name="Q6_16">
                                                <option id="0" value="">নির্বাচন করুন</option>
                                                <?php foreach ($VA_Child_Age as $VA_Child_Age_single) { ?>
                                                    <option <?php if ($userInfo->Q6_16 == $VA_Child_Age_single->id) echo ' selected'; ?> value="<?php echo $VA_Child_Age_single->id; ?>"><?php echo $VA_Child_Age_single->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>
                                                <b>6.16.a</b>&nbsp;শিশুটি জন্মের ২৪ ঘন্টার মধ্যে খিঁচুনী হয়েছিল?
                                            </label>
                                            <select id="Q6_16a" class="form-control" name="Q6_16a">
                                                <option id="0" value="">নির্বাচন করুন</option>
                                                <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                    <option <?php if ($userInfo->Q6_16a == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>
                                                <b>6.16.b</b>&nbsp;শিশুটি জন্মের ২৪ ঘন্টা পরে খিঁচুনী হয়েছিল?
                                            </label>
                                            <select id="Q6_16b" class="form-control" name="Q6_16b">
                                                <option id="0" value="">নির্বাচন করুন</option>
                                                <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                    <option <?php if ($userInfo->Q6_16b == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                        <div class="col-md-3 form-group">
                                            <label>
                                                <b>6.16.1</b>&nbsp;সর্বশেষ অসুখের সময় তার খিঁচুনী হয়েছিল কি?
                                            </label>
                                            <select id="Q6_16_1" class="form-control" name="Q6_16_1">
                                                <option id="0" value="">নির্বাচন করুন</option>
                                                <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                    <option <?php if ($userInfo->Q6_16_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>
                                                <b>6.16.2</b>&nbsp;কতদিন যাবৎ তার খিঁচুনী ছিল?
                                            </label>
                                            <input value="<?php echo $userInfo->Q6_16_2; ?>" name="Q6_16_2" type="text" placeholder="দিন" class="form-control">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>
                                                <b>6.16.3</b>&nbsp;এই ধরনের খিঁচুনী আগেও হয়েছিল কি?
                                            </label>
                                            <select id="Q6_16_3" class="form-control" name="Q6_16_3">
                                                <option id="0" value="">নির্বাচন করুন</option>
                                                <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                    <option <?php if ($userInfo->Q6_16_3 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>
                                                <b>6.16.4</b>&nbsp;গত ১ বছরের মধ্যে শরীরের কোথাও কি কেটেছিল / ক্ষত ছিল?
                                            </label>
                                            <select id="Q6_16_4" class="form-control" name="Q6_16_4">
                                                <option id="0" value="">নির্বাচন করুন</option>
                                                <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                    <option <?php if ($userInfo->Q6_16_4 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                        <b>6.17 অজ্ঞান (UNCONSCIOUSNESS)</b>
                                    </div>
                                    <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                        <div class="col-md-4 form-group">
                                            <label>
                                                <b>6.17.1</b>&nbsp;সর্বশেষ অসুখের সময় --- হতভম্ব অবস্থা হয়েছিল?
                                            </label>
                                            <select id="Q6_17_1" class="form-control" name="Q6_17_1">
                                                <option id="0" value="">নির্বাচন করুন</option>
                                                <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                    <option <?php if ($userInfo->Q6_17_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>
                                                <b>6.17.2</b>&nbsp;কতদিন যাবৎ এ অবস্থায় ছিল?
                                            </label>
                                            <input value="<?php echo $userInfo->Q6_17_2_D; ?>" name="Q6_17_2_D" type="text" style="width: 50%;float: left;" placeholder="দিন" class="form-control">
                                            <input value="<?php echo $userInfo->Q6_17_2_H; ?>" name="Q6_17_2_H" type="text" style="width: 50%;float: left;" placeholder="ঘন্টা " class="form-control">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>
                                                <b>6.17.3</b>&nbsp;মৃত্যুর আগে শিশুটি কি অজ্ঞান ছিল?
                                            </label>
                                            <select id="Q6_17_3" class="form-control" name="Q6_17_3">
                                                <option id="0" value="">নির্বাচন করুন</option>
                                                <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                    <option <?php if ($userInfo->Q6_17_3 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                        <div class="col-md-4 form-group">
                                            <label>
                                                <b>6.17.4</b>&nbsp;কতদিন/ঘন্টা যাবৎ অজ্ঞান ছিল?<br/>(Code: 99 = অজানা)
                                            </label>
                                            <input value="<?php echo $userInfo->Q6_17_4_D; ?>" name="Q6_17_4_D" type="text" style="width: 50%;float: left;" placeholder="দিন" class="form-control">
                                            <input value="<?php echo $userInfo->Q6_17_4_H; ?>" name="Q6_17_4_H" type="text" style="width: 50%;float: left;" placeholder="ঘন্টা " class="form-control">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>
                                                <b>6.17.5</b>&nbsp;কিভাবে এটি শুরু হয়েছিল?
                                            </label>
                                            <select id="Q6_17_5" name="Q6_17_5" class="form-control">
                                                <option id="0" value="">নির্বাচন করুন</option>
                                                <?php foreach ($VA_Suddenly_Slowly_Unknown as $VA_Suddenly_Slowly_Unknown_single) { ?>
                                                    <option <?php if ($userInfo->Q6_17_5 == $VA_Suddenly_Slowly_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Suddenly_Slowly_Unknown_single->id; ?>"><?php echo $VA_Suddenly_Slowly_Unknown_single->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>
                                                <b>6.17.6</b>&nbsp;...কি খিঁচুনীর পর পর অঞ্জান হয়ে গিয়েছিল?
                                            </label>
                                            <select id="Q6_17_6" class="form-control" name="Q6_17_6">
                                                <option id="0" value="">নির্বাচন করুন</option>
                                                <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                    <option <?php if ($userInfo->Q6_17_6 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                        <b>6.18 পক্ষাঘাত বা অবশ (PARALYSIS)</b>
                                    </div>
                                    <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                        <div class="col-md-4 form-group">
                                            <label>
                                                <b>6.18.1</b>&nbsp;মৃত্যুর আগে তার কি দেহের কোন অঙ্গ/পাশ অবশ
                                            </label>
                                            <select id="Q6_18_1" class="form-control" name="Q6_18_1">
                                                <option id="0" value="">নির্বাচন করুন</option>
                                                <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                    <option <?php if ($userInfo->Q6_18_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>
                                                <b>6.18.2</b>&nbsp;দেহের কোন অঙ্গ/পাশ অবশ হয়ে ছিল?
                                            </label>
                                            <select onchange="showHide(this.id, 'Q6_18_2_off')" name="Q6_18_2" class="form-control" id="Q6_18_2">
                                                <option id="0" value="">নির্বাচন করুন</option>
                                                <?php
                                                $i = 1;
                                                foreach ($VA_Paralyzed_Body_Part as $VA_Paralyzed_Body_Part_single) {
                                                    ?>
                                                    <option <?php if ($userInfo->Q6_18_2 == $VA_Paralyzed_Body_Part_single->id) echo ' selected'; ?> <?php
                                                    if ($VA_Paralyzed_Body_Part_single->code == 8)
                                                        echo " id='Q6_18_2_root'";
                                                    else
                                                        echo " id='Q6_18_2_" . $i . "'";
                                                    ?> value="<?php echo $VA_Paralyzed_Body_Part_single->id; ?>"><?php echo $VA_Paralyzed_Body_Part_single->name; ?></option>
                                                        <?php
                                                        $i++;
                                                    }
                                                    ?>
                                            </select>
                                            <br/>
                                            <input value="<?php echo $userInfo->Q6_18_2_OTHER; ?>" <?php if (strlen($userInfo->Q6_18_2_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q6_18_2_off" type="text" name="Q6_18_2_OTHER" class="form-control">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>
                                                <b>6.18.3</b>&nbsp;কত বছর/মাস/দিন যাবৎ অবশ ছিল?<br/>
                                                (Code: 99 = অজানা)
                                            </label>
                                            <input value="<?php echo $userInfo->Q6_18_3_Y; ?>" name="Q6_18_3_Y" type="text" style="width: 33%;float: left;" placeholder="বছর " class="form-control">
                                            <input value="<?php echo $userInfo->Q6_18_3_M; ?>" name="Q6_18_3_M" type="text" style="width: 33%;float: left;" placeholder="মাস " class="form-control">
                                            <input value="<?php echo $userInfo->Q6_18_3_D; ?>" name="Q6_18_3_D" type="text" style="width: 33%;float: left;" placeholder="দিন" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                        <b>6.19 প্রস্রাবের রং (URINE COLOUR)</b>
                                    </div>
                                    <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                        <div class="col-md-4 form-group">
                                            <label>
                                                <b>6.19.1</b>&nbsp;শিশুটির কি প্রস্রাবের রং পরিবর্তন হয়ে গিয়েছিল?
                                            </label>
                                            <select id="Q6_19_1" class="form-control" name="Q6_19_1">
                                                <option id="0" value="">নির্বাচন করুন</option>
                                                <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                    <option <?php if ($userInfo->Q6_19_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>
                                                <b>6.19.2</b>&nbsp;প্রস্র্রাবরে রং কি রুপ ছিল?
                                            </label>
                                            <select id="Q6_19_2" class="form-control" name="Q6_19_2">
                                                <option id="0" value="">নির্বাচন করুন</option>
                                                <?php foreach ($VA_Urine_Color as $VA_Urine_Color_single) { ?>
                                                    <option <?php if ($userInfo->Q6_19_2 == $VA_Urine_Color_single->id) echo ' selected'; ?> value="<?php echo $VA_Urine_Color_single->id; ?>"><?php echo $VA_Urine_Color_single->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>
                                                <b>6.19.3</b>&nbsp;কত দিন যাবৎ প্রস্রাবের রং পরিবর্তিত?<br/>
                                                (Code: 99 = অজানা)
                                            </label>
                                            <input value="<?php echo $userInfo->Q6_19_3; ?>" name="Q6_19_3" type="text"  placeholder="দিন" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                        <b>6.20 প্রস্রাবের পরিমান (URINE AMOUNT) </b>
                                    </div>
                                    <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                        <div class="col-md-4 form-group">
                                            <label>
                                                <b>6.20.1</b>&nbsp;দৈনিক ত্যাগকৃৃত প্রস্রাবের পরিমানে কোন পরিবর্তন হয়েছিল কি?
                                            </label>
                                            <select id="Q6_20_1" class="form-control" name="Q6_20_1">
                                                <option id="0" value="">নির্বাচন করুন</option>
                                                <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                    <option <?php if ($userInfo->Q6_20_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>
                                                <b>6.20.2</b>&nbsp;শিশুটি দৈনিক কি পরিমান প্রস্রাব ত্যাগ করতো?
                                            </label>
                                            <select id="Q6_20_2" class="form-control" name="Q6_20_2">
                                                <option id="0" value="">নির্বাচন করুন</option>
                                                <?php foreach ($VA_Urine_Dimension as $VA_Urine_Dimension_single) { ?>
                                                    <option <?php if ($userInfo->Q6_20_2 == $VA_Urine_Dimension_single->id) echo ' selected'; ?> value="<?php echo $VA_Urine_Dimension_single->id; ?>"><?php echo $VA_Urine_Dimension_single->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>
                                                <b>6.20.3</b>&nbsp;কতদিন যাবৎ প্রস্রাবের পরিমানে এই পরিবর্তন হয়েছিল?
                                                (Code: 99 = অজানা)
                                            </label>
                                            <input value="<?php echo $userInfo->Q6_20_3; ?>" name="Q6_20_3" type="text" placeholder="দিন" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                        <div class="col-md-4 form-group">
                                            <label>
                                                <b>6.20.4.a</b> &nbsp;শিশুটির প্রস্রাবের সাথে কখনো রক্ত গিয়েছিল কি?
                                            </label>
                                            <select id="Q6_20_4a" class="form-control" name="Q6_20_4a">
                                                <option id="0" value="">নির্বাচন করুন</option>
                                                <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                    <option <?php if ($userInfo->Q6_20_4a == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>
                                                <b>6.20.4.b</b> &nbsp;প্রস্রাব  করতে তার কি কোন অসুবিধা ছিল?
                                            </label>
                                            <select id="Q6_20_4b" class="form-control" name="Q6_20_4b">
                                                <option id="0" value="">নির্বাচন করুন</option>
                                                <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                    <option <?php if ($userInfo->Q6_20_4b == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>
                                                <b>6.20.5</b>&nbsp;কি ধরনের অসুবিধা হয়েছিল?
                                                (একাধিক উত্তর হতে পারে)
                                            </label>
                                            <table style="width: 100%;text-align:center;border-collapse: collapse;border-color: lightgray;" border="1">

                                                <tr><td style="text-align: left;">&nbsp;মুত্র ত্যাগে অসমর্থ</td>
                                                    <td>
                                                        <select id="Q6_20_5_A" class="form-control" name="Q6_20_5_A">
                                                            <option id="0" value="">নির্বাচন করুন</option>
                                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                                <option <?php if ($userInfo->Q6_20_5_A == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr><td style="text-align: left;">&nbsp;অনবরত ফোটায় ফোটায় মুত্র ঝরা</td>
                                                    <td>
                                                        <select id="Q6_20_5_B" class="form-control" name="Q6_20_5_B">
                                                            <option id="0" value="">নির্বাচন করুন</option>
                                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                                <option <?php if ($userInfo->Q6_20_5_B == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr><td style="text-align: left;">&nbsp;জ্বালাপোড়া ভাব</td>
                                                    <td>
                                                        <select id="Q6_20_5_C" class="form-control" name="Q6_20_5_C">
                                                            <option id="0" value="">নির্বাচন করুন</option>
                                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                                <option <?php if ($userInfo->Q6_20_5_C == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr><td style="text-align: left;">&nbsp;অন্যান্য</td>
                                                    <td>
                                                        <select onchange="showHide(this.id, 'Q6_20_5_D_off')" name="Q6_20_5_D" class="form-control" id="Q6_20_5_D">
                                                            <option id="0" value="">নির্বাচন করুন</option>    
                                                            <?php
                                                            $i = 1;
                                                            foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) {
                                                                ?>
                                                                <option <?php if ($userInfo->Q6_20_5_D == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> <?php
                                                                if ($VA_Yes_No_Reluctant_Unknown_single->code == 1)
                                                                    echo " id='Q6_20_5_D_root'";
                                                                else
                                                                    echo " id='Q6_20_5_D_" . $i . "'";
                                                                ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                                    <?php
                                                                    $i++;
                                                                }
                                                                ?>
                                                        </select>
                                                        <br/>
                                                        <input value="<?php echo $userInfo->Q6_20_5_D_OTHER; ?>" <?php if (strlen($userInfo->Q6_20_5_D_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q6_20_5_D_off" type="text" name="Q6_20_5_D_OTHER" class="form-control">
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                        <b>6.21 অস্ত্রোপচার (SURGERY/OPERATION) </b>
                                    </div>
                                    <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                        <div class="col-md-4 form-group">
                                            <label>
                                                <b>6.21.1</b>&nbsp;মৃত্যুকালীন অসুখের সময় তার কি কোন অস্ত্রোপচার হয়েছিল?
                                            </label>
                                            <select id="Q6_21_1" class="form-control" name="Q6_21_1">
                                                <option id="0" value="">নির্বাচন করুন</option>
                                                <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                    <option <?php if ($userInfo->Q6_21_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>
                                                <b>6.21.2</b>&nbsp;মৃত্যুর কতদিন/মাস পুর্বে তার শেষ অস্ত্রোপচার হয়েছিল?
                                                (Code: 99 = অজানা)
                                            </label>
                                            <input value="<?php echo $userInfo->Q6_21_2_M; ?>" name="Q6_21_2_M" type="text" style="width: 50%;float: left;" placeholder="মাস" class="form-control">
                                            <input value="<?php echo $userInfo->Q6_21_2_D; ?>" name="Q6_21_2_D" type="text" style="width: 50%;float: left;" placeholder="দিন" class="form-control">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>
                                                <b>6.21.3</b>&nbsp; অপারেশন শরীরের কোথায় হয়েছিল?
                                            </label>
                                            <input value="<?php echo $userInfo->Q6_21_3; ?>" name="Q6_21_3" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                        <b>VII MEDICAL CONSULTATIONS</b>
                                    </div>
                                    <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                        <div class="col-md-4 form-group">
                                            <label>
                                                <b>7.1</b>&nbsp;যে অসুস্থতার জন্য শিশুটি মারা গিয়েছিল, সে অসুখের জন্য কোন চিকিৎসা পেয়েছিল কি?
                                            </label>
                                            <select id="Q7_1" class="form-control" name="Q7_1">
                                                <option id="0" value="">নির্বাচন করুন</option>
                                                <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                    <option <?php if ($userInfo->Q7_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                        <b>7.1.1</b>&nbsp;শিশুটির মৃত্যুকালীন অসুস্থতার সময় কে কে  তার চিকিৎসা করেছিলেন? (একাধিক উত্তর হতে পারে)
                                        <br/> <b>নির্দেশাবলী:</b> উত্তরদাতার উত্তর দেওয়া শেষ হওয়ার সাথে সাথে জিজ্ঞাসা করুন: আর কোথাও থেকে চিকিৎসা নিয়েছিল কি?
                                        জিজ্ঞাসা করতে থাকুন, যতক্ষন না পর্যন্ত উত্তরদাতা বলেন যে, আর কোথাও থেকে চিকিৎসা নেয়নি।
                                    </div>
                                    <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                        <div class="col-md-3 form-group">
                                            <label>
                                                a. 1st Provider
                                            </label>
                                            <select onchange="showHide(this.id, 'Q7_1_1_A_off')" name="Q7_1_1_A" class="form-control" id="Q7_1_1_A">
                                                <option id="0" value="">নির্বাচন করুন</option>
                                                <?php
                                                $i = 1;
                                                foreach ($VA_Treatment_Provider as $VA_Treatment_Provider_single) {
                                                    ?>
                                                    <option <?php if ($userInfo->Q7_1_1_A == $VA_Treatment_Provider_single->id) echo ' selected'; ?> <?php
                                                    if ($VA_Treatment_Provider_single->code == 11)
                                                        echo " id='Q7_1_1_A_root'";
                                                    else
                                                        echo " id='Q7_1_1_A_" . $i . "'";
                                                    ?> value="<?php echo $VA_Treatment_Provider_single->id; ?>"><?php echo $VA_Treatment_Provider_single->name; ?></option>
                                                        <?php
                                                        $i++;
                                                    }
                                                    ?>
                                            </select>
                                            <br/>
                                            <input value="<?php echo $userInfo->Q7_1_1_A_OTHER; ?>" <?php if (strlen($userInfo->Q7_1_1_A_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q7_1_1_A_off" type="text" name="Q7_1_1_A_OTHER" class="form-control">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>
                                                b. 2nd Provider
                                            </label>

                                            <select onchange="showHide(this.id, 'Q7_1_1_B_off')" name="Q7_1_1_B" class="form-control" id="Q7_1_1_B">
                                                <option id="0" value="">নির্বাচন করুন</option>
                                                <?php
                                                $i = 1;
                                                foreach ($VA_Treatment_Provider as $VA_Treatment_Provider_single) {
                                                    ?>
                                                    <option <?php if ($userInfo->Q7_1_1_B == $VA_Treatment_Provider_single->id) echo ' selected'; ?> <?php
                                                    if ($VA_Treatment_Provider_single->code == 11)
                                                        echo " id='Q7_1_1_B_root'";
                                                    else
                                                        echo " id='Q7_1_1_B_" . $i . "'";
                                                    ?> value="<?php echo $VA_Treatment_Provider_single->id; ?>"><?php echo $VA_Treatment_Provider_single->name; ?></option>
                                                        <?php
                                                        $i++;
                                                    }
                                                    ?>
                                            </select>
                                            <br/>
                                            <input value="<?php echo $userInfo->Q7_1_1_B_OTHER; ?>" <?php if (strlen($userInfo->Q7_1_1_B_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q7_1_1_B_off" type="text" name="Q7_1_1_B_OTHER" class="form-control">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>
                                                c. 3rd Provider
                                            </label>
                                            <select onchange="showHide(this.id, 'Q7_1_1_C_off')" name="Q7_1_1_C" class="form-control" id="Q7_1_1_C">
                                                <option id="0" value="">নির্বাচন করুন</option>
                                                <?php
                                                $i = 1;
                                                foreach ($VA_Treatment_Provider as $VA_Treatment_Provider_single) {
                                                    ?>
                                                    <option <?php if ($userInfo->Q7_1_1_C == $VA_Treatment_Provider_single->id) echo ' selected'; ?> <?php
                                                    if ($VA_Treatment_Provider_single->code == 11)
                                                        echo " id='Q7_1_1_C_root'";
                                                    else
                                                        echo " id='Q7_1_1_C_" . $i . "'";
                                                    ?> value="<?php echo $VA_Treatment_Provider_single->id; ?>"><?php echo $VA_Treatment_Provider_single->name; ?></option>
                                                        <?php
                                                        $i++;
                                                    }
                                                    ?>
                                            </select>
                                            <br/>
                                            <input value="<?php echo $userInfo->Q7_1_1_C_OTHER; ?>" <?php if (strlen($userInfo->Q7_1_1_C_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q7_1_1_C_off" type="text" name="Q7_1_1_C_OTHER" class="form-control">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>
                                                d. 4th/last Provider
                                            </label>
                                            <select onchange="showHide(this.id, 'Q7_1_1_D_off')" name="Q7_1_1_D" class="form-control" id="Q7_1_1_D">
                                                <option id="0" value="">নির্বাচন করুন</option>
                                                <?php
                                                $i = 1;
                                                foreach ($VA_Treatment_Provider as $VA_Treatment_Provider_single) {
                                                    ?>
                                                    <option <?php if ($userInfo->Q7_1_1_D == $VA_Treatment_Provider_single->id) echo ' selected'; ?> <?php
                                                    if ($VA_Treatment_Provider_single->code == 11)
                                                        echo " id='Q7_1_1_D_root'";
                                                    else
                                                        echo " id='Q7_1_1_D_" . $i . "'";
                                                    ?> value="<?php echo $VA_Treatment_Provider_single->id; ?>"><?php echo $VA_Treatment_Provider_single->name; ?></option>
                                                        <?php
                                                        $i++;
                                                    }
                                                    ?>
                                            </select>
                                            <br/>
                                            <input value="<?php echo $userInfo->Q7_1_1_D_OTHER; ?>" <?php if (strlen($userInfo->Q7_1_1_D_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q7_1_1_D_off" type="text" name="Q7_1_1_D_OTHER" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                        <div class="col-md-6 form-group">
                                            <label><b>7.1.2</b>&nbsp;সর্বশেষ অসুখের সময় শিশুটিকে চিকিৎসার জন্য স্বাস্থ্য প্রতিষ্ঠানে নিয়ে থাকলে তার নামের পাশে নম্বরে বৃত্তায়িত করুন।</label>
                                            <select onchange="showHide(this.id, 'Q7_1_2_off')" id="Q7_1_2" class="form-control" name="Q7_1_2">
                                                <option id="0" value="">নির্বাচন করুন</option>
                                                <?php
                                                $i = 1;
                                                foreach ($VA_Delivery_Place as $VA_Delivery_Place_single) {
                                                    ?>
                                                    <option <?php if ($userInfo->Q7_1_2 == $VA_Delivery_Place_single->id) echo ' selected'; ?> <?php
                                                    if ($VA_Delivery_Place_single->code == 11)
                                                        echo " id='Q7_1_2_root'";
                                                    else
                                                        echo " id='Q7_1_2_" . $i . "'";
                                                    ?> value="<?php echo $VA_Delivery_Place_single->id; ?>"><?php echo $VA_Delivery_Place_single->name; ?></option>
                                                        <?php
                                                        $i++;
                                                    }
                                                    ?>
                                            </select><br/>
                                            <input value="<?php echo $userInfo->Q7_1_2_OTHER; ?>" <?php if (strlen($userInfo->Q7_1_2_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q7_1_2_off" type="text" name="Q7_1_2_OTHER" class="form-control">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>
                                                <b>7.1.3</b>&nbsp;যে চিকিৎসা পেয়েছিল তার ধরন কি ছিল?
                                            </label>
                                            <table style="width: 100%;text-align:center;border-collapse: collapse;border-color: lightgray;" border="1">

                                                <tr><td style="text-align: left;">&nbsp;Antiretroviral therapy(ART drug)</td>
                                                    <td>
                                                        <select id="Q7_1_3_A" class="form-control" name="Q7_1_3_A">
                                                            <option id="0" value="">নির্বাচন করুন</option>
                                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                                <option <?php if ($userInfo->Q7_1_3_A == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr><td style="text-align: left;">&nbsp;ORS/IV Fluid</td>
                                                    <td>
                                                        <select id="Q7_1_3_B" class="form-control" name="Q7_1_3_B">
                                                            <option id="0" value="">নির্বাচন করুন</option>
                                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                                <option <?php if ($userInfo->Q7_1_3_B == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr><td style="text-align: left;">&nbsp;রক্ত সঞ্চালন</td>
                                                    <td>
                                                        <select id="Q7_1_3_C" class="form-control" name="Q7_1_3_C">
                                                            <option id="0" value="">নির্বাচন করুন</option>
                                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                                <option <?php if ($userInfo->Q7_1_3_C == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr><td style="text-align: left;">&nbsp;নাকের ভিতর টিউব দিয়ে চিকিৎসা বা খাওয়ানো</td>
                                                    <td>
                                                        <select id="Q7_1_3_D" class="form-control" name="Q7_1_3_D">
                                                            <option id="0" value="">নির্বাচন করুন</option>
                                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                                <option <?php if ($userInfo->Q7_1_3_D == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr><td style="text-align: left;">&nbsp;এন্টিবায়োটি ইনজেকশন</td>
                                                    <td>
                                                        <select id="Q7_1_3_E" class="form-control" name="Q7_1_3_E">
                                                            <option id="0" value="">নির্বাচন করুন</option>
                                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                                <option <?php if ($userInfo->Q7_1_3_E == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr><td style="text-align: left;">&nbsp;অন্যান্য চিকিৎসা</td>
                                                    <td>
                                                        <select onchange="showHide(this.id, 'Q7_1_3_F_off')" name="Q7_1_3_F" class="form-control" id="Q7_1_3_F">
                                                            <option id="0" value="">নির্বাচন করুন</option>
                                                            <?php
                                                            $i = 1;
                                                            foreach ($VA_Yes_No_Unknown as $VA_Yes_No_Unknown_single) {
                                                                ?>
                                                                <option <?php if ($userInfo->Q7_1_3_F == $VA_Yes_No_Unknown_single->id) echo ' selected'; ?> <?php
                                                                if ($VA_Yes_No_Unknown_single->code == 1)
                                                                    echo " id='Q7_1_3_F_root'";
                                                                else
                                                                    echo " id='Q7_1_3_F_" . $i . "'";
                                                                ?> value="<?php echo $VA_Yes_No_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Unknown_single->name; ?></option>
                                                                    <?php
                                                                    $i++;
                                                                }
                                                                ?>
                                                        </select>
                                                        <br/>
                                                        <input value="<?php echo $userInfo->Q7_1_3_F_OTHER; ?>" <?php if (strlen($userInfo->Q7_1_3_F_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q7_1_3_F_off" type="text" name="Q7_1_3_F_OTHER" class="form-control">
                                                    </td>
                                                </tr>
                                                <tr><td colspan="2" style="text-align: left;">&nbsp;<b>Note:</b>  বাড়ীতে চিকিৎসা হলে (Skip to 7.3)</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                        <div class="col-md-3 form-group">
                                            <label>
                                                <b>7.1.4</b>&nbsp;স্বাস্থ্যসেবা প্রতিষ্ঠানে যেতে মোটরযান ব্যবহার করেছিল?
                                            </label>
                                            <select id="Q7_1_4" class="form-control" name="Q7_1_4">
                                                <option id="0" value="">নির্বাচন করুন</option>
                                                <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                    <option <?php if ($userInfo->Q7_1_4 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>
                                                <b>7.2</b>&nbsp;মৃত্যুর আগে তাকে হাসপাতালে/ক্লিনিকে ভর্তি করানো  হয়ে ছিল কি?
                                            </label>
                                            <select id="Q7_2" class="form-control" name="Q7_2">
                                                <option id="0" value="">নির্বাচন করুন</option>
                                                <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                    <option <?php if ($userInfo->Q7_2 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php
                                    $partsRequire = explode('-', $userInfo->Q7_2_1_1_DATE);
                                    $Q7_2_1_1_DATE = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];

                                    $partsRequire = explode('-', $userInfo->Q7_2_1_2_DATE);
                                    $Q7_2_1_2_DATE = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];

                                    $partsRequire = explode('-', $userInfo->Q7_2_1_3_DATE);
                                    $Q7_2_1_3_DATE = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];
                                    ?>

                                    <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                        <label>
                                            <b>7.2.1</b> &nbsp;হাসপাতালে ভর্তির তালিকা লিখুন: (অতি সাম্প্রতিক থেকে শুরু করুন)
                                        </label>
                                    </div>
                                    <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                        <div class="col-md-4 form-group">
                                            <label>
                                                1. স্বাস্থ্যসেবা প্রতিষ্ঠানের নাম
                                            </label>
                                            <select id="Q7_2_1_1_HCODE" name="Q7_2_1_1_HCODE" class="form-control">
                                                <option id="0" value="">নির্বাচন করুন</option>
                                                <?php foreach ($VA_Hospital_List as $VA_Hospital_List_single) { ?>
                                                    <option <?php if ($userInfo->Q7_2_1_1_HCODE == $VA_Hospital_List_single->id) echo ' selected'; ?> value="<?php echo $VA_Hospital_List_single->id; ?>"><?php echo $VA_Hospital_List_single->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>
                                                তারিখ
                                            </label>
                                            <input value="<?php if ($userInfo->Q7_2_1_1_DATE != "0000-00-00") echo $Q7_2_1_1_DATE; ?>" id="Q7_2_1_1_DATE" name="Q7_2_1_1_DATE" autocomplete="off" type="text" class="datepicker form-control">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>
                                                হাসপাতালে ভর্তির কারণ সমূহ
                                            </label>
                                            <input value="<?php echo $userInfo->Q7_2_1_1_CAUSE; ?>" id="Q7_2_1_1_CAUSE" name="Q7_2_1_1_CAUSE" type="text" class="form-control">
                                        </div>
                                    </div>      
                                    <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                        <div class="col-md-4 form-group">
                                            <label>
                                                2. স্বাস্থ্যসেবা প্রতিষ্ঠানের নাম
                                            </label>
                                            <select id="Q7_2_1_2_HCODE" name="Q7_2_1_2_HCODE" class="form-control">
                                                <option id="0" value="">নির্বাচন করুন</option>
                                                <?php foreach ($VA_Hospital_List as $VA_Hospital_List_single) { ?>
                                                    <option <?php if ($userInfo->Q7_2_1_2_HCODE == $VA_Hospital_List_single->id) echo ' selected'; ?> value="<?php echo $VA_Hospital_List_single->id; ?>"><?php echo $VA_Hospital_List_single->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>
                                                তারিখ
                                            </label>
                                            <input value="<?php if ($userInfo->Q7_2_1_2_DATE != "0000-00-00") echo $Q7_2_1_2_DATE; ?>" id="Q7_2_1_2_DATE" name="Q7_2_1_2_DATE" autocomplete="off" type="text" class="datepicker form-control">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>
                                                হাসপাতালে ভর্তির কারণ সমূহ
                                            </label>
                                            <input value="<?php echo $userInfo->Q7_2_1_2_CAUSE; ?>" id="Q7_2_1_2_CAUSE" name="Q7_2_1_2_CAUSE" type="text" class="form-control"> 
                                        </div>
                                    </div>      
                                    <div class="col-md-12 Q5_1_8_no_reluctant_unknown">
                                        <div class="col-md-4 form-group">
                                            <label>
                                                3. স্বাস্থ্যসেবা প্রতিষ্ঠানের নাম
                                            </label>
                                            <select id="Q7_2_1_3_HCODE" name="Q7_2_1_3_HCODE" class="form-control">
                                                <option id="0" value="">নির্বাচন করুন</option>
                                                <?php foreach ($VA_Hospital_List as $VA_Hospital_List_single) { ?>
                                                    <option <?php if ($userInfo->Q7_2_1_3_HCODE == $VA_Hospital_List_single->id) echo ' selected'; ?> value="<?php echo $VA_Hospital_List_single->id; ?>"><?php echo $VA_Hospital_List_single->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>
                                                তারিখ
                                            </label>
                                            <input value="<?php if ($userInfo->Q7_2_1_3_DATE != "0000-00-00") echo $Q7_2_1_3_DATE; ?>" id="Q7_2_1_3_DATE" name="Q7_2_1_3_DATE" autocomplete="off" type="text" class="datepicker form-control">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>
                                                হাসপাতালে ভর্তির কারণ সমূহ
                                            </label>
                                            <input value="<?php echo $userInfo->Q7_2_1_3_CAUSE; ?>" id="Q7_2_1_3_CAUSE" name="Q7_2_1_3_CAUSE" type="text" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="col-md-4 form-group Q5_1_8_no_reluctant_unknown">
                                            <label>
                                                <b>7.2.2</b>&nbsp;শিশুটিকে খুবই অসুস্থ অবস্থায়ই ছাড়পত্র দিয়েছিল?
                                            </label>
                                            <select id="Q7_2_2" class="form-control" name="Q7_2_2">
                                                <option id="0" value="">নির্বাচন করুন</option>
                                                <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                    <option <?php if ($userInfo->Q7_2_2 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <label>
                                                <b>7.2.3</b>&nbsp;হাসপাতালে ভর্তি হতে এবং সেবা পেতে এরূপ কোন সমস্যা হয়েছিল?
                                            </label>
                                            <table style="width: 100%;border-collapse: collapse;border-color: lightgray;" border="1">
                                                <tr>
                                                    <td>ভর্তি ও বিছানা পেতে বিলম্ব</td>
                                                    <td>
                                                        <select id="Q7_2_3_A" class="form-control" name="Q7_2_3_A">
                                                            <option id="0" value="">নির্বাচন করুন</option>
                                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                                <option <?php if ($userInfo->Q7_2_3_A == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>রোগ নির্নয় ও চিকিৎসা পেতে বিলম্ব</td>
                                                    <td>
                                                        <select id="Q7_2_3_B" class="form-control" name="Q7_2_3_B">
                                                            <option id="0" value="">নির্বাচন করুন</option>
                                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                                <option <?php if ($userInfo->Q7_2_3_B == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>অমার্জিত আচরন</td>
                                                    <td>
                                                        <select id="Q7_2_3_C" class="form-control" name="Q7_2_3_C">
                                                            <option id="0" value="">নির্বাচন করুন</option>
                                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                                <option <?php if ($userInfo->Q7_2_3_C == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>হাসপাতালে পোঁছাতে দুই ঘন্টার বেশী সময় লাগা</td>
                                                    <td>
                                                        <select onchange="showHide(this.id, 'Q7_2_3_D_off')" name="Q7_2_3_D" class="form-control" id="Q7_2_3_D">
                                                            <option id="0" value="">নির্বাচন করুন</option>
                                                            <?php
                                                            $i = 1;
                                                            foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) {
                                                                ?>
                                                                <option <?php if ($userInfo->Q7_2_3_D == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> <?php
                                                                if ($VA_Yes_No_Reluctant_Unknown_single->code == 1)
                                                                    echo " id='Q7_2_3_D_root'";
                                                                else
                                                                    echo " id='Q7_2_3_D_" . $i . "'";
                                                                ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                                    <?php
                                                                    $i++;
                                                                }
                                                                ?>
                                                        </select>
                                                        <br/>
                                                        <input value="<?php echo $userInfo->Q7_2_3_D_OTHER; ?>" <?php if (strlen($userInfo->Q7_2_3_D_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q7_2_3_D_off" type="text" name="Q7_2_3_D_OTHER" class="form-control">
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <br/>
                                        <label>
                                            <b>7.2.4</b>&nbsp;শেষদিকে চিকিৎসায় সহযোগিতার জন্য কেউ ফোন করেছিল?
                                        </label>
                                        <select id="Q7_2_4" class="form-control" name="Q7_2_4">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_2_4 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <br/>
                                        <label>
                                            <b>7.2.5</b>&nbsp;মৃত্যুর পূর্বে প্রয়োজনীয় চিকিৎসা সেবা নিয়ে কোন সন্দেহ ছিল?
                                        </label>
                                        <select id="Q7_2_5" class="form-control" name="Q7_2_5">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_2_5 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <br/>
                                        <label>
                                            <b>7.2.6</b>&nbsp;মৃত্যুর পূর্বে Traditional medicine (প্রচলিত বা দেশীয় চিকিৎসা) ব্যবহৃত হয়েছিল?
                                        </label>
                                        <select id="Q7_2_6" class="form-control" name="Q7_2_6">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_2_6 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <br/>
                                        <label>
                                            <b>7.2.7</b>&nbsp;শিশুটির চিকিৎসা ব্যয়ের জন্য পারিবারিক অন্যান্য খরচ মিটাতে সমস্যা হয়েছিল?
                                        </label>
                                        <select id="Q7_2_7" class="form-control" name="Q7_2_7">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_2_7 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <br/><br/>
                                        <label>
                                            <b>7.3</b>&nbsp;মৃত্যুর স্থান ঃ
                                        </label>
                                        <select onchange="showHide(this.id, 'Q7_3_off')" name="Q7_3" class="form-control" id="Q7_3">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Death_Place as $VA_Death_Place_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q7_3 == $VA_Death_Place_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Death_Place_single->code == 5)
                                                    echo " id='Q7_3_root'";
                                                else
                                                    echo " id='Q7_3_" . $i . "'";
                                                ?> value="<?php echo $VA_Death_Place_single->id; ?>"><?php echo $VA_Death_Place_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q7_3_OTHER; ?>" <?php if (strlen($userInfo->Q7_3_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q7_3_off" type="text" name="Q7_3_OTHER" class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <br/>
                                        <label>
                                            <b>7.3.1</b>&nbsp;যদি সে কোন স্বাস্থ্যসেবা প্রতিষ্ঠানে মৃত্যুবরন করে থাকেন তা হলে তার নাম ও ঠিকানা লিখুন:
                                        </label>
                                        <textarea name="Q7_3_1_Hname_Haddress" class="form-control" style="resize: none;"><?php echo $userInfo->Q7_3_1_Hname_Haddress; ?></textarea>
                                    </div>
                                    <div class="col-md-3">
                                        <br/>
                                        <label>
                                            <b>7.3.2</b> &nbsp;হাসপাতাল থেকে কেহ কি আপনাকে মৃত্যুর কারণটি বলেছিল?
                                        </label>
                                        <select id="Q7_3_2" class="form-control" name="Q7_3_2">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_3_2 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <br/><br/>
                                        <label>
                                            <b>7.3.3</b>&nbsp;কে কারনটি বলে ছিল?
                                        </label>
                                        <select onchange="showHide(this.id, 'Q7_3_3_off')" name="Q7_3_3" class="form-control" id="Q7_3_3">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Reason_Teller as $VA_Reason_Teller_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q7_3_3 == $VA_Reason_Teller_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Reason_Teller_single->code == 3)
                                                    echo " id='Q7_3_3_root'";
                                                else
                                                    echo " id='Q7_3_3_" . $i . "'";
                                                ?> value="<?php echo $VA_Reason_Teller_single->id; ?>"><?php echo $VA_Reason_Teller_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q7_3_3_OTHER; ?>" <?php if (strlen($userInfo->Q7_3_3_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q7_3_3_off" type="text" name="Q7_3_3_OTHER" class="form-control">
                                    </div>
                                    <div class="col-md-12">
                                        <label>
                                            <b>7.3.4</b> &nbsp;তিনি মৃত্যুর কি কারণ বলেছিলেন? (কারণ সমূহ লিখুন)
                                        </label>
                                        <textarea class="form-control" name="Q7_3_4"><?php echo $userInfo->Q7_3_4; ?></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <br/>
                                        <b>VIII. &nbsp;স্বাস্থ্য তথ্য/ব্যব¯হাপত্র (HEALTH RECORDS/PRESCRIPTION)</b>
                                    </div>
                                    <div class="col-md-4">
                                        <br/>
                                        <label>
                                            <b>8.1</b>&nbsp;শিশুটির কোন স্বাস্থ্য তথ্য বা ব্যব¯হাপত্র  আছে কি?
                                        </label>
                                        <select id="Q8_1" class="form-control" name="Q8_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q8_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>
                                            <b>8.1.1</b>&nbsp;আমি স্বাস্থ্য তথ্যখানা বা ব্যব¯হাপত্র দেখতে পারি কি?
                                        </label>
                                        <select id="Q8_1_1" class="form-control" name="Q8_1_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($va_yes_no as $va_yes_no_single) { ?>
                                                <option <?php if ($userInfo->Q8_1_1 == $va_yes_no_single->id) echo ' selected'; ?> value="<?php echo $va_yes_no_single->id; ?>"><?php echo $va_yes_no_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        তথ্যখানা থেকে Date, Symptoms, Diagnosis and Treatment লিখুন (সংযুক্ত করুন)
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-4 form-group">
                                            <label>
                                                Symptoms
                                            </label>
                                            <input id="Q8_1_1_SYMP" value="<?php echo $userInfo->Q8_1_1_SYMP; ?>" name="Q8_1_1_SYMP" type="text" class="form-control">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>
                                                Diagnosis
                                            </label>
                                            <input id="Q8_1_1_DIAG" value="<?php echo $userInfo->Q8_1_1_DIAG; ?>" name="Q8_1_1_DIAG" type="text" class="form-control">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>
                                                Treatment
                                            </label>
                                            <input id="Q8_1_1_TRET" value="<?php echo $userInfo->Q8_1_1_TRET; ?>" name="Q8_1_1_TRET" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <br/>
                                        <label>
                                            <b>8.1.2</b>&nbsp;সা¤প্রতিক ডাক্তার ভিজিটের সময়কার দুইটি ওজন(গ্রাম) লিখুন। যদি ওজন না পাওয়া যায় ৯৯৯৯ লিখুন।
                                        </label>
                                        <input value="<?php echo $userInfo->Q8_1_2_weight_1; ?>" name="Q8_1_2_weight_1" type="text" style="width:40%;float: left;" class="form-control" placeholder="গ্রাম"><span></span>
                                        <input value="<?php echo $userInfo->Q8_1_2_weight_2; ?>" name="Q8_1_2_weight_2" type="text" style="width:40%;" class="form-control" placeholder="গ্রাম"><span></span>
                                    </div>
                                    <div class="col-md-8">
                                        <br/>
                                        <label>
                                            <b>8.1.3</b> &nbsp;শিশুটিকে কি কি টীকা দেয়া হয়েছিল?
                                        </label>
                                        <table style="width: 100%;border-collapse: collapse;border-color: lightgray;" border="1">
                                            <tr>
                                                <td>Rota</td>
                                                <td>
                                                    <select id="Q8_1_3_A" class="form-control" name="Q8_1_3_A">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q8_1_3_A == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Meningitis</td>
                                                <td>
                                                    <select id="Q8_1_3_B" class="form-control" name="Q8_1_3_B">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q8_1_3_B == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Pneumonia</td>
                                                <td>
                                                    <select id="Q8_1_3_C" class="form-control" name="Q8_1_3_C">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q8_1_3_C == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Hib</td>
                                                <td>
                                                    <select id="Q8_1_3_D" class="form-control" name="Q8_1_3_D">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q8_1_3_D == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>BCG</td>
                                                <td>
                                                    <select id="Q8_1_3_E" class="form-control" name="Q8_1_3_E">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q8_1_3_E == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Penta/DPT</td>
                                                <td>
                                                    <select id="Q8_1_3_F" class="form-control" name="Q8_1_3_F">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q8_1_3_F == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>OPV</td>
                                                <td>
                                                    <select id="Q8_1_3_G" class="form-control" name="Q8_1_3_G">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q8_1_3_G == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Measles, MR or MMR</td>
                                                <td>
                                                    <select id="Q8_1_3_H" class="form-control" name="Q8_1_3_H">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q8_1_3_H == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Hepatitis-B</td>
                                                <td>
                                                    <select id="Q8_1_3_I" class="form-control" name="Q8_1_3_I">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q8_1_3_I == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Others</td>
                                                <td>
                                                    <select onchange="showHide(this.id, 'Q8_1_3_J_off')" name="Q8_1_3_J" class="form-control" id="Q8_1_3_J">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php
                                                        $i = 1;
                                                        foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) {
                                                            ?>
                                                            <option <?php if ($userInfo->Q8_1_3_J == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> <?php
                                                            if ($VA_Yes_No_Reluctant_Unknown_single->code == 1)
                                                                echo " id='Q8_1_3_J_root'";
                                                            else
                                                                echo " id='Q8_1_3_J_" . $i . "'";
                                                            ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                                <?php
                                                                $i++;
                                                            }
                                                            ?>
                                                    </select>
                                                    <br/>
                                                    <input value="<?php echo $userInfo->Q8_1_3_J_OTHER; ?>" <?php if (strlen($userInfo->Q8_1_3_J_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q8_1_3_J_off" type="text" name="Q8_1_3_J_OTHER" class="form-control"> 
                                                </td>
                                            </tr>

                                        </table>
                                    </div>
                                    <div class="col-md-4">
                                        <br/><br/>
                                        <label>
                                            <b>8.2</b>&nbsp;শিশুটির মৃত্যু প্রত্যায়ন পত্র আছে কি?
                                        </label>
                                        <select id="Q8_2" class="form-control" name="Q8_2">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q8_2 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <br/>
                                        <label>
                                            <b>8.2.1</b>&nbsp;আপনি (Interviewer) কি মৃত্যু প্রত্যায়ন পত্র দেখতে পেয়েছিলেন?
                                        </label>
                                        <select id="Q8_2_1" class="form-control" name="Q8_2_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($va_yes_no as $va_yes_no_single) { ?>
                                                <option <?php if ($userInfo->Q8_2_1 == $va_yes_no_single->id) echo ' selected'; ?> value="<?php echo $va_yes_no_single->id; ?>"><?php echo $va_yes_no_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <br/>
                                        <b>8.2.2</b> &nbsp;প্রত্যায়ন পত্র থেকে মৃত্যুর কারন লিপিবদ্ধ করুন:
                                    </div>
                                    <div class="col-md-12 Q10_2_no_reluctant_unknown">
                                        <div class="col-md-3 form-group">
                                            <label> a. Immediate cause </label>
                                            <input value="<?php echo $userInfo->Q8_2_2_ICAUSE; ?>" id="Q8_2_2_ICAUSE" name="Q8_2_2_ICAUSE" type="text" class="form-control">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>Code</label> 
                                            <input value="<?php echo $userInfo->Q8_2_2_ICODE; ?>" id="Q8_2_2_ICODE" name="Q8_2_2_ICODE" type="text" class="form-control">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label> b. Antecedent cause </label>
                                            <input value="<?php echo $userInfo->Q8_2_2_ACAUSE; ?>" id="Q8_2_2_ACAUSE" name="Q8_2_2_ACAUSE" type="text" class="form-control">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>Code</label>
                                            <input value="<?php echo $userInfo->Q8_2_2_ACODE; ?>" id="Q8_2_2_ACODE" name="Q8_2_2_ACODE" type="text" class="form-control">
                                        </div>
                                    </div>      
                                    <div class="col-md-12 Q10_2_no_reluctant_unknown">
                                        <div class="col-md-3 form-group">
                                            <label>c. Underlying cause</label> 
                                            <input value="<?php echo $userInfo->Q8_2_2_UCAUSE; ?>" id="Q8_2_2_UCAUSE" name="Q8_2_2_UCAUSE" type="text" class="form-control">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>Code</label>
                                            <input value="<?php echo $userInfo->Q8_2_2_UCODE; ?>" id="Q8_2_2_UCODE" name="Q8_2_2_UCODE" type="text" class="form-control">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>d. Contributing cause</label> 
                                            <input value="<?php echo $userInfo->Q8_2_2_CCAUSE; ?>" id="Q8_2_2_CCAUSE" name="Q8_2_2_CCAUSE" type="text" class="form-control">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label> Code</label> 
                                            <input value="<?php echo $userInfo->Q8_2_2_CCODE; ?>" id="Q8_2_2_CCODE" name="Q8_2_2_CCODE" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <br/>
                                        <label>
                                            <b>8.2.3</b>&nbsp;মৃত শিশুর মায়ের রক্ত এইচ আই ভি জীবানুর জন্য পরীক্ষা করা হয়েছিল কি?
                                        </label>
                                        <select id="Q8_2_3" class="form-control" name="Q8_2_3">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q8_2_3 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <br/><br/>
                                        <label>
                                            <b>8.2.4</b> &nbsp;এইচ আই ভি জীবানুর পজিটিভ ধরা পড়েছিল?
                                        </label>
                                        <select id="Q8_2_4" class="form-control" name="Q8_2_4">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q8_2_4 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <br/>
                                        <label>
                                            <b>8.2.5</b>&nbsp;কোন স্বাস্থ্য কর্মী কি মাকে বলেছিল যে, মায়ের এইডস রোগ আছে?
                                        </label>
                                        <select id="Q8_2_5" class="form-control" name="Q8_2_5">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q8_2_5 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>
                                            <b>8.3</b>&nbsp;---- মৃত্যু নিবন্ধণ করা হয়েছিল?
                                            <br/>(Civil Registration by Union Parishad/ Paurosova)
                                        </label>
                                        <select id="Q8_3" class="form-control" name="Q8_3">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q8_3 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <br/><br/>
                                        <label>
                                            <b>8.3.1</b>&nbsp;আপনি কি নিবন্ধণপত্র দেখেছেন?
                                        </label>
                                        <select id="Q8_3_1" class="form-control" name="Q8_3_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($va_yes_no as $va_yes_no_single) { ?>
                                                <option <?php if ($userInfo->Q8_3_1 == $va_yes_no_single->id) echo ' selected'; ?> value="<?php echo $va_yes_no_single->id; ?>"><?php echo $va_yes_no_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <?php
                                    $partsRequire = explode('-', $userInfo->Q8_3_2);
                                    $Q8_3_2 = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];
                                    ?>
                                    <div class="col-md-3">
                                        <br/><br/>
                                        <label>
                                            <b>8.3.2</b> &nbsp;নিবন্ধণের তারিখ লিখুন
                                        </label>
                                        <input value="<?php if ($userInfo->Q8_3_2 != "0000-00-00") echo $Q8_3_2; ?>" type="text" class="datepicker form-control" name="Q8_3_2">
                                    </div>
                                    <div class="col-md-3">
                                        <br/><br/>
                                        <label>
                                            <b>8.3.3</b>&nbsp;নিবন্ধণ নাম্বার লিখুন
                                        </label>
                                        <input value="<?php echo $userInfo->Q8_3_3; ?>" type="text" class="form-control" name="Q8_3_3">
                                    </div>
                                    <div class="col-md-12">
                                        <br/>
                                        <h4 style="text-align: center;font-weight: bold;">End of Interview<br/>উত্তর দাতাকে সহযোগিতার জন্য ধন্যবাদ জানান</h4>
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
                                    $partsRequire = explode('-', $userInfo->Q10_DOE);
                                    $Q10_DOE = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];
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
        </div>
    </section>
    <script src="<?php echo base_url(); ?>assets/js/ChildJS.js"></script>
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