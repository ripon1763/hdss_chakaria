<script type="text/javascript">

 $(function () {

     $('#startdate').datepicker({
         autoclose: true,
         format: 'dd/mm/yyyy'
       });

      $('#enddate').datepicker({
         autoclose: true,
         format: 'dd/mm/yyyy'
       });
 });
</script>

<?php

$startDate = '';
$endDate = '';
$id = 0;
$active = '';


if(!empty($userInfo))
{
    foreach ($userInfo as $uf)
    {
        $startDate = $uf->startDate;
        $id = $uf->id;
        $endDate = $uf->endDate;
        $active = $uf->active;
        
    }
}

?>

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
                         <a class="btn btn-primary" href="<?php echo base_url().$controller.'?baseID='.$baseID ?>"><?php echo $shortName ?> List</a>
                </div>
            </div>
        </div>
    </section>
    
    <section class="content content-margin">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title"><?php echo $shortName ?> Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
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
                    
                    <form role="form" action="<?php echo base_url().$controller.'/'.$actionMethod.'?baseID='.$baseID ?>" method="post" id="editUser" role="form">
                        <div class="box-body">
                            

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Item Name">Start Date * (dd/mm/yyyy)</label>
                                        <input type="hidden"  name="id" value="<?php echo $id ?>">


                                        <?php 
                                                   if ($startDate != "")
                                                   {
                                                    $partsRequire = explode('-', $startDate);
                                                    $startDate = $partsRequire[2].'/'.$partsRequire[1].'/'.$partsRequire[0];
                                                   }
                                         ?>
                                        

                                        <input type="text" class="form-control required" value="<?php echo $startDate ?>" id="startdate"  name="startDate"  required="required">
                                    </div>
                                </div>
                            </div>
                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Item Name">End Date (dd/mm/yyyy)</label>

                                        <?php 
                                                   if ($endDate != "")
                                                   {
                                                    $parts = explode('-', $endDate);
                                                    $endDate = $parts[2].'/'.$parts[1].'/'.$parts[0];
                                                   }
                                         ?>


                                        <input type="text" class="form-control required" value="<?php echo $endDate ?>" id="enddate"  name="endDate"  >
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group ckhbox required">
                                        <label for="Item Name">Slum Name</label>
                                         <?php
                                            if(!empty($slumList))
                                            {
                                                foreach ($slumList as $slum)
                                                {


                                                    $arr = array();
                                                   
                                                    foreach ($slumRound as $slumR)
                                                    {
                                                        $arr[] = $slumR->slumID;
                                                       
                                                    }


                                                  ?>

                                                   &nbsp; <input type="checkbox" <?php  if (in_array($slum->id , $arr)) { echo "checked=checked"; } ?> name="slumID[]"  value="<?php echo $slum->id ?>" > &nbsp; <?php echo $slum->name ?>
                                                    
                                                    <?php
                                                }
                                            }
                                            ?>
                                    </div>
                                </div>
                            </div>

							<div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Active">Active</label>
                                        <select class="form-control required" id="role" name="active">
                                            <option value="1" <?php if($active == 1) {echo "selected=selected";}?>>Yes</option>
											<option value="0"  <?php if($active == 0) {echo "selected=selected";}?> >No</option>
                                            
                                        </select>
                                    </div>
                                </div>    
                            </div>
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Save" />
                          
                        </div>
                    </form>
                </div>
            </div>
            
        </div>    
    </section>
</div>
