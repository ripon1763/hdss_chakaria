

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
                        <a class="btn btn-primary" href="<?php echo base_url() . $controller . '/sav_format/child_illness_view' . '?baseID=' . $baseID ?>">sav</a>
                        <a class="btn btn-primary" href="<?php echo base_url() . $controller . '/dta_format/child_illness_view' . '?baseID=' . $baseID ?>">dta</a>
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
                        <h3 class="box-title">Immunization report</h3>

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
                                        <th>HHNO</th>
                                        <th>member_code</th>
                                        <th>breastfeeding_ever_code</th>
                                        <th>breastfeeding_after_how_many_time_after_birth_code</th>
                                        <th>breastfeeding_after_how_many_hour_after_birth</th>
                                        <th>breastfeeding_after_how_many_day_after_birth</th>
                                        <th>other_drink_except_breastfeeding_code</th>
                                        <th>drink_anything_else_except_breastfeeding_code</th>
                                        <th>drink_just_water_code</th>
                                        <th>drink_sugar_or_glucose_water_code</th>
                                        <th>drink_honey_code</th>
                                        <th>drink_pipe_water_code</th>
                                        <th>drink_sugar_or_salt_mixed_water_code</th>
                                        <th>drink_fruit_juice_code</th>
                                        <th>drink_baby_food_code</th>
                                        <th>drink_tea_or_saline_in_vein_code</th>
                                        <th>drink_coffee_code</th>
                                        <th>drink_dont_know_code</th>
                                        <th>drink_other_code</th>
                                        <th>drink_other_value</th>
                                        <th>breastfeeding_still_now_code</th>
                                        <th>breastfeeding_how_many_month_code</th>
                                        <th>breastfeeding_how_many_month_value</th>
                                        <th>yesterday_day_night_just_water_code</th>
                                        <th>yesterday_day_night_juice_code</th>
                                        <th>yesterday_day_night_soup_fruit_juice_code</th>
                                        <th>yesterday_day_night_tin_milk_power_milk_cow_milk_code</th>
                                        <th>yesterday_day_night_baby_food_code</th>
                                        <th>yesterday_day_night_other_code</th>
                                        <th>yesterday_day_night_other_value</th>
                                        <th>yesterday_day_night_hard_half_hard_soft_food_code</th>
                                        <th>hard_half_hard_soft_food_since_how_many_month_code</th>
                                        <th>hard_half_hard_soft_food_since_how_many_month_value</th>
                                        <th>diarrhoea_happened_code</th>
                                        <th>diarrhoea_happened_day_number</th>
                                        <th>diarrhoea_type_code</th>
                                        <th>diarrhoea_treatment_type_code</th>
                                        <th>diarrhoea_treatment_from_code</th>
                                        <th>diarrhoea_treatment_from_other_value</th>
                                        <th>diarrhoea_start_date</th>
                                        <th>pneumonia_symptom_no_symptom_code</th>
                                        <th>pneumonia_symptom_fever_code</th>
                                        <th>pneumonia_symptom_cold_cough_code</th>
                                        <th>pneumonia_symptom_breath_shortness_frequent_breathing_code</th>
                                        <th>pneumonia_symptom_chest_going_down_code</th>
                                        <th>antibiotic_for_pneumonia_code</th>
                                        <th>pneumonia_treatment_taken_from_code</th>
                                        <th>pneumonia_treatment_taken_from_other_value</th>
                                        <th>pneumonia_start_date</th>
                                        <th>interview_status_code</th>
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
                url: '<?php echo base_url() ?>Reports/show_child_illness?baseID=<?php echo $baseID ?>',
                                type: 'POST'
                            },

                            "dom": 'lBfrtip',

                            buttons: [{
                                    extend: 'excel',
                                    title: 'member child illness report',
                                    exportOptions: {
                                        columns: "thead th:not(.noExport)"
                                    }
                                }, {
                                    extend: 'csv',
                                    title: 'member child illness report',
                                    exportOptions: {
                                        columns: "thead th:not(.noExport)"
                                    }
                                }, {
                                    extend: 'print',
                                    title: 'member child illness report',
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

