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
                    <a class="btn btn-primary" href="<?php echo base_url() . $controller . '/sav_format_interview' . '?baseID=' . $baseID ?>">sav</a>
                    <a class="btn btn-primary" href="<?php echo base_url() . $controller . '/dta_format_interview' . '?baseID=' . $baseID ?>">dta</a>
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
                                    <th>interview_date</th>
                                    <th>any_birth_CODE</th>
                                    <th>any_birth_NAME</th>
                                    <th>any_concepton_CODE</th>
                                    <th>any_concepton_NAME</th>
                                    <th>any_pregnancy_CODE</th>
                                    <th>any_pregnancy_NAME</th>
                                    <th>any_death_CODE</th>
                                    <th>any_death_NAME</th>
                                    <th>any_hosp_CODE</th>
                                    <th>any_hosp_NAME</th>
                                    <th>memberCheck_CODE</th>
                                    <th>memberCheck_NAME</th>
                                    <th>any_vaccin_CODE</th>
                                    <th>any_vaccin_NAME</th>
                                    <th>any_marriage_start_CODE</th>
                                    <th>any_marriage_start_NAME</th>
                                    <th>any_marriage_end_CODE</th>
                                    <th>any_marriage_end_NAME</th>
                                    <th>any_migration_in_CODE</th>
                                    <th>any_migration_in_NAME</th>
                                    <th>any_migration_out_CODE</th>
                                    <th>any_migration_out_NAME</th>
                                    <th>fk_interview_status_CODE</th>
                                    <th>fk_interview_status_NAME</th>
                                    <th>fk_interviewer_CODE</th>
                                    <th>fk_interviewer_NAME</th>
                                    <th>fk_responded_type_CODE</th>
                                    <th>fk_responded_type_NAME</th>


                                    <th>respondent_code</th>
                                    <th>is_household_split_CODE</th>
                                    <th>is_household_split_NAME</th>
                                    <th>is_household_merge_CODE</th>
                                    <th>is_household_merge_NAME</th>

                                    <th>split_date</th>
                                    <th>no_of_new_household</th>
                                    <th>merge_date</th>
                                    <th>any_asset_CODE</th>
                                    <th>any_asset_NAME</th>
                                    <th>any_education_CODE</th>
                                    <th>any_education_NAME</th>
                                    <th>any_occupation_CODE</th>
                                    <th>any_occupation_NAME</th>
                                    <th>any_relation_CODE</th>
                                    <th>any_relation_NAME</th>
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
                                <?php foreach ($interview_info as $interview_info_single) { ?>
                                    <tr>
                                        <?php if ($editPerm) { ?>
                                            <td><a href="<?php echo base_url() . $controller . '/' . $editMethod . '/' . $interview_info_single->id . '?baseID=' . $baseID . '&household_master_id=' . $interview_info_single->household_master_id; ?>" class="btn btn-sm btn-primary">Edit</a></td>
                                        <?php } ?>
                                        <td><?php echo $interview_info_single->household_code; ?></td>
                                        <td><?php echo $interview_info_single->interview_date; ?></td>

                                        <td><?php echo $interview_info_single->any_birth_code; ?></td>
                                        <td><?php echo $interview_info_single->any_birth_name; ?></td>
                                        <td><?php echo $interview_info_single->any_concepton_code; ?></td>
                                        <td><?php echo $interview_info_single->any_concepton_name; ?></td>
                                        <td><?php echo $interview_info_single->any_pregnancy_code; ?></td>
                                        <td><?php echo $interview_info_single->any_pregnancy_name; ?></td>
                                        <td><?php echo $interview_info_single->any_death_code; ?></td>
                                        <td><?php echo $interview_info_single->any_death_name; ?></td>
                                        <td><?php echo $interview_info_single->any_hosp_code; ?></td>
                                        <td><?php echo $interview_info_single->any_hosp_name; ?></td>
                                        <td><?php echo $interview_info_single->memberCheck_code; ?></td>
                                        <td><?php echo $interview_info_single->memberCheck_name; ?></td>
                                        <td><?php echo $interview_info_single->any_vaccin_code; ?></td>
                                        <td><?php echo $interview_info_single->any_vaccin_name; ?></td>
                                        <td><?php echo $interview_info_single->any_marriage_start_code; ?></td>
                                        <td><?php echo $interview_info_single->any_marriage_start_name; ?></td>
                                        <td><?php echo $interview_info_single->any_marriage_end_code; ?></td>
                                        <td><?php echo $interview_info_single->any_marriage_end_name; ?></td>
                                        <td><?php echo $interview_info_single->any_migration_in_code; ?></td>
                                        <td><?php echo $interview_info_single->any_migration_in_name; ?></td>
                                        <td><?php echo $interview_info_single->any_migration_out_code; ?></td>
                                        <td><?php echo $interview_info_single->any_migration_out_name; ?></td>
                                        <td><?php echo $interview_info_single->fk_interview_status_code; ?></td>
                                        <td><?php echo $interview_info_single->fk_interview_status_name; ?></td>
                                        <td><?php echo $interview_info_single->fk_interviewer_code; ?></td>
                                        <td><?php echo $interview_info_single->fk_interviewer_name; ?></td>
                                        <td><?php echo $interview_info_single->fk_responded_type_code; ?></td>
                                        <td><?php echo $interview_info_single->fk_responded_type_name; ?></td>

                                        <td><?php echo $interview_info_single->respondent_code; ?></td>
                                        <td><?php echo $interview_info_single->is_household_split_code; ?></td>
                                        <td><?php echo $interview_info_single->is_household_split_name; ?></td>
                                        <td><?php echo $interview_info_single->is_household_merge_code; ?></td>
                                        <td><?php echo $interview_info_single->is_household_merge_name; ?></td>
                                        <td><?php echo $interview_info_single->split_date; ?></td>

                                        <td><?php echo $interview_info_single->no_of_new_household; ?></td>
                                        <td><?php echo $interview_info_single->merge_date; ?></td>
                                        <td><?php echo $interview_info_single->any_asset_code; ?></td>
                                        <td><?php echo $interview_info_single->any_asset_name; ?></td>
                                        <td><?php echo $interview_info_single->any_education_code; ?></td>
                                        <td><?php echo $interview_info_single->any_education_name; ?></td>
                                        <td><?php echo $interview_info_single->any_occupation_code; ?></td>
                                        <td><?php echo $interview_info_single->any_occupation_name; ?></td>
                                        <td><?php echo $interview_info_single->any_relation_code; ?></td>
                                        <td><?php echo $interview_info_single->any_relation_name; ?></td>
                                        <td><?php echo $interview_info_single->remarks; ?></td>
                                        <td><?php echo $interview_info_single->insertedBy_name; ?></td>
                                        <td><?php echo $interview_info_single->insertedDate; ?></td>
                                        <td><?php echo $interview_info_single->insertedTime; ?></td>
                                        <td><?php echo $interview_info_single->updateBy_name; ?></td>
                                        <td><?php echo $interview_info_single->updatedDate; ?></td>
                                        <td><?php echo $interview_info_single->updatedTime; ?></td>
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
//            "order": [[5, "asc"]],
            dom: 'lBfrtip',
            'lengthMenu': [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
            "scrollX": true,

            //buttons: ['copy','csv','excel','pdf','print'],
            buttons: [{
                    extend: 'pdf',
                    title: '<?php echo $shortName . ' ' . $boxTitle ?> Report',
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                }, {
                    extend: 'excel',
                    title: '<?php echo $shortName . ' ' . $boxTitle ?> Report',
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                }, {
                    extend: 'csv',
                    title: '<?php echo $shortName . ' ' . $boxTitle ?> Report',
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                }, {
                    extend: 'print',
                    title: '<?php echo $shortName . ' ' . $boxTitle ?> Report',
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                }
            ]
        });
    });
</script>                 
