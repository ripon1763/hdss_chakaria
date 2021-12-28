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
                    <a class="btn btn-primary" href="<?php echo base_url() . $controller . '/asset?baseID=' . $baseID ?>"><?php echo $shortName ?> List</a>
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
                        <input type="hidden" name="assetID" value="<?php echo $asset_info->id; ?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <b>Household Code:</b> <?php echo $asset_info->household_code; ?>
                                </div>
                                <div class="col-md-3 form-group">
                                    <b>Round No:</b> <?php echo $asset_info->round_master_id; ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="email">Owner of land <span style="color:red">*</span></label>

                                        <select name="fk_owner_land" id="fk_owner_land" class="form-control" required style="">
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($land_owner)) {
                                                foreach ($land_owner as $land) {
                                                    ?>
                                                    <option <?php if ($land->id == $asset_info->fk_owner_land) {
                                                echo "selected=selected";
                                            } ?> value="<?php echo $land->id ?>"><?php echo $land->name ?></option>

                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="email">Owner of House <span style="color:red">*</span></label>

                                        <select name="fk_owner_house" id="fk_owner_house" class="form-control" required style="">
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($house_owner)) {
                                                foreach ($house_owner as $house) {
                                                    ?>
                                                    <option <?php if ($house->id == $asset_info->fk_owner_house) {
                                                echo "selected=selected";
                                            } ?> value="<?php echo $house->id ?>"><?php echo $house->name ?></option>

                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="email">Chair <span style="color:red">*</span></label>

                                        <select name="fk_chair" id="fk_chair" class="form-control" required style="">
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($assetYesNo)) {
                                                foreach ($assetYesNo as $chair) {
                                                    ?>
                                                    <option <?php if ($chair->id == $asset_info->fk_chair) {
                                                echo "selected=selected";
                                            } ?> value="<?php echo $chair->id ?>"><?php echo $chair->name ?></option>

                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="email">Dining Table <span style="color:red">*</span></label>

                                        <select name="fk_dining_table" id="fk_dining_table" class="form-control" required style="">
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($assetYesNo)) {
                                                foreach ($assetYesNo as $table) {
                                                    ?>
                                                    <option <?php if ($table->id == $asset_info->fk_dining_table) {
                                                echo "selected=selected";
                                            } ?> value="<?php echo $table->id ?>"><?php echo $table->name ?></option>

                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="email">Khat <span style="color:red">*</span></label>

                                        <select name="fk_khat" id="fk_khat" class="form-control" required style="">
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($assetYesNo)) {
                                                foreach ($assetYesNo as $khat) {
                                                    ?>
                                                    <option <?php if ($khat->id == $asset_info->fk_khat) {
                                                echo "selected=selected";
                                            } ?> value="<?php echo $khat->id ?>"><?php echo $khat->name ?></option>

                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="email">Chowki <span style="color:red">*</span></label>

                                        <select name="fk_chowki" id="fk_chowki" class="form-control" required style="">
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($assetYesNo)) {
                                                foreach ($assetYesNo as $chowki) {
                                                    ?>
                                                    <option <?php if ($chowki->id == $asset_info->fk_chowki) {
                                                echo "selected=selected";
                                            } ?> value="<?php echo $chowki->id ?>"><?php echo $chowki->name ?></option>

                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="email">Almirah <span style="color:red">*</span></label>

                                        <select name="fk_almirah" id="fk_almirah" class="form-control" required style="">
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($assetYesNo)) {
                                                foreach ($assetYesNo as $almirah) {
                                                    ?>
                                                    <option <?php if ($almirah->id == $asset_info->fk_almirah) {
                                                echo "selected=selected";
                                            } ?> value="<?php echo $almirah->id ?>"><?php echo $almirah->name ?></option>

                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="email">Sofa <span style="color:red">*</span></label>

                                        <select name="fk_sofa" id="fk_sofa" class="form-control" required style="">
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($assetYesNo)) {
                                                foreach ($assetYesNo as $sofa) {
                                                    ?>
                                                    <option <?php if ($sofa->id == $asset_info->fk_sofa) {
                                                echo "selected=selected";
                                            } ?> value="<?php echo $sofa->id ?>"><?php echo $sofa->name ?></option>

                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="email">Radio <span style="color:red">*</span></label>

                                        <select name="fk_radio" id="fk_radio" class="form-control" required style="">
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($assetYesNo)) {
                                                foreach ($assetYesNo as $radio) {
                                                    ?>
                                                    <option <?php if ($radio->id == $asset_info->fk_radio) {
                                                echo "selected=selected";
                                            } ?> value="<?php echo $radio->id ?>"><?php echo $radio->name ?></option>

                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="email">TV <span style="color:red">*</span></label>

                                        <select name="fk_tv" id="fk_tv" class="form-control" required style="">
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($assetYesNo)) {
                                                foreach ($assetYesNo as $tv) {
                                                    ?>
                                                    <option <?php if ($tv->id == $asset_info->fk_tv) {
                                                echo "selected=selected";
                                            } ?> value="<?php echo $tv->id ?>"><?php echo $tv->name ?></option>

                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="email">Freeze <span style="color:red">*</span></label>

                                        <select name="fk_freeze" id="fk_freeze" class="form-control" required style="">
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($assetYesNo)) {
                                                foreach ($assetYesNo as $freeze) {
                                                    ?>
                                                    <option <?php if ($freeze->id == $asset_info->fk_freeze) {
                                                echo "selected=selected";
                                            } ?>  value="<?php echo $freeze->id ?>"><?php echo $freeze->name ?></option>

                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="email">Mobile <span style="color:red">*</span></label>

                                        <select name="fk_mobile" id="fk_mobile" class="form-control" required style="">
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($assetYesNo)) {
                                                foreach ($assetYesNo as $mobile) {
                                                    ?>
                                                    <option <?php if ($mobile->id == $asset_info->fk_mobile) {
                                                echo "selected=selected";
                                            } ?>  value="<?php echo $mobile->id ?>"><?php echo $mobile->name ?></option>

                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="email">Electric Fan <span style="color:red">*</span></label>

                                        <select name="fk_electric_fan" id="fk_electric_fan" class="form-control" required style="">
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($assetYesNo)) {
                                                foreach ($assetYesNo as $fan) {
                                                    ?>
                                                    <option  <?php if ($fan->id == $asset_info->fk_electric_fan) {
                                                echo "selected=selected";
                                            } ?> value="<?php echo $fan->id ?>"><?php echo $fan->name ?></option>

                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="email">Hand Watch <span style="color:red">*</span></label>

                                        <select name="fk_hand_watch" id="fk_hand_watch" class="form-control" required style="">
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($assetYesNo)) {
                                                foreach ($assetYesNo as $watch) {
                                                    ?>
                                                    <option <?php if ($watch->id == $asset_info->fk_hand_watch) {
                                                echo "selected=selected";
                                            } ?>  value="<?php echo $watch->id ?>"><?php echo $watch->name ?></option>

                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="email">Rickshaw <span style="color:red">*</span></label>

                                        <select name="fk_rickshow" id="fk_rickshow" class="form-control" required style="">
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($assetYesNo)) {
                                                foreach ($assetYesNo as $rickshow) {
                                                    ?>
                                                    <option <?php if ($rickshow->id == $asset_info->fk_rickshow) {
                                                echo "selected=selected";
                                            } ?> value="<?php echo $rickshow->id ?>"><?php echo $rickshow->name ?></option>

                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="email">Computer <span style="color:red">*</span></label>

                                        <select name="fk_computer" id="fk_computer" class="form-control" required style="">
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($assetYesNo)) {
                                                foreach ($assetYesNo as $computer) {
                                                    ?>
                                                    <option <?php if ($computer->id == $asset_info->fk_computer) {
                                                echo "selected=selected";
                                            } ?> value="<?php echo $computer->id ?>"><?php echo $computer->name ?></option>

                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="email">Sewing machine <span style="color:red">*</span></label>

                                        <select name="fk_sewing_machine" id="fk_sewing_machine" class="form-control" required style="">
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($assetYesNo)) {
                                                foreach ($assetYesNo as $machine) {
                                                    ?>
                                                    <option <?php if ($machine->id == $asset_info->fk_sewing_machine) {
                                                echo "selected=selected";
                                            } ?>  value="<?php echo $machine->id ?>"><?php echo $machine->name ?></option>

                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="email">Bycycle <span style="color:red">*</span></label>

                                        <select name="fk_cycle" id="fk_cycle" class="form-control" required style="">
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($assetYesNo)) {
                                                foreach ($assetYesNo as $cycle) {
                                                    ?>
                                                    <option <?php if ($cycle->id == $asset_info->fk_cycle) {
                                                echo "selected=selected";
                                            } ?>  value="<?php echo $cycle->id ?>"><?php echo $cycle->name ?></option>

                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="email">Motorcycle <span style="color:red">*</span></label>

                                        <select name="fk_motor_cycle" id="fk_motor_cycle" class="form-control" required style="">
                                            <option value="">Please Select</option>
                                            <?php
                                            if (!empty($assetYesNo)) {
                                                foreach ($assetYesNo as $motor_cycle) {
                                                    ?>
                                                    <option <?php if ($motor_cycle->id == $asset_info->fk_motor_cycle) {
                                                echo "selected=selected";
                                            } ?>  value="<?php echo $motor_cycle->id ?>"><?php echo $motor_cycle->name ?></option>

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

