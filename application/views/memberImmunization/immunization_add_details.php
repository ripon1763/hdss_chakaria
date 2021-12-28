
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


<form action="<?php echo base_url() . 'memberImmunization/addImmunizationDetails?baseID=' . $baseID ?>" id="myForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8">

    <!-- SmartWizard html -->



    <div id="immunization" style="padding-left: 20px; padding-right: 20px">
        <h4>Immunization Details</h4>
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
                        <?php echo $member_code . '-' . $member_name ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="followup_exit_date">শিশুর বহিরাগমনের তারিখ<span style="color:red">*</span></label>
                        <input autocomplete="off" type="text" class="form-control date_format"  name="followup_exit_date" required>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="folowup_exit_round">কততম রাউন্ডে শিশুর বহিরাগমন হয়েছে?<span style="color:red">*</span></label>
                        <input type="text" class="form-control allowInteger" name="folowup_exit_round" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="Q20">টিকা কার্ডটি কি আছে?<span style="color:red">*</span></label>
                        <select class="form-control" id="Q20" name="Q20" required>
                            <option value="">Please Select</option>
                            <?php
                            if (!empty($yes_no)) {
                                foreach ($yes_no as $yes_no_single) {
                                    ?>
                                    <option value="<?php echo $yes_no_single->id ?>"><?php echo $yes_no_single->code . '-' . $yes_no_single->name ?></option>
                                    <?php
                                }
                            }
                            ?>

                        </select>
                    </div>
                </div>
                <div class="col-md-4 Q20_yes_part">
                    <div class="form-group">
                        <label for="Q21">টিকার কার্ডটি দেখেছেন কি?<span style="color:red">*</span></label>
                        <select class="form-control" id="Q21" name="Q21">
                            <option value="">Please Select</option>
                            <?php
                            if (!empty($yes_no)) {
                                foreach ($yes_no as $yes_no_single) {
                                    ?>
                                    <option value="<?php echo $yes_no_single->id ?>"><?php echo $yes_no_single->code . '-' . $yes_no_single->name ?></option>
                                    <?php
                                }
                            }
                            ?>
 
                        </select>
                    </div>
                </div>

                <div class="col-md-4 Q21_no_part">
                    <div class="form-group">
                        <label for="Q22">কেন টিকার কার্ডটি দেখেননি?<span style="color:red">*</span></label>
                        <select class="form-control" id="Q22" name="Q22">
                            <option value="">Please Select</option>
                            <?php
                            if (!empty($why_not_seen_card)) {
                                foreach ($why_not_seen_card as $why_not_seen_card_single) {
                                    ?>
                                    <option value="<?php echo $why_not_seen_card_single->id ?>"><?php echo $why_not_seen_card_single->code . '-' . $why_not_seen_card_single->name ?></option>
                                    <?php
                                }
                            }
                            ?>

                        </select>
                    </div>
                </div>
                <div class="col-md-4 Q22OTH_part">
                    <div class="form-group">
                        <label for="Q22OTH">নির্দিষ্ট করুন<span style="color:red">*</span></label>
                        <input type="text" class="form-control" id="Q22OTH" name="Q22OTH">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="CH1">বাচ্চাটিকে কোন টিকা দেওয়া হয়েছিল কি?<span style="color:red">*</span></label>
                        <select class="form-control" id="CH1" name="CH1" required>
                            <option value="">Please Select</option>
                            <?php
                            if (!empty($yes_no)) {
                                foreach ($yes_no as $yes_no_single) {
                                    ?>
                                    <option value="<?php echo $yes_no_single->id ?>"><?php echo $yes_no_single->code . '-' . $yes_no_single->name ?></option>
                                    <?php
                                }
                            }
                            ?>

                        </select>
                    </div>
                </div>
            </div>
            <fieldset class="scheduler-border CH1_yes_part">
                <legend class="scheduler-border">যদি হ্যাঁ হয়, তবে নিম্নের কোন টিকা দেওয়া হয়েছে?</legend>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="BCG">বিসিজি</label>
                            <input autocomplete="off" type="text" class="form-control date_format"  name="BCG">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="BCGFROM">টিকার তথ্যের উৎস</label>
                            <select class="form-control" id="BCGFROM" name="BCGFROM">
                                <option value="">Please Select</option>
                                <?php
                                if (!empty($information_recorded_from)) {
                                    foreach ($information_recorded_from as $information_recorded_from_single) {
                                        ?>
                                        <option value="<?php echo $information_recorded_from_single->id ?>"><?php echo $information_recorded_from_single->code . '-' . $information_recorded_from_single->name ?></option>
                                        <?php
                                    }
                                }
                                ?>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">

                            <label for="BCGOTH">যদি না দিয়ে থাকে, তবে কেন দেওয়া হয়নি</label>
                            <input type="text" class="form-control" id="BCGOTH"  name="BCGOTH">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="PENTA1">পেন্টা-১ (ডিপিটি,হেপা-বি,হিব)</label>
                            <input autocomplete="off" type="text" class="form-control date_format"  name="PENTA1">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="PENTA1FROM">টিকার তথ্যের উৎস</label>
                            <select class="form-control" id="PENTA1FROM" name="PENTA1FROM">
                                <option value="">Please Select</option>
                                <?php
                                if (!empty($information_recorded_from)) {
                                    foreach ($information_recorded_from as $information_recorded_from_single) {
                                        ?>
                                        <option value="<?php echo $information_recorded_from_single->id ?>"><?php echo $information_recorded_from_single->code . '-' . $information_recorded_from_single->name ?></option>
                                        <?php
                                    }
                                }
                                ?>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">

                            <label for="PENTA1OTH">যদি না দিয়ে থাকে, তবে কেন দেওয়া হয়নি</label>
                            <input type="text" class="form-control" id="PENTA1OTH"  name="PENTA1OTH">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="PENTA2">পেন্টা-২ (ডিপিটি,হেপা-বি,হিব)</label>
                            <input autocomplete="off" type="text" class="form-control date_format"  name="PENTA2">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="PENTA2FROM">টিকার তথ্যের উৎস</label>
                            <select class="form-control" id="PENTA2FROM" name="PENTA2FROM">
                                <option value="">Please Select</option>
                                <?php
                                if (!empty($information_recorded_from)) {
                                    foreach ($information_recorded_from as $information_recorded_from_single) {
                                        ?>
                                        <option value="<?php echo $information_recorded_from_single->id ?>"><?php echo $information_recorded_from_single->code . '-' . $information_recorded_from_single->name ?></option>
                                        <?php
                                    }
                                }
                                ?>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">

                            <label for="PENTA2OTH">যদি না দিয়ে থাকে, তবে কেন দেওয়া হয়নি</label>
                            <input type="text" class="form-control" id="PENTA2OTH"  name="PENTA2OTH">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="PENTA3">পেন্টা-৩ (ডিপিটি,হেপা-বি,হিব)</label>
                            <input autocomplete="off" type="text" class="form-control date_format"  name="PENTA3">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="PENTA3FROM">টিকার তথ্যের উৎস</label>
                            <select class="form-control" id="PENTA3FROM" name="PENTA3FROM">
                                <option value="">Please Select</option>
                                <?php
                                if (!empty($information_recorded_from)) {
                                    foreach ($information_recorded_from as $information_recorded_from_single) {
                                        ?>
                                        <option value="<?php echo $information_recorded_from_single->id ?>"><?php echo $information_recorded_from_single->code . '-' . $information_recorded_from_single->name ?></option>
                                        <?php
                                    }
                                }
                                ?>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">

                            <label for="PENTA3OTH">যদি না দিয়ে থাকে, তবে কেন দেওয়া হয়নি</label>
                            <input type="text" class="form-control" id="PENTA3OTH"  name="PENTA3OTH">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="PCV1">পিসিভি-১</label>
                            <input autocomplete="off" type="text" class="form-control date_format"  name="PCV1">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="PCV1FROM">টিকার তথ্যের উৎস</label>
                            <select class="form-control" id="PCV1FROM" name="PCV1FROM">
                                <option value="">Please Select</option>
                                <?php
                                if (!empty($information_recorded_from)) {
                                    foreach ($information_recorded_from as $information_recorded_from_single) {
                                        ?>
                                        <option value="<?php echo $information_recorded_from_single->id ?>"><?php echo $information_recorded_from_single->code . '-' . $information_recorded_from_single->name ?></option>
                                        <?php
                                    }
                                }
                                ?>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">

                            <label for="PCV1OTH">যদি না দিয়ে থাকে, তবে কেন দেওয়া হয়নি</label>
                            <input type="text" class="form-control" id="PCV1OTH"  name="PCV1OTH">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="PCV2">পিসিভি-২</label>
                            <input autocomplete="off" type="text" class="form-control date_format"  name="PCV2" >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="PCV2FROM">টিকার তথ্যের উৎস</label>
                            <select class="form-control" id="PCV2FROM" name="PCV2FROM">
                                <option value="">Please Select</option>
                                <?php
                                if (!empty($information_recorded_from)) {
                                    foreach ($information_recorded_from as $information_recorded_from_single) {
                                        ?>
                                        <option value="<?php echo $information_recorded_from_single->id ?>"><?php echo $information_recorded_from_single->code . '-' . $information_recorded_from_single->name ?></option>
                                        <?php
                                    }
                                }
                                ?>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">

                            <label for="PCV2OTH">যদি না দিয়ে থাকে, তবে কেন দেওয়া হয়নি</label>
                            <input type="text" class="form-control" id="PCV2OTH"  name="PCV2OTH">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="PPV3">পিসিভি-৩</label>
                            <input autocomplete="off" type="text" class="form-control date_format"  name="PPV3" >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="PPV3FROM">টিকার তথ্যের উৎস</label>
                            <select class="form-control" id="PPV3FROM" name="PPV3FROM">
                                <option value="">Please Select</option>
                                <?php
                                if (!empty($information_recorded_from)) {
                                    foreach ($information_recorded_from as $information_recorded_from_single) {
                                        ?>
                                        <option value="<?php echo $information_recorded_from_single->id ?>"><?php echo $information_recorded_from_single->code . '-' . $information_recorded_from_single->name ?></option>
                                        <?php
                                    }
                                }
                                ?>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">

                            <label for="PPV3OTH">যদি না দিয়ে থাকে, তবে কেন দেওয়া হয়নি</label>
                            <input type="text" class="form-control" id="PPV3OTH"  name="PPV3OTH">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="OPV1">ওপিভি-১</label>
                            <input autocomplete="off" type="text" class="form-control date_format"  name="OPV1" >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="OPV1FROM">টিকার তথ্যের উৎস</label>
                            <select class="form-control" id="OPV1FROM" name="OPV1FROM">
                                <option value="">Please Select</option>
                                <?php
                                if (!empty($information_recorded_from)) {
                                    foreach ($information_recorded_from as $information_recorded_from_single) {
                                        ?>
                                        <option value="<?php echo $information_recorded_from_single->id ?>"><?php echo $information_recorded_from_single->code . '-' . $information_recorded_from_single->name ?></option>
                                        <?php
                                    }
                                }
                                ?>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">

                            <label for="OPV1OTH">যদি না দিয়ে থাকে, তবে কেন দেওয়া হয়নি</label>
                            <input type="text" class="form-control" id="OPV1OTH"  name="OPV1OTH">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="OPV2">ওপিভি-২</label>
                            <input autocomplete="off" type="text" class="form-control date_format"  name="OPV2">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="OPV2FROM">টিকার তথ্যের উৎস</label>
                            <select class="form-control" id="OPV2FROM" name="OPV2FROM">
                                <option value="">Please Select</option>
                                <?php
                                if (!empty($information_recorded_from)) {
                                    foreach ($information_recorded_from as $information_recorded_from_single) {
                                        ?>
                                        <option value="<?php echo $information_recorded_from_single->id ?>"><?php echo $information_recorded_from_single->code . '-' . $information_recorded_from_single->name ?></option>
                                        <?php
                                    }
                                }
                                ?>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">

                            <label for="OPV2OTH">যদি না দিয়ে থাকে, তবে কেন দেওয়া হয়নি</label>
                            <input type="text" class="form-control" id="OPV2OTH"  name="OPV2OTH">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="OPV3">ওপিভি-৩</label>
                            <input autocomplete="off" type="text" class="form-control date_format"  name="OPV3" >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="OPV3FROM">টিকার তথ্যের উৎস</label>
                            <select class="form-control" id="OPV3FROM" name="OPV3FROM">
                                <option value="">Please Select</option>
                                <?php
                                if (!empty($information_recorded_from)) {
                                    foreach ($information_recorded_from as $information_recorded_from_single) {
                                        ?>
                                        <option value="<?php echo $information_recorded_from_single->id ?>"><?php echo $information_recorded_from_single->code . '-' . $information_recorded_from_single->name ?></option>
                                        <?php
                                    }
                                }
                                ?>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">

                            <label for="OPV3OTH">যদি না দিয়ে থাকে, তবে কেন দেওয়া হয়নি</label>
                            <input type="text" class="form-control" id="OPV3OTH"  name="OPV3OTH">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="MR1">এমআর (১ম ডোজ)</label>
                            <input autocomplete="off" type="text" class="form-control date_format"  name="MR1" >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="MR1FROM">টিকার তথ্যের উৎস</label>
                            <select class="form-control" id="MR1FROM" name="MR1FROM">
                                <option value="">Please Select</option>
                                <?php
                                if (!empty($information_recorded_from)) {
                                    foreach ($information_recorded_from as $information_recorded_from_single) {
                                        ?>
                                        <option value="<?php echo $information_recorded_from_single->id ?>"><?php echo $information_recorded_from_single->code . '-' . $information_recorded_from_single->name ?></option>
                                        <?php
                                    }
                                }
                                ?>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">

                            <label for="MR1OTH">যদি না দিয়ে থাকে, তবে কেন দেওয়া হয়নি</label>
                            <input type="text" class="form-control" id="MR1OTH"  name="MR1OTH">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="MR2">এমআর (২য় ডোজ)</label>
                            <input autocomplete="off" type="text" class="form-control date_format"  name="MR2" >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="MR2FROM">টিকার তথ্যের উৎস</label>
                            <select class="form-control" id="MR2FROM" name="MR2FROM">
                                <option value="">Please Select</option>
                                <?php
                                if (!empty($information_recorded_from)) {
                                    foreach ($information_recorded_from as $information_recorded_from_single) {
                                        ?>
                                        <option value="<?php echo $information_recorded_from_single->id ?>"><?php echo $information_recorded_from_single->code . '-' . $information_recorded_from_single->name ?></option>
                                        <?php
                                    }
                                }
                                ?>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">

                            <label for="MR2OTH">যদি না দিয়ে থাকে, তবে কেন দেওয়া হয়নি</label>
                            <input type="text" class="form-control" id="MR2OTH"  name="MR2OTH">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="VITA1">ভিটামিন-এ (১ম ডোজ)</label>
                            <input autocomplete="off" type="text" class="form-control date_format"  name="VITA1" >
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="VITA1FROM">টিকার তথ্যের উৎস</label>
                            <select class="form-control" id="VITA1FROM" name="VITA1FROM">
                                <option value="">Please Select</option>
                                <?php
                                if (!empty($information_recorded_from)) {
                                    foreach ($information_recorded_from as $information_recorded_from_single) {
                                        ?>
                                        <option value="<?php echo $information_recorded_from_single->id ?>"><?php echo $information_recorded_from_single->code . '-' . $information_recorded_from_single->name ?></option>
                                        <?php
                                    }
                                }
                                ?>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">

                            <label for="VITA1OTH">যদি না দিয়ে থাকে, তবে কেন দেওয়া হয়নি</label>
                            <input type="text" class="form-control" id="VITA1OTH"  name="VITA1OTH">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="VITA2">ভিটামিন-এ (২য় ডোজ)</label>
                            <input autocomplete="off" type="text" class="form-control date_format"  name="VITA2" >
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="VITA2FROM">টিকার তথ্যের উৎস</label>
                            <select class="form-control" id="VITA2FROM" name="VITA2FROM">
                                <option value="">Please Select</option>
                                <?php
                                if (!empty($information_recorded_from)) {
                                    foreach ($information_recorded_from as $information_recorded_from_single) {
                                        ?>
                                        <option value="<?php echo $information_recorded_from_single->id ?>"><?php echo $information_recorded_from_single->code . '-' . $information_recorded_from_single->name ?></option>
                                        <?php
                                    }
                                }
                                ?>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">

                            <label for="VITA2OTH">যদি না দিয়ে থাকে, তবে কেন দেওয়া হয়নি</label>
                            <input type="text" class="form-control" id="VITA2OTH"  name="VITA2OTH">
                        </div>
                    </div>
                </div>
            </fieldset>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="interview_status">ইন্টারভিউ স্ট্যাটাস<span style="color:red">*</span></label>
                        <select class="form-control" id="interview_status" name="interview_status" required>
                            <option value="">Please Select</option>
                            <?php
                            if (!empty($interview_status_immunization)) {
                                foreach ($interview_status_immunization as $interview_status_immunization_single) {
                                    ?>
                                    <option value="<?php echo $interview_status_immunization_single->id ?>"><?php echo $interview_status_immunization_single->code . '-' . $interview_status_immunization_single->name ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <div class="box-footer" style="margin-left: 10px">
        <input type="hidden" name="household_master_id_sub" value="<?php echo $household_master_id_sub ?>">
        <input type="hidden" name="round_master_id" value="<?php echo $round_master_id ?>">
        <input type="hidden" name="member_master_id" value="<?php echo $member_master_id ?>">
        <input type="submit" class="btn btn-primary btnVisile" name="submit" value="Save" />
        <a class="btn btn-primary" href="<?php echo base_url() . 'householdvisit/immunization?baseID=' . $baseID . '#immunization' ?>" class="">Back </a>

    </div>




</form>




</div><!-- /.box-body -->
</div><!-- /.box -->
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

    $("#Q22").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");

            if (optionValue == 436)
            {
                $("#Q22OTH").prop('required', true);
                $(".Q22OTH_part").show();
            } else {
                $("#Q22OTH").prop('required', false);
                $(".Q22OTH_part").hide();
            }


        });
    }).change();

    $("#Q20").change(function () {

        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");

            if (optionValue == 1)
            {
                $("#Q21").prop('required', true);
                $(".Q20_yes_part").show();
            } else {
                $("#Q21").prop('required', false);
                $(".Q20_yes_part").hide();
                $('#Q21').val('').trigger('change');
            }

            


        });
    }).change();
    $("#Q21").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");

            if (optionValue == 1)
            {
                $("#Q22").prop('required', false);
                $(".Q21_no_part").hide();
				$('#Q22').val('').trigger('change');
				
            } else if (optionValue == 4) {
                
				
				$("#Q22").prop('required', true);
                $(".Q21_no_part").show();
               
            }
			else 
			{
				$("#Q22").prop('required', false);
                $(".Q21_no_part").hide();
				$('#Q22').val('').trigger('change');
			}

            

        });
    }).change();

    $("#CH1").change(function () {
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");

            if (optionValue == 1)
            {
                $(".CH1_yes_part").show();
            } else {
                $(".CH1_yes_part").hide();
            }

        });
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

