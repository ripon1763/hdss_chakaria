<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
       <div class="row">
		     <div class="col-xs-6 text-left header-margin ">
	              <h3>
					<?php echo $pageTitle; ?>
					<small>(Add, Edit)</small>
					<?php $baseID = $this->input->get('baseID',TRUE); ?>
				  </h3>
               
            </div>
            <div class="col-xs-6 text-right">
                <div class="form-group margin5pxBot">
				      <?php if ($addPerm == 1): ?>
                      <a class="btn btn-primary" style="display:none" href="<?php echo base_url().$controller.'/'.$addMethod.'?baseID='.$baseID ?>">Add New</a>
					  
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
                    
					
					<?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
					?>
					<div class="alert alert-danger alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<?php echo $this->session->flashdata('error'); ?>
					</div>
					<?php } ?>
					<?php
						$success = $this->session->flashdata('success');
						if($success)
						{
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
					  <div class="col-md-6">
						   <div class="form-group text-left">
								   <?php if ($searchMaster) {  ?>
										<a class="btn btn-primary" href="<?php echo base_url().$controller.'/addNew?lookup_master_id='.$searchMaster.'&baseID='.$baseID ?>">Add New</a>
								   <?php }?>
						  </div>
					  </div>
					   <div class="col-md-4 no-print">
							<div class="input-group pull-right">
							  <label class="control-label" for="Asset Type">Lookup type </label>
							           <select class="form-control required" id="role" name="searchMaster">
                                           <option>Select Lookup type</option>
                                            <?php
                                            if(!empty($lookupMasterType))
                                            {
                                                foreach ($lookupMasterType as $type)
                                                {
                                                    ?>
                                                    <option <?php if ($searchMaster == $type->id) { echo 'selected=selected';} ?> value="<?php echo $type->id ?>"><?php echo $type->name ?></option>
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
                      <th class="noExport">Actions</th>
                      <th>Lookup type</th>
                      <th width="30%">Name</th>
                      <th>Code</th>
                      <th>Internal Code</th>
                      <th>Display order</th>
					  <th>Active</th>
                      
                     
                    </tr>
					</thead>
					<tbody>
                    <?php 
                    if(!empty($userRecords))
                    {
                        foreach($userRecords as $record)
                        {
                    ?>
                    <tr>
					  <td class="noExport">
					     <?php if ($editPerm == 1): ?>
                          <a class="btn btn-primary" href="<?php echo base_url().$controller.'/'.$editMethod.'/'.$record->id . '?baseID='.$baseID ?>"><i class="fa fa-pencil"></i></a>
					    <?php endif; ?>
					  </td>
                      <td><?php echo $record->lookup_master_name ?></td>
                      <td><?php echo $record->name ?></td>
                      <td><?php echo $record->code ?></td>
                      <td><?php echo $record->internal_code ?></td>
                      <td><?php echo $record->display_order ?></td>
                      <td><?php if ($record->active == 1 ) { echo "Yes"; } else { echo "No"; } ?></td>
                    
                     
                      
                    </tr>
                    <?php
                        }
                    }
                    ?>
					</tbody>
					<tfoot>
					<tr>
                      <th class="noExport">Actions</th>
					  <th>Lookup type</th>
                      <th>Name</th>
                      <th>Code</th>
					  <th>Internal Code</th>
					  <th>Display order</th>
                      <th>Active</th>
                      
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
        "order": [[ 5, "asc" ]],
		dom: 'lBfrtip',
		'lengthMenu': [[10, 25, 50,100, -1], [10, 25, 50,100, 'All']],
		

            //buttons: ['copy','csv','excel','pdf','print'],
			buttons: [{
                    extend: 'pdf',
                    title: '<?php echo $shortName.' '.$boxTitle ?> Report',
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                },{
                    extend: 'excel',
                    title: '<?php echo $shortName.' '.$boxTitle ?> Report',
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                }, {
                    extend: 'csv',
                    title: '<?php echo $shortName.' '.$boxTitle ?> Report',
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                }, {
                    extend: 'print',
                    title: '<?php echo $shortName.' '.$boxTitle ?> Report',
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                }
            ]
    });
      });
  </script>                 
