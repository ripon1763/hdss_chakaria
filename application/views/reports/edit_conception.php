<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
            <div class="col-xs-6 text-left header-margin ">
                <h3>
                    <?php echo $pageTitle; ?>
                    <small>(Edit)</small>
                    <?php $baseID = $this->input->get('baseID', TRUE); ?>
                </h3>

            </div>
            <div class="col-xs-6 text-right">
                <div class="form-group margin5pxBot">
                    <a class="btn btn-primary" href="<?php echo base_url() . $controller . '/conception?baseID=' . $baseID ?>"><?php echo $shortName ?> List</a>
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
                    <form role="form" action="<?php echo base_url() . $controller . '/' . $actionMethod . '?baseID=' . $baseID ?>" method="post" id="editUser" role="form">
                         <input type="hidden" name="conceptionID" value="<?php echo  $conception_info->id;  ?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <b>Household Code:</b> <?php echo $conception_info->household_code; ?>
                                </div>
                                <div class="col-md-3 form-group">
                                    <b>Round No:</b> <?php echo $conception_info->round_master_id; ?>
                                </div>
                                <div class="col-md-3 form-group">
                                    <b>Member Code:</b> <?php echo $conception_info->member_code; ?>
                                </div>
                                <div class="col-md-3 form-group">
                                    <b>Member Name:</b> <?php echo $conception_info->member_name; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <b>Gender:</b> <?php echo $conception_info->gender_code.'-'.$conception_info->gender_name; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="Item Name">Last menstruation/conception Date <span style="color:red">*</span></label>
                                    <?php
                                    if ($conception_info->conception_date != "") {
                                        $partsRequire = explode('-', $conception_info->conception_date);
                                        $conception_date = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];
                                    }
                                    ?>
                                    <input type="text" class="form-control hhdate" value="<?php if(isset($conception_date)) echo $conception_date; ?>" id="conception_date"  name="conception_date" maxlength="255" required >
                                </div>
                                
                                <div class="col-md-6 form-group">
                                    <label for="Active">Conception Plan <span style="color:red">*</span></label>
                                    <select class="form-control required" id="fk_conception_plan" name="fk_conception_plan" required>
                                        <option value="">Please Select</option>
                                        <?php
                                        if (!empty($conception_plan)) {
                                            foreach ($conception_plan as $conceplan) {
                                                ?>
                                                <option <?php
                                                if ($conception_info->fk_conception_plan == $conceplan->id) {
                                                    echo " selected";
                                                }
                                                ?> value="<?php echo $conceplan->id ?>"><?php echo $conceplan->code . '-' . $conceplan->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>

                                    </select>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="Active">Conception Order <span style="color:red">*</span></label>
                                    <select class="form-control required" id="fk_conception_order" name="fk_conception_order" required>
                                        <option value="">Please Select</option>
                                        <?php
                                        if (!empty($conception_order)) {
                                            foreach ($conception_order as $conceporder) {
                                                ?>
                                                <option <?php
                                                if ($conception_info->fk_conception_order == $conceporder->id) {
                                                    echo " selected";
                                                }
                                                ?> value="<?php echo $conceporder->id ?>"><?php echo $conceporder->code . '-' . $conceporder->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>

                                    </select>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="Active">Conception follow up status <span style="color:red">*</span></label>
                                    <select disabled class="form-control required" id="fk_conception_followup_status" required>
                                        <option value="">Please Select</option>
                                        <?php
                                        if (!empty($consp_follow_up_status)) {
                                            foreach ($consp_follow_up_status as $follow_up_status) {
                                                ?>
                                                <option <?php
                                                if ($conception_info->fk_conception_followup_status == $follow_up_status->id) {
                                                    echo " selected";
                                                }
                                                ?>  value="<?php echo $follow_up_status->id ?>"><?php echo $follow_up_status->code . '-' . $follow_up_status->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>

                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Update"> <input name="update_exit" type="submit" class="btn btn-primary" value="Update & Exit">
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>
</div>

<script type="text/javascript">

    $(document).ready(function () {


        $('#conception_date').datepicker({
            autoclose: true,
            format: 'dd/mm/yyyy'
        });

    });

</script>

