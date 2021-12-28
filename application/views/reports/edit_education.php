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
                    <a class="btn btn-primary" href="<?php echo base_url() . $controller . '/education?baseID=' . $baseID ?>"><?php echo $shortName ?> List</a>
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
                        <input type="hidden" name="educationID" value="<?php echo $education_info->id; ?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <b>Household Code:</b> <?php echo $education_info->household_code; ?>
                                </div>
                                <div class="col-md-3 form-group">
                                    <b>Round No:</b> <?php echo $education_info->round_master_id; ?>
                                </div>
                                <div class="col-md-3 form-group">
                                    <b>Member Code:</b> <?php echo $education_info->member_code; ?>
                                </div>
                                <div class="col-md-3 form-group">
                                    <b>Member Name:</b> <?php echo $education_info->member_name; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <b>Gender:</b> <?php echo $education_info->gender_code.'-'.$education_info->gender_name; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="Active">Type of education <span style="color:red">*</span></label>
                                    <select class="form-control required" id="educationType" name="educationType" required>
                                        <option value="">Please Select</option>
                                        <?php
                                        if (!empty($educationtyp)) {
                                            foreach ($educationtyp as $educationtyp_single) {
                                                ?>
                                                <option <?php
                                                if ($education_info->fk_education_type == $educationtyp_single->id) {
                                                    echo "selected=selected";
                                                }
                                                ?> value="<?php echo $educationtyp_single->id ?>"><?php echo $educationtyp_single->code . '-' . $educationtyp_single->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>

                                    </select>
                                </div>

                                <div <?php if ($education_info->fk_education_type ==45) echo " style='display:none;'"; ?> class="col-md-6 form-group year_of_education_part">
                                    <label for="Item Name">Year of Education <span style="color:red">*</span></label>
                                    <input type="text" value="<?php if($education_info->year_of_education>0) echo $education_info->year_of_education ?>" class="form-control yearOfEdu" id="yearOfEdu"  name="yearOfEdu">
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
        $("#educationType").change(function () {
            $(this).find("option:selected").each(function () {
                var optionValue = $(this).attr("value");
                if (optionValue == 45)
                {
                    $("#yearOfEdu").prop('required', false);
                    $("#yearOfEdu").attr('disabled', true);
                    $(".year_of_education_part").hide();

                } else {
                    $("#yearOfEdu").prop('required', true);
                    $("#yearOfEdu").attr('disabled', false);
                    $(".year_of_education_part").show();
                }
            });
        })

    });

</script>

