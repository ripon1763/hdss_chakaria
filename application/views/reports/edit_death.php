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
                    <a class="btn btn-primary" href="<?php echo base_url() . $controller . '/death?baseID=' . $baseID ?>"><?php echo $shortName ?> List</a>
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
                        <input type="hidden" name="deathID" value="<?php echo $death_info->id; ?>">
                        <input type="hidden" name="member_master_id" value="<?php echo $death_info->member_master_id; ?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <b>Household Code:</b> <?php echo $death_info->household_code; ?>
                                </div>
                                <div class="col-md-3 form-group">
                                    <b>Round No:</b> <?php echo $death_info->round_master_id; ?>
                                </div>
                                <div class="col-md-3 form-group">
                                    <b>Member Code:</b> <?php echo $death_info->member_code; ?>
                                </div>
                                <div class="col-md-3 form-group">
                                    <b>Member Name:</b> <?php echo $death_info->member_name; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <b>Gender:</b> <?php echo $death_info->gender_code.'-'.$death_info->gender_name; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Item Name">Death Date <span style="color:red">*</span></label>

                                        <?php
                                        if ($death_info->death_date != "") {
                                            $partsRequire = explode('-', $death_info->death_date);
                                            $death_date = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];
                                        }
                                        ?>
                                        <input type="text" class="form-control" value="<?php if(isset($death_date)) echo $death_date; ?>" id="deathdate"  name="deathDate" maxlength="255" required >
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Item Name">Death Time <span style="color:red">*</span></label>
                                        <input type="text" class="form-control" value="<?php echo $death_info->death_time; ?>" id="deathTime"  name="deathtime" maxlength="255" required >
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label for="Active">Death Place <span style="color:red">*</span></label>
                                        <select class="form-control required" id="fk_death_place" name="fk_death_place" required>
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($member_death_place)) {
                                                foreach ($member_death_place as $place) {
                                                    ?>
                                                    <option <?php if ($death_info->fk_death_place == $place->id) {
                                                echo "selected=selected";
                                            } ?> value="<?php echo $place->id ?>"><?php echo $place->code . '-' . $place->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label for="Active">Death Cause <span style="color:red">*</span></label>
                                        <select class="form-control required" id="fk_death_cause" name="fk_death_cause" required>
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($member_death_cause)) {
                                                foreach ($member_death_cause as $cause) {
                                                    ?>
                                                    <option  <?php if ($death_info->fk_death_cause == $cause->id) {
                                                echo "selected=selected";
                                            } ?> value="<?php echo $cause->id ?>"><?php echo $cause->code . '-' . $cause->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label for="Active">Type of death <span style="color:red">*</span></label>
                                        <select class="form-control required" id="fk_death_type" name="fk_death_type" required>
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($type_of_death)) {
                                                foreach ($type_of_death as $type) {
                                                    ?>
                                                    <option <?php if ($death_info->fk_death_type == $type->id) {
                                                echo "selected=selected";
                                            } ?> value="<?php echo $type->id ?>"><?php echo $type->code . '-' . $type->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label for="Active">Death confirm by <span style="color:red">*</span></label>
                                        <select class="form-control required" id="fk_death_confirmby" name="fk_death_confirmby" required>
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($death_confirm_by)) {
                                                foreach ($death_confirm_by as $confirm) {
                                                    ?>
                                                    <option <?php if ($death_info->fk_death_confirmby == $confirm->id) {
                                                echo "selected=selected";
                                            } ?> value="<?php echo $confirm->id ?>"><?php echo $confirm->code . '-' . $confirm->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>

                                        </select>
                                    </div>
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


        $('#deathdate').datepicker({
            autoclose: true,
            format: 'dd/mm/yyyy'
        });

    });

</script>

