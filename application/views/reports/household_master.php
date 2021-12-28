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
                    <a class="btn btn-primary" href="<?php echo base_url() . $controller . '/sav_format_household' . '?baseID=' . $baseID ?>">sav</a>
                    <a class="btn btn-primary" href="<?php echo base_url() . $controller . '/dta_format_household' . '?baseID=' . $baseID ?>">dta</a>
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


                        <form action="<?php echo base_url() . $controller . '/' . $actionMethod; ?>" method="get">
                            <input type="hidden" name="baseID" value="<?php echo $baseID ?>">
                            <div class="row" style="margin-bottom:20px; margin-left: 0px">
                                <div class="col-md-2 no-print">
                                    <div class="input-group">
                                        <label class="control-label" for="districtID">District</label>
                                        <select class="form-control" id="districtID"  name="district_id">
                                            <option value="">Select District</option>
                                            <?php
                                            if (!empty($district)) {
                                                foreach ($district as $district_single) {
                                                    ?>
                                                    <option <?php if ($district_single->id == $district_id) echo ' selected'; ?> value="<?php echo $district_single->id ?>"><?php echo $district_single->code . '-' . $district_single->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-2 no-print">
                                    <div class="input-group">
                                        <label for="Item Name">Upazila</label>
                                        <select  class="form-control" id="thanaID" name="thana_id">
                                            <option value="">Select Upazila</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 no-print">
                                    <div class="input-group">
                                        <label for="Item Name">Slum</label>
                                        <select class="form-control" id="slumID" name="slum_id">
                                            <option value="">Select Slum</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 no-print">
                                    <div class="input-group">
                                        <label for="Item Name">Slum Area </label>
                                        <select class="form-control" id="slumAreaID" name="slumarea_id">
                                            <option value="">Select Slum Area</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 no-print">
                                    <div class="input-group">
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
                                    <th>contact_number</th>
                                    <th>fk_district_id_CODE</th>
                                    <th>fk_district_id_NAME</th>
                                    <th>fk_thana_id_CODE</th>
                                    <th>fk_thana_id_NAME</th>
                                    <th>fk_slum_id_CODE</th>
                                    <th>fk_slum_id_NAME</th>
                                    <th>fk_slum_area_id_CODE</th>
                                    <th>fk_slum_area_id_NAME</th>
                                    <th>houseCount</th>
                                    <th>barino</th>
                                    <th>bariwalla_name</th>
                                    <th>household_head_name</th>
                                    <th>longlivy</th>
                                    <th>longlivm</th>
                                    <th>leftpad</th>
                                    <th>fk_entry_type_CODE</th>
                                    <th>fk_entry_type_NAME</th>
                                    <th>entry_date</th>
                                    <th>round_no_entry_round</th>
                                    <th>fk_migration_reason_CODE</th>
                                    <th>fk_migration_reason_NAME</th>
                                    <th>migration_reason_oth</th>
                                    <th>country from</th>
                                    <th>district from</th>
                                    <th>thana from</th>
                                    <th>slum from</th>
                                    <th>slum area from</th>
                                    <th>fk_extinct_type_CODE</th>
                                    <th>fk_extinct_type_NAME</th>
                                    <th>extinct_date</th>
                                    <th>round_no_extinct_round</th>
                                    <th>fk_contract_type_CODE</th>
                                    <th>fk_contract_type_NAME</th>
                                    <th>fk_family_type_CODE</th>
                                    <th>fk_family_type_NAME</th>
                                    <th>fk_study_design_CODE</th>
                                    <th>fk_study_design_NAME</th>
                                    <th>location_id</th>
                                    <th>location_split_id</th>
                                    <th>member_code_last_head</th>
                                    <th>insertedBy</th>
                                    <th>insertedDate</th>
                                    <th>insertedTime</th>
                                    <th>updateBy</th>
                                    <th>updatedDate</th>
                                    <th>updatedTime</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($household_master_info as $household_master_info_single) { ?>
                                    <tr>
                                        <?php if ($editPerm) { ?>
                                            <td><a href="<?php echo base_url() . $controller . '/' . $editMethod . '/' . $household_master_info_single->id . '?baseID=' . $baseID; ?>" class="btn btn-sm btn-primary">Edit</a></td>
                                        <?php } ?>
                                        <td><?php echo $household_master_info_single->household_code; ?></td>
                                        <td><?php echo $household_master_info_single->contact_number; ?></td>
                                        <td><?php echo $household_master_info_single->district_code; ?></td>
                                        <td><?php echo $household_master_info_single->district_name; ?></td>
                                        <td><?php echo $household_master_info_single->thana_code; ?></td>
                                        <td><?php echo $household_master_info_single->thana_name; ?></td>
                                        <td><?php echo $household_master_info_single->slum_code; ?></td>
                                        <td><?php echo $household_master_info_single->slum_name; ?></td>
                                        <td><?php echo $household_master_info_single->slum_area_code; ?></td>
                                        <td><?php echo $household_master_info_single->slum_area_name; ?></td>
                                        <td><?php echo $household_master_info_single->houseCount; ?></td>
                                        <td><?php echo $household_master_info_single->barino; ?></td>
                                        <td><?php echo $household_master_info_single->bariwalla_name; ?></td>
                                        <td><?php echo $household_master_info_single->household_head_name; ?></td>
                                        <td><?php echo $household_master_info_single->longlivy; ?></td>
                                        <td><?php echo $household_master_info_single->longlivm; ?></td>
                                        <td><?php echo $household_master_info_single->leftpad; ?></td>
                                        <td><?php echo $household_master_info_single->fk_entry_type_code; ?></td>
                                        <td><?php echo $household_master_info_single->fk_entry_type_name; ?></td>
                                        <td><?php echo $household_master_info_single->entry_date; ?></td>

                                        <td><?php echo $household_master_info_single->round_master_id_entry_round; ?></td>
                                        <td><?php echo $household_master_info_single->fk_migration_reason_code; ?></td>
                                        <td><?php echo $household_master_info_single->fk_migration_reason_name; ?></td>
                                        <td><?php echo $household_master_info_single->migration_reason_oth; ?></td>
                                        <td><?php echo $household_master_info_single->country_from; ?></td>
                                        <td><?php echo $household_master_info_single->district_from; ?></td>
                                        <td><?php echo $household_master_info_single->thana_from; ?></td>
                                        <td><?php echo $household_master_info_single->slum_from; ?></td>
                                        <td><?php echo $household_master_info_single->slum_area_from; ?></td>
                                        <td><?php echo $household_master_info_single->fk_extinct_type_code; ?></td>
                                        <td><?php echo $household_master_info_single->fk_extinct_type_name; ?></td>
                                        <td><?php echo $household_master_info_single->extinct_date; ?></td>
                                        <td><?php echo $household_master_info_single->round_master_id_extinct_round; ?></td>

                                        <td><?php echo $household_master_info_single->fk_contract_type_code; ?></td>
                                        <td><?php echo $household_master_info_single->fk_contract_type_name; ?></td>
                                        <td><?php echo $household_master_info_single->fk_family_type_code; ?></td>
                                        <td><?php echo $household_master_info_single->fk_family_type_name; ?></td>
                                        <td><?php echo $household_master_info_single->fk_study_design_code; ?></td>
                                        <td><?php echo $household_master_info_single->fk_study_design_name; ?></td>
                                        <td><?php echo $household_master_info_single->location_id; ?></td>
                                        <td><?php echo $household_master_info_single->location_split_id; ?></td>
                                        <td><?php echo $household_master_info_single->member_code_last_head; ?></td>
                                        <td><?php echo $household_master_info_single->insertedBy_name; ?></td>
                                        <td><?php echo $household_master_info_single->insertedDate; ?></td>
                                        <td><?php echo $household_master_info_single->insertedTime; ?></td>
                                        <td><?php echo $household_master_info_single->updateBy_name; ?></td>
                                        <td><?php echo $household_master_info_single->updatedDate; ?></td>
                                        <td><?php echo $household_master_info_single->updatedTime; ?></td>
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

<script>
    $('#districtID').change(function () {
        $('#slumID').html('<option value="">Select Slum</option>');
        $('#slumAreaID').html('<option value="">Select Slum Area</option>');
        var districtID = $('#districtID').val();
        if (districtID != '')
        {
            $.ajax({
                url: "<?php echo base_url(); ?>Reports/getUpaZila<?php echo '?baseID=' . $baseID ?>",
                                method: "POST",
                                data: {"districtID": districtID
                                },
                                success: function (data) {
                                    $('#thanaID').html('');
                                    $('#thanaID').html(data);

                                },
                                error: function (data) {
                                    // do something
                                }
                            });
                        } else
                        {
                            $('#thanaID').html('<option value="">Select Upazila</option>');
                        }
                    });

                    $('#thanaID').change(function () {
                        $('#slumAreaID').html('<option value="">Select Slum Area</option>');
                        var thanaID = $('#thanaID').val();
                        if (thanaID != '')
                        {
                            $.ajax({
                                url: "<?php echo base_url(); ?>Reports/getSlum<?php echo '?baseID=' . $baseID ?>",
                                                method: "POST",
                                                data: {thanaID: thanaID},
                                                success: function (data)
                                                {
                                                    $('#slumID').html('');
                                                    $('#slumID').html(data);
                                                    $('#slumID').val('<?php echo $slum_id; ?>').trigger('change');
                                                }
                                            });
                                        } else
                                        {
                                            $('#slumID').html('<option value="">Select Slum</option>');
                                        }
                                    });

                                    $('#slumID').change(function () {
                                        var slumID = $('#slumID').val();
                                        if (slumID != '')
                                        {
                                            $.ajax({
                                                url: "<?php echo base_url(); ?>Reports/getSlumArea<?php echo '?baseID=' . $baseID ?>",
                                                                method: "POST",
                                                                data: {slumID: slumID},
                                                                success: function (data)
                                                                {
                                                                    $('#slumAreaID').html('');
                                                                    $('#slumAreaID').html(data);
                                                                    $('#slumAreaID').val('<?php echo $slumarea_id; ?>').trigger('change');
                                                                }
                                                            });
                                                        } else
                                                        {
                                                            $('#slumAreaID').html('<option value="">Select Slum Area</option>');
                                                        }
                                                    });

                                                    var seldistrictId = '<?php echo $district_id ?>';
                                                    if (seldistrictId > 0)
                                                    {

                                                        var districtID = seldistrictId;
                                                        if (districtID != '')
                                                        {
                                                            $.ajax({
                                                                url: "<?php echo base_url(); ?>Reports/getUpaZila<?php echo '?baseID=' . $baseID ?>",
                                                                                method: "POST",
                                                                                data: {districtID: districtID},
                                                                                success: function (data)
                                                                                {
                                                                                    $('#thanaID').html('');

                                                                                    $('#thanaID').html(data);
                                                                                    $('#thanaID').val('<?php echo $thana_id; ?>').trigger('change');
                                                                                }
                                                                            });

                                                                        }

                                                                    }

                                                                    var selThanaId = '<?php echo $thana_id; ?>';

                                                                    if (selThanaId > 0)
                                                                    {

                                                                        var thanaID = selThanaId;
                                                                        if (thanaID != '')
                                                                        {
                                                                            $.ajax({
                                                                                url: "<?php echo base_url(); ?>Reports/getSlum<?php echo '?baseID=' . $baseID ?>",
                                                                                                method: "POST",
                                                                                                data: {thanaID: thanaID},
                                                                                                success: function (data)
                                                                                                {
                                                                                                    $('#slumID').html('');

                                                                                                    $('#slumID').html(data);
                                                                                                    $('#slumID').val('<?php echo $slum_id; ?>').trigger('change');
                                                                                                }
                                                                                            });

                                                                                        }

                                                                                    }


                                                                                    var selSlumId = '<?php echo $slum_id; ?>';

                                                                                    if (selSlumId > 0)
                                                                                    {

                                                                                        var slumID = selSlumId;
                                                                                        if (slumID != '')
                                                                                        {
                                                                                            $.ajax({
                                                                                                url: "<?php echo base_url(); ?>Reports/getSlumArea<?php echo '?baseID=' . $baseID ?>",
                                                                                                                method: "POST",
                                                                                                                data: {slumID: slumID},
                                                                                                                success: function (data)
                                                                                                                {
                                                                                                                    $('#slumAreaID').html('');

                                                                                                                    $('#slumAreaID').html(data);
                                                                                                                    $('#slumAreaID').val('<?php echo $slumarea_id; ?>').trigger('change');
                                                                                                                }
                                                                                                            });

                                                                                                        }

                                                                                                    }
</script>
