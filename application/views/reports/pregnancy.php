<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
            <div class="col-xs-6 text-left header-margin ">
                <h3>
                     <?php echo $pageTitle; ?>
                    <?php $baseID = $this->input->get('baseID', TRUE); ?>
                </h3>

            </div>
            <div class="col-xs-6 text-right">
                <div class="form-group margin5pxBot">
                    <a class="btn btn-primary" href="<?php echo base_url() . $controller . '/sav_format_pregnancy' . '?baseID=' . $baseID ?>">sav</a>
                    <a class="btn btn-primary" href="<?php echo base_url() . $controller . '/dta_format_pregnancy' . '?baseID=' . $baseID ?>">dta</a>
                </div>
            </div>
        </div>
    </section>
    <section class="content content-margin">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">


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


                        <form action="<?php echo base_url() . $controller . '/' . $actionMethod . '?baseID=' . $baseID ?>" method="post">
                            <div class="row">
                                <div class="col-md-6">

                                </div>

                                <div class="col-md-4 no-print">
                                    <div class="input-group pull-right">
                                        <label class="control-label" for="round_no">Round No </label>
                                        <select class="form-control" id="round_no" name="round_no">
                                            <option value="">Select Round</option>
                                            <?php
                                            foreach ($all_round_info as $all_round_info_single) {
                                                ?>
                                                <option <?php if ($round_no == $all_round_info_single->id) echo ' selected'; ?> value="<?php echo $all_round_info_single->id; ?>"><?php echo $all_round_info_single->id; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 no-print">
                                    <button title="Search" type="submit" class="btn btn-sm btn-default pull-left" name="search" value="search" style="margin-top:25px"><i class="fa fa-search"> </i></button>
                                    &nbsp;<button title="Clear" type="submit" class="btn btn-sm btn-default pull-left" name="Clear" value="Clear" style="margin-top:25px; margin-left:5px"><i class="fa fa-eraser"> </i></button>

                                </div>

                            </div>
                        </form>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table style="white-space: nowrap;" id="UnitList" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>Household Code</th>
                                    <th>Member code</th>
                                    <th>Member name</th>
                                    <th>Birth Date</th>
                                    <th>pregnancy_outcome_date</th>
                                    <th>breast_milk_day</th>
                                    <th>induced_abortion</th>
                                    <th>spontaneous_abortion</th>
                                    <th>live_birth</th>
                                    <th>still_birth</th>
                                    <th>fk_litter_size_CODE</th>
                                    <th>fk_litter_size_NAME</th>
                                    <th>fk_delivery_methodology_CODE</th>
                                    <th>fk_delivery_methodology_NAME</th>
                                    <th>fk_delivery_assist_type_CODE</th>
                                    <th>fk_delivery_assist_type_NAME</th>
                                    <th>fk_delivery_term_place_CODE</th>
                                    <th>fk_delivery_term_place_NAME</th>
                                    <th>fk_colostrum_CODE</th>
                                    <th>fk_colostrum_NAME</th>
                                    <th>fk_first_milk_CODE</th>
                                    <th>fk_first_milk_NAME</th>
                                    <th>milk_hours</th>
                                    <th>milk_day</th>
                                    <th>fk_facility_delivery_CODE</th>
                                    <th>fk_facility_delivery_NAME</th>
                                    <th>fk_preg_complication_CODE</th>
                                    <th>fk_preg_complication_NAME</th>
                                    <th>fk_delivery_complication_CODE</th>
                                    <th>fk_delivery_complication_NAME</th>
                                    <th>fk_preg_violence_CODE</th>
                                    <th>fk_preg_violence_NAME</th>
                                    <th>fk_health_problem_CODE</th>
                                    <th>fk_health_problem_NAME</th>
                                    <th>fk_high_pressure_CODE</th>
                                    <th>fk_high_pressure_NAME</th>
                                    <th>fk_diabetis_CODE</th>
                                    <th>fk_diabetis_NAME</th>
                                    <th>fk_preaklampshia_CODE</th>
                                    <th>fk_preaklampshia_NAME</th>
                                    <th>fk_lebar_birth_CODE</th>
                                    <th>fk_lebar_birth_NAME</th>
                                    <th>fk_vomiting_CODE</th>
                                    <th>fk_vomiting_NAME</th>
                                    <th>fk_amliotic_CODE</th>
                                    <th>fk_amliotic_NAME</th>
                                    <th>fk_membrane_CODE</th>
                                    <th>fk_membrane_NAME</th>
                                    <th>fk_malposition_CODE</th>
                                    <th>fk_malposition_NAME</th>
                                    <th>fk_headache_CODE</th>
                                    <th>fk_headache_NAME</th>
                                    <th>keep_follow_up</th>
                                    <th>fk_routine_anc_chkup_mother_CODE</th>
                                    <th>fk_routine_anc_chkup_mother_NAME</th>
                                    <th>routine_anc_chkup_mother_times</th>
                                    <th>fk_anc_first_assist_CODE</th>
                                    <th>fk_anc_first_assist_NAME</th>
                                    <th>anc_first_visit_months</th>
                                    <th>fk_anc_second_assist_CODE</th>
                                    <th>fk_anc_second_assist_NAME</th>
                                    <th>anc_second_visit_months</th>
                                    <th>fk_anc_third_assist_CODE</th>
                                    <th>fk_anc_third_assist_NAME</th>
                                    <th>anc_third_visit_months</th>
                                    <th>fk_anc_fouth_assist_CODE</th>
                                    <th>fk_anc_fouth_assist_NAME</th>
                                    <th>anc_fouth_visit_months</th>
                                    <th>fk_anc_fifth_assist_CODE</th>
                                    <th>fk_anc_fifth_assist_NAME</th>
                                    <th>anc_fifth_visit_months</th>
                                    <th>fk_anc_supliment_CODE</th>
                                    <th>fk_anc_supliment_NAME</th>
                                    <th>fk_supliment_received_way_CODE</th>
                                    <th>fk_supliment_received_way_NAME</th>
                                    <th>fk_how_many_tab_CODE</th>
                                    <th>fk_how_many_tab_NAME</th>
                                    <th>totalnumbertab</th>
                                    <th>fk_anc_weight_taken_CODE</th>
                                    <th>fk_anc_weight_taken_NAME</th>
                                    <th>fk_anc_blood_pressure_CODE</th>
                                    <th>fk_anc_blood_pressure_NAME</th>
                                    <th>fk_anc_urine_CODE</th>
                                    <th>fk_anc_urine_NAME</th>
                                    <th>fk_anc_blood_CODE</th>
                                    <th>fk_anc_blood_NAME</th>
                                    <th>fk_anc_denger_sign_CODE</th>
                                    <th>fk_anc_denger_sign_NAME</th>
                                    <th>fk_anc_nutrition_CODE</th>
                                    <th>fk_anc_nutrition_NAME</th>
                                    <th>fk_anc_birth_prepare_CODE</th>
                                    <th>fk_anc_birth_prepare_NAME</th>
                                    <th>fk_anc_delivery_kit_CODE</th>
                                    <th>fk_anc_delivery_kit_NAME</th>
                                    <th>fk_anc_soap_CODE</th>
                                    <th>fk_anc_soap_NAME</th>
                                    <th>fk_anc_care_chix_CODE</th>
                                    <th>fk_anc_care_chix_NAME</th>
                                    <th>fk_anc_dried_CODE</th>
                                    <th>fk_anc_dried_NAME</th>
                                    <th>fk_anc_breast_feed_CODE</th>
                                    <th>fk_anc_breast_feed_NAME</th>

                                    <th>fk_anc_skin_contact_code</th>
                                    <th>fk_anc_skin_contact_name</th>
                                    <th>fk_anc_enc_code</th>
                                    <th>fk_anc_enc_name</th>
                                    <th>fk_suspecred_infection_code</th>
                                    <th>fk_suspecred_infection_name</th>
                                    <th>fk_baby_antibiotics_code</th>
                                    <th>fk_baby_antibiotics_name</th>
                                    <th>fk_prescribe_antibiotics_code</th>
                                    <th>fk_prescribe_antibiotics_name</th>
                                    <th>fk_seek_treatment_code</th>
                                    <th>fk_seek_treatment_name</th>
                                    <th>fk_anc_vaginal_bleeding_code</th>
                                    <th>fk_anc_vaginal_bleeding_name</th>
                                    <th>fk_anc_convulsions_code</th>
                                    <th>fk_anc_convulsions_name</th>
                                    <th>fk_anc_severe_headache_code</th>
                                    <th>fk_anc_severe_headache_name</th>
                                    <th>fk_anc_fever_code</th>
                                    <th>fk_anc_fever_name</th>
                                    <th>fk_anc_abdominal_pain_code</th>
                                    <th>fk_anc_abdominal_pain_name</th>
                                    <th>fk_anc_diff_breath_code</th>
                                    <th>fk_anc_diff_breath_name</th>
                                    <th>fk_anc_water_break_code</th>
                                    <th>fk_anc_water_break_name</th>
                                    <th>fk_anc_vaginal_bleed_aph_code</th>
                                    <th>fk_anc_vaginal_bleed_aph_name</th>

                                    <th>fk_anc_obstructed_labour_code</th>
                                    <th>fk_anc_obstructed_labour_name</th>
                                    <th>fk_anc_convulsion_code</th>
                                    <th>fk_anc_convulsion_name</th>
                                    <th>fk_anc_sepsis_code</th>
                                    <th>fk_anc_sepsis_name</th>
                                    <th>fk_anc_severe_headache_delivery_code</th>
                                    <th>fk_anc_severe_headache_delivery_name</th>
                                    <th>fk_anc_consciousness_code</th>
                                    <th>fk_anc_consciousness_name</th>
                                    <th>fk_anc_vaginal_bleeding_post_code</th>
                                    <th>fk_anc_vaginal_bleeding_post_name</th>
                                    <th>fk_anc_convulsion_eclampsia_post_code</th>
                                    <th>fk_anc_convulsion_eclampsia_post_name</th>
                                    <th>fk_anc_high_feaver_post_code</th>
                                    <th>fk_anc_high_feaver_post_name</th>
                                    <th>fk_anc_smelling_discharge_post_code</th>
                                    <th>fk_anc_smelling_discharge_post_name</th>
                                    <th>fk_anc_severe_headache_post_code</th>
                                    <th>fk_anc_severe_headache_post_name</th>
                                    <th>fk_anc_consciousness_post_code</th>
                                    <th>fk_anc_consciousness_post_name</th>
                                    <th>fk_anc_inability_baby_code</th>
                                    <th>fk_anc_inability_baby_name</th>
                                    <th>fk_anc_baby_small_baby_code</th>
                                    <th>fk_anc_baby_small_baby_name</th>
                                    <th>fk_anc_fast_breathing_baby_code</th>
                                    <th>fk_anc_fast_breathing_baby_name</th>
                                    <th>fk_anc_convulsions_baby_code</th>
                                    <th>fk_anc_convulsions_baby_name</th>
                                    <th>fk_anc_drowsy_baby_code</th>
                                    <th>fk_anc_drowsy_baby_name</th>
                                    <th>fk_anc_movement_baby_code</th>
                                    <th>fk_anc_movement_baby_name</th>
                                    <th>fk_anc_grunting_baby_code</th>
                                    <th>fk_anc_grunting_baby_name</th>
                                    <th>fk_anc_indrawing_baby_code</th>
                                    <th>fk_anc_indrawing_baby_name</th>
                                    <th>fk_anc_temperature_baby_code</th>
                                    <th>fk_anc_temperature_baby_name</th>
                                    <th>fk_anc_hypothermia_baby_code</th>
                                    <th>fk_anc_hypothermia_baby_name</th>
                                    <th>fk_anc_central_cyanosis_baby_code</th>
                                    <th>fk_anc_central_cyanosis_baby_name</th>
                                    <th>fk_anc_umbilicus_baby_code</th>
                                    <th>fk_anc_umbilicus_baby_name</th>
                                    <th>fk_anc_labour_preg_code</th>
                                    <th>fk_anc_labour_preg_name</th>
                                    <th>fk_anc_excessive_bld_pre_code</th>
                                    <th>fk_anc_excessive_bld_pre_name</th>
                                    <th>fk_anc_severe_headache_preg_code</th>
                                    <th>fk_anc_severe_headache_preg_name</th>
                                    <th>fk_anc_obstructed_preg_code</th>
                                    <th>fk_anc_obstructed_preg_name</th>
                                    <th>fk_anc_convulsion_preg_code</th>
                                    <th>fk_anc_convulsion_preg_name</th>
                                    <th>fk_anc_placenta_preg_code</th>
                                    <th>fk_anc_placenta_preg_name</th>
                                    <th>fk_anc_breath_child_code</th>
                                    <th>fk_anc_breath_child_name</th>
                                    <th>fk_anc_suck_baby_code</th>
                                    <th>fk_anc_suck_baby_name</th>
                                    <th>fk_anc_hot_cold_child_code</th>
                                    <th>fk_anc_hot_cold_child_name</th>
                                    <th>fk_anc_blue_child_code</th>
                                    <th>fk_anc_blue_child_name</th>
                                    <th>fk_anc_convulsion_child_code</th>
                                    <th>fk_anc_convulsion_child_name</th>
                                    <th>fk_anc_indrawing_child_code</th>
                                    <th>fk_anc_indrawing_child_name</th>
                                    <th>fk_supliment_post_code</th>
                                    <th>fk_supliment_post_name</th>
                                    <th>fk_post_natal_visit_code</th>
                                    <th>fk_post_natal_visit_name</th>
                                    <th>fk_pnc_chkup_mother_code</th>
                                    <th>fk_pnc_chkup_mother_name</th>
                                    <th>pnc_chkup_mother_times</th>
                                    <th>fk_pnc_first_visit_assist_code</th>
                                    <th>fk_pnc_first_visit_assist_name</th>
                                    <th>fk_pnc_first_visit_code</th>
                                    <th>fk_pnc_first_visit_name</th>
                                    <th>pnc_first_visit_days</th>
                                    <th>fk_pnc_second_visit_assist_code</th>
                                    <th>fk_pnc_second_visit_assist_name</th>
                                    <th>fk_pnc_second_visit_code</th>
                                    <th>fk_pnc_second_visit_name</th>
                                    <th>pnc_second_visit_days</th>
                                    <th>remarks</th>


                                    <th>insertedBy</th>
                                    <th>insertedDate</th>
                                    <th>insertedTime</th>
                                    <th>updateBy</th>
                                    <th>updatedDate</th>
                                    <th>updatedTime</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pregnancy_info as $pregnancy_info_single) { ?>
                                    <tr>
                                        <?php if ($editPerm) { ?>
                                            <td><a href="<?php echo base_url() . $controller . '/' . $editMethod . '/' . $pregnancy_info_single->id . '?baseID=' . $baseID; ?>" class="btn btn-sm btn-primary">Edit</a></td>
                                        <?php } ?>
                                        <td><?php echo $pregnancy_info_single->household_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->member_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->member_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->birth_date; ?></td>
                                        <td><?php echo $pregnancy_info_single->pregnancy_outcome_date; ?></td>

                                        <td><?php echo $pregnancy_info_single->breast_milk_day; ?></td>
                                        <td><?php echo $pregnancy_info_single->induced_abortion; ?></td>
                                        <td><?php echo $pregnancy_info_single->spontaneous_abortion; ?></td>
                                        <td><?php echo $pregnancy_info_single->live_birth; ?></td>
                                        <td><?php echo $pregnancy_info_single->still_birth; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_litter_size_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_litter_size_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_delivery_methodology_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_delivery_methodology_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_delivery_assist_type_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_delivery_assist_type_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_delivery_term_place_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_delivery_term_place_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_colostrum_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_colostrum_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_first_milk_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_first_milk_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->milk_hours; ?></td>
                                        <td><?php echo $pregnancy_info_single->milk_day; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_facility_delivery_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_facility_delivery_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_preg_complication_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_preg_complication_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_delivery_complication_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_delivery_complication_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_preg_violence_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_preg_violence_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_health_problem_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_health_problem_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_high_pressure_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_high_pressure_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_diabetis_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_diabetis_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_preaklampshia_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_preaklampshia_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_lebar_birth_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_lebar_birth_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_vomiting_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_vomiting_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_amliotic_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_amliotic_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_membrane_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_membrane_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_malposition_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_malposition_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_headache_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_headache_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->keep_follow_up; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_routine_anc_chkup_mother_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_routine_anc_chkup_mother_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->routine_anc_chkup_mother_times; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_first_assist_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_first_assist_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->anc_first_visit_months; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_second_assist_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_second_assist_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->anc_second_visit_months; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_third_assist_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_third_assist_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->anc_third_visit_months; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_fourth_assist_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_fourth_assist_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->anc_fourth_visit_months; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_fifth_assist_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_fifth_assist_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->anc_fifth_visit_months; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_supliment_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_supliment_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_supliment_received_way_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_supliment_received_way_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_how_many_tab_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_how_many_tab_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->totalnumbertab; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_weight_taken_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_weight_taken_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_blood_pressure_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_blood_pressure_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_urine_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_urine_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_blood_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_blood_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_denger_sign_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_denger_sign_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_nutrition_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_nutrition_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_birth_prepare_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_birth_prepare_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_delivery_kit_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_delivery_kit_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_soap_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_soap_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_care_chix_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_care_chix_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_dried_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_dried_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_breast_feed_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_breast_feed_name; ?></td>

                                        <td><?php echo $pregnancy_info_single->fk_anc_skin_contact_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_skin_contact_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_enc_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_enc_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_suspecred_infection_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_suspecred_infection_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_baby_antibiotics_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_baby_antibiotics_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_prescribe_antibiotics_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_prescribe_antibiotics_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_seek_treatment_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_seek_treatment_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_vaginal_bleeding_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_vaginal_bleeding_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_convulsions_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_convulsions_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_severe_headache_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_severe_headache_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_fever_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_fever_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_abdominal_pain_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_abdominal_pain_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_diff_breath_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_diff_breath_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_water_break_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_water_break_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_vaginal_bleed_aph_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_vaginal_bleed_aph_name; ?></td>

                                        <td><?php echo $pregnancy_info_single->fk_anc_obstructed_labour_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_obstructed_labour_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_convulsion_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_convulsion_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_sepsis_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_sepsis_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_severe_headache_delivery_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_severe_headache_delivery_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_consciousness_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_consciousness_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_vaginal_bleeding_post_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_vaginal_bleeding_post_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_convulsion_eclampsia_post_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_convulsion_eclampsia_post_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_high_feaver_post_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_high_feaver_post_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_smelling_discharge_post_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_smelling_discharge_post_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_severe_headache_post_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_severe_headache_post_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_consciousness_post_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_consciousness_post_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_inability_baby_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_inability_baby_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_baby_small_baby_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_baby_small_baby_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_fast_breathing_baby_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_fast_breathing_baby_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_convulsions_baby_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_convulsions_baby_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_drowsy_baby_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_drowsy_baby_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_movement_baby_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_movement_baby_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_grunting_baby_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_grunting_baby_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_indrawing_baby_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_indrawing_baby_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_temperature_baby_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_temperature_baby_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_hypothermia_baby_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_hypothermia_baby_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_central_cyanosis_baby_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_central_cyanosis_baby_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_umbilicus_baby_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_umbilicus_baby_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_labour_preg_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_labour_preg_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_excessive_bld_pre_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_excessive_bld_pre_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_severe_headache_preg_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_severe_headache_preg_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_obstructed_preg_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_obstructed_preg_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_convulsion_preg_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_convulsion_preg_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_placenta_preg_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_placenta_preg_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_breath_child_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_breath_child_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_suck_baby_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_suck_baby_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_hot_cold_child_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_hot_cold_child_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_blue_child_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_blue_child_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_convulsion_child_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_convulsion_child_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_indrawing_child_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_anc_indrawing_child_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_supliment_post_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_supliment_post_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_post_natal_visit_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_post_natal_visit_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_pnc_chkup_mother_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_pnc_chkup_mother_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->pnc_chkup_mother_times; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_pnc_first_visit_assist_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_pnc_first_visit_assist_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_pnc_first_visit_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_pnc_first_visit_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->pnc_first_visit_days; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_pnc_second_visit_assist_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_pnc_second_visit_assist_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_pnc_second_visit_code; ?></td>
                                        <td><?php echo $pregnancy_info_single->fk_pnc_second_visit_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->pnc_second_visit_days; ?></td>
                                        <td><?php echo $pregnancy_info_single->remarks; ?></td>

                                        <td><?php echo $pregnancy_info_single->insertedBy_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->insertedDate; ?></td>
                                        <td><?php echo $pregnancy_info_single->insertedTime; ?></td>
                                        <td><?php echo $pregnancy_info_single->updateBy_name; ?></td>
                                        <td><?php echo $pregnancy_info_single->updatedDate; ?></td>
                                        <td><?php echo $pregnancy_info_single->updatedTime; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>


                        </table>

                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>
<script>
    $(function () {
        $("#UnitList").DataTable({
            "order": [[5, "asc"]],
            dom: 'lBfrtip',
            'lengthMenu': [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
            "scrollX": true,

            //buttons: ['copy','csv','excel','pdf','print'],
            buttons: [{
                    extend: 'pdf',
                    title: 'Pregnancy Report',
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                }, {
                    extend: 'excel',
                    title: 'Pregnancy Report',
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                }, {
                    extend: 'csv',
                    title: 'Pregnancy Report',
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                }, {
                    extend: 'print',
                    title: 'Pregnancy Report',
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                }
            ]
        });
    });
</script>                 
