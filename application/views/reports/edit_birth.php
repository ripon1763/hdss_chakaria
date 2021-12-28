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
                    <a class="btn btn-primary" href="<?php echo base_url() . $controller . '/birth?baseID=' . $baseID ?>"><?php echo $shortName ?> List</a>
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
                        <input type="hidden" name="household_master_id" value="<?php echo $birth_info->household_master_id_hh ?>">
                        <input type="hidden" name="member_household_id_last" value="<?php echo $birth_info->member_household_id_last ?>">
                        <input type="hidden" name="fk_education_id_last" value="<?php echo $birth_info->fk_education_id_last ?>">
                        <input type="hidden" name="fk_occupation_id_last" value="<?php echo $birth_info->fk_occupation_id_last ?>">
                        <input type="hidden" name="fk_member_relation_id_last" value="<?php echo $birth_info->fk_member_relation_id_last ?>">
                        <input type="hidden" name="member_master_id" value="<?php echo $birth_info->id ?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <b>Household Code:</b> <?php echo $birth_info->household_code; ?>
                                </div>
                                <div class="col-md-3 form-group">
                                    <b>Round No:</b> <?php echo $birth_info->round_master_id_entry_round; ?>
                                </div>
                                <div class="col-md-3 form-group">
                                    <b>Member Code:</b> <?php echo $birth_info->member_code; ?>
                                </div>
                                <div class="col-md-3 form-group">
                                    <b>Member Name:</b> <?php echo $birth_info->member_name; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <b>Member Sex:</b> <?php echo $birth_info->gender_code . '-' . $birth_info->gender_name; ?>
                                </div>
                            </div>
                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border">Birth Information</legend>
                                <div class="row">

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="Item Name">Child Name <span style="color:red">*</span></label>
                                            <input type="text" class="form-control required" id="memberName" value="<?php echo $birth_info->member_name ?>" name="memberName" maxlength="255" required="required">
                                        </div>
                                    </div>


                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="Active">Sex  <span style="color:red">*</span></label>
                                            <select class="form-control required" id="sexType" name="sexType" required>
                                                <option value="">Please Select</option>
                                                <?php
                                                if (!empty($membersextype)) {
                                                    foreach ($membersextype as $membersex) {
                                                        ?>
                                                        <option <?php
                                                        if ($birth_info->fk_sex == $membersex->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $membersex->id ?>"><?php echo $membersex->code . '-' . $membersex->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="Item Name">Birth Time <span style="color:red">*</span></label>
                                            <input type="text" class="form-control required" id="" value="<?php echo $birth_info->birth_time ?>"  name="birth_time" maxlength="255" required="required">
                                        </div>
                                    </div> 

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="Item Name">Birth Weight (KG) <span style="color:red">*</span></label>
                                            <input type="number" class="form-control required" id="birth_weight" value="<?php echo $birth_info->birth_weight ?>"  name="birth_weight" value="0.00" step=".01" required="required">
                                        </div>
                                    </div> 

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="Item Name">Birth weight status  <span style="color:red">*</span></label>

                                            <select class="form-control required" id="fk_birth_weight_size" name="fk_birth_weight_size" required>
                                                <option value="">Please Select</option>
                                                <?php
                                                if (!empty($birth_weight_size)) {
                                                    foreach ($birth_weight_size as $birth_weight) {
                                                        ?>
                                                        <option <?php
                                                        if ($birth_info->fk_birth_weight_size == $birth_weight->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $birth_weight->id ?>"><?php echo $birth_weight->code . '-' . $birth_weight->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="Item Name">Father's RID</label>

                                            <select class="form-control" id="fatherCode" name="fatherCode">
                                                <option value="">Please Select</option>
                                                <?php
                                                if (!empty($maleList)) {
                                                    foreach ($maleList as $male) {
                                                        ?>
                                                        <option <?php
                                                        if ($birth_info->fk_father_id == $male->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $male->id ?>"><?php echo $male->member_code . '-' . $male->member_name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="Item Name">Mother's RID  <span style="color:red">*</span></label>
                                            <select class="form-control required" id="motherCode" name="motherCode" required>
                                                <option value="">Please Select</option>
                                                <?php
                                                if (!empty($femaleList)) {
                                                    foreach ($femaleList as $female) {
                                                        ?>
                                                        <option <?php
                                                        if ($birth_info->fk_mother_id == $female->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $female->id ?>"><?php echo $female->member_code . '-' . $female->member_name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="Item Name">Pregnancy ourcome date <span style="color:red">*</span></label>
                                            <select class="form-control required" id="outCodeDate" name="pregnancy_outcome_id" required>
                                                <option value="">--- Select date ---</option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="Active">Relation with household head  <span style="color:red">*</span></label>
                                            <select class="form-control required" id="relationheadID" name="relationheadID" required>
                                                <option value="">Please Select</option>
                                                <?php
                                                if (!empty($relationhhh)) {
                                                    foreach ($relationhhh as $relationhhh) {
                                                        ?>
                                                        <option <?php
                                                        if ($birth_info->fk_relation_with_hhh == $relationhhh->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $relationhhh->id ?>"><?php echo $relationhhh->code . '-' . $relationhhh->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="Active">Entry type <span style="color:red">*</span></label>
                                            <select class="form-control required" id="entryType" name="entryType" required>
                                                <!-- <option value="">Please Select</option>-->
                                                <?php
                                                if (!empty($entryType)) {
                                                    foreach ($entryType as $entryType) {
                                                        ?>
                                                        <option <?php
                                                        if ($birth_info->fk_entry_type == $entryType->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $entryType->id ?>"><?php echo $entryType->code . '-' . $entryType->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="Item Name">Entry Date <span style="color:red">*</span></label>

                                            <?php
                                            if ($birth_info->entry_date != "") {
                                                $partsRequire = explode('-', $birth_info->entry_date);
                                                $entry_date = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];
                                            }
                                            ?>
                                            <input type="text" class="form-control required" id="datepicker" value="<?php echo $entry_date ?>" name="entryDate" maxlength="255" required="required">
                                        </div>
                                    </div> 

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="Active">Present Marital status <span style="color:red">*</span></label>
                                            <select class="form-control required" id="maritalStatusType" name="maritalStatusType" required>

                                                <?php
                                                if (!empty($maritalstatustyp)) {
                                                    foreach ($maritalstatustyp as $maritalstatu) {
                                                        ?>
                                                        <option <?php
                                                        if ($birth_info->fk_marital_status == $maritalstatu->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $maritalstatu->id ?>"><?php echo $maritalstatu->code . '-' . $maritalstatu->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="Active">Religion <span style="color:red">*</span></label>
                                            <select class="form-control required" id="religionType" name="religionType" required>
                                                <option value="">Please Select</option>
                                                <?php
                                                if (!empty($religion)) {
                                                    foreach ($religion as $religion) {
                                                        ?>
                                                        <option <?php
                                                        if ($birth_info->fk_religion == $religion->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $religion->id ?>"><?php echo $religion->code . '-' . $religion->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="Active">Type of education <span style="color:red">*</span></label>
                                            <select class="form-control required" id="educationType" name="educationType" required>
                                                <option value="">Please Select</option>
                                                <?php
                                                if (!empty($educationtyp)) {
                                                    foreach ($educationtyp as $educationtyp) {
                                                        ?>
                                                        <option <?php
                                                        if ($birth_info->fk_education_type == $educationtyp->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $educationtyp->id ?>"><?php echo $educationtyp->code . '-' . $educationtyp->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>


                                    <!-- <div class="col-md-3">
                                       <div class="form-group">
                                         <label for="Active">Secular education</label>
                                         <select class="form-control required" id="secularEduType" name="secularEduType" required>
                                           <option value="">Please Select</option>
                                    <?php
                                    if (!empty($secularedutyp)) {
                                        foreach ($secularedutyp as $secularedutyp) {
                                            ?>
                                                                                                                                                                                                                               <option <?php
                                            if ($fk_secular_edu == $secularedutyp->id) {
                                                echo "selected=selected";
                                            }
                                            ?> value="<?php echo $secularedutyp->id ?>"><?php echo $secularedutyp->code . '-' . $secularedutyp->name ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                           
                                         </select>
                                       </div>
                                     </div>
                                     <div class="col-md-3">
                                       <div class="form-group">
                                         <label for="Active">Religious education </label>
                                         <select class="form-control required" id="religiousEduType" name="religiousEduType" required>
                                           <option value="">Please Select</option>
                                    <?php
                                    if (!empty($religiousedutype)) {
                                        foreach ($religiousedutype as $religiousedu) {
                                            ?>
                                                                                                                                                                                                                               <option <?php
                                            if ($fk_religious_edu == $religiousedu->id) {
                                                echo "selected=selected";
                                            }
                                            ?> value="<?php echo $religiousedu->id ?>"><?php echo $religiousedu->code . '-' . $religiousedu->name ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                           
                                         </select>
                                       </div>
                                     </div> -->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="Active">Main occupation <span style="color:red">*</span></label>
                                            <select class="form-control required" id="occupationType" name="occupationType" required>
                                                <option value="">Please Select</option>
                                                <?php
                                                if (!empty($occupationtyp)) {
                                                    foreach ($occupationtyp as $occupationtyp) {
                                                        ?>
                                                        <option <?php
                                                        if ($birth_info->fk_main_occupation == $occupationtyp->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $occupationtyp->id ?>"><?php echo $occupationtyp->code . '-' . $occupationtyp->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="Active">Mother live birth order </label>
                                            <select class="form-control required" id="fk_mother_live_birth_order" name="fk_mother_live_birth_order" required>

                                                <?php
                                                if (!empty($mother_live_birth_order)) {
                                                    foreach ($mother_live_birth_order as $live_birth_order) {
                                                        ?>
                                                        <option <?php
                                                        if ($birth_info->fk_mother_live_birth_order == $live_birth_order->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?>  value="<?php echo $live_birth_order->id ?>"><?php echo $live_birth_order->code . '-' . $live_birth_order->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="Active">Birth registration done <span style="color:red">*</span></label>
                                            <select class="form-control required" id="birstRegiType" name="birstRegiType" required>
                                                <option value="">Please Select</option>
                                                <?php
                                                if (!empty($birthregistration)) {
                                                    foreach ($birthregistration as $birthregistration) {
                                                        ?>
                                                        <option <?php
                                                        if ($birth_info->fk_birth_registration == $birthregistration->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $birthregistration->id ?>"><?php echo $birthregistration->code . '-' . $birthregistration->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 birthRegi">
                                        <div class="form-group">
                                            <label for="Item Name">Registration date <span style="color:red">*</span></label>

                                            <?php
                                            if ($birth_info->birth_registration_date != "") {
                                                $partsRequire = explode('-', $birth_info->birth_registration_date);
                                                $birth_registration_date = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];
                                            }
                                            ?>
                                            <input type="text" class="form-control birthRegidate" id="birthRegidate" value="<?php echo $birth_registration_date ?>"  name="birthRegidate" maxlength="255">
                                        </div>
                                    </div>

                                    <div class="col-md-3 notRegi" <?php if ($birth_info->fk_birth_registration != 4) echo " style='display:none'"; ?>>
                                        <div class="form-group">
                                            <label for="Active">why not registration <span style="color:red">*</span></label>
                                            <select class="form-control whyNotRegi" id="whyNotRegi" name="whyNotRegi">
                                                <option value="">Please Select</option>
                                                <?php
                                                if (!empty($whynotbirthreg)) {
                                                    foreach ($whynotbirthreg as $whynotbirthreg) {
                                                        ?>
                                                        <option <?php
                                                        if ($birth_info->fk_why_not_birth_registration == $whynotbirthreg->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $whynotbirthreg->id ?>"><?php echo $whynotbirthreg->code . '-' . $whynotbirthreg->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">

                                            <label for="Active">Keep Follow up for PNC <span style="color:red">*</span></label>
                                            <select class="form-control required" id="keep_follow_up" name="keep_follow_up" required>
                                                <option <?php
                                                if ($birth_info->keep_follow_up == 1) {
                                                    echo "selected=selected";
                                                }
                                                ?> value="1">Yes</option>
                                                <option <?php
                                                if ($birth_info->keep_follow_up == 0) {
                                                    echo "selected=selected";
                                                }
                                                ?> value="0">No</option>

                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </fieldset>

                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border">PNC-for Child</legend>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="Active"> Birth of the child (name) is made to check-up within 42 days? </label>
                                            <select class="form-control" id="checkupTypeChild" name="checkupTypeChild" >
                                                <option value="">Please Select</option>
                                                <?php
                                                if (!empty($onlyYesNo)) {
                                                    foreach ($onlyYesNo as $onlyync) {
                                                        ?>
                                                        <option <?php
                                                        if ($birth_info->fk_pnc_chkup_child_id == $onlyync->id) {
                                                            echo "selected=selected";
                                                        }
                                                        ?> value="<?php echo $onlyync->id ?>"><?php echo $onlyync->code . '-' . $onlyync->name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 manyTimesChild">
                                        <div class="form-group">
                                            <label for="Item Name">If yes, Total times <span style="color:red">*</span></label>
                                            <input type="number" class="form-control afterTotalTimesChild" id="afterTotalTimesChild"  name="afterTotalTimesChild" value="<?php echo $birth_info->pnc_chkup_child_times ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-6 manyTimesChild">
                                        <div class="form-group">
                                            <label for="Active"> Is post-natal visit conducted within 2 days or 48 hours of delivery?</label>
                                            <select class="form-control" id="fk_post_natal_visit" name="fk_post_natal_visit">
                                                <option value="">Please Select</option>
                                                <?php
                                                if (!empty($onlyYesNo)) {
                                                    foreach ($onlyYesNo as $onlyyn) {
                                                        ?>
                                                        <option <?php
                                                            if ($birth_info->fk_post_natal_child_visit == $onlyyn->id) {
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
                                <div class="row manyTimesChild">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Active">Who assist during PNC? (First visit)</label>
                                            <select class="form-control" id="childFirstVisitAsist" name="childFirstVisitAsist">
                                                <option value="">Please Select</option>
                                                <?php
                                                if (!empty($pncassisttyp)) {
                                                    foreach ($pncassisttyp as $pncassisttyp_single) {
                                                        ?>
                                                        <option <?php
                                                            if ($birth_info->fk_child_first_visit_assist == $pncassisttyp_single->id) {
                                                                echo "selected=selected";
                                                            }
                                                            ?> value="<?php echo $pncassisttyp_single->id ?>"><?php echo $pncassisttyp_single->code . '-' . $pncassisttyp_single->name ?></option>
        <?php
    }
}
?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Active">Place of First Visit</label>
                                            <select class="form-control" id="childFirstVisit" name="childFirstVisit">
                                                <option value="">Please Select</option>
                                                    <?php
                                                    if (!empty($ancPncVisit)) {
                                                        foreach ($ancPncVisit as $childancPncVisit1) {
                                                            ?>
                                                        <option <?php
                                                    if ($birth_info->fk_pnc_first_visit_id == $childancPncVisit1->id) {
                                                        echo "selected=selected";
                                                    }
                                                    ?> value="<?php echo $childancPncVisit1->id ?>"><?php echo $childancPncVisit1->code . '-' . $childancPncVisit1->name ?></option>
        <?php
    }
}
?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">

                                            <label for="Active">After days of delivery?(Days only)</label>
                                            <input type="number" class="form-control " name="childFirstVisitDays" value="<?php echo $birth_info->pnc_first_visit_days ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Active">Who assist during PNC? (Second visit)</label>
                                            <select class="form-control" id="childSecondVisitAsist" name="childSecondVisitAsist">
                                                <option value="">Please Select</option>
                                                    <?php
                                                    if (!empty($pncassisttyp)) {
                                                        foreach ($pncassisttyp as $pncassisttyp_single) {
                                                            ?>
                                                        <option <?php
                                                            if ($birth_info->fk_child_second_visit_assist == $pncassisttyp_single->id) {
                                                                echo "selected=selected";
                                                            }
                                                            ?> value="<?php echo $pncassisttyp_single->id ?>"><?php echo $pncassisttyp_single->code . '-' . $pncassisttyp_single->name ?></option>
        <?php
    }
}
?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Active">Place of Second Visit </label>
                                            <select class="form-control" id="childSecondVisit" name="childSecondVisit">
                                                <option value="">Please Select</option>
                                                    <?php
                                                    if (!empty($ancPncVisit)) {
                                                        foreach ($ancPncVisit as $childancPncVisit2) {
                                                            ?>
                                                        <option <?php
                                                            if ($birth_info->fk_pnc_second_visit_id == $childancPncVisit2->id) {
                                                                echo "selected=selected";
                                                            }
                                                            ?> value="<?php echo $childancPncVisit2->id ?>"><?php echo $childancPncVisit2->code . '-' . $childancPncVisit2->name ?></option>
        <?php
    }
}
?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">

                                            <label for="Active">After days of delivery?(Days only)</label>
                                            <input type="number" class="form-control " name="childSecondVisitDays" value="<?php echo $birth_info->pnc_second_visit_days ?>">
                                        </div>
                                    </div>

                                </div>

                            </fieldset>
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

        $('#timepicker').wickedpicker();
        $('#datepicker').datepicker({
            autoclose: true,
            format: 'dd/mm/yyyy'
        });

        $('#birthRegidate').datepicker({
            autoclose: true,
            format: 'dd/mm/yyyy'
        });



        $("#birstRegiType").change(function () {

            $(this).find("option:selected").each(function () {
                var optionValue = $(this).attr("value");

                if (optionValue == 1)
                {
                    $(".birthRegidate").prop('required', true);
                    $(".whyNotRegi").prop('required', false);
                    $(".birthRegi").show();
                    $(".notRegi").hide();

                } else {

                    $(".birthRegidate").prop('required', false);
                    $(".whyNotRegi").prop('required', true);
                    $(".birthRegi").hide();
                    $(".notRegi").show();
                }
            });
        }).change();


        $('#motherCode').change(function () {
            var motherCode = $('#motherCode').val();
            if (motherCode != '')
            {
                $.ajax({
                    url: "<?php echo base_url(); ?>api/getPrenancyListbyMother",
                    method: "POST",
                    data: {motherCode: motherCode},
                    success: function (data)
                    {
                        $('#outCodeDate').html('');
                        $('#outCodeDate').html(data);
                    }
                });
            } else
            {
                $('#outCodeDate').html('<option value="">--- Select Date ---</option>');
            }
        });



        var seldistrictId = $('#motherCode').val();
        if (seldistrictId > 0)
        {

            var motherCode = $('#motherCode').val();
            if (motherCode != '')
            {
                $.ajax({
                    url: "<?php echo base_url(); ?>api/getPrenancyListbyMother",
                    method: "POST",
                    data: {motherCode: motherCode},
                    success: function (data)
                    {
                        $('#outCodeDate').html('');

                        $('#outCodeDate').html(data);
                        $('#outCodeDate').val('<?php echo $birth_info->pregnancy_outcome_id; ?>').trigger('change');
                    }
                });

            }

        }


        $("#checkupTypeChild").change(function () {
            $(this).find("option:selected").each(function () {
                var optionValue = $(this).attr("value");

                if (optionValue == 1)
                {
                    $(".afterTotalTimesChild").prop('required', true);
                    $(".manyTimesChild").show();

                } else {

                    $(".afterTotalTimesChild").prop('required', false);
                    $(".manyTimesChild").hide();
                }
            });
        }).change();

    });

</script>