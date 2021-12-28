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
                    <a class="btn btn-primary" href="<?php echo base_url() . $controller . '/sav_format_member' . '?baseID=' . $baseID ?>">sav</a>
                    <a class="btn btn-primary" href="<?php echo base_url() . $controller . '/dta_format_member' . '?baseID=' . $baseID ?>">dta</a>
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
                                    <th>Member ID</th>
                                    <th>Member code</th>
                                    <th>Member name</th>
                                    <th>Birth date</th>
                                    <th>fk_marital_status_CODE</th>
                                    <th>fk_marital_status_NAME</th>
                                    <th>fk_sex_CODE</th>
                                    <th>fk_sex_NAME</th>
                                    <th>fk_religion_CODE</th>
                                    <th>fk_religion_NAME</th>
                                    <th>fk_relation_with_hhh_CODE</th>
                                    <th>fk_relation_with_hhh_NAME</th>
                                    <th>father_code</th>
                                    <th>mother_code</th>
                                    <th>spouse_code</th>
                                    <th>fk_mother_live_birth_order_CODE</th>
                                    <th>fk_mother_live_birth_order_NAME</th>
                                    <th>national_id</th>
                                    <th>fk_birth_registration_CODE</th>
                                    <th>fk_birth_registration_NAME</th>
                                    <th>birth_registration_date</th>
                                    <th>fk_why_not_birth_registration_CODE</th>
                                    <th>fk_why_not_birth_registration_NAME</th>
                                    <th>fk_additionalChild_CODE</th>
                                    <th>fk_additionalChild_NAME</th>
                                    <th>afterYear</th>
                                    <th>contactNoOne</th>
                                    <th>contactNoTwo</th>

                                    <th>insertedBy</th>
                                    <th>insertedDate</th>
                                    <th>insertedTime</th>
                                    <th>updateBy</th>
                                    <th>updatedDate</th>
                                    <th>updatedTime</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($member_info as $member_info_single) { ?>
                                    <tr>
                                        <?php if ($editPerm) { ?>
                                            <td><a href="<?php echo base_url() . $controller . '/' . $editMethod . '/' . $member_info_single->id . '?baseID=' . $baseID . '&household_master_id=' . $member_info_single->household_master_id_hh; ?>" class="btn btn-sm btn-primary">Edit</a></td>
                                        <?php } ?>
                                        <td><?php echo $member_info_single->id; ?></td>
                                        <td><?php echo $member_info_single->member_code; ?></td>
                                        <td><?php echo $member_info_single->member_name; ?></td>
                                        <td><?php echo $member_info_single->birth_date; ?></td>
                                        
                                        <td><?php echo $member_info_single->marital_status_code; ?></td>
                                        <td><?php echo $member_info_single->marital_status_name; ?></td>
                                        <td><?php echo $member_info_single->fk_sex_code; ?></td>
                                        <td><?php echo $member_info_single->fk_sex_name; ?></td>
                                        <td><?php echo $member_info_single->fk_religion_code; ?></td>
                                        <td><?php echo $member_info_single->fk_religion_name; ?></td>
                                        <td><?php echo $member_info_single->fk_relation_with_hhh_code; ?></td>
                                        <td><?php echo $member_info_single->fk_relation_with_hhh_name; ?></td>

                                        <td><?php echo $member_info_single->father_code; ?></td>
                                        <td><?php echo $member_info_single->mother_code; ?></td>
                                        <td><?php echo $member_info_single->spouse_code; ?></td>
                                        <td><?php echo $member_info_single->fk_mother_live_birth_order_code; ?></td>
                                        <td><?php echo $member_info_single->fk_mother_live_birth_order_name; ?></td>
                                        <td><?php echo $member_info_single->national_id; ?></td>
                                        <td><?php echo $member_info_single->fk_birth_registration_code; ?></td>
                                        <td><?php echo $member_info_single->fk_birth_registration_name; ?></td>
                                        <td><?php echo $member_info_single->birth_registration_date; ?></td>

                                        
                                        <td><?php echo $member_info_single->fk_why_not_birth_registration_code; ?></td>
                                        <td><?php echo $member_info_single->fk_why_not_birth_registration_name; ?></td>
                                        <td><?php echo $member_info_single->fk_additionalChild_code; ?></td>
                                        <td><?php echo $member_info_single->fk_additionalChild_name; ?></td>
                                        <td><?php echo $member_info_single->afterYear; ?></td>
                                        <td><?php echo $member_info_single->contactNoOne; ?></td>
                                        <td><?php echo $member_info_single->contactNoTwo; ?></td>

                                        <td><?php echo $member_info_single->insertedBy_name; ?></td>
                                       <td><?php echo $member_info_single->insertedDate; ?></td>
                                        <td><?php echo $member_info_single->insertedTime; ?></td>
                                        <td><?php echo $member_info_single->updateBy_name; ?></td>
                                        <td><?php echo $member_info_single->updatedDate; ?></td>
                                        <td><?php echo $member_info_single->updatedTime; ?></td>
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
