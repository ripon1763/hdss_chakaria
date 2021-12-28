<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
            <div class="col-xs-6 text-left header-margin ">
                <h3>
                     Adult Verbal Autopsy
                    <small></small>
                    <?php $baseID = $this->input->get('baseID', TRUE); ?>
                </h3>

            </div>
            <div class="col-xs-6 text-right">
                <div class="form-group margin5pxBot">
                    <!--<a class="btn btn-primary" href="<?php echo base_url() . $controller . '/sav_format_adult' . '?baseID=' . $baseID ?>">sav</a>-->
                    <!--<a class="btn btn-primary" href="<?php echo base_url() . $controller . '/dta_format_adult' . '?baseID=' . $baseID ?>">dta</a>-->
                </div>
            </div>
        </div>
    </section>
    <section class="content margin_need">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title"><?php echo $shortName . ' ' . $boxTitle ?></h3>

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
						
						
						
						<!--<form action="<?php echo base_url().$controller.'/adult?baseID='.$baseID ?>" method="POST">
						 <div class="row">
						  
						   <div class="col-md-2 no-print">
								<div class="input-group pull-left">
								  <label class="control-label" for="Asset Type">Round </label>
										   <select class="form-control required" id="role" name="round_master_id" required>
											   <option value="">Select round</option>
												<?php
												if(!empty($roundlist))
												{
													foreach ($roundlist as $round)
													{
														?>
														<option <?php if ($round_master_id == $round->id) { echo 'selected=selected';} ?> value="<?php echo $round->id ?>"><?php echo $round->round_no ?></option>
														<?php
													}
												}
												?>
											</select><?php // echo $searchStart; ?>
								  
								  
								</div>
						   </div>
							<div class="col-md-2 no-print">
							<button title="Search" type="submit" class="btn btn-sm btn-default pull-left" name="search" value="search" style="margin-top:25px"><i class="fa fa-search"> </i></button>
							&nbsp;<button title="Clear" type="submit" class="btn btn-sm btn-default pull-left" name="Clear" value="Clear" style="margin-top:25px; margin-left:5px"><i class="fa fa-eraser"> </i></button>
								
							</div>
							
						  </div>
						</form> -->
						
						
                    </div><!-- /.box-header -->
                    <div class="box-body"  style="overflow-x:auto;">
                        <table style="white-space:nowrap;" id="UnitList" class="table table-bordered table-striped">
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
                                    $i = 1;
                                    foreach ($fields as $key => $value) {

                                        if (in_array($value, $dropdown)) {
                                            echo '<th>' . $value . '_NAME</th>';
                                            echo '<th>' . $value . '_CODE</th>';
                                        } else {
                                            echo '<th>' . $value . '</th>';
                                        }

                                        $i++;
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
                                                $edit_link = base_url() . $controller . '/editOld' . '/' . $record->id . '?household_master_id='.$record->household_master_id.'&&baseID=' . $baseID;
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
                                            $i = 1;
                                            foreach ($fields as $key => $value) {




                                                if (in_array($value, $dropdown)) {

                                                    if (isset($lookUp[$record->$value])) {

                                                        $val = json_decode($lookUp[$record->$value]);
                                                        echo '<td>' . $val->name . '</td>';
                                                        echo '<td>' . $val->code . '</td>';
                                                    } else {

                                                        echo '<td>' . $record->$value . '</td>';
                                                        echo '<td></td>';
                                                    }
                                                } else {



                                                    if (in_array($value, $dateFields)) {

                                                        if (($record->$value == '1900-01-01') or ($record->$value == ''))
                                                            echo '<td></td>';
                                                        else
                                                            echo "<td>" . date('d/m/Y', strtotime($record->$value)) . "</td>";
                                                    } else {
                                                        echo '<td>' . $record->$value . '</td>';
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
            //buttons: ['copy','csv','excel','pdf','print'],
            buttons: [{
                    extend: 'pdf',
                    title: 'va_adult_list_report',
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                }, {
                    extend: 'excel',
                    title: 'va_adult_list_report',
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                }, {
                    extend: 'csv',
                    title: 'va_adult_list_report',
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                }, {
                    extend: 'print',
                    title: 'va_adult_list_report',
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                }
            ]
        });
    });
</script>
