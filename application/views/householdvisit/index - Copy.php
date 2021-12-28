
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
       <div class="row">
		     <div class="col-xs-12 text-left header-margin ">
	              <h3>
					<?php echo $pageTitle; ?>
				
					<?php $baseID = $this->input->get('baseID',TRUE); ?>
				  </h3>
               
            </div>
           
        </div>
    </section>
    <section class="content margin_need">
        <div class="row">
            <div class="col-xs-12">
              <div class="box box-primary" style="min-height: 480px">
                <div class="box-header">
                    <h3 class="box-title"><?php // echo $shortName.' '.$boxTitle ?></h3>
					
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

               
                   <div class="row" style="margin-bottom:20px; margin-left: 0px">
                    <div class="col-md-2 no-print">
                       Household Code
                    </div>
                     <div class="col-md-4 no-print">
                         <form id="form_search" action="<?php echo base_url().'householdvisit?baseID='.$baseID ?>" method="post">
                               <div class="input-group">
                                  <input type="hidden" name="householdid" class="form-control" id="householdid" required>
                                  <input type="hidden" name="householdcode" class="form-control" id="householdcode">
                                  <input type="hidden" name="search" class="form-control" id="search" value="search">
                                  <input type="text" name="household_code" class="form-control" id="title" placeholder="Type Household code" required>
                                  <span class="input-group-btn">
                                      <button class="btn btn-info" type="submit">Search</button>
                                  </span>
                               </div>
                          </form>
                    </div>
                    
                    <div class="col-md-2 no-print">
                      
                    </div>
      

                <div class="box-body">
                   
                  
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>

     <script type="text/javascript">
        $(document).ready(function(){
 
            $('#title').autocomplete(
            {
                source: "<?php echo site_url('api/get_autocomplete');?>",
                minLength: 3,
      
                select: function (event, ui) 
                {
                    $(this).val(ui.item.label);
                    $('#householdid').val(ui.item.value);
                    $('#householdcode').val(ui.item.house);
                    $("#form_search").submit(); 
                }
            });
 
        });
    </script>