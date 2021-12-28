<?php




$id = 0;
$fk_district_id = 0;
$fk_thana_id= 0;
$fk_slum_id= 0; 
$fk_slum_area_id = 0;
$fk_entry_type = 0;
$household_master_id_hh = 0;
$fk_relation_with_hhh = 0;
$fk_marital_status = 0;
$fk_religion = 0;
$fk_birth_registration = 0;
$fk_why_not_birth_registration = 0;
$fk_additionalChild = 0;
$afterYear = 0;
$fk_sex = 0;
$entry_date = '';
$household_code = '';
$member_code = '';
$member_name = '';
$birth_date = '';
$father_code = '';
$mother_code = '';
$spouse_code = '';
$national_id = '';
$entryTypeCode = '';
$entryTypeName = '';
$birth_registration_date = '';
$change_date = '';
$fk_extinct_type = 0;
$fk_education_type = 0;
$year_of_education = 0;
$fk_secular_edu = 0;
$fk_religious_edu = 0;
$fk_main_occupation = 0;

$fk_member_relation_id_last = 0;
$fk_education_id_last = 0;
$fk_occupation_id_last = 0;
$member_household_id_last = 0;


if(!empty($userInfo))
{
    foreach ($userInfo as $uf)
    {
        $id = $uf->id;
        $fk_district_id = $uf->fk_district_id;
        $fk_thana_id = $uf->fk_thana_id;
        $fk_slum_id = $uf->fk_slum_id;
        $fk_slum_area_id = $uf->fk_slum_area_id;
        $fk_entry_type = $uf->fk_entry_type;
        $entry_date = $uf->entry_date;
        $household_code = $uf->household_code;
        $member_code = $uf->member_code;
        $member_name = $uf->member_name;
        $household_master_id_hh = $uf->household_master_id_hh;
        $birth_date = $uf->birth_date;
        $fk_marital_status = $uf->fk_marital_status;
        $fk_sex = $uf->fk_sex;
        $fk_religion = $uf->fk_religion;
        $fk_relation_with_hhh = $uf->fk_relation_with_hhh;
        $father_code = $uf->father_code;
        $mother_code = $uf->mother_code;
        $spouse_code = $uf->spouse_code;
        $national_id = $uf->national_id;
        $fk_birth_registration = $uf->fk_birth_registration;
        $birth_registration_date = $uf->birth_registration_date;
        $fk_why_not_birth_registration = $uf->fk_why_not_birth_registration;
        $fk_additionalChild = $uf->fk_additionalChild;
        $afterYear = $uf->afterYear;
        $change_date = $uf->change_date;
        $fk_education_type = $uf->fk_education_type;
        $fk_extinct_type = $uf->fk_extinct_type;
        $year_of_education = $uf->year_of_education;
        $fk_secular_edu = $uf->fk_secular_edu;
        $fk_religious_edu = $uf->fk_religious_edu;
        $fk_main_occupation = $uf->fk_main_occupation;

        $fk_member_relation_id_last =$uf->fk_member_relation_id_last;
        $fk_education_id_last = $uf->fk_education_id_last;
        $fk_occupation_id_last =$uf->fk_occupation_id_last;
        $member_household_id_last =$uf->member_household_id_last;
        $entryTypeCode =$uf->entryTypeCode;
        $entryTypeName =$uf->entryTypeName;
       
    }
}

?>
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

            if(optionValue == 45)
            {
               $(".yearOfEdu").prop('required',false);
               $(".yearEdu").hide();

            } else{

               $(".yearOfEdu").prop('required',true);
               $(".yearEdu").show();
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
		    <div class="col-xs-6 text-left header-margin ">
	              <h3>
					<?php echo $pageTitle; ?>
					<small>(Add, Edit)</small>
					<?php $baseID = $this->input->get('baseID',TRUE); ?>
				  </h3>
               
            </div>
            <div class="col-xs-6 text-right">
                <div class="form-group margin5pxBot">
                         <a class="btn btn-primary" href="<?php echo base_url().$controller.'?baseID='.$baseID ?>"><?php echo $shortName ?> List</a>
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

                    <?php if ($fk_extinct_type > 0) : ?>

                        <p style="padding-left: 10px; color:red">This household is already extincted. You cannot change anything !!</p>

                    <?php endif; ?>
                    
                    <form role="form" action="<?php echo base_url().$controller.'/'.$actionMethod.'?baseID='.$baseID ?>" method="post" id="editUser" role="form">
                        <div class="box-body">
						<div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">District <span style="color:red">*</span></label>
                                        <input type="hidden" name="id" value="<?php echo $id ?>">
                                        <input type="hidden" name="household_master_id" value="<?php echo $household_master_id_hh ?>">

                                        <input type="hidden" name="fk_education_id_last" value="<?php echo $fk_education_id_last ?>">
                                        <input type="hidden" name="fk_occupation_id_last" value="<?php echo $fk_occupation_id_last ?>">
                                        <input type="hidden" name="fk_member_relation_id_last" value="<?php echo $fk_member_relation_id_last ?>">
                                        <input type="hidden" name="member_household_id_last" value="<?php echo $member_household_id_last ?>">

                                        <select class="form-control" id="districtID"  name="districtID" disabled="disabled">
                                           <option value="">--- Select District ---</option>
                                            <?php
                                            if(!empty($district))
                                            {
                                                foreach ($district as $district)
                                                {
                                                    ?>
                                                    <option <?php if($district->id == $fk_district_id) { echo "selected=selected";} ?> value="<?php echo $district->id ?>"><?php echo $district->code. '-' .$district->name ?></option>
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

                                        <select  class="form-control required" id="thanaID" name="thanaID" disabled="disabled">
                                            <option value="">--- Select Upazila ---</option>
                                        </select>
                                    </div>
                                </div>

                               <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Slum <span style="color:red">*</span></label>
                                        
                                        <select class="form-control required" id="slumID" name="slumID" disabled="disabled">
                                           <option value="">--- Select Slum ---</option>
                                        </select>
                                    </div>
                                </div>

                                 <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Slum Area <span style="color:red">*</span></label>
                                        
                                        <select class="form-control required" id="slumAreaID" name="slumAreaID" disabled="disabled">
                                           <option value="">--- Select Slum Area ---</option>
                                           
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Household Code</label> 
                                         <input type="text" class="form-control required" value="<?php echo $household_code; ?>" id="household_code"  name="household_code" maxlength="255" disabled="disabled">
                                        
                                       
                                    </div>
                                </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Member Code</label> 
                                     <input type="text" class="form-control required" value="<?php echo $member_code; ?>" id="member_code"  name="member_code" maxlength="255" disabled="disabled">
                                        
                                      
                                    </div>
                                </div>

                                 <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Member Name <span style="color:red">*</span></label>
                                        <input type="text" class="form-control required" value="<?php echo $member_name; ?>" id="memberName"  name="memberName" maxlength="255" required="required">
                                    </div>
                                </div>

                                
                           
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Active">Entry type <span style="color:red">*</span></label>

                                          <input type="text" class="form-control required" value="<?php echo $entryTypeCode.'-'.$entryTypeName; ?>" id="entryTypeCode"  name="entryTypeCode" disabled="disabled">
                                        
                                        
                                    </div>
                                </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Entry Date <span style="color:red">*</span></label>

                                        <?php 
                                                   if ($entry_date != "")
                                                   {
                                                    $partsRequire = explode('-', $entry_date);
                                                    $entry_date = $partsRequire[2].'/'.$partsRequire[1].'/'.$partsRequire[0];
                                                   }
                                         ?>
                                        <input type="text" value="<?php echo $entry_date ?>" class="form-control required" id="datepicker"  name="entryDate" maxlength="255" required="required">
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
                                                    <option <?php  if ($membersex->id == $fk_sex) { echo "selected=selected";} ?> value="<?php echo $membersex->id ?>"><?php echo $membersex->code. '-' .$membersex->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            
                                        </select>
                                    </div>
                                </div>

                                 <div class="col-md-3">
                                    <div class="form-group">
                                         <?php 
                                                   if ($birth_date != "")
                                                   {
                                                    $partsRequire = explode('-', $birth_date);
                                                    $birth_date = $partsRequire[2].'/'.$partsRequire[1].'/'.$partsRequire[0];
                                                   }
                                         ?>
                                        <label for="Item Name">Birth Date <span style="color:red">*</span></label>
                                        <input type="text" class="form-control required" value="<?php echo $birth_date ?>" id="birthdate"  name="birthdate" maxlength="255" required="required">
                                    </div>
                                </div> 

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Father code</label>
                                        <input type="text" class="form-control required" value="<?php echo $father_code ?>"  id="fatherCode"  name="fatherCode" maxlength="255">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Mother code</label>
                                        <input type="text" class="form-control required" value="<?php echo $mother_code ?>"  id="motherCode"  name="motherCode" maxlength="255" >
                                    </div>
                                </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">Present Spouse code </label>
                                        <input type="text" class="form-control required" id="spouseCode" value="<?php echo $spouse_code ?>"   name="spouseCode" maxlength="255">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Item Name">National/ Voter Id <span style="color:red">*</span></label>
                                        <input type="text" class="form-control required" value="<?php echo $national_id ?>"  id="nationalID"  name="nationalID" maxlength="255" required="required">
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
                                                    <option <?php  if ($relationhhh->id == $fk_relation_with_hhh) { echo "selected=selected";} ?> value="<?php echo $relationhhh->id ?>"><?php echo $relationhhh->code. '-' .$relationhhh->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3 hhefectiveDate">
                                    <div class="form-group">
                                         <?php 
                                                   if ($change_date != "")
                                                   {
                                                    $partsRequire = explode('-', $change_date);
                                                    $change_date = $partsRequire[2].'/'.$partsRequire[1].'/'.$partsRequire[0];
                                                   }
                                         ?>
                                        <label for="Item Name">Effective date (If HHH) <span style="color:red">*</span></label>
                                        <input type="text" class="form-control hhdate" value="<?php echo $change_date ?>" id="hhdate"  name="hhdate" maxlength="255" >
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
                                                    <option <?php  if ($maritalstatu->id == $fk_marital_status) { echo "selected=selected";} ?>  value="<?php echo $maritalstatu->id ?>"><?php echo $maritalstatu->code. '-' .$maritalstatu->name ?></option>
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
                                                    <option <?php  if ($religion->id == $fk_religion) { echo "selected=selected";} ?>  value="<?php echo $religion->id ?>"><?php echo $religion->code. '-' .$religion->name ?></option>
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
                                                    <option  <?php  if ($educationtyp->id == $fk_education_type) { echo "selected=selected";} ?> value="<?php echo $educationtyp->id ?>"><?php echo $educationtyp->code. '-' .$educationtyp->name ?></option>
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
                                        <input type="text" value="<?php echo $year_of_education ?>" class="form-control yearOfEdu" id="yearOfEdu"  name="yearOfEdu" maxlength="255" >
                                    </div>
                                </div>

                               
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Active">Secular education</label>
                                        <select class="form-control required"  id="secularEduType" name="secularEduType" required>
                                            <option value="">Please Select</option>
                                             <?php
                                            if(!empty($secularedutyp))
                                            {
                                                foreach ($secularedutyp as $secularedutyp)
                                                {
                                                    ?>
                                                    <option <?php  if ($secularedutyp->id == $fk_secular_edu) { echo "selected=selected";} ?> value="<?php echo $secularedutyp->id ?>"><?php echo $secularedutyp->code. '-' .$secularedutyp->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Active">Religious education </label>
                                        <select class="form-control required" id="religiousEduType" name="religiousEduType" required>
                                            <option value="">Please Select</option>
                                             <?php
                                            if(!empty($religiousedutype))
                                            {
                                                foreach ($religiousedutype as $religiousedu)
                                                {
                                                    ?>
                                                    <option <?php  if ($religiousedu->id == $fk_religious_edu) { echo "selected=selected";} ?> value="<?php echo $religiousedu->id ?>"><?php echo $religiousedu->code. '-' .$religiousedu->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            
                                        </select>
                                    </div>
                                </div>
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
                                                    <option <?php  if ($occupationtyp->id == $fk_main_occupation) { echo "selected=selected";} ?> value="<?php echo $occupationtyp->id ?>"><?php echo $occupationtyp->code. '-' .$occupationtyp->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            
                                        </select>
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
                                                    <option <?php  if ($birthregistration->id == $fk_birth_registration) { echo "selected=selected";} ?> value="<?php echo $birthregistration->id ?>"><?php echo $birthregistration->code. '-' .$birthregistration->name ?></option>
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

                                         <?php 
                                                   if ($birth_registration_date != "")
                                                   {
                                                    $partsRequire = explode('-', $birth_registration_date);
                                                    $birth_registration_date = $partsRequire[2].'/'.$partsRequire[1].'/'.$partsRequire[0];
                                                   }
                                         ?>
                                        <input type="text" class="form-control birthRegidate" value="<?php echo $birth_registration_date ?>" id="birthRegidate"  name="birthRegidate" maxlength="255">
                                    </div>
                                </div>

                                 <div class="col-md-3 notRegi">
                                    <div class="form-group">
                                        <label for="Active">why not registration <span style="color:red">*</span></label>
                                        <select class="form-control whyNotRegi" id="whyNotRegi" name="whyNotRegi">
                                            <option value="">Please Select</option>
                                             <?php
                                            if(!empty($whynotbirthreg))
                                            {
                                                foreach ($whynotbirthreg as $whynotbirthreg)
                                                {
                                                    ?>
                                                    <option <?php  if ($whynotbirthreg->id == $fk_why_not_birth_registration) { echo "selected=selected";} ?> value="<?php echo $whynotbirthreg->id ?>"><?php echo $whynotbirthreg->code. '-' .$whynotbirthreg->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            
                                        </select>
                                    </div>
                                </div>

                                 <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Active">Additional child desire <span style="color:red">*</span></label>
                                        <select class="form-control required" id="additionalChild" name="additionalChild" required>
                                            <option value="">Please Select</option>
                                             <?php
                                            if(!empty($additionChild))
                                            {
                                                foreach ($additionChild as $additionChild)
                                                {
                                                    ?>
                                                    <option <?php  if ($additionChild->id == $fk_additionalChild) { echo "selected=selected";} ?>  value="<?php echo $additionChild->id ?>"><?php echo $additionChild->code. '-' .$additionChild->name ?></option>
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
                                        <input type="text" class="form-control afterManyYear" value="<?php echo $afterYear ?>" id="afterManyYear"  name="afterManyYear" maxlength="255">
                                    </div>
                                </div>
                               
                            </div>
						    
                        </div><!-- /.box-body -->
                         <?php if ($fk_extinct_type == 0) : ?>
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Save" />
                          
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

            // console.log(data);
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




   var seldistrictId = $('#districtID').val();  
    if (seldistrictId > 0)
    {

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
             $('#thanaID').val('<?php echo $fk_thana_id; ?>').trigger('change');
            }
           });

          }   

    }

    var selThanaId = '<?php echo $fk_thana_id; ?>';

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
             $('#slumID').val('<?php echo $fk_slum_id; ?>').trigger('change');
            }
           });

          }   

    }

    var selSlumId = '<?php echo $fk_slum_id; ?>';

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
             $('#slumAreaID').val('<?php echo $fk_slum_area_id; ?>').trigger('change');
            }
           });

          }   

    }



 });


</script>