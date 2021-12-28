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
                    <a class="btn btn-primary" href="<?php echo base_url() . $controller . '/migration_out?baseID=' . $baseID ?>"><?php echo $shortName ?> List</a>
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
                        <input type="hidden" name="migrationID" value="<?php echo $migration_out_info->id; ?>">
                        <input type="hidden" name="member_master_id" value="<?php echo $migration_out_info->member_master_id; ?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <b>Household Code:</b> <?php echo $migration_out_info->household_code; ?>
                                </div>
                                <div class="col-md-3 form-group">
                                    <b>Round No:</b> <?php echo $migration_out_info->round_master_id; ?>
                                </div>
                                <div class="col-md-3 form-group">
                                    <b>Member Code:</b> <?php echo $migration_out_info->member_code; ?>
                                </div>
                                <div class="col-md-3 form-group">
                                    <b>Member Name:</b> <?php echo $migration_out_info->member_name; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <b>Member sex :</b> <?php echo $migration_out_info->gender_code . '-' . $migration_out_info->gender_name; ?>
                                </div>
                            </div>
                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border">Movement Information</legend>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Active">Movement type <span style="color:red">*</span></label>
                                        <select class="form-control" id="fk_movement_type" name="fk_movement_type" disabled>
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($memberexittyp)) {
                                                foreach ($memberexittyp as $memberexittyp) {
                                                    ?>
                                                    <option <?php
                                                    if ($migration_out_info->fk_movement_type == $memberexittyp->id) {
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
                                        $movement_date=NULL;
                                        if ($migration_out_info->movement_date != "") {
                                            $partsRequire = explode('-', $migration_out_info->movement_date);
                                            $movement_date = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];
                                        }
                                        ?>
                                        <input type="text" class="form-control" data-provide="datepicker-inline" value="<?php echo $movement_date ?>" id="movement_date"  name="movement_date" required>
                                    </div>
                                </div>

                                <div class="col-md-4 migration">
                                    <div class="form-group">
                                        <label for="Active">Type of group <span style="color:red">*</span></label>
                                        <select class="form-control required fk_type_of_group" id="fk_type_of_group" name="fk_type_of_group">
                                            <option value="">Select type of group</option>
                                            <?php
                                            if (!empty($movement_group_typ)) {
                                                foreach ($movement_group_typ as $group_typ) {
                                                    ?>
                                                    <option <?php
                                                    if ($migration_out_info->fk_type_of_group == $group_typ->id) {
                                                        echo "selected=selected";
                                                    }
                                                    ?> value="<?php echo $group_typ->id ?>"><?php echo $group_typ->code . '-' . $group_typ->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 migration">
                                    <div class="form-group">
                                        <label for="Item Name">Cause of outside (individual) <span style="color:red">*</span></label>

                                        <select class="form-control" id="fk_outside_cause_individual"  name="fk_outside_cause_individual">
                                            <option value="0">Select Cause of outside</option>
                                            <?php
                                            if (!empty($outside_cause)) {
                                                foreach ($outside_cause as $outsidecause) {
                                                    ?>
                                                    <option <?php
                                                    if ($migration_out_info->fk_outside_cause_individual == $outsidecause->id) {
                                                        echo "selected=selected";
                                                    }
                                                    ?> value="<?php echo $outsidecause->id ?>"><?php echo $outsidecause->code . '-' . $outsidecause->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 migration">
                                    <div class="form-group">
                                        <label for="Item Name">Cause of outside (Group) <span style="color:red">*</span></label>

                                        <select class="form-control" id="fk_outside_cause_group"  name="fk_outside_cause_group">
                                            <option value="0">Select Cause of outside</option>
                                            <?php
                                            if (!empty($outside_cause)) {
                                                foreach ($outside_cause as $outsidecausegroup) {
                                                    ?>
                                                    <option <?php
                                                    if ($migration_out_info->fk_outside_cause_group == $outsidecausegroup->id) {
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
                                        <label for="Item Name">Country <span style="color:red">*</span></label>

                                        <select class="form-control countryID" id="countryID"  name="countryID">
                                            <option value="0">--- Select Country ---</option>
                                            <?php
                                            if (!empty($countrylist)) {
                                                foreach ($countrylist as $country) {
                                                    ?>
                                                    <option <?php
                                                    if ($migration_out_info->countryIDMoveTo == $country->id) {
                                                        echo "selected=selected";
                                                    }
                                                    ?> value="<?php echo $country->id ?>"><?php echo $country->code . '-' . $country->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 migration country">
                                    <div class="form-group">
                                        <label for="Item Name">Division</label>

                                        <select class="form-control" id="divisionID"  name="divisionID">
                                            <option value="0">--- Select Division ---</option>
                                            <?php
                                            if (!empty($divisionlist)) {
                                                foreach ($divisionlist as $division) {
                                                    ?>
                                                    <option <?php
                                                    if ($migration_out_info->divisionIDMoveTo == $division->id) {
                                                        echo "selected=selected";
                                                    }
                                                    ?>  value="<?php echo $division->id ?>"><?php echo $division->code . '-' . $division->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 migration country">
                                    <div class="form-group">
                                        <label for="Item Name">District</label>

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
                                        <label for="Item Name">Upazila</label>

                                        <select  class="form-control required" id="thanaID2" name="thanaID">
                                            <option value="0">--- Select Upazila ---</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="email">Remarks (if any)</span></label>

                                        <textarea  class="form-control" name="remarks"><?php echo $migration_out_info->remarks; ?></textarea>

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

        $('#divisionID').change(function () {
            var divisionID = $('#divisionID').val();
            if (divisionID != '')
            {
                $.ajax({
                    url: "<?php echo base_url(); ?>api/getDistrict",
                    method: "POST",
                    data: {divisionID: divisionID},
                    success: function (data)
                    {
                        $('#districtID').html('');
                        $('#thanaID2').html('<option value="">--- Select Upazila ---</option>');
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
                        $('#thanaID2').html('');
                        $('#thanaID2').html(data);
                        $('#thanaID2').val('<?php echo $migration_out_info->thanaIDMoveTo; ?>').trigger('change');
                    }
                });
            } else
            {
                $('#thanaID2').html('<option value="">--- Select Upazila ---</option>');
            }
        });

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
                        $('#districtID').val('<?php echo $migration_out_info->districtIDMoveTo; ?>').trigger('change');

                    }
                });

            }

        }


        var seldistrictID = <?php echo $migration_out_info->districtIDMoveTo; ?>;
        if (seldistrictID > 0)
        {
            var districtID = seldistrictID;
            if (seldistrictID != '')
            {
                $.ajax({
                    url: "<?php echo base_url(); ?>api/getUpaZila",
                    method: "POST",
                    data: {districtID: seldistrictID},
                    success: function (data)
                    {
                        $('#thanaID2').html('');

                        $('#thanaID2').html(data);
                        $('#thanaID2').val('<?php echo $migration_out_info->thanaIDMoveTo; ?>').trigger('change');
                    }
                });

            }

        }

    });


</script>