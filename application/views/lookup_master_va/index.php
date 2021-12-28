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
                      <a class="btn btn-primary" href="<?php echo base_url().$controller.'/'.$addMethod.'?baseID='.$baseID ?>">Add New</a>
					  
					  <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <section class="content <?php if ($addPerm == 1): ?>content-margin <?php else : echo "margin_need"; endif; ?>">
        <div class="row">
            <div class="col-xs-12">
              <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"><?php echo $shortName.' '.$boxTitle ?></h3>
					
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
                </div><!-- /.box-header -->
                <div class="box-body">
                   <table id="UnitList" class="table table-bordered table-striped">
					<thead>
                    <tr>
                      <th class="noExport">Actions</th>
                      <th>Name</th>
                      <th>Code</th>
                      <th>Description</th>
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
                          <a class="btn btn-primary" href="<?php echo base_url().$controller.'/'.$editMethod.'/'.$record->ID . '?baseID='.$baseID ?>"><i class="fa fa-pencil"></i></a>
					    <?php endif; ?>
					  </td>
                      <td><?php echo $record->NAME ?></td>
                      <td><?php echo $record->CODE ?></td>
                      <td><?php echo $record->DESCRIPTION ?></td>
                      <td><?php echo $record->ACTIVE  ?></td>
                    
                    
                      
                    </tr>
                    <?php
                        }
                    }
                    ?>
					</tbody>
					<tfoot>
					<tr>
                      <th class="noExport">Actions</th>
                      <th>Name</th>
                      <th>Code</th>
					  <th>Description</th>
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
        "order": [[ 2, "asc" ]],
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
