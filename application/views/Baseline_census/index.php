
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
            <div class="col-xs-12 text-left header-margin ">
                <h3>
                    <?php echo $pageTitle; ?>

                    <?php $baseID = $this->input->get('baseID', TRUE); ?>
                </h3>

            </div>

        </div>
    </section>
    <section class="content margin_need">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary" style="min-height: 480px">
                    <div class="box-header">
                        <h3 class="box-title"><?php // echo $shortName.' '.$boxTitle     ?></h3>

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
                    </div><!-- /.box-header -->

                    <form id="form_search" action="<?php echo base_url() . 'Baseline_census?baseID=' . $baseID ?>" method="post">
                        <div class="row" style="margin-bottom:20px; margin-left: 0px">

                            <div class="col-md-2 no-print">
                                <div class="input-group">
                                    <label for="Item Name">Slum Name<span style="color:red">*</span></label>

                                    <select class="form-control required" id="slumID" name="slum_id" required>
                                        <option value="">--- Select Slum Name---</option>
                                        <?php
                                        if (!empty($Slum)) {
                                            foreach ($Slum as $slum) {
                                                ?>
                                                <option <?php
                                                if ($slumid_visit == $slum->id) {
                                                    echo "selected=selected";
                                                }
                                                ?>  value="<?php echo $slum->id ?>"><?php echo $slum->code . '-' . $slum->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 no-print">
                                <div class="input-group">
                                    <label for="Item Name">Slum Area <span style="color:red">*</span></label>

                                    <select class="form-control required" id="slumAreaID" name="slumarea_id" required>
                                        <option value="">--- Select Slum Area ---</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 no-print">
                                <div class="input-group">
                                    <label for="Item Name">Bari Number <span style="color:red">*</span></label>

                                    <select class="form-control required" id="barinumber" name="barinumber" required>
                                        <option value="">--- Select Bari Number ---</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 no-print">
                                <div class="form-group">
                                    <label for="Item Name">Household Code <span style="color:red">*</span></label>

                                    <select class="form-control required" id="househodID" name="household_id" required>
                                        <option value="">--- Select Household ---</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 no-print">
                                <button title="Search" type="submit" class="btn btn-sm btn-default pull-left" name="search" value="search" style="margin-top:25px"><i class="fa fa-search"> </i></button>
                                &nbsp;<button title="Clear" type="submit" class="btn btn-sm btn-default pull-left" name="Clear" value="Clear" style="margin-top:25px; margin-left:5px"><i class="fa fa-eraser"> </i></button>

                            </div>
                        </div>
                    </form>


                    <div class="box-body">


                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
    $(document).ready(function () {

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
                        $('#slumAreaID').val('<?php echo $slumareaid_visit; ?>').trigger('change');
                    }
                });
            } else
            {
                $('#slumAreaID').html('<option value="">--- Select Slum Area ---</option>');
            }
        });

        $('#slumAreaID').change(function () {
            var slumAreaID = $('#slumAreaID').val();
            if (slumAreaID != '')
            {
                $.ajax({
                    url: "<?php echo base_url(); ?>api/getBariNumber",
                    method: "POST",
                    data: {slumAreaID: slumAreaID},
                    success: function (data)
                    {
                        $('#barinumber').html('');
                        $('#barinumber').html(data);

                        $('#barinumber').val('<?php echo $barinumber_visit; ?>').trigger('change');
                    }
                });
            } else
            {
                $('#barinumber').html('<option value="">--- Select Bari Number ---</option>');
            }
        });


        $('#barinumber').change(function () {
            var barinumber = $('#barinumber').val();
            var slumAreaID = $('#slumAreaID').val();
            if (barinumber != '')
            {
                $.ajax({
                    url: "<?php echo base_url(); ?>api/getHouseHoldBari",
                    method: "POST",
                    data: {barinumber: barinumber, slumAreaID: slumAreaID},
                    success: function (data)
                    {
                        $('#househodID').html('');
                        $('#househodID').html(data);

                        console.log(data);

                    }
                });
            } else
            {
                $('#househodID').html('<option value="">--- Select Household ---</option>');
            }
        });



        var selSlumId = '<?php echo $slumid_visit; ?>';

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
                        $('#slumAreaID').val('<?php echo $slumareaid_visit; ?>').trigger('change');
                    }
                });

            }

        }



        $('#title').autocomplete(
                {
                    source: "<?php echo site_url('api/get_autocomplete'); ?>",
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