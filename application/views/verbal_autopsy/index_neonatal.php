<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
            <div class="col-xs-6 text-left header-margin ">
                <h3>
                     Neonate Verbal Autopsy
                    <small></small>
                    <?php $baseID = $this->input->get('baseID', TRUE); ?>
                </h3>

            </div>
            <div class="col-xs-6 text-right">
                <div class="form-group margin5pxBot">
                    <?php if ($addPerm == 1): ?>
                        <a class="btn btn-primary" style="display:none" href="<?php echo base_url() . $controller . '/' . $addMethod . '?baseID=' . $baseID ?>">Add New</a>

                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <section class="content margin_need">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title"><?php echo 'Neonatal ' . $boxTitle ?></h3>

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
                    <div class="box-body"  style="overflow-x:auto;">
                        <table  style="white-space: nowrap;" id="UnitList" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="noExport">Actions</th>
                                    <th>Member ID</th>
                                    <th>Member Name</th>
                                    <th>Household Code</th>
                                    <th>Birth Date</th>
                                    <th>Death Date</th>
                                    <th>Created_By</th>

                                    <?php
                                    foreach ($fields as $key => $value) {

                                        if (in_array($value, $dropdown)) {
                                            echo '<th>' . $value . '_NAME</th>';
                                            echo '<th>' . $value . '_CODE</th>';
                                        } else {
                                            echo '<th>' . $value . '</th>';
                                        }
                                    }
                                    ?>

                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                if (!empty($userRecords)) {
                                    foreach ($userRecords as $record) {
                                        ?>
                                        <tr>
                                            <td class="noExport" style="white-space: nowrap;">
                                                <?php
                                                
												$edit_link = base_url() . $controller . '/editNeonatal' . '/' . $record->id . '?household_master_id='.$record->household_master_id.'&&baseID=' . $baseID;
                                                if ($editPerm == 1):
                                                    echo "<a href='$edit_link' class='btn btn-sm btn-primary'>Edit</a>";
                                                endif;
                                                ?>
                                            </td>
                                            <td><?php echo $record->member_code ?></td>
                                            <td style="white-space: nowrap;"><?php echo $record->member_name ?></td>
                                            <td><?php echo $record->household_code ?></td>
                                            <td style="white-space: nowrap;">
                                                <?php
                                                if (!empty($record->birth_date))
                                                    echo date('d/m/Y', strtotime($record->birth_date));
                                                ?>
                                            </td>
                                            <td style="white-space: nowrap;">
                                                <?php
                                                if (!empty($record->death_date))
                                                    echo date('d/m/Y', strtotime($record->death_date));
                                                ?>

                                            </td>
                                            <td style="white-space: nowrap;"><?php echo $record->NAME ?></td>
                                            <?php
                                            foreach ($fields as $key => $value) {

                                                if (in_array($value, $dropdown)) {
                                                    if (isset($lookUp[$record->$value])) {
                                                        $val = json_decode($lookUp[$record->$value]);
                                                        echo '<td>' . $val->name . '</td>';
                                                        echo '<td>' . $val->code . '</td>';
                                                    } else {

                                                        echo '<td></td>';
                                                        echo '<td></td>';
                                                    }
                                                } else {

                                                    if (in_array($value, $dateFields)) {
                                                        if ($record->$value == '0000-00-00')
                                                            echo '<td></td>';
                                                        else
                                                            echo '<td>' . date('d/m/Y', strtotime($record->$value)) . '</td>';
                                                    } else {
                                                        if (in_array($value, $textarea)) {
                                                            echo '<td>' . $record->$value . '</td>';
                                                        } else {
                                                            echo '<td>' . $record->$value . '</td>';
                                                        }
                                                    }
                                                }
                                            }
                                            ?>


                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
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
            "order": [[4, "asc"]],
            dom: 'lBfrtip',
            'lengthMenu': [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],

            "scrollX": true,
            "columnDefs": [
                {"width": "320px", "targets": 72}, //Q4_1_death_reasons
                {"width": "320px", "targets": 249}, //Q6_5_1
                {"width": "320px", "targets": 274}, //Q6_5_3_ADDRESS
                {"width": "320px", "targets": 327}, //Q6_6_4
                {"width": "320px", "targets": 340}, //Q6_6_12
                {"width": "320px", "targets": 552}, //Q8_3_2_HOSPITAL_ADDRESS
                {"width": "320px", "targets": 558}, //Q8_4_2
                {"width": "320px", "targets": 593}, //Q10_INTERVIEW
                {"width": "320px", "targets": 594}, //Q10_CSQ
                {"width": "320px", "targets": 595}, //Q10_AOC
                {"width": "320px", "targets": 596}//Q10_SO

            ],
            //buttons: ['copy','csv','excel','pdf','print'],
            buttons: [{
                    extend: 'pdf',
                    title: 'va_neonatal_list_report',
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                }, {
                    extend: 'excel',
                    title: 'va_neonatal_list_report',
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                }, {
                    extend: 'csv',
                    title: 'va_neonatal_list_report',
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                }, {
                    extend: 'print',
                    title: 'va_neonatal_list_report',
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                }
            ]
        });
    });
</script>
