

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

                    <form action="#" id="myForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8">

                    <!-- SmartWizard html -->
                    <div id="smartwizard">
                        <ul>
                            <li><a href="#split"><small>Split</small></a></li>
                            <li><a href="#marge"><small>Marge</small></a></li>
                            <li><a href="#step-3"><small>Migration in</small></a></li>
                            <li><a href="#step-4"><small>Migration out</small></a></li>
                            <li><a href="#step-5"><small>Marriage Start</small></a></li>
                            <li><a href="#step-6"><small>Marriage End</small></a></li>
                            <li><a href="#step-7"><small>Conception</small></a></li>
                            <li><a href="#step-8"><<small>Birth</small></a></li>
                            <li><a href="#step-9"><small>Asset</small></a></li>
                            <li><a href="#step-10"><small>Head</small></a></li>
                            <li><a href="#step-11"><small>Relation</small></a></li>
                            <li><a href="#step-12"><small>Death</small></a></li>
                            <li><a href="#step-13"><small>Interview</small></a></li>
                        </ul>

                        <div>
                            <div id="split">
                                <h2>Your Email Address</h2>

                                <div id="form-step-0" role="form" data-toggle="validator">
                                    <div class="form-group">
                                        <label for="email">Any Household Split occur ?</label>
                                         <select name="split" class="form-control" required style="">
                                             <option value="">Please Select</option>
                                             <option value="1">Yes</option>
                                             <option value="2">No</option>
                                         </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>

                            </div>
                            <div id="marge">
                                <h2>Your Name</h2>
                                <div id="form-step-1" role="form" data-toggle="validator">
                                    <div class="form-group">
                                        <label for="name">Name:</label>
                                        <input type="text" class="form-control" name="name" id="email" placeholder="Write your name" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div id="step-3">
                                <h2>Your Address</h2>
                                <div id="form-step-2" role="form" data-toggle="validator">
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <textarea class="form-control" name="address" id="address" rows="3" placeholder="Write your address..." required></textarea>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div id="step-4" class="">
                                <h2>Terms and Conditions</h2>
                                <p>
                                    Terms and conditions: Keep your smile :)
                                </p>
                                <div id="form-step-3" role="form" data-toggle="validator">
                                    <div class="form-group">
                                        <label for="terms">I agree with the T&C</label>
                                        <input type="checkbox" id="terms" data-error="Please accept the Terms and Conditions" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>

                 </form>
                   
                  
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>

