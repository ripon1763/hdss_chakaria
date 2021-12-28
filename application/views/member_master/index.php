<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
       <div class="row">
		     <div class="col-xs-7 text-left header-margin ">
	              <h3>
					<?php echo $pageTitle; ?>
				
					<?php $baseID = $this->input->get('baseID',TRUE); ?>
				  </h3>
               
            </div>
            <div class="col-xs-5 text-right">
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

                <form action="<?php echo base_url().$controller ?>?baseID=<?php echo $baseID ?>" method="POST">
                   <div class="row" style="margin-bottom:20px; margin-left: 0px">
                    
                     <div class="col-md-2 no-print">
                      <div class="input-group">
                        <label class="control-label" for="Start Date">District <span style="color:red">*</span></label>
                            <select class="form-control" id="districtID"  name="district_id" required>
                               <option value="">--- Select District ---</option>
                                <?php
                                if(!empty($district))
                                {
                                    foreach ($district as $district)
                                    {
                                        ?>
                                        <option <?php if($district->id == $district_id) { echo "selected=selected";} ?>  value="<?php echo $district->id ?>"><?php echo $district->code. '-' .$district->name ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        
                      </div>
                    </div>
                    <div class="col-md-2 no-print">
                        <div class="input-group">
                            <label for="Item Name">City area <span style="color:red">*</span></label>

                            <select  class="form-control required" id="thanaID" name="thana_id" required>
                                <option value="">--- Select City area ---</option>
                            </select>
                          
                          
                        </div>
                    </div>
                    <div class="col-md-2 no-print">
                        <div class="input-group">
                            <label for="Item Name">Slum Name<span style="color:red">*</span></label>
                                        
                              <select class="form-control required" id="slumID" name="slum_id" required>
                                 <option value="">--- Select Slum Name---</option>
                              </select>
                        </div>
                    </div>
                     <div class="col-md-2 no-print">
                        <div class="input-group">
                            <label for="Item Name">Slum Area </label>
                                        
                              <select class="form-control required" id="slumAreaID" name="slumarea_id">
                                 <option value="">--- Select Slum Area ---</option>
                                 
                              </select>
                        </div>
                    </div>
                     <div class="col-md-2 no-print">
                          <div class="form-group">
                              <label for="Item Name">Household Code <span style="color:red">*</span></label>
                              
                              <select class="form-control required" id="househodID" name="household_id" >
                                 <option value="">--- Select Household ---</option>
                                 
                              </select>
                          </div>
                      </div>
                    <div class="col-md-2 no-print">
                    <button title="Search" type="submit" class="btn btn-sm btn-default pull-left" name="search" value="search" style="margin-top:25px"><i class="fa fa-search"> </i></button>
                    &nbsp;<button title="Clear" type="submit" class="btn btn-sm btn-default pull-left" name="Clear" value="Clear" style="margin-top:25px; margin-left:5px"><i class="fa fa-eraser"> </i></button>
                      
                    </div>
                    </div>
                </form>

                <div class="box-body">
                  <div class="table-responsive">
                   <table id="UnitList" class="table table-bordered table-striped">
					<thead>
                    <tr>
                      <th class="noExport">Actions</th>
                      <th>RID</th>
                      <th>CID</th>
                      <th>Member Name</th>
					  <th>Household Code</th>
                      <th>InsertedOn</th>
                      <th>#</th>
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
					     <?php if ($editPerm == 1): 
                     if ($record->fk_extinct_type == 0) :
                   ?>
                          <a class="btn btn-primary" href="<?php echo base_url().$controller.'/'.$editMethod.'/'.$record->id.'?household_master_id='.$record->household_master_id_hh.'&&baseID='.$baseID ?>"><i class="fa fa-pencil"></i></a>
					    <?php endif; endif; ?>
					  </td>
                      <td><?php echo $record->member_code ?></td>
                      <td><?php echo $record->current_indenttification_id ?></td>
                      <td><?php echo $record->member_name ?></td>
                      <td><?php echo $record->household_code  ?></td>
                      <td><?php echo date('j F Y h:i:s a', strtotime($record->insertedOn)); ?></td>
                      <td><?php echo $record->id ?></td>
                      
                    </tr>
                    <?php
                        }
                    }
                    ?>
					</tbody>
					<tfoot>
					<tr>
                      <th class="noExport">Actions</th>
                      <th>RID</th>
                      <th>CID</th>
					  <th>Member Name</th>
					  <th>Household Code</th>
					  <th>InsertedOn</th>
                      <th>#</th>
                    </tr>
					</tfoot>
                  </table>
                  </div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>
   <script>
  $(function () {
        $("#UnitList").DataTable({
        "order": [[ 6, "asc" ]],
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

  <script type="text/javascript">


    $(document).ready(function() {


    $('#districtID').change(function(){
          var districtID = $('#districtID').val();
          if(districtID != '')
          {
           $.ajax({
            url:"<?php echo base_url(); ?>api/getUpaZila",
            method:"POST",
            data:{districtID:districtID},
            success:function(data)
            {
             $('#thanaID').html('');
             $('#thanaID').html(data);
            //$('#city').html('<option value="">Select City</option>');
            }
           });
          }
          else
          {
           $('#thanaID').html('<option value="">--- Select City area ---</option>');
           $('#slumID').html('<option value="">--- Select Slum name---</option>');
          }
     });


    $('#thanaID').change(function(){
          var thanaID = $('#thanaID').val();
          if(thanaID != '')
          {
           $.ajax({
            url:"<?php echo base_url(); ?>api/getSlum",
            method:"POST",
            data:{thanaID:thanaID},
            success:function(data)
            {
             $('#slumID').html('');
             $('#slumID').html(data);
             $('#slumID').val('<?php echo $slum_id; ?>').trigger('change');
            //$('#city').html('<option value="">Select City</option>');
            }
           });
          }
          else
          {
           $('#slumID').html('<option value="">--- Select Slum name---</option>');
           //$('#city').html('<option value="">Select City</option>');
          }
     });


    $('#slumID').change(function(){
          var slumID = $('#slumID').val();
          if(slumID != '')
          {
           $.ajax({
            url:"<?php echo base_url(); ?>api/getSlumArea",
            method:"POST",
            data:{slumID:slumID},
            success:function(data)
            {
             $('#slumAreaID').html('');
             $('#slumAreaID').html(data);
             $('#slumAreaID').val('<?php echo $slumarea_id; ?>').trigger('change');
           //  console.log(data);
            //$('#city').html('<option value="">Select City</option>');
            }
           });
          }
          else
          {
           $('#slumAreaID').html('<option value="">--- Select Slum Area ---</option>');
           //$('#city').html('<option value="">Select City</option>');
          }
     });

    $('#slumAreaID').change(function(){
          var slumAreaID = $('#slumAreaID').val();
          if(slumAreaID != '')
          {
           $.ajax({
            url:"<?php echo base_url(); ?>api/getHousehold",
            method:"POST",
            data:{slumAreaID:slumAreaID},
            success:function(data)
            {
             $('#househodID').html('');
             $('#househodID').html(data);
             $('#househodID').val('<?php echo $household_id; ?>').trigger('change');
            // console.log(data);
            //$('#city').html('<option value="">Select City</option>');
            }
           });
          }
          else
          {
           $('#househodID').html('<option value="">--- Select Household ---</option>');
           //$('#city').html('<option value="">Select City</option>');
          }
     });


    var seldistrictId = '<?php echo $district_id ?>';
    if (seldistrictId > 0)
    {

         var districtID = seldistrictId;
          if(districtID != '')
          {
           $.ajax({
            url:"<?php echo base_url(); ?>api/getUpaZila",
            method:"POST",
            data:{districtID:districtID},
            success:function(data)
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
          if(thanaID != '')
          {
           $.ajax({
            url:"<?php echo base_url(); ?>api/getSlum",
            method:"POST",
            data:{thanaID:thanaID},
            success:function(data)
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
          if(slumID != '')
          {
           $.ajax({
            url:"<?php echo base_url(); ?>api/getSlumArea",
            method:"POST",
            data:{slumID:slumID},
            success:function(data)
            {
             $('#slumAreaID').html('');

             $('#slumAreaID').html(data);
             $('#slumAreaID').val('<?php echo $slumarea_id; ?>').trigger('change');
            }
           });

          }   

    }

     var selHouseId = '<?php echo $household_id; ?>';

    if (selHouseId > 0)
    {

         var slumAreaID = selHouseId;


          if(slumAreaID != '')
          {
           $.ajax({
            url:"<?php echo base_url(); ?>api/getHousehold",
            method:"POST",
            data:{slumAreaID:slumAreaID},
            success:function(data)
            {
             $('#househodID').html('');

             $('#househodID').html(data);
             $('#househodID').val('<?php echo $household_id; ?>').trigger('change');
             //console.log(data);
            }
           });

          }   

    }


        
    });
</script>               
