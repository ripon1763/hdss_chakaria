<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
            <div class="col-xs-6 text-left header-margin ">
                <h3>
                    <?php echo $pageTitle; ?>
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
						
						
						<form action="<?php echo base_url().$controller.'?baseID='.$baseID ?>" method="POST">
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
						</form>
						
						
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="UnitList" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="noExport" width="100px">Actions</th>
                                    <th>Household Code</th>
                                    <th>Member ID</th>
                                    <th>Member Name</th>
                                    <th>Birth Date</th>
                                    <th>Death Date</th>
                                    <th>Status</th>
                                    

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($userRecords)) {
                                    foreach ($userRecords as $record) {
										
										
										 $date1 = strtotime($record->birth_date);  
										 $date2 = strtotime($record->death_date);  
										  
										 $diff = abs($date2 - $date1);  
										 $years = floor($diff / (365*60*60*24)); 
										
										 $year1 = floor($diff / (60*60*24));
										
										
                                        ?>
                                        <tr>
                                            <td class="noExport">
                                                <?php if ($editPerm == 1): ?>
                                                    
													<?php if ($years >= 11) : ?>
													  <a class="btn btn-primary" href="<?php echo base_url().$controller.'/'.$editMethod.'/'.$record->id . '?household_master_id='.$record->household_master_id.'&&baseID='.$baseID ?>"><i class="fa fa-pencil"> Adult</i></a>
													  <?php endif; ?>
													 
													 <!-- <a class="btn btn-primary" href="<?php echo base_url().$controller.'/'.$editMethod.'/'.$record->id . '?baseID='.$baseID ?>"><i class="fa fa-pencil"> Child</i></a>-->
													  
													  <?php if ($year1 <= 28) : ?>
													  
													  <a class="btn btn-primary" href="<?php echo base_url().$controller.'/'.$editMethodNew.'/'.$record->id . '?household_master_id='.$record->household_master_id.'&&baseID='.$baseID ?>"><i class="fa fa-pencil"> Neonatal</i></a>
													
													  <?php endif; ?>
													  
													  
													   <?php if (($year1 > 28) &&  ($years < 11) ): ?>
													  
															<a class="btn btn-primary" href="<?php echo base_url().$controller.'/'.$editMethodChild.'/'.$record->id . '?household_master_id='.$record->household_master_id.'&&baseID='.$baseID ?>"><i class="fa fa-pencil"> Child</i></a>
													
													  <?php endif; ?>
                                               
											   <?php endif; ?>
                                            </td>
                                            <td><?php echo $record->household_code ?></td>
                                            <td><?php echo $record->member_code ?></td>
                                            <td><?php echo $record->member_name ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($record->birth_date)) ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($record->death_date)) ?></td>
											<td><?php if($record->inv_status == 1) { echo "complete";} else { echo "incomplete";} ?></td>
											

                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="noExport">Actions</th>
                                    <th>Household Code</th>
                                    <th>Member ID</th>
                                    <th>Member Name</th>
                                    <th>Birth Date</th>
                                    <th>Death Date</th>
									<th>Status</th>
									
                                </tr>
                            </tfoot>
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
