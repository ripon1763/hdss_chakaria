<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
            <div class="col-xs-7 text-left header-margin ">
                <h3>
                    <?php echo $pageTitle; ?>

                    <?php $baseID = $this->input->get('baseID', TRUE); ?>
                </h3>

            </div>
            <div class="col-xs-5 text-right">
                <div class="form-group margin5pxBot">
                    <div class="form-group margin5pxBot">
                        <a class="btn btn-primary" href="<?php echo base_url() . $controller . '/sav_format_family_planning' . '?baseID=' . $baseID ?>">sav</a>
                        <a class="btn btn-primary" href="<?php echo base_url() . $controller . '/dta_format_family_planning' . '?baseID=' . $baseID ?>">dta</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="content margin_need">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Family Planning report</h3>

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
                    </div><!-- /.box-header -->

                    <form action="<?php echo base_url() . $controller . '/' . $actionMethod . '?baseID=' . $baseID ?>" method="post">
                        <div class="row">
                            <div class="col-md-6">

                            </div>

                            <div class="col-md-4 no-print">
                                <div class="input-group pull-right">
                                    <label class="control-label" for="round_no">Round No </label>
                                    <select class="form-control" id="round_no" name="round_no">
                                        <option value="0">Select Round</option>
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
                                &nbsp;<button title="Clear" type="submit" class="btn btn-sm btn-default pull-left" id="clear" name="Clear" value="Clear" style="margin-top:25px; margin-left:5px"><i class="fa fa-eraser"> </i></button>

                            </div>

                        </div>
                    </form>

                    <div class="box-body">
                        <div class="table-responsive">


                            <table style="white-space: nowrap;" class="table" id="memberData">
                                <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>DOB</th>
                                        <th>DOBN</th>
                                        <th>household_code</th>
                                        <th>member_code</th>
                                        <th>maritial_status_code</th>
                                        <th>current_pregnancy_status_code</th>
                                        <th>husband_living_place_code</th>
                                        <th>birth_control_method_usage_status_code</th>
                                        <th>birth_control_method_code</th>
                                        <th>birth_control_method_other_value</th>
                                        <th>continuously_using_how_many_month</th>
                                        <th>continuously_using_how_many_year</th>
                                        <th>birth_control_method_suggestion_from_where_status_code</th>
                                        <th>birth_control_method_suggestion_from_where_other_value</th>
                                        <th>whose_decision_code</th>
                                        <th>whose_decision_other_value</th>
                                        <th>reason_behind_not_using_code</th>
                                        <th>reason_behind_not_using_other_value</th>
                                        <th>future_desire_code</th>
                                        <th>reason_behind_not_having_future_desire_code</th>
                                        <th>reason_behind_not_having_future_desire_other_value</th>
                                        <th>do_you_know_from_where_code</th>
                                        <th>available_govt_hospital</th>
                                        <th>available_central_dist_hospital</th>
                                        <th>available_matri_sonod</th>
                                        <th>available_ngo_facility</th>
                                        <th>available_upazilla_sasthokendro</th>
                                        <th>available_union_sastho_poribar_kollan_kendro</th>
                                        <th>available_satellite_clinic</th>
                                        <th>available_community_clinic</th>
                                        <th>available_ngo_and_satellite_clinic</th>
                                        <th>available_ngo_and_static_clinic</th>
                                        <th>available_private_hospital</th>
                                        <th>available_mbbs_doctor_chamber</th>
                                        <th>available_doctor_without_degrees</th>
                                        <th>available_pharmacy</th>
                                        <th>available_other</th>
                                        <th>available_other_value</th>
                                        <th>taking_desire_more_children_code</th>
                                        <th>taking_desire_more_children_after_year</th>
                                        <th>how_many_children_you_want_code</th>
                                        <th>alive_children_code</th>
                                        <th>alive_boy_number</th>
                                        <th>alive_girl_number</th>
                                        <th>alive_children_yes_availability_code</th>
                                        <th>alive_children_yes_availability_other_value</th>
                                        <th>alive_children_yes_availability_how_many</th>
                                        <th>alive_children_no_availability_code</th>
                                        <th>alive_children_no_availability_other_value</th>
                                        <th>alive_children_no_availability_how_many</th>
                                        <th>how_many_male_female_children_code</th>
                                        <th>how_many_male_female_children_other_value</th>
                                        <th>how_many_male</th>
                                        <th>how_many_female</th>
                                        <th>how_many_any</th>
                                        <th>comment</th>
                                        <th>insertedDate</th>
                                        <th>insertedTime</th>
                                        <th>insertedBy_name</th>
                                        <th>updatedDate</th>
                                        <th>updatedTime</th>
                                        <th>updateBy_name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>  



                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>
<script>
    $(document).ready(function (e) {

        var base_url = "<?php echo base_url(); ?>"; // You can use full url here but I prefer like this
        $('#memberData').DataTable({
            // "lengthMenu": [ [10, 25, 50,100, -1], [10, 25, 50,100, "All"] ],
            "lengthMenu": [[10, 25, 50, 100, 500, 1000, 100000, 200000, 500000], [10, 25, 50, 100, 500, 1000, 100000, 200000, 500000]],
            "processing": true,
            // "stateSave": true,
            "paging": true,

            "pagingType": "full_numbers",
            "pageLength": 10,
            "serverSide": true,
            "order": [[0, "asc"]],

            "ajax": {
                url: '<?php echo base_url() ?>family_planning_report/show_family_planning_view?baseID=<?php echo $baseID ?>',
                                type: 'POST'
                            },

                            "dom": 'lBfrtip',

                            buttons: [{
                                    extend: 'excel',
                                    title: 'member family planning report',
                                    exportOptions: {
                                        columns: "thead th:not(.noExport)"
                                    }
                                }, {
                                    extend: 'csv',
                                    title: 'member family planning report',
                                    exportOptions: {
                                        columns: "thead th:not(.noExport)"
                                    }
                                }, {
                                    extend: 'print',
                                    title: 'member family planning report',
                                    exportOptions: {
                                        columns: "thead th:not(.noExport)"
                                    }
                                }
                            ]
                                    // "buttons": [
                                    // {
                                    // extend: 'collection',
                                    // text: 'Export',
                                    // buttons: [
                                    // 'copy',
                                    // 'excel',
                                    // 'csv',
                                    // 'pdf',
                                    // 'print'
                                    // ]
                                    // }
                                    // ]

                        }); // End of DataTable
                    });
</script>  

<script type="text/javascript" src="<?php echo base_url() ?>assets/js/datatables.min.js"></script> 

