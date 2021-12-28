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
                    <a class="btn btn-primary" href="<?php echo base_url() . $controller . '/pregnancy?baseID=' . $baseID ?>"><?php echo $shortName ?> List</a>
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
                        <input type="hidden" name="pregnancyID" value="<?php echo $pregnancy_info->id; ?>">
                        <input type="hidden" name="conceptionID" value="<?php echo $pregnancy_info->conceptionID; ?>">
                        <input type="hidden" name="member_master_id" value="<?php echo $pregnancy_info->member_master_id; ?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <b>Household Code:</b> <?php echo $pregnancy_info->household_code; ?>
                                </div>
                                <div class="col-md-3 form-group">
                                    <b>Round No:</b> <?php echo $pregnancy_info->round_master_id; ?>
                                </div>
                                <div class="col-md-3 form-group">
                                    <b>Member Code:</b> <?php echo $pregnancy_info->member_code; ?>
                                </div>
                                <div class="col-md-3 form-group">
                                    <b>Member Name:</b> <?php echo $pregnancy_info->member_name; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <b>Member Sex:</b> <?php echo $pregnancy_info->gender_code . '-' . $pregnancy_info->gender_name; ?>
                                </div>
                                <div class="col-md-3 form-group">
                                    <b>Conception Date:</b> <?php echo $pregnancy_info->household_code; ?>
                                </div>
                                <div class="col-md-3 form-group">
                                    <b>Conception Order:</b> <?php echo $pregnancy_info->round_master_id; ?>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Item Name">Preg outcome date <span style="color:red">*</span></label>

                                        <?php
                                        if ($pregnancy_info->pregnancy_outcome_date != "") {
                                            $partsRequire = explode('-', $pregnancy_info->pregnancy_outcome_date);
                                            $pregnancy_outcome_date = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];
                                        }
                                        ?>
                                        <input type="text" class="form-control hhdate" id="conceptionDate" value="<?php if (isset($pregnancy_outcome_date)) echo $pregnancy_outcome_date; ?>"  name="pregnancy_outcome_date" maxlength="255" required >
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label for="Active">Spontaneous abortion <span style="color:red">*</span></label>
                                        <select class="form-control required" id="spontaneous_abortion" name="spontaneous_abortion" required>
                                            <option <?php
                                            if ($pregnancy_info->spontaneous_abortion == 0) {
                                                echo "selected=selected";
                                            }
                                            ?> value="0">0</option>
                                            <option <?php
                                            if ($pregnancy_info->spontaneous_abortion == 1) {
                                                echo "selected=selected";
                                            }
                                            ?> value="1">1</option>


                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label for="Active">Induced abortion <span style="color:red">*</span></label>
                                        <select class="form-control required" id="induced_abortion" name="induced_abortion" required>
                                            <option <?php
                                            if ($pregnancy_info->induced_abortion == 0) {
                                                echo "selected=selected";
                                            }
                                            ?> value="0">0</option>
                                            <option <?php
                                            if ($pregnancy_info->induced_abortion == 1) {
                                                echo "selected=selected";
                                            }
                                            ?> value="1">1</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label for="Active">Still birth <span style="color:red">*</span></label>
                                        <select class="form-control required" id="still_birth" name="still_birth" required>
                                            <option <?php
                                            if ($pregnancy_info->still_birth == 0) {
                                                echo "selected=selected";
                                            }
                                            ?> value="0">0</option>
                                            <option <?php
                                            if ($pregnancy_info->still_birth == 1) {
                                                echo "selected=selected";
                                            }
                                            ?> value="1">1</option>
                                            <option <?php
                                            if ($pregnancy_info->still_birth == 2) {
                                                echo "selected=selected";
                                            }
                                            ?> value="2">2</option>
                                            <option <?php
                                            if ($pregnancy_info->still_birth == 3) {
                                                echo "selected=selected";
                                            }
                                            ?> value="3">3</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label for="Active">Live birth <span style="color:red">*</span></label>
                                        <select class="form-control required" id="live_birth" name="live_birth" required>
                                            <option <?php
                                            if ($pregnancy_info->live_birth == 0) {
                                                echo "selected=selected";
                                            }
                                            ?> value="0">0</option>
                                            <option <?php
                                            if ($pregnancy_info->live_birth == 1) {
                                                echo "selected=selected";
                                            }
                                            ?> value="1">1</option>
                                            <option <?php
                                            if ($pregnancy_info->live_birth == 2) {
                                                echo "selected=selected";
                                            }
                                            ?> value="2">2</option>
                                            <option <?php
                                            if ($pregnancy_info->live_birth == 3) {
                                                echo "selected=selected";
                                            }
                                            ?> value="3">3</option>
                                            <option <?php
                                            if ($pregnancy_info->live_birth == 4) {
                                                echo "selected=selected";
                                            }
                                            ?> value="4">4</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label for="Active">Mode of delivery ? <span style="color:red">*</span></label>
                                        <select class="form-control required" id="fk_delivery_methodology" name="fk_delivery_methodology" required>
                                            <option value="">Please select</option>
                                            <?php
                                            if (!empty($delivery_methodology)) {
                                                foreach ($delivery_methodology as $delivery) {
                                                    ?>
                                                    <option <?php
                                                    if ($pregnancy_info->fk_delivery_methodology == $delivery->id) {
                                                        echo "selected=selected";
                                                    }
                                                    ?> value="<?php echo $delivery->id ?>"><?php echo $delivery->code . '-' . $delivery->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label for="Active">Result of Pregnancy(Pregnancy outcome) <span style="color:red">*</span></label>
                                        <select class="form-control required" id="fk_conception_result" name="fk_conception_result" required>
                                            <option value="">Please select</option>
                                            <?php
                                            if (!empty($pregnancy_result)) {
                                                foreach ($pregnancy_result as $pregnancyrelt) {
                                                    ?>
                                                    <option <?php
                                                    if ($pregnancy_info->fk_conception_result == $pregnancyrelt->id) {
                                                        echo "selected=selected";
                                                    }
                                                    ?> value="<?php echo $pregnancyrelt->id ?>"><?php echo $pregnancyrelt->code . '-' . $pregnancyrelt->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 birthAttended">
                                    <div class="form-group">

                                        <label for="Active">Did you give colostrum to baby? </label>
                                        <select class="form-control required" id="fk_colostrum" name="fk_colostrum">
                                            <option value="0">Please select</option>
                                            <?php
                                            if (!empty($yes_no)) {
                                                foreach ($yes_no as $yes_no) {
                                                    ?>
                                                    <option <?php
                                                    if ($pregnancy_info->fk_colostrum == $yes_no->id) {
                                                        echo "selected=selected";
                                                    }
                                                    ?> value="<?php echo $yes_no->id ?>"><?php echo $yes_no->code . '-' . $yes_no->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 birthAttended">
                                    <div class="form-group">

                                        <label for="Active">How long after birth did you first put baby to the breast? </label>
                                        <select class="form-control required" id="fk_first_milk" name="fk_first_milk">
                                            <option value="0">Please select</option>
                                            <?php
                                            if (!empty($fast_milk_birth)) {
                                                foreach ($fast_milk_birth as $milk_birth) {
                                                    ?>
                                                    <option <?php
                                                    if ($pregnancy_info->fk_first_milk == $milk_birth->id) {
                                                        echo "selected=selected";
                                                    }
                                                    ?> value="<?php echo $milk_birth->id ?>"><?php echo $milk_birth->code . '-' . $milk_birth->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 hours">
                                    <div class="form-group">
                                        <label for="Item Name">Hours (less than 1 hour 00, less than 24 hours then hour) <span style="color:red">*</span></label>
                                        <input type="number" class="form-control milk_hours" id="milk_hours" value="<?php echo $pregnancy_info->milk_hours ?>"  name="milk_hours">
                                    </div>
                                </div>

                                <div class="col-md-4 days">
                                    <div class="form-group">
                                        <label for="Item Name">Day <span style="color:red">*</span></label>
                                        <input type="number" class="form-control milk_day" id="milk_day" value="<?php echo $pregnancy_info->milk_day ?>"  name="milk_day">
                                    </div>
                                </div>



                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label for="Active">Birth attended ? <span style="color:red">*</span></label>
                                        <select class="form-control required" id="fk_delivery_assist_type" name="fk_delivery_assist_type" required>
                                            <option value="">Please select</option>
                                            <?php
                                            if (!empty($preg_term_assist)) {
                                                foreach ($preg_term_assist as $pregtermassist) {
                                                    ?>
                                                    <option  <?php
                                                    if ($pregnancy_info->fk_delivery_assist_type == $pregtermassist->id) {
                                                        echo "selected=selected";
                                                    }
                                                    ?> value="<?php echo $pregtermassist->id ?>"><?php echo $pregtermassist->code . '-' . $pregtermassist->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label for="Active">Place of delivery ? <span style="color:red">*</span></label>
                                        <select class="form-control required" id="fk_delivery_term_place" name="fk_delivery_term_place" required>
                                            <option value="">Please select</option>
                                            <?php
                                            if (!empty($preg_term_place)) {
                                                foreach ($preg_term_place as $pregtermplace) {
                                                    ?>
                                                    <option <?php
                                                    if ($pregnancy_info->fk_delivery_term_place == $pregtermplace->id) {
                                                        echo "selected=selected";
                                                    }
                                                    ?> value="<?php echo $pregtermplace->id ?>"><?php echo $pregtermplace->code . '-' . $pregtermplace->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 facility">
                                    <div class="form-group">

                                        <label for="Active">In case of facility delivery, whether the mother was </label>
                                        <select class="form-control required" id="fk_facility_delivery" name="fk_facility_delivery">
                                            <option value="0">Please select</option>
                                            <?php
                                            if (!empty($facility_delivery)) {
                                                foreach ($facility_delivery as $facilitydelivery) {
                                                    ?>
                                                    <option <?php
                                                    if ($pregnancy_info->fk_facility_delivery == $facilitydelivery->id) {
                                                        echo "selected=selected";
                                                    }
                                                    ?> value="<?php echo $facilitydelivery->id ?>"><?php echo $facilitydelivery->code . '-' . $facilitydelivery->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label for="Active">Complications during pregnancy? <span style="color:red">*</span></label>
                                        <select class="form-control required" id="fk_preg_complication" name="fk_preg_complication" required>
                                            <option value="0">Please select</option>
                                            <?php
                                            if (!empty($yes_no_com)) {
                                                foreach ($yes_no_com as $yesno) {
                                                    ?>
                                                    <option <?php
                                                    if ($pregnancy_info->fk_preg_complication == $yesno->id) {
                                                        echo "selected=selected";
                                                    }
                                                    ?> value="<?php echo $yesno->id ?>"><?php echo $yesno->code . '-' . $yesno->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label for="Active">Complications during delivery? <span style="color:red">*</span></label>
                                        <select class="form-control required" id="fk_delivery_complication" name="fk_delivery_complication" required>
                                            <option value="0">Please select</option>
                                            <?php
                                            foreach ($yes_no_com as $yesnode) {
                                                ?>
                                                <option <?php
                                                if ($pregnancy_info->fk_delivery_complication == $yesnode->id) {
                                                    echo "selected=selected";
                                                }
                                                ?> value="<?php echo $yesnode->id ?>"><?php echo $yesnode->code . '-' . $yesnode->name ?></option>
                                                    <?php
                                                }
                                                ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label for="Active">Did you have any violence during pregnancy? <span style="color:red">*</span></label>
                                        <select class="form-control required" id="fk_preg_violence" name="fk_preg_violence" required>
                                            <option value="0">Please select</option>
                                            <?php
                                            foreach ($yes_no_com as $yesnovio) {
                                                ?>
                                                <option <?php
                                                if ($pregnancy_info->fk_preg_violence == $yesnovio->id) {
                                                    echo "selected=selected";
                                                }
                                                ?> value="<?php echo $yesnovio->id ?>"><?php echo $yesnovio->code . '-' . $yesnovio->name ?></option>
                                                    <?php
                                                }
                                                ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label for="Active">Litter Size <span style="color:red">*</span></label>
                                        <select class="form-control required" id="fk_litter_size" name="fk_litter_size" required>
                                            <option value="">Please select</option>
                                            <?php
                                            if (!empty($litter_size)) {
                                                foreach ($litter_size as $litter_size) {
                                                    ?>
                                                    <option <?php
                                                    if ($pregnancy_info->fk_litter_size == $litter_size->id) {
                                                        echo "selected=selected";
                                                    }
                                                    ?> value="<?php echo $litter_size->id ?>"><?php echo $litter_size->code . '-' . $litter_size->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                        </select>
                                    </div>
                                </div>

                                <!--<div class="col-md-4">
<div class="form-group">

<label for="Active">What was given to babies mouth within first six hour of birth ?</label>
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
                                if (!empty($yes_no_miss_not_app)) {
                                    foreach ($yes_no_miss_not_app as $yesnomissnotapp) {
                                        ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <option <?php
                                        if ($fk_health_problem_id == $yesnomissnotapp->id) {
                                            echo "selected=selected";
                                        }
                                        ?> value="<?php echo $yesnomissnotapp->id ?>"><?php echo $yesnomissnotapp->code . '-' . $yesnomissnotapp->name ?></option>
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
                                if (!empty($yes_no_miss_not_app)) {
                                    foreach ($yes_no_miss_not_app as $yesnohigh) {
                                        ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <option <?php
                                        if ($fk_high_pressure_id == $yesnohigh->id) {
                                            echo "selected=selected";
                                        }
                                        ?> value="<?php echo $yesnohigh->id ?>"><?php echo $yesnohigh->code . '-' . $yesnohigh->name ?></option>
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
                                if (!empty($yes_no_miss_not_app)) {
                                    foreach ($yes_no_miss_not_app as $yesnodia) {
                                        ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <option <?php
                                        if ($fk_diabetis_id == $yesnodia->id) {
                                            echo "selected=selected";
                                        }
                                        ?> value="<?php echo $yesnodia->id ?>"><?php echo $yesnodia->code . '-' . $yesnodia->name ?></option>
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
                                if (!empty($yes_no_miss_not_app)) {
                                    foreach ($yes_no_miss_not_app as $yesnopre) {
                                        ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <option <?php
                                        if ($fk_preaklampshia_id == $yesnopre->id) {
                                            echo "selected=selected";
                                        }
                                        ?> value="<?php echo $yesnopre->id ?>"><?php echo $yesnopre->code . '-' . $yesnopre->name ?></option>
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
                                if (!empty($yes_no_miss_not_app)) {
                                    foreach ($yes_no_miss_not_app as $yesnoprelab) {
                                        ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <option <?php
                                        if ($fk_lebar_birth_id == $yesnoprelab->id) {
                                            echo "selected=selected";
                                        }
                                        ?> value="<?php echo $yesnoprelab->id ?>"><?php echo $yesnoprelab->code . '-' . $yesnoprelab->name ?></option>
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
                                if (!empty($yes_no_miss_not_app)) {
                                    foreach ($yes_no_miss_not_app as $yesnobim) {
                                        ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <option  <?php
                                        if ($fk_vomiting_id == $yesnobim->id) {
                                            echo "selected=selected";
                                        }
                                        ?> value="<?php echo $yesnobim->id ?>"><?php echo $yesnobim->code . '-' . $yesnobim->name ?></option>
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
                                if (!empty($yes_no_miss_not_app)) {
                                    foreach ($yes_no_miss_not_app as $yesnofluid) {
                                        ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <option <?php
                                        if ($fk_amliotic_id == $yesnofluid->id) {
                                            echo "selected=selected";
                                        }
                                        ?> value="<?php echo $yesnofluid->id ?>"><?php echo $yesnofluid->code . '-' . $yesnofluid->name ?></option>
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
                                if (!empty($yes_no_miss_not_app)) {
                                    foreach ($yes_no_miss_not_app as $yesnomem) {
                                        ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <option <?php
                                        if ($fk_membrane_id == $yesnomem->id) {
                                            echo "selected=selected";
                                        }
                                        ?> value="<?php echo $yesnomem->id ?>"><?php echo $yesnomem->code . '-' . $yesnomem->name ?></option>
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
                                if (!empty($yes_no_miss_not_app)) {
                                    foreach ($yes_no_miss_not_app as $yesnomal) {
                                        ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <option <?php
                                        if ($fk_malposition_id == $yesnomal->id) {
                                            echo "selected=selected";
                                        }
                                        ?> value="<?php echo $yesnomal->id ?>"><?php echo $yesnomal->code . '-' . $yesnomal->name ?></option>
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
                                if (!empty($yes_no_miss_not_app)) {
                                    foreach ($yes_no_miss_not_app as $yesnohead) {
                                        ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <option <?php
                                        if ($fk_headache_id == $yesnohead->id) {
                                            echo "selected=selected";
                                        }
                                        ?> value="<?php echo $yesnohead->id ?>"><?php echo $yesnohead->code . '-' . $yesnohead->name ?></option>
                                        <?php
                                    }
                                }
                                ?>
     
 </select>
</div>
</div>-->

                                <!-- <div class="col-md-4">
<div class="form-group">

<label for="Active">Keep Follow up for PNC <span style="color:red">*</span></label>
<select class="form-control required" id="keep_follow_up" name="keep_follow_up" required>
<option <?php
                                if ($keep_follow_up == 1) {
                                    echo "selected=selected";
                                }
                                ?> value="1">Yes</option>
<option <?php
                                if ($keep_follow_up == 0) {
                                    echo "selected=selected";
                                }
                                ?> value="0">No</option>

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
                                                if (!empty($onlyYesNo)) {
                                                    foreach ($onlyYesNo as $onlyynr) {
                                                        ?>
                                                        <option <?php
                                                        if ($pregnancy_info->fk_routine_anc_chkup_mother_id == $onlyynr->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $onlyynr->id ?>"><?php echo $onlyynr->code . '-' . $onlyynr->name ?></option>
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
                                            <input type="number" class="form-control afterTotalTimesRoutine" id="afterTotalTimesRoutine"  name="afterTotalTimesRoutine" value="<?php echo $pregnancy_info->routine_anc_chkup_mother_times ?>">
                                        </div>
                                    </div>

                                </div> 
                                <div class="row manyTimesRoutine">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Active">Who assisted during ANC(First Visit)</label>
                                            <select class="form-control required" id="routineFirstVisitAsist" name="routineFirstVisitAsist">
                                                <option value="0">Please Select</option>
                                                <?php
                                                if (!empty($anc_assist_typ)) {
                                                    foreach ($anc_assist_typ as $anc_assist_typ) {
                                                        ?>
                                                        <option <?php
                                                        if ($pregnancy_info->fk_anc_first_assist_id == $anc_assist_typ->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $anc_assist_typ->id ?>"><?php echo $anc_assist_typ->code . '-' . $anc_assist_typ->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Active"> Place of first visit</label>
                                            <select class="form-control required" id="routineFirstVisit" name="routineFirstVisit">
                                                <option value="0">Please Select</option>
                                                <?php
                                                if (!empty($ancPncVisit)) {
                                                    foreach ($ancPncVisit as $rutancPncVisit1) {
                                                        ?>
                                                        <option <?php
                                                        if ($pregnancy_info->fk_anc_first_visit_id == $rutancPncVisit1->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $rutancPncVisit1->id ?>"><?php echo $rutancPncVisit1->code . '-' . $rutancPncVisit1->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">

                                            <label for="Active">Duration of pregnancy(month only)</label>
                                            <input type="number" class="form-control" placeholder="months" name="routineFirstVisitMonthss" value="<?php echo $pregnancy_info->anc_first_visit_months ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Active">Who assisted during ANC(Second Visit)</label>
                                            <select class="form-control required" id="routineSecondVisitAsist" name="routineSecondVisitAsist">
                                                <option value="0">Please Select</option>
                                                <?php
                                                if (!empty($anc_assist_typ1)) {
                                                    foreach ($anc_assist_typ1 as $anc_assist_typ1) {
                                                        ?>
                                                        <option <?php
                                                        if ($pregnancy_info->fk_anc_second_assist_id == $anc_assist_typ1->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $anc_assist_typ1->id ?>"><?php echo $anc_assist_typ1->code . '-' . $anc_assist_typ1->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Active">Place of second visit </label>
                                            <select class="form-control required" id="routineSecondVisit" name="routineSecondVisit">
                                                <option value="0">Please Select</option>
                                                <?php
                                                if (!empty($ancPncVisit)) {
                                                    foreach ($ancPncVisit as $rutancPncVisit2) {
                                                        ?>
                                                        <option <?php
                                                        if ($pregnancy_info->fk_anc_second_visit_id == $rutancPncVisit2->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $rutancPncVisit2->id ?>"><?php echo $rutancPncVisit2->code . '-' . $rutancPncVisit2->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">

                                            <label for="Active">Duration of pregnancy(month only)</label>
                                            <input type="number" class="form-control " placeholder="months" name="routineSecondVisitMonths" value="<?php echo $pregnancy_info->anc_second_visit_months ?>">
                                        </div>
                                    </div>

                                    <!-- third-->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Active">Who assisted during ANC(Third Visit)</label>
                                            <select class="form-control required" id="routineThirdVisitAsist" name="routineThirdVisitAsist">
                                                <option value="0">Please Select</option>
                                                <?php
                                                if (!empty($anc_assist_typ2)) {
                                                    foreach ($anc_assist_typ2 as $anc_assist_typ2) {
                                                        ?>
                                                        <option <?php
                                                        if ($pregnancy_info->fk_anc_third_assist_id == $anc_assist_typ2->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $anc_assist_typ2->id ?>"><?php echo $anc_assist_typ2->code . '-' . $anc_assist_typ2->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Active"> Place of third visit </label>
                                            <select class="form-control required" id="routineThirdVisit" name="routineThirdVisit">
                                                <option value="0">Please Select</option>
                                                <?php
                                                if (!empty($ancPncVisit)) {
                                                    foreach ($ancPncVisit as $rutancPncVisit3) {
                                                        ?>
                                                        <option <?php
                                                        if ($pregnancy_info->fk_anc_third_visit_id == $rutancPncVisit3->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $rutancPncVisit3->id ?>"><?php echo $rutancPncVisit3->code . '-' . $rutancPncVisit3->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">

                                            <label for="Active">Duration of pregnancy(month only)</label>
                                            <input type="number" class="form-control " placeholder="months" name="routineThirdVisitMonths" value="<?php echo $pregnancy_info->anc_third_visit_months ?>">
                                        </div>
                                    </div>
                                    <!-- fourth-->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Active">Who assisted during ANC(Fourth Visit)</label>
                                            <select class="form-control required" id="routineFourthVisitAsist" name="routineFourthVisitAsist">
                                                <option value="0">Please Select</option>
                                                <?php
                                                if (!empty($anc_assist_typ3)) {
                                                    foreach ($anc_assist_typ3 as $anc_assist_typ3) {
                                                        ?>
                                                        <option <?php
                                                        if ($pregnancy_info->fk_anc_fourth_assist_id == $anc_assist_typ3->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $anc_assist_typ3->id ?>"><?php echo $anc_assist_typ3->code . '-' . $anc_assist_typ3->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Active">Place of fourth visit </label>
                                            <select class="form-control required" id="routineSecFourthVisit" name="routineFourthVisit">
                                                <option value="0">Please Select</option>
                                                <?php
                                                if (!empty($ancPncVisit)) {
                                                    foreach ($ancPncVisit as $rutancPncVisit4) {
                                                        ?>
                                                        <option <?php
                                                        if ($pregnancy_info->fk_anc_fourth_visit_id == $rutancPncVisit4->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $rutancPncVisit4->id ?>"><?php echo $rutancPncVisit4->code . '-' . $rutancPncVisit4->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">

                                            <label for="Active">Duration of pregnancy(month only)</label>
                                            <input type="number" class="form-control " placeholder="months" name="routineFourthVisitMonths" value="<?php echo $pregnancy_info->anc_fourth_visit_months ?>">
                                        </div>
                                    </div>
                                    <!-- fifth-->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Active">Who assisted during ANC(Fifth Visit)</label>
                                            <select class="form-control required" id="routineFifthVisitAsist" name="routineFifthVisitAsist">
                                                <option value="0">Please Select</option>
                                                <?php
                                                if (!empty($anc_assist_typ4)) {
                                                    foreach ($anc_assist_typ4 as $anc_assist_typ4) {
                                                        ?>
                                                        <option <?php
                                                        if ($pregnancy_info->fk_anc_fifth_assist_id == $anc_assist_typ4->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $anc_assist_typ4->id ?>"><?php echo $anc_assist_typ4->code . '-' . $anc_assist_typ4->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Active">Place of fifth visit </label>
                                            <select class="form-control required" id="routineFifthVisit" name="routineFifthVisit">
                                                <option value="0">Please Select</option>
                                                <?php
                                                if (!empty($ancPncVisit)) {
                                                    foreach ($ancPncVisit as $rutancPncVisit5) {
                                                        ?>
                                                        <option <?php
                                                        if ($pregnancy_info->fk_anc_fifth_visit_id == $rutancPncVisit5->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $rutancPncVisit5->id ?>"><?php echo $rutancPncVisit5->code . '-' . $rutancPncVisit5->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">

                                            <label for="Active">Duration of pregnancy(month only)</label>
                                            <input type="number" class="form-control " placeholder="months" name="routineFifthVisitMonths" value="<?php echo $pregnancy_info->anc_fifth_visit_months ?>">
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Active"> Did you receive any iron and folic acid (IFA) supplement? </label>
                                            <select class="form-control" id="fk_supliment" name="fk_supliment" required>
                                                <option value="">Please Select</option>
                                                <?php
                                                if (!empty($onlyYesNo)) {
                                                    foreach ($onlyYesNo as $onlyyn) {
                                                        ?>
                                                        <option <?php
                                                        if ($pregnancy_info->fk_anc_supliment == $onlyyn->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $onlyyn->id ?>"><?php echo $onlyyn->code . '-' . $onlyyn->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 supplement">
                                        <div class="form-group">
                                            <label for="Active"> Did you receive or purchase IFA supplement? </label>
                                            <select class="form-control" id="fk_supliment_received_way" name="fk_supliment_received_way">
                                                <option value="0">Please Select</option>
                                                <?php
                                                if (!empty($ifa_supliment_source)) {
                                                    foreach ($ifa_supliment_source as $isuplimensource) {
                                                        ?>
                                                        <option <?php
                                                        if ($pregnancy_info->fk_supliment_received_way == $isuplimensource->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $isuplimensource->id ?>"><?php echo $isuplimensource->code . '-' . $isuplimensource->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4 supplement">
                                        <div class="form-group">
                                            <label for="Active"> How many tablets she took? </label>
                                            <select class="form-control" id="fk_how_many_tab" name="fk_how_many_tab">
                                                <option value="0">Please Select</option>
                                                <?php
                                                if (!empty($how_many_tablet)) {
                                                    foreach ($how_many_tablet as $how_many_tablet) {
                                                        ?>
                                                        <option <?php
                                                        if ($pregnancy_info->fk_how_many_tab == $how_many_tablet->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $how_many_tablet->id ?>"><?php echo $how_many_tablet->code . '-' . $how_many_tablet->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4 numbers">
                                        <div class="form-group">
                                            <label for="Item Name">Total Number <span style="color:red">*</span></label>
                                            <input type="number" class="form-control totalNumberTablet" placeholder="Total Number" id="totalNumberTablet" value="<?php echo $pregnancy_info->totalnumbertab ?>" name="totalNumberTablet">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                <fieldset class="scheduler-border" style="border:1px solid red">
                                    <legend class="scheduler-border">Basic components of ANC</legend>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Active"> Weight taken </label>
                                            <select class="form-control" id="fk_anc_weight_taken" name="fk_anc_weight_taken">
                                                <option value="0">Please Select</option>
                                                <?php
                                                if (!empty($onlyYesNo)) {
                                                    foreach ($onlyYesNo as $onlyyn) {
                                                        ?>
                                                        <option <?php
                                                        if ($pregnancy_info->fk_anc_weight_taken == $onlyyn->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $onlyyn->id ?>"><?php echo $onlyyn->code . '-' . $onlyyn->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Active"> Blood pressure measured </label>
                                            <select class="form-control" id="fk_anc_blood_pressure" name="fk_anc_blood_pressure">
                                                <option value="0">Please Select</option>
                                                <?php
                                                if (!empty($onlyYesNo)) {
                                                    foreach ($onlyYesNo as $onlyyn) {
                                                        ?>
                                                        <option <?php
                                                        if ($pregnancy_info->fk_anc_blood_pressure == $onlyyn->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $onlyyn->id ?>"><?php echo $onlyyn->code . '-' . $onlyyn->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Active"> Urine sample taken </label>
                                            <select class="form-control" id="fk_anc_urine" name="fk_anc_urine">
                                                <option value="0">Please Select</option>
                                                <?php
                                                if (!empty($onlyYesNo)) {
                                                    foreach ($onlyYesNo as $onlyyn) {
                                                        ?>
                                                        <option <?php
                                                        if ($pregnancy_info->fk_anc_urine == $onlyyn->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $onlyyn->id ?>"><?php echo $onlyyn->code . '-' . $onlyyn->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Active"> Blood sample taken </label>
                                            <select class="form-control" id="fk_anc_blood" name="fk_anc_blood">
                                                <option value="0">Please Select</option>
                                                <?php
                                                if (!empty($onlyYesNo)) {
                                                    foreach ($onlyYesNo as $onlyyn) {
                                                        ?>
                                                        <option <?php
                                                        if ($pregnancy_info->fk_anc_blood == $onlyyn->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $onlyyn->id ?>"><?php echo $onlyyn->code . '-' . $onlyyn->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Active"> Informed about danger signs of pregnancy </label>
                                            <select class="form-control" id="fk_anc_denger_sign" name="fk_anc_denger_sign">
                                                <option value="0">Please Select</option>
                                                <?php
                                                if (!empty($onlyYesNo)) {
                                                    foreach ($onlyYesNo as $onlyyn) {
                                                        ?>
                                                        <option <?php
                                                        if ($pregnancy_info->fk_anc_denger_sign == $onlyyn->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $onlyyn->id ?>"><?php echo $onlyyn->code . '-' . $onlyyn->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Active"> Counseling about nutrition </label>
                                            <select class="form-control" id="fk_anc_nutrition" name="fk_anc_nutrition">
                                                <option value="0">Please Select</option>
                                                <?php
                                                if (!empty($onlyYesNo)) {
                                                    foreach ($onlyYesNo as $onlyyn) {
                                                        ?>
                                                        <option <?php
                                                        if ($pregnancy_info->fk_anc_nutrition == $onlyyn->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $onlyyn->id ?>"><?php echo $onlyyn->code . '-' . $onlyyn->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Active"> Counseling about birth preparedness </label>
                                            <select class="form-control" id="fk_anc_birth_prepare" name="fk_anc_birth_prepare">
                                                <option value="0">Please Select</option>
                                                <?php
                                                if (!empty($onlyYesNo)) {
                                                    foreach ($onlyYesNo as $onlyyn) {
                                                        ?>
                                                        <option  <?php
                                                        if ($pregnancy_info->fk_anc_birth_prepare == $onlyyn->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $onlyyn->id ?>"><?php echo $onlyyn->code . '-' . $onlyyn->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>
                                </fieldset>
                                </div>

                                <fieldset class="scheduler-border" style="border:1px solid red">
                                    <legend class="scheduler-border">Newborn care practices</legend>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Active"> Boiled/steriled instrument/safe delivery kit </label>
                                            <select class="form-control" id="fk_anc_delivery_kit" name="fk_anc_delivery_kit">
                                                <option value="0">Please Select</option>
                                                <?php
                                                if (!empty($onlyYesNo)) {
                                                    foreach ($onlyYesNo as $onlyyn) {
                                                        ?>
                                                        <option <?php
                                                        if ($pregnancy_info->fk_anc_delivery_kit == $onlyyn->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $onlyyn->id ?>"><?php echo $onlyyn->code . '-' . $onlyyn->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Active"> Wash hands with soap </label>
                                            <select class="form-control" id="fk_anc_soap" name="fk_anc_soap">
                                                <option value="0">Please Select</option>
                                                <?php
                                                if (!empty($onlyYesNo)) {
                                                    foreach ($onlyYesNo as $onlyyn) {
                                                        ?>
                                                        <option <?php
                                                        if ($pregnancy_info->fk_anc_soap == $onlyyn->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $onlyyn->id ?>"><?php echo $onlyyn->code . '-' . $onlyyn->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Active"> Cord care-chix or nothing  </label>
                                            <select class="form-control" id="fk_anc_care_chix" name="fk_anc_care_chix">
                                                <option value="0">Please Select</option>
                                                <?php
                                                if (!empty($onlyYesNo)) {
                                                    foreach ($onlyYesNo as $onlyyn) {
                                                        ?>
                                                        <option <?php
                                                        if ($pregnancy_info->fk_anc_care_chix == $onlyyn->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $onlyyn->id ?>"><?php echo $onlyyn->code . '-' . $onlyyn->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Active"> Dried within 5 minutes of birth </label>
                                            <select class="form-control" id="fk_anc_dried" name="fk_anc_dried">
                                                <option value="0">Please Select</option>
                                                <?php
                                                if (!empty($onlyYesNo)) {
                                                    foreach ($onlyYesNo as $onlyyn) {
                                                        ?>
                                                        <option <?php
                                                        if ($pregnancy_info->fk_anc_dried == $onlyyn->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $onlyyn->id ?>"><?php echo $onlyyn->code . '-' . $onlyyn->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Active"> Bathing delayed>24 hours </label>
                                            <select class="form-control" id="fk_anc_bathing" name="fk_anc_bathing">
                                                <option value="0">Please Select</option>
                                                <?php
                                                if (!empty($onlyYesNo)) {
                                                    foreach ($onlyYesNo as $onlyyn) {
                                                        ?>
                                                        <option <?php
                                                        if ($pregnancy_info->fk_anc_bathing == $onlyyn->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $onlyyn->id ?>"><?php echo $onlyyn->code . '-' . $onlyyn->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Active"> Immediate breastfeeding </label>
                                            <select class="form-control" id="fk_anc_breast_feed" name="fk_anc_breast_feed">
                                                <option value="0">Please Select</option>
                                                <?php
                                                if (!empty($onlyYesNo)) {
                                                    foreach ($onlyYesNo as $onlyyn) {
                                                        ?>
                                                        <option <?php
                                                        if ($pregnancy_info->fk_anc_breast_feed == $onlyyn->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $onlyyn->id ?>"><?php echo $onlyyn->code . '-' . $onlyyn->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Active"> Skin to skin contact immediately after birth </label>
                                            <select class="form-control" id="fk_anc_skin_contact" name="fk_anc_skin_contact">
                                                <option value="0">Please Select</option>
                                                <?php
                                                if (!empty($onlyYesNo)) {
                                                    foreach ($onlyYesNo as $onlyyn) {
                                                        ?>
                                                        <option <?php
                                                        if ($pregnancy_info->fk_anc_skin_contact == $onlyyn->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $onlyyn->id ?>"><?php echo $onlyyn->code . '-' . $onlyyn->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Active"> All ENC practices </label>
                                            <select class="form-control" id="fk_anc_enc" name="fk_anc_enc">
                                                <option value="0">Please Select</option>
                                                <?php
                                                if (!empty($onlyYesNo)) {
                                                    foreach ($onlyYesNo as $onlyyn) {
                                                        ?>
                                                        <option <?php
                                                        if ($pregnancy_info->fk_anc_enc == $onlyyn->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $onlyyn->id ?>"><?php echo $onlyyn->code . '-' . $onlyyn->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>

                                </fieldset>


                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Active"> Did the baby had suspected infection or sepsis? </label>
                                            <select class="form-control" id="fk_suspecred_infection" name="fk_suspecred_infection">
                                                <option value="0">Please Select</option>
                                                <?php
                                                if (!empty($yes_no_not_applicable)) {
                                                    foreach ($yes_no_not_applicable as $not_applicable) {
                                                        ?>
                                                        <option <?php
                                                        if ($pregnancy_info->fk_suspecred_infection == $not_applicable->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $not_applicable->id ?>"><?php echo $not_applicable->code . '-' . $not_applicable->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 antibiotics">
                                        <div class="form-group">
                                            <label for="Active"> If yes, did the baby received antibiotics? </label>
                                            <select class="form-control" id="fk_baby_antibiotics" name="fk_baby_antibiotics">
                                                <option value="0">Please Select</option>
                                                <?php
                                                if (!empty($onlyYesNo)) {
                                                    foreach ($onlyYesNo as $onlyyn) {
                                                        ?>
                                                        <option <?php
                                                        if ($pregnancy_info->fk_baby_antibiotics == $onlyyn->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?>  value="<?php echo $onlyyn->id ?>"><?php echo $onlyyn->code . '-' . $onlyyn->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4 antibiotics_pres">
                                        <div class="form-group">
                                            <label for="Active">Who prescribe antibiotics?</label>
                                            <select class="form-control required" id="fk_prescribe_antibiotics" name="fk_prescribe_antibiotics">
                                                <option value="0">Please Select</option>
                                                <?php
                                                if (!empty($prescribe_antibiotics)) {
                                                    foreach ($prescribe_antibiotics as $antibiotics) {
                                                        ?>
                                                        <option <?php
                                                        if ($pregnancy_info->fk_prescribe_antibiotics == $antibiotics->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $antibiotics->id ?>"><?php echo $antibiotics->code . '-' . $antibiotics->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4 antibiotics_pres">
                                        <div class="form-group">
                                            <label for="Active">Where did you seek treatment?</label>
                                            <select class="form-control required" id="fk_seek_treatment" name="fk_seek_treatment">
                                                <option value="0">Please Select</option>
                                                <?php
                                                if (!empty($go_for_treatment)) {
                                                    foreach ($go_for_treatment as $go_for_treatment) {
                                                        ?>
                                                        <option <?php
                                                        if ($pregnancy_info->fk_seek_treatment == $go_for_treatment->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $go_for_treatment->id ?>"><?php echo $go_for_treatment->code . '-' . $go_for_treatment->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>

                                </div>


                                <fieldset class="scheduler-border" style="border:1px solid red">
                                    <legend class="scheduler-border">Knowledge and Behavior</legend>


                                    <fieldset class="scheduler-border" style="border:1px solid red">
                                        <legend class="scheduler-border">Did you know about danger signs of pregnancy?</legend>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Active"> Vaginal bleeding </label>
                                                <select class="form-control" id="fk_anc_vaginal_bleeding" name="fk_anc_vaginal_bleeding">
                                                    <option value="0">Please Select</option>
                                                    <?php
                                                    if (!empty($knowledgebehavior)) {
                                                        foreach ($knowledgebehavior as $knvior) {
                                                            ?>
                                                            <option <?php
                                                            if ($pregnancy_info->fk_anc_vaginal_bleeding == $knvior->id) {
                                                                echo "selected=selected";
                                                            }
                                                            ?> value="<?php echo $knvior->id ?>"><?php echo $knvior->code . '-' . $knvior->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Active"> Convulsions/fits </label>
                                                <select class="form-control" id="fk_anc_convulsions" name="fk_anc_convulsions">
                                                    <option value="0">Please Select</option>
                                                    <?php
                                                    if (!empty($knowledgebehavior)) {
                                                        foreach ($knowledgebehavior as $knvior) {
                                                            ?>
                                                            <option <?php
                                                            if ($pregnancy_info->fk_anc_convulsions == $knvior->id) {
                                                                echo "selected=selected";
                                                            }
                                                            ?> value="<?php echo $knvior->id ?>"><?php echo $knvior->code . '-' . $knvior->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Active"> Severe headaches with blurred vision </label>
                                                <select class="form-control" id="fk_anc_severe_headache" name="fk_anc_severe_headache">
                                                    <option value="0">Please Select</option>
                                                    <?php
                                                    if (!empty($knowledgebehavior)) {
                                                        foreach ($knowledgebehavior as $knvior) {
                                                            ?>
                                                            <option  <?php
                                                            if ($pregnancy_info->fk_anc_severe_headache == $knvior->id) {
                                                                echo "selected=selected";
                                                            }
                                                            ?> value="<?php echo $knvior->id ?>"><?php echo $knvior->code . '-' . $knvior->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Active"> Fever and too weak get out of bed </label>
                                                <select class="form-control" id="fk_anc_fever" name="fk_anc_fever">
                                                    <option value="0">Please Select</option>
                                                    <?php
                                                    if (!empty($knowledgebehavior)) {
                                                        foreach ($knowledgebehavior as $knvior) {
                                                            ?>
                                                            <option <?php
                                                            if ($pregnancy_info->fk_anc_fever == $knvior->id) {
                                                                echo "selected=selected";
                                                            }
                                                            ?> value="<?php echo $knvior->id ?>"><?php echo $knvior->code . '-' . $knvior->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Active"> Severe abdominal pain </label>
                                                <select class="form-control" id="fk_anc_abdominal_pain" name="fk_anc_abdominal_pain">
                                                    <option value="0">Please Select</option>
                                                    <?php
                                                    if (!empty($knowledgebehavior)) {
                                                        foreach ($knowledgebehavior as $knvior) {
                                                            ?>
                                                            <option <?php
                                                            if ($pregnancy_info->fk_anc_abdominal_pain == $knvior->id) {
                                                                echo "selected=selected";
                                                            }
                                                            ?> value="<?php echo $knvior->id ?>"><?php echo $knvior->code . '-' . $knvior->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Active"> Fast or difficult breathing </label>
                                                <select class="form-control" id="fk_anc_diff_breath" name="fk_anc_diff_breath">
                                                    <option value="0">Please Select</option>
                                                    <?php
                                                    if (!empty($knowledgebehavior)) {
                                                        foreach ($knowledgebehavior as $knvior) {
                                                            ?>
                                                            <option <?php
                                                            if ($pregnancy_info->fk_anc_diff_breath == $knvior->id) {
                                                                echo "selected=selected";
                                                            }
                                                            ?> value="<?php echo $knvior->id ?>"><?php echo $knvior->code . '-' . $knvior->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                </select>
                                            </div>
                                        </div>

                                    </fieldset>
                                    <fieldset class="scheduler-border" style="border:1px solid red">
                                        <legend class="scheduler-border">Did you know about danger signs of delivery?</legend>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Active"> Water breaks but labour does not start in 12 hours (Prolonged labour) </label>
                                                <select class="form-control" id="fk_anc_water_break" name="fk_anc_water_break">
                                                    <option value="0">Please Select</option>
                                                    <?php
                                                    if (!empty($knowledgebehavior)) {
                                                        foreach ($knowledgebehavior as $knvior) {
                                                            ?>
                                                            <option <?php
                                                            if ($pregnancy_info->fk_anc_water_break == $knvior->id) {
                                                                echo "selected=selected";
                                                            }
                                                            ?> value="<?php echo $knvior->id ?>"><?php echo $knvior->code . '-' . $knvior->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Active"> Excessive vaginal bleeding (APH) </label>
                                                <select class="form-control" id="fk_anc_vaginal_bleed_aph" name="fk_anc_vaginal_bleed_aph">
                                                    <option value="0">Please Select</option>
                                                    <?php
                                                    if (!empty($knowledgebehavior)) {
                                                        foreach ($knowledgebehavior as $knvior) {
                                                            ?>
                                                            <option <?php
                                                            if ($pregnancy_info->fk_anc_vaginal_bleed_aph == $knvior->id) {
                                                                echo "selected=selected";
                                                            }
                                                            ?> value="<?php echo $knvior->id ?>"><?php echo $knvior->code . '-' . $knvior->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Active"> Prolapse of any part of the baby per vagina   (obstructed labour) </label>
                                                <select class="form-control" id="fk_anc_obstructed_labour" name="fk_anc_obstructed_labour">
                                                    <option value="0">Please Select</option>
                                                    <?php
                                                    if (!empty($knowledgebehavior)) {
                                                        foreach ($knowledgebehavior as $knvior) {
                                                            ?>
                                                            <option <?php
                                                            if ($pregnancy_info->fk_anc_obstructed_labour == $knvior->id) {
                                                                echo "selected=selected";
                                                            }
                                                            ?> value="<?php echo $knvior->id ?>"><?php echo $knvior->code . '-' . $knvior->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Active"> Convulsion (eclampsia) </label>
                                                <select class="form-control" id="fk_anc_convulsion" name="fk_anc_convulsion">
                                                    <option value="0">Please Select</option>
                                                    <?php
                                                    if (!empty($knowledgebehavior)) {
                                                        foreach ($knowledgebehavior as $knvior) {
                                                            ?>
                                                            <option <?php
                                                            if ($pregnancy_info->fk_anc_convulsion == $knvior->id) {
                                                                echo "selected=selected";
                                                            }
                                                            ?> value="<?php echo $knvior->id ?>"><?php echo $knvior->code . '-' . $knvior->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Active"> High fever (sepsis) </label>
                                                <select class="form-control" id="fk_anc_sepsis" name="fk_anc_sepsis">
                                                    <option value="0">Please Select</option>
                                                    <?php
                                                    if (!empty($knowledgebehavior)) {
                                                        foreach ($knowledgebehavior as $knvior) {
                                                            ?>
                                                            <option <?php
                                                            if ($pregnancy_info->fk_anc_sepsis == $knvior->id) {
                                                                echo "selected=selected";
                                                            }
                                                            ?> value="<?php echo $knvior->id ?>"><?php echo $knvior->code . '-' . $knvior->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Active"> Severe headache </label>
                                                <select class="form-control" id="fk_anc_severe_headache_delivery" name="fk_anc_severe_headache_delivery">
                                                    <option value="0">Please Select</option>
                                                    <?php
                                                    if (!empty($knowledgebehavior)) {
                                                        foreach ($knowledgebehavior as $knvior) {
                                                            ?>
                                                            <option <?php
                                                            if ($pregnancy_info->fk_anc_severe_headache_delivery == $knvior->id) {
                                                                echo "selected=selected";
                                                            }
                                                            ?> value="<?php echo $knvior->id ?>"><?php echo $knvior->code . '-' . $knvior->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Active"> Loss of consciousness </label>
                                                <select class="form-control" id="fk_anc_consciousness" name="fk_anc_consciousness">
                                                    <option value="0">Please Select</option>
                                                    <?php
                                                    if (!empty($knowledgebehavior)) {
                                                        foreach ($knowledgebehavior as $knvior) {
                                                            ?>
                                                            <option <?php
                                                            if ($pregnancy_info->fk_anc_consciousness == $knvior->id) {
                                                                echo "selected=selected";
                                                            }
                                                            ?> value="<?php echo $knvior->id ?>"><?php echo $knvior->code . '-' . $knvior->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                </select>
                                            </div>
                                        </div>

                                    </fieldset>
                                    <fieldset class="scheduler-border" style="border:1px solid red">
                                        <legend class="scheduler-border">Did you know about danger signs of postnatal period?</legend>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Active"> Excessive vaginal bleeding (PPH) </label>
                                                <select class="form-control" id="fk_anc_vaginal_bleeding_post" name="fk_anc_vaginal_bleeding_post">
                                                    <option value="0">Please Select</option>
                                                    <?php
                                                    if (!empty($knowledgebehavior)) {
                                                        foreach ($knowledgebehavior as $knvior) {
                                                            ?>
                                                            <option <?php
                                                            if ($pregnancy_info->fk_anc_vaginal_bleeding_post == $knvior->id) {
                                                                echo "selected=selected";
                                                            }
                                                            ?> value="<?php echo $knvior->id ?>"><?php echo $knvior->code . '-' . $knvior->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Active"> Convulsion (eclampsia) </label>
                                                <select class="form-control" id="fk_anc_convulsion_eclampsia_post" name="fk_anc_convulsion_eclampsia_post">
                                                    <option value="0">Please Select</option>
                                                    <?php
                                                    if (!empty($knowledgebehavior)) {
                                                        foreach ($knowledgebehavior as $knvior) {
                                                            ?>
                                                            <option <?php
                                                            if ($pregnancy_info->fk_anc_convulsion_eclampsia_post == $knvior->id) {
                                                                echo "selected=selected";
                                                            }
                                                            ?> value="<?php echo $knvior->id ?>"><?php echo $knvior->code . '-' . $knvior->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Active"> High fever (sepsis) </label>
                                                <select class="form-control" id="fk_anc_high_feaver_post" name="fk_anc_high_feaver_post">
                                                    <option value="0">Please Select</option>
                                                    <?php
                                                    if (!empty($knowledgebehavior)) {
                                                        foreach ($knowledgebehavior as $knvior) {
                                                            ?>
                                                            <option <?php
                                                            if ($pregnancy_info->fk_anc_high_feaver_post == $knvior->id) {
                                                                echo "selected=selected";
                                                            }
                                                            ?> value="<?php echo $knvior->id ?>"><?php echo $knvior->code . '-' . $knvior->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Active"> Foul smelling discharge per vagina </label>
                                                <select class="form-control" id="fk_anc_smelling_discharge_post" name="fk_anc_smelling_discharge_post">
                                                    <option value="0">Please Select</option>
                                                    <?php
                                                    if (!empty($knowledgebehavior)) {
                                                        foreach ($knowledgebehavior as $knvior) {
                                                            ?>
                                                            <option  <?php
                                                            if ($pregnancy_info->fk_anc_smelling_discharge_post == $knvior->id) {
                                                                echo "selected=selected";
                                                            }
                                                            ?> value="<?php echo $knvior->id ?>"><?php echo $knvior->code . '-' . $knvior->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Active"> Severe headache </label>
                                                <select class="form-control" id="fk_anc_severe_headache_post" name="fk_anc_severe_headache_post">
                                                    <option value="0">Please Select</option>
                                                    <?php
                                                    if (!empty($knowledgebehavior)) {
                                                        foreach ($knowledgebehavior as $knvior) {
                                                            ?>
                                                            <option <?php
                                                            if ($pregnancy_info->fk_anc_severe_headache_post == $knvior->id) {
                                                                echo "selected=selected";
                                                            }
                                                            ?> value="<?php echo $knvior->id ?>"><?php echo $knvior->code . '-' . $knvior->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Active"> Loss of consciousness </label>
                                                <select class="form-control" id="fk_anc_consciousness_post" name="fk_anc_consciousness_post">
                                                    <option value="0">Please Select</option>
                                                    <?php
                                                    if (!empty($knowledgebehavior)) {
                                                        foreach ($knowledgebehavior as $knvior) {
                                                            ?>
                                                            <option <?php
                                                            if ($pregnancy_info->fk_anc_consciousness_post == $knvior->id) {
                                                                echo "selected=selected";
                                                            }
                                                            ?> value="<?php echo $knvior->id ?>"><?php echo $knvior->code . '-' . $knvior->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                </select>
                                            </div>
                                        </div>

                                    </fieldset>

                                    <fieldset class="scheduler-border" style="border:1px solid red">
                                        <legend class="scheduler-border">Did you know about danger signs of newborn baby?</legend>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Active"> inability to suck </label>
                                                <select class="form-control" id="fk_anc_inability_baby" name="fk_anc_inability_baby">
                                                    <option value="0">Please Select</option>
                                                    <?php
                                                    if (!empty($knowledgebehavior)) {
                                                        foreach ($knowledgebehavior as $knvior) {
                                                            ?>
                                                            <option <?php
                                                            if ($pregnancy_info->fk_anc_inability_baby == $knvior->id) {
                                                                echo "selected=selected";
                                                            }
                                                            ?> value="<?php echo $knvior->id ?>"><?php echo $knvior->code . '-' . $knvior->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Active"> Baby too small  </label>
                                                <select class="form-control" id="fk_anc_baby_small_baby" name="fk_anc_baby_small_baby">
                                                    <option value="0">Please Select</option>
                                                    <?php
                                                    if (!empty($knowledgebehavior)) {
                                                        foreach ($knowledgebehavior as $knvior) {
                                                            ?>
                                                            <option <?php
                                                            if ($pregnancy_info->fk_anc_baby_small_baby == $knvior->id) {
                                                                echo "selected=selected";
                                                            }
                                                            ?> value="<?php echo $knvior->id ?>"><?php echo $knvior->code . '-' . $knvior->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Active"> Fast breathing (60 breaths per min) </label>
                                                <select class="form-control" id="fk_anc_fast_breathing_baby" name="fk_anc_fast_breathing_baby">
                                                    <option value="0">Please Select</option>
                                                    <?php
                                                    if (!empty($knowledgebehavior)) {
                                                        foreach ($knowledgebehavior as $knvior) {
                                                            ?>
                                                            <option <?php
                                                            if ($pregnancy_info->fk_anc_fast_breathing_baby == $knvior->id) {
                                                                echo "selected=selected";
                                                            }
                                                            ?> value="<?php echo $knvior->id ?>"><?php echo $knvior->code . '-' . $knvior->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Active"> Convulsions </label>
                                                <select class="form-control" id="fk_anc_convulsions_baby" name="fk_anc_convulsions_baby">
                                                    <option value="0">Please Select</option>
                                                    <?php
                                                    if (!empty($knowledgebehavior)) {
                                                        foreach ($knowledgebehavior as $knvior) {
                                                            ?>
                                                            <option <?php
                                                            if ($pregnancy_info->fk_anc_convulsions_baby == $knvior->id) {
                                                                echo "selected=selected";
                                                            }
                                                            ?> value="<?php echo $knvior->id ?>"><?php echo $knvior->code . '-' . $knvior->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Active"> Drowsy or unconscious </label>
                                                <select class="form-control" id="fk_anc_drowsy_baby" name="fk_anc_drowsy_baby">
                                                    <option value="0">Please Select</option>
                                                    <?php
                                                    if (!empty($knowledgebehavior)) {
                                                        foreach ($knowledgebehavior as $knvior) {
                                                            ?>
                                                            <option <?php
                                                            if ($pregnancy_info->fk_anc_drowsy_baby == $knvior->id) {
                                                                echo "selected=selected";
                                                            }
                                                            ?> value="<?php echo $knvior->id ?>"><?php echo $knvior->code . '-' . $knvior->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Active"> Movement only when stimulated or no movement at all </label>
                                                <select class="form-control" id="fk_anc_movement_baby" name="fk_anc_movement_baby">
                                                    <option value="0">Please Select</option>
                                                    <?php
                                                    if (!empty($knowledgebehavior)) {
                                                        foreach ($knowledgebehavior as $knvior) {
                                                            ?>
                                                            <option <?php
                                                            if ($pregnancy_info->fk_anc_movement_baby == $knvior->id) {
                                                                echo "selected=selected";
                                                            }
                                                            ?> value="<?php echo $knvior->id ?>"><?php echo $knvior->code . '-' . $knvior->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Active"> Grunting </label>
                                                <select class="form-control" id="fk_anc_grunting_baby" name="fk_anc_grunting_baby">
                                                    <option value="0">Please Select</option>
                                                    <?php
                                                    if (!empty($knowledgebehavior)) {
                                                        foreach ($knowledgebehavior as $knvior) {
                                                            ?>
                                                            <option <?php
                                                            if ($pregnancy_info->fk_anc_grunting_baby == $knvior->id) {
                                                                echo "selected=selected";
                                                            }
                                                            ?> value="<?php echo $knvior->id ?>"><?php echo $knvior->code . '-' . $knvior->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Active"> Severe chest indrawing </label>
                                                <select class="form-control" id="fk_anc_indrawing_baby" name="fk_anc_indrawing_baby">
                                                    <option value="0">Please Select</option>
                                                    <?php
                                                    if (!empty($knowledgebehavior)) {
                                                        foreach ($knowledgebehavior as $knvior) {
                                                            ?>
                                                            <option <?php
                                                            if ($pregnancy_info->fk_anc_indrawing_baby == $knvior->id) {
                                                                echo "selected=selected";
                                                            }
                                                            ?> value="<?php echo $knvior->id ?>"><?php echo $knvior->code . '-' . $knvior->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Active"> Baby Too hot (raised temperature, > 38 °C) </label>
                                                <select class="form-control" id="fk_anc_temperature_baby" name="fk_anc_temperature_baby">
                                                    <option value="0">Please Select</option>
                                                    <?php
                                                    if (!empty($knowledgebehavior)) {
                                                        foreach ($knowledgebehavior as $knvior) {
                                                            ?>
                                                            <option <?php
                                                            if ($pregnancy_info->fk_anc_temperature_baby == $knvior->id) {
                                                                echo "selected=selected";
                                                            }
                                                            ?> value="<?php echo $knvior->id ?>"><?php echo $knvior->code . '-' . $knvior->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Active"> Baby too cold (hypothermia, < 35.5 °C </label>
                                                <select class="form-control" id="fk_anc_hypothermia_baby" name="fk_anc_hypothermia_baby">
                                                    <option value="0">Please Select</option>
                                                    <?php
                                                    if (!empty($knowledgebehavior)) {
                                                        foreach ($knowledgebehavior as $knvior) {
                                                            ?>
                                                            <option <?php
                                                            if ($pregnancy_info->fk_anc_hypothermia_baby == $knvior->id) {
                                                                echo "selected=selected";
                                                            }
                                                            ?> value="<?php echo $knvior->id ?>"><?php echo $knvior->code . '-' . $knvior->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Active"> Central cyanosis </label>
                                                <select class="form-control" id="fk_anc_central_cyanosis_baby" name="fk_anc_central_cyanosis_baby">
                                                    <option value="0">Please Select</option>
                                                    <?php
                                                    if (!empty($knowledgebehavior)) {
                                                        foreach ($knowledgebehavior as $knvior) {
                                                            ?>
                                                            <option <?php
                                                            if ($pregnancy_info->fk_anc_central_cyanosis_baby == $knvior->id) {
                                                                echo "selected=selected";
                                                            }
                                                            ?> value="<?php echo $knvior->id ?>"><?php echo $knvior->code . '-' . $knvior->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Active"> Red coloration of umbilicus</label>
                                                <select class="form-control" id="fk_anc_umbilicus_baby" name="fk_anc_umbilicus_baby">
                                                    <option value="0">Please Select</option>
                                                    <?php
                                                    if (!empty($knowledgebehavior)) {
                                                        foreach ($knowledgebehavior as $knvior) {
                                                            ?>
                                                            <option <?php
                                                            if ($pregnancy_info->fk_anc_umbilicus_baby == $knvior->id) {
                                                                echo "selected=selected";
                                                            }
                                                            ?>  value="<?php echo $knvior->id ?>"><?php echo $knvior->code . '-' . $knvior->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                </select>
                                            </div>
                                        </div>

                                    </fieldset>

                                    <fieldset class="scheduler-border" style="border:1px solid red">
                                        <legend class="scheduler-border">Did you know about referral of complicated pregnancy?</legend>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Active"> If the labour is prolonged </label>
                                                <select class="form-control" id="fk_anc_labour_preg" name="fk_anc_labour_preg">
                                                    <option value="0">Please Select</option>
                                                    <?php
                                                    if (!empty($knowledgebehavior)) {
                                                        foreach ($knowledgebehavior as $knvior) {
                                                            ?>
                                                            <option <?php
                                                            if ($pregnancy_info->fk_anc_labour_preg == $knvior->id) {
                                                                echo "selected=selected";
                                                            }
                                                            ?> value="<?php echo $knvior->id ?>"><?php echo $knvior->code . '-' . $knvior->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Active"> If there is  excessive bleeding per vagina  </label>
                                                <select class="form-control" id="fk_anc_excessive_bld_pre" name="fk_anc_excessive_bld_pre">
                                                    <option value="0">Please Select</option>
                                                    <?php
                                                    if (!empty($knowledgebehavior)) {
                                                        foreach ($knowledgebehavior as $knvior) {
                                                            ?>
                                                            <option <?php
                                                            if ($pregnancy_info->fk_anc_excessive_bld_pre == $knvior->id) {
                                                                echo "selected=selected";
                                                            }
                                                            ?> value="<?php echo $knvior->id ?>"><?php echo $knvior->code . '-' . $knvior->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Active"> If there is severe headache </label>
                                                <select class="form-control" id="fk_anc_severe_headache_preg" name="fk_anc_severe_headache_preg">
                                                    <option value="0">Please Select</option>
                                                    <?php
                                                    if (!empty($knowledgebehavior)) {
                                                        foreach ($knowledgebehavior as $knvior) {
                                                            ?>
                                                            <option <?php
                                                            if ($pregnancy_info->fk_anc_severe_headache_preg == $knvior->id) {
                                                                echo "selected=selected";
                                                            }
                                                            ?> value="<?php echo $knvior->id ?>"><?php echo $knvior->code . '-' . $knvior->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Active"> If there is obstructed labour </label>
                                                <select class="form-control" id="fk_anc_obstructed_preg" name="fk_anc_obstructed_preg">
                                                    <option value="0">Please Select</option>
                                                    <?php
                                                    if (!empty($knowledgebehavior)) {
                                                        foreach ($knowledgebehavior as $knvior) {
                                                            ?>
                                                            <option <?php
                                                            if ($pregnancy_info->fk_anc_obstructed_preg == $knvior->id) {
                                                                echo "selected=selected";
                                                            }
                                                            ?> value="<?php echo $knvior->id ?>"><?php echo $knvior->code . '-' . $knvior->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Active"> If there is convulsion </label>
                                                <select class="form-control" id="fk_anc_convulsion_preg" name="fk_anc_convulsion_preg">
                                                    <option value="0">Please Select</option>
                                                    <?php
                                                    if (!empty($knowledgebehavior)) {
                                                        foreach ($knowledgebehavior as $knvior) {
                                                            ?>
                                                            <option <?php
                                                            if ($pregnancy_info->fk_anc_convulsion_preg == $knvior->id) {
                                                                echo "selected=selected";
                                                            }
                                                            ?> value="<?php echo $knvior->id ?>"><?php echo $knvior->code . '-' . $knvior->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Active"> If the placenta retained over time ( > 30 min)  </label>
                                                <select class="form-control" id="fk_anc_placenta_preg" name="fk_anc_placenta_preg">
                                                    <option value="0">Please Select</option>
                                                    <?php
                                                    if (!empty($knowledgebehavior)) {
                                                        foreach ($knowledgebehavior as $knvior) {
                                                            ?>
                                                            <option <?php
                                                            if ($pregnancy_info->fk_anc_placenta_preg == $knvior->id) {
                                                                echo "selected=selected";
                                                            }
                                                            ?> value="<?php echo $knvior->id ?>"><?php echo $knvior->code . '-' . $knvior->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                </select>
                                            </div>
                                        </div>

                                    </fieldset>


                                    <fieldset class="scheduler-border" style="border:1px solid red">
                                        <legend class="scheduler-border">Did you know about referral of complicated newborn and child?</legend>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Active"> If the baby does not breath well </label>
                                                <select class="form-control" id="fk_anc_breath_child" name="fk_anc_breath_child">
                                                    <option value="0">Please Select</option>
                                                    <?php
                                                    if (!empty($knowledgebehavior)) {
                                                        foreach ($knowledgebehavior as $knvior) {
                                                            ?>
                                                            <option <?php
                                                            if ($pregnancy_info->fk_anc_breath_child == $knvior->id) {
                                                                echo "selected=selected";
                                                            }
                                                            ?> value="<?php echo $knvior->id ?>"><?php echo $knvior->code . '-' . $knvior->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Active"> If the baby could not suck well  </label>
                                                <select class="form-control" id="fk_anc_suck_baby" name="fk_anc_suck_baby">
                                                    <option value="0">Please Select</option>
                                                    <?php
                                                    if (!empty($knowledgebehavior)) {
                                                        foreach ($knowledgebehavior as $knvior) {
                                                            ?>
                                                            <option <?php
                                                            if ($pregnancy_info->fk_anc_suck_baby == $knvior->id) {
                                                                echo "selected=selected";
                                                            }
                                                            ?> value="<?php echo $knvior->id ?>"><?php echo $knvior->code . '-' . $knvior->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Active"> If the baby is too hot or too cold </label>
                                                <select class="form-control" id="fk_anc_hot_cold_child" name="fk_anc_hot_cold_child">
                                                    <option value="0">Please Select</option>
                                                    <?php
                                                    if (!empty($knowledgebehavior)) {
                                                        foreach ($knowledgebehavior as $knvior) {
                                                            ?>
                                                            <option <?php
                                                            if ($pregnancy_info->fk_anc_hot_cold_child == $knvior->id) {
                                                                echo "selected=selected";
                                                            }
                                                            ?> value="<?php echo $knvior->id ?>"><?php echo $knvior->code . '-' . $knvior->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Active"> If the baby turns blue </label>
                                                <select class="form-control" id="fk_anc_blue_child" name="fk_anc_blue_child">
                                                    <option value="0">Please Select</option>
                                                    <?php
                                                    if (!empty($knowledgebehavior)) {
                                                        foreach ($knowledgebehavior as $knvior) {
                                                            ?>
                                                            <option <?php
                                                            if ($pregnancy_info->fk_anc_blue_child == $knvior->id) {
                                                                echo "selected=selected";
                                                            }
                                                            ?> value="<?php echo $knvior->id ?>"><?php echo $knvior->code . '-' . $knvior->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Active"> If there  is convulsion </label>
                                                <select class="form-control" id="fk_anc_convulsion_child" name="fk_anc_convulsion_child">
                                                    <option value="0">Please Select</option>
                                                    <?php
                                                    if (!empty($knowledgebehavior)) {
                                                        foreach ($knowledgebehavior as $knvior) {
                                                            ?>
                                                            <option <?php
                                                            if ($pregnancy_info->fk_anc_convulsion_child == $knvior->id) {
                                                                echo "selected=selected";
                                                            }
                                                            ?> value="<?php echo $knvior->id ?>"><?php echo $knvior->code . '-' . $knvior->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Active"> If there is severe chest indrawing   </label>
                                                <select class="form-control" id="fk_anc_indrawing_child" name="fk_anc_indrawing_child">
                                                    <option value="0">Please Select</option>
                                                    <?php
                                                    if (!empty($knowledgebehavior)) {
                                                        foreach ($knowledgebehavior as $knvior) {
                                                            ?>
                                                            <option <?php
                                                            if ($pregnancy_info->fk_anc_indrawing_child == $knvior->id) {
                                                                echo "selected=selected";
                                                            }
                                                            ?> value="<?php echo $knvior->id ?>"><?php echo $knvior->code . '-' . $knvior->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                </select>
                                            </div>
                                        </div>

                                    </fieldset>

                                </fieldset>

                            </fieldset>

                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border">PNC-for Mother</legend>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="Active"> Do you take vitamin A supplement for post-partum period? <span style="color:red">*</span></label>
                                            <select class="form-control" id="fk_supliment_post" name="fk_supliment_post">
                                                <option value="0">Please Select</option>
                                                <?php
                                                if (!empty($onlyYesNo)) {
                                                    foreach ($onlyYesNo as $onlyyn) {
                                                        ?>
                                                        <option <?php
                                                        if ($pregnancy_info->fk_supliment_post == $onlyyn->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $onlyyn->id ?>"><?php echo $onlyyn->code . '-' . $onlyyn->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="Active"> Within 42 days of the birth of the baby you ever had a check-up? <span style="color:red">*</span></label>
                                            <select class="form-control required" id="checkupType" name="checkupType" required>
                                                <option value="">Please Select</option>
                                                <?php
                                                if (!empty($onlyYesNo)) {
                                                    foreach ($onlyYesNo as $onlyyn) {
                                                        ?>
                                                        <option <?php
                                                        if ($pregnancy_info->fk_pnc_chkup_mother_id == $onlyyn->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $onlyyn->id ?>"><?php echo $onlyyn->code . '-' . $onlyyn->name ?></option>
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
                                            <input type="number" class="form-control afterTotalTimes" id="afterTotalTimes"  name="afterTotalTimes" value="<?php echo $pregnancy_info->pnc_chkup_mother_times ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6 manyTimes">
                                        <div class="form-group">
                                            <label for="Active"> Is post-natal visit conducted within 2 days or 48 hours of delivery? <span style="color:red">*</span></label>
                                            <select class="form-control" id="fk_post_natal_visit" name="fk_post_natal_visit">
                                                <option value="0">Please Select</option>
                                                <?php
                                                if (!empty($onlyYesNo)) {
                                                    foreach ($onlyYesNo as $onlyyn) {
                                                        ?>
                                                        <option <?php
                                                        if ($pregnancy_info->fk_post_natal_visit == $onlyyn->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $onlyyn->id ?>"><?php echo $onlyyn->code . '-' . $onlyyn->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>

                                </div> 
                                <div class="row manyTimes">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Active">Who assist during PNC(First Visit)</label>
                                            <select class="form-control required" id="pncFirstVisitAsist" name="pncFirstVisitAsist">
                                                <option value="0">Please Select</option>
                                                <?php
                                                if (!empty($pnc_assist_typ)) {
                                                    foreach ($pnc_assist_typ as $pnc_assist_typ) {
                                                        ?>
                                                        <option <?php
                                                        if ($pregnancy_info->fk_pnc_first_visit_assist == $pnc_assist_typ->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $pnc_assist_typ->id ?>"><?php echo $pnc_assist_typ->code . '-' . $pnc_assist_typ->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Active">Place of PNC first visit</label>
                                            <select class="form-control required" id="firstVisit" name="firstVisit">
                                                <option value="0">Please Select</option>
                                                <?php
                                                if (!empty($ancPncVisit)) {
                                                    foreach ($ancPncVisit as $ancPncVisit1) {
                                                        ?>
                                                        <option <?php
                                                        if ($pregnancy_info->fk_pnc_first_visit_id == $ancPncVisit1->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $ancPncVisit1->id ?>"><?php echo $ancPncVisit1->code . '-' . $ancPncVisit1->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">

                                            <label for="Active">After days of delivery(Days only)</label>
                                            <input type="number" class="form-control " name="firstVisitDays" value="<?php echo $pregnancy_info->pnc_first_visit_days ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Active">Who assist during PNC(Second Visit)</label>
                                            <select class="form-control required" id="pncSecondVisitAsist" name="pncSecondVisitAsist">
                                                <option value="0">Please Select</option>
                                                <?php
                                                if (!empty($pnc_assist_typ1)) {
                                                    foreach ($pnc_assist_typ1 as $pnc_assist_typ1) {
                                                        ?>
                                                        <option <?php
                                                        if ($pregnancy_info->fk_pnc_second_visit_assist == $pnc_assist_typ1->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $pnc_assist_typ1->id ?>"><?php echo $pnc_assist_typ1->code . '-' . $pnc_assist_typ1->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Active">Place of PNC second visit </label>
                                            <select class="form-control required" id="secondVisit" name="secondVisit">
                                                <option value="0">Please Select</option>
                                                <?php
                                                if (!empty($ancPncVisit)) {
                                                    foreach ($ancPncVisit as $ancPncVisit2) {
                                                        ?>
                                                        <option <?php
                                                        if ($pregnancy_info->fk_pnc_second_visit_id == $ancPncVisit2->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $ancPncVisit2->id ?>"><?php echo $ancPncVisit2->code . '-' . $ancPncVisit2->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">

                                            <label for="Active">After days of delivery(Days only)</label>
                                            <input type="number" class="form-control " name="secondVisitDays" value="<?php echo $pregnancy_info->pnc_second_visit_days ?>">
                                        </div>
                                    </div>

                                </div>

                            </fieldset>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Active">Remarks</label>
                                        <textarea class="form-control " name="remarks" ><?php echo $pregnancy_info->remarks ?></textarea>
                                    </div>
                                </div>  
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


    

    $("#fk_conception_result").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");

            if(optionValue == 95)
            {
              
                $(".birthAttended").hide();

            } 
            else if(optionValue == 199)
            {
              
                $(".birthAttended").hide();

            }
            else{

                $(".birthAttended").show();
               
            }
        });
    }).change();


    $("#fk_first_milk").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");

            //alert(optionValue);

            if(optionValue == 215)
            {
                $(".milk_hours").prop('required',true);
                $(".milk_day").prop('required',false);
                $(".hours").show();
                $(".days").hide();

            } 
            else if(optionValue == 216)
            {
                $(".milk_hours").prop('required',false);
                $(".milk_day").prop('required',true);
                $(".hours").hide();
                $(".days").show();

            }
            else{

                $(".milk_hours").prop('required',false);
                $(".milk_day").prop('required',false);

                $(".hours").hide();
                $(".days").hide();
               
            }
        });
    }).change();

    $("#fk_delivery_term_place").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");

            //alert(optionValue);

            if(optionValue == 103)
            {
              
                $(".facility").hide();

            } 
            else if(optionValue == 104)
            {
              
                $(".facility").hide();

            }
            else if(optionValue == 205)
            {
              
                $(".facility").hide();

            }
            else{

                $(".facility").show();
               
            }
        });
    }).change();


    $("#fk_how_many_tab").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");

           // alert(optionValue);

            if(optionValue == 226)
            {
               $(".totalNumberTablet").prop('required',true);
               $(".numbers").show();

            } else{

               $(".totalNumberTablet").prop('required',false);
               $(".numbers").hide();
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


    
    $("#fk_supliment").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");

            if(optionValue == 1)
            {
               $(".supplement").show();

            } else{

               $(".supplement").hide();
            }
        });
    }).change();

    $("#fk_suspecred_infection").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");


            if(optionValue == 228)
            {
               $(".antibiotics").show();
               $(".antibiotics_pres").show();

            } else{

               $(".antibiotics").hide();
               $(".antibiotics_pres").hide();
            }
        });
    }).change();


    $("#fk_baby_antibiotics").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");


            if(optionValue == 1)
            {
               $(".antibiotics_pres").show();

            } else{

               $(".antibiotics_pres").hide();
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

