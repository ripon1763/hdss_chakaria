
<?php $baseID = $this->input->get('baseID',TRUE); ?>
 <?php 
    $householdvisitID = 0;

    if (!empty($householdVisit)) 
    { 

         $householdvisitID = $householdVisit[0]->id; 

    } 

    ?>

                    <form action="<?php echo base_url().'householdassets/addNewAsset?baseID='.$baseID ?>" id="myForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8">

                    <!-- SmartWizard html -->
                  
                           
                     
                            <div id="asset" style="padding-left: 20px; padding-right: 20px">
                                <h4>Household Asset Details</h4>
                                 <div class="row">
                                     <div class="col-md-4">
                                          <p>Household Code : <?php echo $householdcode ?></p>
                                     </div>
                                      <div class="col-md-4">
                                         <p>Round Number :  <?php echo $roundNo ?></p>
                                     </div>
                                      <div class="col-md-4">
                                         <p>Last Interview Date :</p>
                                     </div>
                                </div>

                                <div id="form-step-0" role="form" data-toggle="validator">
                                    <div class="row">

                                         <div class="col-md-3">
                                             <div class="form-group">
                                                    <label for="email">Owner of land <span style="color:red">*</span></label>
                                                   
                                                     <select name="fk_owner_land" id="fk_owner_land" class="form-control" required style="">
                                                        <option value="">Please Select</option>
                                                        <?php if (!empty($land_owner))
                                                        {
                                                            foreach($land_owner as $land)
                                                            {
                                                            ?>
                                                               <option  value="<?php echo $land->id  ?>"><?php echo $land->name  ?></option>

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
                                                        <?php if (!empty($house_owner))
                                                            {
                                                                foreach($house_owner as $house)
                                                                {
                                                                ?>
                                                                   <option  value="<?php echo $house->id  ?>"><?php echo $house->name  ?></option>

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
                                                         <?php if (!empty($assetYesNo))
                                                            {
                                                                foreach($assetYesNo as $chair)
                                                                {
                                                                ?>
                                                                   <option  value="<?php echo $chair->id  ?>"><?php echo $chair->name  ?></option>

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
                                                         <?php if (!empty($assetYesNo))
                                                            {
                                                                foreach($assetYesNo as $table)
                                                                {
                                                                ?>
                                                                   <option  value="<?php echo $table->id  ?>"><?php echo $table->name  ?></option>

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
                                                         <?php if (!empty($assetYesNo))
                                                            {
                                                                foreach($assetYesNo as $khat)
                                                                {
                                                                ?>
                                                                   <option  value="<?php echo $khat->id  ?>"><?php echo $khat->name  ?></option>

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
                                                          <?php if (!empty($assetYesNo))
                                                            {
                                                                foreach($assetYesNo as $chowki)
                                                                {
                                                                ?>
                                                                   <option  value="<?php echo $chowki->id  ?>"><?php echo $chowki->name  ?></option>

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
                                                          <?php if (!empty($assetYesNo))
                                                            {
                                                                foreach($assetYesNo as $almirah)
                                                                {
                                                                ?>
                                                                   <option  value="<?php echo $almirah->id  ?>"><?php echo $almirah->name  ?></option>

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
                                                         <?php if (!empty($assetYesNo))
                                                            {
                                                                foreach($assetYesNo as $sofa)
                                                                {
                                                                ?>
                                                                   <option  value="<?php echo $sofa->id  ?>"><?php echo $sofa->name  ?></option>

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
                                                          <?php if (!empty($assetYesNo))
                                                            {
                                                                foreach($assetYesNo as $radio)
                                                                {
                                                                ?>
                                                                   <option  value="<?php echo $radio->id  ?>"><?php echo $radio->name  ?></option>

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
                                                          <?php if (!empty($assetYesNo))
                                                            {
                                                                foreach($assetYesNo as $tv)
                                                                {
                                                                ?>
                                                                   <option  value="<?php echo $tv->id  ?>"><?php echo $tv->name  ?></option>

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
                                                          <?php if (!empty($assetYesNo))
                                                            {
                                                                foreach($assetYesNo as $freeze)
                                                                {
                                                                ?>
                                                                   <option  value="<?php echo $freeze->id  ?>"><?php echo $freeze->name  ?></option>

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
                                                         <?php if (!empty($assetYesNo))
                                                            {
                                                                foreach($assetYesNo as $mobile)
                                                                {
                                                                ?>
                                                                   <option  value="<?php echo $mobile->id  ?>"><?php echo $mobile->name  ?></option>

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
                                                         <?php if (!empty($assetYesNo))
                                                            {
                                                                foreach($assetYesNo as $fan)
                                                                {
                                                                ?>
                                                                   <option  value="<?php echo $fan->id  ?>"><?php echo $fan->name  ?></option>

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
                                                          <?php if (!empty($assetYesNo))
                                                            {
                                                                foreach($assetYesNo as $watch)
                                                                {
                                                                ?>
                                                                   <option  value="<?php echo $watch->id  ?>"><?php echo $watch->name  ?></option>

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
                                                         <?php if (!empty($assetYesNo))
                                                            {
                                                                foreach($assetYesNo as $rickshow)
                                                                {
                                                                ?>
                                                                   <option  value="<?php echo $rickshow->id  ?>"><?php echo $rickshow->name  ?></option>

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
                                                          <?php if (!empty($assetYesNo))
                                                            {
                                                                foreach($assetYesNo as $computer)
                                                                {
                                                                ?>
                                                                   <option  value="<?php echo $computer->id  ?>"><?php echo $computer->name  ?></option>

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
                                                         <?php if (!empty($assetYesNo))
                                                            {
                                                                foreach($assetYesNo as $machine)
                                                                {
                                                                ?>
                                                                   <option  value="<?php echo $machine->id  ?>"><?php echo $machine->name  ?></option>

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
                                                         <?php if (!empty($assetYesNo))
                                                            {
                                                                foreach($assetYesNo as $cycle)
                                                                {
                                                                ?>
                                                                   <option  value="<?php echo $cycle->id  ?>"><?php echo $cycle->name  ?></option>

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
                                                          <?php if (!empty($assetYesNo))
                                                            {
                                                                foreach($assetYesNo as $motor_cycle)
                                                                {
                                                                ?>
                                                                   <option  value="<?php echo $motor_cycle->id  ?>"><?php echo $motor_cycle->name  ?></option>

                                                                <?php
                                                                }
                                                            }
                                                       
                                                        ?>
                                                     </select>
                                                   
                                                </div>
                                         </div>


                                    </div>
 
                                </div>

                            </div>

                            

                             <div class="box-footer" style="margin-left: 10px">
                                <input type="hidden" name="household_master_id_sub" value="<?php echo  $household_master_id_sub  ?>">
                                <input type="hidden" name="round_master_id" value="<?php echo  $round_master_id  ?>">
                                <input type="hidden" name="householdVisitID" value="<?php echo  $householdvisitID  ?>">
                                <input type="submit" class="btn btn-primary btnVisile" name="submit" value="Save" />
                                <a class="btn btn-primary" href="<?php echo base_url().'householdvisit/assets?baseID='.$baseID.'#asset' ?>" class="">Back </a>
                               
                            </div>
                           
                       

                     </form>

                    
                   
                  
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>

