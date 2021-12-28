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
                    <a class="btn btn-primary" href="<?php echo base_url() . $controller . '/interview?baseID=' . $baseID ?>"><?php echo $shortName ?> List</a>
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
                        <input type="hidden" name="householdVisitID" value="<?php echo $interview_info->id; ?>">
                        <input type="hidden" name="household_master_id" value="<?php echo $interview_info->household_master_id; ?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <b>Household Code:</b> <?php echo $interview_info->household_code; ?>
                                </div>
                                <div class="col-md-4 form-group">
                                    <b>Round No:</b> <?php echo $interview_info->round_master_id; ?>
                                </div>
                                <div class="col-md-4 form-group">
                                    <!--<b>Member Code:</b> <?php echo $interview_info->member_code; ?>-->
                                </div>
                                <div class="col-md-4 form-group">
                                    <!--<b>Member Name:</b> <?php echo $interview_info->member_name; ?>-->
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <!--<b>Member Sex:</b> <?php echo $interview_info->gender_code . '-' . $interview_info->gender_name; ?>-->
                                </div>
                            </div>
                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border">Interview Information</legend>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="fk_interview_status">Interview status <span style="color:red">*</span></label>
                                        <select class="form-control required" id="fk_interview_status" name="fk_interview_status" required>
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($interview_status)) {
                                                foreach ($interview_status as $interview_status_single) {
                                                    ?>
                                                    <option <?php
                                                    if ($interview_info->fk_interview_status == $interview_status_single->id) {
                                                        echo "selected=selected";
                                                    }
                                                    ?> value="<?php echo $interview_status_single->id ?>"><?php echo $interview_status_single->code . '-' . $interview_status_single->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="fk_interviewer">Interviewer Name <span style="color:red">*</span></label>
                                        <select class="form-control required" id="fk_interviewer" name="fk_interviewer" required>
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($interview_code)) {
                                                foreach ($interview_code as $interview_code_single) {
                                                    ?>
                                                    <option <?php
                                                    if ($interview_info->fk_interviewer == $interview_code_single->id) {
                                                        echo "selected=selected";
                                                    }
                                                    ?> value="<?php echo $interview_code_single->id ?>"><?php echo $interview_code_single->code . '-' . $interview_code_single->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Active">Interview Date <span style="color:red">*</span></label>
                                        <?php
                                        if ($interview_info->interview_date != "") {
                                            $partsRequire = explode('-', $interview_info->interview_date);
                                            $interview_date = $partsRequire[2] . '/' . $partsRequire[1] . '/' . $partsRequire[0];
                                        }
                                        ?>
                                        <input disabled class="form-control" value="<?php if (isset($interview_date)) echo $interview_date; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="respondent_code">Respondent Code <span style="color:red">*</span></label>
                                        <select class="form-control required" id="respondent_code" name="respondent_code" required>
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($presentMemberList)) {
                                                foreach ($presentMemberList as $member) {
                                                    ?>
                                                    <option <?php if ($interview_info->respondent_code == $member->member_code) {
                                                echo 'selected=selected';
                                            } ?> value="<?php echo $member->member_code ?>"><?php echo $member->member_code . '-' . $member->member_name ?></option>
                                                    <?php
                                                }
                                                ?>
                                                <option <?php if ($interview_info->respondent_code == '99') {
                                                echo 'selected=selected';
                                            } ?> value="99">99-Out of Household</option>
                                                <?php
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="fk_responded_type">Respondent Type <span style="color:red">*</span></label>
                                        <select class="form-control required" id="fk_responded_type" name="fk_responded_type" required>
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($respondent_typ)) {
                                                foreach ($respondent_typ as $respondent_typ_single) {
                                                    ?>
                                                    <option <?php
                                                    if ($interview_info->fk_responded_type == $respondent_typ_single->id) {
                                                        echo "selected=selected";
                                                    }
                                                    ?> value="<?php echo $respondent_typ_single->id ?>"><?php echo $respondent_typ_single->code . '-' . $respondent_typ_single->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Active">Contact Number <span style="color:red">*</span></label>
                                        <input name="contactNumber" class="form-control" value="<?php echo $interview_info->contact_number; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Active">Remarks (if any)</label>
                                        <textarea class="form-control" name="remarks"><?php echo $interview_info->remarks; ?></textarea>
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

