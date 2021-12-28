
<?php $baseID = $this->input->get('baseID', TRUE); ?>
<?php
$id = 0;
$fk_owner_land = 0;
$fk_owner_house = 0;
$fk_chair = 0;
$fk_dining_table = 0;
$fk_khat = 0;
$fk_chowki = 0;
$fk_almirah = 0;
$fk_sofa = 0;
$fk_radio = 0;
$fk_tv = 0;
$fk_freeze = 0;
$fk_mobile = 0;
$fk_electric_fan = 0;
$fk_hand_watch = 0;
$fk_rickshow = 0;
$fk_computer = 0;
$fk_sewing_machine = 0;
$fk_cycle = 0;
$fk_motor_cycle = 0;

if (!empty($assetrecord)) {

    $id = $assetrecord[0]->id;
    $fk_owner_land = $assetrecord[0]->fk_owner_land;
    $fk_owner_house = $assetrecord[0]->fk_owner_house;
    $fk_chair = $assetrecord[0]->fk_chair;
    $fk_dining_table = $assetrecord[0]->fk_dining_table;
    $fk_khat = $assetrecord[0]->fk_khat;
    $fk_chowki = $assetrecord[0]->fk_chowki;
    $fk_almirah = $assetrecord[0]->fk_almirah;
    $fk_sofa = $assetrecord[0]->fk_sofa;
    $fk_radio = $assetrecord[0]->fk_radio;
    $fk_tv = $assetrecord[0]->fk_tv;
    $fk_freeze = $assetrecord[0]->fk_freeze;
    $fk_mobile = $assetrecord[0]->fk_mobile;
    $fk_electric_fan = $assetrecord[0]->fk_electric_fan;
    $fk_hand_watch = $assetrecord[0]->fk_hand_watch;
    $fk_rickshow = $assetrecord[0]->fk_rickshow;
    $fk_computer = $assetrecord[0]->fk_computer;
    $fk_sewing_machine = $assetrecord[0]->fk_sewing_machine;
    $fk_cycle = $assetrecord[0]->fk_cycle;
    $fk_motor_cycle = $assetrecord[0]->fk_motor_cycle;
}
?>

<form action="<?php echo base_url() . 'Baseline_census/editAssetDetails?baseID=' . $baseID ?>" id="myForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8">

    <!-- SmartWizard html -->



    <div id="asset" style="padding-left: 20px; padding-right: 20px">
        <h4>Household Asset Details</h4>
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

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="email">এই জমির মালিক কে? <span style="color:red">*</span></label>

                        <select name="fk_owner_land" id="fk_owner_land" class="form-control" required style="">
                            <option value="">Please Select</option>
                            <?php
                            if (!empty($land_owner)) {
                                foreach ($land_owner as $land) {
                                    ?>
                                    <option <?php
                                    if ($land->id == $fk_owner_land) {
                                        echo "selected=selected";
                                    }
                                    ?> value="<?php echo $land->id ?>"><?php echo $land->code.'-'.$land->name ?></option>

                                    <?php
                                }
                            }
                            ?>
                        </select>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="email">এই ঘরের মালিক কে ? <span style="color:red">*</span></label>

                        <select name="fk_owner_house" id="fk_owner_house" class="form-control" required style="">
                            <option value="">Please Select</option>
                            <?php
                            if (!empty($house_owner)) {
                                foreach ($house_owner as $house) {
                                    ?>
                                    <option <?php
                                    if ($house->id == $fk_owner_house) {
                                        echo "selected=selected";
                                    }
                                    ?> value="<?php echo $house->id ?>"><?php echo $house->code.'-'.$house->name ?></option>

                                    <?php
                                }
                            }
                            ?>
                        </select>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="email">চেয়ার <span style="color:red">*</span></label>

                        <select name="fk_chair" id="fk_chair" class="form-control" required style="">
                            <option value="">Please Select</option>
                            <?php
                            if (!empty($assetYesNo)) {
                                foreach ($assetYesNo as $chair) {
                                    ?>
                                    <option <?php
                                    if ($chair->id == $fk_chair) {
                                        echo "selected=selected";
                                    }
                                    ?> value="<?php echo $chair->id ?>"><?php echo $chair->code.'-'.$chair->name ?></option>

                                    <?php
                                }
                            }
                            ?>
                        </select>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="email">খাবার টেবিল <span style="color:red">*</span></label>

                        <select name="fk_dining_table" id="fk_dining_table" class="form-control" required style="">
                            <option value="">Please Select</option>
                            <?php
                            if (!empty($assetYesNo)) {
                                foreach ($assetYesNo as $table) {
                                    ?>
                                    <option <?php
                                    if ($table->id == $fk_dining_table) {
                                        echo "selected=selected";
                                    }
                                    ?> value="<?php echo $table->id ?>"><?php echo $table->code.'-'.$table->name ?></option>

                                    <?php
                                }
                            }
                            ?>
                        </select>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="email">খাট  <span style="color:red">*</span></label>

                        <select name="fk_khat" id="fk_khat" class="form-control" required style="">
                            <option value="">Please Select</option>
                            <?php
                            if (!empty($assetYesNo)) {
                                foreach ($assetYesNo as $khat) {
                                    ?>
                                    <option <?php
                                    if ($khat->id == $fk_khat) {
                                        echo "selected=selected";
                                    }
                                    ?> value="<?php echo $khat->id ?>"><?php echo $khat->code.'-'.$khat->name ?></option>

                                    <?php
                                }
                            }
                            ?>
                        </select>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="email">চৌকি <span style="color:red">*</span></label>

                        <select name="fk_chowki" id="fk_chowki" class="form-control" required style="">
                            <option value="">Please Select</option>
                            <?php
                            if (!empty($assetYesNo)) {
                                foreach ($assetYesNo as $chowki) {
                                    ?>
                                    <option <?php
                                    if ($chowki->id == $fk_chowki) {
                                        echo "selected=selected";
                                    }
                                    ?> value="<?php echo $chowki->id ?>"><?php echo $chowki->code.'-'.$chowki->name ?></option>

                                    <?php
                                }
                            }
                            ?>
                        </select>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="email">আলমারি <span style="color:red">*</span></label>

                        <select name="fk_almirah" id="fk_almirah" class="form-control" required style="">
                            <option value="">Please Select</option>
                            <?php
                            if (!empty($assetYesNo)) {
                                foreach ($assetYesNo as $almirah) {
                                    ?>
                                    <option <?php
                                    if ($almirah->id == $fk_almirah) {
                                        echo "selected=selected";
                                    }
                                    ?> value="<?php echo $almirah->id ?>"><?php echo $almirah->code.'-'.$almirah->name ?></option>

                                    <?php
                                }
                            }
                            ?>
                        </select>

                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="email">সোফা সেট <span style="color:red">*</span></label>

                        <select name="fk_sofa" id="fk_sofa" class="form-control" required style="">
                            <option value="">Please Select</option>
                            <?php
                            if (!empty($assetYesNo)) {
                                foreach ($assetYesNo as $sofa) {
                                    ?>
                                    <option <?php
                                    if ($sofa->id == $fk_sofa) {
                                        echo "selected=selected";
                                    }
                                    ?> value="<?php echo $sofa->id ?>"><?php echo $sofa->code.'-'.$sofa->name ?></option>

                                    <?php
                                }
                            }
                            ?>
                        </select>

                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="email">রেডিও  <span style="color:red">*</span></label>

                        <select name="fk_radio" id="fk_radio" class="form-control" required style="">
                            <option value="">Please Select</option>
                            <?php
                            if (!empty($assetYesNo)) {
                                foreach ($assetYesNo as $radio) {
                                    ?>
                                    <option <?php
                                    if ($radio->id == $fk_radio) {
                                        echo "selected=selected";
                                    }
                                    ?> value="<?php echo $radio->id ?>"><?php echo $radio->code.'-'.$radio->name ?></option>

                                    <?php
                                }
                            }
                            ?>
                        </select>

                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="email">টেলিভিশন <span style="color:red">*</span></label>

                        <select name="fk_tv" id="fk_tv" class="form-control" required style="">
                            <option value="">Please Select</option>
                            <?php
                            if (!empty($assetYesNo)) {
                                foreach ($assetYesNo as $tv) {
                                    ?>
                                    <option <?php
                                    if ($tv->id == $fk_tv) {
                                        echo "selected=selected";
                                    }
                                    ?> value="<?php echo $tv->id ?>"><?php echo $tv->code.'-'.$tv->name ?></option>

                                    <?php
                                }
                            }
                            ?>
                        </select>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="email">রেফ্রিজারেটর / ফ্রিজ <span style="color:red">*</span></label>

                        <select name="fk_freeze" id="fk_freeze" class="form-control" required style="">
                            <option value="">Please Select</option>
                            <?php
                            if (!empty($assetYesNo)) {
                                foreach ($assetYesNo as $freeze) {
                                    ?>
                                    <option <?php
                                    if ($freeze->id == $fk_freeze) {
                                        echo "selected=selected";
                                    }
                                    ?>  value="<?php echo $freeze->id ?>"><?php echo $freeze->code.'-'.$freeze->name ?></option>

                                    <?php
                                }
                            }
                            ?>
                        </select>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="email">মোবাইল <span style="color:red">*</span></label>

                        <select name="fk_mobile" id="fk_mobile" class="form-control" required style="">
                            <option value="">Please Select</option>
                            <?php
                            if (!empty($assetYesNo)) {
                                foreach ($assetYesNo as $mobile) {
                                    ?>
                                    <option <?php
                                    if ($mobile->id == $fk_mobile) {
                                        echo "selected=selected";
                                    }
                                    ?>  value="<?php echo $mobile->id ?>"><?php echo $mobile->code.'-'.$mobile->name ?></option>

                                    <?php
                                }
                            }
                            ?>
                        </select>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="email">বৈদ্যুতিক ফ্যান <span style="color:red">*</span></label>

                        <select name="fk_electric_fan" id="fk_electric_fan" class="form-control" required style="">
                            <option value="">Please Select</option>
                            <?php
                            if (!empty($assetYesNo)) {
                                foreach ($assetYesNo as $fan) {
                                    ?>
                                    <option  <?php
                                    if ($fan->id == $fk_electric_fan) {
                                        echo "selected=selected";
                                    }
                                    ?> value="<?php echo $fan->id ?>"><?php echo $fan->code.'-'.$fan->name ?></option>

                                    <?php
                                }
                            }
                            ?>
                        </select>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="email">হাত /ওয়াল ঘড়ি <span style="color:red">*</span></label>

                        <select name="fk_hand_watch" id="fk_hand_watch" class="form-control" required style="">
                            <option value="">Please Select</option>
                            <?php
                            if (!empty($assetYesNo)) {
                                foreach ($assetYesNo as $watch) {
                                    ?>
                                    <option <?php
                                    if ($watch->id == $fk_hand_watch) {
                                        echo "selected=selected";
                                    }
                                    ?>  value="<?php echo $watch->id ?>"><?php echo $watch->code.'-'.$watch->name ?></option>

                                    <?php
                                }
                            }
                            ?>
                        </select>

                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="email">রিকশা/ভ্যান <span style="color:red">*</span></label>

                        <select name="fk_rickshow" id="fk_rickshow" class="form-control" required style="">
                            <option value="">Please Select</option>
                            <?php
                            if (!empty($assetYesNo)) {
                                foreach ($assetYesNo as $rickshow) {
                                    ?>
                                    <option <?php
                                    if ($rickshow->id == $fk_rickshow) {
                                        echo "selected=selected";
                                    }
                                    ?> value="<?php echo $rickshow->id ?>"><?php echo $rickshow->code.'-'.$rickshow->name ?></option>

                                    <?php
                                }
                            }
                            ?>
                        </select>

                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="email">কম্পিউটার/ল্যাপটপ  <span style="color:red">*</span></label>

                        <select name="fk_computer" id="fk_computer" class="form-control" required style="">
                            <option value="">Please Select</option>
                            <?php
                            if (!empty($assetYesNo)) {
                                foreach ($assetYesNo as $computer) {
                                    ?>
                                    <option <?php
                                    if ($computer->id == $fk_computer) {
                                        echo "selected=selected";
                                    }
                                    ?> value="<?php echo $computer->id ?>"><?php echo $computer->code.'-'.$computer->name ?></option>

                                    <?php
                                }
                            }
                            ?>
                        </select>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="email">সেলাই মেশিন <span style="color:red">*</span></label>

                        <select name="fk_sewing_machine" id="fk_sewing_machine" class="form-control" required style="">
                            <option value="">Please Select</option>
                            <?php
                            if (!empty($assetYesNo)) {
                                foreach ($assetYesNo as $machine) {
                                    ?>
                                    <option <?php
                                    if ($machine->id == $fk_sewing_machine) {
                                        echo "selected=selected";
                                    }
                                    ?>  value="<?php echo $machine->id ?>"><?php echo $machine->code.'-'.$machine->name ?></option>

                                    <?php
                                }
                            }
                            ?>
                        </select>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="email">সাইকেল <span style="color:red">*</span></label>

                        <select name="fk_cycle" id="fk_cycle" class="form-control" required style="">
                            <option value="">Please Select</option>
                            <?php
                            if (!empty($assetYesNo)) {
                                foreach ($assetYesNo as $cycle) {
                                    ?>
                                    <option <?php
                                    if ($cycle->id == $fk_cycle) {
                                        echo "selected=selected";
                                    }
                                    ?>  value="<?php echo $cycle->id ?>"><?php echo $cycle->code.'-'.$cycle->name ?></option>

                                    <?php
                                }
                            }
                            ?>
                        </select>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="email">মটর সাইকেল <span style="color:red">*</span></label>

                        <select name="fk_motor_cycle" id="fk_motor_cycle" class="form-control" required style="">
                            <option value="">Please Select</option>
                            <?php
                            if (!empty($assetYesNo)) {
                                foreach ($assetYesNo as $motor_cycle) {
                                    ?>
                                    <option <?php
                                    if ($motor_cycle->id == $fk_motor_cycle) {
                                        echo "selected=selected";
                                    }
                                    ?>  value="<?php echo $motor_cycle->id ?>"><?php echo $motor_cycle->code.'-'.$motor_cycle->name ?></option>

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


    <?php if ($id > 0) { ?>

        <div class="box-footer" style="margin-left: 10px">
            <input type="hidden" name="household_master_id_sub" value="<?php echo $household_master_id_sub ?>">
            <input type="hidden" name="round_master_id" value="<?php echo $round_master_id ?>">
            <input type="hidden" name="assetID" value="<?php echo $id ?>">
            <input type="submit" class="btn btn-primary btnVisile" name="submit" value="Save" />
            <a class="btn btn-primary" href="<?php echo base_url() . 'Baseline_census/baseline_census_info?baseID=' . $baseID . '#baseline_census_info' ?>" class="">Back </a>

        </div>

    <?php } ?>



</form>




</div><!-- /.box-body -->
</div><!-- /.box -->
</div>
</div>
</section>
</div>

