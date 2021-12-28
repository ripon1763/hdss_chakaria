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
                    <a class="btn btn-primary" href="<?php echo base_url() . $controller . '/sav_format_asset' . '?baseID=' . $baseID ?>">sav</a>
                    <a class="btn btn-primary" href="<?php echo base_url() . $controller . '/dta_format_asset' . '?baseID=' . $baseID ?>">dta</a>
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
                                    <th>fk_owner_land_CODE</th>
                                    <th>fk_owner_land_NAME</th>
                                    <th>fk_owner_house_CODE</th>
                                    <th>fk_owner_house_NAME</th>
                                    <th>fk_chair_CODE</th>
                                    <th>fk_chair_NAME</th>
                                    <th>fk_dining_table_CODE</th>
                                    <th>fk_dining_table_NAME</th>
                                    <th>fk_khat_CODE</th>
                                    <th>fk_khat_NAME</th>
                                    <th>fk_chowki_CODE</th>
                                    <th>fk_chowki_NAME</th>
                                    <th>fk_almirah_CODE</th>
                                    <th>fk_almirah_NAME</th>
                                    <th>fk_sofa_CODE</th>
                                    <th>fk_sofa_NAME</th>
                                    <th>fk_radio_CODE</th>
                                    <th>fk_radio_NAME</th>
                                    <th>fk_tv_CODE</th>
                                    <th>fk_tv_NAME</th>
                                    <th>fk_freeze_CODE</th>
                                    <th>fk_freeze_NAME</th>
                                    <th>fk_mobile_CODE</th>
                                    <th>fk_mobile_NAME</th>
                                    <th>fk_electric_fan_CODE</th>
                                    <th>fk_electric_fan_NAME</th>
                                    <th>fk_hand_watch_CODE</th>
                                    <th>fk_hand_watch_NAME</th>
                                    <th>fk_rickshow_CODE</th>
                                    <th>fk_rickshow_NAME</th>
                                    <th>fk_computer_CODE</th>
                                    <th>fk_computer_NAME</th>
                                    <th>fk_sewing_machine_CODE</th>
                                    <th>fk_sewing_machine_NAME</th>
                                    <th>fk_cycle_CODE</th>
                                    <th>fk_cycle_NAME</th>
                                    <th>fk_motor_cycle_CODE</th>
                                    <th>fk_motor_cycle_NAME</th>


                                    <th>insertedBy</th>
                                    <th>insertedDate</th>
                                    <th>insertedTime</th>
                                    <th>updateBy</th>
                                    <th>updatedDate</th>
                                    <th>updatedTime</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($asset_info as $asset_info_single) { ?>
                                    <tr>
                                        <?php if ($editPerm) { ?>
                                            <td><a href="<?php echo base_url() . $controller . '/' . $editMethod . '/' . $asset_info_single->id . '?baseID=' . $baseID; ?>" class="btn btn-sm btn-primary">Edit</a></td>
                                        <?php } ?>
                                        <td><?php echo $asset_info_single->household_code; ?></td>
                                        <td><?php echo $asset_info_single->fk_owner_land_code; ?></td>
                                        <td><?php echo $asset_info_single->fk_owner_land_name; ?></td>
                                        <td><?php echo $asset_info_single->fk_owner_house_code; ?></td>
                                        <td><?php echo $asset_info_single->fk_owner_house_name; ?></td>
                                        <td><?php echo $asset_info_single->fk_chair_code; ?></td>
                                        <td><?php echo $asset_info_single->fk_chair_name; ?></td>
                                        <td><?php echo $asset_info_single->fk_dining_table_code; ?></td>
                                        <td><?php echo $asset_info_single->fk_dining_table_name; ?></td>
                                        <td><?php echo $asset_info_single->fk_khat_code; ?></td>
                                        <td><?php echo $asset_info_single->fk_khat_name; ?></td>
                                        <td><?php echo $asset_info_single->fk_chowki_code; ?></td>
                                        <td><?php echo $asset_info_single->fk_chowki_name; ?></td>

                                        <td><?php echo $asset_info_single->fk_almirah_code; ?></td>
                                        <td><?php echo $asset_info_single->fk_almirah_name; ?></td>

                                        <td><?php echo $asset_info_single->fk_sofa_code; ?></td>
                                        <td><?php echo $asset_info_single->fk_sofa_name; ?></td>
                                        <td><?php echo $asset_info_single->fk_radio_code; ?></td>
                                        <td><?php echo $asset_info_single->fk_radio_name; ?></td>
                                        <td><?php echo $asset_info_single->fk_tv_code; ?></td>
                                        <td><?php echo $asset_info_single->fk_tv_name; ?></td>
                                        <td><?php echo $asset_info_single->fk_freeze_code; ?></td>
                                        <td><?php echo $asset_info_single->fk_freeze_name; ?></td>
                                        <td><?php echo $asset_info_single->fk_mobile_code; ?></td>
                                        <td><?php echo $asset_info_single->fk_mobile_name; ?></td>
                                        <td><?php echo $asset_info_single->fk_electric_fan_code; ?></td>
                                        <td><?php echo $asset_info_single->fk_electric_fan_name; ?></td>
                                        <td><?php echo $asset_info_single->fk_hand_watch_code; ?></td>
                                        <td><?php echo $asset_info_single->fk_hand_watch_name; ?></td>
                                        <td><?php echo $asset_info_single->fk_rickshow_code; ?></td>
                                        <td><?php echo $asset_info_single->fk_rickshow_name; ?></td>
                                        <td><?php echo $asset_info_single->fk_computer_code; ?></td>
                                        <td><?php echo $asset_info_single->fk_computer_name; ?></td>
                                        <td><?php echo $asset_info_single->fk_sewing_machine_code; ?></td>
                                        <td><?php echo $asset_info_single->fk_sewing_machine_name; ?></td>
                                        <td><?php echo $asset_info_single->fk_cycle_code; ?></td>
                                        <td><?php echo $asset_info_single->fk_cycle_name; ?></td>
                                        <td><?php echo $asset_info_single->fk_motor_cycle_code; ?></td>
                                        <td><?php echo $asset_info_single->fk_motor_cycle_name; ?></td>

                                        <td><?php echo $asset_info_single->insertedBy_name; ?></td>
                                        <td><?php echo $asset_info_single->insertedDate; ?></td>
                                        <td><?php echo $asset_info_single->insertedTime; ?></td>
                                        <td><?php echo $asset_info_single->updateBy_name; ?></td>
                                        <td><?php echo $asset_info_single->updatedDate; ?></td>
                                        <td><?php echo $asset_info_single->updatedTime; ?></td>
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
