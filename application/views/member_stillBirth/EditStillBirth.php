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
                    <small>(Edit)</small>
                    <?php $baseID = $this->input->get('baseID', TRUE); ?>
                </h3>

            </div>
            <div class="col-xs-6 text-right">
                <div class="form-group margin5pxBot">
                    <a class="btn btn-primary" href="<?php echo base_url() . $controller .'?baseID=' . $baseID ?>">Still Birth List</a>
                </div>
            </div>
        </div>
    </section>

    <section class="content content-margin">
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="" style="color: #00799E;text-align: center;font-weight: bold;">
                            Verbal Autopsy for Stillbirth
                        </h3>
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
                        <input type="hidden" name="ID" value="<?php echo $userInfo->ID; ?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group col-md-4">
                                        <label><b>1.1</b> মায়ের নাম:</label>
                                        <input value="<?php echo $userInfo->Q1_1_N1; ?>" name="Q1_1_N1" type="text" class="form-control">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Member ID:</label>
                                        <input value="<?php echo $userInfo->Q1_1_CID; ?>" name="Q1_1_CID" type="text" class="form-control">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>LPODT:</label>
                                        <input value="<?php echo $userInfo->Q1_1_LPODT; ?>" name="Q1_1_LPODT" type="text" class="form-control">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label> <b>1.2</b>
                                            &nbsp;তিনি (মা) কি এখনও বেঁচে আছেন?
                                            (নোট: সাক্ষাৎকারের সময়ে মা যদি উপস্থিত থাকেন তা হলে ১.৫ নং প্রশ্নে যান)</label>

                                        <select id="Q1_2" name="Q1_2" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q1_2 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label> <b>1.3</b>
                                            &nbsp;যদি মা মারা গিয়ে থাকেন, উনি প্রসব কালে না প্রসবের পরে মারা গিয়েছেন?</label>
                                        <br/><br/>
                                        <select id="Q1_3" class="form-control" name="Q1_3">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Mother_Death_When as $VA_Mother_Death_When_single) { ?>
                                                <option <?php if ($userInfo->Q1_3 == $VA_Mother_Death_When_single->id) echo ' selected'; ?> value="<?php echo $VA_Mother_Death_When_single->id; ?>"><?php echo $VA_Mother_Death_When_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label ><b>1.4</b>&nbsp;প্রসবের কতক্ষন পরে মা মারা গেছেন?
                                            (২৪ ঘন্টার কম হলে=০০ দিন, মাস হিসাব করতে ১ মাস=৩০ দিন,এই হিসাবে গননা করুন)।
                                        </label>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <select onchange="showHide(this.id, 'Q1_4_off')" class="form-control" id="Q1_4" name="Q1_4">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Day_Month_Reluctant_Unknown as $VA_Day_Month_Reluctant_Unknown_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q1_4 == $VA_Day_Month_Reluctant_Unknown_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Day_Month_Reluctant_Unknown_single->code == 1 || $VA_Day_Month_Reluctant_Unknown_single->code == 2)
                                                    echo " id='Q1_4_root'";
                                                else
                                                    echo " id='Q1_4_" . $i . "'";
                                                ?> value="<?php echo $VA_Day_Month_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Day_Month_Reluctant_Unknown_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select><br/>
                                        <input value="<?php echo $userInfo->Q1_4_DAY_OR_MONTH; ?>" <?php if ($userInfo->Q1_4_DAY_OR_MONTH == 0) echo " style='display:none;'"; ?> type="number" id="Q1_4_off" name="Q1_4_DAY_OR_MONTH" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group col-md-6">
                                        <label><b>1.5a</b>&nbsp;জন্মের পর শিশুটি একবারও কি নড়েছিল?
                                        </label>
                                        <select class="form-control" name="Q1_5a">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q1_5a == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label><b>1.5b</b>&nbsp;জন্মের পর পর শিশুটি কি একবারও কেঁদেছিল?
                                        </label>
                                        <select class="form-control" name="Q1_5b">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q1_5b == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label><b>1.6</b>&nbsp;জন্মের পর শিশুটি কি একবারও শ্বাস ফেলেছিল?
                                        </label>
                                        <select class="form-control" name="Q1_6">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q1_6 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label><b>1.7</b>&nbsp;জন্মের পর শিশুটির হৃদস্পন্দন ছিল কি?
                                        </label>
                                        <select class="form-control" name="Q1_7">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q1_7 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label><b>1.8</b>&nbsp;জন্মের পর শিশুটি যদি একবারও না নড়ে, একবারও না কাঁদে
                                            শ্বাস না ফেলে এবং হৃদস্পন্দন না থাকে, তাহলে সে কখন মারা গেছে বলে আপনি মনে করেন?
                                        </label>
                                        <select class="form-control" name="Q1_8">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q1_8 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label><b>1.9</b>&nbsp;জন্মের পর শিশুটির চামড়া কি ক্ষতবিক্ষত বা শরীর বিবর্ন হয়েছিল?
                                        </label><br/><br/>
                                        <select class="form-control" name="Q1_9">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q1_9 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label><b>1.10</b>&nbsp;জন্মের পর বাচ্চাটির গায়ে কি থেঁতলানো বা আঘাতের কালো দাগ/চিহ্ন ছিল?
                                        </label>
                                        <select class="form-control" name="Q1_10">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q1_10 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label><b>1.11</b>&nbsp;বাচ্চাটির শরীরে বা চামড়া কোন অংশে ফুলা ছিল?
                                        </label>
                                        <select class="form-control" name="Q1_11">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q1_11 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label><b>1.12</b>&nbsp;জন্মের সময় শিশুটির আকার কিরূপ ছিল?
                                            <!-- (পড়ে শুনান) -->
                                        </label>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <select id="Q1_12" class="form-control" name="Q1_12">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Baby_Weight as $VA_Baby_Weight_single) { ?>
                                                <option <?php if ($userInfo->Q1_12 == $VA_Baby_Weight_single->id) echo ' selected'; ?> value="<?php echo $VA_Baby_Weight_single->id; ?>"><?php echo $VA_Baby_Weight_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label><b>1.13</b>&nbsp;জন্ম ওজন (কেজিতে)<br/>Code: ৯৮ = ওজন নেয়নি, ৯৯ = অজানা)
                                        </label>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <select onchange="showHide(this.id, 'Q1_13_off')" class="form-control" id="Q1_13" name="Q1_13">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Weight_Specific as $VA_Weight_Specific_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q1_13 == $VA_Weight_Specific_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Weight_Specific_single->code == 1)
                                                    echo " id='Q1_13_root'";
                                                else
                                                    echo " id='Q1_13_" . $i . "'";
                                                ?> value="<?php echo $VA_Weight_Specific_single->id; ?>"><?php echo $VA_Weight_Specific_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select><br/>
                                        <input value="<?php echo $userInfo->Q1_13_kg; ?>" <?php if ($userInfo->Q1_13_kg == 0) echo " style='display:none;'"; ?> type="number" id="Q1_13_off" name="Q1_13_kg" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group col-md-6">
                                        <label>1.14&nbsp;জন্মের সময় বাচ্চাটির কি কোন অঙ্গ বিকৃতি ছিল?(যেমন- ঠোঁট কাটা, পা বাঁকা, খুব ছোট/বড় মাথা,পিছনে ফোলা)
                                        </label>
                                            <select id="Q1_14" class="form-control" name="Q1_14">
                                                <option id="0" value="">নির্বাচন করুন</option>
                                                <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                    <option <?php if ($userInfo->Q1_14 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                <?php } ?>
                                            </select>
                                    </div>
                                    <div <?php if ($userInfo->Q1_14!=1576) echo " style='display:none;'"; ?> class="form-group col-md-6 Q1_15_part">
                                        <label><b>1.15</b>&nbsp;অঙ্গ বিকৃতিগুলি কি কি ছিল:</label>
                                        <select onchange="showHide(this.id, 'Q1_15_off')" name="Q1_15" class="form-control" id="Q1_15">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Organ_Distortion as $VA_Organ_Distortion_single) {
                                                ?>
                                                <option <?php
                                                if ($userInfo->Q1_15 == $VA_Organ_Distortion_single->id)
                                                    echo ' selected';

                                                if ($VA_Organ_Distortion_single->code == 4)
                                                    echo " id='Q1_15_root'";
                                                else
                                                    echo " id='Q1_15_" . $i . "'";
                                                ?> value="<?php echo $VA_Organ_Distortion_single->id; ?>"><?php echo $VA_Organ_Distortion_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                        <br/>
                                        <input <?php if (strlen($userInfo->Q1_15_OTHER) > 0 == false) echo " style='display:none;'"; ?> value="<?php echo $userInfo->Q1_15_OTHER; ?>" id="Q1_15_off" type="text" name="Q1_15_OTHER" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group col-md-12">
                                        <b>2.0</b>&nbsp;
                                        <table class="table table-bordered table-striped">
                                            <tr>
                                                <td colspan="2">গর্ভাবস্থায় মায়ের নিম্মের অসুস্থতাগুলোর কোনটি ছিল কি না জিজ্ঞাসা করুন:
                                                    <br/>(একাধিক উত্তর হতে পারে)</td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: left;">&nbsp;উচ্চ রক্তচাপ (Hypertension)</td>
                                                <td>
                                                    <select class="form-control" name="Q2_A">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q2_A == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td style="text-align: left;">&nbsp;হৃদ রোগ (Heart diseases)</td>
                                                <td>
                                                    <select class="form-control" name="Q2_B">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q2_B == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: left;">&nbsp;ডায়াবেটিস (Diabetes)</td>
                                                <td>
                                                    <select class="form-control" name="Q2_C">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q2_C == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: left;">&nbsp;যক্ষা (TB)</td>
                                                <td>
                                                    <select class="form-control" name="Q2_D">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q2_D == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: left;">&nbsp;মৃগীরোগ/খিঁচুনী (Epilepsy/Convulsion)</td>
                                                <td>
                                                    <select class="form-control" name="Q2_E">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q2_E == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: left;">&nbsp;শরীরের দানা/লালচে গোটা/জ্বর (Rash/Fever) গর্ভাব¯হায়</td>
                                                <td>
                                                    <select class="form-control" name="Q2_F">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q2_F == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: left;">&nbsp;অন্যান্য রোগ (উল্লেখ করুন)</td>
                                                <td>
                                                    <select onchange="showHide(this.id, 'Q2_G_off')" name="Q2_G" class="form-control" id="Q2_G">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php
                                                        $i = 1;
                                                        foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) {
                                                            ?>
                                                            <option <?php if ($userInfo->Q2_G == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> <?php
                                                            if ($VA_Yes_No_Reluctant_Unknown_single->code == 1)
                                                                echo " id='Q2_G_root'";
                                                            else
                                                                echo " id='Q2_G_" . $i . "'";
                                                            ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                                <?php
                                                                $i++;
                                                            }
                                                            ?>
                                                    </select>
                                                    <br/>
                                                    <input value="<?php echo $userInfo->Q2_G_OTHER; ?>" <?php if (strlen($userInfo->Q2_G_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q2_G_off" type="text" name="Q2_G_OTHER" class="form-control">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <b>2.1</b>&nbsp;
                                        <table class="table table-bordered table-striped">
                                            <tr>
                                                <td colspan="2">সর্বশেষ গর্ভাবস্থায় বা প্রসবে আপনার (মায়ের) কি কোনও জটিলতা হয়েছিল?</td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;১. খিঁচুনী (Convulsions)</td>
                                                <td>
                                                    <select class="form-control" name="Q2_1_1">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q2_1_1 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;২. রক্তপাত (Antenatal bleeding)</td>
                                                <td>
                                                    <select class="form-control" name="Q2_1_2">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q2_1_2 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;৩. প্রসবপূর্ব বাচ্চার নড়াচড়া বন্ধ/কমে যাওয়া</td>
                                                <td>
                                                    <select class="form-control" name="Q2_1_3">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q2_1_3 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;৪. গর্ভাবস্থায় জ্বর (Fever/febrile illness during pregnancy)</td>
                                                <td>
                                                    <select class="form-control" name="Q2_1_4">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q2_1_4 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;৫. প্রসবকালীন অতিরিক্ত রক্তপাত (Excessive bleeding)</td>
                                                <td>
                                                    <select class="form-control" name="Q2_1_5">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q2_1_5 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;৬. প্রসব ব্যথা শুরুর ১ দিন বা তার আগে পানি ভাঙ্গা</td>
                                                <td>
                                                    <select class="form-control" name="Q2_1_6">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q2_1_6 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;৭. পানি ভাঙ্গা-পানি বাদামী/সবুজ/হলুদ রংয়ের/দুর্গন্ধযুক্ত</td>
                                                <td>
                                                    <select class="form-control" name="Q2_1_7">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q2_1_7 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;৮. কষ্টদায়ক প্রসব </td>
                                                <td>
                                                    <select class="form-control" name="Q2_1_8">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q2_1_8 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;৯. দীর্ঘায়িত/কষ্টদায়ক প্রসব (২৪ ঘন্টা +)</td>
                                                <td>
                                                    <select class="form-control" name="Q2_1_9">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q2_1_9 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;১০. উল্টা প্রসব (Breech)</td>
                                                <td>
                                                    <select class="form-control" name="Q2_1_10">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q2_1_10 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;১১. প্রসবের পূর্বে হাত আগে আসা (Hand prolapse)</td>
                                                <td>
                                                    <select class="form-control" name="Q2_1_11">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q2_1_11 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;১২. বাচ্চা আড়াআড়ি থাকা (Tranverse lie)</td>
                                                <td>
                                                    <select class="form-control" name="Q2_1_12">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q2_1_12 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;১৩. নাড়ী (Umbilical cord) আগে আসা (প্রসব কালে) </td>
                                                <td>
                                                    <select class="form-control" name="Q2_1_13">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q2_1_13 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;১৪. নাড়ী শিশুর গলায় পেচাঁনো </td>
                                                <td>
                                                    <select class="form-control" name="Q2_1_14">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q2_1_14 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;১৫. পা ফোলা/মুখ ফোলা</td>
                                                <td>
                                                    <select class="form-control" name="Q2_1_15">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q2_1_15 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;১৬. জন্ডিস</td>
                                                <td>
                                                    <select class="form-control" name="Q2_1_16">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q2_1_16 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;১৭. গর্ভাবস্থায় দেখতে ফ্যাকাশে এবং ঘনঘন শ্বাস (উভয়ই) নেওয়া</td>
                                                <td>
                                                    <select class="form-control" name="Q2_1_17">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q2_1_17 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;১৮. গর্ভাবস্থায় মাথা ব্যথা</td>
                                                <td>
                                                    <select class="form-control" name="Q2_1_18">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q2_1_18 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;১৯. গর্ভাবস্থায় ঝাপসা দেখা</td>
                                                <td>
                                                    <select class="form-control" name="Q2_1_19">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q2_1_19 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;২০. যোনী পথে গন্ধযুক্ত সাদা স্রাব নির্গত হওয়া</td>
                                                <td>
                                                    <select class="form-control" name="Q2_1_20">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q2_1_20 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;২১. মারাত্বক পেটব্যথা (প্রসব ব্যথা নয়)</td>
                                                <td>
                                                    <select class="form-control" name="Q2_1_21">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q2_1_21 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;২২. প্রসব ব্যথার দিন জ্বর  </td>
                                                <td>
                                                    <select class="form-control" name="Q2_1_22">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q2_1_22 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;অন্যান্য রোগ (উল্লেখ করুন)</td>
                                                <td>
                                                    <select onchange="showHide(this.id, 'Q2_1_23_off')" name="Q2_1_23" class="form-control" id="Q2_1_23">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php
                                                        $i = 1;
                                                        foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) {
                                                            ?>
                                                            <option <?php if ($userInfo->Q2_1_23 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> <?php
                                                            if ($VA_Yes_No_Reluctant_Unknown_single->code == 1)
                                                                echo " id='Q2_1_23_root'";
                                                            else
                                                                echo " id='Q2_1_23_" . $i . "'";
                                                            ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                                <?php
                                                                $i++;
                                                            }
                                                            ?>
                                                    </select>
                                                    <br/>
                                                    <input value="<?php echo $userInfo->Q2_1_23_OTHER; ?>" <?php if (strlen($userInfo->Q2_1_23_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q2_1_23_off" type="text" name="Q2_1_23_OTHER" class="form-control">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label><b>2.2</b>&nbsp;আপনি (মা) কি টিটি টিকা নিয়েছিলেন?</label>
                                        <select id="Q2_2" class="form-control" name="Q2_2">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q2_2 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div <?php if ($userInfo->Q2_2!=1576) echo " style='display:none;'"; ?> class="form-group col-md-6 Q2_3_part">
                                        <label><b>2.3</b>&nbsp;কত ডোজ টিটি টিকা নিয়েছিলেন?</label>
                                        <input value="<?php echo $userInfo->Q2_3; ?>" id="Q2_3" name="Q2_3" type="text" class="form-control" placeholder="ডোজ">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label><b>2.4</b>&nbsp;আপনি (মা) কি অন্য কোন টীকা নিয়েছিলেন?</label>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <table class="table table-bordered table-striped">
                                            <tr>
                                                <td colspan="2">টীকার নাম</td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;হেপাটাইটিস বি</td>
                                                <td>
                                                    <select class="form-control" name="Q2_4_A">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q2_4_A == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;বিসিজি</td>
                                                <td>
                                                    <select class="form-control" name="Q2_4_B">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q2_4_B == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><td style="text-align: left;">&nbsp;অন্যান্য</td>
                                                <td>
                                                    <select class="form-control" name="Q2_4_C">
                                                        <option id="0" value="">নির্বাচন করুন</option>
                                                        <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                            <option <?php if ($userInfo->Q2_4_C == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label><b>2.5</b>&nbsp;আপনার (মায়ের) কতগুলো জীবিত জন্ম (এই শিশু সহ), মৃত জন্ম এবং গর্ভপাত হয়েছিল?</label>
                                    </div>
                                    <div class="form-group col-md-2"><input value="<?php echo $userInfo->Q2_5_alive; ?>" name="Q2_5_alive" type="text" class="form-control" placeholder="জীবিত জন্ম"></div>
                                    <div class="form-group col-md-2"><input value="<?php echo $userInfo->Q2_5_dead; ?>" name="Q2_5_dead" type="text" class="form-control" placeholder="মৃত জন্ম"></div>
                                    <div class="form-group col-md-2"><input value="<?php echo $userInfo->Q2_5_mr; ?>" name="Q2_5_mr" type="text" class="form-control" placeholder="গর্ভপাত/এমআর"></div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group col-md-6">
                                        <label><b>2.6</b>&nbsp;আপনার (মায়ের) সর্বশেষ মাসিক এর তারিখ (দিন/মাস/বছর):</label>
                                    </div>
                                    <?php
                                    
                                    if ($userInfo->Q2_6_DATE == "") {
                                        $userInfo->Q2_6_DATE = "1900-01-01";
                                    }
                                    $partsRequire = explode('-', $userInfo->Q2_6_DATE);
                                    $Q2_6_DATE = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];
                                    
                                    ?>
                                    <div class="form-group col-md-6">
                                        <input value="<?php if ($userInfo->Q2_6_DATE != "1900-01-01") echo $Q2_6_DATE; ?>" name="Q2_6_DATE" class="datepicker form-control">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label><b>2.7</b>&nbsp;তিনি (মা) কতমাস যাবৎ গর্ভবতী ছিলেন?</label>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input value="<?php echo $userInfo->Q2_7; ?>" name="Q2_7" type="text" class="form-control" placeholder="মাস">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label><b>2.8</b>&nbsp;গর্ভাব¯হা কি সময়ের আগে, ঠিক সময়ে, না বিলম্বে শেষ হয়েছিল?</label>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <select id="Q2_8" class="form-control" name="Q2_8">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Pregnancy_Ending_Time as $VA_Pregnancy_Ending_Time_single) { ?>
                                                <option <?php if ($userInfo->Q2_8 == $VA_Pregnancy_Ending_Time_single->id) echo ' selected'; ?> value="<?php echo $VA_Pregnancy_Ending_Time_single->id; ?>"><?php echo $VA_Pregnancy_Ending_Time_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label><b>2.9</b>&nbsp;ধাত্রী (Birth attendant) কি আপনাকে বলেছিলেন যে, উনি শিশুটির হৃদস্পন্দন (foetal heart sound) শুনেছেন?</label>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <select class="form-control" name="Q2_9">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Yes_No_Reluctant_Unknown as $VA_Yes_No_Reluctant_Unknown_single) { ?>
                                                <option <?php if ($userInfo->Q2_9 == $VA_Yes_No_Reluctant_Unknown_single->id) echo ' selected'; ?> value="<?php echo $VA_Yes_No_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Yes_No_Reluctant_Unknown_single->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <div class="form-group col-md-6"> 
                                        <label><b>2.10</b>&nbsp;আপনি (মা) সর্বশেষ কখন বাচ্চার নড়াচড়া অনুভব করতে পেরেছিলেন?</label>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <select onchange="showHide(this.id, 'Q2_10_off')" class="form-control" id="Q2_10" name="Q2_10">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Day_Hour_Reluctant_Unknown as $VA_Day_Hour_Reluctant_Unknown_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q2_10 == $VA_Day_Hour_Reluctant_Unknown_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Day_Hour_Reluctant_Unknown_single->code == 1 || $VA_Day_Hour_Reluctant_Unknown_single->code == 2)
                                                    echo " id='Q2_10_root'";
                                                else
                                                    echo " id='Q2_10_" . $i . "'";
                                                ?> value="<?php echo $VA_Day_Hour_Reluctant_Unknown_single->id; ?>"><?php echo $VA_Day_Hour_Reluctant_Unknown_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select><br/>
                                        <input value="<?php echo $userInfo->Q2_10_DAY_OR_HOUR; ?>" <?php if ($userInfo->Q2_10_DAY_OR_HOUR > 0 == false) echo " style='display:none;'"; ?> type="number" id="Q2_10_off" name="Q2_10_DAY_OR_HOUR" class="form-control">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label><b>2.11</b>&nbsp;প্রসব ব্যথা কত ঘন্টা ছিল?</label>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input value="<?php echo $userInfo->Q2_11; ?>" name="Q2_11" type="text" class="form-control" placeholder="ঘন্টা">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label><b>2.12</b>&nbsp;প্রসব কোথায় হয়েছিল?</label>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <select onchange="showHide(this.id, 'Q2_12_off')" id="Q2_12" class="form-control" name="Q2_12">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php
                                            $i = 1;
                                            foreach ($VA_Delivery_Place as $VA_Delivery_Place_single) {
                                                ?>
                                                <option <?php if ($userInfo->Q2_12 == $VA_Delivery_Place_single->id) echo ' selected'; ?> <?php
                                                if ($VA_Delivery_Place_single->code == 11)
                                                    echo " id='Q2_12_root'";
                                                else
                                                    echo " id='Q2_12_" . $i . "'";
                                                ?> value="<?php echo $VA_Delivery_Place_single->id; ?>"><?php echo $VA_Delivery_Place_single->name; ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                        </select><br/>
                                        <input value="<?php echo $userInfo->Q2_12_OTHER; ?>" <?php if (strlen($userInfo->Q2_12_OTHER) > 0 == false) echo " style='display:none;'"; ?> id="Q2_12_off" type="text" name="Q2_12_OTHER" class="form-control">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label><b>2.13</b>&nbsp;স্বাস্থ্য সেবা প্রতিষ্ঠানে প্রসব হলে তার নাম ও ঠিকানা লিখুন</label>
                                        <textarea name="Q2_13" class="form-control"><?php echo $userInfo->Q2_13; ?></textarea>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label><b>2.14</b>&nbsp;ডেলিভারী করাতে কে প্রধান ভূমিকায় ছিলেন? (নাম ও ঠিকানা)</label>
                                        <textarea name="Q2_14" class="form-control"><?php echo $userInfo->Q2_14; ?></textarea>
                                    </div>

                                    <div class="col-md-12">
                                        <h4 style="text-align: center;font-weight: bold;">
                                            উত্তর দাতাকে সহযোগিতার জন্য ধন্যবাদ জানান
                                        </h4>
                                    </div>
                                    <div class="col-md-12">
                                        <label>সাক্ষাৎকার গ্রহনকারীর মন্তব্য এবং পর্যবেক্ষনঃ</label>
                                        <textarea name="Q2_14_comment" style="resize: none;" class="form-control"><?php echo $userInfo->Q2_14_comment; ?></textarea>
                                    </div>

                                    <?php
                                    if ($userInfo->Q2_14_DOE == "") {
                                        $userInfo->Q2_14_DOE = "1900-01-01";
                                    }

                                    $partsRequire = explode('-', $userInfo->Q2_14_DOE);
                                    $Q2_14_DOE = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];
                                    ?>

                                    <div class="col-md-6">
                                        <label>Date of editing questionnaire </label>
                                        <input value="<?php if ($userInfo->Q2_14_DOE != "1900-01-01") echo $Q2_14_DOE; ?>" name="Q2_14_DOE" type="text" class="datepicker form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Supervisor</label>
                                        <select name="Q2_14_SUP_CODE" class="form-control">
                                            <option id="0" value="">নির্বাচন করুন</option>
                                            <?php foreach ($VA_Supervisor_List as $VA_Supervisor_List_single) { ?>
                                                <option <?php if ($userInfo->Q2_14_SUP_CODE == $VA_Supervisor_List_single->id) echo ' selected'; ?> value="<?php echo $VA_Supervisor_List_single->id; ?>"><?php echo $VA_Supervisor_List_single->name; ?></option>
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
    </section>
    <script src="<?php echo base_url(); ?>assets/js/StillBirthJS.js"></script>
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
    </script>
</div>