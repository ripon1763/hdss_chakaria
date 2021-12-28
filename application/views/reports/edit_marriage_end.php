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
                    <a class="btn btn-primary" href="<?php echo base_url() . $controller . '/marriage_end?baseID=' . $baseID ?>"><?php echo $shortName ?> List</a>
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
                        <input type="hidden" name="marriageID" value="<?php echo $marriage_end_info->id; ?>">
                        <input type="hidden" name="member_master_id" value="<?php echo $marriage_end_info->member_master_id; ?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <b>Household Code:</b> <?php echo $marriage_end_info->household_code; ?>
                                </div>
                                <div class="col-md-3 form-group">
                                    <b>Round No:</b> <?php echo $marriage_end_info->round_master_id; ?>
                                </div>
                                <div class="col-md-3 form-group">
                                    <b>Member Code:</b> <?php echo $marriage_end_info->member_code; ?>
                                </div>
                                <div class="col-md-3 form-group">
                                    <b>Member Name:</b> <?php echo $marriage_end_info->member_name; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <b>Member Sex:</b> <?php echo $marriage_end_info->gender_code . '-' . $marriage_end_info->gender_name; ?>
                                </div>
                            </div>
                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border"><?php
                                    if ($marriage_end_info->gender_code == 1) {
                                        echo "Bride ";
                                    } else {
                                        echo "Groom ";
                                    }
                                    ?>details</legend>




                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Active"><?php
                                            if ($marriage_end_info->gender_code == 1) {
                                                echo "Bride ";
                                            } else {
                                                echo "Groom ";
                                            }
                                            ?>Member code (blank if not DSS member) </label>
                                        <input type="hidden" name="fk_spouse_id" class="form-control" id="fk_spouse_id" value="<?php echo $marriage_end_info->member_master_id_bride_groom ?>" >
                                        <input type="text" name="spouse_code" class="form-control" id="spouse_code" value="<?php echo $marriage_end_info->spouseCode . ' - ' . $marriage_end_info->spouseName ?>" disabled>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border">Marriage Information</legend>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Active">Marriage end type <span style="color:red">*</span></label>
                                        <select class="form-control required" id="fk_marriage_end_type" name="fk_marriage_end_type" required>
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($marriage_end_typ)) {
                                                foreach ($marriage_end_typ as $marriageendtyp) {
                                                    ?>
                                                    <option <?php
                                                    if ($marriage_end_info->fk_marriage_end_type == $marriageendtyp->id) {
                                                        echo "selected=selected";
                                                    }
                                                    ?> value="<?php echo $marriageendtyp->id ?>"><?php echo $marriageendtyp->code . '-' . $marriageendtyp->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Item Name">Marriage end date <span style="color:red">*</span></label>
                                        <?php
                                        if ($marriage_end_info->marriage_end_date != "") {
                                            $partsRequire = explode('-', $marriage_end_info->marriage_end_date);
                                            $marriage_end_date = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];
                                        }
                                        ?>
                                        <input type="text" class="form-control" data-provide="datepicker-inline" id="marriage_end_date"  name="marriage_end_date" value="<?php echo $marriage_end_date ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Active">Marriage end cause - 1 </label>
                                        <select class="form-control required" id="fk_marriage_end_cause_one" name="fk_marriage_end_cause_one">
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($marriage_end_cause)) {
                                                foreach ($marriage_end_cause as $marriageendcause) {
                                                    ?>
                                                    <option <?php
                                                    if ($marriage_end_info->fk_marriage_end_cause_one == $marriageendcause->id) {
                                                        echo "selected=selected";
                                                    }
                                                    ?> value="<?php echo $marriageendcause->id ?>"><?php echo $marriageendcause->code . '-' . $marriageendcause->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Active">Marriage end cause - 2 </label>
                                        <select class="form-control required" id="fk_marriage_end_cause_two" name="fk_marriage_end_cause_two">
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($marriage_end_cause)) {
                                                foreach ($marriage_end_cause as $marriageendcause2) {
                                                    ?>
                                                    <option <?php
                                                    if ($marriage_end_info->fk_marriage_end_cause_two == $marriageendcause2->id) {
                                                        echo "selected=selected";
                                                    }
                                                    ?> value="<?php echo $marriageendcause2->id ?>"><?php echo $marriageendcause2->code . '-' . $marriageendcause2->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Active">Marriage end cause - 3 </label>
                                        <select class="form-control required" id="fk_marriage_end_cause_three" name="fk_marriage_end_cause_three">
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($marriage_end_cause)) {
                                                foreach ($marriage_end_cause as $marriageendcaus3) {
                                                    ?>
                                                    <option <?php
                                                    if ($marriage_end_info->fk_marriage_end_cause_three == $marriageendcaus3->id) {
                                                        echo "selected=selected";
                                                    }
                                                    ?> value="<?php echo $marriageendcaus3->id ?>"><?php echo $marriageendcaus3->code . '-' . $marriageendcaus3->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="email">Remarks (if any)</span></label>

                                        <textarea  class="form-control" name="remarks"><?php echo $marriage_end_info->remarks ?></textarea>

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
        $('#bride_groom_ID_full').hide();
        $('#reset').show();
        $('#bride_groom_ID').autocomplete(
                {
                    source: "<?php echo site_url('api/get_autocomplete_member'); ?>",
                    minLength: 1,

                    select: function (event, ui)
                    {
                        //$(this).val(ui.item.member);
                        $('#householdid').val(ui.item.value);
                        $('#householdcode').val(ui.item.house);

                        $('#bride_groom_ID').hide();
                        $('#bride_groom_ID_full').show();
                        $('#reset').show();
                        $('#bride_groom_ID_full').val(ui.item.label);
                    }
                });

        $('#reset').on('click', function (e) {
            e.preventDefault();
            $('#bride_groom_ID').show();
            $('#bride_groom_ID').val('');
            $('#householdid').val('');
            $('#householdcode').val('');
            $('#bride_groom_ID_full').val('');
            $('#bride_groom_ID_full').hide();
            $('#reset').hide();
        });

    });


</script>

