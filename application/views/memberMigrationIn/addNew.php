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

    // $("#relationheadID").change(function(){
        // $(this).find("option:selected").each(function(){
            // var optionValue = $(this).attr("value");

            // if(optionValue == 27)
            // {
               // $(".hhdate").prop('required',true);
               // $(".hhefectiveDate").show();

            // } else{

               // $(".hhdate").prop('required',false);
               // $(".hhefectiveDate").hide();
            // }
        // });
    // }).change();

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
			
	<?php $baseID = $this->input->get('baseID',TRUE); ?>
				 
    
    <section class="content">    
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
            
                    <!--<form role="form" id="addUser" action="<?php //echo base_url().$controller.'/'.$actionMethod.'?baseID='.$baseID?>" method="post" role="form">-->
                    <form role="form" id="addUser" method="post">
                        <div class="box-body">
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Item Name">Member Name <span style="color:red">*</span></label>
										<input type="hidden" name="household_master_id" value="<?php echo $household_master_id ?>" />
										<input type="hidden" name="baseID" value="<?php echo $baseID ?>" />
                                        <input type="text" class="form-control required" id="memberName" placeholder="Member Name"  name="memberName" maxlength="255" required="required">
                                    </div>
                                </div>
								
                                <div class="col-md-6">
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

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Item Name">Age <span style="color:red">*</span></label>
                                        <input type="number" class="form-control required age" id="age" placeholder="Age" name="age">
                                    </div>
                                </div> 
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Item Name">Birth Date <span style="color:red">*</span></label>
                                        <input type="text" class="form-control required" id="birthdate" placeholder="Birth Date"  name="birthdate" maxlength="255" required="required">
                                    </div>
                                </div> 
                                <div class="col-md-6">
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

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Item Name">Mother code</label>
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
                                <div class="col-md-6">
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
								
								<div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Item Name">Entry Date <span style="color:red">*</span></label>
                                        <input type="text" class="form-control required" id="datepicker"  name="entryDate" maxlength="255" required="required">
                                    </div>
                                </div> 

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Item Name">National/ Voter Id</label>
                                        <input type="text" class="form-control" id="nationalID"  name="nationalID" maxlength="17">
                                    </div>
                                </div>

                                 <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Active">Relation with HHH  <span style="color:red">*</span></label>
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

                                <div class="col-md-6">
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
                            

                                <div class="col-md-6">
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

                                <div class="col-md-6">
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
                                <div class="col-md-6 yearEdu">
                                    <div class="form-group">
                                        <label for="Item Name">Year of Education <span style="color:red">*</span></label>
                                        <!--<input type="text" class="form-control yearOfEdu" id="yearOfEdu"  name="yearOfEdu" maxlength="255" >-->
                                        <select class="form-control required yearOfEdu" id="yearOfEdu" name="yearOfEdu">
                                            <option value="0">Please Select</option>
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

                               
                               <!-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Active">Secular education</label>
                                        <select class="form-control required" id="secularEduType" name="secularEduType" required>
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
                                </div>
                                <div class="col-md-6">
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
                                                    <option value="<?php echo $religiousedu->id ?>"><?php echo $religiousedu->code. '-' .$religiousedu->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            
                                        </select>
                                    </div>
                                </div>-->
                                <div class="col-md-6">
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
                                
                                <div class="col-md-6">
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
                                <div class="col-md-6 birthRegi">
                                    <div class="form-group">
                                        <label for="Item Name">Registration date <span style="color:red">*</span></label>
                                        <input type="text" class="form-control birthRegidate" id="birthRegidate"  name="birthRegidate" maxlength="255">
                                    </div>
                                </div>

                                 <div class="col-md-6 notRegi">
                                    <div class="form-group">
                                        <label for="Active">why not registrated<span style="color:red">*</span></label>
                                        <select class="form-control whyNotRegi" id="whyNotRegi" name="whyNotRegi">
                                            <option value="0">Please Select</option>
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

                                 <div class="col-md-6 additionalChild_Desire">
                                    <div class="form-group">
                                        <label for="Active">Desire for additional child <span style="color:red">*</span></label>
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
                                <div class="col-md-6 manyYear">
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Item Name">Contact No(One) </label>
                                        <input type="text" class="form-control" id="contactNoOne" placeholder="contact number"  name="contactNoOne" minlength="11" maxlength="11">
                                    </div>
                                </div>
								<div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Item Name">Contact No(Two) </label>
                                        <input type="text" class="form-control" id="contactNoTwo"  placeholder="contact number" name="contactNoTwo" minlength="11" maxlength="11">
                                    </div>
                                </div>


                            </div>
                        </div><!-- /.box-body -->
                       <?php if($roundStstus == 1) : ?>
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Save" />
                            <input type="reset" class="btn btn-default" value="Reset" /> 
							<div id="error" style="margin-top:10px;color:red">Please give all required data. some data are missing or inappropiate</div>
                        </div>
                       <?php endif; ?>
                    </form>
                </div>
            </div>
            
        </div>    
    </section>
    



<script type="text/javascript">


    $(document).ready(function() {

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

<script>
    $(document).ready(function(){
		
		$('#error').hide();
        $("#addUser").submit(function(e){
			
            e.preventDefault();
            //var title = $("#memberName").val();;
           // var decs = $("#birthdate").val();
			var data = $("#addUser").serializeArray();
            $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>memberMigration/addNewMemberSubmit',
				dataType: 'json',
                data: data,
                success:function(data)
                {
					if (data.success1 ==0)
					{
						$('#error').show();
					}
					else{
						//alert('Success');
						$('#error').hide();
						//$('#view-modal').hide();
						//$('#addUser').hide();
						$('#view-modal').modal('hide');
						
						//setTimeout($('#view-modal').modal('hide'), 100);
						
						//$("#view-modal").dialog("close");
						//$("#addMember").modal('close');
					}
				 // console.log(data.success1);
                    
					
                },
                error:function()
                {
                    $('#error').show();
                }
            });
        });
    });
</script>