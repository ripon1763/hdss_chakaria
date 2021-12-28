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
                    <a class="btn btn-primary" href="<?php echo base_url() . $controller . '/member_master?baseID=' . $baseID ?>"><?php echo $shortName ?> List</a>
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

                    <?php if ($member_master_info->fk_extinct_type > 0) : ?>

                        <p style="padding-left: 10px; color:red">This household is already extincted. You cannot change anything !!</p>

                    <?php endif; ?>

                    <form role="form" action="<?php echo base_url() . $controller . '/' . $actionMethod . '?baseID=' . $baseID ?>" method="post" id="editUser" role="form">

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <b>Household Code:</b> <?php echo $member_master_info->household_code; ?>
                                </div>
                                <div class="col-md-3 form-group">
                                    <b>Round No:</b> <?php echo $member_master_info->round_master_id_entry_round; ?>
                                </div>
                                <div class="col-md-3 form-group">
                                    <b>Member Code:</b> <?php echo $member_master_info->member_code; ?>
                                </div>
                                <div class="col-md-3 form-group">
                                    <b>Member Name:</b> <?php echo $member_master_info->member_name; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <b>Member Sex:</b> <?php echo $member_master_info->gender_code . '-' . $member_master_info->gender_name; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">District <span style="color:red">*</span></label>
                                        <input type="hidden" name="id" value="<?php echo $member_master_info->id ?>">
                                        <input type="hidden" name="household_master_id" value="<?php echo $member_master_info->household_master_id_hh ?>">
                                        <input type="hidden" name="fk_education_id_last" value="<?php echo $member_master_info->fk_education_id_last ?>">
                                        <input type="hidden" name="fk_occupation_id_last" value="<?php echo $member_master_info->fk_occupation_id_last ?>">
                                        <input type="hidden" name="fk_member_relation_id_last" value="<?php echo $member_master_info->fk_member_relation_id_last ?>">
                                        <input type="hidden" name="member_household_id_last" value="<?php echo $member_master_info->member_household_id_last ?>">

                                        <select class="form-control" id="districtID"  name="districtID" disabled="disabled">
                                            <option value="">--- Select District ---</option>
                                            <?php
                                            if (!empty($district)) {
                                                foreach ($district as $district_single) {
                                                    ?>
                                                    <option <?php
                                                    if ($district_single->id == $member_master_info->fk_district_id) {
                                                        echo "selected=selected";
                                                    }
                                                    ?> value="<?php echo $district_single->id ?>"><?php echo $district_single->code . '-' . $district_single->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">City area <span style="color:red">*</span></label>

                                        <select  class="form-control required" id="thanaID" name="thanaID" disabled="disabled">
                                            <option value="">--- Select City area ---</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Slum <span style="color:red">*</span></label>

                                        <select class="form-control required" id="slumID" name="slumID" disabled="disabled">
                                            <option value="">--- Select Slum Name---</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Slum Area <span style="color:red">*</span></label>

                                        <select class="form-control required" id="slumAreaID" name="slumAreaID" disabled="disabled">
                                            <option value="">--- Select Slum Area ---</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Household Code</label> 
                                        <input type="text" class="form-control required" value="<?php echo $member_master_info->household_code; ?>" id="household_code"  name="household_code" maxlength="255" disabled="disabled">


                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Member Code</label> 
                                        <input type="text" class="form-control required" value="<?php echo $member_master_info->member_code; ?>" id="member_code"  name="member_code" maxlength="255" disabled="disabled">


                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Active">Entry type <span style="color:red">*</span></label>

                                        <input type="text" class="form-control required" value="<?php echo $member_master_info->fk_entry_type_code . '-' . $member_master_info->fk_entry_type_name; ?>" id="entryTypeCode"  name="entryTypeCode" disabled="disabled">


                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Entry Date <span style="color:red">*</span></label>

                                        <?php
                                        if ($member_master_info->entry_date != "") {
                                            $partsRequire = explode('-', $member_master_info->entry_date);
                                            $entry_date = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];
                                        }
                                        ?>
                                        <input type="text" value="<?php echo $entry_date ?>" class="form-control required" data-provide="datepicker-inline"  name="entryDate" maxlength="255" required="required">
                                    </div>
                                </div> 
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Member Name <span style="color:red">*</span></label>
                                        <input type="text" class="form-control required" value="<?php echo $member_master_info->member_name; ?>" id="memberName"  name="memberName" maxlength="255" required="required">
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
                                                    if ($membersex->id == $member_master_info->fk_sex) {
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
                                        <?php
                                        if ($member_master_info->birth_date != "") {
                                            $partsRequire = explode('-', $member_master_info->birth_date);
                                            $birth_date = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];
                                        }
                                        ?>
                                        <label for="Item Name">Birth Date <span style="color:red">*</span></label>
                                        <input type="text" class="form-control required" value="<?php if(isset($birth_date)) echo $birth_date; ?>" id="birthdate" data-provide="datepicker-inline"  name="birthdate" maxlength="255" required="required">
                                    </div>
                                </div> 

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Father's RID</label>
                                        <select class="form-control" id="fatherCode" name="fatherCode">
                                            <option value="0">--- Select Father's ---</option>
                                            <?php
                                            if (!empty($fatherList)) {
                                                foreach ($fatherList as $father) {
                                                    ?>
                                                    <option <?php
                                                    if ($father->id == $member_master_info->fk_father_id) {
                                                        echo "selected=selected";
                                                    }
                                                    ?>  value="<?php echo $father->id ?>"><?php echo $father->member_code . '-' . $father->member_name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Mother's RID</label>
                                        <select class="form-control" id="motherCode" name="motherCode">
                                            <option value="0">--- Select Mother's ---</option>
                                            <?php
                                            if (!empty($motherList)) {
                                                foreach ($motherList as $mother) {
                                                    ?>
                                                    <option <?php
                                                    if ($mother->id == $member_master_info->fk_mother_id) {
                                                        echo "selected=selected";
                                                    }
                                                    ?> value="<?php echo $mother->id ?>"><?php echo $mother->member_code . '-' . $mother->member_name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Present Spouse's RID </label>
                                        <select class="form-control" id="spouseCode" name="spouseCode">
                                            <option value="0">--- Select Spouse's ---</option>
                                            <?php
                                            if (!empty($spouseList)) {
                                                foreach ($spouseList as $spouse) {
                                                    ?>
                                                    <option <?php
                                                    if ($spouse->id == $member_master_info->fk_spouse_id) {
                                                        echo "selected=selected";
                                                    }
                                                    ?> value="<?php echo $spouse->id ?>"><?php echo $spouse->member_code . '-' . $spouse->member_name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">National/ Voter Id </label>
                                        <input type="text" class="form-control required" value="<?php echo $member_master_info->national_id ?>"  id="nationalID"  name="nationalID" maxlength="255">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Active">Relation with household head  <span style="color:red">*</span></label>
                                        <select class="form-control required" id="relationheadID" name="relationheadID" required>
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($relationhhh)) {
                                                foreach ($relationhhh as $relationhhh_single) {
                                                    ?>
                                                    <option <?php
                                                    if ($relationhhh_single->id == $member_master_info->fk_relation_with_hhh) {
                                                        echo "selected=selected";
                                                    }
                                                    ?> value="<?php echo $relationhhh_single->id ?>"><?php echo $relationhhh_single->code . '-' . $relationhhh_single->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3 hhefectiveDate">
                                    <div class="form-group">
                                        <?php
                                        if ($member_master_info->change_date != "") {
                                            $partsRequire = explode('-', $member_master_info->change_date);
                                            $change_date = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];
                                        }
                                        ?>
                                        <label for="Item Name">Effective date (If HHH) <span style="color:red">*</span></label>
                                        <input type="text" class="form-control hhdate" value="<?php echo $member_master_info->change_date ?>" data-provide="datepicker-inline" id="hhdate"  name="hhdate" maxlength="255" >
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Active">Present Marital status <span style="color:red">*</span></label>
                                        <select class="form-control required" id="maritalStatusType" name="maritalStatusType" required>
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($maritalstatustyp)) {
                                                foreach ($maritalstatustyp as $maritalstatu) {
                                                    ?>
                                                    <option <?php
                                                    if ($maritalstatu->id == $member_master_info->fk_marital_status) {
                                                        echo "selected=selected";
                                                    }
                                                    ?>  value="<?php echo $maritalstatu->id ?>"><?php echo $maritalstatu->code . '-' . $maritalstatu->name ?></option>
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
                                                foreach ($religion as $religion_single) {
                                                    ?>
                                                    <option <?php
                                                    if ($religion_single->id == $member_master_info->fk_religion) {
                                                        echo "selected=selected";
                                                    }
                                                    ?>  value="<?php echo $religion_single->id ?>"><?php echo $religion_single->code . '-' . $religion_single->name ?></option>
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
                                                foreach ($educationtyp as $educationtyp_single) {
                                                    ?>
                                                    <option  <?php
                                                    if ($educationtyp_single->id == $member_master_info->fk_education_type) {
                                                        echo "selected=selected";
                                                    }
                                                    ?> value="<?php echo $educationtyp_single->id ?>"><?php echo $educationtyp_single->code . '-' . $educationtyp_single->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 yearEdu">
                                    <div class="form-group">
                                        <label for="Item Name">Year of Education <span style="color:red">*</span></label>
                                        <!--<input type="text" value="<?php echo $year_of_education ?>" class="form-control yearOfEdu" id="yearOfEdu"  name="yearOfEdu" maxlength="255" >-->
                                        <select class="form-control required yearOfEdu" id="yearOfEdu" name="yearOfEdu">
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($education_year)) {
                                                foreach ($education_year as $education_year_single) {
                                                    ?>
                                                    <option  <?php
                                                    if ($education_year_single->id == $member_master_info->year_of_education) {
                                                        echo "selected=selected";
                                                    }
                                                    ?> value="<?php echo $education_year_single->id ?>"><?php echo $education_year_single->code . '-' . $education_year_single->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                        </select>

                                    </div>
                                </div>


                                <!--  <div class="col-md-3">
                                      <div class="form-group">
                                          <label for="Active">Secular education</label>
                                          <select class="form-control required"  id="secularEduType" name="secularEduType">
                                              <option value="0">Please Select</option>
                                <?php
                                if (!empty($secularedutyp)) {
                                    foreach ($secularedutyp as $secularedutyp) {
                                        ?>
                                                                                                                                                                                                                                                                      <option <?php
                                        if ($secularedutyp->id == $fk_secular_edu) {
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
                                          <select class="form-control required" id="religiousEduType" name="religiousEduType">
                                              <option value="0">Please Select</option>
                                <?php
                                if (!empty($religiousedutype)) {
                                    foreach ($religiousedutype as $religiousedu) {
                                        ?>
                                                                                                                                                                                                                                                                      <option <?php
                                        if ($religiousedu->id == $fk_religious_edu) {
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
                                                foreach ($occupationtyp as $occupationtyp_single) {
                                                    ?>
                                                    <option <?php
                                                    if ($occupationtyp_single->id == $member_master_info->fk_main_occupation) {
                                                        echo "selected=selected";
                                                    }
                                                    ?> value="<?php echo $occupationtyp_single->id ?>"><?php echo $occupationtyp_single->code . '-' . $occupationtyp_single->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3 occupationOth">
                                    <div class="form-group">
                                        <label for="Item Name">Specify Other Occupation <span style="color:red">*</span></label>
                                        <input type="text" class="form-control main_occupation_oth" id="main_occupation_oth"  name="main_occupation_oth" maxlength="255" value="<?php echo $member_master_info->main_occupation_oth ?>">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Active">Birth registration <span style="color:red">*</span></label>
                                        <select class="form-control required" id="birstRegiType" name="birstRegiType" required>
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($birthregistration)) {
                                                foreach ($birthregistration as $birthregistration_single) {
                                                    ?>
                                                    <option <?php
                                                    if ($birthregistration_single->id == $member_master_info->fk_birth_registration) {
                                                        echo "selected=selected";
                                                    }
                                                    ?> value="<?php echo $birthregistration_single->id ?>"><?php echo $birthregistration_single->code . '-' . $birthregistration_single->name ?></option>
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
                                        if ($member_master_info->birth_registration_date != "") {
                                            $partsRequire = explode('-', $member_master_info->birth_registration_date);
                                            $birth_registration_date = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];
                                        }
                                        ?>
                                        <input type="text" class="form-control birthRegidate" value="<?php if(isset($birth_registration_date)) echo $birth_registration_date ?>" data-provide="datepicker-inline" id="birthRegidate"  name="birthRegidate" maxlength="255">
                                    </div>
                                </div>

                                <div class="col-md-3 notRegi">
                                    <div class="form-group">
                                        <label for="Active">why not registrated <span style="color:red">*</span></label>
                                        <select class="form-control whyNotRegi" id="whyNotRegi" name="whyNotRegi">
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($whynotbirthreg)) {
                                                foreach ($whynotbirthreg as $whynotbirthreg_single) {
                                                    ?>
                                                    <option <?php
                                                    if ($whynotbirthreg_single->id == $member_master_info->fk_why_not_birth_registration) {
                                                        echo "selected=selected";
                                                    }
                                                    ?> value="<?php echo $whynotbirthreg_single->id ?>"><?php echo $whynotbirthreg_single->code . '-' . $whynotbirthreg_single->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3 additionalChild_Desire">
                                    <div class="form-group">
                                        <label for="Active">Desire for additional child </label>
                                        <select class="form-control required" id="additionalChild" name="additionalChild">
                                            <option value="0">Please Select</option>
                                            <?php
                                            if (!empty($additionChild)) {
                                                foreach ($additionChild as $additionChild_single) {
                                                    ?>
                                                    <option <?php
                                                    if ($additionChild_single->id == $member_master_info->fk_additionalChild) {
                                                        echo "selected=selected";
                                                    }
                                                    ?>  value="<?php echo $additionChild_single->id ?>"><?php echo $additionChild_single->code . '-' . $additionChild_single->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 manyYear">
                                    <div class="form-group">
                                        <label for="Item Name">After how many year <span style="color:red">*</span></label>
                                        <select class="form-control afterManyYear" id="afterManyYear" name="afterManyYear" required>
                                            <option value="0">Please Select</option>
                                            <?php
                                            if (!empty($child_after_year)) {
                                                foreach ($child_after_year as $after_year) {
                                                    ?>
                                                    <option <?php
                                                    if ($after_year->id == $member_master_info->afterYear) {
                                                        echo "selected=selected";
                                                    }
                                                    ?> value="<?php echo $after_year->id ?>"><?php echo $after_year->code . '-' . $after_year->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                        </select>


                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Contact No(One) </label>
                                        <input type="text" class="form-control" id="contactNoOne" value="<?php echo $member_master_info->contactNoOne ?>"  name="contactNoOne" minlength="11" maxlength="11">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Contact No(Two) </label>
                                        <input type="text" class="form-control" id="contactNoTwo" value="<?php echo $member_master_info->contactNoTwo ?>"  name="contactNoTwo" minlength="11" maxlength="11">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if ($member_master_info->fk_extinct_type == 0) : ?>
                            <div class="box-footer">
                                <input type="submit" class="btn btn-primary" value="Update"> <input name="update_exit" type="submit" class="btn btn-primary" value="Update & Exit">
                            </div>
                        <?php endif; ?>
                    </form>
                </div>

            </div>
        </div>
    </section>
</div>

<script type="text/javascript">


    $(document).ready(function () {



        var seldistrictId = $('#districtID').val();
        if (seldistrictId > 0)
        {

            var districtID = $('#districtID').val();
            if (districtID != '')
            {
                $.ajax({
                    url: "<?php echo base_url(); ?>api/getUpaZila",
                    method: "POST",
                    data: {districtID: districtID},
                    success: function (data)
                    {
                        $('#thanaID').html('');

                        $('#thanaID').html(data);
                        $('#thanaID').val('<?php echo $member_master_info->fk_thana_id; ?>').trigger('change');
                    }
                });

            }

        }

        var selThanaId = <?php echo $member_master_info->fk_thana_id; ?>;

        if (selThanaId > 0)
        {

            var thanaID = selThanaId;
            //alert(thanaID);  
            if (thanaID != '')
            {

                $.ajax({
                    url: "<?php echo base_url(); ?>api/getSlum",
                    method: "POST",
                    data: {thanaID: thanaID},
                    success: function (data)
                    {
                        $('#slumID').html('');

                        console.log(data);

                        $('#slumID').html(data);
                        $('#slumID').val('<?php echo $member_master_info->fk_slum_id; ?>').trigger('change');

                    }
                });

            }

        }

        var selSlumId = '<?php echo $member_master_info->fk_slum_id; ?>';

        if (selSlumId > 0)
        {

            var slumID = selSlumId;
            if (slumID != '')
            {
                $.ajax({
                    url: "<?php echo base_url(); ?>api/getSlumArea",
                    method: "POST",
                    data: {slumID: slumID},
                    success: function (data)
                    {
                        $('#slumAreaID').html('');

                        $('#slumAreaID').html(data);
                        $('#slumAreaID').val('<?php echo $member_master_info->fk_slum_area_id; ?>').trigger('change');
                    }
                });

            }

        }

        $("#occupationType").change(function () {
            $(this).find("option:selected").each(function () {
                var optionValue = $(this).attr("value");
                //alert(optionValue);
                if (optionValue == 166)
                {
                    $(".main_occupation_oth").prop('required', true);
                    $(".occupationOth").show();
                } else {
                    $(".main_occupation_oth").prop('required', false);
                    $(".occupationOth").hide();
                }
            });
        }).change();
        
            $("#relationheadID").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");

            if(optionValue == 27)
            {
               $(".hhdate").prop('required',true);
               $(".hhefectiveDate").show();

            } else{

               $(".hhdate").prop('required',false);
               $(".hhefectiveDate").hide();
            }
        });
    }).change();

     $("#educationType").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");

            if(optionValue == 45)
            {
               $(".yearOfEdu").prop('required',false);
               $(".yearEdu").hide();

            } 
            else if(optionValue == 120)
            {
               $(".yearOfEdu").prop('required',false);
               $(".yearEdu").hide();

            }
            else{

               $(".yearOfEdu").prop('required',true);
               $(".yearEdu").show();
            }
        });
    }).change();

      $("#birstRegiType").change(function(){

        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");

            if(optionValue == 1)
            {
               $(".birthRegidate").prop('required',true);
               $(".whyNotRegi").prop('required',false);
               $(".birthRegi").show();
               $(".notRegi").hide();

            } else{

               $(".birthRegidate").prop('required',false);
               $(".whyNotRegi").prop('required',true);
               $(".birthRegi").hide();
               $(".notRegi").show();
            }
        });
    }).change();

    $("#maritalStatusType").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");

            if(optionValue == 41)
            {
               $(".additionalChild_Desire").show();
               $(".afterManyYear").prop('required',false);

            } else{

               $(".additionalChild_Desire").hide();
               
            }
        });
    }).change();

    $("#additionalChild").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");

            if(optionValue == 1)
            {
               $(".afterManyYear").prop('required',true);
               $(".manyYear").show();

            } else{

               $(".afterManyYear").prop('required',false);
               $(".manyYear").hide();
            }
        });
    }).change();


    });


</script>