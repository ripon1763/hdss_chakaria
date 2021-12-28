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
                    <a class="btn btn-primary" href="<?php echo base_url() . $controller . '/household_master?baseID=' . $baseID ?>"><?php echo $shortName ?> List</a>
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
                    <?php if ($household_master_info->round_master_id_extinct_round > 0) : ?>

                        <p style="padding-left: 10px; color:red">This household is already extincted. You cannot change anything !!</p>

                    <?php endif; ?>
                    <form role="form" action="<?php echo base_url() . $controller . '/' . $actionMethod . '?baseID=' . $baseID ?>" method="post" id="editUser" role="form">
                        <input type="hidden" name="id" value="<?php echo $household_master_info->id; ?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <b>Household Code:</b> <?php echo $household_master_info->household_code; ?>
                                </div>
                                <div class="col-md-4 form-group">
                                    <b>Round No:</b> <?php echo $household_master_info->round_master_id_entry_round; ?>
                                </div>
                                <div class="col-md-4 form-group">
                                    <b>Member Code:</b> <?php echo $household_master_info->member_code; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <b>Member Name:</b> <?php echo $household_master_info->member_name; ?>
                                </div>
                                <div class="col-md-4 form-group">
                                    <b>Member Sex:</b> <?php echo $household_master_info->gender_code . '-' . $household_master_info->gender_name; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">District <span style="color:red">*</span></label>
                                        <select class="form-control" id="districtID"  name="districtID" disabled>
                                            <option value="">--- Select District ---</option>
                                            <?php
                                            if (!empty($district)) {
                                                foreach ($district as $district) {
                                                    ?>
                                                    <option <?php
                                                    if ($district->id == $household_master_info->fk_district_id) {
                                                        echo "selected=selected";
                                                    }
                                                    ?> value="<?php echo $district->id ?>"><?php echo $district->code . '-' . $district->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Upazila <span style="color:red">*</span></label>

                                        <select  class="form-control required" id="thanaID" name="thanaID" disabled>
                                            <option value="">--- Select Upazila ---</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Slum <span style="color:red">*</span></label>

                                        <select class="form-control required" id="slumID" name="slumID" disabled>
                                            <option value="">--- Select Slum ---</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Slum Area <span style="color:red">*</span></label>

                                        <select class="form-control required" id="slumAreaID" name="slumAreaID" disabled>
                                            <option value="">--- Select Slum Area ---</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Name of Bariwala <span style="color:red">*</span></label>
                                        <input type="text" class="form-control required" id="bariwallaName"  name="bariwallaName" value="<?php echo $household_master_info->bariwalla_name ?>" maxlength="255" required="required">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Bari Number <span style="color:red">*</span></label>
                                        <input type="text" class="form-control required" id="bariNumber"  name="bariNumber" value="<?php echo $household_master_info->barino ?>" minlength="5" maxlength="10" size="10" required="required">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Name of Household head <span style="color:red">*</span></label>
                                        <input type="text" value="<?php echo $household_master_info->household_head_name ?>" class="form-control required" id="headName"  name="headName" maxlength="255" required="required">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">How long living here (Year)</label>
                                        <input type="text" class="form-control required" id="livingYear"  name="livingYear" value="<?php echo $household_master_info->longlivy ?>" minlength="1" maxlength="2" size="10" required="required">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">How long living here (Month)</label>
                                        <input type="text" class="form-control required" id="livingMonth"  name="livingMonth" value="<?php echo $household_master_info->longlivm ?>" minlength="1" maxlength="2" size="10" required="required">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">How long ago left to slum</label>
                                        <input type="text" class="form-control required" id="leftSlum"  name="leftSlum" minlength="1" value="<?php echo $household_master_info->leftpad ?>" maxlength="2" size="10" required="required">
                                    </div>
                                </div>



                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Active">Entry type <span style="color:red">*</span></label>
                                        <select class="form-control required" id="entryType" name="entryType" required>
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($entryType)) {
                                                foreach ($entryType as $entryType_single) {
                                                    ?>
                                                    <option <?php
                                                    if ($entryType_single->id == $household_master_info->fk_entry_type) {
                                                        echo "selected=selected";
                                                    }
                                                    ?> value="<?php echo $entryType_single->id ?>"><?php echo $entryType_single->code . '-' . $entryType_single->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Entry Date <span style="color:red">*</span></label>

                                        <?php
                                        if ($household_master_info->entry_date != "") {
                                            $partsRequire = explode('-', $household_master_info->entry_date);
                                            $entry_date = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];
                                        }
                                        ?>
                                        <input type="text" value="<?php if (isset($entry_date)) echo $entry_date ?>" class="form-control required" id="datepicker"  name="entryDate" maxlength="255" required="required">
                                    </div>
                                </div> 
                                <div class="col-md-3 migration" >
                                    <div class="form-group">
                                        <label for="Active">Migration reason</label>
                                        <select class="form-control required migrationReason" id="migrationReason" name="migrationReason">
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($migrationReason)) {
                                                foreach ($migrationReason as $mig) {
                                                    ?>
                                                    <option <?php
                                                    if ($mig->id == $household_master_info->fk_migration_reason) {
                                                        echo "selected=selected";
                                                    }
                                                    ?>   value="<?php echo $mig->id ?>"><?php echo $mig->code . '-' . $mig->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                        </select>
                                    </div>
                                </div>  
                                <div class="col-md-3 migration">
                                    <div class="form-group">
                                        <label for="Active">Migrated from country</label>
                                        <select class="form-control required" id="countryID" name="countryID">
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($country)) {
                                                foreach ($country as $country) {
                                                    ?>
                                                    <option <?php
                                                    if ($country->id == $household_master_info->fk_country_id_from) {
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
                                <div class="col-md-3 migration">
                                    <div class="form-group">
                                        <label for="Active">Migrated from district</label>
                                        <select class="form-control required" id="migDistrictID" name="migDistrictID" >
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($district2)) {
                                                foreach ($district2 as $dist) {
                                                    ?>
                                                    <option <?php
                                                    if ($dist->id == $household_master_info->fk_district_id_from) {
                                                        echo "selected=selected";
                                                    }
                                                    ?> value="<?php echo $dist->id ?>"><?php echo $dist->code . '-' . $dist->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 migration">
                                    <div class="form-group">
                                        <label for="Active">Migrated from upazila</label>

                                        <select  class="form-control required" id="migThanaID" name="migThanaID">
                                            <option value="">Please Select</option>
                                        </select>

                                    </div>
                                </div>

                                <div class="col-md-12 migrationOth">
                                    <div class="form-group">
                                        <label for="Item Name">Migration reason (Others)</label>
                                        <input type="text" value="<?php echo $household_master_info->migration_reason_oth ?>"  class="form-control migreasonOth" id="migreasonOth"  name="migreasonOth" maxlength="255">
                                    </div>
                                </div>

                                <div class="col-md-3 internal">
                                    <div class="form-group">
                                        <label for="Item Name">Slum From </label>

                                        <select class="form-control required" id="slumIDFrom" name="slumIDFrom">
                                            <option value="">--- Select Slum ---</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3 internal">
                                    <div class="form-group">
                                        <label for="Item Name">Slum Area From</label>

                                        <select class="form-control required" id="slumAreaIDFrom" name="slumAreaIDFrom">
                                            <option value="">--- Select Slum Area ---</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Household Code</label>
                                        <input type="text" class="form-control required" id="household_code1"  name="household_code1" value="<?php echo $household_master_info->household_code ?>" disabled="disabled">
                                        <input type="hidden" class="form-control required" id="household_code"  name="household_code" value="<?php echo $household_master_info->household_code ?>">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Contact no <span style="color:red">*</span></label>
                                        <input type="text" class="form-control required" id="contactNumber" value="<?php echo $household_master_info->contact_number ?>"  name="contactNumber" maxlength="255" required="required">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Active">Contact source type <span style="color:red">*</span></label>
                                        <select class="form-control required" id="contactSource" name="contactSource" required>
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($hhcontacttyp)) {
                                                foreach ($hhcontacttyp as $contact) {
                                                    ?>
                                                    <option <?php
                                                    if ($contact->id == $household_master_info->fk_contract_type) {
                                                        echo "selected=selected";
                                                    }
                                                    ?>  value="<?php echo $contact->id ?>"><?php echo $contact->code . '-' . $contact->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if ($household_master_info->round_master_id_extinct_round == 0) : ?>
                            <div class="box-footer">
                                <input type="submit" class="btn btn-primary" value="Update"> <input name="update_exit" type="submit" class="btn btn-primary" value="Update & Exit">
                            </div>
                        <?php endif; ?>
                    </form>
                </div>

            </div>
        </div>
    </section>
</div>

<script type="text/javascript">


    $(document).ready(function () {

        $("#entryType").change(function () {
            $(this).find("option:selected").each(function () {
                var optionValue = $(this).attr("value");

                if (optionValue == 14)
                {
                    $(".migrationReason").prop('required', false);
                    $(".migreasonOth").prop('required', false);
                    $(".migration").hide();
                    $(".migrationOth").hide();
                    $(".internal").hide();

                } else if (optionValue == 15)
                {
                    $(".migrationReason").prop('required', true);
                    $(".migreasonOth").prop('required', false);
                    $(".migration").show();
                    $(".internal").hide();

                } else {

                    $(".migrationReason").prop('required', false);
                    $(".migreasonOth").prop('required', false);
                    $(".migration").show();
                    $(".internal").show();
                }




            });
        }).change();

        $("#migrationReason").change(function () {
            $(this).find("option:selected").each(function () {
                var optionValue = $(this).attr("value");

                if (optionValue == 12)
                {
                    // $(".migrationReason").prop('required',fals 
                    $(".migreasonOth").prop('required', true);
                    $(".migrationOth").show();

                } else {

                    $(".migreasonOth").prop('required', false);
                    $(".migrationOth").hide();
                }
            });
        }).change();

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
                        //$('#city').html('<option value="">Select City</option>');
                    }
                });
            } else
            {
                $('#thanaID').html('<option value="">--- Select Upazila ---</option>');
                $('#slumID').html('<option value="">--- Select Slum ---</option>');
            }
        });


        $('#thanaID').change(function () {
            var thanaID = $('#thanaID').val();
            if (thanaID != '')
            {
                $.ajax({
                    url: "<?php echo base_url(); ?>api/getSlum",
                    method: "POST",
                    data: {thanaID: thanaID},
                    success: function (data)
                    {
                        $('#slumID').html('');
                        $('#slumID').html(data);

                        $('#slumID').val('<?php echo $household_master_info->fk_slum_id; ?>').trigger('change');
                    }
                });
            } else
            {
                $('#slumID').html('<option value="">--- Select Slum ---</option>');
                //$('#city').html('<option value="">Select City</option>');
            }
        });


        $('#slumID').change(function () {
            var slumID = $('#slumID').val();
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

                        $('#slumAreaID').val('<?php echo $household_master_info->fk_slum_area_id; ?>').trigger('change');
                    }
                });
            } else
            {
                $('#slumAreaID').html('<option value="">--- Select Slum Area ---</option>');
                //$('#city').html('<option value="">Select City</option>');
            }
        });


        $('#migDistrictID').change(function () {
            $('#slumAreaIDFrom').html('<option value="">--- Select Slum Area ---</option>');
            $('#slumIDFrom').html('<option value="">--- Select Slum ---</option>');
            var migDistrictID = $('#migDistrictID').val();
            if (migDistrictID != '')
            {
                $.ajax({
                    url: "<?php echo base_url(); ?>api/getMigUpaZila",
                    method: "POST",
                    data: {migDistrictID: migDistrictID},
                    success: function (data)
                    {
                        $('#migThanaID').html('');
                        $('#migThanaID').html(data);
                        //$('#city').html('<option value="">Select City</option>');
                    }
                });
            } else
            {
                $('#migThanaID').html('<option value="">Please Select</option>');
            }
        });



        $("#livingYear").keydown(function (event) {
            // Allow only backspace and delete
            if (event.keyCode == 46 || event.keyCode == 8) {
            } else {
                // Ensure that it is a number and stop the keypress
                if (event.keyCode < 48 || event.keyCode > 57) {
                    event.preventDefault();
                }
            }
        });

        $("#livingMonth").keydown(function (event) {
            // Allow only backspace and delete
            if (event.keyCode == 46 || event.keyCode == 8) {
            } else {
                // Ensure that it is a number and stop the keypress
                if (event.keyCode < 48 || event.keyCode > 57) {
                    event.preventDefault();
                }
            }
        });

        $("#leftSlum").keydown(function (event) {
            // Allow only backspace and delete
            if (event.keyCode == 46 || event.keyCode == 8) {
            } else {
                // Ensure that it is a number and stop the keypress
                if (event.keyCode < 48 || event.keyCode > 57) {
                    event.preventDefault();
                }
            }
        });




        var seldistrictId = $('#districtID').val();
        if (seldistrictId > 0)
        {

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
                        $('#thanaID').val('<?php echo $household_master_info->fk_thana_id; ?>').trigger('change');
                    }
                });

            }

        }

        var selThanaId = '<?php echo $household_master_info->fk_thana_id; ?>';

        if (selThanaId > 0)
        {

            var thanaID = selThanaId;
            if (thanaID != '')
            {
                $.ajax({
                    url: "<?php echo base_url(); ?>api/getSlum",
                    method: "POST",
                    data: {thanaID: thanaID},
                    success: function (data)
                    {
                        $('#slumID').html('');

                        $('#slumID').html(data);
                        $('#slumID').val('<?php echo $household_master_info->fk_slum_id; ?>').trigger('change');
                    }
                });

            }

        }

        var selSlumId = '<?php echo $household_master_info->fk_slum_id; ?>';

        if (selSlumId > 0)
        {

            var slumID = selSlumId;
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
                        $('#slumAreaID').val('<?php echo $household_master_info->fk_slum_area_id; ?>').trigger('change');
                    }
                });

            }

        }



        var migDistrictID = $('#migDistrictID').val();
        if (migDistrictID > 0)
        {

            var migDistrictID = $('#migDistrictID').val();
            if (migDistrictID != '')
            {
                $.ajax({
                    url: "<?php echo base_url(); ?>api/getMigUpaZila",
                    method: "POST",
                    data: {migDistrictID: migDistrictID},
                    success: function (data)
                    {
                        $('#migThanaID').html('');

                        $('#migThanaID').html(data);
                        $('#migThanaID').val('<?php echo $household_master_info->fk_thana_id_from; ?>').trigger('change');
                    }
                });

            }

        }


        $('#migThanaID').change(function () {
            var thanaID = $('#migThanaID').val();
            if (thanaID != '')
            {
                $.ajax({
                    url: "<?php echo base_url(); ?>api/getSlum",
                    method: "POST",
                    data: {thanaID: thanaID},
                    success: function (data)
                    {
                        $('#slumIDFrom').html('');
                        $('#slumIDFrom').html(data);
                        $('#slumIDFrom').val('<?php echo $household_master_info->fk_slum_id_from; ?>').trigger('change');

                    }
                });
            } else
            {
                $('#slumIDFrom').html('<option value="">--- Select Slum ---</option>');

            }
        });

        $('#slumIDFrom').change(function () {
            var slumID = $('#slumIDFrom').val();
            if (slumID != '')
            {
                $.ajax({
                    url: "<?php echo base_url(); ?>api/getSlumArea",
                    method: "POST",
                    data: {slumID: slumID},
                    success: function (data)
                    {
                        $('#slumAreaIDFrom').html('');
                        $('#slumAreaIDFrom').html(data);
                        $('#slumAreaIDFrom').val('<?php echo $household_master_info->fk_slumArea_id_from; ?>').trigger('change');

                    }
                });
            } else
            {
                $('#slumAreaIDFrom').html('<option value="">--- Select Slum Area ---</option>');
            }
        });



    });


</script>

