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
                    <a class="btn btn-primary" href="<?php echo base_url() . $controller . '/sav_format_death' . '?baseID=' . $baseID ?>">sav</a>
                    <a class="btn btn-primary" href="<?php echo base_url() . $controller . '/dta_format_death' . '?baseID=' . $baseID ?>">dta</a>
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
                                    <th>Death Date</th>
                                    <th>Death Time</th>
                                    <th>fk_death_cause_CODE</th>
                                    <th>fk_death_cause_NAME</th>
                                    <th>fk_death_place_CODE</th>
                                    <th>fk_death_place_NAME</th>
                                    <th>fk_death_type_CODE</th>
                                    <th>fk_death_type_NAME</th>
                                    <th>fk_death_confirmby_CODE</th>
                                    <th>fk_death_confirmby_NAME</th>


                                    <th>insertedBy</th>
                                    <th>insertedDate</th>
                                    <th>insertedTime</th>
                                    <th>updateBy</th>
                                    <th>updatedDate</th>
                                    <th>updatedTime</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($death_info as $death_info_single) { ?>
                                    <tr>
                                        <?php if ($editPerm) { ?>
                                            <td><a href="<?php echo base_url() . $controller . '/' . $editMethod . '/' . $death_info_single->id . '?baseID=' . $baseID; ?>" class="btn btn-sm btn-primary">Edit</a></td>
                                        <?php } ?>
                                        <td><?php echo $death_info_single->household_code; ?></td>
                                        <td><?php echo $death_info_single->member_code; ?></td>
                                        <td><?php echo $death_info_single->member_name; ?></td>
                                        <td><?php echo $death_info_single->birth_date; ?></td>
                                        <td><?php echo $death_info_single->death_date; ?></td>
                                        
                                        <td><?php echo $death_info_single->death_time; ?></td>
                                        <td><?php echo $death_info_single->fk_death_cause_code; ?></td>
                                        <td><?php echo $death_info_single->fk_death_cause_name; ?></td>
                                        <td><?php echo $death_info_single->fk_death_place_code; ?></td>
                                        <td><?php echo $death_info_single->fk_death_place_name; ?></td>
                                        <td><?php echo $death_info_single->fk_death_type_code; ?></td>
                                        <td><?php echo $death_info_single->fk_death_type_name; ?></td>
                                        <td><?php echo $death_info_single->fk_death_confirmby_code; ?></td>
                                        <td><?php echo $death_info_single->fk_death_confirmby_name; ?></td>
                                        <td><?php echo $death_info_single->insertedBy_name; ?></td>
                                        <td><?php echo $death_info_single->insertedDate; ?></td>
                                        <td><?php echo $death_info_single->insertedTime; ?></td>
                                        <td><?php echo $death_info_single->updateBy_name; ?></td>
                                        <td><?php echo $death_info_single->updatedDate; ?></td>
                                        <td><?php echo $death_info_single->updatedTime; ?></td>
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
