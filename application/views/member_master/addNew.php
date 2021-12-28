
<script type="text/javascript">




 $(function () {
   $('#datepicker').datepicker({
     autoclose: true,
     format: 'dd/mm/yyyy'
   });
   $('#birthdate').datepicker({
     autoclose: true,
     format: 'dd/mm/yyyy'
   });
   $('#hhdate').datepicker({
     autoclose: true,
     format: 'dd/mm/yyyy'
   });

   $('#birthRegidate').datepicker({
     autoclose: true,
     format: 'dd/mm/yyyy'
   });
 });
$( document ).ready(function() {

            $("#addUser").validate({
                rules: {
                    age: { required: "#birthdate:blank"},
                    birthdate: { required: "#age:blank" }
                }
            });

    
    $("#relationheadID").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");

            if(optionValue == 27)
            {
               $(".hhdate").prop('required',true);
               $(".hhefectiveDate").show();

            } else{

               $(".hhdate").prop('required',false);
               $(".hhefectiveDate").hide();
            }
        });
    }).change();

     $("#educationType").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");

            //alert(optionValue);

            if(optionValue == 45)
            {
               $(".yearOfEdu").prop('required',false);
               $(".yearEdu").hide();

            }
            else if(optionValue == 120)
            {
               $(".yearOfEdu").prop('required',false);
               $(".yearEdu").hide();

            } else{

               $(".yearOfEdu").prop('required',true);
               $(".yearEdu").show();
            }
        });
    }).change();

     $("#occupationType").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");

            //alert(optionValue);

            if(optionValue == 166)
            {
              
               $(".main_occupation_oth").prop('required',true);
               $(".occupationOth").show();

            } else{


                $(".main_occupation_oth").prop('required',false);
                $(".occupationOth").hide();
            }
        });
    }).change();


      $("#birstRegiType").change(function(){

        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");

            if(optionValue == 1)
            {
               $(".birthRegidate").prop('required',true);
               $(".whyNotRegi").prop('required',false);
               $(".birthRegi").show();
               $(".notRegi").hide();

            } else{

               $(".birthRegidate").prop('required',false);
               $(".whyNotRegi").prop('required',true);
               $(".birthRegi").hide();
               $(".notRegi").show();
            }
        });
    }).change();

    $("#maritalStatusType").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");

            if(optionValue == 41)
            {
               $(".additionalChild_Desire").show();
               $(".afterManyYear").prop('required',false);

            } else{

               $(".additionalChild_Desire").hide();
               
            }
        });
    }).change();

    $("#additionalChild").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");

            if(optionValue == 1)
            {
               $(".afterManyYear").prop('required',true);
               $(".manyYear").show();

            } else{

               $(".afterManyYear").prop('required',false);
               $(".manyYear").hide();
            }
        });
    }).change();


});


</script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <div class="row">
		    <div class="col-xs-7 text-left header-margin ">
	              <h3>
					<?php echo $pageTitle; ?>
					
					<?php $baseID = $this->input->get('baseID',TRUE); ?>
				  </h3>
               
            </div>
            <div class="col-xs-5 text-right">
                <div class="form-group margin5pxBot">
                        <a class="btn btn-primary" href="<?php echo base_url().$controller.'?baseID='.$baseID ?>"><?php echo $shortName ?> List</a>
                </div>
            </div>
        </div>
    </section>
    
    <section class="content content-margin">    
        <div class="row">
           
            <div class="col-md-12">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title"><?php echo $shortName ?> Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
						<?php
							$this->load->helper('form');
							$error = $this->session->flashdata('error');
							if($error)
							{
						?>
						<div class="alert alert-danger alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<?php echo $this->session->flashdata('error'); ?>                    
						</div>
						<?php } ?>
						<?php  
							$success = $this->session->flashdata('success');
							if($success)
							{
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
                    <?php if($roundStstus == 0) : ?>
                     <h4 style="padding-left:10px; color:red"> Round is closed now, You can't add any member </h4>

                     <?php endif; ?>
            
                    <form role="form" id="addUser" action="<?php echo base_url().$controller.'/'.$actionMethod.'?baseID='.$baseID?>" method="post" role="form">
                        <div class="box-body">
                            <div class="row" ng-app="">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">District <span style="color:red">*</span></label>
                                        
                                        <select class="form-control" id="districtID"  name="districtID" required>
                                           <option value="">--- Select District ---</option>
                                            <?php
                                            if(!empty($district))
                                            {
                                                foreach ($district as $district)
                                                {
                                                    ?>
                                                    <option <?php if($district->id == $district_id) { echo "selected=selected";} ?> value="<?php echo $district->id ?>"><?php echo $district->code. '-' .$district->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">City area <span style="color:red">*</span></label>

                                        <select  class="form-control required" id="thanaID" name="thanaID" required>
                                            <option value="">--- Select City area ---</option>
                                        </select>
                                    </div>
                                </div>

                               <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Slum Name<span style="color:red">*</span></label>
                                        
                                        <select class="form-control required" id="slumID" name="slumID" required>
                                           <option value="">--- Select Slum Name---</option>
                                        </select>
                                    </div>
                                </div>

                                 <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Slum Area <span style="color:red">*</span></label>
                                        
                                        <select class="form-control required" id="slumAreaID" name="slumAreaID" required>
                                           <option value="">--- Select Slum Area ---</option>
                                           
                                        </select>
                                    </div>
                                </div>

                                 <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Household Code <span style="color:red">*</span></label>
                                        
                                        <select class="form-control required" id="househodID" name="househodID" required>
                                           <option value="">--- Select Household ---</option>
                                           
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Active">Member Entry type <span style="color:red">*</span></label>
                                        <select class="form-control required" id="entryType" name="entryType" required>
                                           <!-- <option value="">Please Select</option>-->
                                           <?php
                                            if(!empty($entryType))
                                            {
                                                foreach ($entryType as $entryType)
                                                {
                                                    ?>
                                                    <option value="<?php echo $entryType->id ?>"><?php echo $entryType->code. '-' .$entryType->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Member Entry Date <span style="color:red">*</span></label>
                                        <input type="text" class="form-control required" id="datepicker"  placeholder="Member Entry Date"  name="entryDate" maxlength="255" required="required">
                                    </div>
                                </div> 
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Current Round no <span style="color:red">*</span></label>
                                        <input type="text" class="form-control" id="round"  name="round_master_id" value="<?php echo $roundid ?>" disabled="disabled">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Member Name <span style="color:red">*</span></label>
                                        <input type="text" class="form-control required" id="memberName" placeholder="Member Name"  name="memberName" maxlength="255" required="required">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Active">Sex  <span style="color:red">*</span></label>
                                        <select class="form-control required" id="sexType" name="sexType" required>
                                            <option value="">Please Select</option>
                                           <?php
                                            if(!empty($membersextype))
                                            {
                                                foreach ($membersextype as $membersex)
                                                {
                                                    ?>
                                                    <option value="<?php echo $membersex->id ?>"><?php echo $membersex->code. '-' .$membersex->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Age <span style="color:red">*</span></label>
                                        <input type="number" class="form-control required age" id="age" placeholder="Age" name="age">
                                    </div>
                                </div> 

                                 <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Birth Date <span style="color:red">*</span></label>
                                        <input type="text" class="form-control" id="birthdate" placeholder="Birth Date"  name="birthdate" >
                                    </div>
                                </div> 

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Father's RID</label>
                                        <select class="form-control" id="fatherCode" name="fatherCode">
                                           <option value="0">--- Select Father's ---</option>
                                           <?php
                                            if(!empty($fatherList))
                                            {
                                                foreach ($fatherList as $father)
                                                {
                                                    ?>
                                                    <option value="<?php echo $father->id ?>"><?php echo $father->member_code. '-' .$father->member_name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Mother's RID</label>
                                        <select class="form-control" id="motherCode" name="motherCode">
                                           <option value="0">--- Select Mother's ---</option>
                                           <?php
                                            if(!empty($motherList))
                                            {
                                                foreach ($motherList as $mother)
                                                {
                                                    ?>
                                                    <option value="<?php echo $mother->id ?>"><?php echo $mother->member_code. '-' .$mother->member_name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Present Spouse's RID </label>
                                        <select class="form-control" id="spouseCode" name="spouseCode">
                                           <option value="0">--- Select Spouse's ---</option>
                                           <?php
                                            if(!empty($spouseList))
                                            {
                                                foreach ($spouseList as $spouse)
                                                {
                                                    ?>
                                                    <option value="<?php echo $spouse->id ?>"><?php echo $spouse->member_code. '-' .$spouse->member_name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">National/ Voter ID </label>
                                        <input type="text" class="form-control" id="nationalID"  name="nationalID" maxlength="17" >
                                    </div>
                                </div>

                                 <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Active">Relation with household head  <span style="color:red">*</span></label>
                                        <select class="form-control required" id="relationheadID" name="relationheadID" required>
                                            <option value="">Please Select</option>
                                           <?php
                                            if(!empty($relationhhh))
                                            {
                                                foreach ($relationhhh as $relationhhh)
                                                {
                                                    ?>
                                                    <option value="<?php echo $relationhhh->id ?>"><?php echo $relationhhh->code. '-' .$relationhhh->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3 hhefectiveDate">
                                    <div class="form-group">
                                        <label for="Item Name">Effective date (If HHH) <span style="color:red">*</span></label>
                                        <input type="text" class="form-control hhdate" id="hhdate"  name="hhdate" maxlength="255" >
                                    </div>
                                </div>
                          
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Active">Present Marital status <span style="color:red">*</span></label>
                                        <select class="form-control required" id="maritalStatusType" name="maritalStatusType" required>
                                            <option value="">Please Select</option>
                                             <?php
                                            if(!empty($maritalstatustyp))
                                            {
                                                foreach ($maritalstatustyp as $maritalstatu)
                                                {
                                                    ?>
                                                    <option value="<?php echo $maritalstatu->id ?>"><?php echo $maritalstatu->code. '-' .$maritalstatu->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            
                                        </select>
                                    </div>
                                </div>
                            

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Active">Religion <span style="color:red">*</span></label>
                                        <select class="form-control required" id="religionType" name="religionType" required>
                                            <option value="">Please Select</option>
                                             <?php
                                            if(!empty($religion))
                                            {
                                                foreach ($religion as $religion)
                                                {
                                                    ?>
                                                    <option value="<?php echo $religion->id ?>"><?php echo $religion->code. '-' .$religion->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Active">Type of education <span style="color:red">*</span></label>
                                        <select class="form-control required" id="educationType" name="educationType" required>
                                            <option value="">Please Select</option>
                                             <?php
                                            if(!empty($educationtyp))
                                            {
                                                foreach ($educationtyp as $educationtyp)
                                                {
                                                    ?>
                                                    <option value="<?php echo $educationtyp->id ?>"><?php echo $educationtyp->code. '-' .$educationtyp->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 yearEdu">
                                    <div class="form-group">
                                        <label for="Item Name">Year of Education <span style="color:red">*</span></label>
                                        <!--<input type="text" class="form-control yearOfEdu" id="yearOfEdu"  name="yearOfEdu" maxlength="255" >-->
                                        <select class="form-control yearOfEdu" id="yearOfEdu" name="yearOfEdu">
                                            <option value="">Please Select</option>
                                             <?php
                                            if(!empty($education_year))
                                            {
                                                foreach ($education_year as $education_year) 
                                                {
                                                    ?>
                                                    <option value="<?php echo $education_year->id ?>"><?php echo $education_year->code. '-' .$education_year->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            
                                        </select>
									
									
									</div>
                                </div>

                               
                              <!--  <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Active">Secular education</label>
                                        <select class="form-control required" id="secularEduType" name="secularEduType">
                                            <option value="">Please Select</option>
                                             <?php
                                            if(!empty($secularedutyp))
                                            {
                                                foreach ($secularedutyp as $secularedutyp)
                                                {
                                                    ?>
                                                    <option value="<?php echo $secularedutyp->id ?>"><?php echo $secularedutyp->code. '-' .$secularedutyp->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            
                                        </select>
                                    </div>
                                </div>-->
                                <!--<div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Active">Religious education </label>
                                        <select class="form-control required" id="religiousEduType" name="religiousEduType">
                                            <option value="0">Please Select</option>
                                             <?php
                                            if(!empty($religiousedutype))
                                            {
                                                foreach ($religiousedutype as $religiousedu)
                                                {
                                                    ?>
                                                    <option value="<?php echo $religiousedu->id ?>"><?php echo $religiousedu->code. '-' .$religiousedu->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            
                                        </select>
                                    </div>
                                </div>-->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Active">Main occupation <span style="color:red">*</span></label>
                                        <select class="form-control required" id="occupationType" name="occupationType" required>
                                            <option value="">Please Select</option>
                                             <?php
                                            if(!empty($occupationtyp))
                                            {
                                                foreach ($occupationtyp as $occupationtyp)
                                                {
                                                    ?>
                                                    <option value="<?php echo $occupationtyp->id ?>"><?php echo $occupationtyp->code. '-' .$occupationtyp->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            
                                        </select>
                                    </div>
                                </div>

                                 <div class="col-md-3 occupationOth">
                                    <div class="form-group">
                                        <label for="Item Name">Specify Other Occupation <span style="color:red">*</span></label>
                                        <input type="text" class="form-control main_occupation_oth" id="main_occupation_oth"  name="main_occupation_oth" maxlength="255" >
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Active">Birth registration <span style="color:red">*</span></label>
                                        <select class="form-control required" id="birstRegiType" name="birstRegiType" required>
                                            <option value="">Please Select</option>
                                             <?php
                                            if(!empty($birthregistration))
                                            {
                                                foreach ($birthregistration as $birthregistration)
                                                {
                                                    ?>
                                                    <option value="<?php echo $birthregistration->id ?>"><?php echo $birthregistration->code. '-' .$birthregistration->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 birthRegi">
                                    <div class="form-group">
                                        <label for="Item Name">Registration date <span style="color:red">*</span></label>
                                        <input type="text" class="form-control birthRegidate" id="birthRegidate" placeholder="Registration Date"  name="birthRegidate" maxlength="255">
                                    </div>
                                </div>

                                 <div class="col-md-3 notRegi">
                                    <div class="form-group">
                                        <label for="Active">why not registrated <span style="color:red">*</span></label>
                                        <select class="form-control whyNotRegi" id="whyNotRegi" name="whyNotRegi">
                                            <option value="">Please Select</option>
                                             <?php
                                            if(!empty($whynotbirthreg))
                                            {
                                                foreach ($whynotbirthreg as $whynotbirthreg)
                                                {
                                                    ?>
                                                    <option value="<?php echo $whynotbirthreg->id ?>"><?php echo $whynotbirthreg->code. '-' .$whynotbirthreg->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            
                                        </select>
                                    </div>
                                </div>

                                 <div class="col-md-3 additionalChild_Desire">
                                    <div class="form-group">
                                        <label for="Active">Desire for additional child </label>
                                        <select class="form-control" id="additionalChild" name="additionalChild">
                                            <option value="0">Please Select</option>
                                             <?php
                                            if(!empty($additionChild))
                                            {
                                                foreach ($additionChild as $additionChild)
                                                {
                                                    ?>
                                                    <option value="<?php echo $additionChild->id ?>"><?php echo $additionChild->code. '-' .$additionChild->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 manyYear">
                                    <div class="form-group">
                                        <label for="Item Name">After how many year <span style="color:red">*</span></label>
                                        <select class="form-control afterManyYear" id="afterManyYear" name="afterManyYear">
                                            <option value="0">Please Select</option>
                                             <?php
                                            if(!empty($child_after_year))
                                            {
                                                foreach ($child_after_year as $after_year) 
                                                {
                                                    ?>
                                                    <option value="<?php echo $after_year->id ?>"><?php echo $after_year->code. '-' .$after_year->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            
                                        </select>
                                    
                                    
                                    </div>
                                </div>
								
								<div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Contact No(One) </label>
                                        <input type="text" class="form-control" id="contactNoOne"  name="contactNoOne" minlength="11" maxlength="11">
                                    </div>
                                </div>
								<div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Contact No(Two) </label>
                                        <input type="text" class="form-control" id="contactNoTwo"  name="contactNoTwo" minlength="11" maxlength="11">
                                    </div>
                                </div>



                            </div>
                        </div><!-- /.box-body -->
                       <?php if($roundStstus == 1) : ?>
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Save" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </div>
                       <?php endif; ?>
                    </form>
                </div>
            </div>
            
        </div>    
    </section>
    
</div>


<script type="text/javascript">


    $(document).ready(function() {


    $('#districtID').change(function(){
          var districtID = $('#districtID').val();
          if(districtID != '')
          {
           $.ajax({
            url:"<?php echo base_url(); ?>api/getUpaZila",
            method:"POST",
            data:{districtID:districtID},
            success:function(data)
            {
             $('#thanaID').html('');
             $('#thanaID').html(data);
            //$('#city').html('<option value="">Select City</option>');
            }
           });
          }
          else
          {
           $('#thanaID').html('<option value="">--- Select Upazila ---</option>');
           $('#slumID').html('<option value="">--- Select Slum ---</option>');
          }
     });


    $('#thanaID').change(function(){
          var thanaID = $('#thanaID').val();
          if(thanaID != '')
          {
           $.ajax({
            url:"<?php echo base_url(); ?>api/getSlum",
            method:"POST",
            data:{thanaID:thanaID},
            success:function(data)
            {
             $('#slumID').html('');
             $('#slumID').html(data);
             $('#slumID').val('<?php echo $slum_id; ?>').trigger('change');
            //$('#city').html('<option value="">Select City</option>');
            }
           });
          }
          else
          {
           $('#slumID').html('<option value="">--- Select Slum ---</option>');
           //$('#city').html('<option value="">Select City</option>');
          }
     });


    $('#slumID').change(function(){
          var slumID = $('#slumID').val();
          if(slumID != '')
          {
           $.ajax({
            url:"<?php echo base_url(); ?>api/getSlumArea",
            method:"POST",
            data:{slumID:slumID},
            success:function(data)
            {
             $('#slumAreaID').html('');
             $('#slumAreaID').html(data);
             $('#slumAreaID').val('<?php echo $slumarea_id; ?>').trigger('change');
             //console.log(data);
            //$('#city').html('<option value="">Select City</option>');
            }
           });
          }
          else
          {
           $('#slumAreaID').html('<option value="">--- Select Slum Area ---</option>');
           //$('#city').html('<option value="">Select City</option>');
          }
     });


    $('#slumAreaID').change(function(){
          var slumAreaID = $('#slumAreaID').val();
          if(slumAreaID != '')
          {
           $.ajax({
            url:"<?php echo base_url(); ?>api/getHousehold",
            method:"POST",
            data:{slumAreaID:slumAreaID},
            success:function(data)
            {
             $('#househodID').html('');
             $('#househodID').html(data);
             $('#househodID').val('<?php echo $household_id; ?>').trigger('change');
            // console.log(data);
            //$('#city').html('<option value="">Select City</option>');
            }
           });
          }
          else
          {
           $('#househodID').html('<option value="">--- Select Household ---</option>');
           //$('#city').html('<option value="">Select City</option>');
          }
     });


     var seldistrictId = '<?php echo $district_id ?>';
    if (seldistrictId > 0)
    {

         var districtID = seldistrictId;
          if(districtID != '')
          {
           $.ajax({
            url:"<?php echo base_url(); ?>api/getUpaZila",
            method:"POST",
            data:{districtID:districtID},
            success:function(data)
            {
             $('#thanaID').html('');

             $('#thanaID').html(data);
             $('#thanaID').val('<?php echo $thana_id; ?>').trigger('change');
             $('#slumID').val('<?php echo $slum_id; ?>').trigger('change');
             $('#slumAreaID').val('<?php echo $slumarea_id; ?>').trigger('change');
            }
           });

          }   

    }

    var selThanaId = '<?php echo $thana_id; ?>';

    if (selThanaId > 0)
    {

         var thanaID = selThanaId;
          if(thanaID != '')
          {
           $.ajax({
            url:"<?php echo base_url(); ?>api/getSlum",
            method:"POST",
            data:{thanaID:thanaID},
            success:function(data)
            {
             $('#slumID').html('');

             $('#slumID').html(data);
             $('#slumID').val('<?php echo $slum_id; ?>').trigger('change');
            }
           });

          }   

    }


    var selSlumId = '<?php echo $slum_id; ?>';

    if (selSlumId > 0)
    {

         var slumID = selSlumId;
          if(slumID != '')
          {
           $.ajax({
            url:"<?php echo base_url(); ?>api/getSlumArea",
            method:"POST",
            data:{slumID:slumID},
            success:function(data)
            {
             $('#slumAreaID').html('');

             $('#slumAreaID').html(data);
             $('#slumAreaID').val('<?php echo $slumarea_id; ?>').trigger('change');
            }
           });

          }   

    }

     var selHouseId = '<?php echo $household_id; ?>';

    if (selHouseId > 0)
    {

         var slumAreaID = selHouseId;


          if(slumAreaID != '')
          {
           $.ajax({
            url:"<?php echo base_url(); ?>api/getHousehold",
            method:"POST",
            data:{slumAreaID:slumAreaID},
            success:function(data)
            {
             $('#househodID').html('');

             $('#househodID').html(data);
             $('#househodID').val('<?php echo $household_id; ?>').trigger('change');
             //console.log(data);
            }
           });

          }   

    }


    $("#yearOfEdu").keydown(function(event) {
        // Allow only backspace and delete
        if ( event.keyCode == 46 || event.keyCode == 8 ) {
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.keyCode < 48 || event.keyCode > 57 ) {
                event.preventDefault(); 
            }   
        }
    });

      $("#afterManyYear").keydown(function(event) {
        // Allow only backspace and delete
        if ( event.keyCode == 46 || event.keyCode == 8 ) {
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.keyCode < 48 || event.keyCode > 57 ) {
                event.preventDefault(); 
            }   
        }
    });

    


        
    });
</script>