$(function () {
    $("#Q3_9_MSTATUS").on('change', function () {
        if (this.value == 92) {
            $("#Q3_9_1_MD").val('').trigger('change');
            $(".Q3_9_MSTATUS_unmarried").hide();
            $("#Q3_9_1_MD").prop('required', false);
            $("#Q3_9_1_MD").attr('disabled', true);



        } else {
            $(".Q3_9_MSTATUS_unmarried").show();
            $("#Q3_9_1_MD").attr('disabled', false);
            $("#Q3_9_2_DOM").attr('disabled', false);
            $("#Q3_9_1_MD").prop('required', true);
            $("#Q3_9_2_DOM").prop('required', true);
        }
    });
    $("#Q3_9_1_MD").on('change', function () {
        if (this.value == 1576) {
            $("#Q3_9_2").show();
            $("#Q3_9_2_DOM").attr('disabled', false);
            $("#Q3_9_2_DOM").prop('required', true);
        } else {
            $("#Q3_9_2").hide();
            $("#Q3_9_2_DOM").prop('required', false);
            $("#Q3_9_2_DOM").attr('disabled', true);

            $("#Q3_9_2_DOM").val('');
        }
    });
    $("#Q5_1").on('change', function () {

        if (this.value==1576) {
            
            $(".Q5_1_no_reluctant_unknown").show();
            $("#Q5_1_1").attr('disabled', false);
            $("#Q5_1_1_off").attr('disabled', false);

            $("#Q5_1_5").attr('disabled', false);
            $("#Q5_1_6").attr('disabled', false);
            $("#Q5_1_7_D").attr('disabled', false);
            $("#Q5_1_7_H").attr('disabled', false);
            $("#Q5_1_8").attr('disabled', false);
        } else {
                     
            $("#Q5_1_1").val('').trigger('change');
            $("#Q5_1_1_off").val('');
            $("#Q5_1_2").val('').trigger('change');
            $("#Q5_1_2_off").val('');
            $("#Q5_1_3").val('').trigger('change');
            $("#Q5_1_3_off").val('');
            $("#Q5_1_4").val('').trigger('change');
            $("#Q5_1_5").val('').trigger('change');
            $("#Q5_1_6").val('').trigger('change');
            $("#Q5_1_7_D").val('');
            $("#Q5_1_7_H").val('');
            $("#Q5_1_8").val('').trigger('change');



            $(".Q5_1_no_reluctant_unknown").hide();



            $("#Q5_1_1").prop('required', false);
            $("#Q5_1_1_off").prop('required', false);
            $("#Q5_1_2").prop('required', false);
            $("#Q5_1_2_off").prop('required', false);
            $("#Q5_1_3").prop('required', false);
            $("#Q5_1_3_off").prop('required', false);
            $("#Q5_1_4").prop('required', false);
            $("#Q5_1_5").prop('required', false);
            $("#Q5_1_6").prop('required', false);
            $("#Q5_1_7_D").prop('required', false);
            $("#Q5_1_7_H").prop('required', false);
            $("#Q5_1_8").prop('required', false);
            $("#Q5_1_1").attr('disabled', true);
            $("#Q5_1_1_off").attr('disabled', true);
            $("#Q5_1_2").attr('disabled', true);
            $("#Q5_1_2_off").attr('disabled', true);
            $("#Q5_1_3").attr('disabled', true);
            $("#Q5_1_3_off").attr('disabled', true);
            $("#Q5_1_4").attr('disabled', true);
            $("#Q5_1_5").attr('disabled', true);
            $("#Q5_1_6").attr('disabled', true);
            $("#Q5_1_7_D").attr('disabled', true);
            $("#Q5_1_7_H").attr('disabled', true);
            $("#Q5_1_8").attr('disabled', true);
        }
    });
    $("#Q5_1_1").on('change', function () {

        $("#Q5_1_2").val('').trigger('change');
        $("#Q5_1_2_off").val('');
        $("#Q5_1_4").val('').trigger('change');
        $("#Q5_1_3_off").val('');
        $("#Q5_1_3").val('').trigger('change');

        $(".Q5_1_3_part").hide();
        $("#Q5_1_3").prop('required', false);
        $("#Q5_1_3").attr('disabled', true);
        $("#Q5_1_3_off").attr('disabled', true);

        $(".Q5_1_4_part").hide();
        $("#Q5_1_4").prop('required', false);
        $("#Q5_1_4").attr('disabled', true);

        $(".Q5_1_2_part").hide();
        $("#Q5_1_2").prop('required', false);
        $("#Q5_1_2").attr('disabled', true);
        $("#Q5_1_2_off").attr('disabled', true);




        if (this.value == 1599 || this.value == 1600) {
            $(".Q5_1_2_part").show();
            $("#Q5_1_2").prop('required', true);
            $("#Q5_1_2").attr('disabled', false);
            $("#Q5_1_2_off").attr('disabled', false);
        } else if (this.value == 1597 || this.value == 1598 || this.value == 1603 || this.value == 1604 || this.value == 1605 || this.value == 1610 || this.value == 1611) {

            $(".Q5_1_4_part").show();
            $("#Q5_1_4").prop('required', true);
            $("#Q5_1_4").attr('disabled', false);

        } else if (this.value == 1608) {

            $(".Q5_1_3_part").show();
            $("#Q5_1_3").prop('required', true);
            $("#Q5_1_3").attr('disabled', false);
            $("#Q5_1_3_off").attr('disabled', false);
        }
    });


    $("#Q5_1_2").on('change', function () {
        $("#Q5_1_4").val('').trigger('change');
        $(".Q5_1_4_part").hide();
        $("#Q5_1_4").prop('required', false);
        $("#Q5_1_4").attr('disabled', true);

        if (this.value > 0) {
            $(".Q5_1_4_part").show();
            $("#Q5_1_4").prop('required', true);
            $("#Q5_1_4").attr('disabled', false);
        }
    });

    $("#Q6_1_1").on('change', function () {
        if (this.value == 1577 || this.value == 1578 || this.value == 1579) {
            $("#Q6_1_2").hide();
            $(".Q6_1_1_reluctant").prop('required', false);
            $(".Q6_1_1_reluctant").attr('disabled', true);
        } else {
            $("#Q6_1_2").show();
            $(".Q6_1_1_reluctant").attr('disabled', false);
            $(".Q6_1_1_reluctant").prop('required', true);
        }
    });
    $("#Q6_1_3").on('change', function () {
        if (this.value == 1625 || this.value == 1626 || this.value == 1627 || this.value == 1628) {
            $(".Q6_1_4_part").hide();
            $("#Q6_1_4_M").val('');
            $("#Q6_1_4_D").val('');

            $("#Q6_1_4_M").prop('required', false);
            $("#Q6_1_4_D").prop('required', false);
            $("#Q6_1_4_M").attr('disabled', true);
            $("#Q6_1_4_D").attr('disabled', true);
        } else {
            $(".Q6_1_4_part").show();
            $("#Q6_1_4_M").attr('disabled', false);
            $("#Q6_1_4_D").attr('disabled', false);
            $("#Q6_1_4_M").prop('required', true);
            $("#Q6_1_4_D").prop('required', true);
        }
    });

    $("#Q6_1_5").on('change', function () {
        if (this.value == 1577 || this.value == 1578 || this.value == 1579) {
            $("#Q6_1_6_part").hide();
            $("#Q6_1_6").prop('required', false);
            $("#Q6_1_6").attr('disabled', true);
        } else {
            $("#Q6_1_6_part").show();
            $("#Q6_1_6").attr('disabled', false);
            $("#Q6_1_6").prop('required', true);
        }
    });

    $("#Q6_1_6").on('change', function () {
        if (this.value == 1577 || this.value == 1578 || this.value == 1579) {
            $("#Q6_1_7_part").hide();
            $("#Q6_1_7").prop('required', false);
            $("#Q6_1_7").attr('disabled', true);
        } else {
            $("#Q6_1_7_part").show();
            $("#Q6_1_7").attr('disabled', false);
            $("#Q6_1_7").prop('required', true);
        }
    });
    $("#Q6_2_3").on('change', function () {
        if (this.value == 1635) {

            $("#Q6_2_4").val('').trigger('change');
            $("#Q6_2_5").val('').trigger('change');
            $("#Q6_2_6").val('').trigger('change');
            $("#Q6_2_7_1").val('').trigger('change');
            $("#Q6_2_7_2").val('').trigger('change');
            $("#Q6_2_7_3").val('').trigger('change');
            $("#Q6_2_7_4").val('').trigger('change');
            $("#Q6_2_7_5").val('').trigger('change');
            $("#Q6_2_7_6").val('').trigger('change');
            $("#Q6_2_7_7").val('').trigger('change');
            $("#Q6_2_7_8").val('').trigger('change');
            $("#Q6_2_7_9").val('').trigger('change');
            $("#Q6_2_7_10").val('').trigger('change');
            $("#Q6_2_7_11").val('').trigger('change');
            $("#Q6_2_7_12").val('').trigger('change');
            $("#Q6_2_7_13").val('').trigger('change');
            $("#Q6_2_7_14").val('').trigger('change');
            $("#Q6_2_7_15").val('').trigger('change');
            $("#Q6_2_7_15_off").val('');
            $("#Q6_2_7A").val('').trigger('change');
            $("#Q6_2_7B").val('').trigger('change');
            $("#Q6_2_8").val('').trigger('change');
            $("#Q6_2_9").val('').trigger('change');
            $("#Q6_2_10").val('').trigger('change');
            $("#Q6_2_11_A").val('').trigger('change');
            $("#Q6_2_11_B").val('').trigger('change');
            $("#Q6_2_11_C").val('').trigger('change');
            $("#Q6_2_11_D").val('').trigger('change');
            $("#Q6_2_11_E").val('').trigger('change');
            $("#Q6_2_11_F").val('').trigger('change');
            $("#Q6_2_11_F_off").val('');
            $("#Q6_2_12").val('').trigger('change');
            $("#Q6_2_12_1").val('').trigger('change');
            $("#Q6_2_13").val('').trigger('change');
            $("#Q6_2_13_off").val('');
            $("#Q6_2_14_A").val('').trigger('change');
            $("#Q6_2_14_B").val('').trigger('change');
            $("#Q6_2_14_C").val('').trigger('change');
            $("#Q6_2_14_D").val('').trigger('change');
            $("#Q6_2_14_E").val('').trigger('change');
            $("#Q6_2_14_F").val('').trigger('change');
            $("#Q6_2_15").val('').trigger('change');
            $("#Q6_2_16").val('').trigger('change');
            $("#Q6_2_17_M").val('').trigger('change');
            $("#Q6_2_17_1").val('').trigger('change');
            $("#Q6_2_18").val('').trigger('change');

            $(".Q6_2_3_Not_Delivery").hide();


            $("#Q6_2_4").prop('required', false);
            $("#Q6_2_5").prop('required', false);
            $("#Q6_2_6").prop('required', false);
            $("#Q6_2_7_1").prop('required', false);
            $("#Q6_2_7_2").prop('required', false);
            $("#Q6_2_7_3").prop('required', false);
            $("#Q6_2_7_4").prop('required', false);
            $("#Q6_2_7_5").prop('required', false);
            $("#Q6_2_7_6").prop('required', false);
            $("#Q6_2_7_7").prop('required', false);
            $("#Q6_2_7_8").prop('required', false);
            $("#Q6_2_7_9").prop('required', false);
            $("#Q6_2_7_10").prop('required', false);
            $("#Q6_2_7_11").prop('required', false);
            $("#Q6_2_7_12").prop('required', false);
            $("#Q6_2_7_13").prop('required', false);
            $("#Q6_2_7_14").prop('required', false);
            $("#Q6_2_7_15").prop('required', false);
            $("#Q6_2_7_15_off").prop('required', false);
            $("#Q6_2_7A").prop('required', false);
            $("#Q6_2_7B").prop('required', false);
            $("#Q6_2_8").prop('required', false);
            $("#Q6_2_9").prop('required', false);
            $("#Q6_2_10").prop('required', false);
            $("#Q6_2_11_A").prop('required', false);
            $("#Q6_2_11_B").prop('required', false);
            $("#Q6_2_11_C").prop('required', false);
            $("#Q6_2_11_D").prop('required', false);
            $("#Q6_2_11_E").prop('required', false);
            $("#Q6_2_11_F").prop('required', false);
            $("#Q6_2_11_F_off").prop('required', false);
            $("#Q6_2_12").prop('required', false);
            $("#Q6_2_12_1").prop('required', false);
            $("#Q6_2_13").prop('required', false);
            $("#Q6_2_13_off").prop('required', false);
            $("#Q6_2_14_A").prop('required', false);
            $("#Q6_2_14_B").prop('required', false);
            $("#Q6_2_14_C").prop('required', false);
            $("#Q6_2_14_D").prop('required', false);
            $("#Q6_2_14_E").prop('required', false);
            $("#Q6_2_14_F").prop('required', false);
            $("#Q6_2_15").prop('required', false);
            $("#Q6_2_16").prop('required', false);
            $("#Q6_2_17_M").prop('required', false);
            $("#Q6_2_17_1").prop('required', false);
            $("#Q6_2_18").prop('required', false);

            $("#Q6_2_4").attr('disabled', true);
            $("#Q6_2_5").attr('disabled', true);
            $("#Q6_2_6").attr('disabled', true);
            $("#Q6_2_7_1").attr('disabled', true);
            $("#Q6_2_7_2").attr('disabled', true);
            $("#Q6_2_7_3").attr('disabled', true);
            $("#Q6_2_7_4").attr('disabled', true);
            $("#Q6_2_7_5").attr('disabled', true);
            $("#Q6_2_7_6").attr('disabled', true);
            $("#Q6_2_7_7").attr('disabled', true);
            $("#Q6_2_7_8").attr('disabled', true);
            $("#Q6_2_7_9").attr('disabled', true);
            $("#Q6_2_7_10").attr('disabled', true);
            $("#Q6_2_7_11").attr('disabled', true);
            $("#Q6_2_7_12").attr('disabled', true);
            $("#Q6_2_7_13").attr('disabled', true);
            $("#Q6_2_7_14").attr('disabled', true);
            $("#Q6_2_7_15").attr('disabled', true);
            $("#Q6_2_7_15_off").attr('disabled', true);
            $("#Q6_2_7A").attr('disabled', true);
            $("#Q6_2_7B").attr('disabled', true);
            $("#Q6_2_8").attr('disabled', true);
            $("#Q6_2_9").attr('disabled', true);
            $("#Q6_2_10").attr('disabled', true);
            $("#Q6_2_11_A").attr('disabled', true);
            $("#Q6_2_11_B").attr('disabled', true);
            $("#Q6_2_11_C").attr('disabled', true);
            $("#Q6_2_11_D").attr('disabled', true);
            $("#Q6_2_11_E").attr('disabled', true);
            $("#Q6_2_11_F").attr('disabled', true);
            $("#Q6_2_11_F_off").attr('disabled', true);
            $("#Q6_2_12").attr('disabled', true);
            $("#Q6_2_12_1").attr('disabled', true);
            $("#Q6_2_13").attr('disabled', true);
            $("#Q6_2_13_off").attr('disabled', true);
            $("#Q6_2_14_A").attr('disabled', true);
            $("#Q6_2_14_B").attr('disabled', true);
            $("#Q6_2_14_C").attr('disabled', true);
            $("#Q6_2_14_D").attr('disabled', true);
            $("#Q6_2_14_E").attr('disabled', true);
            $("#Q6_2_14_F").attr('disabled', true);
            $("#Q6_2_15").attr('disabled', true);
            $("#Q6_2_16").attr('disabled', true);
            $("#Q6_2_17_M").attr('disabled', true);
            $("#Q6_2_17_1").attr('disabled', true);
            $("#Q6_2_18").attr('disabled', true);
        } else {
            $(".Q6_2_3_Not_Delivery").show();
            $("#Q6_2_4").prop('required', true);
            $("#Q6_2_5").prop('required', true);
            $("#Q6_2_6").prop('required', true);
            $("#Q6_2_7_1").prop('required', true);
            $("#Q6_2_7_2").prop('required', true);
            $("#Q6_2_7_3").prop('required', true);
            $("#Q6_2_7_4").prop('required', true);
            $("#Q6_2_7_5").prop('required', true);
            $("#Q6_2_7_6").prop('required', true);
            $("#Q6_2_7_7").prop('required', true);
            $("#Q6_2_7_8").prop('required', true);
            $("#Q6_2_7_9").prop('required', true);
            $("#Q6_2_7_10").prop('required', true);
            $("#Q6_2_7_11").prop('required', true);
            $("#Q6_2_7_12").prop('required', true);
            $("#Q6_2_7_13").prop('required', true);
            $("#Q6_2_7_14").prop('required', true);
            $("#Q6_2_7_15").prop('required', true);
//            $("#Q6_2_7_15_off").prop('required', true);
            $("#Q6_2_7A").prop('required', true);
            $("#Q6_2_7B").prop('required', true);
            $("#Q6_2_8").prop('required', true);
            $("#Q6_2_9").prop('required', true);
            $("#Q6_2_10").prop('required', true);
            $("#Q6_2_11_A").prop('required', true);
            $("#Q6_2_11_B").prop('required', true);
            $("#Q6_2_11_C").prop('required', true);
            $("#Q6_2_11_D").prop('required', true);
            $("#Q6_2_11_E").prop('required', true);
            $("#Q6_2_11_F").prop('required', true);
//            $("#Q6_2_11_F_off").prop('required', true);
            $("#Q6_2_12").prop('required', true);
            $("#Q6_2_12_1").prop('required', true);
            $("#Q6_2_13").prop('required', true);
//            $("#Q6_2_13_off").prop('required', true);
            $("#Q6_2_14_A").prop('required', true);
            $("#Q6_2_14_B").prop('required', true);
            $("#Q6_2_14_C").prop('required', true);
            $("#Q6_2_14_D").prop('required', true);
            $("#Q6_2_14_E").prop('required', true);
            $("#Q6_2_14_F").prop('required', true);
            $("#Q6_2_15").prop('required', true);
            $("#Q6_2_16").prop('required', true);
            $("#Q6_2_17_M").prop('required', true);
            $("#Q6_2_17_1").prop('required', true);
            $("#Q6_2_18").prop('required', true);

            $("#Q6_2_4").attr('disabled', false);
            $("#Q6_2_5").attr('disabled', false);
            $("#Q6_2_6").attr('disabled', false);
            $("#Q6_2_7_1").attr('disabled', false);
            $("#Q6_2_7_2").attr('disabled', false);
            $("#Q6_2_7_3").attr('disabled', false);
            $("#Q6_2_7_4").attr('disabled', false);
            $("#Q6_2_7_5").attr('disabled', false);
            $("#Q6_2_7_6").attr('disabled', false);
            $("#Q6_2_7_7").attr('disabled', false);
            $("#Q6_2_7_8").attr('disabled', false);
            $("#Q6_2_7_9").attr('disabled', false);
            $("#Q6_2_7_10").attr('disabled', false);
            $("#Q6_2_7_11").attr('disabled', false);
            $("#Q6_2_7_12").attr('disabled', false);
            $("#Q6_2_7_13").attr('disabled', false);
            $("#Q6_2_7_14").attr('disabled', false);
            $("#Q6_2_7_15").attr('disabled', false);
            $("#Q6_2_7_15_off").attr('disabled', false);
            $("#Q6_2_7A").attr('disabled', false);
            $("#Q6_2_7B").attr('disabled', false);
            $("#Q6_2_8").attr('disabled', false);
            $("#Q6_2_9").attr('disabled', false);
            $("#Q6_2_10").attr('disabled', false);
            $("#Q6_2_11_A").attr('disabled', false);
            $("#Q6_2_11_B").attr('disabled', false);
            $("#Q6_2_11_C").attr('disabled', false);
            $("#Q6_2_11_D").attr('disabled', false);
            $("#Q6_2_11_E").attr('disabled', false);
            $("#Q6_2_11_F").attr('disabled', false);
            $("#Q6_2_11_F_off").attr('disabled', false);
            $("#Q6_2_12").attr('disabled', false);
            $("#Q6_2_12_1").attr('disabled', false);
            $("#Q6_2_13").attr('disabled', false);
            $("#Q6_2_13_off").attr('disabled', false);
            $("#Q6_2_14_A").attr('disabled', false);
            $("#Q6_2_14_B").attr('disabled', false);
            $("#Q6_2_14_C").attr('disabled', false);
            $("#Q6_2_14_D").attr('disabled', false);
            $("#Q6_2_14_E").attr('disabled', false);
            $("#Q6_2_14_F").attr('disabled', false);
            $("#Q6_2_15").attr('disabled', false);
            $("#Q6_2_16").attr('disabled', false);
            $("#Q6_2_17_M").attr('disabled', false);
            $("#Q6_2_17_1").attr('disabled', false);
            $("#Q6_2_18").attr('disabled', false);
        }
    });
    
    
    $("#Q6_2_8").on('change', function () {
        if (this.value == 2025) {

            
            $("#Q6_2_9").val('').trigger('change');
            $("#Q6_2_10").val('').trigger('change');
            $("#Q6_2_11_A").val('').trigger('change');
            $("#Q6_2_11_B").val('').trigger('change');
            $("#Q6_2_11_C").val('').trigger('change');
            $("#Q6_2_11_D").val('').trigger('change');
            $("#Q6_2_11_E").val('').trigger('change');
            $("#Q6_2_11_F").val('').trigger('change');
            $("#Q6_2_11_F_off").val('');
            $("#Q6_2_12").val('').trigger('change');
            $("#Q6_2_12_1").val('').trigger('change');
            $("#Q6_2_13").val('').trigger('change');
            $("#Q6_2_13_off").val('');
            $("#Q6_2_14_A").val('').trigger('change');
            $("#Q6_2_14_B").val('').trigger('change');
            $("#Q6_2_14_C").val('').trigger('change');
            $("#Q6_2_14_D").val('').trigger('change');
            $("#Q6_2_14_E").val('').trigger('change');
            $("#Q6_2_14_F").val('').trigger('change');
            $("#Q6_2_15").val('').trigger('change');
            $("#Q6_2_16").val('').trigger('change');
            $("#Q6_2_17_M").val('').trigger('change');
            $("#Q6_2_17_1").val('').trigger('change');
            $("#Q6_2_18").val('').trigger('change');

            $(".Q6_2_8_part").hide();


            
            $("#Q6_2_9").prop('required', false);
            $("#Q6_2_10").prop('required', false);
            $("#Q6_2_11_A").prop('required', false);
            $("#Q6_2_11_B").prop('required', false);
            $("#Q6_2_11_C").prop('required', false);
            $("#Q6_2_11_D").prop('required', false);
            $("#Q6_2_11_E").prop('required', false);
            $("#Q6_2_11_F").prop('required', false);
            $("#Q6_2_11_F_off").prop('required', false);
            $("#Q6_2_12").prop('required', false);
            $("#Q6_2_12_1").prop('required', false);
            $("#Q6_2_13").prop('required', false);
            $("#Q6_2_13_off").prop('required', false);
            $("#Q6_2_14_A").prop('required', false);
            $("#Q6_2_14_B").prop('required', false);
            $("#Q6_2_14_C").prop('required', false);
            $("#Q6_2_14_D").prop('required', false);
            $("#Q6_2_14_E").prop('required', false);
            $("#Q6_2_14_F").prop('required', false);
            $("#Q6_2_15").prop('required', false);
            $("#Q6_2_16").prop('required', false);
            $("#Q6_2_17_M").prop('required', false);
            $("#Q6_2_17_1").prop('required', false);
            $("#Q6_2_18").prop('required', false);

            
            $("#Q6_2_9").attr('disabled', true);
            $("#Q6_2_10").attr('disabled', true);
            $("#Q6_2_11_A").attr('disabled', true);
            $("#Q6_2_11_B").attr('disabled', true);
            $("#Q6_2_11_C").attr('disabled', true);
            $("#Q6_2_11_D").attr('disabled', true);
            $("#Q6_2_11_E").attr('disabled', true);
            $("#Q6_2_11_F").attr('disabled', true);
            $("#Q6_2_11_F_off").attr('disabled', true);
            $("#Q6_2_12").attr('disabled', true);
            $("#Q6_2_12_1").attr('disabled', true);
            $("#Q6_2_13").attr('disabled', true);
            $("#Q6_2_13_off").attr('disabled', true);
            $("#Q6_2_14_A").attr('disabled', true);
            $("#Q6_2_14_B").attr('disabled', true);
            $("#Q6_2_14_C").attr('disabled', true);
            $("#Q6_2_14_D").attr('disabled', true);
            $("#Q6_2_14_E").attr('disabled', true);
            $("#Q6_2_14_F").attr('disabled', true);
            $("#Q6_2_15").attr('disabled', true);
            $("#Q6_2_16").attr('disabled', true);
            $("#Q6_2_17_M").attr('disabled', true);
            $("#Q6_2_17_1").attr('disabled', true);
            $("#Q6_2_18").attr('disabled', true);
        } else {
            $(".Q6_2_8_part").show();
            
            $("#Q6_2_9").prop('required', true);
            $("#Q6_2_10").prop('required', true);
            $("#Q6_2_11_A").prop('required', true);
            $("#Q6_2_11_B").prop('required', true);
            $("#Q6_2_11_C").prop('required', true);
            $("#Q6_2_11_D").prop('required', true);
            $("#Q6_2_11_E").prop('required', true);
            $("#Q6_2_11_F").prop('required', true);
//            $("#Q6_2_11_F_off").prop('required', true);
            $("#Q6_2_12").prop('required', true);
            $("#Q6_2_12_1").prop('required', true);
            $("#Q6_2_13").prop('required', true);
//            $("#Q6_2_13_off").prop('required', true);
            $("#Q6_2_14_A").prop('required', true);
            $("#Q6_2_14_B").prop('required', true);
            $("#Q6_2_14_C").prop('required', true);
            $("#Q6_2_14_D").prop('required', true);
            $("#Q6_2_14_E").prop('required', true);
            $("#Q6_2_14_F").prop('required', true);
            $("#Q6_2_15").prop('required', true);
            $("#Q6_2_16").prop('required', true);
            $("#Q6_2_17_M").prop('required', true);
            $("#Q6_2_17_1").prop('required', true);
            $("#Q6_2_18").prop('required', true);

            
            $("#Q6_2_9").attr('disabled', false);
            $("#Q6_2_10").attr('disabled', false);
            $("#Q6_2_11_A").attr('disabled', false);
            $("#Q6_2_11_B").attr('disabled', false);
            $("#Q6_2_11_C").attr('disabled', false);
            $("#Q6_2_11_D").attr('disabled', false);
            $("#Q6_2_11_E").attr('disabled', false);
            $("#Q6_2_11_F").attr('disabled', false);
            $("#Q6_2_11_F_off").attr('disabled', false);
            $("#Q6_2_12").attr('disabled', false);
            $("#Q6_2_12_1").attr('disabled', false);
            $("#Q6_2_13").attr('disabled', false);
            $("#Q6_2_13_off").attr('disabled', false);
            $("#Q6_2_14_A").attr('disabled', false);
            $("#Q6_2_14_B").attr('disabled', false);
            $("#Q6_2_14_C").attr('disabled', false);
            $("#Q6_2_14_D").attr('disabled', false);
            $("#Q6_2_14_E").attr('disabled', false);
            $("#Q6_2_14_F").attr('disabled', false);
            $("#Q6_2_15").attr('disabled', false);
            $("#Q6_2_16").attr('disabled', false);
            $("#Q6_2_17_M").attr('disabled', false);
            $("#Q6_2_17_1").attr('disabled', false);
            $("#Q6_2_18").attr('disabled', false);
        }
    });
    
    

    $("#Q6_2_13").on('change', function () {
        if (this.value == 1651 || this.value == 1652 || this.value == 1653 || this.value == 1654 || this.value == 1655 || this.value == 1657) {

            $("#Q6_2_14_A").val('').trigger('change');
            $("#Q6_2_14_B").val('').trigger('change');
            $("#Q6_2_14_C").val('').trigger('change');
            $("#Q6_2_14_D").val('').trigger('change');
            $("#Q6_2_14_E").val('').trigger('change');
            $("#Q6_2_14_F").val('').trigger('change');

            $(".Q6_2_14_part").hide();

            $("#Q6_2_14_A").prop('required', false);
            $("#Q6_2_14_B").prop('required', false);
            $("#Q6_2_14_C").prop('required', false);
            $("#Q6_2_14_D").prop('required', false);
            $("#Q6_2_14_E").prop('required', false);
            $("#Q6_2_14_F").prop('required', false);

            $("#Q6_2_14_A").attr('disabled', true);
            $("#Q6_2_14_B").attr('disabled', true);
            $("#Q6_2_14_C").attr('disabled', true);
            $("#Q6_2_14_D").attr('disabled', true);
            $("#Q6_2_14_E").attr('disabled', true);
            $("#Q6_2_14_F").attr('disabled', true);
        } else {
            $(".Q6_2_14_part").show();
            $("#Q6_2_14_A").prop('required', true);
            $("#Q6_2_14_B").prop('required', true);
            $("#Q6_2_14_C").prop('required', true);
            $("#Q6_2_14_D").prop('required', true);
            $("#Q6_2_14_E").prop('required', true);
            $("#Q6_2_14_F").prop('required', true);

            $("#Q6_2_14_A").attr('disabled', false);
            $("#Q6_2_14_B").attr('disabled', false);
            $("#Q6_2_14_C").attr('disabled', false);
            $("#Q6_2_14_D").attr('disabled', false);
            $("#Q6_2_14_E").attr('disabled', false);
            $("#Q6_2_14_F").attr('disabled', false);
        }
    });

    $("#Q7_1_1").on('change', function () {
        //alert(this.value);
        if (this.value == 1576) {
            $(".Q7_1_1_no_reluctant_unknown").show();

            var IDList_show = ["Q7_1_2_D", "Q7_1_3", "Q7_1_4", "Q7_1_5", "Q7_1_6", "Q7_1_7"];

            IDList_show.forEach(EnableFields);

        } else {
            $("#Q7_1_2_D").val('');
            $("#Q7_1_3").val('').trigger('change');
            $("#Q7_1_4").val('').trigger('change');
            $("#Q7_1_5").val('').trigger('change');
            $("#Q7_1_6").val('').trigger('change');
            $("#Q7_1_7").val('').trigger('change');

            var IDList_off = ["Q7_1_2_D", "Q7_1_3", "Q7_1_4", "Q7_1_5", "Q7_1_6", "Q7_1_7"];

            IDList_off.forEach(DisableFields);
            $(".Q7_1_1_no_reluctant_unknown").hide();

        }
    });


    $("#Q7_2_1").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_2_1_no_reluctant_unknown").show();
            var IDList_show = ["Q7_2_2", "Q7_2_2_off", "Q7_2_3_D", "Q7_2_4"];
            IDList_show.forEach(EnableFields);
        } else {
            $("#Q7_2_2").val('').trigger('change');
            $("#Q7_2_2_off").val('');
            $("#Q7_2_3_D").val('');
            $("#Q7_2_4").val('').trigger('change');

            var IDList_off = ["Q7_2_2", "Q7_2_2_off", "Q7_2_3_D", "Q7_2_4"];

            IDList_off.forEach(DisableFields);
            $(".Q7_2_1_no_reluctant_unknown").hide();

        }
    });

    $("#Q7_2_7").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_2_8_no_reluctant_unknown").show();
            var IDList_show = ["Q7_2_8_A", "Q7_2_8_B", "Q7_2_8_C", "Q7_2_8_D", "Q7_2_8_E", "Q7_2_8_F", "Q7_2_8_F_off"];
            IDList_show.forEach(EnableFields);
        } else {
            $("#Q7_2_8_A").val('').trigger('change');
            $("#Q7_2_8_B").val('').trigger('change');
            $("#Q7_2_8_C").val('').trigger('change');
            $("#Q7_2_8_D").val('').trigger('change');
            $("#Q7_2_8_E").val('').trigger('change');
            $("#Q7_2_8_F").val('').trigger('change');
            $("#Q7_2_8_F_off").val('');

            var IDList_off = ["Q7_2_8_A", "Q7_2_8_B", "Q7_2_8_C", "Q7_2_8_D", "Q7_2_8_E", "Q7_2_8_F", "Q7_2_8_F_off"];

            IDList_off.forEach(DisableFields);
            $(".Q7_2_8_no_reluctant_unknown").hide();

        }
    });

    $("#Q7_2_12").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_2_12_no_reluctant_unknown").show();
            var IDList_show = ["Q7_2_13"];
            IDList_show.forEach(EnableFields);
        } else {
            $("#Q7_2_13").val('').trigger('change');

            var IDList_off = ["Q7_2_13"];

            IDList_off.forEach(DisableFields);
            $(".Q7_2_12_no_reluctant_unknown").hide();

        }
    });

    $("#Q7_2_13").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_2_13_no_reluctant_unknown").show();
            var IDList_show = ["Q7_2_14_D"];
            IDList_show.forEach(EnableFields);
        } else {
            $("#Q7_2_14_D").val('').trigger('change');

            var IDList_off = ["Q7_2_14_D"];

            IDList_off.forEach(DisableFields);
            $(".Q7_2_13_no_reluctant_unknown").hide();

        }
    });

    $("#Q7_3_3").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_3_3_no_reluctant_unknown").show();
            var IDList_show = ["Q7_3_4_Y", "Q7_3_4_M"];
            IDList_show.forEach(EnableFields);
        } else {
            $("#Q7_3_4_Y").val('').trigger('change');
            $("#Q7_3_4_M").val('').trigger('change');

            var IDList_off = ["Q7_3_4_Y", "Q7_3_4_M"];

            IDList_off.forEach(DisableFields);
            $(".Q7_3_3_no_reluctant_unknown").hide();

        }
    });

    $("#Q7_3_5").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_3_5_no_reluctant_unknown").show();
            var IDList_show = ["Q7_3_6", "Q7_3_6_off"];
            IDList_show.forEach(EnableFields);
        } else {
            $("#Q7_3_6").val('').trigger('change');
            $("#Q7_3_6_off").val('');

            var IDList_off = ["Q7_3_6", "Q7_3_6_off"];

            IDList_off.forEach(DisableFields);
            $(".Q7_3_5_no_reluctant_unknown").hide();

        }
    });

    $("#Q7_3_7").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_3_7_no_reluctant_unknown").show();
            var IDList_show = ["Q7_3_8_A", "Q7_3_8_B", "Q7_3_8_C", "Q7_3_8_D", "Q7_3_8_E", "Q7_3_8_F", "Q7_3_8_G", "Q7_3_8_G_off"];
            IDList_show.forEach(EnableFields);
        } else {
            $("#Q7_3_8_A").val('').trigger('change');
            $("#Q7_3_8_B").val('').trigger('change');
            $("#Q7_3_8_C").val('').trigger('change');
            $("#Q7_3_8_D").val('').trigger('change');
            $("#Q7_3_8_E").val('').trigger('change');
            $("#Q7_3_8_F").val('').trigger('change');
            $("#Q7_3_8_G").val('').trigger('change');
            $("#Q7_3_8_G_off").val('');

            var IDList_off = ["Q7_3_8_A", "Q7_3_8_B", "Q7_3_8_C", "Q7_3_8_D", "Q7_3_8_E", "Q7_3_8_F", "Q7_3_8_G", "Q7_3_8_G_off"];

            IDList_off.forEach(DisableFields);
            $(".Q7_3_7_no_reluctant_unknown").hide();

        }
    });

    $("#Q7_4_1").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_4_1_no_reluctant_unknown").show();
            var IDList_show = ["Q7_4_2_M", "Q7_4_2_D", "Q7_4_3"];
            IDList_show.forEach(EnableFields);
        } else {
            $("#Q7_4_2_M").val('').trigger('change');
            $("#Q7_4_2_D").val('').trigger('change');
            $("#Q7_4_3").val('').trigger('change');

            var IDList_off = ["Q7_4_2_M", "Q7_4_2_D", "Q7_4_3"];

            IDList_off.forEach(DisableFields);
            $(".Q7_4_1_no_reluctant_unknown").hide();

        }
    });

    $("#Q7_4_5").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_4_5_no_reluctant_unknown").show();
            var IDList_show = ["Q7_4_6_M", "Q7_4_6_D"];
            IDList_show.forEach(EnableFields);
        } else {
            $("#Q7_4_6_M").val('').trigger('change');
            $("#Q7_4_6_D").val('').trigger('change');

            var IDList_off = ["Q7_4_6_M", "Q7_4_6_D"];

            IDList_off.forEach(DisableFields);
            $(".Q7_4_5_no_reluctant_unknown").hide();

        }
    });

    $("#Q7_5_1").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_5_1_no_reluctant_unknown").show();
            var IDList_show = ["Q7_5_2_M", "Q7_5_2_D"];
            IDList_show.forEach(EnableFields);
        } else {
            $("#Q7_5_2_M").val('').trigger('change');
            $("#Q7_5_2_D").val('').trigger('change');

            var IDList_off = ["Q7_5_2_M", "Q7_5_2_D"];

            IDList_off.forEach(DisableFields);
            $(".Q7_5_1_no_reluctant_unknown").hide();

        }
    });

    $("#Q7_5_3").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_5_3_no_reluctant_unknown").show();
            var IDList_show = ["Q7_5_4_D", "Q7_5_5"];
            IDList_show.forEach(EnableFields);
        } else {
            $("#Q7_5_4_D").val('').trigger('change');
            $("#Q7_5_5").val('').trigger('change');

            var IDList_off = ["Q7_5_4_D", "Q7_5_5"];

            IDList_off.forEach(DisableFields);
            $(".Q7_5_3_no_reluctant_unknown").hide();

        }
    });

    $("#Q7_6_1").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_6_1_no_reluctant_unknown").show();
            var IDList_show =
                    ["Q7_6_2_A", "Q7_6_2_B", "Q7_6_2_C", "Q7_6_2_D", "Q7_6_2_E", "Q7_6_2_F",
                        "Q7_6_2_G", "Q7_6_2_G_off", "Q7_6_3_M", "Q7_6_3_D", "Q7_6_4", "Q7_6_4_off"];
            IDList_show.forEach(EnableFields);
        } else {
            $("#Q7_6_2_A").val('').trigger('change');
            $("#Q7_6_2_B").val('').trigger('change');
            $("#Q7_6_2_C").val('').trigger('change');
            $("#Q7_6_2_D").val('').trigger('change');
            $("#Q7_6_2_E").val('').trigger('change');
            $("#Q7_6_2_F").val('').trigger('change');
            $("#Q7_6_2_G").val('').trigger('change');
            $("#Q7_6_2_G_off").val('');
            $("#Q7_6_3_M").val('').trigger('change');
            $("#Q7_6_3_D").val('').trigger('change');
            $("#Q7_6_4").val('').trigger('change');
            $("#Q7_6_4_off").val('');

            var IDList_off = ["Q7_6_2_A", "Q7_6_2_B", "Q7_6_2_C", "Q7_6_2_D", "Q7_6_2_E", "Q7_6_2_F", "Q7_6_2_G", "Q7_6_2_G_off", "Q7_6_3_M", "Q7_6_3_D", "Q7_6_4", "Q7_6_4_off"];

            IDList_off.forEach(DisableFields);
            $(".Q7_6_1_no_reluctant_unknown").hide();

        }
    });

    $("#Q7_6_5").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_6_5_no_reluctant_unknown").show();
            var IDList_show =
                    ["Q7_6_6_M", "Q7_6_6_D", "Q7_6_7"];
            IDList_show.forEach(EnableFields);
        } else {
            $("#Q7_6_6_M").val('').trigger('change');
            $("#Q7_6_6_D").val('').trigger('change');
            $("#Q7_6_7").val('').trigger('change');

            var IDList_off = ["Q7_6_6_M", "Q7_6_6_D", "Q7_6_7"];
            IDList_off.forEach(DisableFields);
            $(".Q7_6_5_no_reluctant_unknown").hide();

        }
    });

    $("#Q7_7_1").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_7_1_no_reluctant_unknown").show();
            var IDList_show =
                    ["Q7_7_2_M", "Q7_7_2_D", "Q7_7_3", "Q7_7_4", "Q7_7_5"];
            IDList_show.forEach(EnableFields);
        } else {
            $("#Q7_7_2_M").val('').trigger('change');
            $("#Q7_7_2_D").val('').trigger('change');
            $("#Q7_7_3").val('').trigger('change');
            $("#Q7_7_4").val('').trigger('change');
            $("#Q7_7_5").val('').trigger('change');

            var IDList_off = ["Q7_7_2_M", "Q7_7_2_D", "Q7_7_3", "Q7_7_4", "Q7_7_5"];
            IDList_off.forEach(DisableFields);
            $(".Q7_7_1_no_reluctant_unknown").hide();

        }
    });

    $("#Q7_8_1").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_8_1_no_reluctant_unknown").show();
            var IDList_show =
                    ["Q7_8_2_M", "Q7_8_2_D", "Q7_8_3"];
            IDList_show.forEach(EnableFields);
        } else {
            $("#Q7_8_2_M").val('').trigger('change');
            $("#Q7_8_2_D").val('').trigger('change');
            $("#Q7_8_3").val('').trigger('change');

            var IDList_off = ["Q7_8_2_M", "Q7_8_2_D", "Q7_8_3"];
            IDList_off.forEach(DisableFields);
            $(".Q7_8_1_no_reluctant_unknown").hide();

        }
    });

    $("#Q7_8_4").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_8_4_no_reluctant_unknown").show();
            var IDList_show =
                    ["Q7_8_5_M", "Q7_8_5_D"];
            IDList_show.forEach(EnableFields);
        } else {
            $("#Q7_8_5_M").val('').trigger('change');
            $("#Q7_8_5_D").val('').trigger('change');

            var IDList_off = ["Q7_8_5_M", "Q7_8_5_D"];
            IDList_off.forEach(DisableFields);
            $(".Q7_8_4_no_reluctant_unknown").hide();

        }
    });

    $("#Q7_8_6").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_8_6_no_reluctant_unknown").show();
            var IDList_show =
                    ["Q7_8_7_M", "Q7_8_7_D"];
            IDList_show.forEach(EnableFields);
        } else {
            $("#Q7_8_7_M").val('').trigger('change');
            $("#Q7_8_7_D").val('').trigger('change');

            var IDList_off = ["Q7_8_7_M", "Q7_8_7_D"];
            IDList_off.forEach(DisableFields);
            $(".Q7_8_6_no_reluctant_unknown").hide();

        }
    });

    $("#Q7_8_8").on('change', function () {
        if (this.value == 1850) {
            $(".Q7_8_8_no_NoBreathingProblem_unknown").show();
            var IDList_show =
                    ["Q7_8_9", "Q7_8_10", "Q7_8_11"];
            IDList_show.forEach(EnableFields);
        } else {
            $("#Q7_8_9").val('').trigger('change');
            $("#Q7_8_10").val('').trigger('change');
            $("#Q7_8_11").val('').trigger('change');

            var IDList_off = ["Q7_8_9", "Q7_8_10", "Q7_8_11"];
            ;
            IDList_off.forEach(DisableFields);
            $(".Q7_8_8_no_NoBreathingProblem_unknown").hide();

        }
    });

    $("#Q7_9_1").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_9_1_no_reluctant_unknown").show();
            var IDList_show =
                    ["Q7_9_2_D", "Q7_9_3", "Q7_9_3_off", "Q7_9_4", "Q7_9_5", "Q7_9_6", "Q7_9_7", "Q7_9_8", "Q7_9_9"];
            IDList_show.forEach(EnableFields);
        } else {
            $("#Q7_9_2_D").val('').trigger('change');
            $("#Q7_9_3").val('').trigger('change');
            $("#Q7_9_3_off").val('').trigger('change');
            $("#Q7_9_4").val('').trigger('change');
            $("#Q7_9_5").val('').trigger('change');
            $("#Q7_9_6").val('').trigger('change');
            $("#Q7_9_7").val('').trigger('change');
            $("#Q7_9_8").val('').trigger('change');
            $("#Q7_9_9").val('').trigger('change');

            var IDList_off = ["Q7_9_2_D", "Q7_9_3", "Q7_9_3_off", "Q7_9_4", "Q7_9_5", "Q7_9_6", "Q7_9_7", "Q7_9_8", "Q7_9_9"];
            IDList_off.forEach(DisableFields);
            $(".Q7_9_1_no_reluctant_unknown").hide();

        }
    });

    $("#Q7_10_1").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_10_1_no_reluctant_unknown").show();
            var IDList_show =
                    ["Q7_10_2_D", "Q7_10_3", "Q7_10_4_N"];
            IDList_show.forEach(EnableFields);
        } else {

            var IDList_off = ["Q7_10_2_D", "Q7_10_3", "Q7_10_4_N"];
            IDList_off.forEach(DisableFields);
            $(".Q7_10_1_no_reluctant_unknown").hide();

        }
    });

    $("#Q7_10_5").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_10_5_no_reluctant_unknown").show();
            var IDList_show =
                    ["Q7_10_6"];
            IDList_show.forEach(EnableFields);
        } else {

            var IDList_off = ["Q7_10_6"];
            IDList_off.forEach(DisableFields);
            $(".Q7_10_5_no_reluctant_unknown").hide();

        }
    });

    $("#Q7_11_1").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_11_1_no_reluctant_unknown").show();
            var IDList_show =
                    ["Q7_11_2_D", "Q7_11_3_N", "Q7_11_4", "Q7_11_4_off"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q7_11_2_D", "Q7_11_3_N", "Q7_11_4", "Q7_11_4_off"];
            IDList_off.forEach(DisableFields);
            $(".Q7_11_1_no_reluctant_unknown").hide();

        }
    });

    $("#Q7_12_1").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_12_1_no_reluctant_unknown").show();
            var IDList_show =
                    ["Q7_12_2", "Q7_12_2_off", "Q7_12_3_M", "Q7_12_3_D", "Q7_12_4", "Q7_12_5", "Q7_12_6", "Q7_12_7", "Q7_12_8", "Q7_12_8_off"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q7_12_2", "Q7_12_2_off", "Q7_12_3_M", "Q7_12_3_D", "Q7_12_4", "Q7_12_5", "Q7_12_6", "Q7_12_7", "Q7_12_8", "Q7_12_8_off"];
            IDList_off.forEach(DisableFields);
            $(".Q7_12_1_no_reluctant_unknown").hide();

        }
    });

    $("#Q7_12_7").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_12_7_no_reluctant_unknown").show();
            var IDList_show =
                    ["Q7_12_8", "Q7_12_8_off"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q7_12_8", "Q7_12_8_off"];
            IDList_off.forEach(DisableFields);
            $(".Q7_12_7_no_reluctant_unknown").hide();

        }
    });

    $("#Q7_13_1").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_13_1_no_reluctant_unknown").show();
            var IDList_show =
                    ["Q7_13_2_M", "Q7_13_2_D", "Q7_13_3", "Q7_13_4", "Q7_13_5", "Q7_13_6_M", "Q7_13_6_D"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q7_13_2_M", "Q7_13_2_D", "Q7_13_3", "Q7_13_4", "Q7_13_5", "Q7_13_6_M", "Q7_13_6_D"];
            IDList_off.forEach(DisableFields);
            $(".Q7_13_1_no_reluctant_unknown").hide();

        }
    });

    $("#Q7_13_5").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_13_5_no_reluctant_unknown").show();
            var IDList_show =
                    ["Q7_13_6_M", "Q7_13_6_D"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q7_13_6_M", "Q7_13_6_D"];
            IDList_off.forEach(DisableFields);
            $(".Q7_13_5_no_reluctant_unknown").hide();

        }
    });
    $("#Q7_14_1").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_14_1_no_reluctant_unknown").show();
            var IDList_show =
                    ["Q7_14_2_M", "Q7_14_2_D"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q7_14_2_M", "Q7_14_2_D"];
            IDList_off.forEach(DisableFields);
            $(".Q7_14_1_no_reluctant_unknown").hide();

        }
    });

    $("#Q7_14_3").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_14_3_no_reluctant_unknown").show();
            var IDList_show =
                    ["Q7_14_4_M", "Q7_14_4_D"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q7_14_4_M", "Q7_14_4_D"];
            IDList_off.forEach(DisableFields);
            $(".Q7_14_3_no_reluctant_unknown").hide();

        }
    });

    $("#Q7_15_1").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_15_1_no_reluctant_unknown").show();
            var IDList_show =
                    ["Q7_15_2", "Q7_15_2_off", "Q7_15_3", "Q7_15_4_M", "Q7_15_4_D"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q7_15_2", "Q7_15_2_off", "Q7_15_3", "Q7_15_4_M", "Q7_15_4_D"];
            IDList_off.forEach(DisableFields);
            $(".Q7_15_1_no_reluctant_unknown").hide();

        }
    });

    $("#Q7_16_1").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_16_1_no_reluctant_unknown").show();
            var IDList_show =
                    ["Q7_16_2_M", "Q7_16_2_D", "Q7_16_3", "Q7_16_4"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q7_16_2_M", "Q7_16_2_D", "Q7_16_3", "Q7_16_4"];
            IDList_off.forEach(DisableFields);
            $(".Q7_16_1_no_reluctant_unknown").hide();

        }
    });

        $("#Q7_17_1").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_17_1_no_reluctant_unknown").show();
            var IDList_show =
                    ["Q7_17_2_D", "Q7_17_3"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q7_17_2_D", "Q7_17_3"];
            IDList_off.forEach(DisableFields);
            $(".Q7_17_1_no_reluctant_unknown").hide();

        }
        $("#Q7_17_3").val('').trigger('change');
    });
    
    $("#Q7_17_3").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_17_3_yes_part").show();
            var IDList_show =
                    ["Q7_17_4_M", "Q7_17_4_D", "Q7_17_5", "Q7_17_6"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q7_17_4_M", "Q7_17_4_D", "Q7_17_5", "Q7_17_6"];
            IDList_off.forEach(DisableFields);
            $(".Q7_17_3_yes_part").hide();

        }
    });

    $("#Q7_18_1").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_18_1_no_reluctant_unknown").show();
            var IDList_show =
                    ["Q7_18_2_D", "Q7_18_2_H", "Q7_18_3", "Q7_18_4"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q7_18_2_D", "Q7_18_2_H", "Q7_18_3", "Q7_18_4"];
            IDList_off.forEach(DisableFields);
            $(".Q7_18_1_no_reluctant_unknown").hide();

        }
    });

    $("#Q7_19_0").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_19_0_no_reluctant_unknown").show();
            var IDList_show =
                    ["Q7_19_1_M", "Q7_19_1_D"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q7_19_1_M", "Q7_19_1_D"];
            IDList_off.forEach(DisableFields);
            $(".Q7_19_0_no_reluctant_unknown").hide();

        }
    });

    $("#Q7_19_2").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_19_2_no_reluctant_unknown").show();
            var IDList_show =
                    ["Q7_19_3_M", "Q7_19_3_D", "Q7_19_3_H", "Q7_19_4", "Q7_19_5_N", "Q7_19_6", "Q7_19_7"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q7_19_3_M", "Q7_19_3_D", "Q7_19_3_H", "Q7_19_4", "Q7_19_5_N", "Q7_19_6", "Q7_19_7"];
            IDList_off.forEach(DisableFields);
            $(".Q7_19_2_no_reluctant_unknown").hide();

        }
    });

    $("#Q7_19_9").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_19_9_no_reluctant_unknown").show();
            var IDList_show =
                    ["Q7_19_10_D"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q7_19_10_D"];
            IDList_off.forEach(DisableFields);
            $(".Q7_19_9_no_reluctant_unknown").hide();

        }
    });

    $("#Q7_19_11").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_19_11_no_reluctant_unknown").show();
            var IDList_show =
                    ["Q7_19_12_M", "Q7_19_12_D"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q7_19_12_M", "Q7_19_12_D"];
            IDList_off.forEach(DisableFields);
            $(".Q7_19_11_no_reluctant_unknown").hide();

        }
    });

    $("#Q7_20_1").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_20_1_no_reluctant_unknown").show();
            var IDList_show =
                    ["Q7_20_2", "Q7_20_3_M", "Q7_20_3_D", "Q7_20_4"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q7_20_2", "Q7_20_3_M", "Q7_20_3_D", "Q7_20_4"];
            IDList_off.forEach(DisableFields);
            $(".Q7_20_1_no_reluctant_unknown").hide();

        }
    });

    $("#Q7_21_1").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_21_1_no_reluctant_unknown").show();
            var IDList_show =
                    ["Q7_21_2", "Q7_21_3_D"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q7_21_2", "Q7_21_3_D"];
            IDList_off.forEach(DisableFields);
            $(".Q7_21_1_no_reluctant_unknown").hide();

        }
    });

    $("#Q7_22_1").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_22_1_no_reluctant_unknown").show();
            var IDList_show =
                    ["Q7_22_2", "Q7_22_3_M", "Q7_22_3_D"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q7_22_2", "Q7_22_3_M", "Q7_22_3_D"];
            IDList_off.forEach(DisableFields);
            $(".Q7_22_1_no_reluctant_unknown").hide();

        }
    });

    $("#Q7_22_4").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_22_4_no_reluctant_unknown").show();
            var IDList_show =
                    ["Q7_22_5_A", "Q7_22_5_B", "Q7_22_5_C", "Q7_22_5_D", "Q7_22_5_D_off"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q7_22_5_A", "Q7_22_5_B", "Q7_22_5_C", "Q7_22_5_D", "Q7_22_5_D_off"];
            IDList_off.forEach(DisableFields);
            $(".Q7_22_4_no_reluctant_unknown").hide();

        }
    });

    $("#Q7_23_1").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_23_1_no_reluctant_unknown").show();
            var IDList_show =
                    ["Q7_23_2_M", "Q7_23_2_D", "Q7_23_3_NAME"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q7_23_2_M", "Q7_23_2_D", "Q7_23_3_NAME"];
            IDList_off.forEach(DisableFields);
            $(".Q7_23_1_no_reluctant_unknown").hide();

        }
    });
    
    
    $("#Q9_0_F").on('change', function () {
        if (this.value == 1576) {
            $("#Q9_0_F_yes_part").show();
            var IDList_show =["Q9_0_F_OTHER", "Q9_0_F_D"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q9_0_F_OTHER", "Q9_0_F_D"];
            IDList_off.forEach(DisableFields);
            $("#Q9_0_F_yes_part").hide();

        }
    });

    $("#Q9_1").on('change', function () {   
        if (this.value == 1576) {
            $(".Q9_1_no_reluctant_unknown").show();
            var IDList_show =
                    ["Q9_1_1_AP", "Q9_1_1_AP_off", "Q9_1_1_BP", "Q9_1_1_BP_off", "Q9_1_1_CP", "Q9_1_1_CP_off", "Q9_1_1_DP", "Q9_1_1_DP_off", "Q9_1_2_A"
                                , "Q9_1_2_B", "Q9_1_2_C", "Q9_1_2_D", "Q9_1_2_E", "Q9_1_2_F", "Q9_1_2_G", "Q9_1_2_H", "Q9_1_2_I", "Q9_1_2_J", "Q9_1_2_K"
                                , "Q9_1_2_K_off", "Q9_1_2_L", "Q9_1_3_N", "Q9_1_4_A", "Q9_1_4_B", "Q9_1_4_C", "Q9_1_4_D", "Q9_1_4_E", "Q9_1_4_F", "Q9_1_4_G"
                                , "Q9_1_4_G_off", "Q9_1_5", "Q9_2"];
                            
            var IDList_required =["Q9_1_1_AP", "Q9_1_1_AP_off"];               
                           
            IDList_show.forEach(JustEnableFields);
            IDList_required.forEach(JustAddRequiredFields); 
        } else {
            var IDList_off = ["Q9_1_1_AP", "Q9_1_1_AP_off", "Q9_1_1_BP", "Q9_1_1_BP_off", "Q9_1_1_CP", "Q9_1_1_CP_off", "Q9_1_1_DP", "Q9_1_1_DP_off", "Q9_1_2_A"
                        , "Q9_1_2_B", "Q9_1_2_C", "Q9_1_2_D", "Q9_1_2_E", "Q9_1_2_F", "Q9_1_2_G", "Q9_1_2_H", "Q9_1_2_I", "Q9_1_2_J", "Q9_1_2_K"
                        , "Q9_1_2_K_off", "Q9_1_2_L", "Q9_1_3_N", "Q9_1_4_A", "Q9_1_4_B", "Q9_1_4_C", "Q9_1_4_D", "Q9_1_4_E", "Q9_1_4_F", "Q9_1_4_G"
                        , "Q9_1_4_G_off", "Q9_1_5", "Q9_2"];
                    
            var IDList_remove_required =["Q9_1_1_AP", "Q9_1_1_AP_off"];
            
            IDList_off.forEach(JustDisableFields);
            IDList_remove_required.forEach(JustRemoveRequiredFields);
            
            $(".Q9_1_no_reluctant_unknown").hide();

        }
    });
    $("#Q9_2").on('change', function () {
        if (this.value == 1576) {
            $(".Q9_2_no_reluctant_unknown").show();
            var IDList_show =
                    ["Q9_2_1_1_HCODE", "Q9_2_1_1_DATE", "Q9_2_1_1_CAUSE"
                                , "Q9_2_1_2_HCODE", "Q9_2_1_2_DATE", "Q9_2_1_2_CAUSE", "Q9_2_1_3_HCODE", "Q9_2_1_3_DATE"
                                , "Q9_2_1_3_CAUSE", "Q9_2_2", "Q9_2_3_A", "Q9_2_3_B", "Q9_2_3_C", "Q9_2_3_D", "Q9_2_4", "Q9_2_5"];
            
            var IDList_required =["Q9_2_1_1_HCODE"];
            IDList_show.forEach(JustEnableFields);
            IDList_required.forEach(JustAddRequiredFields);
        } else {
            var IDList_off = ["Q9_2_1_1_HCODE", "Q9_2_1_1_DATE", "Q9_2_1_1_CAUSE"
                        , "Q9_2_1_2_HCODE", "Q9_2_1_2_DATE", "Q9_2_1_2_CAUSE", "Q9_2_1_3_HCODE", "Q9_2_1_3_DATE"
                        , "Q9_2_1_3_CAUSE", "Q9_2_2", "Q9_2_3_A", "Q9_2_3_B", "Q9_2_3_C", "Q9_2_3_D", "Q9_2_4", "Q9_2_5"];
            
            var IDList_remove_required =["Q9_2_1_1_HCODE"]; 
            
            IDList_off.forEach(JustDisableFields); 
            IDList_remove_required.forEach(JustRemoveRequiredFields);
            $(".Q9_2_no_reluctant_unknown").hide();

        }
    });

    $("#Q9_3").on('change', function () {
        if (this.value == 1826) {
            $(".Q9_3_home_street_accidentPlace_other").show();
            var IDList_show =
                    ["Q9_3_off", "Q9_3_1_HCODE", "Q9_3_2"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off =
                    ["Q9_3_off", "Q9_3_1_HCODE", "Q9_3_2"];
            IDList_off.forEach(DisableFields);
            $(".Q9_3_home_street_accidentPlace_other").hide();

        }
    });

    $("#Q9_3_2").on('change', function () {
        if (this.value == 1576) {
            $(".Q9_3_2_no_reluctant_unknown").show();
            var IDList_show =
                    ["Q9_3_3", "Q9_3_3_off", "Q9_3_4_CAUSE"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off =
                    ["Q9_3_3", "Q9_3_3_off", "Q9_3_4_CAUSE"];
            IDList_off.forEach(DisableFields);
            $(".Q9_3_2_no_reluctant_unknown").hide();

        }
    });

    $("#Q10_1").on('change', function () {
        
        if (this.value == 1576) {
            $("#Q10_2").val('').trigger('change');
            var IDList_off1 = ["Q10_2"];
            IDList_off1.forEach(DisableFields);
            $(".Q10_2_part").hide();

            $(".Q10_1_no_reluctant_unknown").show();
            var IDList_show = ["Q10_1_1"];
            IDList_show.forEach(EnableFields);

        } else {
            $("#Q10_1_1").val('').trigger('change');
            var IDList_off = ["Q10_1_1"];
            IDList_off.forEach(DisableFields);
            $(".Q10_1_no_reluctant_unknown").hide();

            $(".Q10_2_part").show();
            var IDList_show2 = ["Q10_2"];
            IDList_show2.forEach(EnableFields);

        }
    });

    $("#Q10_1_1").on('change', function () {
        var IDList_off2 = ["Q10_1_1_VDATE", "Q10_1_1_HIGH", "Q10_1_1_WEIG", "Q10_1_1_SYMP", "Q10_1_1_DIAG", "Q10_1_1_TRET"];
        
        var IDList_remove_required = ["Q10_1_1_VDATE"];
        IDList_off2.forEach(JustDisableFields);
        IDList_remove_required.forEach(JustRemoveRequiredFields);
        $(".Q10_1_1_part").hide();
        
        if (this.value == 1568) {
            var IDList_off2 = ["Q10_1_1_VDATE", "Q10_1_1_HIGH", "Q10_1_1_WEIG", "Q10_1_1_SYMP", "Q10_1_1_DIAG"
                        , "Q10_1_1_TRET"];
            var IDList_remove_required = ["Q10_1_1_VDATE"];
            IDList_off2.forEach(JustDisableFields);
            IDList_remove_required.forEach(JustRemoveRequiredFields);
            $(".Q10_1_1_part").hide();

            $(".Q10_2_part").show();
            var IDList_show = ["Q10_2"];
            IDList_show.forEach(EnableFields);

        } else if (this.value == 1567) {
            var IDList_off = ["Q10_2"];
            IDList_off.forEach(DisableFields);
            $(".Q10_2_part").hide();

            var IDList_show2 = ["Q10_1_1_VDATE", "Q10_1_1_HIGH", "Q10_1_1_WEIG", "Q10_1_1_SYMP", "Q10_1_1_DIAG"
                        , "Q10_1_1_TRET"];
            var IDList_required = ["Q10_1_1_VDATE"];
            IDList_show2.forEach(JustEnableFields);
            IDList_required.forEach(JustAddRequiredFields);
            $(".Q10_1_1_part").show();

        }
    });
    
    $("#Q10_2").on('change', function () {
        if (this.value == 1576) {
            $(".Q10_2_no_reluctant_unknown").show();
            var IDList_show =
                    ["Q10_2_1", "Q10_2_2_ICAUSE", "Q10_2_2_ICODE","Q10_2_2_ACAUSE","Q10_2_2_ACODE"
            ,"Q10_2_2_UCAUSE","Q10_2_2_UCODE","Q10_2_2_CCAUSE","Q10_2_2_CCODE"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off =
                    ["Q10_2_1", "Q10_2_2_ICAUSE", "Q10_2_2_ICODE","Q10_2_2_ACAUSE","Q10_2_2_ACODE"
            ,"Q10_2_2_UCAUSE","Q10_2_2_UCODE","Q10_2_2_CCAUSE","Q10_2_2_CCODE"];
            IDList_off.forEach(DisableFields);
            $(".Q10_2_no_reluctant_unknown").hide();

        }
    });
    
    $("#Q10_3_DR").on('change', function () {
        if (this.value == 1576) {
            $(".Q10_3_DR_no_reluctant_unknown").show();
            var IDList_show =
                    ["Q10_3_1_DRS"];
            IDList_show.forEach(EnableFields);
        } else {
            $("#Q10_3_1_DRS").val('').trigger('change');
            var IDList_off =
                    ["Q10_3_1_DRS"];
            IDList_off.forEach(DisableFields);
            $(".Q10_3_DR_no_reluctant_unknown").hide();

        }
    });
    
    $("#Q10_3_1_DRS").on('change', function () {
        if (this.value == 1567) {
            $(".Q10_3_1_DRS_no_reluctant_unknown").show();
            var IDList_show =
                    ["Q10_3_2_DRD","Q10_3_3_DRN"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off =
                    ["Q10_3_2_DRD","Q10_3_3_DRN"];
            IDList_off.forEach(DisableFields);
            $(".Q10_3_1_DRS_no_reluctant_unknown").hide();

        }
    });


});

function DisableFields(item) {
    $('#' + item).prop('required', false);
    $('#' + item).attr('disabled', true);
}

function EnableFields(item) {

    $('#' + item).attr('disabled', false);
    if (item.slice(-3) != 'off') {
        $('#' + item).prop('required', true);
    }

}


function JustDisableFields(item) {
    $('#' + item).attr('disabled', true);
}

function JustEnableFields(item) {
    $('#' + item).attr('disabled', false);
}

function JustRemoveRequiredFields(item) {
    $('#' + item).prop('required', false);
}

function JustAddRequiredFields(item) {
    if (item.slice(-3) != 'off') {
        $('#' + item).prop('required', true);
    }
}