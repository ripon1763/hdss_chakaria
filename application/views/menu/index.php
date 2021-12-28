<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
		    <div class="col-xs-6 text-left header-margin ">
				<h3>
				   Menu Management
				  <small>Add, Edit</small>
				</h3>
	        </div>
            <div class="col-xs-6 text-right">
                <div class="form-group">
                     <a class="btn btn-primary" href="<?php echo base_url().'menu/addNew?baseID='.$baseID ?>"><i class="fa fa-plus" aria-hidden="true"></i> Add New</a>
                </div>
            </div>
        </div>
    </section>
    <section class="content content-margin">
	
        <div class="row">
            <div class="col-xs-12">
              <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Menu List</h3>
					
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
					
                </div><!-- /.box-header -->
                <div class="box-body">
                   <table id="UnitList" class="table table-bordered table-striped">
					<thead>
                    <tr>
                      <th width="4%">Action</th>
                      <th>Menu Name</th>
					  <th>Parent Name</th>
					  <th>URL</th>
                      <th>Active</th>
                      <th width="2%">#</th>
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
                      <td>
                          <a class="btn btn-primary" href="<?php echo base_url().'menu/editOld/'.$record->id .'?baseID='.$baseID ?>"><i class="fa fa-pencil"></i></a>
                        
					  </td>
                      <td><?php echo $record->menu_name ?></td>
					  <td><?php echo $record->parent_menu_name ?></td>
					  <td><?php echo $record->url ?></td>
                      <td>  <?php if ($record->status == 1 ) { echo "Yes"; } else { echo "No"; } ?></td>
                      
                      <td><?php echo $record->id ?></td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
					</tbody>
					<tfoot>
					<tr>
                      <th>Action</th>
                      <th>Menu Name</th>
					  <th>Parent Name</th> 
					  <th>URL</th>
                      <th>Active</th>
                      <th>#</th>
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
        order: [[ 5, 'asc' ]],
		dom: 'lBfrtip',
            //buttons: ['copy','csv','excel','pdf','print'],
			buttons: [{
                    extend: 'pdf',
                    title: 'Menu List',
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                },{
                    extend: 'excel',
                    title: 'Menu List',
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                }, {
                    extend: 'csv',
                    title: 'Menu List',
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                }, {
                    extend: 'print',
                    title: 'Menu List',
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                }
            ]
    });
      });
  </script>              
