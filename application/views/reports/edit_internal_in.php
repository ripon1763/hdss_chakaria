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
                    <a class="btn btn-primary" href="<?php echo base_url() . $controller . '/internal_in?baseID=' . $baseID ?>"><?php echo $shortName ?> List</a>
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
                        <input type="hidden" name="migrationID" value="<?php echo $internal_in_info->id; ?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <b>Household Code:</b> <?php echo $internal_in_info->household_code; ?>
                                </div>
                                <div class="col-md-3 form-group">
                                    <b>Round No:</b> <?php echo $internal_in_info->round_master_id; ?>
                                </div>
                                <div class="col-md-3 form-group">
                                    <b>Member Code:</b> <?php echo $internal_in_info->member_code; ?>
                                </div>
                                <div class="col-md-3 form-group">
                                    <b>Member Name:</b> <?php echo $internal_in_info->member_name; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <b>Member sex :</b> <?php echo $internal_in_info->gender_code . '-' . $internal_in_info->gender_name; ?>
                                </div>
                            </div>
                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border">Movement Information </legend>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Active">Movement type <span style="color:red">*</span></label>
                                        <select class="form-control" id="fk_movement_type" name="fk_movement_type" disabled="disabled">
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($memberexittyp)) {
                                                foreach ($memberexittyp as $memberexittyp) {
                                                    ?>
                                                    <option <?php
                                                    if ($internal_in_info->fk_movement_type == $memberexittyp->id) {
                                                        echo "selected=selected";
                                                    }
                                                    ?> value="<?php echo $memberexittyp->id ?>"><?php echo $memberexittyp->code . '-' . $memberexittyp->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Item Name">Movement/Migration date <span style="color:red">*</span></label>
                                        <?php
                                        if ($internal_in_info->movement_date != "") {
                                            $partsRequire = explode('-', $internal_in_info->movement_date);
                                            $movement_date = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];
                                        }
                                        ?>
                                        <input type="text" class="form-control" data-provide="datepicker-inline" value="<?php echo $movement_date ?>" id="movement_date"  name="movement_date" required>
                                    </div>
                                </div>
                                <div class="col-md-4 internal">
                                    <div class="form-group">
                                        <label for="Active">Cause internal of movement <span style="color:red">*</span></label>
                                        <select class="form-control fk_internal_cause" required id="fk_internal_cause" name="fk_internal_cause">
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($internal_movement_cause)) {
                                                foreach ($internal_movement_cause as $internal_movement_cause) {
                                                    ?>
                                                    <option <?php
                                                    if ($internal_in_info->fk_internal_cause == $internal_movement_cause->id) {
                                                        echo "selected=selected";
                                                    }
                                                    ?> value="<?php echo $internal_movement_cause->id ?>"><?php echo $internal_movement_cause->code . '-' . $internal_movement_cause->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 internal">
                                    <div class="form-group">
                                        <label for="Item Name">From Slum <span style="color:red">*</span></label>

                                        <select class="form-control slumID" id="slumID" required name="slumID">
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($slumlist)) {
                                                foreach ($slumlist as $slum) {
                                                    ?>
                                                    <option <?php
                                                    if ($internal_in_info->slumIDFrom == $slum->id) {
                                                        echo "selected=selected";
                                                    }
                                                    ?> value="<?php echo $slum->id ?>"><?php echo $slum->code . '-' . $slum->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 internal">
                                    <div class="form-group">
                                        <label for="Item Name">From Slum Area <span style="color:red">*</span></label>

                                        <select class="form-control slumAreaID" required id="slumAreaID" name="slumAreaID">
                                            <option value="">--- Select Slum Area ---</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 internal">
                                    <div class="form-group">
                                        <label for="Item Name"> From Household Code <span style="color:red">*</span></label>

                                        <select class="form-control househodID" id="househodID" required name="househodID">
                                            <option value="">--- Select Household ---</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="email">Remarks (if any)</span></label>
                                        <textarea  class="form-control" name="remarks"><?php echo $internal_in_info->remarks ?></textarea>
                                    </div>
                                </div>
                            </fieldset>
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
        $('#slumID').change(function () {
            var slumID = $('#slumID').val();
            $('#slumAreaID').val('').trigger('change');

            if (slumID != '')
            {
                $.ajax({
                    url: "<?php echo base_url(); ?>api/getSlumArea",
                    method: "POST",
                    data: {slumID: slumID},
                    success: function (data)
                    {
                        $('#slumAreaID').html('');
                        $('#slumAreaID').html(data);

                    }
                });
            } else
            {
                $('#slumAreaID').html('<option value="">--- Select Slum Area ---</option>');
            }
        });

        var selslumID = $('#slumID').val();
        if (selslumID > 0)
        {
            if (selslumID != '')
            {
                $.ajax({
                    url: "<?php echo base_url(); ?>api/getSlumArea",
                    method: "POST",
                    data: {slumID: selslumID},
                    success: function (data)
                    {
                        $('#slumAreaID').html('');
                        $('#slumAreaID').html(data);
                        $('#slumAreaID').val('<?php echo $internal_in_info->slumAreaIDFrom; ?>').trigger('change');
                    }
                });

            }

        }

        $('#slumAreaID').change(function () {
            var slumAreaID = $('#slumAreaID').val();
            if (slumAreaID != '')
            {
                $.ajax({
                    url: "<?php echo base_url(); ?>api/getHousehold",
                    method: "POST",
                    data: {slumAreaID: slumAreaID},
                    success: function (data)
                    {
                        $('#househodID').html('');
                        $('#househodID').html(data);
                        $('#househodID').val('<?php echo $internal_in_info->household_master_id_move_from; ?>').trigger('change');
                    }
                });
            } else
            {
                $('#househodID').html('<option value="">--- Select Household ---</option>');
            }
        });


    });


</script>