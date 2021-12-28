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
                    Adult Verbal Autopsy
                    <small></small>
                    <?php $baseID = $this->input->get('baseID', TRUE); ?>
                </h3>

            </div>
            <div class="col-xs-6 text-right">
                <div class="form-group margin5pxBot">
                    <a class="btn btn-primary" href="<?php echo base_url() . $controller . '?baseID=' . $baseID ?>"><?php echo $shortName ?> List</a>
                    <a class="btn btn-primary" href="<?php echo base_url() . $controller . '/adult?baseID=' . $baseID ?>">Adult List</a>
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

                    <form action="<?php echo base_url() . $controller . '/' . $actionMethod . '?baseID=' . $baseID ?>" method="post" id="editUser" role="form">
                        <input type="hidden" name="ID" value="<?php echo $userInfo->id; ?>">
                        <input id="FK_SEX" type="hidden" name="FK_SEX" value="<?php echo $userInfo->fk_sex; ?>">
                        <input id="household_master_id" type="hidden" name="household_master_id" value="<?php echo $userInfo->household_master_id; ?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    I. IDENTIFICATION OF THE RESPONDENT <br>
                                    1.1) সাক্ষাতের সময় যারা উপস্থিত আছেন, তাদের মধ্যে কারা শেষ অসুখের সময় উপস্থিত ছিলেন? <br><br>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>1. সাক্ষাৎকার গ্রহনের সময় উপস্থিত ব্যক্তির নাম:</label>
                                        <select name="Q1_1_N1" class="form-control" id="Q1_1_N1">
                                            <option id="" value="">নির্বাচন করুন</option>
                                            <?php
                                            foreach ($household_member as $household) {
                                                ?>
                                                <option <?php
                                                if ($userInfo->Q1_1_N1 == $household->member_code) {
                                                    echo 'selected=selected';
                                                }
                                                ?> value="<?php echo $household->member_code; ?>"><?php echo $household->member_code . '-' . $household->member_name; ?></option>
                                                    <?php
                                                }
                                                ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>মৃত ব্যক্তির সাথে সম্পর্ক</label>
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
                                    <div class="col-md-4 form-group">
                                        <label>অসুস্থকালীন উপস্থিত ছিলেন?</label>
                                        <select name="Q1_1_P1" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($va_yes_no as $va_yes_no_single) { ?>
                                                <option <?php if ($userInfo->Q1_1_P1 == $va_yes_no_single->id) echo ' selected'; ?> value="<?php echo $va_yes_no_single->id; ?>"><?php echo $va_yes_no_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>2. সাক্ষাৎকার গ্রহনের সময় উপস্থিত ব্যক্তির নাম:</label>
                                        <select name="Q1_1_N2" class="form-control" id="Q1_1_N2">
                                            <option id="" value="">নির্বাচন করুন</option>
                                            <?php
                                            foreach ($household_member as $household2) {
                                                ?>
                                                <option <?php
                                                if ($userInfo->Q1_1_N2 == $household2->member_code) {
                                                    echo 'selected=selected';
                                                }
                                                ?> value="<?php echo $household2->member_code; ?>"><?php echo $household2->member_code . '-' . $household2->member_name; ?></option>
                                                    <?php
                                                }
                                                ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>মৃত ব্যক্তির সাথে সম্পর্ক</label>
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
                                    <div class="col-md-4 form-group">
                                        <label>অসুস্থকালীন উপস্থিত ছিলেন?</label>
                                        <select name="Q1_1_P2" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($va_yes_no as $va_yes_no_single) { ?>
                                                <option <?php if ($userInfo->Q1_1_P2 == $va_yes_no_single->id) echo ' selected'; ?> value="<?php echo $va_yes_no_single->id; ?>"><?php echo $va_yes_no_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>3. সাক্ষাৎকার গ্রহনের সময় উপস্থিত ব্যক্তির নাম:</label>
                                        <select name="Q1_1_N3" class="form-control" id="Q1_1_N3">
                                            <option id="" value="">নির্বাচন করুন</option>
                                            <?php
                                            foreach ($household_member as $household3) {
                                                ?>
                                                <option <?php
                                                if ($userInfo->Q1_1_N3 == $household3->member_code) {
                                                    echo 'selected=selected';
                                                }
                                                ?> value="<?php echo $household3->member_code; ?>"><?php echo $household3->member_code . '-' . $household3->member_name; ?></option>
                                                    <?php
                                                }
                                                ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>মৃত ব্যক্তির সাথে সম্পর্ক</label>
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
                                    <div class="col-md-4 form-group">
                                        <label>অসুস্থকালীন উপস্থিত ছিলেন?</label>
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
                                </div>

                                <div class="box-footer col-md-12">
                                    <input type="submit" class="btn btn-primary" value="Update">
                                </div>

                                <div class="col-md-12">
                                    II. BACKGROUND INFORMATION ABOUT THE INTERVIEWER <br><br>
                                </div>

                                <div class="col-md-12"> 
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


                                        <input value="<?php echo $name; ?>" name="Q2_1_INTV_NAME1" type="text" class="form-control" disabled>
                                        <input value="<?php echo $name; ?>" name="Q2_1_INTV_NAME" type="hidden" class="form-control" disabled>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>কোড:</label>
                                        <input value="<?php echo $intervcode; ?>" name="Q2_1_INTV_CODE1" type="text" class="form-control" disabled>
                                        <input value="<?php echo $intervcode; ?>" name="Q2_1_INTV_CODE" type="hidden" class="form-control" disabled>
                                    </div>

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

                                <div class="col-md-12">                                            
                                    <div class="col-md-4 form-group">
                                        <label>2.2) সাক্ষাতের তারিখ (দিন/মাস/বছর):</label>

                                        <input value="<?php if ($userInfo->Q2_2_INTV_DATE != "1900-01-01") echo $Q2_2_INTV_DATE; ?>" autocomplete="off" name="Q2_2_INTV_DATE" type="text" class="datepicker form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>2.3) ১ম সাক্ষাতের তারিখ (দিন/মাস/বছর):</label>
                                        <input value="<?php if ($userInfo->Q2_3_1ST_INTV_DATE != "1900-01-01") echo $Q2_3_1ST_INTV_DATE; ?>" autocomplete="off" name="Q2_3_1ST_INTV_DATE" type="text" class="datepicker form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>2.4) ২য় সাক্ষাতের তারিখ (দিন/মাস/বছর):</label>
                                        <input value="<?php if ($userInfo->Q2_4_2ND_INTV_DATE != "1900-01-01") echo $Q2_4_2ND_INTV_DATE; ?>" autocomplete="off" name="Q2_4_2ND_INTV_DATE" type="text" class="datepicker form-control">
                                    </div>
                                </div>



                                <div class="col-md-12">
                                    III. IDENTIFICATION & DEMOGRAPHIC DATA OF THE DECEASED <br/>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>3.1) মৃতের নাম:</label>
                                        <input value="<?php echo $userInfo->member_name; ?>" name="Q3_1_DNAME" type="text" class="form-control" disabled>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>3.2) RID: </label>
                                        <input value="<?php echo $userInfo->member_code; ?>" name="Q3_2_RID" type="text" class="form-control" disabled>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>CID</label>
                                        <input value="<?php echo $userInfo->household_code; ?>" name="Q3_2_CID" type="text" class="form-control" disabled>
                                    </div>
                                </div>

                                <!--<div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>3.2.1) জাতীয় পরিচয়পত্র নং</label>
                                        <input value="<?php echo $userInfo->Q3_2_1_NID; ?>" name="Q3_2_1_NID" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>3.3) গ্রামের নাম:</label>
                                        <input value="<?php echo $userInfo->Q3_3_V_NAME; ?>" name="Q3_3_V_NAME" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>3.4) বাড়ির নাম:</label>
                                        <input value="<?php echo $userInfo->Q3_4_B_NAME; ?>" name="Q3_4_B_NAME" type="text" class="form-control">
                                    </div>
                                </div>-->

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



                                $partsRequire = explode('-', $userInfo->birth_date);
                                $birth_date = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];

                                $partsRequire = explode('-', $userInfo->death_date);
                                $death_date = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];


                                $date1 = strtotime($userInfo->birth_date);
                                $date2 = strtotime($userInfo->death_date);

                                $diff = abs($date2 - $date1);
                                $years = floor($diff / (365 * 60 * 60 * 24));
                                ?>

                                <div class="col-md-12">
                                    <!-- <div class="col-md-4 form-group">
                                         <label>বাড়ির কোড:</label>
                                         <input value="<?php echo $Q3_4_B_CODE; ?>" name="Q3_4_B_CODE" type="text" class="form-control" disabled>
                                     </div>-->
                                    <div class="col-md-4 form-group">
                                        <label>3.5) মৃতের জন্ম তারিখ (দিন/মাস/বছর):</label>
                                        <input value="<?php echo $birth_date; ?>" autocomplete="off" name="Q3_5_DOB" type="text" class="datepicker form-control" disabled>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>3.6) মৃতের মৃত্যু তারিখ (দিন/মাস/বছর):</label>
                                        <input value="<?php echo $death_date; ?>" autocomplete="off" name="Q3_6_DOD" type="text" class="datepicker form-control" disabled>
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label>3.7) মৃতের বয়স (বছরে):</label>
                                        <input value="<?php echo $years; ?>" name="Q3_7_AGE_Y" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>3.8) মৃতের লিঙ্গ:</label>
                                        <select name="Q3_8_SEX" class="form-control" disabled>
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($va_gender as $va_gender_single) { ?>
                                                <option <?php if ($userInfo->fk_sex == $va_gender_single->id) echo ' selected'; ?> value="<?php echo $va_gender_single->id; ?>"><?php echo $va_gender_single->name; ?></option>
                                            <?php } ?>
                                        </select> 
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>3.9) মৃতের বৈবাহিক অবস্থা কি ছিল?</label>
                                        <select id="Q3_9_MSTATUS" name="Q3_9_MSTATUS" class="form-control" disabled>
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Marital_Status as $VA_Marital_Status_single) { ?>
                                                <option <?php if ($userInfo->fk_marital_status == $VA_Marital_Status_single->id) echo ' selected'; ?> value="<?php echo $VA_Marital_Status_single->id; ?>"><?php echo $VA_Marital_Status_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <!--<div class="col-md-4 form-group">
                                        <label>3.9) মৃতের বৈবাহিক অবস্থা কি ছিল?</label>
                                        <select id="Q3_9_MSTATUS" name="Q3_9_MSTATUS" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                    <?php foreach ($VA_Marital_Status as $VA_Marital_Status_single) { ?>
                                                                                            <option <?php if ($userInfo->Q3_9_MSTATUS == $VA_Marital_Status_single->id) echo ' selected'; ?> value="<?php echo $VA_Marital_Status_single->id; ?>"><?php echo $VA_Marital_Status_single->name; ?></option>
                                    <?php } ?>
                                        </select>
                                    </div>
                                
                                    <div <?php if ($userInfo->Q3_9_MSTATUS == 1571) echo " style='display:none;'"; ?> class="col-md-4 form-group Q3_9_MSTATUS_unmarried">
                                        <label>3.9.1) বিবাহের তারিখ জানা আছে?</label>
                                        <select id="Q3_9_1_MD" name="Q3_9_1_MD" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                                                            <option <?php if ($userInfo->Q3_9_1_MD == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                    <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q3_9_2_DOM == "1900-01-01") echo " style='display:none;'"; ?> id="Q3_9_2" class="col-md-4 form-group">
                                        <label>3.9.2) বিবাহের তারিখঃ</label>
                                        <input value="<?php if ($userInfo->Q3_9_2_DOM != "1900-01-01") echo $Q3_9_2_DOM; ?>" autocomplete="off" name="Q3_9_2_DOM" id="Q3_9_2_DOM" type="text" class="datepicker form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>3.10) মৃতের প্রাতিষ্ঠানিক শিক্ষা কত বৎসরের? (Code: 98 =কখনো যায়নি, 99 = অজানা) 
                                            (উত্তর 98 বা 99 হলে প্রশ্ন 3.11 এ যান)</label>
                                        <input value="<?php echo $userInfo->Q3_10_EDU; ?>" type="text" name="Q3_10_EDU" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>3.10.1) শিক্ষা প্রতিষ্ঠানের ধরন:</label>
                                        <select id="Q3_10_1" name="Q3_10_1" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                    <?php foreach ($VA_Education_Institute_Type as $VA_Education_Institute_Type_single) { ?>
                                                                                            <option <?php if ($userInfo->Q3_10_1 == $VA_Education_Institute_Type_single->id) echo ' selected'; ?> value="<?php echo $VA_Education_Institute_Type_single->id; ?>"><?php echo $VA_Education_Institute_Type_single->name; ?></option>
                                    <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>3.10.2) উনি কি পড়তে/লিখতে পারতেন?</label>
                                        <select id="Q3_10_2_ES" class="form-control" name="Q3_10_2_ES">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                    <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                                                            <option <?php if ($userInfo->Q3_10_2_ES == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                    <?php } ?>
                                        </select>
                                    </div> -->
                                    <div class="col-md-4 form-group">
                                        <label>3.11) মৃত ব্যক্তির প্রধান পেশা:</label>
                                        <select class="form-control" name="Q3_11_CODE" disabled>
                                            <option id="0" value="">নির্বাচন করুন</option> 
                                            <?php foreach ($VA_Occupation_Type as $VA_Occupation_Type_single) { ?>
                                                <option <?php if ($userInfo->fk_main_occupation == $VA_Occupation_Type_single->id) echo ' selected'; ?> value="<?php echo $VA_Occupation_Type_single->id; ?>"><?php echo $VA_Occupation_Type_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="box-footer col-md-12">
                                    <input type="submit" class="btn btn-primary" value="Update">
                                </div>

                                <div class="col-md-12">
                                    IV. RESPONDENT'S ACCOUNT OF ILLNESS/EVENTS LEADING TO DEATH<br>
                                    4.1) আপনি কি আমাকে তার মৃত্যুর আগের অসুস্থতার/ঘটনাগুলো বলতে পারেন?
                                    <br/>সাক্ষাৎকার গ্রহনকারীর প্রতি নির্দেশিকা: উত্তরদাতাকে তার নিজের ভাষায় বলার জন্য সহায়তা করূন। উত্তরদাতা বলার পর, যতক্ষন পর্যন্ত না বলে যে আর কিছু বলার নেই ততক্ষন পর্যন্তÍ জিজ্ঞাসা করতে থাকুন আর কিছু ছিল কিনা? উত্তরদাতার স্বতস্ফুর্তভাবে বলা রোগের লক্ষণগুলো লিপিবদ্ধ করূন ও অপরিচিত কোন শব্দ থাকলে তার নীচে লাইন টেনে চিহ্নিত করূন
                                    <br/>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-12 form-group">
                                        <label>কি কারণে তার মৃত্যু হয়েছিল বলে আপনি মনে করেন? কারণ সমূহ লিখুনঃ (অনিচ্ছা=7)</label>
                                        <textarea name="Q4_1_death_reasons" rows="5" class="form-control"><?php echo $userInfo->Q4_1_death_reasons; ?></textarea>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <h4>CONTEXT AND HISTORY OF PREVIOUSLY KNOWN CONDITIONS:</h4>
                                </div>
                                <div class="col-md-12">
                                    <p>I would like to ask you some questions concerning the contexts and previously known medical conditions the deceased had; injuries and accidents that the deceased suffered; and signs and symptoms that the deceased had/showed when s/he was ill. Some of these questions may not appear to be directly related to his/her death. Please bear with me and answer all the questions. They will help us to get a clear picture of all possible symptoms that the deceased had and the diagnosis assessed by a doctor, health worker or other health professional during the final illness.</p>
                                </div>
                                <div class="col-md-12">
                                    <p>(আমি আপনাকে ------------ অসুস্থকালীন সময়ে রোগের লক্ষণ ও উপসর্গ/আঘাত/দূর্ঘটনা প্রসঙ্গে কিছু প্রশ্ন করব যাহাতে উনি মৃত্যুর পূর্বে ভুগেছিলেন/সম্মুখীন হয়েছিলেন। কিছু প্রশ্ন তার মৃত্যর সাথে সরাসরি সম্পর্কিত নাও হতে পারে। অনুগ্রহ পূর্বক আমার সাথে থাকুন এবং প্রশ্নগুলির উত্তর দিন। সেগুলি মৃতব্যক্তির সম্ভাব্য লক্ষণ সম্বন্ধে একটি চিত্র পেতে আমাদিগকে সাহায্য করবে এবং মৃত্যুর পূর্বে র্সবশষে অসুখরে সময় কোন একজন ডাক্তার, স্বাস্থ্যকর্মী বা অন্য কোন স্বাস্থ্যপেশাজীবি দ্বারা এ রোগ নণিীত হয়েছে।)</p>
                                </div>
                                <div class="col-md-12"> 
                                    <p>
                                        4.2) মৃত ব্যক্তির নিম্মের অসুস্থতা/লক্ষণগুলোর কোনটি ছিল কিনা জিজ্ঞাসা করুন:
                                    </p>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>উচ্চ রক্তচাপ (Hypertension)?</label>
                                        <select class="form-control" name="Q4_2_A">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q4_2_A == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label>হৃদ রোগ (Heart diseases)?</label>
                                        <select class="form-control" name="Q4_2_B">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q4_2_B == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select> 
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label>
                                            স্ট্রোক (Stroke)
                                        </label>
                                        <select class="form-control" name="Q4_2_C">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q4_2_C == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>বহুমুত্র (Diabetes)?</label>
                                        <select class="form-control" name="Q4_2_D">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q4_2_D == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            মৃগী রোগ (Epilepsy)?
                                        </label>
                                        <select class="form-control" name="Q4_2_E">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q4_2_E == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>ক্যানসার (Cancer)নির্দিষ্ট করুন</label>
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
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            হাঁপানী (Asthma)?
                                        </label>
                                        <select class="form-control" name="Q4_2_G">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q4_2_G == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>COPD (Chronic Obsetructive Pulmonary Disease)</label>

                                        <select class="form-control" name="Q4_2_H">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q4_2_H == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            যক্ষা (TB)?
                                        </label>

                                        <select class="form-control" name="Q4_2_I">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q4_2_I == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>মারাত্মক অপুষ্টি  (Severe malnutrition)</label>
                                        <select class="form-control" name="Q4_2_J">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q4_2_J == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>  
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            গিঁটে ব্যথা/বাত (Arthritis-মাঝাব্যথা ছাড়া)?
                                        </label>

                                        <select class="form-control" name="Q4_2_K">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q4_2_K == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">

                                        <label>কিডনীর রোগ (Kidney disease)</label>

                                        <select class="form-control" name="Q4_2_L">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q4_2_L == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            হেপাটাইটিস/লিভারের রোগ (Hepatitis/liver disease)?
                                        </label>
                                        <select class="form-control" name="Q4_2_M">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q4_2_M == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-md-4 form-group">

                                        <label>রক্তের রোগ (Thalassemia, heamolytic, sickle cell anaemia, etc)</label>

                                        <select class="form-control" name="Q4_2_N">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q4_2_N == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>  
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            পেপটিক আলসার (ডিউডেনাল আলসার/গেষ্ট্রিক আলসার)?
                                        </label>

                                        <select class="form-control" name="Q4_2_O">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q4_2_O == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>মানসিক প্রতিবন্ধি (Mental handicap)?</label>

                                        <select class="form-control" name="Q4_2_P">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q4_2_P == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            শারীরিক প্রতিবন্ধি (Physical handicap)?
                                        </label>
                                        <select class="form-control" name="Q4_2_Q">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q4_2_Q == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>মাঝে মাঝে পাযুপথ দিয়ে টাটকা রক্ত (অর্শ্ব/ভগন্দর)?</label>

                                        <select class="form-control" name="Q4_2_R">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q4_2_R == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            মাঝেমধ্যে কালো পায়খানা (Black stool)?
                                        </label>
                                        <select class="form-control" name="Q4_2_S">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q4_2_S == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">

                                        <label>মানসিক রোগ (Schizophrenia, mania, depresstion)</label>

                                        <select class="form-control" name="Q4_2_T">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q4_2_T == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label>
                                            ডিমেনশিয়া (Dementia)?
                                        </label>

                                        <select class="form-control" name="Q4_2_U">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q4_2_U == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>ম্যালেরিয়া (Malaria in recent time)</label>

                                        <select class="form-control" name="Q4_2_V">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q4_2_V == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            এইডস (AIDS/HIV)?
                                        </label>

                                        <select class="form-control" name="Q4_2_W">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q4_2_W == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>আর্সেনিক রোগ (Arsenicosis)</label>

                                        <select class="form-control" name="Q4_2_X">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q4_2_X == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>     
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            স্থূলতা (Obesity)?
                                        </label>

                                        <select class="form-control" name="Q4_2_Y">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q4_2_Y == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">

                                        <label>ডেঙ্গু জ্বর (Dengue fever)</label>

                                        <select class="form-control" name="Q4_2_DEN">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q4_2_DEN == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            হাম (Measles)?
                                        </label>
                                        <select class="form-control" name="Q4_2_MEA">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q4_2_MEA == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>চিকুনগুনিয়া(Chikungunya)</label>
                                        <select class="form-control" name="Q4_2_CHI">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q4_2_CHI == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            অন্যান্য রোগ (উল্লেখ করুন)
                                        </label>
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
                                    </div>

                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>4.3) মৃত্যুর পুর্বে কত মাস/দিন যাবৎ অসুস্থ ছিলেন?</label>
                                        <input value="<?php echo $userInfo->Q4_3_M; ?>" name="Q4_3_M" style="width:50%;float:left;" placeholder="মাস" type="text" class="form-control">
                                        <input value="<?php echo $userInfo->Q4_3_D; ?>" name="Q4_3_D" style="width:50%;float:left;" placeholder="দিন" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>4.4) হঠাৎ মৃত্যুবরণ করেছিলেন?</label>
                                        <select class="form-control" name="Q4_4">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q4_4 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="box-footer col-md-12">
                                    <input type="submit" class="btn btn-primary" value="Update">
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
                                    <div <?php if ($userInfo->Q5_1 == 1577 || $userInfo->Q5_1 == 1578 || $userInfo->Q5_1 == 1579) echo " style='display:none'"; ?> class="col-md-4 form-group Q5_1_no_reluctant_unknown">
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
                                    <div <?php
                                    if ($userInfo->Q5_1_1 == 1599 || $userInfo->Q5_1_1 == 1600)
                                        echo " style='display:block'";
                                    else
                                        echo " style='display:none'";
                                    ?> class="col-md-4 form-group Q5_1_2_part">
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

                                <div <?php if ($userInfo->Q5_1 == 1577 || $userInfo->Q5_1 == 1578 || $userInfo->Q5_1 == 1579) echo " style='display:none'"; ?> class="col-md-12 Q5_1_no_reluctant_unknown">
                                    <div <?php
                                    if ($userInfo->Q5_1_1 == 1608)
                                        echo " style='display:block'";
                                    else
                                        echo " style='display:none'";
                                    ?> class="col-md-4 form-group Q5_1_3_part">
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
                                    <div <?php
                                    if ($userInfo->Q5_1_1 == 1597 || $userInfo->Q5_1_1 == 1598 || $userInfo->Q5_1_1 == 1603 || $userInfo->Q5_1_1 == 1604 || $userInfo->Q5_1_1 == 1605 || $userInfo->Q5_1_1 == 1610 || $userInfo->Q5_1_1 == 1611 || $userInfo->Q5_1_2 > 0)
                                        echo " style='display:block;'";
                                    else
                                        echo " style='display:none'";
                                    ?> class="col-md-4 form-group Q5_1_4_part">
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

                                <div <?php if ($userInfo->Q5_1 == 1577 || $userInfo->Q5_1 == 1578 || $userInfo->Q5_1 == 1579) echo " style='display:none'"; ?> class="col-md-12 Q5_1_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            5.1.6) তিনি কি দুর্ঘটনা বা আহত হওয়ার জায়গায় মারা গিয়েছিলেন?
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
                                            5.1.7) দুর্ঘটনায় আহত হওয়ার পর তিনি কত দিন/ঘন্টা বেঁচে ছিলেন?
                                        </label>
                                        <input value="<?php echo $userInfo->Q5_1_7_D; ?>" id="Q5_1_7_D"  name="Q5_1_7_D" style="width:50%;float:left;" placeholder="দিন" type="text" class="form-control">
                                        <input value="<?php echo $userInfo->Q5_1_7_H; ?>" id="Q5_1_7_H" name="Q5_1_7_H" style="width:50%;float:left;" placeholder="ঘন্টা" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="Q5_1_8_td">
                                            5.1.8) তিনি কি মৃত্যুর আগে চিকিৎসা পেয়েছিলেন?
                                        </label>
                                        <select id="Q5_1_8" class="form-control" name="Q5_1_8">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q5_1_8 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="box-footer col-md-12">
                                    <input type="submit" class="btn btn-primary" value="Update">
                                </div>

                                <div <?php if ($userInfo->fk_sex == 25) echo " style='display:none;'" ?> class="col-md-12 Q5_1_no_reluctant_unknown_female">
                                    VI. SYMPTOMS & SIGNS ASSOCIATED WITH ILLNESS OF WOMEN <br><br>
                                    সকল মহিলা মৃত্যুর ক্ষেত্রে জিজ্ঞাসা করুন: (Deceased)<br><br>
                                </div>

                                <div <?php if ($userInfo->fk_sex == 25) echo " style='display:none;'" ?> class="col-md-12 Q5_1_no_reluctant_unknown_female">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            6.1.1) তার স্তনে কি ক্ষত বা ফোলা ছিল?
                                        </label>

                                        <select class="form-control" id="Q6_1_1" name="Q6_1_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_1_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>


                                    </div>
                                    <div <?php if ($userInfo->Q6_1_1 != 1576) echo " style='display:none'"; ?> id="Q6_1_2" class="col-md-4 form-group">
                                        <label>
                                            6.1.2) কত মাস/দিন যাবৎ তার স্তনে ক্ষত বা ফোলা ছিল?
                                        </label>

                                        <input value="<?php echo $userInfo->Q6_1_2_M; ?>" name="Q6_1_2_M" style="width:50%;float:left;" placeholder="মাস" type="text" class="form-control Q6_1_1_reluctant">
                                        <input value="<?php echo $userInfo->Q6_1_2_D; ?>" name="Q6_1_2_D" style="width:50%;float:left;" placeholder="দিন" type="text" class="form-control Q6_1_1_reluctant">
                                    </div>
                                    <div class="col-md-4 form-group">

                                        <label>
                                            6.1.3) দুই মাসিকের মধ্যবর্তী সময়ে তার যোনীপথে রক্তক্ষরণ হতো কি?
                                        </label>

                                        <select id="Q6_1_3" class="form-control" name="Q6_1_3">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_NotApplicable_Unknown as $VA_Yes_No_Reluctant_NotApplicable_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_1_3 == $VA_Yes_No_Reluctant_NotApplicable_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_NotApplicable_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_NotApplicable_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                </div>

                                <div <?php if ($userInfo->fk_sex == 25) echo " style='display:none;'" ?> class="col-md-12 Q5_1_no_reluctant_unknown_female">
                                    <div class="col-md-4 form-group Q6_1_4_part">
                                        <label>
                                            6.1.4) দুই মাসিকের মধ্যবর্তী সময়ে কত মাস/দিন যাবৎ যোনীপথে রক্তক্ষরণ হতো?
                                        </label>

                                        <input value="<?php echo $userInfo->Q6_1_4_M; ?>" id="Q6_1_4_M" name="Q6_1_4_M" style="width:50%;float:left;" placeholder="মাস" type="text" class="form-control">
                                        <input value="<?php echo $userInfo->Q6_1_4_D; ?>" id="Q6_1_4_D" name="Q6_1_4_D" style="width:50%;float:left;" placeholder="দিন" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">

                                        <label>
                                            6.1.5) মাসিক কি একবোরে বন্ধ হয়ে গিয়েছিল/ অপারশেন করে জরায়ু ফেলে দেওয়া হয়েছিল কি?
                                        </label>

                                        <select id="Q6_1_5" class="form-control" name="Q6_1_5">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_1_5 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div id="Q6_1_6_part" class="col-md-4 form-group">
                                        <label>
                                            6.1.6) মাসিক একেবারে বন্ধ হয়ে যাবার পর / অপারেশন করে জরায়ু অপসারণের পর আবার রক্তপাত হয়েছিল কি?
                                        </label>

                                        <select id="Q6_1_6" class="form-control" name="Q6_1_6">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_1_6 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div <?php if ($userInfo->fk_sex == 25) echo " style='display:none;'" ?> class="col-md-12 Q5_1_no_reluctant_unknown_female">
                                    <div id="Q6_1_7_part" class="col-md-4 form-group">
                                        <label>
                                            6.1.7) মৃত্যুর আগে ঐ এক সপ্তাহে অতিরিক্ত রক্তক্ষরণ হয়েছিল কি?
                                        </label>

                                        <select id="Q6_1_7" class="form-control" name="Q6_1_7">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_1_7 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            6.1.8) মৃত্যুর সময় উনার মাসিকের সময় পার হয়ে গিয়েছিল কি?
                                        </label>

                                        <select class="form-control" name="Q6_1_8">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_NotApplicable_Unknown as $VA_Yes_No_Reluctant_NotApplicable_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_1_8 == $VA_Yes_No_Reluctant_NotApplicable_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_NotApplicable_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_NotApplicable_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            6.1.9) যদি হয়ে থাকে তাহলে কত সপ্তাহ পার হয়ে গিয়েছিল? (Code: 7 =অনিচ্ছা, 8 = প্রযোজ্য নয়, 9 = অজানা)
                                        </label>

                                        <input value="<?php echo $userInfo->Q6_1_9_W; ?>" type="text" name="Q6_1_9_W" class="form-control">


                                    </div>
                                </div>

                                <div <?php if ($userInfo->fk_sex == 25) echo " style='display:none;'" ?> class="col-md-12 Q5_1_no_reluctant_unknown_female">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            6.1.10) মৃত্যুর কিছুক্ষণ পূর্বে পেটে তীব্র ব্যথা ছিল কি?
                                        </label>

                                        <select class="form-control" name="Q6_1_10">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_1_10 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div <?php if ($userInfo->fk_sex == 25) echo " style='display:none;'" ?> class="col-md-12 Q5_1_no_reluctant_unknown_female">
                                    <h5 style="color:red;font-size:14px;">Note: If the person died from accident/injury within 48 hours, skip to Q 9.0 </h5>
                                    <br>6.2) গর্ভাবস্থার বিবরণ (SYMPTOMS & SIGNS ASSOCIATED WITH PREGNANCY)
                                    <br><br>(যদি অবিবাহিত হয়ে থাকেন তা হলে সতর্কতার সহিত গর্ভ সম্বন্ধে খোজ খবর নিন।)
                                    <br><br>6.2.1) মৃত্যু পর্যন্ত তার কতজন জীবিত বাচ্চা ও মৃত বাচ্চা এবং কতবার গর্ভপাত হয়েছিল? <br/>(Code: 00 =একটিও না, প্রযোজ্য নয়  = 88, 99 = অজানা)
                                    <br><br>
                                </div>
                                <div <?php if ($userInfo->fk_sex == 25) echo " style='display:none;'" ?> class="col-md-12 Q5_1_no_reluctant_unknown_female">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            জীবিত সন্তান
                                        </label>
                                        <input value="<?php echo $userInfo->Q6_2_1_A; ?>" type="text" name="Q6_2_1_A" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>মৃত সন্তান</label>
                                        <input value="<?php echo $userInfo->Q6_2_1_B; ?>" type="text" name="Q6_2_1_B" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">                     
                                        <label>গর্ভপাত (স্বতঃস্ফুর্তভাবে)</label>    
                                        <input value="<?php echo $userInfo->Q6_2_1_C; ?>" type="text" name="Q6_2_1_C" class="form-control">  

                                    </div>
                                </div>

                                <div <?php if ($userInfo->fk_sex == 25) echo " style='display:none;'" ?> class="col-md-12 Q5_1_no_reluctant_unknown_female">
                                    <div class="col-md-4 form-group">
                                        <label>গর্ভপাত/এমআর (উদ্দেশ্য প্রনোদিত)
                                        </label>
                                        <input value="<?php echo $userInfo->Q6_2_1_D; ?>" type="text" name="Q6_2_1_D" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>গর্ভাবস্থায়</label>
                                        <input value="<?php echo $userInfo->Q6_2_1_E; ?>" type="text" name="Q6_2_1_E" class="form-control">
                                    </div>
                                </div>

                                <div <?php if ($userInfo->fk_sex == 25) echo " style='display:none;'" ?> class="col-md-12 Q5_1_no_reluctant_unknown_female">
                                    <div class="col-md-4 form-group">
                                        <tr>
                                        <label>
                                            6.2.2) সর্বশেষ কবে তার প্রসব/গর্ভপাত/এমআর হয়েছিল?
                                        </label>
                                        <?php
                                        $Q6_2_2 = '';
                                        if (!empty($userInfo->Q6_2_2)) {
                                            $partsRequire = explode('-', $userInfo->Q6_2_2);
                                            $Q6_2_2 = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];
                                        }
                                        ?>
                                        <input value="<?php if ($userInfo->Q6_2_2 != "1900-01-01") echo $Q6_2_2; ?>" autocomplete="off" name="Q6_2_2" type="text" class="datepicker form-control">


                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            6.2.3) তিনি কখন মারা গেছেন?
                                        </label>

                                        <select id="Q6_2_3" class="form-control" name="Q6_2_3">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Death_When as $VA_Death_When_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_3 == $VA_Death_When_single->id) echo ' selected'; ?> value="<?php echo $VA_Death_When_single->id; ?>"><?php echo $VA_Death_When_single->name; ?></option>
                                            <?php } ?>
                                        </select>


                                    </div>
                                    <div <?php if ($userInfo->Q6_2_3 == 1635) echo " style='display:none;'" ?> class="col-md-4 form-group Q6_2_3_Not_Delivery">
                                        <label>
                                            6.2.4) মৃত্যুর পূর্বে উনি বুকের দুধ পান করাতেন?
                                        </label>
                                        <select id="Q6_2_4" class="form-control" name="Q6_2_4">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_4 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>


                                    </div>
                                </div>

                                <div <?php if ($userInfo->fk_sex == 25 || $userInfo->Q6_2_3 == 1635) echo " style='display:none;'" ?> class="col-md-12 Q5_1_no_reluctant_unknown_female Q6_2_3_Not_Delivery">
                                    <div class="col-md-4 form-group">

                                        <label>
                                            6.2.5) পূর্বে কখনো সিজারিয়ান অপারেশন করা হয়েছিল?
                                        </label>

                                        <select id="Q6_2_5" class="form-control" name="Q6_2_5">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_5 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                    <div class="col-md-4 form-group">

                                        <label>
                                            6.2.6) জমজ গর্ভাবস্থায় বা প্রসবের পরে মারা গেছেন?
                                        </label>

                                        <select id="Q6_2_6" class="form-control" name="Q6_2_6">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_6 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div <?php if ($userInfo->fk_sex == 25 || $userInfo->Q6_2_3 == 1635) echo " style='display:none;'" ?> class="col-md-12 Q5_1_no_reluctant_unknown_female Q6_2_3_Not_Delivery">
                                    6.2.7) তার গর্ভাবস্থায় কোন সমস্যা হলে, জটিলতাগুলো কি কি ছিল? (একাধিক উত্তর হতে পারে)
                                    <br><br>
                                </div>
                                <div <?php if ($userInfo->fk_sex == 25 || $userInfo->Q6_2_3 == 1635) echo " style='display:none;'" ?> class="col-md-12 Q5_1_no_reluctant_unknown_female Q6_2_3_Not_Delivery">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            ১. মাথা ব্যথা
                                        </label>

                                        <select id="Q6_2_7_1" class="form-control" name="Q6_2_7_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_7_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>


                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            ২. চোখে ঝাপসা দেখা-গর্ভাবস্থায়
                                        </label>

                                        <select id="Q6_2_7_2" class="form-control" name="Q6_2_7_2">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_7_2 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            ৩. মুখে/পায়ে পানি আসা
                                        </label>
                                        <select id="Q6_2_7_3" class="form-control" name="Q6_2_7_3">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_7_3 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>


                                <div <?php if ($userInfo->fk_sex == 25 || $userInfo->Q6_2_3 == 1635) echo " style='display:none;'" ?> class="col-md-12 Q5_1_no_reluctant_unknown_female Q6_2_3_Not_Delivery">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            ৪. উচ্চরক্ত চাপ
                                        </label>
                                        <select id="Q6_2_7_4" class="form-control" name="Q6_2_7_4">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_7_4 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            ৫. রক্তশুন্যতা
                                        </label>

                                        <select id="Q6_2_7_5" class="form-control" name="Q6_2_7_5">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_7_5 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            ৬. অতিরিক্ত বমি
                                        </label>

                                        <select id="Q6_2_7_6" class="form-control" name="Q6_2_7_6">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_7_6 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div <?php if ($userInfo->fk_sex == 25 || $userInfo->Q6_2_3 == 1635) echo " style='display:none;'" ?> class="col-md-12 Q5_1_no_reluctant_unknown_female Q6_2_3_Not_Delivery">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            ৭. রক্তস্রাব
                                        </label>

                                        <select id="Q6_2_7_7" class="form-control" name="Q6_2_7_7">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_7_7 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            ৮. পেট ব্যথা (তীব্র)
                                        </label>

                                        <select id="Q6_2_7_8" class="form-control" name="Q6_2_7_8">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_7_8 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            ৯. জন্ডিস
                                        </label>

                                        <select id="Q6_2_7_9" class="form-control" name="Q6_2_7_9">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_7_9 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div <?php if ($userInfo->fk_sex == 25 || $userInfo->Q6_2_3 == 1635) echo " style='display:none;'" ?> class="col-md-12 Q5_1_no_reluctant_unknown_female Q6_2_3_Not_Delivery">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            ১০. হঠাৎ অজ্ঞান হওয়া / খিঁচুনী
                                        </label>
                                        <select id="Q6_2_7_10" class="form-control" name="Q6_2_7_10">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_7_10 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>    
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            ১১. বেশী জ্বর
                                        </label>

                                        <select id="Q6_2_7_11" class="form-control" name="Q6_2_7_11">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_7_11 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            ১২. দেখতে ফ্যাকাশে ও ঘন ঘন শাস নেওয়া
                                        </label>

                                        <select id="Q6_2_7_12" class="form-control" name="Q6_2_7_12">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_7_12 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div <?php if ($userInfo->fk_sex == 25 || $userInfo->Q6_2_3 == 1635) echo " style='display:none;'" ?> class="col-md-12 Q5_1_no_reluctant_unknown_female Q6_2_3_Not_Delivery">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            ১৩. গন্ধযুক্তস্রাব বের হওয়া
                                        </label>
                                        <select id="Q6_2_7_13" class="form-control" name="Q6_2_7_13">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_7_13 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            ১৪. সময়ের আগে পানি ভাঙ্গা(PRM)
                                        </label>

                                        <select id="Q6_2_7_14" class="form-control" name="Q6_2_7_14">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_7_14 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            ১৫. অন্যান্য (উল্লেখ করুন)
                                        </label>

                                        <select onchange="showHide(this.id, 'Q6_2_7_15_off')" class="form-control" id="Q6_2_7_15" name="Q6_2_7_15">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q6_2_7_15 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Yes_No_Reluctant_Unknown_single->code == 1)
                                                    echo " id='Q6_2_7_15_root'";
                                                else
                                                    echo " id='Q6_2_7_15_" . $i . "'";
                                                ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select><br/>
                                        <input value="<?php echo $userInfo->Q6_2_7_15_OTHER; ?>" <?php if (strlen($userInfo->Q6_2_7_15_OTHER) > 0 == false) echo " style='display:none;'"; ?> type="text" id="Q6_2_7_15_off" name="Q6_2_7_15_OTHER" class="form-control">
                                    </div>

                                    <div class="box-footer col-md-12">
                                        <input type="submit" class="btn btn-primary" value="Update">
                                    </div>
                                </div>

                                <div <?php if ($userInfo->fk_sex == 25 || $userInfo->Q6_2_3 == 1635) echo " style='display:none;'" ?> class="col-md-12 Q5_1_no_reluctant_unknown_female Q6_2_3_Not_Delivery">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            6.2.7a) গর্ভাবস্থায় প্রথম ছয় মাসে রক্তপাত হয়েছিল?
                                        </label>

                                        <select id="Q6_2_7A" class="form-control" name="Q6_2_7A">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_7A == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>


                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            6.2.7b) গর্ভবস্থায় শেষ ৩ মাসে, কিন্তু প্রসবব্যথা শুরু হওয়ার আগে রক্তপাত হয়েছিল?
                                        </label>

                                        <select id="Q6_2_7B" class="form-control" name="Q6_2_7B">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_7B == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                        <label>

                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>6.2.8) গর্ভ খালাসের ফলাফল কি ছিল?
                                        </label>

                                        <select id="Q6_2_8" class="form-control" name="Q6_2_8">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Delivery_Result as $VA_Delivery_Result_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_8 == $VA_Delivery_Result_single->id) echo ' selected'; ?> value="<?php echo $VA_Delivery_Result_single->id; ?>"><?php echo $VA_Delivery_Result_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div <?php if ($userInfo->fk_sex == 25 || $userInfo->Q6_2_3 == 1635|| $userInfo->Q6_2_8 == 2025) echo " style='display:none;'" ?> class="col-md-12 Q5_1_no_reluctant_unknown_female Q6_2_3_Not_Delivery Q6_2_8_part">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            6.2.9) মৃত্যুর ছয় সপ্তাহের মধ্যে জীবিত সুস্থ বাচ্চা জন্ম দিয়েছিলেন?
                                        </label>

                                        <select id="Q6_2_9" class="form-control" name="Q6_2_9">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_9 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>


                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            6.2.10) প্রসবে অতিরিক্ত রক্তপাত (কাপড়, বিছানা বা মেঝে ভিজে যাওয়া) গিয়েছিল?
                                        </label>

                                        <select id="Q6_2_10" class="form-control" name="Q6_2_10">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_10 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                    </div>
                                </div>

                                <div <?php if ($userInfo->fk_sex == 25 || $userInfo->Q6_2_3 == 1635|| $userInfo->Q6_2_8 == 2025) echo " style='display:none;'" ?> class="col-md-12 Q5_1_no_reluctant_unknown_female Q6_2_3_Not_Delivery Q6_2_8_part">
                                    6.2.11) গর্ভখালাসের সময় এরূপ কোন জটিল সমস্যা হয়েছিল?
                                    <br><br>
                                </div>

                                <div <?php if ($userInfo->fk_sex == 25 || $userInfo->Q6_2_3 == 1635|| $userInfo->Q6_2_8 == 2025) echo " style='display:none;'" ?> class="col-md-12 Q5_1_no_reluctant_unknown_female Q6_2_3_Not_Delivery Q6_2_8_part">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            তলপেটে প্রচন্ড ব্যাথা
                                        </label>

                                        <select id="Q6_2_11_A" class="form-control" name="Q6_2_11_A">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_11_A == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            উল্টা প্রসব (Breech)
                                        </label>
                                        <select id="Q6_2_11_B" class="form-control" name="Q6_2_11_B">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_11_B == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                    <div class="col-md-4 form-group">

                                        <label>
                                            হাত পা আগে আসা
                                        </label>
                                        <select id="Q6_2_11_C" class="form-control" name="Q6_2_11_C">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_11_C == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                </div>

                                <div <?php if ($userInfo->fk_sex == 25 || $userInfo->Q6_2_3 == 1635|| $userInfo->Q6_2_8 == 2025) echo " style='display:none;'" ?> class="col-md-12 Q5_1_no_reluctant_unknown_female Q6_2_3_Not_Delivery Q6_2_8_part">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            অতিরিক্ত রক্ত স্রাব
                                        </label>
                                        <select id="Q6_2_11_D" class="form-control" name="Q6_2_11_D">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_11_D == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            ধীরে ধীরে অজ্ঞান হয়ে যাওয়া 
                                        </label>

                                        <select id="Q6_2_11_E" class="form-control" name="Q6_2_11_E">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option  <?php if ($userInfo->Q6_2_11_E == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            অন্যান্য (উল্লেখ করুন)
                                        </label>
                                        <select onchange="showHide(this.id, 'Q6_2_11_F_off')" id="Q6_2_11_F" class="form-control" name="Q6_2_11_F">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q6_2_11_F == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Yes_No_Reluctant_Unknown_single->code == 1)
                                                    echo " id='Q6_2_11_F_root'";
                                                else
                                                    echo " id='Q6_2_11_F_" . $i . "'";
                                                ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select><br/>
                                        <input value="<?php echo $userInfo->Q6_2_11_F_OTHER; ?>" <?php if (strlen($userInfo->Q6_2_11_F_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q6_2_11_F_off" type="text" name="Q6_2_11_F_OTHER" class="form-control">
                                    </div>

                                    <div class="box-footer col-md-12">
                                        <input type="submit" class="btn btn-primary" value="Update">
                                    </div>

                                </div>



                                <div <?php if ($userInfo->fk_sex == 25 || $userInfo->Q6_2_3 == 1635|| $userInfo->Q6_2_8 == 2025) echo " style='display:none;'" ?> class="col-md-12 Q5_1_no_reluctant_unknown_female Q6_2_3_Not_Delivery Q6_2_8_part">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            6.2.12) প্রসব বেদনা কতক্ষন স্থায়ী ছিল?
                                        </label> 
                                        <select id="Q6_2_12" class="form-control" name="Q6_2_12">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Delivery_Durability as $VA_Delivery_Durability_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_12 == $VA_Delivery_Durability_single->id) echo ' selected'; ?> value="<?php echo $VA_Delivery_Durability_single->id; ?>"><?php echo $VA_Delivery_Durability_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            6.2.12.1) প্রসব বা গর্ভপাতের পরে অতিরিক্ত রক্তপাত হয়েছিল?
                                        </label>
                                        <select id="Q6_2_12_1" class="form-control" name="Q6_2_12_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_12_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            6.2.13) তার ডেলিভারী কোথায় হয়েছিল?
                                        </label>
                                        <select onchange="showHide(this.id, 'Q6_2_13_off')" id="Q6_2_13" class="form-control" name="Q6_2_13">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Delivery_Place as $VA_Delivery_Place_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q6_2_13 == $VA_Delivery_Place_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Delivery_Place_single->code == 11)
                                                    echo " id='Q6_2_13_root'";
                                                else
                                                    echo " id='Q6_2_13_" . $i . "'";
                                                ?> value="<?php echo $VA_Delivery_Place_single->id; ?>"><?php echo $VA_Delivery_Place_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select><br/>
                                        <input value="<?php echo $userInfo->Q6_2_13_OTHER; ?>" <?php if (strlen($userInfo->Q6_2_13_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q6_2_13_off" type="text" name="Q6_2_13_OTHER" class="form-control">
                                    </div>
                                </div>

                                <div <?php if ($userInfo->fk_sex == 25 || $userInfo->Q6_2_3 == 1635|| $userInfo->Q6_2_8 == 2025) echo " style='display:none;'" ?> class="col-md-12 Q5_1_no_reluctant_unknown_female Q6_2_3_Not_Delivery Q6_2_8_part">
                                    6.2.14) ডেলিভারী বাড়ীতে/পথিমধ্যে হলে প্রসবকার্যে কে কে জড়িত ছিল? (একাধিক উত্তর হতে পারে)
                                    <br><br>
                                </div>

                                <div <?php if ($userInfo->fk_sex == 25 || $userInfo->Q6_2_3 == 1635|| $userInfo->Q6_2_8 == 2025) echo " style='display:none;'" ?> class="col-md-12 Q5_1_no_reluctant_unknown_female Q6_2_3_Not_Delivery Q6_2_8_part Q6_2_14_part">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            ডাক্তার
                                        </label>
                                        <select id="Q6_2_14_A" class="form-control" name="Q6_2_14_A">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_14_A == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>নার্স</label>

                                        <select id="Q6_2_14_B" class="form-control" name="Q6_2_14_B">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_14_B == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            CSBA (FWA/HA trained)
                                        </label>
                                        <select id="Q6_2_14_C" class="form-control" name="Q6_2_14_C">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_14_C == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div <?php if ($userInfo->fk_sex == 25 || $userInfo->Q6_2_3 == 1635|| $userInfo->Q6_2_8 == 2025) echo " style='display:none;'" ?> class="col-md-12 Q5_1_no_reluctant_unknown_female Q6_2_3_Not_Delivery Q6_2_8_part Q6_2_14_part">
                                    <div class="col-md-4 form-group">
                                        <label>টিবিএ (Trained)</label>
                                        <select id="Q6_2_14_D" class="form-control" name="Q6_2_14_D">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_14_D == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>টিবিএ(Untrained)</label>
                                        <select id="Q6_2_14_E" class="form-control" name="Q6_2_14_E">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_14_E == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>আত্মীয়/প্রতিবেশী</label>
                                        <select id="Q6_2_14_F" class="form-control" name="Q6_2_14_F">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_14_F == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div <?php if ($userInfo->fk_sex == 25 || $userInfo->Q6_2_3 == 1635|| $userInfo->Q6_2_8 == 2025) echo " style='display:none;'" ?> class="col-md-12 Q5_1_no_reluctant_unknown_female Q6_2_3_Not_Delivery Q6_2_8_part">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            6.2.15) মৃত্যুর কিছুক্ষণ পূর্বে জরায়ু ফেলে দিতে অপারেশন করা হয়েছিল?
                                        </label>

                                        <select id="Q6_2_15" class="form-control" name="Q6_2_15">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_15 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>


                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            6.2.16) কি পদ্ধতিতে ডেলিভারী হয়েছিল?
                                        </label>

                                        <select id="Q6_2_16" class="form-control" name="Q6_2_16">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Delivery_Method as $VA_Delivery_Method_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_16 == $VA_Delivery_Method_single->id) echo ' selected'; ?> value="<?php echo $VA_Delivery_Method_single->id; ?>"><?php echo $VA_Delivery_Method_single->name; ?></option>
                                            <?php } ?>
                                        </select>


                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            6.2.17) তিনি কত মাসের গর্ভবতী ছিলেন?
                                        </label>

                                        <input id="Q6_2_17_M" value="<?php echo $userInfo->Q6_2_17_M; ?>" name="Q6_2_17_M" type="text" class="form-control">


                                    </div>
                                </div>

                                <div <?php if ($userInfo->fk_sex == 25 || $userInfo->Q6_2_3 == 1635|| $userInfo->Q6_2_8 == 2025) echo " style='display:none;'" ?> class="col-md-12 Q5_1_no_reluctant_unknown_female Q6_2_3_Not_Delivery Q6_2_8_part">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            6.2.17.1) শিশুটির জন্ম নির্দিষ্ট সময়ের এক মাস বা তারও আগে সংঘটিত হয়েছিল কি?
                                        </label>

                                        <select id="Q6_2_17_1" class="form-control" name="Q6_2_17_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_17_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>


                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            6.2.18) তার গর্ভফুল সম্পূর্ন বের হয়েছিল?
                                        </label>

                                        <select id="Q6_2_18" class="form-control" name="Q6_2_18">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q6_2_18 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>



                                <div class="col-md-12">
                                    VII. QUESTION ON SYMPTOMS & SIGNS OF FINAL ILLNESS
                                    <br><br>7.1) জ্বর(Fever)
                                    <br><br>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.1.1) সর্বশেষ অসুস্থতার সময় তার কি জ্বর ছিল?
                                            <br/><p style="color:red;font-size:14px;">Note: If the person is male and died from accident/injury within 48 hours, skip to Q9.0 please</p>
                                        </label>

                                        <select id="Q7_1_1" class="form-control" name="Q7_1_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_1_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>


                                    </div>
                                    <div <?php if ($userInfo->Q7_1_1 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_1_1_no_reluctant_unknown">
                                        <label>
                                            7.1.2) তার কতদিন যাবৎ জ্বর ছিল?
                                        </label>

                                        <input value="<?php echo $userInfo->Q7_1_2_D; ?>" id="Q7_1_2_D" name="Q7_1_2_D" type ="text" class="form-control">


                                    </div>
                                    <div <?php if ($userInfo->Q7_1_1 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_1_1_no_reluctant_unknown">

                                        <label>
                                            7.1.3) জ্বরের মাত্রা কেমন ছিল?
                                        </label>

                                        <select id="Q7_1_3" class="form-control" name="Q7_1_3">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Fever_Dimension as $VA_Fever_Dimension_single) { ?>
                                                <option <?php if ($userInfo->Q7_1_3 == $VA_Fever_Dimension_single->id) echo ' selected'; ?> value="<?php echo $VA_Fever_Dimension_single->id; ?>"><?php echo $VA_Fever_Dimension_single->name; ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div <?php if ($userInfo->Q7_1_1 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_1_1_no_reluctant_unknown">

                                        <label>
                                            7.1.4) জ্বর কি ধরনের ছিল?
                                        </label>

                                        <select id="Q7_1_4" class="form-control" name="Q7_1_4">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Fever_Type as $VA_Fever_Type_single) { ?>
                                                <option <?php if ($userInfo->Q7_1_4 == $VA_Fever_Type_single->id) echo ' selected'; ?> value="<?php echo $VA_Fever_Type_single->id; ?>"><?php echo $VA_Fever_Type_single->name; ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                    <div <?php if ($userInfo->Q7_1_1 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_1_1_no_reluctant_unknown">
                                        <label>
                                            7.1.5) জ্বরের সাথে তার  কি শীত শীত ভাব/কাঁপুনী ছিল?
                                        </label>

                                        <select id="Q7_1_5" class="form-control" name="Q7_1_5">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_1_5 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                    <div <?php if ($userInfo->Q7_1_1 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_1_1_no_reluctant_unknown">

                                        <label>
                                            7.1.6) জ্বর হওয়ার পর তার শরীরে রাতে ঘাম হতো কিনা?
                                        </label>

                                        <select id="Q7_1_6" class="form-control" name="Q7_1_6">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_1_6 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div <?php if ($userInfo->Q7_1_1 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_1_1_no_reluctant_unknown">
                                        <label>
                                            7.1.7) মৃত্যুর সময় পর্যন্ত জ্বর অব্যাহত ছিল?
                                        </label>

                                        <select id="Q7_1_7" class="form-control" name="Q7_1_7">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_1_7 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    দানা/লালচে গোটা (RASH)<br><br>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">

                                        <label>
                                            7.2.1) তার গায়ে কি দানা/লালচে গোটা উঠেছিল?
                                        </label>

                                        <select id="Q7_2_1" class="form-control" name="Q7_2_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_2_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>


                                    </div>
                                    <div <?php if ($userInfo->Q7_2_1 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_2_1_no_reluctant_unknown">
                                        <label>
                                            7.2.2) শরীরের কোথায় দানা উঠেছিল?
                                        </label>
                                        <select onchange="showHide(this.id, 'Q7_2_2_off')" name="Q7_2_2" class="form-control" id="Q7_2_2">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Body_Where as $VA_Body_Where_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q7_2_2 == $VA_Body_Where_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Body_Where_single->code == 5)
                                                    echo " id='Q7_2_2_root'";
                                                else
                                                    echo " id='Q7_2_2_" . $i . "'";
                                                ?> value="<?php echo $VA_Body_Where_single->id; ?>"><?php echo $VA_Body_Where_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q7_2_2_OTHER; ?>" <?php if (strlen($userInfo->Q7_2_2_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q7_2_2_off" type="text" name="Q7_2_2_OTHER" class="form-control">
                                    </div>
                                    <div <?php if ($userInfo->Q7_2_1 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_2_1_no_reluctant_unknown">
                                        <label>
                                            7.2.3) কত দিন যাবৎ গায়ে দানা/গোটা ছিল?
                                        </label>

                                        <input value="<?php echo $userInfo->Q7_2_3_D; ?>" id="Q7_2_3_D" name="Q7_2_3_D" type="text" class="form-control">

                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div <?php if ($userInfo->Q7_2_1 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_2_1_no_reluctant_unknown">
                                        <label>
                                            7.2.4) দানাগুলো দেখতে কেমন ছিল?
                                        </label>

                                        <select onchange="showHide(this.id, 'Q7_2_4_off')" name="Q7_2_4" class="form-control" id="Q7_2_4">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Grain_Type as $VA_Grain_Type_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q7_2_4 == $VA_Grain_Type_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Grain_Type_single->code == 4)
                                                    echo " id='Q7_2_4_root'";
                                                else
                                                    echo " id='Q7_2_4_" . $i . "'";
                                                ?> value="<?php echo $VA_Grain_Type_single->id; ?>"><?php echo $VA_Grain_Type_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q7_2_4_OTHER; ?>" <?php if (strlen($userInfo->Q7_2_4_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q7_2_4_off" type="text" name="Q7_2_4_OTHER" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.2.5) কখনো গায়ে/চামড়ায় ব্যথাযুক্ত ফোস্কা(Shingles/herpes zoster)
                                        </label>

                                        <select class="form-control" name="Q7_2_5">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_2_5 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.2.5a) তার চোখ কি লাল/লালচে হয়ে গিয়েছিল?
                                        </label>

                                        <select class="form-control" name="Q7_2_5A">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_2_5A == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.2.6) চামড়ায় চুলকানি ছিল কি?
                                        </label>

                                        <select class="form-control" name="Q7_2_6">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_2_6 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.2.6.1) উনার শরীরের কি চামড়া স্তরে স্তরে উঠে যেত?
                                        </label>

                                        <select class="form-control" name="Q7_2_6_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_2_6_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.2.7) মৃত ব্যক্তির শরীরের কোন জায়গা থেকে রক্তক্ষরন হয়েছিল কি?
                                        </label>

                                        <select id="Q7_2_7" class="form-control" name="Q7_2_7">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_2_7 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div <?php if ($userInfo->Q7_2_7 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q7_2_8_no_reluctant_unknown">
                                    7.2.8) শরীরের কোন স্থান থেকে রক্তক্ষরন হয়েছিল? (একাধিক উত্তর হতে পারে, যাচাই করে সবগুলি উত্তর জেনে নিন)
                                    <br><br>
                                </div>

                                <div  <?php if ($userInfo->Q7_2_7 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q7_2_8_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            চোখের পর্দার নিচ
                                        </label>

                                        <select id="Q7_2_8_A" class="form-control" name="Q7_2_8_A">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_2_8_A == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            নাক
                                        </label>

                                        <select id="Q7_2_8_B" class="form-control" name="Q7_2_8_B">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_2_8_B == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            বমির সাথে
                                        </label>

                                        <select id="Q7_2_8_C" class="form-control" name="Q7_2_8_C">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_2_8_C == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div <?php if ($userInfo->Q7_2_7 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q7_2_8_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            দাঁতের মাড়ি
                                        </label>
                                        <select id="Q7_2_8_D" class="form-control" name="Q7_2_8_D">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_2_8_D == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            পায়ুপথ
                                        </label>

                                        <select id="Q7_2_8_E" class="form-control" name="Q7_2_8_E">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_2_8_E == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            অন্যান্য(উল্লেখ করুন)
                                        </label>
                                        <select onchange="showHide(this.id, 'Q7_2_8_F_off')" name="Q7_2_8_F" class="form-control" id="Q7_2_8_F">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q7_2_8_F == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Yes_No_Reluctant_Unknown_single->code == 1)
                                                    echo " id='Q7_2_8_F_root'";
                                                else
                                                    echo " id='Q7_2_8_F_" . $i . "'";
                                                ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q7_2_8_F_OTHER; ?>" <?php if (strlen($userInfo->Q7_2_8_F_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q7_2_8_F_off" type="text" name="Q7_2_8_F_OTHER" class="form-control">
                                    </div>
                                </div>

                                <div class="box-footer col-md-12">
                                    <input type="submit" class="btn btn-primary" value="Update">
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.2.9) পায়ের তলায় ঝিন ঝিনি ভাব হতো?
                                        </label>

                                        <select class="form-control" name="Q7_2_9">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_2_9 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.2.10) ঠোঁট নীলচে হয়ে যেত?
                                        </label>

                                        <select class="form-control" name="Q7_2_10">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_2_10 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.2.11) পায়ের পাতা বা পায়ের পাতা ছাড়া অন্য জায়গায় ক্ষত ছিল?
                                        </label>

                                        <select class="form-control" name="Q7_2_11">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Leg_Wound as $VA_Leg_Wound_single) { ?>
                                                <option <?php if ($userInfo->Q7_2_11 == $VA_Leg_Wound_single->id) echo ' selected'; ?> value="<?php echo $VA_Leg_Wound_single->id; ?>"><?php echo $VA_Leg_Wound_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.2.12) পায়ের তলায় গর্তযুক্ত ক্ষত ছিল কি?
                                        </label>

                                        <select id="Q7_2_12" class="form-control" name="Q7_2_12">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_2_12 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_2_12 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_2_12_no_reluctant_unknown">
                                        <label>
                                            7.2.13) ক্ষত থেকে ধীরে ধীরে পূঁজ বের হতো বা ঝরতো কিনা?
                                        </label>

                                        <select id="Q7_2_13" class="form-control" name="Q7_2_13">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_2_13 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_2_13 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_2_13_no_reluctant_unknown">
                                        <label>
                                            7.2.14) কতদিন যাবৎ পুঁজ বের হতো?
                                        </label>

                                        <input id="Q7_2_14_D" value="<?php echo $userInfo->Q7_2_14_D; ?>" name="Q7_2_14_D" type="text" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    7.3) চামড়ায় অন্যান্য পরিবর্তন (OTHER SKIN CHANGES)
                                    <br><br>7.3.1) মৃতব্যক্তির শরীরে ছিট ছিট সাদা/কালো দাগ/গুটি ছল কিনা এবং থাকলে কোথায় ছিল? (একাধিক উত্তর হতে পারে)
                                    <br><br>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>হাতের তালুতে</label>
                                        <select class="form-control" name="Q7_3_1_A">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_3_1_A == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>


                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>বুকে/পেটে</label>

                                        <select class="form-control" name="Q7_3_1_B">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_3_1_B == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>পিঠে</label>

                                        <select class="form-control" name="Q7_3_1_C">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_3_1_C == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>পায়ের তলায়</label>

                                        <select class="form-control" name="Q7_3_1_D">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_3_1_D == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>সমস্ত শরীরে</label>

                                        <select class="form-control" name="Q7_3_1_E">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_3_1_E == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>অন্যান্য স্থানে</label>

                                        <select onchange="showHide(this.id, 'Q7_3_1_off')" name="Q7_3_1_F" class="form-control" id="Q7_3_1_F">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q7_3_1_F == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Yes_No_Reluctant_Unknown_single->code == 1)
                                                    echo " id='Q7_3_1_F_root'";
                                                else
                                                    echo " id='Q7_3_1_F_" . $i . "'";
                                                ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q7_3_1_F_OTHER; ?>" <?php if (strlen($userInfo->Q7_3_1_F_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q7_3_1_off" type="text" name="Q7_3_1_F_OTHER" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <p style="color:red;font-size:14px;">Note: If all answers of 7.3.1 are no then skip 7.3.2 </p>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">

                                        <label>
                                            7.3.2) কত বছর/মাস যাবৎ ছিটছিটে সাদা/কালো দাগ/গুটি ছিল? 
                                        </label>

                                        <input value="<?php echo $userInfo->Q7_3_2_Y; ?>" name="Q7_3_2_Y" style="width:50%;float:left;" placeholder="বছর" type="text" class="form-control">
                                        <input value="<?php echo $userInfo->Q7_3_2_M; ?>" name="Q7_3_2_M" style="width:50%;float:left;" placeholder="মাস" type="text" class="form-control">


                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.3.3) মৃত ব্যক্তির হাতের তালু ও পায়ের তলায়-চামড়া শক্ত/গুটি ছিল কিনা?
                                        </label>

                                        <select id="Q7_3_3" class="form-control" name="Q7_3_3">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_3_3 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                    <div <?php if ($userInfo->Q7_3_3 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_3_3_no_reluctant_unknown">

                                        <label>
                                            7.3.4) কত বছর/মাস যাবৎ হাতের তালু ও পায়ের তলায়-চামড়া শক্ত/গুটি ছিল?
                                        </label>

                                        <input value="<?php echo $userInfo->Q7_3_4_Y; ?>" id="Q7_3_4_Y" name="Q7_3_4_Y" style="width:50%;float:left;" placeholder="বছর" type="text" class="form-control">
                                        <input value="<?php echo $userInfo->Q7_3_4_M; ?>" id="Q7_3_4_M" name="Q7_3_4_M" style="width:50%;float:left;" placeholder="মাস" type="text" class="form-control">

                                    </div>
                                </div>

                                <div class="box-footer col-md-12">
                                    <input type="submit" class="btn btn-primary" value="Update">
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">

                                        <label>
                                            7.3.5) আপনি কি জানেন, মৃত ব্যক্তি আর্সেনিক সংক্রান্ত জটিলতায় ভুগছিলেন কিনা?
                                        </label>

                                        <select id="Q7_3_5" class="form-control" name="Q7_3_5">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_3_5 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                    <div <?php if ($userInfo->Q7_3_5 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_3_5_no_reluctant_unknown">

                                        <label>
                                            7.3.6) কোথায় প্রথম আর্সেনিকজনিত অসুস্থতা নির্নয় হয়েছিল?
                                        </label>

                                        <select onchange="showHide(this.id, 'Q7_3_6_off')" name="Q7_3_6" class="form-control" id="Q7_3_6">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Arsenic_Identification_Hospital as $VA_Arsenic_Identification_Hospital_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q7_3_6 == $VA_Arsenic_Identification_Hospital_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Arsenic_Identification_Hospital_single->code == 6)
                                                    echo " id='Q7_3_6_root'";
                                                else
                                                    echo " id='Q7_3_6_" . $i . "'";
                                                ?> value="<?php echo $VA_Arsenic_Identification_Hospital_single->id; ?>"><?php echo $VA_Arsenic_Identification_Hospital_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q7_3_6_OTHER; ?>" <?php if (strlen($userInfo->Q7_3_6_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q7_3_6_off" type="text" name="Q7_3_6_OTHER" class="form-control">

                                    </div>
                                    <div class="col-md-4 form-group">

                                        <label>
                                            7.3.7) চামড়ার পরিবর্তনের সাথে/চামড়ায় ক্ষত/দগদগে ঘা ছিল কিনা?
                                        </label>

                                        <select id="Q7_3_7" class="form-control" name="Q7_3_7">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_3_7 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div <?php if ($userInfo->Q7_3_7 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q7_3_7_no_reluctant_unknown">
                                    7.3.8) (যদি হ্যাঁ হয়) শরীরের কোন কোন জায়গায় ক্ষত/দগদগে ঘা ছিল? (উল্লেখ করুন)
                                    <br><br>
                                </div>

                                <div <?php if ($userInfo->Q7_3_7 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q7_3_7_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            হাতের তালুতে
                                        </label>

                                        <select id="Q7_3_8_A" class="form-control" name="Q7_3_8_A">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_3_8_A == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>বুকে/পেটে</label>
                                        <select id="Q7_3_8_B" class="form-control" name="Q7_3_8_B">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_3_8_B == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>পিঠে</label>
                                        <select id="Q7_3_8_C" class="form-control" name="Q7_3_8_C">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_3_8_C == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div <?php if ($userInfo->Q7_3_7 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q7_3_7_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>পায়ের তলায়</label>

                                        <select id="Q7_3_8_D" class="form-control" name="Q7_3_8_D">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_3_8_D == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>জিহ্বা/মাড়ি</label>

                                        <select id="Q7_3_8_E" class="form-control" name="Q7_3_8_E">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_3_8_E == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>সমস্ত শরীরে</label>

                                        <select id="Q7_3_8_F" class="form-control" name="Q7_3_8_F">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_3_8_F == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>


                                <div <?php if ($userInfo->Q7_3_7 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q7_3_7_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>অন্যান্য</label>

                                        <select onchange="showHide(this.id, 'Q7_3_8_G_off')" name="Q7_3_8_G" class="form-control" id="Q7_3_8_G">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q7_3_8_G == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Yes_No_Reluctant_Unknown_single->code == 1)
                                                    echo " id='Q7_3_8_G_root'";
                                                else
                                                    echo " id='Q7_3_8_G_" . $i . "'";
                                                ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q7_3_8_G_OTHER; ?>" <?php if (strlen($userInfo->Q7_3_8_G_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q7_3_8_G_off" type="text" name="Q7_3_8_G_OTHER" class="form-control">
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    7.4) ওজন হ্রাস (WEIGHT LOSS)
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.4.1) মৃত্যুর আগে তার কি ওজন কমে গিয়েছিল?
                                        </label>
                                        <select id="Q7_4_1" class="form-control" name="Q7_4_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_4_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                    <div <?php if ($userInfo->Q7_4_1 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_4_1_no_reluctant_unknown">
                                        <label>
                                            7.4.2) মৃত্যুর কত মাস/দিন আগে থেকে ওজন কমে ছিল?
                                        </label>


                                        <input value="<?php echo $userInfo->Q7_4_2_M; ?>" id="Q7_4_2_M" name="Q7_4_2_M" style="width:50%;float:left;" placeholder="মাস" type="text" class="form-control">
                                        <input value="<?php echo $userInfo->Q7_4_2_D; ?>" id="Q7_4_2_D" name="Q7_4_2_D" style="width:50%;float:left;" placeholder="দিন" type="text" class="form-control">

                                    </div>
                                    <div <?php if ($userInfo->Q7_4_1 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_4_1_no_reluctant_unknown">

                                        <label>
                                            7.4.3) কি ধরনের ওজন কমে ছিল:
                                        </label>

                                        <select id="Q7_4_3" class="form-control" name="Q7_4_3">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Weight_Loss_Type as $VA_Weight_Loss_Type_single) { ?>
                                                <option <?php if ($userInfo->Q7_4_3 == $VA_Weight_Loss_Type_single->id) echo ' selected'; ?> value="<?php echo $VA_Weight_Loss_Type_single->id; ?>"><?php echo $VA_Weight_Loss_Type_single->name; ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">

                                        <label>
                                            7.4.4) তাকে দেখতে কি খুব পাতলা ও রোগা দেখাত?
                                        </label>

                                        <select class="form-control" name="Q7_4_4">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_4_4 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                    <div class="col-md-4 form-group">

                                        <label>
                                            7.4.5) তার মুখে বা জিহ্বায় কি ঘা বা সাদা জ্যাবড়া (ছোব ছোব) দাগ ছিল?
                                        </label>

                                        <select id="Q7_4_5" class="form-control" name="Q7_4_5">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_4_5 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                    <div <?php if ($userInfo->Q7_4_5 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_4_5_no_reluctant_unknown">

                                        <label>
                                            7.4.6) কত মাস/দিন যাবৎ তাহার মুখে/জিহ্বায় ঘা বা সাদা জ্যাবড়া (ছোব ছোব) দাগ ছিল?
                                        </label>

                                        <input value="<?php echo $userInfo->Q7_4_6_M; ?>" id="Q7_4_6_M" name="Q7_4_6_M" style="width:50%;float:left;" placeholder="মাস" type="text" class="form-control">
                                        <input value="<?php echo $userInfo->Q7_4_6_D; ?>" id="Q7_4_6_D" name="Q7_4_6_D" style="width:50%;float:left;" placeholder="দিন" type="text" class="form-control">


                                    </div>
                                </div>

                                <div class="col-md-12">
                                    7.5) ফ্যাকাশে/জন্ডিস (PALLOR/JAUNDICE)<br><br>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.5.1) শেষ অসুখের সময় তাকে কি ফ্যাকাশে দেখাত (পাতলা বা রক্তের অভাব) বা তার হাতের তালু, চোখ বা নখ কি ফ্যাকাশে ছিল? 
                                        </label>

                                        <select id="Q7_5_1" class="form-control" name="Q7_5_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_5_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_5_1 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_5_1_no_reluctant_unknown">
                                        <label>
                                            7.5.2) কত মাস/দিন যাবৎ তার হাতের তালু, চোখ বা নখ ফ্যাকাশে ছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_5_2_M; ?>" id="Q7_5_2_M" name="Q7_5_2_M" style="width:50%;float:left;" placeholder="মাস" type="text" class="form-control">
                                        <input value="<?php echo $userInfo->Q7_5_2_D; ?>" id="Q7_5_2_D" name="Q7_5_2_D" style="width:50%;float:left;" placeholder="দিন" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.5.3) তাহার চোখ হলদে ছিল কিনা?
                                        </label>

                                        <select id="Q7_5_3" class="form-control" name="Q7_5_3">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_5_3 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div <?php if ($userInfo->Q7_5_3 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q7_5_3_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.5.4) কত দিন যাবৎ চোখ হলদে ছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_5_4_D; ?>" id="Q7_5_4_D" name="Q7_5_4_D" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.5.5) চুলের বর্ণ লালচে/হলদে হয়ে গিয়েছিল কিনা?
                                        </label>
                                        <select id="Q7_5_5" class="form-control" name="Q7_5_5">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_5_5 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="box-footer col-md-12">
                                    <input type="submit" class="btn btn-primary" value="Update">
                                </div>

                                <div class="col-md-12">
                                    7.6) শোথ/ফোলা (OEDEMATUS SWELLING)<br><br>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.6.1) তার কি শরীরের কোথাও ফুলে ছিল? 
                                        </label>  

                                        <select id="Q7_6_1" class="form-control" name="Q7_6_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_6_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                </div>

                                <div <?php if ($userInfo->Q7_6_1 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q7_6_1_no_reluctant_unknown">
                                    7.6.2) কোথায় এ ফোলা ছিল?(একাধিক উত্তর হতে পারে)
                                    <br><br>
                                </div>

                                <div <?php if ($userInfo->Q7_6_1 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q7_6_1_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            গিটে (Joints)
                                        </label>

                                        <select id="Q7_6_2_A" class="form-control" name="Q7_6_2_A">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_6_2_A == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            পায়ের গোঁড়ালী
                                        </label>

                                        <select id="Q7_6_2_B" class="form-control" name="Q7_6_2_B">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_6_2_B == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            দুই পায়ের পাতা 
                                        </label>

                                        <select id="Q7_6_2_C" class="form-control" name="Q7_6_2_C">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_6_2_C == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>


                                <div <?php if ($userInfo->Q7_6_1 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q7_6_1_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            পেট 
                                        </label>

                                        <select id="Q7_6_2_D" class="form-control" name="Q7_6_2_D">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_6_2_D == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            মুখ
                                        </label>

                                        <select id="Q7_6_2_E" class="form-control" name="Q7_6_2_E">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_6_2_E == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            সমস্ত শরীরে
                                        </label>

                                        <select id="Q7_6_2_F" class="form-control" name="Q7_6_2_F">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_6_2_F == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>


                                <div <?php if ($userInfo->Q7_6_1 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q7_6_1_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            অন্যান্য
                                        </label>
                                        <select onchange="showHide(this.id, 'Q7_6_2_G_off')" name="Q7_6_2_G" class="form-control" id="Q7_6_2_G">
                                            <option id="0" value="">নির্বাচন করুন</option>    
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q7_6_2_G == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Yes_No_Reluctant_Unknown_single->code == 1)
                                                    echo " id='Q7_6_2_G_root'";
                                                else
                                                    echo " id='Q7_6_2_G_" . $i . "'";
                                                ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q7_6_2_G_OTHER; ?>" <?php if (strlen($userInfo->Q7_6_2_G_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q7_6_2_G_off" type="text" name="Q7_6_2_G_OTHER" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.6.3) কত মাস/দিন যাবৎ ফোলা ছিল?
                                        </label>

                                        <input value="<?php echo $userInfo->Q7_6_3_M; ?>" id="Q7_6_3_M" name="Q7_6_3_M" style="width:50%;float:left;" placeholder="মাস" type="text" class="form-control">
                                        <input value="<?php echo $userInfo->Q7_6_3_D; ?>" id="Q7_6_3_D" name="Q7_6_3_D" style="width:50%;float:left;" placeholder="দিন" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.6.4) তার কোন অঙ্গ প্রথম ফুলেছিল?
                                        </label>

                                        <select onchange="showHide(this.id, 'Q7_6_4_off')" name="Q7_6_4" class="form-control" id="Q7_6_4">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Swollen_Body_Part as $VA_Swollen_Body_Part_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q7_6_4 == $VA_Swollen_Body_Part_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Swollen_Body_Part_single->code == 7)
                                                    echo " id='Q7_6_4_root'";
                                                else
                                                    echo " id='Q7_6_4_" . $i . "'";
                                                ?> value="<?php echo $VA_Swollen_Body_Part_single->id; ?>"><?php echo $VA_Swollen_Body_Part_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q7_6_4_OTHER; ?>" <?php if (strlen($userInfo->Q7_6_4_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q7_6_4_off" type="text" name="Q7_6_4_OTHER" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    গ্রন্থি ফোলা/গ্রন্থিতে চাকা (GLANDULAR SWELLING/MASS or LUMPS)<br><br>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.6.5) তার গ্রন্থিতে ফোলা বা চাকা (পিচলী) ছিল কি?
                                        </label>
                                        <select id="Q7_6_5" class="form-control" name="Q7_6_5">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_6_5 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                    <div <?php if ($userInfo->Q7_6_5 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_6_5_no_reluctant_unknown">
                                        <label>
                                            7.6.6) কত মাস/দিন যাবৎ তার গ্রন্থিতে ফোলা বা চাকা ছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_6_6_M; ?>" id="Q7_6_6_M" name="Q7_6_6_M" style="width:50%;float:left;" placeholder="মাস" type="text" class="form-control">
                                        <input value="<?php echo $userInfo->Q7_6_6_D; ?>" id="Q7_6_6_D" name="Q7_6_6_D" style="width:50%;float:left;" placeholder="দিন" type="text" class="form-control">
                                    </div>
                                    <div <?php if ($userInfo->Q7_6_5 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_6_5_no_reluctant_unknown">
                                        <label>
                                            7.6.7) গ্রন্থি ফোলা বা চাকা কোথায় ছিল?
                                        </label>

                                        <select id="Q7_6_7" class="form-control" name="Q7_6_7">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Glands_Swollen_Where as $VA_Glands_Swollen_Where_single) { ?>
                                                <option <?php if ($userInfo->Q7_6_7 == $VA_Glands_Swollen_Where_single->id) echo ' selected'; ?> value="<?php echo $VA_Glands_Swollen_Where_single->id; ?>"><?php echo $VA_Glands_Swollen_Where_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.6.8) মুখের ভিতর কোন ক্ষত বা চাকা ছিল কিনা?
                                        </label>
                                        <select class="form-control" name="Q7_6_8">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_6_8 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    7.7) কাঁশি (COUGH)<br><br>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.7.1) সর্বশেষ অসুস্থতার সময় তার কি কাঁশি ছিল?
                                        </label>
                                        <select id="Q7_7_1" class="form-control" name="Q7_7_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_7_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                    <div <?php if ($userInfo->Q7_7_1 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_7_1_no_reluctant_unknown">
                                        <label>
                                            7.7.2) তার কত মাস/দিন যাবৎ কাঁশি ছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_7_2_M; ?>" id="Q7_7_2_M" name="Q7_7_2_M" style="width:50%;float:left;" placeholder="মাস" type="text" class="form-control">
                                        <input value="<?php echo $userInfo->Q7_7_2_D; ?>" id="Q7_7_2_D" name="Q7_7_2_D" style="width:50%;float:left;" placeholder="দিন" type="text" class="form-control">
                                    </div>
                                    <div <?php if ($userInfo->Q7_7_1 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_7_1_no_reluctant_unknown">
                                        <label>
                                            7.7.3) কাঁশি কি মারাত্বক ছিল?
                                        </label>
                                        <select id="Q7_7_3" class="form-control" name="Q7_7_3">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_7_3 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div <?php if ($userInfo->Q7_7_1 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q7_7_1_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.7.4) কাঁশির সময় কি কফ বের হতো?
                                        </label>
                                        <select id="Q7_7_4" class="form-control" name="Q7_7_4">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_7_4 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.7.5) কফের সাথে কি রক্ত যেত?
                                        </label>
                                        <select id="Q7_7_5" class="form-control" name="Q7_7_5">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_7_5 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="box-footer col-md-12">
                                    <input type="submit" class="btn btn-primary" value="Update">
                                </div>

                                <div class="col-md-12">
                                    7.8) শ্বাসকষ্ট  (RESPIRATORY PROBLEMS)<br><br>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.8.1) কি শ্বাসকষ্ট ছিল? (Difficulty Breathing)
                                        </label>
                                        <select id="Q7_8_1" class="form-control" name="Q7_8_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_8_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_8_1 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_8_1_no_reluctant_unknown">
                                        <label>
                                            7.8.2) কত মাস/দিন যাবৎ শ্বাসকষ্ট ছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_8_2_M; ?>" id="Q7_8_2_M" name="Q7_8_2_M" style="width:50%;float:left;" placeholder="মাস" type="text" class="form-control">
                                        <input value="<?php echo $userInfo->Q7_8_2_D; ?>" id="Q7_8_2_D" name="Q7_8_2_D" style="width:50%;float:left;" placeholder="দিন" type="text" class="form-control">
                                    </div>
                                    <div <?php if ($userInfo->Q7_8_1 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_8_1_no_reluctant_unknown">
                                        <label>
                                            7.8.3) এই শ্বাসকষ্ট কি একটানা হত, নাকি মাঝে মাঝে হত? 
                                        </label>
                                        <select id="Q7_8_3" class="form-control" name="Q7_8_3">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Breathing_Problem_Type as $VA_Breathing_Problem_Type_single) { ?>
                                                <option <?php if ($userInfo->Q7_8_3 == $VA_Breathing_Problem_Type_single->id) echo ' selected'; ?> value="<?php echo $VA_Breathing_Problem_Type_single->id; ?>"><?php echo $VA_Breathing_Problem_Type_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.8.4) ঘন ঘন শ্বাস (fast breathing) ফেলতো?
                                        </label>
                                        <select id="Q7_8_4" class="form-control" name="Q7_8_4">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_8_4 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_8_4 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_8_4_no_reluctant_unknown">
                                        <label>
                                            7.8.5) কতদিন যাবত ঘন ঘন শ্বাস ফেলতো?
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_8_5_M; ?>" id="Q7_8_5_M" name="Q7_8_5_M" style="width:50%;float:left;" placeholder="মাস" type="text" class="form-control">
                                        <input value="<?php echo $userInfo->Q7_8_5_D; ?>" id="Q7_8_5_D" name="Q7_8_5_D" style="width:50%;float:left;" placeholder="দিন" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.8.6) উনার কি রুদ্ধশ্বাস / থেমে থেমে শ্বাস নেয়া (Breathlessness) ছিল?
                                        </label>
                                        <select id="Q7_8_6" class="form-control" name="Q7_8_6">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_8_6 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div <?php if ($userInfo->Q7_8_6 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_8_6_no_reluctant_unknown">
                                        <label>
                                            7.8.7) কত মাস / দিন যাবত রুদ্ধশ্বাস / থেমে থেমে শ্বাস নেয়া (Breathlessness) ছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_8_7_M; ?>" id="Q7_8_7_M" name="Q7_8_7_M" style="width:50%;float:left;" placeholder="মাস" type="text" class="form-control">
                                        <input value="<?php echo $userInfo->Q7_8_7_D; ?>" id="Q7_8_7_D" name="Q7_8_7_D" style="width:50%;float:left;" placeholder="দিন" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.8.8) সে কি শ্বাসকষ্টের জন্য দৈনন্দিন কাজকর্ম করতে পারত?
                                        </label>
                                        <select id="Q7_8_8" class="form-control" name="Q7_8_8">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Daily_Work_Hampered_By_Breathing_Problem as $VA_Daily_Work_Hampered_By_Breathing_Problem_single) { ?>
                                                <option <?php if ($userInfo->Q7_8_8 == $VA_Daily_Work_Hampered_By_Breathing_Problem_single->id) echo ' selected'; ?> value="<?php echo $VA_Daily_Work_Hampered_By_Breathing_Problem_single->id; ?>"><?php echo $VA_Daily_Work_Hampered_By_Breathing_Problem_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_8_8 != 1850) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_8_8_no_NoBreathingProblem_unknown">
                                        <label>
                                            7.8.9) কোন অবস্থায় তার শ্বাসকষ্ট বেশী হতো?
                                        </label>
                                        <select id="Q7_8_9" class="form-control" name="Q7_8_9">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Shortness_of_breath_Body_Condition as $VA_Shortness_of_breath_Body_Condition_single) { ?>
                                                <option <?php if ($userInfo->Q7_8_9 == $VA_Shortness_of_breath_Body_Condition_single->id) echo ' selected'; ?> value="<?php echo $VA_Shortness_of_breath_Body_Condition_single->id; ?>"><?php echo $VA_Shortness_of_breath_Body_Condition_single->name; ?></option>
                                            <?php } ?>
                                        </select>  
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div <?php if ($userInfo->Q7_8_8 != 1850) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_8_8_no_NoBreathingProblem_unknown">
                                        <label>
                                            7.8.10) কখন তার শ্বাসকষ্ট বেশী হতো?
                                        </label>

                                        <select id="Q7_8_10" class="form-control" name="Q7_8_10">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Breathing_Problem_When as $VA_Breathing_Problem_When_single) { ?>
                                                <option <?php if ($userInfo->Q7_8_10 == $VA_Breathing_Problem_When_single->id) echo ' selected'; ?> value="<?php echo $VA_Breathing_Problem_When_single->id; ?>"><?php echo $VA_Breathing_Problem_When_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_8_8 != 1850) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_8_8_no_NoBreathingProblem_unknown">
                                        <label>
                                            7.8.11) এরূপ শ্বাসকষ্ট আগেও মাঝে মধ্যে ছিল কি?
                                        </label>
                                        <select id="Q7_8_11" class="form-control" name="Q7_8_11">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Unknown as $VA_Yes_No_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_8_11 == $VA_Yes_No_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.8.12) শ্বাস নেয়ার সময় বুকে ব্যথা হত কি?
                                        </label>
                                        <select class="form-control" name="Q7_8_12">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_8_12 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.8.13) তার কি নিঃশ্বাস নিতে বুকের ভিতর সাঁসাঁ/ঘোত ঘোত শব্দ হতো? (Wheezing or grunting)
                                        </label>
                                        <select class="form-control" name="Q7_8_13">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Unknown as $VA_Yes_No_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_8_13 == $VA_Yes_No_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.8.14) তিনি কি আগেও শ্বাসকষ্ট জনিত রোগে আক্রান্ত হয়েছেন?
                                        </label>
                                        <select class="form-control" name="Q7_8_14">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Unknown as $VA_Yes_No_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_8_14 == $VA_Yes_No_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    7.9) বুক ব্যথা (CHEST PAIN)<br><br>
                                </div> 
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.9.1) সর্বশেষ অসুস্থতার সময় তার কি বুকে ব্যথা ছিল?
                                        </label>
                                        <select id="Q7_9_1" class="form-control" name="Q7_9_1">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_9_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_9_1 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_9_1_no_reluctant_unknown">
                                        <label>
                                            7.9.2) কতদিন বুকে ব্যথা ছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_9_2_D; ?>" id="Q7_9_2_D" name="Q7_9_2_D" type="number" class="form-control">
                                    </div>
                                    <div <?php if ($userInfo->Q7_9_1 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_9_1_no_reluctant_unknown">
                                        <label>
                                            7.9.3) কোথায় ব্যথা ছিল?
                                        </label>
                                        <select onchange="showHide(this.id, 'Q7_9_3_off')" name="Q7_9_3" class="form-control" id="Q7_9_3">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Chest_Pain_Where as $VA_Chest_Pain_Where_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q7_9_3 == $VA_Chest_Pain_Where_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Chest_Pain_Where_single->code == 4)
                                                    echo " id='Q7_9_3_root'";
                                                else
                                                    echo " id='Q7_9_3_" . $i . "'";
                                                ?> value="<?php echo $VA_Chest_Pain_Where_single->id; ?>"><?php echo $VA_Chest_Pain_Where_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q7_9_3_OTHER; ?>" <?php if (strlen($userInfo->Q7_9_3_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q7_9_3_off" type="text" name="Q7_9_3_OTHER" class="form-control">
                                    </div>
                                </div> 
                                <div <?php if ($userInfo->Q7_9_1 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q7_9_1_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.9.4) বুকের ব্যথা অবিরাম হতো না ছেড়ে ছেড়ে হতো?
                                        </label>
                                        <select id="Q7_9_4" class="form-control" name="Q7_9_4">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Chest_Pain_Continuous as $VA_Chest_Pain_Continuous_single) { ?>
                                                <option <?php if ($userInfo->Q7_9_4 == $VA_Chest_Pain_Continuous_single->id) echo ' selected'; ?> value="<?php echo $VA_Chest_Pain_Continuous_single->id; ?>"><?php echo $VA_Chest_Pain_Continuous_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.9.5) ব্যথা কি হঠাৎ করে, না কি ধীরে ধীরে শুরু হয়েছিল?
                                        </label>
                                        <select id="Q7_9_5" class="form-control" name="Q7_9_5">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Chest_Pain_Suddenly as $VA_Chest_Pain_Suddenly_single) { ?>
                                                <option <?php if ($userInfo->Q7_9_5 == $VA_Chest_Pain_Suddenly_single->id) echo ' selected'; ?> value="<?php echo $VA_Chest_Pain_Suddenly_single->id; ?>"><?php echo $VA_Chest_Pain_Suddenly_single->name; ?></option>
                                            <?php } ?>
                                        </select>


                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.9.6) তার তীব্র বুক ব্যথা কতক্ষন স্থায়ী ছিল?
                                        </label> 
                                        <select id="Q7_9_6" class="form-control" name="Q7_9_6">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Chest_Pain_Stability as $VA_Chest_Pain_Stability_single) { ?>
                                                <option <?php if ($userInfo->Q7_9_6 == $VA_Chest_Pain_Stability_single->id) echo ' selected'; ?> value="<?php echo $VA_Chest_Pain_Stability_single->id; ?>"><?php echo $VA_Chest_Pain_Stability_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div <?php if ($userInfo->Q7_9_1 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q7_9_1_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.9.7) কাঁশির সময় তার বুক ব্যথা কি বেড়ে যেত?
                                        </label>
                                        <select id="Q7_9_7" name="Q7_9_7" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_9_7 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.9.8) কাজকর্ম করার সময় বুকে এই ব্যথা হতো কি?
                                        </label>
                                        <select id="Q7_9_8" name="Q7_9_8" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_9_8 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.9.9) তার কি বুকে ধুকধুকুনি ছিল বা বুক ধড়ফড় করতো?
                                        </label>
                                        <select id="Q7_9_9" class="form-control" name="Q7_9_9">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Unknown as $VA_Yes_No_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_9_9 == $VA_Yes_No_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    7.10)  ডায়রিয়া (DIARRHOEA)<br><br>
                                </div>  
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.10.1) তার কি ডায়রিয়া/আমাশয় হয়েছিল?
                                        </label>
                                        <select id="Q7_10_1" name="Q7_10_1" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_10_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_10_1 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_10_1_no_reluctant_unknown">
                                        <label>
                                            7.10.2) মৃত্যুর কতদিন আগে থেকে তার ডায়রিয়া ছিল? 
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_10_2_D; ?>" id="Q7_10_2_D" name="Q7_10_2_D" type="text" class="form-control">
                                    </div>
                                    <div <?php if ($userInfo->Q7_10_1 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_10_1_no_reluctant_unknown">
                                        <label>
                                            7.10.3) পায়খানা কি ধরনের ছিল?
                                        </label>
                                        <select id="Q7_10_3" name="Q7_10_3" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Stool_Type as $VA_Stool_Type_single) { ?>
                                                <option <?php if ($userInfo->Q7_10_3 == $VA_Stool_Type_single->id) echo ' selected'; ?> value="<?php echo $VA_Stool_Type_single->id; ?>"><?php echo $VA_Stool_Type_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>  
                                <div class="col-md-12">
                                    <div <?php if ($userInfo->Q7_10_1 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_10_1_no_reluctant_unknown">
                                        <label>
                                            7.10.4) ডায়রিয়া যখন মারাত্বক ছিল, তখন দিনে কতবার পায়খানা হয়েছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_10_4_N; ?>"id="Q7_10_4_N" name="Q7_10_4_N" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.10.5) তার কি পায়খানার সাথে রক্ত যেত?
                                        </label>
                                        <select id="Q7_10_5" name="Q7_10_5" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_10_5 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_10_5 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_10_5_no_reluctant_unknown">
                                        <label>
                                            7.10.6)  পায়খানার সাথে রক্ত যাওয়া কি মৃত্যুর পূর্ব পর্যন্ত ছিল?
                                        </label>
                                        <select id="Q7_10_6" name="Q7_10_6" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_10_6 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>  
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.10.7) তার কি চোখ ডেবে গিয়েছিল?
                                        </label>
                                        <select class="form-control" name="Q7_10_7">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Unknown as $VA_Yes_No_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_10_7 == $VA_Yes_No_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.10.8)  স্বাভাবিকের তুলনায় ইনি কি প্রচুর পানি পান করতেন?
                                        </label>
                                        <select name="Q7_10_8" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_10_8 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.10.9) ডায়রিয়া কি অবিরাম হতো, না থেমে থেমে হতো?
                                        </label>
                                        <select name="Q7_10_9" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Diarrhea_Continuous as $VA_Diarrhea_Continuous_single) { ?>
                                                <option <?php if ($userInfo->Q7_10_9 == $VA_Diarrhea_Continuous_single->id) echo ' selected'; ?> value="<?php echo $VA_Diarrhea_Continuous_single->id; ?>"><?php echo $VA_Diarrhea_Continuous_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>  
                                <div class="col-md-12">
                                    7.11) বমি (VOMITING) <br><br>
                                </div>  
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.11.1) গত এক সপ্তাহের মধ্যে তার কি বমি হয়েছিল? 
                                        </label>
                                        <select id="Q7_11_1" name="Q7_11_1" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_11_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_11_1 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_11_1_no_reluctant_unknown">

                                        <label>
                                            7.11.2) কতদিন যাবৎ তার বমি হয়ে ছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_11_2_D; ?>" id="Q7_11_2_D" name="Q7_11_2_D" type="text" class="form-control">
                                    </div>
                                    <div <?php if ($userInfo->Q7_11_1 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_11_1_no_reluctant_unknown">
                                        <label>
                                            7.11.3) বমি যখন মারাত্বক ছিল, দিনে কয়বার বমি হতো?
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_11_3_N; ?>" id="Q7_11_3_N" name="Q7_11_3_N" type="text" class="form-control">
                                    </div>
                                </div>  
                                <div <?php if ($userInfo->Q7_11_1 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q7_11_1_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.11.4) বমি দেখতে কিরূপ ছিল?
                                        </label>
                                        <select onchange="showHide(this.id, 'Q7_11_4_off')" name="Q7_11_4" class="form-control" id="Q7_11_4">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Vomit_Looks_Like as $VA_Vomit_Looks_Like_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q7_11_4 == $VA_Vomit_Looks_Like_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Vomit_Looks_Like_single->code == 7)
                                                    echo " id='Q7_11_4_root'";
                                                else
                                                    echo " id='Q7_11_4_" . $i . "'";
                                                ?> value="<?php echo $VA_Vomit_Looks_Like_single->id; ?>"><?php echo $VA_Vomit_Looks_Like_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q7_11_4_OTHER; ?>" <?php if (strlen($userInfo->Q7_11_4_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q7_11_4_off" type="text" name="Q7_11_4_OTHER" class="form-control">
                                    </div>

                                </div>  

                                <div class="box-footer col-md-12">
                                    <input type="submit" class="btn btn-primary" value="Update">
                                </div>
                                <div class="col-md-12">
                                    7.12) পেট ব্যথা (ABDOMINAL PAIN)<br><br>
                                </div>  
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.12.1) কি পেট ব্যথা ছিল?
                                        </label>
                                        <select id="Q7_12_1" name="Q7_12_1" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_12_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_12_1 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_12_1_no_reluctant_unknown">
                                        <label>
                                            7.12.2) এটা কি ধরনের ব্যথা ছিল?
                                        </label> 
                                        <select onchange="showHide(this.id, 'Q7_12_2_off')" name="Q7_12_2" class="form-control" id="Q7_12_2">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Abdominal_Pain_Type as $VA_Abdominal_Pain_Type_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q7_12_2 == $VA_Abdominal_Pain_Type_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Abdominal_Pain_Type_single->code == 4)
                                                    echo " id='Q7_12_2_root'";
                                                else
                                                    echo " id='Q7_12_2_" . $i . "'";
                                                ?> value="<?php echo $VA_Abdominal_Pain_Type_single->id; ?>"><?php echo $VA_Abdominal_Pain_Type_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q7_12_2_OTHER; ?>" <?php if (strlen($userInfo->Q7_12_2_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q7_12_2_off" type="text" name="Q7_12_2_OTHER" class="form-control">
                                    </div>
                                    <div <?php if ($userInfo->Q7_12_1 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_12_1_no_reluctant_unknown">
                                        <label>
                                            7.12.3) কত দিন/মাস যাবৎ ব্যথাটি ছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_12_3_M; ?>" id="Q7_12_3_M" name="Q7_12_3_M" style="width:50%;float:left;" placeholder="মাস" type="text" class="form-control">
                                        <input value="<?php echo $userInfo->Q7_12_3_D; ?>" id="Q7_12_3_D" name="Q7_12_3_D" style="width:50%;float:left;" placeholder="দিন" type="text" class="form-control">
                                    </div>
                                </div>  
                                <div <?php if ($userInfo->Q7_12_1 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q7_12_1_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.12.4) ব্যথাটি কোন জায়গায় ছিল?
                                        </label>
                                        <select onchange="showHide(this.id, 'Q7_12_4_off')" name="Q7_12_4" class="form-control" id="Q7_12_4">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Abdominal_Pain_Where as $VA_Abdominal_Pain_Where_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q7_12_4 == $VA_Abdominal_Pain_Where_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Abdominal_Pain_Where_single->code == 5)
                                                    echo " id='Q7_12_4_root'";
                                                else
                                                    echo " id='Q7_12_4_" . $i . "'";
                                                ?> value="<?php echo $VA_Abdominal_Pain_Where_single->id; ?>"><?php echo $VA_Abdominal_Pain_Where_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.12.5) ব্যথাটি কতটুকু মারাত্বক ছিল?
                                        </label>
                                        <select id="Q7_12_5" name="Q7_12_5" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Pain_Dimension as $VA_Pain_Dimension_single) { ?>
                                                <option <?php if ($userInfo->Q7_12_5 == $VA_Pain_Dimension_single->id) echo ' selected'; ?> value="<?php echo $VA_Pain_Dimension_single->id; ?>"><?php echo $VA_Pain_Dimension_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.12.6) মলত্যাগে কোন পরিবর্তন এসেছিল?
                                        </label>
                                        <select id="Q7_12_6" name="Q7_12_6" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_12_6 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>  
                                <div <?php if ($userInfo->Q7_12_1 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q7_12_1_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.12.7) এই অসুখের সময় উনার পায়খানা হতো কি?
                                        </label>
                                        <select id="Q7_12_7" name="Q7_12_7" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_12_7 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_12_7 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_12_7_no_reluctant_unknown">
                                        <label>
                                            7.12.8) তার পায়খানা কিরূপ ছিল?
                                        </label>
                                        <select onchange="showHide(this.id, 'Q7_12_8_off')" name="Q7_12_8" class="form-control" id="Q7_12_8">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Abdominal_Pain_Stool_Look_Like as $VA_Abdominal_Pain_Stool_Look_Like_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q7_12_8 == $VA_Abdominal_Pain_Stool_Look_Like_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Abdominal_Pain_Stool_Look_Like_single->code == 5)
                                                    echo " id='Q7_12_8_root'";
                                                else
                                                    echo " id='Q7_12_8_" . $i . "'";
                                                ?> value="<?php echo $VA_Abdominal_Pain_Stool_Look_Like_single->id; ?>"><?php echo $VA_Abdominal_Pain_Stool_Look_Like_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q7_12_8_OTHER; ?>" <?php if (strlen($userInfo->Q7_12_8_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q7_12_8_off" type="text" name="Q7_12_8_OTHER" class="form-control">
                                    </div>
                                </div>  
                                <div class="col-md-12">
                                    7.13) পেট ফাঁপা/ফোলা  (ABDOMINAL DISTENSION)<br><br>
                                </div>  
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.13.1) মৃত্যুর আগে উনার পেট ফুলে গিয়েছিল কি?
                                        </label>
                                        <select id="Q7_13_1" name="Q7_13_1" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_13_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_13_1 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_13_1_no_reluctant_unknown">
                                        <label style="width:100%;">
                                            7.13.2) কত দিন/মাস যাবৎ এ ফোলা ছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_13_2_M; ?>" id="Q7_13_2_M" name="Q7_13_2_M" style="width:25%;float:left;" placeholder="মাস" type="text" class="form-control">
                                        <input value="<?php echo $userInfo->Q7_13_2_D; ?>" id="Q7_13_2_D" name="Q7_13_2_D" style="width:25%;float:left;" placeholder="দিন" type="text" class="form-control">
                                    </div>
                                    <div <?php if ($userInfo->Q7_13_1 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_13_1_no_reluctant_unknown">
                                        <label>
                                            7.13.3) এই ফোলা কি দ্রুত নাকি ধীরে ধীরে বেড়েছিল?
                                        </label> 
                                        <select id="Q7_13_3" name="Q7_13_3" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_ABDOMINAL_DISTENSION_QUICK as $VA_ABDOMINAL_DISTENSION_QUICK_single) { ?>
                                                <option <?php if ($userInfo->Q7_13_3 == $VA_ABDOMINAL_DISTENSION_QUICK_single->id) echo ' selected'; ?> value="<?php echo $VA_ABDOMINAL_DISTENSION_QUICK_single->id; ?>"><?php echo $VA_ABDOMINAL_DISTENSION_QUICK_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>  
                                <div <?php if ($userInfo->Q7_13_1 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q7_13_1_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.13.4) আপনি কি মনে করেন, পেটে পানি আসার জন্য পেট ফুলে গিয়েছিল?
                                        </label>
                                        <select id="Q7_13_4" class="form-control" name="Q7_13_4">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Unknown as $VA_Yes_No_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_13_4 == $VA_Yes_No_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.13.5) পেঁট ফাঁপা অবস্থায় এক বা একাধিক দিন তার পায়খানা হতো না এই ধরনের সমস্যা হযেছিল কি?
                                        </label>
                                        <select id="Q7_13_5" name="Q7_13_5" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_13_5 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_13_5 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_13_5_no_reluctant_unknown">
                                        <label>
                                            7.13.6) মৃত্যুর আগে কতদিন যাবৎ তার পায়খানা হতো না?
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_13_6_M; ?>" id="Q7_13_6_M" name="Q7_13_6_M" style="width:50%;float:left;" placeholder="মাস" type="text" class="form-control">
                                        <input value="<?php echo $userInfo->Q7_13_6_D; ?>" id="Q7_13_6_D" name="Q7_13_6_D" style="width:50%;float:left;" placeholder="দিন" type="text" class="form-control">
                                    </div>
                                </div>  
                                <div class="col-md-12">
                                    7.14) গলাধঃকরন (SWALLOWING)<br><br>
                                </div>  
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">

                                        <label>
                                            7.14.1) সর্বশেষ অসুখের সময় তার কি শক্ত খাবার গলাধঃকরনে বা গিলতে অসুবিধা হয়েছিল?
                                        </label>
                                        <select id="Q7_14_1" name="Q7_14_1" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_14_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_14_1 != 1576) echo " style='display:none;'"; ?>  class="col-md-4 form-group Q7_14_1_no_reluctant_unknown">
                                        <label>
                                            7.14.2) কত মাস/দিন যাবৎ গলাধঃকরনে বা গিলতে অসুবিধা হয়েছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_14_2_M; ?>" id="Q7_14_2_M" name="Q7_14_2_M" style="width:50%;float:left;" placeholder="মাস" type="text" class="form-control">
                                        <input value="<?php echo $userInfo->Q7_14_2_D; ?>" id="Q7_14_2_D" name="Q7_14_2_D" style="width:50%;float:left;" placeholder="দিন" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.14.3) সর্বশেষ অসুখের সময় তার কি নরম/তরল খাবার গলাধঃকরণে বা গিলতে অসুবিধা হয়েছিল?
                                        </label>
                                        <select id="Q7_14_3" name="Q7_14_3" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_14_3 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>  
                                <div class="col-md-12">
                                    <div <?php if ($userInfo->Q7_14_3 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_14_3_no_reluctant_unknown">
                                        <label>
                                            7.14.4) কত মাস/দিন যাবৎ নরম/তরল খাবার গলাধঃকরণে বা গিলতে অসুবিধা হয়েছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_14_4_M; ?>" id="Q7_14_4_M" name="Q7_14_4_M" style="width:50%;float:left;" placeholder="মাস" type="text" class="form-control">
                                        <input value="<?php echo $userInfo->Q7_14_4_D; ?>" id="Q7_14_4_D" name="Q7_14_4_D" style="width:50%;float:left;" placeholder="দিন" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.14.5) গলাধঃকরণে বা খাবার গিলতে ব্যথা হতো কি?
                                        </label>
                                        <select name="Q7_14_5" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_14_5 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div> 

                                <div class="box-footer col-md-12">
                                    <input type="submit" class="btn btn-primary" value="Update">
                                </div>								

                                <div class="col-md-12">
                                    7.15) পেটে মাংস পিন্ড/শক্ত চাকা  (MASS in Abdomen)<br><br>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.15.1) তার পেটে কি কোন শক্ত চাকা ছিল?
                                        </label>
                                        <select id="Q7_15_1" name="Q7_15_1" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_15_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_15_1 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_15_1_no_reluctant_unknown">
                                        <label>
                                            7.15.2) শক্ত চাকাটি কোথায় ছিল?
                                        </label> 
                                        <select onchange="showHide(this.id, 'Q7_15_2_off')" name="Q7_15_2" class="form-control" id="Q7_15_2">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_MASS_in_Abdomen_Strong_Wheel_Position as $VA_MASS_in_Abdomen_Strong_Wheel_Position_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q7_15_2 == $VA_MASS_in_Abdomen_Strong_Wheel_Position_single->id) echo ' selected'; ?> <?php
                                                if ($VA_MASS_in_Abdomen_Strong_Wheel_Position_single->code == 6)
                                                    echo " id='Q7_15_2_root'";
                                                else
                                                    echo " id='Q7_15_2_" . $i . "'";
                                                ?> value="<?php echo $VA_MASS_in_Abdomen_Strong_Wheel_Position_single->id; ?>"><?php echo $VA_MASS_in_Abdomen_Strong_Wheel_Position_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q7_15_2_OTHER; ?>" <?php if (strlen($userInfo->Q7_15_2_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q7_15_2_off" type="text" name="Q7_15_2_OTHER" class="form-control">
                                    </div>
                                    <div <?php if ($userInfo->Q7_15_1 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_15_1_no_reluctant_unknown">
                                        <label>
                                            7.15.3) শক্ত চাকাটি কি ব্যথা যুক্ত ছিল?
                                        </label>
                                        <select id="Q7_15_3" name="Q7_15_3" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_15_3 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div> 
                                <div <?php if ($userInfo->Q7_15_1 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q7_15_1_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.15.4) কত মাস/দিন যাবৎ চাকাটি ছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_15_4_M; ?>" id="Q7_15_4_M" name="Q7_15_4_M" style="width:50%;float:left;" placeholder="মাস" type="text" class="form-control">
                                        <input value="<?php echo $userInfo->Q7_15_4_D; ?>" id="Q7_15_4_D" name="Q7_15_4_D" style="width:50%;float:left;" placeholder="দিন" type="text" class="form-control">

                                    </div>
                                </div>  
                                <div class="col-md-12">
                                    7.16) মাথা ব্যথা (HEADACHE) <br><br>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.16.1) তার কি মাথা ব্যথা ছিল?
                                        </label>
                                        <select id="Q7_16_1" name="Q7_16_1" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_16_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_16_1 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_16_1_no_reluctant_unknown">
                                        <label>
                                            7.16.2) তার কত মাস/দিন যাবৎ মাথা ব্যথা ছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_16_2_M; ?>" id="Q7_16_2_M" name="Q7_16_2_M" style="width:50%;float:left;" placeholder="মাস" type="text" class="form-control">
                                        <input value="<?php echo $userInfo->Q7_16_2_D; ?>" id="Q7_16_2_D" name="Q7_16_2_D" style="width:50%;float:left;" placeholder="দিন" type="text" class="form-control">
                                    </div>
                                    <div <?php if ($userInfo->Q7_16_1 != 1576) echo " style='display:none;'"; ?>  class="col-md-4 form-group Q7_16_1_no_reluctant_unknown">
                                        <label>
                                            7.16.3) মাথা ব্যথা কতটুকু তীব্র/মারাত্বক ছিল?
                                        </label>
                                        <select id="Q7_16_3" name="Q7_16_3" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Pain_Dimension as $VA_Pain_Dimension_single) { ?>
                                                <option <?php if ($userInfo->Q7_16_3 == $VA_Pain_Dimension_single->id) echo ' selected'; ?> value="<?php echo $VA_Pain_Dimension_single->id; ?>"><?php echo $VA_Pain_Dimension_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>  
                                <div <?php if ($userInfo->Q7_16_1 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q7_16_1_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.16.4) মাথা ব্যথা কি দ্রুত না ধীরে ধীরে শুরু হতো?
                                        </label>
                                        <select id="Q7_16_4" name="Q7_16_4" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Headache_Quick_Or_Slow as $VA_Headache_Quick_Or_Slow_single) { ?>
                                                <option <?php if ($userInfo->Q7_16_4 == $VA_Headache_Quick_Or_Slow_single->id) echo ' selected'; ?> value="<?php echo $VA_Headache_Quick_Or_Slow_single->id; ?>"><?php echo $VA_Headache_Quick_Or_Slow_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>  
                                <div class="col-md-12">
                                    7.17) ঘাড় শক্ত হওয়া বা ঘাড় ব্যথা হওয়া  (STIFF NECK/PAIN IN NECK)<br><br>
                                </div>  
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.17.1) সর্বশেষ অসুখের সময় তার ঘাড় শক্ত বা ঘাড় ব্যথা হয়েছিল কি?
                                        </label>
                                        <select id="Q7_17_1" name="Q7_17_1" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_17_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_17_1 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_17_1_no_reluctant_unknown">
                                        <label>
                                            7.17.2) কত দিন আগে থেকে ঘাড় শক্ত/ব্যথা হয়ে গিয়েছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_17_2_D; ?>" id="Q7_17_2_D" name="Q7_17_2_D" type="text" class="form-control">
                                    </div>
                                    <div <?php if ($userInfo->Q7_17_1 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_17_1_no_reluctant_unknown">
                                        <label>
                                            7.17.3) সারা শরীর কি শক্ত হয়ে গিয়েছিল বা উনার মুখ খুলতে পারতো না?
                                        </label>
                                        <select id="Q7_17_3" name="Q7_17_3" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_17_3 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>  
                                <div <?php
                                if ($userInfo->Q7_17_3 == 1576)
                                    echo " style='display:block;'";
                                else
                                    echo " style='display:none;'";
                                ?> class="col-md-12 Q7_17_3_yes_part">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.17.4) কত মাস/দিন যাবৎ তার সারা শরীর শক্ত হয়ে গিয়েছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_17_4_M; ?>" id="Q7_17_4_M" name="Q7_17_4_M" style="width:50%;float:left;" placeholder="মাস" type="text" class="form-control">
                                        <input value="<?php echo $userInfo->Q7_17_4_D; ?>" id="Q7_17_4_D" name="Q7_17_4_D" style="width:50%;float:left;" placeholder="দিন" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.17.5) সমস্ত শরীর কি ধনুকের মতো বাঁঁকা হয়ে যেত?
                                        </label>
                                        <select id="Q7_17_5" name="Q7_17_5" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_17_5 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.17.6) তার শরীরের কোথায়ও কেটে ছিল/ক্ষত ছিল কি? (গত এক বছরে)
                                        </label>
                                        <select id="Q7_17_6" name="Q7_17_6" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_17_6 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>  

                                <div class="col-md-12">
                                    7.18) খিঁচুনী (CONVULSION)<br><br>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.18.1) সর্বশেষ অসুখের সময় তার খিঁচুনী হয়েছিল কি?
                                        </label>
                                        <select id="Q7_18_1" name="Q7_18_1" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_18_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_18_1 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_18_1_no_reluctant_unknown">
                                        <label>
                                            7.18.2) কত দিন/ঘন্টা যাবৎ তার খিঁচুনী ছিল? 
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_18_2_D; ?>" id="Q7_18_2_D" name="Q7_18_2_D" style="width:50%;float:left;" placeholder="দিন" type="text" class="form-control">
                                        <input value="<?php echo $userInfo->Q7_18_2_H; ?>" id="Q7_18_2_H" name="Q7_18_2_H" style="width:50%;float:left;" placeholder="ঘন্টা" type="text" class="form-control">
                                    </div>
                                    <div <?php if ($userInfo->Q7_18_1 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_18_1_no_reluctant_unknown">
                                        <label>
                                            7.18.3) এই ধরনের খিঁচুনী কি আগেও হয়েছিল?
                                        </label>
                                        <select id="Q7_18_3" name="Q7_18_3" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_18_3 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>  
                                <div <?php if ($userInfo->Q7_18_1 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q7_18_1_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.18.4)খিঁচুনীর পর পর সে কি অজ্ঞান হয়ে গিয়েছিল?
                                        </label>
                                        <select id="Q7_18_4" name="Q7_18_4" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_18_4 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                </div>  
                                <div class="col-md-12">
                                    7.19) হতভম্ব/মুর্ছা/অজ্ঞান (Mental Confusion/FITS/UNCONSCIOUSNESS)<br><br>
                                </div>  
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.19.0) হতভম্ব / ভাবলেশহীন অবস্থায় ছিল?
                                        </label>
                                        <select id="Q7_19_0" name="Q7_19_0" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_19_0 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_19_0 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_19_0_no_reluctant_unknown">
                                        <label>
                                            7.19.1) কত মাস / দিন যাবত হতভম্ব / ভাবলেশহীন অবস্থায় ছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_19_1_M; ?>" id="Q7_19_1_M" name="Q7_19_1_M" style="width:50%;float:left;" placeholder="দিন" type="text" class="form-control">
                                        <input value="<?php echo $userInfo->Q7_19_1_D; ?>" id="Q7_19_1_D" name="Q7_19_1_D" style="width:50%;float:left;" placeholder="ঘন্টা" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.19.2) সর্বশেষ অসুখের সময় কি মুর্ছা/অজ্ঞান হয়ে গিয়েছিলেন?
                                        </label>
                                        <select id="Q7_19_2" name="Q7_19_2" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_19_2 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>  
                                <div <?php if ($userInfo->Q7_19_2 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q7_19_2_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.19.3) কত মাস/দিন/ঘন্টা যাবৎ এই অবস্থায় ছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_19_3_M; ?>" id="Q7_19_3_M" name="Q7_19_3_M" style="width:33.33%;float:left;" placeholder="মাস" type="text" class="form-control">
                                        <input value="<?php echo $userInfo->Q7_19_3_D; ?>" id="Q7_19_3_D" name="Q7_19_3_D" style="width:33.33%;float:left;" placeholder="দিন" type="text" class="form-control">
                                        <input value="<?php echo $userInfo->Q7_19_3_H; ?>" id="Q7_19_3_H" name="Q7_19_3_H" style="width:33.33%;float:left;" placeholder="ঘন্টা" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.19.4) কিভাবে ইহা শুরু হয়েছিল?
                                        </label>
                                        <select id="Q7_19_4" name="Q7_19_4" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Suddenly_Slowly_Unknown as $VA_Suddenly_Slowly_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_19_4 == $VA_Suddenly_Slowly_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Suddenly_Slowly_Unknown_single->id; ?>"><?php echo $VA_Suddenly_Slowly_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.19.5) যখন বেশী ঘন ঘন অজ্ঞান হতেন/মুর্ছা যেতেন, দিনে কতবার?
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_19_5_N; ?>" id="Q7_19_5_N" name="Q7_19_5_N" type="text" class="form-control">
                                    </div>
                                </div>  
                                <div class="col-md-12">
                                    <div <?php if ($userInfo->Q7_19_2 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_19_2_no_reluctant_unknown">
                                        <label>
                                            7.19.6) যদি অজ্ঞান হয়ে থাকে, সেই অবস্থা কি মৃত্যু পর্যন্ত ছিল?
                                        </label>
                                        <select id="Q7_19_6" name="Q7_19_6" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_19_6 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_19_2 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_19_2_no_reluctant_unknown">
                                        <label>
                                            7.19.7) মুর্ছার মাঝে সে কি অবস্থায় ছিল?
                                        </label> 
                                        <select id="Q7_19_7" name="Q7_19_7" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Status_Before_Swoon as $VA_Status_Before_Swoon_single) { ?>
                                                <option <?php if ($userInfo->Q7_19_7 == $VA_Status_Before_Swoon_single->id) echo ' selected'; ?> value="<?php echo $VA_Status_Before_Swoon_single->id; ?>"><?php echo $VA_Status_Before_Swoon_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.19.8) মৃত্যুর আগের ৩ মাসের মধ্যে কি সে স্মৃতিশক্তি হারিয়ে ফেলেছিল?
                                        </label>
                                        <select name="Q7_19_8" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_19_8 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>  
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.19.9) মুখ খুলতে কি অসুবিধা হতো?
                                        </label>
                                        <select id="Q7_19_9" name="Q7_19_9" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_19_9 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_19_9 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_19_9_no_reluctant_unknown">
                                        <label>
                                            7.19.10) এ অসুবিধা কতদিন আগ থেকে ছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_19_10_D; ?>" id="Q7_19_10_D" name="Q7_19_10_D" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.19.11) মৃত্যুর আগে তার মাথা এলোমেলো হয়ে গিয়েছিল? (বা অসংলগ্ন আচরন করত)
                                        </label>
                                        <select id="Q7_19_11" name="Q7_19_11" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_19_11 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>  
                                <div <?php if ($userInfo->Q7_19_11 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q7_19_11_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.19.12) তার মাথা কত মাস/দিন যাবৎ এলোমেলো ছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_19_12_M; ?>" id="Q7_19_12_M" name="Q7_19_12_M" style="width:50%;float:left;" placeholder="মাস" type="text" class="form-control">
                                        <input value="<?php echo $userInfo->Q7_19_12_D; ?>" id="Q7_19_12_D" name="Q7_19_12_D" style="width:50%;float:left;" placeholder="দিন" type="text" class="form-control">
                                    </div>
                                </div>  
                                <div class="box-footer col-md-12" style="margin-top:40px">
                                    <input type="submit" class="btn btn-primary" value="Update">
                                </div>
                                <div class="col-md-12">
                                    7.20) পক্ষাঘাত বা অবশ (PARALYSIS)<br><br>
                                </div>  
                                <div class="col-md-12">
                                    <div class="col-md-3 form-group">
                                        <label>
                                            7.20.1) মৃত্যুর আগে তার কি দেহের কোন অঙ্গ/পাশ অবশ হয়ে গিয়েছিল?
                                        </label>
                                        <select id="Q7_20_1" name="Q7_20_1" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_20_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_20_1 != 1576) echo " style='display:none;'"; ?> class="col-md-3 form-group Q7_20_1_no_reluctant_unknown">
                                        <label>
                                            7.20.2) দেহের কোন অঙ্গ/পাশ অবশ হয়েছিল?
                                        </label>
                                        <select onchange="showHide(this.id, 'Q7_20_2_off')" name="Q7_20_2" class="form-control" id="Q7_20_2">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Paralyzed_Body_Part as $VA_Paralyzed_Body_Part_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q7_20_2 == $VA_Paralyzed_Body_Part_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Paralyzed_Body_Part_single->code == 8)
                                                    echo " id='Q7_20_2_root'";
                                                else
                                                    echo " id='Q7_20_2_" . $i . "'";
                                                ?> value="<?php echo $VA_Paralyzed_Body_Part_single->id; ?>"><?php echo $VA_Paralyzed_Body_Part_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q7_20_2_OTHER; ?>" <?php if (strlen($userInfo->Q7_20_2_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q7_20_2_off" type="text" name="Q7_20_2_OTHER" class="form-control">
                                    </div>
                                    <div <?php if ($userInfo->Q7_20_1 != 1576) echo " style='display:none;'"; ?> class="col-md-3 form-group Q7_20_1_no_reluctant_unknown">
                                        <label>
                                            7.20.3) কত দিন/মাস যাবৎ অবশ ছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_20_3_M; ?>" id="Q7_20_3_M" name="Q7_20_3_M" style="width:50%;float:left;" placeholder="মাস" type="text" class="form-control">
                                        <input value="<?php echo $userInfo->Q7_20_3_D; ?>" id="Q7_20_3_D" name="Q7_20_3_D" style="width:50%;float:left;" placeholder="দিন" type="text" class="form-control">
                                    </div>
                                    <div <?php if ($userInfo->Q7_20_1 != 1576) echo " style='display:none;'"; ?> class="col-md-3 form-group Q7_20_1_no_reluctant_unknown">
                                        <label>
                                            7.20.4) তার অঙ্গ/পাশ অবশ শুরু হয়েছিল কি হঠাৎ করে, একদিনের মধ্যে না ধীরে ধীরে?
                                        </label>
                                        <select id="Q7_20_4" name="Q7_20_4" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Paralyzed_When as $VA_Paralyzed_When_single) { ?>
                                                <option <?php if ($userInfo->Q7_20_4 == $VA_Paralyzed_When_single->id) echo ' selected'; ?> value="<?php echo $VA_Paralyzed_When_single->id; ?>"><?php echo $VA_Paralyzed_When_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>  



                                <div class="col-md-12">
                                    7.21) মুত্রের রং (URINE COLOUR)<br><br>
                                </div>  
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.21.1) মৃত্যুর আগে মুত্রের রং এ কি কোন পরিবর্তন হয়েছিল? 
                                        </label>
                                        <select id="Q7_21_1" name="Q7_21_1" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_21_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_21_1 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_21_1_no_reluctant_unknown">
                                        <label>
                                            7.21.2) মুত্রের রং কিরূপ ছিল? 
                                        </label>
                                        <select id="Q7_21_2" name="Q7_21_2" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Urine_Color as $VA_Urine_Color_single) { ?>
                                                <option <?php if ($userInfo->Q7_21_2 == $VA_Urine_Color_single->id) echo ' selected'; ?> value="<?php echo $VA_Urine_Color_single->id; ?>"><?php echo $VA_Urine_Color_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_21_1 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_21_1_no_reluctant_unknown">
                                        <label>
                                            7.21.3) কত দিন যাবৎ মুত্রের রং পরিবর্তিত ছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_21_3_D; ?>" id="Q7_21_3_D" name="Q7_21_3_D" type="text" class="form-control">
                                    </div>
                                </div>  
                                <div class="col-md-12">
                                    7.22) মুত্রের পরিমান (URINE AMOUNT)<br><br>
                                </div>  
                                <div class="col-md-12">
                                    <div class="col-md-3 form-group">
                                        <label>
                                            7.22.1) দৈনিক ত্যাগকৃৃত মুত্রের পরিমানে কোন পরিবর্তন হয়েছিল কি?
                                        </label>
                                        <select id="Q7_22_1" name="Q7_22_1" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_22_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_22_1 != 1576) echo " style='display:none;'"; ?> class="col-md-3 form-group Q7_22_1_no_reluctant_unknown">
                                        <label>
                                            7.22.2) তিনি দৈনিক কি পরিমান মুত্র ত্যাগ করতেন?
                                        </label>
                                        <select id="Q7_22_2" name="Q7_22_2" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Urine_Dimension as $VA_Urine_Dimension_single) { ?>
                                                <option <?php if ($userInfo->Q7_22_2 == $VA_Urine_Dimension_single->id) echo ' selected'; ?> value="<?php echo $VA_Urine_Dimension_single->id; ?>"><?php echo $VA_Urine_Dimension_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_22_1 != 1576) echo " style='display:none;'"; ?> class="col-md-3 form-group Q7_22_1_no_reluctant_unknown">
                                        <label>
                                            7.22.3) মূত্রের পরিমানে এই পরিবর্তনটি মাস/দিন যাবৎ ছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_22_3_M; ?>" id="Q7_22_3_M" name="Q7_22_3_M" style="width:50%;float:left;" placeholder="মাস" type="text" class="form-control">
                                        <input value="<?php echo $userInfo->Q7_22_3_D; ?>" id="Q7_22_3_D" name="Q7_22_3_D" style="width:50%;float:left;" placeholder="দিন" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>
                                            7.22.4) মুত্র ত্যাগে তার কি কোন অসুবিধা ছিল?
                                        </label>
                                        <select id="Q7_22_4" name="Q7_22_4" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_22_4 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>  
                                <div <?php if ($userInfo->Q7_22_4 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q7_22_4_no_reluctant_unknown">
                                    7.22.5) কি ধরনের অসুবিধা হয়েছিল? (একাধিক উত্তর হতে পারে)<br><br>
                                </div>  
                                <div <?php if ($userInfo->Q7_22_4 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q7_22_4_no_reluctant_unknown">
                                    <div class="col-md-3 form-group">
                                        <label>মুত্র ত্যাগে অসমর্থ</label>

                                        <select id="Q7_22_5_A" class="form-control" name="Q7_22_5_A">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Unknown as $VA_Yes_No_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_22_5_A == $VA_Yes_No_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>অনবরত ফোটায় ফোটায় মুত্র ঝরা</label>

                                        <select id="Q7_22_5_B" class="form-control" name="Q7_22_5_B">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Unknown as $VA_Yes_No_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_22_5_B == $VA_Yes_No_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>জ্বালাপোড়া ভাব</label>

                                        <select id="Q7_22_5_C" class="form-control" name="Q7_22_5_C">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Unknown as $VA_Yes_No_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_22_5_C == $VA_Yes_No_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>অন্যান্য (উল্লেখ করুন)</label>
                                        <select onchange="showHide(this.id, 'Q7_22_5_D_off')" name="Q7_22_5_D" class="form-control" id="Q7_22_5_D">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Yes_No_Unknown as $VA_Yes_No_Unknown_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q7_22_5_D == $VA_Yes_No_Unknown_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Yes_No_Unknown_single->code == 1)
                                                    echo " id='Q7_22_5_D_root'";
                                                else
                                                    echo " id='Q7_22_5_D_" . $i . "'";
                                                ?> value="<?php echo $VA_Yes_No_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Unknown_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q7_22_5_D_OTHER; ?>" <?php if (strlen($userInfo->Q7_22_5_D_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q7_22_5_D_off" type="text" name="Q7_22_5_D_OTHER" class="form-control">
                                    </div>
                                </div>  
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.22.6) সর্বশেষ অসুখের সময় প্রস্রাবের সাথে কখনো রক্ত পড়েছিল কি?
                                        </label>

                                        <select name="Q7_22_6" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_22_6 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="box-footer col-md-12">
                                    <input type="submit" class="btn btn-primary" value="Update">
                                </div>

                                <div class="col-md-12">
                                    7.23) অস্ত্রোপচার (SURGERY/OPERATION) 
                                </div> 
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            7.23.1) মৃত্যু কালীন অসুস্থতার সময় তার কি কোন অস্ত্রোপচার হয়েছিল? 
                                        </label>
                                        <select id="Q7_23_1" name="Q7_23_1" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q7_23_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q7_23_1 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_23_1_no_reluctant_unknown">
                                        <label>
                                            7.23.2) মৃত্যুর কত মাস/দিন আগে তাহার অস্ত্রোপচার হয়েছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_23_2_M; ?>" id="Q7_23_2_M" name="Q7_23_2_M" style="width:50%;float:left;" placeholder="মাস" type="text" class="form-control">
                                        <input value="<?php echo $userInfo->Q7_23_2_D; ?>" id="Q7_23_2_D" name="Q7_23_2_D" style="width:50%;float:left;" placeholder="দিন" type="text" class="form-control">
                                    </div>
                                    <div <?php if ($userInfo->Q7_23_1 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q7_23_1_no_reluctant_unknown">
                                        <label>
                                            7.23.3) অস্ত্রোপচার শরীরের কোথায় হয়েছিল?
                                        </label>
                                        <input value="<?php echo $userInfo->Q7_23_3_NAME; ?>" id="Q7_23_3_NAME" name="Q7_23_3_NAME" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    VIII) LIFE STYLE & RISK BEHAVIOUR<br><br>
                                </div> 
                                <div class="col-md-12">
                                    ধুমপান/পান খাওয়া সংক্রান্ত তথ্য (Smoking /Betel-Leaf Chewing):<br><br>
                                    8.1.1) মৃত ব্যক্তির কি পান, তামাক, সিগারেট, বিড়ি বা হুক্কা খাওয়ার/টানার অভ্যাস ছিল?<br><br>
                                </div> 
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>১.পান খাওয়া (তামাক/জর্দা ছাড়া)</label>

                                        <select name="Q8_1_1_1" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q8_1_1_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>২.পান খাওয়া (তামাক/জর্দা সহ) </label>

                                        <select name="Q8_1_1_2" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q8_1_1_2 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            ৩.ধূমপান (বিড়ি/সিগারেট)</label>

                                        <select name="Q8_1_1_3" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q8_1_1_3 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div> 
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>৪.হুক্কা টানা (Pipe) </label>

                                        <select name="Q8_1_1_4" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q8_1_1_4 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>৫.খালি সুপারী</label> 

                                        <select name="Q8_1_1_5" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q8_1_1_5 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select> 
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>৬.গুল (Tobacco powder)</label> 

                                        <select name="Q8_1_1_6" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q8_1_1_6 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div> 
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>৭. খৈনী (rolled tobacco)</label>

                                        <select name="Q8_1_1_7" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q8_1_1_7 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div> 
                                <div class="box-footer col-md-12">
                                    <input type="submit" class="btn btn-primary" value="Update">
                                </div>
                                <div class="col-md-12">
                                    <h4 style="color:red;font-size:14px;">Note:  If s/he had no such habit, skip to Q.8.2</h4> <br>
                                    8.1.2) তিনি আনুমানিক দিনে কয়বার/কয়টি করে খেতেন/টানতেন? (Code: 99 = অজানা)
                                    <br><br>
                                </div> 
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>১.পান খাওয়া (তামাক/জর্দা ছাড়া)</label>
                                        <input value="<?php echo $userInfo->Q8_1_2_1_N; ?>" name="Q8_1_2_1_N" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>২.পান খাওয়া (তামাক/জর্দা সহ) </label>
                                        <input value="<?php echo $userInfo->Q8_1_2_2_N; ?>" name="Q8_1_2_2_N" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>৩.ধূমপান (বিড়ি/সিগারেট)</label>
                                        <input value="<?php echo $userInfo->Q8_1_2_3_N; ?>" name="Q8_1_2_3_N" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>৪.হুক্কা টানা (Pipe)</label>

                                        <input value="<?php echo $userInfo->Q8_1_2_4_N; ?>" name="Q8_1_2_4_N" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>৫.খালি সুপারী</label>

                                        <input value="<?php echo $userInfo->Q8_1_2_5_N; ?>" name="Q8_1_2_5_N" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>৬.গুল (Tobacco powder)</label>

                                        <input value="<?php echo $userInfo->Q8_1_2_6_N; ?>" name="Q8_1_2_6_N" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>৭. খৈনী (rolled tobacco)</label>
                                        <input value="<?php echo $userInfo->Q8_1_2_7_N; ?>" name="Q8_1_2_7_N" type="text" class="form-control">
                                    </div>
                                </div> 
                                <div class="col-md-12">
                                    8.1.3) মৃত্যুর কত দিন আগে তিনি সম্পুর্নভাবে এইসব খাওয়া/টানা ছেড়ে দিয়েছিলেন? <br><br>
                                </div> 
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>১.পান খাওয়া (তামাক/জর্দা ছাড়া)</label>

                                        <input value="<?php echo $userInfo->Q8_1_3_1_Y; ?>" name="Q8_1_3_1_Y" placeholder="বছর" type="text" class="form-control">
                                        <br/>
                                        <input value="<?php echo $userInfo->Q8_1_3_1_M; ?>" name="Q8_1_3_1_M" placeholder="মাস" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>২.পান খাওয়া (তামাক/জর্দা সহ)</label>

                                        <input value="<?php echo $userInfo->Q8_1_3_2_Y; ?>" name="Q8_1_3_2_Y" placeholder="বছর" type="text" class="form-control">
                                        <br/>
                                        <input value="<?php echo $userInfo->Q8_1_3_2_M; ?>" name="Q8_1_3_2_M" placeholder="মাস" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>৩.ধূমপান (বিড়ি/সিগারেট)</label>

                                        <input value="<?php echo $userInfo->Q8_1_3_3_Y; ?>" name="Q8_1_3_3_Y" placeholder="বছর" type="text" class="form-control">
                                        <br/>
                                        <input value="<?php echo $userInfo->Q8_1_3_3_M; ?>" name="Q8_1_3_3_M" placeholder="মাস" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>৪.হুক্কা টানা (Pipe)</label>
                                        <input value="<?php echo $userInfo->Q8_1_3_4_Y; ?>" name="Q8_1_3_4_Y" placeholder="বছর" type="text" class="form-control">
                                        <br/>
                                        <input value="<?php echo $userInfo->Q8_1_3_4_M; ?>"  name="Q8_1_3_4_M" placeholder="মাস" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>৫.খালি সুপারী</label> 

                                        <input value="<?php echo $userInfo->Q8_1_3_5_Y; ?>" name="Q8_1_3_5_Y"  placeholder="বছর" type="text" class="form-control">
                                        <br/>
                                        <input value="<?php echo $userInfo->Q8_1_3_5_M; ?>" name="Q8_1_3_5_M"  placeholder="মাস" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>৬.গুল (Tobacco powder)</label>

                                        <input value="<?php echo $userInfo->Q8_1_3_6_Y; ?>" name="Q8_1_3_6_Y"  placeholder="বছর" type="text" class="form-control">
                                        <br/>
                                        <input value="<?php echo $userInfo->Q8_1_3_6_M; ?>" name="Q8_1_3_6_M"  placeholder="মাস" type="text" class="form-control">
                                    </div>
                                </div> 
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>৭. খৈনী (rolled tobacco)</label>

                                        <input value="<?php echo $userInfo->Q8_1_3_7_Y; ?>" name="Q8_1_3_7_Y"  placeholder="বছর" type="text" class="form-control">
                                        <br/>
                                        <input value="<?php echo $userInfo->Q8_1_3_7_M; ?>" name="Q8_1_3_7_M"  placeholder="মাস" type="text" class="form-control">
                                    </div>
                                </div> 
                                <div class="col-md-12">
                                    8.1.4) তিনি আনুমানিক কত বছর ধরে নিয়মিত ভাবে পান খেতেন ধুমপান করতেন?<br><br>
                                </div> 
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>১.পান খাওয়া (তামাক/জর্দা ছাড়া)</label>

                                        <input value="<?php echo $userInfo->Q8_1_4_1_Y; ?>" name="Q8_1_4_1_Y" placeholder="বছর" type="text" class="form-control">
                                        <br/>
                                        <input value="<?php echo $userInfo->Q8_1_4_1_M; ?>" name="Q8_1_4_1_M" placeholder="মাস" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>২.পান খাওয়া (তামাক/জর্দা সহ)</label>

                                        <input value="<?php echo $userInfo->Q8_1_4_2_Y; ?>" name="Q8_1_4_2_Y" placeholder="বছর" type="text" class="form-control">
                                        <br/>
                                        <input value="<?php echo $userInfo->Q8_1_4_2_M; ?>" name="Q8_1_4_2_M" placeholder="মাস" type="text" class="form-control">
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label>৩.ধূমপান (বিড়ি/সিগারেট)</label>

                                        <input value="<?php echo $userInfo->Q8_1_4_3_Y; ?>" name="Q8_1_4_3_Y" placeholder="বছর" type="text" class="form-control">
                                        <br/>
                                        <input value="<?php echo $userInfo->Q8_1_4_3_M; ?>" name="Q8_1_4_3_M" placeholder="মাস" type="text" class="form-control">
                                    </div>

                                </div> 

                                <div class="col-md-12">

                                    <div class="col-md-4 form-group">
                                        <label>৪.হুক্কা টানা (Pipe)</label>

                                        <input value="<?php echo $userInfo->Q8_1_4_4_Y; ?>" name="Q8_1_4_4_Y" placeholder="বছর" type="text" class="form-control">
                                        <br/>
                                        <input value="<?php echo $userInfo->Q8_1_4_4_M; ?>" name="Q8_1_4_4_M" placeholder="মাস" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>৫.খালি সুপারী</label>

                                        <input value="<?php echo $userInfo->Q8_1_4_5_Y; ?>" name="Q8_1_4_5_Y" placeholder="বছর" type="text" class="form-control">
                                        <br/><input value="<?php echo $userInfo->Q8_1_4_5_M; ?>" name="Q8_1_4_5_M" placeholder="মাস" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>৬.গুল (Tobacco powder)</label>

                                        <input value="<?php echo $userInfo->Q8_1_4_6_Y; ?>" name="Q8_1_4_6_Y" placeholder="বছর" type="text" class="form-control">
                                        <br><input value="<?php echo $userInfo->Q8_1_4_6_M; ?>" name="Q8_1_4_6_M" placeholder="মাস" type="text" class="form-control">
                                    </div>
                                </div> 
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>৭. খৈনী (rolled tobacco)</label>

                                        <input value="<?php echo $userInfo->Q8_1_4_7_Y; ?>" name="Q8_1_4_7_Y" placeholder="বছর" type="text" class="form-control">
                                        <br><input value="<?php echo $userInfo->Q8_1_4_7_M; ?>" name="Q8_1_4_7_M" placeholder="মাস" type="text" class="form-control">
                                    </div>

                                </div> 

                                <div class="box-footer col-md-12">
                                    <input type="submit" class="btn btn-primary" value="Update">
                                </div>
                                <div class="col-md-12">
                                    8.2) ঔষধ/মাদক অপব্যাবহার সংক্রান্ত (DRUG/ALCOHOL ABUSE)<br><br>

                                    বিশেষ নির্দেশিকা: এই সেকশনের প্রশ্নগুলো স্পর্শকাতর বিধায় এগুলো ধারাবাহিক ভাবে আপনার মনের মধ্যে গেঁথে রাখুন 
                                    এবং প্রশ্নগুলো সরাসরি জিজ্ঞেস না করে গল্পের আকারে সহজ ভাষায়, কৌশলে এবং সুন্দর ভাবে জিজ্ঞেস করুন। যেমন: 
                                    দুরের গ্রামের একজন লোকের কথা আমি শুনেছি যিনি বন্ধুদের পাল­ায় পড়ে যুবক বয়স থেকেই মাদক গ্রহণ শুরু করেন। 
                                    ক্রমেই তার আসক্তি বৃদ্ধি পায় ও লোকটি কঠিন অসুখে পড়েন। অনেক চিকিৎসাতেও তার অবস্থার কোন উন্নতি হয় নাই 
                                    ও একসময় লোকটি মারা যায়।<br><br>

                                    8.2.1) মৃত ব্যক্তি কি কখনও কোন নেশা জাতীয় ঔষধ/মাদক গ্রহন করতেন? যদি করে থাকেন, কি ধরনের নেশা জাতীয় জিনিস গ্রহন করতেন। (একাধিক উত্তর হতে পারে)<br><br>
                                </div>
                                <div class="col-md-12">
                                    <p style="color:red;font-size:14px;">(8.2.1 প্রশ্নের উত্তর না/অজানা হলে 9.0 এ যান)</p>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>বাংলা মদ (সুরা/তাড়ি)</label>

                                        <select name="Q8_2_1_A" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q8_2_1_A == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>এলকোহল (Brand alcohol)</label>

                                        <select name="Q8_2_1_B" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q8_2_1_B == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>স্পিরিট</label>

                                        <select name="Q8_2_1_C" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q8_2_1_C == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>বিয়ার  (Beer)</label>

                                        <select name="Q8_2_1_D" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q8_2_1_D == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select> 
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>ফেনসিডিল</label>

                                        <select name="Q8_2_1_E" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q8_2_1_E == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select> 
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>প্যাথেডিন/মরফিন</label>
                                        <select name="Q8_2_1_F" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q8_2_1_F == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select> 
                                    </div>
                                </div>      
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>ঘুমের ট্যাবলেট</label>
                                        <select name="Q8_2_1_G" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q8_2_1_G == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>মারিজুয়ানা/গাঁজা/আফিম</label>
                                        <select name="Q8_2_1_H" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q8_2_1_H == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select> 
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>হিরোইন</label>
                                        <select name="Q8_2_1_I" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q8_2_1_I == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>      
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>অন্যান্য (উলে­খ করুন)</label>

                                        <select onchange="showHide(this.id, 'Q8_2_1_J_off')" name="Q8_2_1_J" class="form-control" id="Q8_2_1_J">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q8_2_1_J == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Yes_No_Reluctant_Unknown_single->code == 1)
                                                    echo " id='Q8_2_1_J_root'";
                                                else
                                                    echo " id='Q8_2_1_J_" . $i . "'";
                                                ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q8_2_1_J_OTHER; ?>" <?php if (strlen($userInfo->Q8_2_1_J_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q8_2_1_J_off" type="text" name="Q8_2_1_J_OTHER" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            8.2.2) তাহলে তিনি কত বছর যাবৎ মাদক ব্যবহার করেছিলেন?
                                        </label>
                                        <input value="<?php echo $userInfo->Q8_2_2_Y; ?>" name="Q8_2_2_Y" type="text" placeholder="বছর" class="form-control">
                                        <br><input value="<?php echo $userInfo->Q8_2_2_M; ?>" name="Q8_2_2_M" type="text" placeholder="মাস" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            8.2.3)  তিনি কোথা থেকে মাদক সংগ্রহ করতেন? 
                                        </label> 
                                        <select onchange="showHide(this.id, 'Q8_2_3_off')" name="Q8_2_3" class="form-control" id="Q8_2_3">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Drug_Collection_Place as $VA_Drug_Collection_Place_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q8_2_3 == $VA_Drug_Collection_Place_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Drug_Collection_Place_single->code == 5)
                                                    echo " id='Q8_2_3_root'";
                                                else
                                                    echo " id='Q8_2_3_" . $i . "'";
                                                ?> value="<?php echo $VA_Drug_Collection_Place_single->id; ?>"><?php echo $VA_Drug_Collection_Place_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q8_2_3_OTHER; ?>" <?php if (strlen($userInfo->Q8_2_3_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q8_2_3_off" type="text" name="Q8_2_3_OTHER" class="form-control">
                                    </div>
                                </div>
                                <div class="box-footer col-md-12">
                                    <input type="submit" class="btn btn-primary" value="Update">
                                </div>
                                <div class="col-md-12">
                                    IX) MEDICAL CONSULTATIONS <br><br>
                                    9.0) মৃত্যুর আগে উনি কি কি টীকা নিয়েছিলেন?
                                    <br><br>
                                </div>      
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            TT
                                        </label>
                                        <select onchange="showHide(this.id, 'Q9_0_A_off')" name="Q9_0_A" class="form-control" id="Q9_0_A">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q9_0_A == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Yes_No_Reluctant_Unknown_single->code == 1)
                                                    echo " id='Q9_0_A_root'";
                                                else
                                                    echo " id='Q9_0_A_" . $i . "'";
                                                ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q9_0_A_D; ?>" <?php if (strlen($userInfo->Q9_0_A_D) > 0 == false) echo " style='display:none;'"; ?> placeholder="মাত্রা" id="Q9_0_A_off" type="text" name="Q9_0_A_D" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            Hepatitis B
                                        </label>
                                        <select onchange="showHide(this.id, 'Q9_0_B_off')" name="Q9_0_B" class="form-control" id="Q9_0_B">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q9_0_B == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Yes_No_Reluctant_Unknown_single->code == 1)
                                                    echo " id='Q9_0_B_root'";
                                                else
                                                    echo " id='Q9_0_B_" . $i . "'";
                                                ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q9_0_B_D; ?>" <?php if (strlen($userInfo->Q9_0_B_D) > 0 == false) echo " style='display:none;'"; ?> placeholder="মাত্রা" id="Q9_0_B_off" type="text" name="Q9_0_B_D" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            Typhoid
                                        </label>

                                        <select onchange="showHide(this.id, 'Q9_0_C_off')" name="Q9_0_C" class="form-control" id="Q9_0_C">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q9_0_C == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Yes_No_Reluctant_Unknown_single->code == 1)
                                                    echo " id='Q9_0_C_root'";
                                                else
                                                    echo " id='Q9_0_C_" . $i . "'";
                                                ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q9_0_C_D; ?>" <?php if (strlen($userInfo->Q9_0_C_D) > 0 == false) echo " style='display:none;'"; ?> placeholder="মাত্রা" id="Q9_0_C_off" type="text" name="Q9_0_C_D" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            HPV
                                        </label>
                                        <select onchange="showHide(this.id, 'Q9_0_D_off')" name="Q9_0_D" class="form-control" id="Q9_0_D">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q9_0_D == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Yes_No_Reluctant_Unknown_single->code == 1)
                                                    echo " id='Q9_0_D_root'";
                                                else
                                                    echo " id='Q9_0_D_" . $i . "'";
                                                ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q9_0_D_D; ?>" <?php if (strlen($userInfo->Q9_0_D_D) > 0 == false) echo " style='display:none;'"; ?> placeholder="মাত্রা" id="Q9_0_D_off" type="text" name="Q9_0_D_D" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            MMR/MR
                                        </label>
                                        <select onchange="showHide(this.id, 'Q9_0_E_off')" name="Q9_0_E" class="form-control" id="Q9_0_E">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q9_0_E == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Yes_No_Reluctant_Unknown_single->code == 1)
                                                    echo " id='Q9_0_E_root'";
                                                else
                                                    echo " id='Q9_0_E_" . $i . "'";
                                                ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q9_0_E_D; ?>" <?php if (strlen($userInfo->Q9_0_E_D) > 0 == false) echo " style='display:none;'"; ?> placeholder="মাত্রা" id="Q9_0_E_off" type="text" name="Q9_0_E_D" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            Others
                                        </label>
                                        <select name="Q9_0_F" class="form-control" id="Q9_0_F">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q9_0_F == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Yes_No_Reluctant_Unknown_single->code == 1)
                                                    echo " id='Q9_0_F_" . $i . "'";
                                                ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <span <?php if ($userInfo->Q9_0_F != 1576) echo " style='display:none;'"; ?> id="Q9_0_F_yes_part">
                                            <br/>
                                            <input value="<?php echo $userInfo->Q9_0_F_OTHER; ?>" placeholder="অন্যান্য (উল্লেখ করুন)" id="Q9_0_F_OTHER" type="text" name="Q9_0_F_OTHER" class="form-control">
                                            <br/>
                                            <input value="<?php echo $userInfo->Q9_0_F_D; ?>" placeholder="মাত্রা" id="Q9_0_F_D" type="text" name="Q9_0_F_D" class="form-control">
                                        </span>
                                    </div>
                                </div>      
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            9.1) যে অসুস্থতার জন্য তিনি মারা গিয়েছিলেন, সে অসুখের কোন চিকিৎসা হয়েছিল কি?
                                        </label>
                                        <select id="Q9_1" name="Q9_1" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q9_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>      
                                <div <?php if ($userInfo->Q9_1 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q9_1_no_reluctant_unknown">
                                    9.1.1) মৃত্যুকালীন অসুস্থতার সময় কে কে  তার চিকিৎসা করেছিলেন?
                                    <br/><br/>নির্দেশাবলী: উত্তরদাতার উত্তর দেওয়া শেষ হওয়ার সাথে সাথে জিজ্ঞাসা করুন: আর কোথাও থেকে চিকিৎসা নিয়েছিল কি?
                                    জিজ্ঞাসা করতে থাকুন, যতক্ষন না পর্যন্ত উত্তরদাতা বলেন যে, আর কোথাও থেকে চিকিৎসা নেয়নি। 
                                </div>      
                                <div <?php if ($userInfo->Q9_1 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q9_1_no_reluctant_unknown">
                                    <div class="col-md-3 form-group">
                                        <label>
                                            a. 1st Provider
                                        </label>
                                        <select onchange="showHide(this.id, 'Q9_1_1_AP_off')" name="Q9_1_1_AP" class="form-control" id="Q9_1_1_AP">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Treatment_Provider as $VA_Treatment_Provider_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q9_1_1_AP == $VA_Treatment_Provider_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Treatment_Provider_single->code == 11)
                                                    echo " id='Q9_1_1_AP_root'";
                                                else
                                                    echo " id='Q9_1_1_AP_" . $i . "'";
                                                ?> value="<?php echo $VA_Treatment_Provider_single->id; ?>"><?php echo $VA_Treatment_Provider_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q9_1_1_AP_OTHER; ?>" <?php if (strlen($userInfo->Q9_1_1_AP_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q9_1_1_AP_off" type="text" name="Q9_1_1_AP_OTHER" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>
                                            b. 2nd Provider
                                        </label>

                                        <select onchange="showHide(this.id, 'Q9_1_1_BP_off')" name="Q9_1_1_BP" class="form-control" id="Q9_1_1_BP">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Treatment_Provider as $VA_Treatment_Provider_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q9_1_1_BP == $VA_Treatment_Provider_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Treatment_Provider_single->code == 11)
                                                    echo " id='Q9_1_1_BP_root'";
                                                else
                                                    echo " id='Q9_1_1_BP_" . $i . "'";
                                                ?> value="<?php echo $VA_Treatment_Provider_single->id; ?>"><?php echo $VA_Treatment_Provider_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q9_1_1_BP_OTHER; ?>" <?php if (strlen($userInfo->Q9_1_1_BP_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q9_1_1_BP_off" type="text" name="Q9_1_1_BP_OTHER" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>
                                            c. 3rd Provider
                                        </label>
                                        <select onchange="showHide(this.id, 'Q9_1_1_CP_off')" name="Q9_1_1_CP" class="form-control" id="Q9_1_1_CP">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Treatment_Provider as $VA_Treatment_Provider_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q9_1_1_CP == $VA_Treatment_Provider_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Treatment_Provider_single->code == 11)
                                                    echo " id='Q9_1_1_CP_root'";
                                                else
                                                    echo " id='Q9_1_1_CP_" . $i . "'";
                                                ?> value="<?php echo $VA_Treatment_Provider_single->id; ?>"><?php echo $VA_Treatment_Provider_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q9_1_1_CP_OTHER; ?>" <?php if (strlen($userInfo->Q9_1_1_CP_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q9_1_1_CP_off" type="text" name="Q9_1_1_CP_OTHER" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>
                                            d. 4th/last Provider
                                        </label>
                                        <select onchange="showHide(this.id, 'Q9_1_1_DP_off')" name="Q9_1_1_DP" class="form-control" id="Q9_1_1_DP">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Treatment_Provider as $VA_Treatment_Provider_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q9_1_1_DP == $VA_Treatment_Provider_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Treatment_Provider_single->code == 11)
                                                    echo " id='Q9_1_1_DP_root'";
                                                else
                                                    echo " id='Q9_1_1_DP_" . $i . "'";
                                                ?> value="<?php echo $VA_Treatment_Provider_single->id; ?>"><?php echo $VA_Treatment_Provider_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q9_1_1_DP_OTHER; ?>" <?php if (strlen($userInfo->Q9_1_1_DP_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q9_1_1_DP_off" type="text" name="Q9_1_1_DP_OTHER" class="form-control">
                                    </div>
                                </div>      
                                <div <?php if ($userInfo->Q9_1 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q9_1_no_reluctant_unknown">
                                    9.1.2) সর্বশেষ অসুখের সময় তিনি কোথায় চিকিৎসা নিয়েছিলেন? (একের অধিক উত্তর হতে পারে)
                                    <br><br>সরকারী প্রতিষ্ঠান সমূহ:  
                                    <br><br>
                                </div>      
                                <div <?php if ($userInfo->Q9_1 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q9_1_no_reluctant_unknown">
                                    <div class="col-md-3 form-group">
                                        <label>সরকারী হাসপাতাল (DH & above)</label>

                                        <select id="Q9_1_2_A" name="Q9_1_2_A" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q9_1_2_A == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select> 
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>MCWC</label>

                                        <select id="Q9_1_2_B" name="Q9_1_2_B" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q9_1_2_B == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select> 
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>উপজেলা স্বাস্থ্য কেন্দ্র</label>

                                        <select id="Q9_1_2_C" name="Q9_1_2_C" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q9_1_2_C == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>HFWC/RD/SC/CC</label>
                                        <select id="Q9_1_2_D" name="Q9_1_2_D" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q9_1_2_D == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>          
                                <div <?php if ($userInfo->Q9_1 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q9_1_no_reluctant_unknown">
                                    এনজিও প্রতিষ্ঠান সমূহ::<br><br>
                                </div>

                                <div <?php if ($userInfo->Q9_1 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q9_1_no_reluctant_unknown">
                                    <div class="col-md-3 form-group">
                                        <label>ICDDR,B হাসপাতাল/চিকিৎসাকেন্দ্র</label>
                                        <select id="Q9_1_2_E" name="Q9_1_2_E" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q9_1_2_E == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>ICDDR,B সাব-সেন্টার</label>
                                        <select id="Q9_1_2_F" name="Q9_1_2_F" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q9_1_2_F == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>এনজিও হাসপাতাল</label>
                                        <select id="Q9_1_2_G" name="Q9_1_2_G" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q9_1_2_G == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>এনজিও ক্লিনিক</label>

                                        <select id="Q9_1_2_H" name="Q9_1_2_H" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q9_1_2_H == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select> 
                                    </div>
                                </div>           
                                <div <?php if ($userInfo->Q9_1 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q9_1_no_reluctant_unknown">
                                    প্রাইভেট (ব্যক্তিগত) প্রতিষ্ঠান সমূহ:<br><br>
                                </div>      
                                <div <?php if ($userInfo->Q9_1 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q9_1_no_reluctant_unknown">
                                    <div class="col-md-3 form-group">
                                        <label>হাসপাতাল/ক্লিনিক/চেম্বার</label>

                                        <select id="Q9_1_2_I" name="Q9_1_2_I" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q9_1_2_I == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>বাড়ীতে</label>

                                        <select id="Q9_1_2_J" name="Q9_1_2_J" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q9_1_2_J == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>অন্যান্য (উল্লেখ করুন):</label>

                                        <select onchange="showHide(this.id, 'Q9_1_2_K_off')" name="Q9_1_2_K" class="form-control" id="Q9_1_2_K">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q9_1_2_K == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Yes_No_Reluctant_Unknown_single->code == 1)
                                                    echo " id='Q9_1_2_K_root'";
                                                else
                                                    echo " id='Q9_1_2_K_" . $i . "'";
                                                ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q9_1_2_K_OTHER; ?>" <?php if (strlen($userInfo->Q9_1_2_K_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q9_1_2_K_off" type="text" name="Q9_1_2_K_OTHER" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>কোথাও নেয়নি</label>
                                        <td>
                                            <select id="Q9_1_2_L" name="Q9_1_2_L" class="form-control">
                                                <option id="0" value="">নির্বাচন করুন</option>
                                                <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                    <option <?php if ($userInfo->Q9_1_2_L == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                <?php } ?>
                                            </select> 
                                    </div>
                                </div>           
                                <div <?php if ($userInfo->Q9_1 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q9_1_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            9.1.3) মৃত্যুর আগের এক মাসে তিনি কতবার পাশকরা ডাক্তার, নার্স,বা সাকমো থেকে চিকিৎসা নিয়েছেন?
                                        </label>
                                        <input value="<?php echo $userInfo->Q9_1_3_N; ?>" id="Q9_1_3_N" name="Q9_1_3_N" type="text" class="form-control">
                                    </div>
                                </div>      
                                <div <?php if ($userInfo->Q9_1 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q9_1_no_reluctant_unknown">
                                    <div class="col-md-12 form-group">
                                        <label>
                                            9.1.4) যে চিকিৎসা পেয়েছিল তার ধরন কি ছিল?
                                        </label>
                                    </div>
                                </div>      
                                <div <?php if ($userInfo->Q9_1 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q9_1_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>ORS</label>
                                        <td>
                                            <select id="Q9_1_4_A" name="Q9_1_4_A" class="form-control">
                                                <option id="0" value="">নির্বাচন করুন</option>
                                                <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                    <option <?php if ($userInfo->Q9_1_4_A == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                <?php } ?>
                                            </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>I/V (Intravenus) fluids</label>
                                        <td>
                                            <select id="Q9_1_4_B" name="Q9_1_4_B" class="form-control">
                                                <option id="0" value="">নির্বাচন করুন</option>
                                                <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                    <option <?php if ($userInfo->Q9_1_4_B == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                <?php } ?>
                                            </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>রক্ত সঞ্চালন</label>

                                        <select id="Q9_1_4_C" name="Q9_1_4_C" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q9_1_4_C == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                </div>      
                                <div <?php if ($userInfo->Q9_1 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q9_1_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>নাকের ভিতর টিউব দিয়ে চিকিৎসা বা খাওয়ানো</label>

                                        <select id="Q9_1_4_D" name="Q9_1_4_D" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q9_1_4_D == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>এন্টিবায়োটি ইনজেকশন</label>

                                        <select id="Q9_1_4_E" name="Q9_1_4_E" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q9_1_4_E == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>Antiretroviral Therapy for HIV infection(ART drug)</label>	

                                        <select id="Q9_1_4_F" name="Q9_1_4_F" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q9_1_4_F == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select> 
                                    </div>

                                </div>
                                <div <?php if ($userInfo->Q9_1 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q9_1_no_reluctant_unknown">

                                    <div class="col-md-4 form-group">
                                        <label>অন্যান্য চিকিৎসা</label>

                                        <select onchange="showHide(this.id, 'Q9_1_4_G_off')" name="Q9_1_4_G" class="form-control" id="Q9_1_4_G">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q9_1_4_G == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Yes_No_Reluctant_Unknown_single->code == 1)
                                                    echo " id='Q9_1_4_G_root'";
                                                else
                                                    echo " id='Q9_1_4_G_" . $i . "'";
                                                ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q9_1_4_G_OTHER; ?>" <?php if (strlen($userInfo->Q9_1_4_G_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q9_1_4_G_off" type="text" name="Q9_1_4_G_OTHER" class="form-control"> 
                                    </div>
                                </div>

                                <div <?php if ($userInfo->Q9_1 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q9_1_no_reluctant_unknown">
                                    <p style="color:red;font-size:14px;">Note: বাড়ীতে চিকিৎসা হলে (Skip to 9.3)</p><br><br>
                                </div>
                                <div <?php if ($userInfo->Q9_1 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q9_1_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            9.1.5) উনি হাসপাতাল বা স্বাস্থ্যসেবা প্রতিষ্ঠানে যেতে মোটরযান ব্যবহার করেছিল?
                                        </label>

                                        <select id="Q9_1_5" name="Q9_1_5" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q9_1_5 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            9.2) মৃত্যুর আগে তিনি হাসপাতালে/ক্লিনিকে ভর্তি হয়েছিলেন কি?
                                        </label>
                                        <select id="Q9_2" name="Q9_2" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q9_2 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <?php
                                $Q9_2_1_1_DATE = '';
                                $Q9_2_1_2_DATE = '';
                                $Q9_2_1_3_DATE = '';

                                if (!empty($userInfo->Q9_2_1_1_DATE)) {
                                    $partsRequire = explode('-', $userInfo->Q9_2_1_1_DATE);
                                    $Q9_2_1_1_DATE = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];
                                }
                                if (!empty($userInfo->Q9_2_1_2_DATE)) {
                                    $partsRequire = explode('-', $userInfo->Q9_2_1_2_DATE);
                                    $Q9_2_1_2_DATE = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];
                                }
                                if (!empty($userInfo->Q9_2_1_3_DATE)) {
                                    $partsRequire = explode('-', $userInfo->Q9_2_1_3_DATE);
                                    $Q9_2_1_3_DATE = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];
                                }
                                ?>

                                <div <?php if ($userInfo->Q9_2 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q9_2_no_reluctant_unknown">
                                    9.2.1) হাসপাতালে ভর্তির তালিকা লিখুন:  অতি সাম্প্রতিক থেকে শুরু করুন) <br><br>
                                </div>      
                                <div <?php if ($userInfo->Q9_2 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q9_2_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            1. স্বাস্থ্যসেবা প্রতিষ্ঠানের নাম
                                        </label>
                                        <select id="Q9_2_1_1_HCODE" name="Q9_2_1_1_HCODE" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Hospital_List as $VA_Hospital_List_single) { ?>
                                                <option <?php if ($userInfo->Q9_2_1_1_HCODE == $VA_Hospital_List_single->id) echo ' selected'; ?> value="<?php echo $VA_Hospital_List_single->id; ?>"><?php echo $VA_Hospital_List_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            তারিখ
                                        </label>
                                        <input value="<?php if ($userInfo->Q9_2_1_1_DATE != "1900-01-01") echo $Q9_2_1_1_DATE; ?>" id="Q9_2_1_1_DATE" name="Q9_2_1_1_DATE" autocomplete="off" type="text" class="datepicker form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            হাসপাতালে ভর্তির কারণ সমূহ
                                        </label>
                                        <input value="<?php echo $userInfo->Q9_2_1_1_CAUSE; ?>" id="Q9_2_1_1_CAUSE" name="Q9_2_1_1_CAUSE" type="text" class="form-control">
                                    </div>
                                </div>      
                                <div <?php if ($userInfo->Q9_2 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q9_2_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            2. স্বাস্থ্যসেবা প্রতিষ্ঠানের নাম
                                        </label>
                                        <select id="Q9_2_1_2_HCODE" name="Q9_2_1_2_HCODE" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Hospital_List as $VA_Hospital_List_single) { ?>
                                                <option <?php if ($userInfo->Q9_2_1_2_HCODE == $VA_Hospital_List_single->id) echo ' selected'; ?> value="<?php echo $VA_Hospital_List_single->id; ?>"><?php echo $VA_Hospital_List_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            তারিখ
                                        </label>
                                        <input value="<?php if ($userInfo->Q9_2_1_2_DATE != "1900-01-01") echo $Q9_2_1_2_DATE; ?>" id="Q9_2_1_2_DATE" name="Q9_2_1_2_DATE" autocomplete="off" type="text" class="datepicker form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            হাসপাতালে ভর্তির কারণ সমূহ
                                        </label>
                                        <input value="<?php echo $userInfo->Q9_2_1_2_CAUSE; ?>" id="Q9_2_1_2_CAUSE" name="Q9_2_1_2_CAUSE" type="text" class="form-control"> 
                                    </div>
                                </div>      
                                <div <?php if ($userInfo->Q9_2 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q9_2_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            3. স্বাস্থ্যসেবা প্রতিষ্ঠানের নাম
                                        </label>
                                        <select id="Q9_2_1_3_HCODE" name="Q9_2_1_3_HCODE" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Hospital_List as $VA_Hospital_List_single) { ?>
                                                <option <?php if ($userInfo->Q9_2_1_3_HCODE == $VA_Hospital_List_single->id) echo ' selected'; ?> value="<?php echo $VA_Hospital_List_single->id; ?>"><?php echo $VA_Hospital_List_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            তারিখ
                                        </label>
                                        <input value="<?php if ($userInfo->Q9_2_1_3_DATE != "1900-01-01") echo $Q9_2_1_3_DATE; ?>" id="Q9_2_1_3_DATE" name="Q9_2_1_3_DATE" autocomplete="off" type="text" class="datepicker form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            হাসপাতালে ভর্তির কারণ সমূহ
                                        </label>
                                        <input value="<?php echo $userInfo->Q9_2_1_3_CAUSE; ?>" id="Q9_2_1_3_CAUSE" name="Q9_2_1_3_CAUSE" type="text" class="form-control">
                                    </div>
                                </div>      
                                <div <?php if ($userInfo->Q9_2 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q9_2_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            9.2.2) খুবই অসুস্থ অবস্থায়ই ছাড়পত্র দিয়েছিল?
                                        </label>

                                        <select id="Q9_2_2" name="Q9_2_2" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q9_2_2 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select> 
                                    </div>
                                    <div class="col-md-4 form-group">
                                        9.2.3) হাসপাতালে ভর্তি হতে এবং সেবা পেতে এরূপ কোন সমস্যা হয়েছিল?
                                        <label>
                                            <td>ভর্তি ও বিছানা পেতে বিলম্ব</td>
                                        </label>
                                        <select id="Q9_2_3_A" name="Q9_2_3_A" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q9_2_3_A == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select> 
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>রোগ নির্নয় ও চিকিৎসা পেতে বিলম্ব </label>

                                        <select id="Q9_2_3_B" name="Q9_2_3_B" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q9_2_3_B == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select> 
                                    </div>
                                </div>      
                                <div <?php if ($userInfo->Q9_2 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q9_2_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>অমার্জিত আচরন </label>


                                        <select id="Q9_2_3_C" name="Q9_2_3_C" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q9_2_3_C == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select> 
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>হাসপাতালে পোঁছাতে দুই ঘন্টার বেশী সময় লাগা </label>


                                        <select id="Q9_2_3_D" name="Q9_2_3_D" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q9_2_3_D == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            9.2.4) মৃত্যুর আগের কয়েকদিনে চিকিৎসায় সহযোগিতার জন্য কেউ ফোন করেছিল?
                                        </label>
                                        <select id="Q9_2_4" name="Q9_2_4" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q9_2_4 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select> 
                                    </div>
                                </div>      
                                <div <?php if ($userInfo->Q9_2 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q9_2_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            9.2.5) মৃত্যুর আগের কয়েকদিনে প্রয়োজনীয় চিকিৎসা সেবা নিয়ে কোন সন্দেহ ছিল?
                                        </label>
                                        <select id="Q9_2_5" name="Q9_2_5" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q9_2_5 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select> 
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            9.2.6) মৃত্যুর আগের কয়েকদিনে Traditional medicine (প্রচলিত বা দেশীয় চিকিৎসা) ব্যবহৃত হয়েছিল?
                                        </label>
                                        <select id="Q9_2_6" name="Q9_2_6" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q9_2_6 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select> 
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            9.2.7) চিকিৎসা ব্যয়ের জন্য পারিবারিক অন্যান্য খরচ মিটাতে সমস্যা হয়েছিল?
                                        </label>
                                        <select id="Q9_2_7" name="Q9_2_7" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q9_2_7 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>      
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            9.3) মৃত্যুর স্থান
                                        </label> 
                                        <select onchange="showHide(this.id, 'Q9_3_off')" name="Q9_3" class="form-control" id="Q9_3">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Death_Place as $VA_Death_Place_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q9_3 == $VA_Death_Place_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Death_Place_single->code == 5)
                                                    echo " id='QQ9_3_root'";
                                                else
                                                    echo " id='QQ9_3_" . $i . "'";
                                                ?> value="<?php echo $VA_Death_Place_single->id; ?>"><?php echo $VA_Death_Place_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q9_3_OTHER; ?>" <?php if (strlen($userInfo->Q9_3_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q9_3_off" type="text" name="Q9_3_OTHER" class="form-control">
                                    </div>
                                    <div <?php if ($userInfo->Q9_3 != 1826) echo " style='display:none;'"; ?> class="col-md-4 form-group Q9_3_home_street_accidentPlace_other">
                                        <label>
                                            9.3.1) যদি সে কোন স্বাস্থ্যসেবা প্রতিষ্ঠানে মৃত্যুবরন করেন, তার নাম ও ঠিকানা লিখুন:
                                        </label>
                                        <select id="Q9_3_1_HCODE" name="Q9_3_1_HCODE" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Hospital_List as $VA_Hospital_List_single) { ?>
                                                <option <?php if ($userInfo->Q9_3_1_HCODE == $VA_Hospital_List_single->id) echo ' selected'; ?> value="<?php echo $VA_Hospital_List_single->id; ?>"><?php echo $VA_Hospital_List_single->name; ?></option>
                                            <?php } ?>
                                        </select>

                                        <br><input value="<?php echo $userInfo->Q9_3_1_ADDRESS; ?>" name="Q9_3_1_ADDRESS" type="text" class="form-control">
                                    </div>
                                    <div <?php if ($userInfo->Q9_3 != 1826) echo " style='display:none;'"; ?> class="col-md-4 form-group Q9_3_home_street_accidentPlace_other">
                                        <label>
                                            9.3.2) স্বাস্থ্যসেবা প্রতিষ্ঠান থেকে কেউ কি আপনাকে মৃত্যুর কারণটি বলেছিল?
                                        </label> 
                                        <select id="Q9_3_2" name="Q9_3_2" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q9_3_2 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select> 
                                    </div>
                                </div>      
                                <div <?php if ($userInfo->Q9_3_2 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q9_3_2_no_reluctant_unknown">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            9.3.3) কে কারণটি বলে ছিল?
                                        </label> 
                                        <select onchange="showHide(this.id, 'Q9_3_3_off')" name="Q9_3_3" class="form-control" id="Q9_3_3">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Reason_Teller as $VA_Reason_Teller_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q9_3_3 == $VA_Reason_Teller_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Reason_Teller_single->code == 3)
                                                    echo " id='Q9_3_3_root'";
                                                else
                                                    echo " id='Q9_3_3_" . $i . "'";
                                                ?> value="<?php echo $VA_Reason_Teller_single->id; ?>"><?php echo $VA_Reason_Teller_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input value="<?php echo $userInfo->Q9_3_3_OTHER; ?>" <?php if (strlen($userInfo->Q9_3_3_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q9_3_3_off" type="text" name="Q9_3_3_OTHER" class="form-control">
                                    </div>

                                </div>


                                <div <?php if ($userInfo->Q9_3_2 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q9_3_2_no_reluctant_unknown">
                                    <div class="col-md-12 form-group">
                                        <label>
                                            9.3.4) তিনি মৃত্যুর কি কারণ বলেছিলেন? (কারণ সমূহ লিখুন) 
                                        </label>
                                        <textarea id="Q9_3_4_CAUSE" name="Q9_3_4_CAUSE" rows="5" class="form-control"><?php echo $userInfo->Q9_3_4_CAUSE; ?></textarea>
                                    </div>
                                </div>      
                                <div class="col-md-12">
                                    X) স্বাস্থ্য সম্পর্কিত তথ্য/ব্যবস্থাপত্র  (HEALTH RECORDS/PRESCRIPTION)<br><br>
                                </div>      
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>   
                                            10.1) মৃতের কোন স্বাস্থ্য সম্পর্কিত তথ্য/ব্যবস্থাপত্র আছে কি?
                                        </label>
                                        <select id="Q10_1" name="Q10_1" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q10_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q10_1 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q10_1_no_reluctant_unknown">
                                        <label>
                                            10.1.1) আমি কি স্বাস্থ্য সম্পর্কিত তথ্যখানা/ব্যবস্থাপত্র দেখতে পারি?
                                        </label>	
                                        <select id="Q10_1_1" name="Q10_1_1" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($va_yes_no as $va_yes_no_single) { ?>
                                                <option <?php if ($userInfo->Q10_1_1 == $va_yes_no_single->id) echo ' selected'; ?> value="<?php echo $va_yes_no_single->id; ?>"><?php echo $va_yes_no_single->name; ?></option>
                                            <?php } ?>
                                        </select> 
                                    </div>
                                </div>
                                <?php
                                $Q10_1_1_VDATE = '';
                                if (!empty($userInfo->Q10_1_1_VDATE)) {
                                    $partsRequire = explode('-', $userInfo->Q10_1_1_VDATE);
                                    $Q10_1_1_VDATE = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];
                                }
                                ?>

                                <div <?php if ($userInfo->Q10_1_1 != 1567) echo " style='display:none;'"; ?> class="col-md-12 Q10_1_1_part">
                                    (তথ্যখানা থেকে  Date, height, weight in kg written at the most recent visit, Symptoms, diagnosis and treatment লিখুন / সংযুক্ত করূন)<br><br>
                                </div>      
                                <div <?php if ($userInfo->Q10_1_1 != 1567) echo " style='display:none;'"; ?> class="col-md-12 Q10_1_1_part">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            Date
                                        </label>

                                        <input id="Q10_1_1_VDATE" value="<?php if ($userInfo->Q10_1_1_VDATE != "1900-01-01") echo $Q10_1_1_VDATE; ?>" type="text" name="Q10_1_1_VDATE" autocomplete="off" class="datepicker form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            Height (cm)
                                        </label>

                                        <input id="Q10_1_1_HIGH" value="<?php echo $userInfo->Q10_1_1_HIGH; ?>" name="Q10_1_1_HIGH" type="number" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            Weight (kg)
                                        </label>

                                        <input id="Q10_1_1_WEIG" value="<?php echo $userInfo->Q10_1_1_WEIG; ?>" name="Q10_1_1_WEIG" type="number" class="form-control">
                                    </div>
                                </div>      
                                <div <?php if ($userInfo->Q10_1_1 != 1567) echo " style='display:none;'"; ?> class="col-md-12 Q10_1_1_part">
                                    <div class="col-md-4 form-group">

                                        <label>
                                            Symptoms
                                        </label>

                                        <input id="Q10_1_1_SYMP" value="<?php echo $userInfo->Q10_1_1_SYMP; ?>" name="Q10_1_1_SYMP" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            Diagnosis
                                        </label>

                                        <input id="Q10_1_1_DIAG" value="<?php echo $userInfo->Q10_1_1_DIAG; ?>" name="Q10_1_1_DIAG" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>
                                            Treatment
                                        </label>
                                        <input id="Q10_1_1_TRET" value="<?php echo $userInfo->Q10_1_1_TRET; ?>" name="Q10_1_1_TRET" type="text" class="form-control">
                                    </div>
                                </div>      
                                <div class="col-md-12">
                                    <div <?php
                                    if ($userInfo->Q10_1 == 1577 || $userInfo->Q10_1 == 1578 || $userInfo->Q10_1 == 1579 || $userInfo->Q10_1_1 == 1568)
                                        echo " style='display:block;'";
                                    else
                                        echo " style='display:none;'";
                                    ?> class="col-md-4 form-group Q10_2_part">
                                        <label>
                                            10.2) তার কি মৃত্যু প্রত্যায়ন পত্র ছিল?
                                        </label>

                                        <select id="Q10_2" name="Q10_2" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q10_2 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select> 
                                    </div>
                                    <div <?php if ($userInfo->Q10_2 != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q10_2_no_reluctant_unknown">
                                        <label>
                                            10.2.1) সাক্ষাৎকার গ্রহনকারী কি মৃত্যু প্রত্যায়ন পত্র দেখেছিলেন? (Don't ask the Respondent)
                                        </label>

                                        <select id="Q10_2_1" name="Q10_2_1" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($va_yes_no as $va_yes_no_single) { ?>
                                                <option <?php if ($userInfo->Q10_2_1 == $va_yes_no_single->id) echo ' selected'; ?> value="<?php echo $va_yes_no_single->id; ?>"><?php echo $va_yes_no_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>      
                                <div <?php if ($userInfo->Q10_2 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q10_2_no_reluctant_unknown">
                                    10.2.2) সার্টিফিকেট অনুযায়ী মৃত্যুর কারণ লিখুন<br><br>
                                </div>      
                                <div <?php if ($userInfo->Q10_2 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q10_2_no_reluctant_unknown">
                                    <div class="col-md-3 form-group">
                                        <label> a. Immediate cause </label>
                                        <input value="<?php echo $userInfo->Q10_2_2_ICAUSE; ?>" id="Q10_2_2_ICAUSE" name="Q10_2_2_ICAUSE" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>Code</label> 
                                        <input value="<?php echo $userInfo->Q10_2_2_ICODE; ?>" id="Q10_2_2_ICODE" name="Q10_2_2_ICODE" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label> b. Antecedent cause </label>
                                        <input value="<?php echo $userInfo->Q10_2_2_ACAUSE; ?>" id="Q10_2_2_ACAUSE" name="Q10_2_2_ACAUSE" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>Code</label>
                                        <input value="<?php echo $userInfo->Q10_2_2_ACODE; ?>" id="Q10_2_2_ACODE" name="Q10_2_2_ACODE" type="text" class="form-control">
                                    </div>
                                </div>      
                                <div <?php if ($userInfo->Q10_2 != 1576) echo " style='display:none;'"; ?> class="col-md-12 Q10_2_no_reluctant_unknown">
                                    <div class="col-md-3 form-group">
                                        <label>c. Underlying cause</label> 
                                        <input value="<?php echo $userInfo->Q10_2_2_UCAUSE; ?>" id="Q10_2_2_UCAUSE" name="Q10_2_2_UCAUSE" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>Code</label>
                                        <input value="<?php echo $userInfo->Q10_2_2_UCODE; ?>" id="Q10_2_2_UCODE" name="Q10_2_2_UCODE" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>d. Contributing cause</label> 
                                        <input value="<?php echo $userInfo->Q10_2_2_CCAUSE; ?>" id="Q10_2_2_CCAUSE" name="Q10_2_2_CCAUSE" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label> Code</label> 
                                        <input value="<?php echo $userInfo->Q10_2_2_CCODE; ?>" id="Q10_2_2_CCODE" name="Q10_2_2_CCODE" type="text" class="form-control">
                                    </div>
                                </div>      
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>       
                                            10.3) মৃত্যু নিবন্ধণ করা হয়েছিল?(Civil Registration by Union Parishad/ Paurosova)
                                        </label>    
                                        <select id="Q10_3_DR" name="Q10_3_DR" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q10_3_DR == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>      
                                <div class="col-md-12">
                                    <div <?php if ($userInfo->Q10_3_DR != 1576) echo " style='display:none;'"; ?> class="col-md-4 form-group Q10_3_DR_no_reluctant_unknown">
                                        <label>
                                            10.3.1) আপনি কি নিবন্ধণপত্র দেখেছেন? (Don't ask the Respondent)
                                        </label>
                                        <select id="Q10_3_1_DRS" name="Q10_3_1_DRS" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($va_yes_no as $va_yes_no_single) { ?>
                                                <option <?php if ($userInfo->Q10_3_1_DRS == $va_yes_no_single->id) echo ' selected'; ?> value="<?php echo $va_yes_no_single->id; ?>"><?php echo $va_yes_no_single->name; ?></option>
                                            <?php } ?>
                                        </select> 
                                    </div>
                                    <?php
                                    $Q10_3_2_DRD = '';
                                    if (!empty($userInfo->Q10_3_2_DRD)) {
                                        $partsRequire = explode('-', $userInfo->Q10_3_2_DRD);
                                        $Q10_3_2_DRD = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];
                                    }
                                    ?>
                                    <div <?php if ($userInfo->Q10_3_1_DRS != 1567) echo " style='display:none;'"; ?> class="col-md-4 form-group Q10_3_1_DRS_no_reluctant_unknown">
                                        <label>
                                            10.3.2) নিবন্ধণের তারিখ লিখুন
                                        </label>
                                        <input value="<?php if ($userInfo->Q10_3_2_DRD != "1900-01-01") echo $Q10_3_2_DRD; ?>" id="Q10_3_2_DRD" name="Q10_3_2_DRD" type="text" autocomplete="off" class="datepicker form-control">
                                    </div>
                                    <div <?php if ($userInfo->Q10_3_1_DRS != 1567) echo " style='display:none;'"; ?> class="col-md-4 form-group Q10_3_1_DRS_no_reluctant_unknown">
                                        <label>
                                            10.3.3) নিবন্ধণ নাম্বার লিখুন
                                        </label>

                                        <input value="<?php echo $userInfo->Q10_3_3_DRN; ?>" id="Q10_3_3_DRN" name="Q10_3_3_DRN" type="text" class="form-control">
                                    </div>
                                </div>    
                                <div class="box-footer col-md-12">
                                    <input type="submit" class="btn btn-primary" value="Update">
                                </div>								
                                <div class="col-md-12">
                                    <label>
                                        XI) সাক্ষাৎকার গ্রহনকারীর মন্তব্য এবং পর্যবেক্ষনঃ (মৃত্যুর কারণ সম্পর্কে সন্দেহ থাকলে তাও লিখুন)
                                    </label>
                                    <textarea name="Q11_INTERVIEW" rows="5" class="form-control"><?php echo $userInfo->Q11_INTERVIEW; ?></textarea>
                                </div>    
                                <div class="col-md-12">
                                    <label>Comments on specific questions:</label>
                                    <textarea name="Q11_CSQ" rows="5" class="form-control"><?php echo $userInfo->Q11_CSQ; ?></textarea>
                                </div>      
                                <div class="col-md-12">
                                    <label>
                                        Any other comments:
                                    </label>

                                    <textarea name="Q11_AOC" rows="5" class="form-control"><?php echo $userInfo->Q11_AOC; ?></textarea>
                                </div>
                                <div class="col-md-12">
                                    <label>
                                        Supervisor Observation:
                                    </label>

                                    <textarea name="Q11_SO" rows="5" class="form-control"><?php echo $userInfo->Q11_SO; ?></textarea>
                                </div>
                                <?php
                                $Q11_DOE = '';
                                if (!empty($userInfo->Q11_DOE)) {
                                    $partsRequire = explode('-', $userInfo->Q11_DOE);
                                    $Q11_DOE = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];
                                }
                                ?>

                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label>
                                            Date of editing questionnaire
                                        </label>

                                        <input value="<?php if ($userInfo->Q11_DOE != "1900-01-01") echo $Q11_DOE; ?>" name="Q11_DOE" type="text" autocomplete="off" class="datepicker form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>By Supervisor</label>

                                        <select name="Q11_SUP_CODE" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Supervisor_List as $VA_Supervisor_List_single) { ?>
                                                <option <?php if ($userInfo->Q11_SUP_CODE == $VA_Supervisor_List_single->id) echo ' selected'; ?> value="<?php echo $VA_Supervisor_List_single->id; ?>"><?php echo $VA_Supervisor_List_single->name; ?></option>
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
                </div>
            </div>
            <div class="box-footer">
                <input type="submit" class="btn btn-primary" value="Update">
            </div>
            </form>
        </div>
</div>    
</section>

<script src="<?php echo base_url(); ?>assets/js/adultJS.js"></script>


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

                                            function showClass(item) {
                                                $("." + item).show();
                                            }

                                            function hideClass(item) {
                                                $("." + item).hide();
                                            }

                                            function EnableRequiredFields(item) {
                                                $('#' + item).attr('disabled', false);
                                                $("#" + item).show();
                                                $('#' + item).prop('required', true);

                                                if (jQuery('#' + item).prop("tagName") === 'SELECT') {
                                                    //            $('#' + item).prop('selectedIndex', 0);
                                                    $('#' + item).val('0').trigger('change');
                                                }
                                            }

                                            function DisableRequiredFields(item) {
                                                $("#" + item).hide();
                                                $('#' + item).prop('required', false);
                                                $('#' + item).attr('disabled', true);
                                            }
</script>