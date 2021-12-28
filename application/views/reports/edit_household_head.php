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
                    <a class="btn btn-primary" href="<?php echo base_url() . $controller . '/household_head?baseID=' . $baseID ?>"><?php echo $shortName ?> List</a>
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
                        <input type="hidden" name="household_head_id" value="<?php echo $household_head_info->id; ?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <b>Household Code:</b> <?php echo $household_head_info->household_code; ?>
                                </div>
                                <div class="col-md-3 form-group">
                                    <b>Round No:</b> <?php echo $household_head_info->round_master_id; ?>
                                </div>
                                <div class="col-md-3 form-group">
                                    <b>Member Code:</b> <?php echo $household_head_info->member_code; ?>
                                </div>
                                <div class="col-md-3 form-group">
                                    <b>Member Name:</b> <?php echo $household_head_info->member_name; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <b>Member Sex:</b> <?php echo $household_head_info->gender_code . '-' . $household_head_info->gender_name; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="Active">Relation with HHH <span style="color:red">*</span></label>
                                    <select class="form-control" disabled>
                                        <option value="">self</option>
                                    </select>
                                </div>

                                <div <?php if ($household_head_info->fk_relation != 27) echo " style='display:none;'"; ?> class="col-md-6 form-group">
                                    <label for="Active">Cause of head change <span style="color:red">*</span></label>
                                    <select class="form-control fk_hhh_cause" id="fk_hhh_cause" name="fk_hhh_cause" <?php if ($household_head_info->fk_relation == 27) echo " required"; ?>>
                                        <option value="">Please Select</option>
                                        <?php
                                        if (!empty($hh_change_reason)) {
                                            foreach ($hh_change_reason as $hh_change) {
                                                ?>
                                                <option <?php
                                                if (isset($household_head_info->fk_hhh_cause) && $household_head_info->fk_hhh_cause == $hh_change->id) {
                                                    echo "selected=selected";
                                                }
                                                ?> value="<?php echo $hh_change->id ?>"><?php echo $hh_change->code . '-' . $hh_change->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>

                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div <?php if ($household_head_info->fk_relation != 27) echo " style='display:none;'"; ?> class="col-md-6 form-group">
                                    <?php
                                    if (isset($household_head_info->change_date) && $household_head_info->change_date != "") {
                                        $partsRequire = explode('-', $household_head_info->change_date);
                                        $hhdate = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];
                                    }
                                    ?>
                                    <label for="Item Name">Effective date (If HHH) <span style="color:red">*</span></label>
                                    <input value="<?php if (isset($hhdate)) echo $hhdate; ?>" type="text" class="form-control hhdate" id="hhdate"  name="hhdate" <?php if ($household_head_info->fk_relation == 27) echo " required"; ?>>
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


        $('#hhdate').datepicker({
            autoclose: true,
            format: 'dd/mm/yyyy'
        });

    });

</script>

