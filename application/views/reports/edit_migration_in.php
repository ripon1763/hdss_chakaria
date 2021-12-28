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
                    <a class="btn btn-primary" href="<?php echo base_url() . $controller . '/migration_in?baseID=' . $baseID ?>"><?php echo $shortName ?> List</a>
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
                        <input type="hidden" name="migrationID" value="<?php echo $migration_in_info->id; ?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <b>Household Code:</b> <?php echo $migration_in_info->household_code; ?>
                                </div>
                                <div class="col-md-3 form-group">
                                    <b>Round No:</b> <?php echo $migration_in_info->round_master_id; ?>
                                </div>
                                <div class="col-md-3 form-group">
                                    <b>Member Code:</b> <?php echo $migration_in_info->member_code; ?>
                                </div>
                                <div class="col-md-3 form-group">
                                    <b>Member Name:</b> <?php echo $migration_in_info->member_name; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <b>Member sex :</b> <?php echo $migration_in_info->gender_code . '-' . $migration_in_info->gender_name; ?>
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
                                                    if ($migration_in_info->fk_movement_type == $memberexittyp->id) {
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
                                        if ($migration_in_info->movement_date != "") {
                                            $partsRequire = explode('-', $migration_in_info->movement_date);
                                            $movement_date = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];
                                        }
                                        ?>
                                        <input type="text" class="form-control" data-provide="datepicker-inline" value="<?php echo $movement_date ?>" id="movement_date"  name="movement_date" required>
                                    </div>
                                </div>

                                <div class="col-md-4 migration">
                                    <div class="form-group">
                                        <label for="Item Name">Cause of in-migration <span style="color:red">*</span></label>

                                        <select class="form-control fk_migration_cause" id="fk_migration_cause"  name="fk_migration_cause">
                                            <option value="0">Select cause of in-migration</option>
                                            <?php
                                            if (!empty($outside_cause)) {
                                                foreach ($outside_cause as $outsidecausegroup) {
                                                    ?>
                                                    <option <?php
                                                    if ($migration_in_info->fk_migration_cause == $outsidecausegroup->id) {
                                                        echo "selected=selected";
                                                    }
                                                    ?> value="<?php echo $outsidecausegroup->id ?>"><?php echo $outsidecausegroup->code . '-' . $outsidecausegroup->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 migration">
                                    <div class="form-group">
                                        <label for="Item Name">Country From<span style="color:red">*</span></label>

                                        <select class="form-control countryID" id="countryID"  name="countryID">
                                            <option value="0">--- Select Country ---</option>
                                            <?php
                                            if (!empty($countrylist)) {
                                                foreach ($countrylist as $country) {
                                                    ?>
                                                    <option <?php
                                                    if ($migration_in_info->countryIDMoveFrom == $country->id) {
                                                        echo "selected=selected";
                                                    }
                                                    ?>  value="<?php echo $country->id ?>"><?php echo $country->code . '-' . $country->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 migration country">
                                    <div class="form-group">
                                        <label for="Item Name">Division From</label>

                                        <select class="form-control" id="divisionID"  name="divisionID">
                                            <option value="0">--- Select Division ---</option>
                                            <?php
                                            if (!empty($divisionlist)) {
                                                foreach ($divisionlist as $division) {
                                                    ?>
                                                    <option <?php
                                                    if ($migration_in_info->divisionIDMoveFrom == $division->id) {
                                                        echo "selected=selected";
                                                    }
                                                    ?> value="<?php echo $division->id ?>"><?php echo $division->code . '-' . $division->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 migration country">
                                    <div class="form-group">
                                        <label for="Item Name">District From</label>

                                        <select class="form-control" id="districtID"  name="districtID">
                                            <option value="0">--- Select District ---</option>
                                            <?php
                                            if (!empty($district)) {
                                                foreach ($district as $district) {
                                                    ?>
                                                    <option value="<?php echo $district->id ?>"><?php echo $district->code . '-' . $district->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 migration country">
                                    <div class="form-group">
                                        <label for="Item Name">Upazila From</label>

                                        <select  class="form-control required" id="thanaID" name="thanaID">
                                            <option value="0">--- Select Upazila ---</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="email">Remarks (if any)</span></label>
                                        <textarea  class="form-control" name="remarks"><?php echo $migration_in_info->remarks ?></textarea>
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
        $("#countryID").change(function () {
            $(this).find("option:selected").each(function () {
                var optionValue = $(this).attr("value");

                if (optionValue == 19)
                {
                    $(".country").show();
                } else {
                    $(".country").hide();
                }

            });
        }).change();
        
        var seldivisionID = $('#divisionID').val();
        if (seldivisionID > 0)
        {

            var divisionID = seldivisionID;
            if (divisionID != '')
            {
                $.ajax({
                    url: "<?php echo base_url(); ?>api/getDistrict",
                    method: "POST",
                    data: {divisionID: divisionID},
                    success: function (data)
                    {
                        $('#districtID').html('');

                        $('#districtID').html(data);
                        $('#districtID').val('<?php echo $migration_in_info->districtIDMoveFrom; ?>').trigger('change');

                    }
                });

            }

        }

        var sedistrictID = <?php echo $migration_in_info->districtIDMoveFrom; ?>;
        if (sedistrictID > 0)
        {

            if (sedistrictID != '')
            {
                $.ajax({
                    url: "<?php echo base_url(); ?>api/getUpaZila",
                    method: "POST",
                    data: {districtID: sedistrictID},
                    success: function (data)
                    {
                        $('#thanaID').html('');

                        $('#thanaID').html(data);
                        $('#thanaID').val('<?php echo $migration_in_info->thanaIDMoveFrom; ?>').trigger('change');

                    }
                });

            }

        }




        $('#divisionID').change(function () {
        
            var divisionID = $('#divisionID').val();
            $('#thanaID').html('<option value="">--- Select Upazila ---</option>');
            $('#thanaID').val('').trigger('change');
            if (divisionID != '')
            {
                $.ajax({
                    url: "<?php echo base_url(); ?>api/getDistrict",
                    method: "POST",
                    data: {divisionID: divisionID},
                    success: function (data)
                    {
                        $('#districtID').html('');
                        $('#districtID').html(data);
                    }
                });
            } else
            {
                $('#districtID').html('<option value="">--- Select District ---</option>');
            }
        });

        $('#districtID').change(function () {
            var districtID = $('#districtID').val();
            if (districtID != '')
            {
                $.ajax({
                    url: "<?php echo base_url(); ?>api/getUpaZila",
                    method: "POST",
                    data: {districtID: districtID},
                    success: function (data)
                    {
                        $('#thanaID').html('');
                        $('#thanaID').html(data);
                        $('#thanaID').val('<?php echo $migration_in_info->thanaIDMoveFrom; ?>').trigger('change');
                    }
                });
            } else
            {
                $('#thanaID').html('<option value="">--- Select Upazila ---</option>');
            }
        });
    });


</script>