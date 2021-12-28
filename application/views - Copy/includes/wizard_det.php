<link href="<?php echo base_url(); ?>assets/widzard/css/smart_wizard.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/widzard/css/smart_wizard_theme_circles.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/widzard/css/smart_wizard_theme_arrows.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/widzard/css/smart_wizard_theme_dots.css" rel="stylesheet" type="text/css" />
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.5/validator.min.js"></script>-->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/widzard/js/jquery.smartWizard.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){

            // Toolbar extra buttons
           /* var btnFinish = $('<button></button>').text('Finish')
                                             .addClass('btn btn-info')
                                             .on('click', function(){
                                                    if( !$(this).hasClass('disabled')){
                                                        var elmForm = $("#myForm");
                                                        if(elmForm){
                                                            elmForm.validator('validate');
                                                            var elmErr = elmForm.find('.has-error');
                                                            if(elmErr && elmErr.length > 0){
                                                                alert('Oops we still have error in the form');
                                                                return false;
                                                            }else{
                                                                alert('Great! we are ready to submit form');
                                                                elmForm.submit();
                                                                return false;
                                                            }
                                                        }
                                                    }
                                                });
            var btnCancel = $('<button></button>').text('Cancel')
                                             .addClass('btn btn-danger')
                                             .on('click', function(){
                                                    $('#smartwizard').smartWizard("reset");
                                                    $('#myForm').find("input, textarea").val("");
                                                });*/



            // Smart Wizard
            $('#smartwizard').smartWizard({
                    selected: 0,
                    theme: 'arrows',
                    transitionEffect:'fade',
                    toolbarSettings: {toolbarPosition: 'bottom',
                                      toolbarExtraButtons: []
                                    },
                    anchorSettings: {
                                markDoneStep: true, // add done css
                                markAllPreviousStepsAsDone: true, // When a step selected by url hash, all previous steps are marked done
                                removeDoneStepOnNavigateBack: true, // While navigate back done step after active step will be cleared
                                enableAnchorOnDoneStep: false // Enable/Disable the done steps navigation
                            }
                 });

            $("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
                var elmForm = $("#form-step-" + stepNumber);
                // stepDirection === 'forward' :- this condition allows to do the form validation
                // only on forward navigation, that makes easy navigation on backwards still do the validation when going next
                if(stepDirection === 'forward' && elmForm){
                    elmForm.validator('validate');
                    var elmErr = elmForm.children('.has-error');
                    if(elmErr && elmErr.length > 0){
                        // Form validation failed
                        return false;
                    }
                }
                return true;
            });

           /* $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection) {
                // Enable finish button only on last step
                if(stepNumber == 3){
                    $('.btn-finish').removeClass('disabled');
                }else{
                    $('.btn-finish').addClass('disabled');
                }
            });*/

        });
    </script>



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
                    <h3 class="box-title">Member List</h3>
                    
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

                   <div id="smartwizard">
                        <ul>
                            <li><a href="#split"><small>Split</small></a></li>
                            <li><a href="#merge"><small>Merge</small></a></li>
                            <li><a href="#asset"><small>Asset</small></a></li>
                            <li><a href="#migin"><small>Movement in</small></a></li>
                            <li><a href="#migout"><small>Movement out</small></a></li>
                            <li><a href="#mstart"><small>Marriage Start</small></a></li>
                            <li><a href="#mend"><small>Marriage End</small></a></li>
                            <li><a href="#consp"><small>Conception</small></a></li>
                            <li><a href="#birth"><small>Birth</small></a></li>
                            <li><a href="#education"><small>Education</small></a></li>
                            <li><a href="#occupation"><small>Occupation</small></a></li>
                            <li><a href="#relation"><small>Relation</small></a></li>
                            <li><a href="#death"><small>Death</small></a></li>
                            <li><a href="#interview"><small>Interview</small></a></li>
                        </ul>


                       
                   