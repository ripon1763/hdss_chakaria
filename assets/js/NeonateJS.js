$(function () {
    $("#Q5_1").on('change', function () {
        if (this.value == 1576) {
            $(".Q5_1_yes").show();
            var IDList_show =
                    ["Q5_1_1", "Q5_1_1_off", "Q5_1_2", "Q5_1_3", "Q5_1_4_D", "Q5_1_4_H", "Q5_1_5"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q5_1_1", "Q5_1_1_off", "Q5_1_2", "Q5_1_3", "Q5_1_4_D", "Q5_1_4_H", "Q5_1_5"];
            IDList_off.forEach(DisableFields);
            $(".Q5_1_yes").hide();

        }
    });

    $("#Q5_1_3").on('change', function () {
        if (this.value == 1577 || this.value == 1578 || this.value == 1579) {
            $(".Q5_1_3_no_reluctant_unknown").show();
            var IDList_show = ['Q5_1_4', 'Q5_1_4_D', 'Q5_1_4_H', 'Q5_1_5', 'Q5_1_6', 'Q5_1_7_D', 'Q5_1_7_H', 'Q5_1_8', 'Q6_1_A', 'Q6_1_B', 'Q6_1_C', 'Q6_1_D', 'Q6_1_E', 'Q6_1_F', 'Q6_1_G', 'Q6_1_G_OTHER', 'Q6_1_1', 'Q6_1_2_M', 'Q6_1_2_D', 'Q6_1_3', 'Q6_1_4_M', 'Q6_1_4_D', 'Q6_1_5', 'Q6_1_6', 'Q6_1_7', 'Q6_1_8', 'Q6_1_9', 'Q6_1_9_W', 'Q6_1_10', 'Q6_2_1_A', 'Q6_2_1_B', 'Q6_2_1_C', 'Q6_2_1_D', 'Q6_2_1_E', 'Q6_2_2', 'Q6_2_2_N', 'Q6_2_3', 'Q6_2_4_DATE', 'Q6_2_3_BIRTH_ORDER', 'Q6_2_3_1_BIRTH_ORDER', 'Q6_2_4', 'Q6_2_5', 'Q6_2_5_M', 'Q6_2_6', 'Q6_2_6_1', 'Q6_2_7', 'Q6_2_7_1', 'Q6_2_7_2', 'Q6_2_7_3', 'Q6_2_7_4', 'Q6_2_7_5', 'Q6_2_7_6', 'Q6_2_7_7', 'Q6_2_7_8', 'Q6_2_7_9', 'Q6_2_7_10', 'Q6_2_7_11', 'Q6_2_7_12', 'Q6_2_7_13', 'Q6_2_7_14', 'Q6_2_7_15', 'Q6_2_7_15_OTHER', 'Q6_2_7A', 'Q6_2_7B', 'Q6_2_8', 'Q6_2_8_DAY_MONTH', 'Q6_2_9', 'Q6_2_10', 'Q6_2_11_A', 'Q6_2_11_B', 'Q6_2_11_C', 'Q6_2_11_D', 'Q6_2_11_E', 'Q6_2_11_F', 'Q6_2_11_F_OTHER', 'Q6_2_12', 'Q6_2_12_1', 'Q6_2_13', 'Q6_2_13_OTHER', 'Q6_2_14_A', 'Q6_2_14_B', 'Q6_2_14_C', 'Q6_2_14_D', 'Q6_2_14_E', 'Q6_2_14_F', 'Q6_2_14_G', 'Q6_2_14_H', 'Q6_2_14_I', 'Q6_2_14_J', 'Q6_2_14_K', 'Q6_2_14_K_OTHER', 'Q6_2_15', 'Q6_2_16', 'Q6_2_17_M', 'Q6_2_17_1', 'Q6_2_18', 'Q6_3_A', 'Q6_3_B', 'Q6_3_C', 'Q6_3_D', 'Q6_3_E', 'Q6_3_F', 'Q6_3_G', 'Q6_3_H', 'Q6_3_I', 'Q6_3_J', 'Q6_3_K', 'Q6_3_L', 'Q6_3_M', 'Q6_3_N', 'Q6_3_O', 'Q6_3_P', 'Q6_3_Q', 'Q6_3_R', 'Q6_3_S', 'Q6_3_T', 'Q6_3_U', 'Q6_3_V', 'Q6_3_W', 'Q6_3_W_OTHER', 'Q6_3_1', 'Q6_3_2', 'Q6_4', 'Q6_5', 'Q6_5_OTHER', 'Q6_5_1', 'Q6_5_2_A', 'Q6_5_2_B', 'Q6_5_2_C', 'Q6_5_2_D', 'Q6_5_2_E', 'Q6_5_2_F', 'Q6_5_2_G', 'Q6_5_2_H', 'Q6_5_2_I', 'Q6_5_2_J', 'Q6_5_2_K', 'Q6_5_2_K_OTHER', 'Q6_5_3_NAME', 'Q6_5_3_ADDRESS', 'Q6_5_4_A', 'Q6_5_4_B', 'Q6_5_4_C', 'Q6_5_4_D', 'Q6_5_4_E', 'Q6_5_4_F', 'Q6_5_4_G', 'Q6_5_4_H', 'Q6_5_4_I', 'Q6_5_4_J', 'Q6_5_4_K', 'Q6_5_4_K_OTHER', 'Q6_5_5', 'Q6_5_6_A', 'Q6_5_6_B', 'Q6_5_6_C', 'Q6_5_6_D', 'Q6_5_6_E', 'Q6_5_6_F', 'Q6_5_6_F_OTHER', 'Q6_6', 'Q6_6_1', 'Q6_6_2_A', 'Q6_6_2_B', 'Q6_6_2_C', 'Q6_6_2_D', 'Q6_6_3', 'Q6_6_4', 'Q6_6_5', 'Q6_6_6', 'Q6_6_7', 'Q6_6_8', 'Q6_6_9', 'Q6_6_10', 'Q6_6_11', 'Q6_6_12', 'Q6_6_13', 'Q7_1', 'Q7_1_0', 'Q7_1_1_D', 'Q7_1_1_H', 'Q7_1_1', 'Q7_1_2_D', 'Q7_1_3', 'Q7_1_4', 'Q7_1_5', 'Q7_1_6', 'Q7_1_7', 'Q7_2', 'Q7_2_1', 'Q7_2_2', 'Q7_2_2_OTHER', 'Q7_2_3_D', 'Q7_2_4', 'Q7_2_4_OTHER', 'Q7_2_5', 'Q7_2_5A', 'Q7_2_6', 'Q7_2_6_1', 'Q7_2_7', 'Q7_2_8_A', 'Q7_2_8_B', 'Q7_2_8_C', 'Q7_2_8_D', 'Q7_2_8_E', 'Q7_2_8_F', 'Q7_2_8_F_OTHER', 'Q7_2_9', 'Q7_2_10', 'Q7_2_11', 'Q7_2_12', 'Q7_2_13', 'Q7_2_14_D', 'Q7_3', 'Q7_3a', 'Q7_3b', 'Q7_3_1', 'Q7_3_1_A', 'Q7_3_1_B', 'Q7_3_1_C', 'Q7_3_1_D', 'Q7_3_1_E', 'Q7_3_1_F', 'Q7_3_1_F_OTHER', 'Q7_3_2_Y', 'Q7_3_2_M', 'Q7_3_3', 'Q7_3_4_Y', 'Q7_3_4_M', 'Q7_3_5', 'Q7_3_6', 'Q7_3_6_OTHER', 'Q7_3_7', 'Q7_3_8_A', 'Q7_3_8_B', 'Q7_3_8_C', 'Q7_3_8_D', 'Q7_3_8_E', 'Q7_3_8_F', 'Q7_3_8_G', 'Q7_3_8_G_OTHER', 'Q7_4', 'Q7_4_1', 'Q7_4_2_M', 'Q7_4_2_D', 'Q7_4_3', 'Q7_4_4', 'Q7_4_5', 'Q7_4_6_M', 'Q7_4_6_D', 'Q7_5', 'Q7_5_1', 'Q7_5_2', 'Q7_5_2_M', 'Q7_5_2_D', 'Q7_5_3', 'Q7_5_4_D', 'Q7_5_5', 'Q7_6', 'Q7_6_0', 'Q7_6_0_D', 'Q7_6_1_D', 'Q7_6_1_H', 'Q7_6_1', 'Q7_6_2_A', 'Q7_6_2_B', 'Q7_6_2_C', 'Q7_6_2_D', 'Q7_6_2_E', 'Q7_6_2_F', 'Q7_6_2_G', 'Q7_6_2_G_OTHER', 'Q7_6_3_M', 'Q7_6_3_D', 'Q7_6_4', 'Q7_6_4_OTHER', 'Q7_6_5', 'Q7_6_6_M', 'Q7_6_6_D', 'Q7_6_7', 'Q7_6_8', 'Q7_7_1', 'Q7_7', 'Q7_7_1_D', 'Q7_7_1_H', 'Q7_7_2', 'Q7_7_2_M', 'Q7_7_2_D', 'Q7_7_3', 'Q7_7_4', 'Q7_7_4_D', 'Q7_7_4_H', 'Q7_7_5', 'Q7_8', 'Q7_8_1', 'Q7_8_2_M', 'Q7_8_2_D', 'Q7_8_3', 'Q7_8_4', 'Q7_8_5_M', 'Q7_8_5_D', 'Q7_8_6', 'Q7_8_7_M', 'Q7_8_7_D', 'Q7_8_8', 'Q7_8_9', 'Q7_8_10', 'Q7_8_11', 'Q7_8_12', 'Q7_8_13', 'Q7_8_14', 'Q7_9', 'Q7_9_1', 'Q7_9_2', 'Q7_9_2_D', 'Q7_9_3', 'Q7_9_3_OTHER', 'Q7_9_4', 'Q7_9_5', 'Q7_9_6', 'Q7_9_7', 'Q7_9_8', 'Q7_9_9', 'Q7_10', 'Q7_10_1', 'Q7_10_2_D', 'Q7_10_3', 'Q7_10_4_N', 'Q7_10_5', 'Q7_10_6', 'Q7_10_7', 'Q7_10_8', 'Q7_10_9', 'Q7_11_1', 'Q7_11', 'Q7_11_2_D', 'Q7_11_2_H', 'Q7_11_3_N', 'Q7_11_4', 'Q7_11_4_OTHER', 'Q7_12', 'Q7_12_1_D', 'Q7_12_1_H', 'Q7_12_1', 'Q7_12_2', 'Q7_12_2_D', 'Q7_12_2_H', 'Q7_12_2_OTHER', 'Q7_12_3_M', 'Q7_12_3_D', 'Q7_12_4', 'Q7_12_4_OTHER', 'Q7_12_5', 'Q7_12_6', 'Q7_12_7', 'Q7_12_8', 'Q7_12_8_OTHER', 'Q7_13', 'Q7_13_1', 'Q7_13_2_M', 'Q7_13_2_D', 'Q7_13_3', 'Q7_13_4', 'Q7_13_5', 'Q7_13_6_M', 'Q7_13_6_D', 'Q7_14', 'Q7_14_1', 'Q7_14_2_M', 'Q7_14_2_D', 'Q7_14_3', 'Q7_14_4_M', 'Q7_14_4_D', 'Q7_14_5', 'Q7_15_1', 'Q7_15', 'Q7_15_2_D', 'Q7_15_2_H', 'Q7_15_2', 'Q7_15_2_OTHER', 'Q7_15_3', 'Q7_15_4_M', 'Q7_15_4_D', 'Q7_15_4', 'Q7_15_5', 'Q7_16', 'Q7_16_2', 'Q7_16_1', 'Q7_16_2_M', 'Q7_16_2_D', 'Q7_16_3', 'Q7_16_4', 'Q7_17_1', 'Q7_17_2_D', 'Q7_17_3', 'Q7_17_4_M', 'Q7_17_4_D', 'Q7_17_5', 'Q7_17_6', 'Q7_18_1', 'Q7_18', 'Q7_18_0', 'Q7_18_2', 'Q7_18_2_D', 'Q7_18_2_H', 'Q7_18_3', 'Q7_18_4', 'Q7_19', 'Q7_19_0', 'Q7_19_1_M', 'Q7_19_1_D', 'Q7_19_2', 'Q7_19_3_M', 'Q7_19_3_D', 'Q7_19_3_H', 'Q7_19_4', 'Q7_19_5_N', 'Q7_19_6', 'Q7_19_7', 'Q7_19_8', 'Q7_19_9', 'Q7_19_10_D', 'Q7_19_11', 'Q7_19_12_M', 'Q7_19_12_D', 'Q7_20', 'Q7_20_1_A', 'Q7_20_1_B', 'Q7_20_1_C', 'Q7_20_1_D', 'Q7_20_1_E', 'Q7_20_1_E_OTHER', 'Q7_20_1', 'Q7_20_2', 'Q7_20_2_OTHER', 'Q7_20_3_M', 'Q7_20_3_D', 'Q7_20_4', 'Q7_21', 'Q7_21_1', 'Q7_21_2', 'Q7_21_3', 'Q7_22', 'Q7_21_3_D', 'Q7_22_1', 'Q7_22_2', 'Q7_22_3', 'Q7_22_3_M', 'Q7_22_3_D', 'Q7_22_4', 'Q7_22_5_A', 'Q7_22_5_B', 'Q7_22_5_C', 'Q7_22_5_D', 'Q7_22_5_D_OTHER', 'Q7_22_6', 'Q7_23', 'Q7_23_1', 'Q7_23_1_D', 'Q7_23_1_H', 'Q7_23_2_M', 'Q7_23_2_D', 'Q7_23_3_NAME', 'Q7_24', 'Q7_24_1', 'Q7_24_2', 'Q7_25', 'Q8_0_A', 'Q8_0_B', 'Q8_0_C', 'Q8_1', 'Q8_1_1_A', 'Q8_1_1_B', 'Q8_1_1_C', 'Q8_1_1_D', 'Q8_1_1_1', 'Q8_1_1_2', 'Q8_1_1_3', 'Q8_1_1_4', 'Q8_1_1_5', 'Q8_1_1_6', 'Q8_1_1_7', 'Q8_1_2_1_N', 'Q8_1_2_2_N', 'Q8_1_2_3_N', 'Q8_1_2_4_N', 'Q8_1_2_5_N', 'Q8_1_2_6_N', 'Q8_1_2_7_N', 'Q8_1_3_1_Y', 'Q8_1_3_1_M', 'Q8_1_3_2_Y', 'Q8_1_3_2_M', 'Q8_1_3_3_Y', 'Q8_1_3_3_M', 'Q8_1_3_4_Y', 'Q8_1_3_4_M', 'Q8_1_3_5_Y', 'Q8_1_3_5_M', 'Q8_1_3_6_Y', 'Q8_1_3_6_M', 'Q8_1_3_7_Y', 'Q8_1_3_7_M', 'Q8_1_4_1_Y', 'Q8_1_4_1_M', 'Q8_1_4_2_Y', 'Q8_1_4_2_M', 'Q8_1_4_3_Y', 'Q8_1_4_3_M', 'Q8_1_4_4_Y', 'Q8_1_4_4_M', 'Q8_1_4_5_Y', 'Q8_1_4_5_M', 'Q8_1_4_6_Y', 'Q8_1_4_6_M', 'Q8_1_4_7_Y', 'Q8_1_4_7_M', 'Q8_1_2', 'Q8_1_2_OTHER', 'Q8_1_3_A', 'Q8_1_3_B', 'Q8_1_3_C', 'Q8_1_3_D', 'Q8_1_3_E', 'Q8_1_3_F', 'Q8_1_3_G', 'Q8_1_3_G_OTHER', 'Q8_1_4', 'Q8_2', 'Q8_2_1_A', 'Q8_2_1_B', 'Q8_2_1_C', 'Q8_2_1_D', 'Q8_2_1_E', 'Q8_2_1_F', 'Q8_2_1_G', 'Q8_2_1_H', 'Q8_2_1_I', 'Q8_2_1_J', 'Q8_2_1_J_OTHER', 'Q8_2_1_HOSPITAL_1', 'Q8_2_1_DATE_ADMISSION_1', 'Q8_2_1_REASON_1', 'Q8_2_1_HOSPITAL_2', 'Q8_2_1_DATE_ADMISSION_2', 'Q8_2_1_REASON_2', 'Q8_2_1_HOSPITAL_3', 'Q8_2_1_DATE_ADMISSION_3', 'Q8_2_1_REASON_3', 'Q8_2_2_Y', 'Q8_2_2_M', 'Q8_2_2', 'Q8_2_3_A', 'Q8_2_3_B', 'Q8_2_3_C', 'Q8_2_3_D', 'Q8_2_3_E', 'Q8_2_3', 'Q8_2_3_OTHER', 'Q8_2_4', 'Q8_2_5', 'Q8_2_6', 'Q8_2_7'];
            IDList_show.forEach(EnableFieldsWithoutRequired);
        } else {
            var IDList_off =
                    ['Q5_1_4', 'Q5_1_4_D', 'Q5_1_4_H', 'Q5_1_5', 'Q5_1_6', 'Q5_1_7_D', 'Q5_1_7_H', 'Q5_1_8', 'Q6_1_A', 'Q6_1_B', 'Q6_1_C', 'Q6_1_D', 'Q6_1_E', 'Q6_1_F', 'Q6_1_G', 'Q6_1_G_OTHER', 'Q6_1_1', 'Q6_1_2_M', 'Q6_1_2_D', 'Q6_1_3', 'Q6_1_4_M', 'Q6_1_4_D', 'Q6_1_5', 'Q6_1_6', 'Q6_1_7', 'Q6_1_8', 'Q6_1_9', 'Q6_1_9_W', 'Q6_1_10', 'Q6_2_1_A', 'Q6_2_1_B', 'Q6_2_1_C', 'Q6_2_1_D', 'Q6_2_1_E', 'Q6_2_2', 'Q6_2_2_N', 'Q6_2_3', 'Q6_2_4_DATE', 'Q6_2_3_BIRTH_ORDER', 'Q6_2_3_1_BIRTH_ORDER', 'Q6_2_4', 'Q6_2_5', 'Q6_2_5_M', 'Q6_2_6', 'Q6_2_6_1', 'Q6_2_7', 'Q6_2_7_1', 'Q6_2_7_2', 'Q6_2_7_3', 'Q6_2_7_4', 'Q6_2_7_5', 'Q6_2_7_6', 'Q6_2_7_7', 'Q6_2_7_8', 'Q6_2_7_9', 'Q6_2_7_10', 'Q6_2_7_11', 'Q6_2_7_12', 'Q6_2_7_13', 'Q6_2_7_14', 'Q6_2_7_15', 'Q6_2_7_15_OTHER', 'Q6_2_7A', 'Q6_2_7B', 'Q6_2_8', 'Q6_2_8_DAY_MONTH', 'Q6_2_9', 'Q6_2_10', 'Q6_2_11_A', 'Q6_2_11_B', 'Q6_2_11_C', 'Q6_2_11_D', 'Q6_2_11_E', 'Q6_2_11_F', 'Q6_2_11_F_OTHER', 'Q6_2_12', 'Q6_2_12_1', 'Q6_2_13', 'Q6_2_13_OTHER', 'Q6_2_14_A', 'Q6_2_14_B', 'Q6_2_14_C', 'Q6_2_14_D', 'Q6_2_14_E', 'Q6_2_14_F', 'Q6_2_14_G', 'Q6_2_14_H', 'Q6_2_14_I', 'Q6_2_14_J', 'Q6_2_14_K', 'Q6_2_14_K_OTHER', 'Q6_2_15', 'Q6_2_16', 'Q6_2_17_M', 'Q6_2_17_1', 'Q6_2_18', 'Q6_3_A', 'Q6_3_B', 'Q6_3_C', 'Q6_3_D', 'Q6_3_E', 'Q6_3_F', 'Q6_3_G', 'Q6_3_H', 'Q6_3_I', 'Q6_3_J', 'Q6_3_K', 'Q6_3_L', 'Q6_3_M', 'Q6_3_N', 'Q6_3_O', 'Q6_3_P', 'Q6_3_Q', 'Q6_3_R', 'Q6_3_S', 'Q6_3_T', 'Q6_3_U', 'Q6_3_V', 'Q6_3_W', 'Q6_3_W_OTHER', 'Q6_3_1', 'Q6_3_2', 'Q6_4', 'Q6_5', 'Q6_5_OTHER', 'Q6_5_1', 'Q6_5_2_A', 'Q6_5_2_B', 'Q6_5_2_C', 'Q6_5_2_D', 'Q6_5_2_E', 'Q6_5_2_F', 'Q6_5_2_G', 'Q6_5_2_H', 'Q6_5_2_I', 'Q6_5_2_J', 'Q6_5_2_K', 'Q6_5_2_K_OTHER', 'Q6_5_3_NAME', 'Q6_5_3_ADDRESS', 'Q6_5_4_A', 'Q6_5_4_B', 'Q6_5_4_C', 'Q6_5_4_D', 'Q6_5_4_E', 'Q6_5_4_F', 'Q6_5_4_G', 'Q6_5_4_H', 'Q6_5_4_I', 'Q6_5_4_J', 'Q6_5_4_K', 'Q6_5_4_K_OTHER', 'Q6_5_5', 'Q6_5_6_A', 'Q6_5_6_B', 'Q6_5_6_C', 'Q6_5_6_D', 'Q6_5_6_E', 'Q6_5_6_F', 'Q6_5_6_F_OTHER', 'Q6_6', 'Q6_6_1', 'Q6_6_2_A', 'Q6_6_2_B', 'Q6_6_2_C', 'Q6_6_2_D', 'Q6_6_3', 'Q6_6_4', 'Q6_6_5', 'Q6_6_6', 'Q6_6_7', 'Q6_6_8', 'Q6_6_9', 'Q6_6_10', 'Q6_6_11', 'Q6_6_12', 'Q6_6_13', 'Q7_1', 'Q7_1_0', 'Q7_1_1_D', 'Q7_1_1_H', 'Q7_1_1', 'Q7_1_2_D', 'Q7_1_3', 'Q7_1_4', 'Q7_1_5', 'Q7_1_6', 'Q7_1_7', 'Q7_2', 'Q7_2_1', 'Q7_2_2', 'Q7_2_2_OTHER', 'Q7_2_3_D', 'Q7_2_4', 'Q7_2_4_OTHER', 'Q7_2_5', 'Q7_2_5A', 'Q7_2_6', 'Q7_2_6_1', 'Q7_2_7', 'Q7_2_8_A', 'Q7_2_8_B', 'Q7_2_8_C', 'Q7_2_8_D', 'Q7_2_8_E', 'Q7_2_8_F', 'Q7_2_8_F_OTHER', 'Q7_2_9', 'Q7_2_10', 'Q7_2_11', 'Q7_2_12', 'Q7_2_13', 'Q7_2_14_D', 'Q7_3', 'Q7_3a', 'Q7_3b', 'Q7_3_1', 'Q7_3_1_A', 'Q7_3_1_B', 'Q7_3_1_C', 'Q7_3_1_D', 'Q7_3_1_E', 'Q7_3_1_F', 'Q7_3_1_F_OTHER', 'Q7_3_2_Y', 'Q7_3_2_M', 'Q7_3_3', 'Q7_3_4_Y', 'Q7_3_4_M', 'Q7_3_5', 'Q7_3_6', 'Q7_3_6_OTHER', 'Q7_3_7', 'Q7_3_8_A', 'Q7_3_8_B', 'Q7_3_8_C', 'Q7_3_8_D', 'Q7_3_8_E', 'Q7_3_8_F', 'Q7_3_8_G', 'Q7_3_8_G_OTHER', 'Q7_4', 'Q7_4_1', 'Q7_4_2_M', 'Q7_4_2_D', 'Q7_4_3', 'Q7_4_4', 'Q7_4_5', 'Q7_4_6_M', 'Q7_4_6_D', 'Q7_5', 'Q7_5_1', 'Q7_5_2', 'Q7_5_2_M', 'Q7_5_2_D', 'Q7_5_3', 'Q7_5_4_D', 'Q7_5_5', 'Q7_6', 'Q7_6_0', 'Q7_6_0_D', 'Q7_6_1_D', 'Q7_6_1_H', 'Q7_6_1', 'Q7_6_2_A', 'Q7_6_2_B', 'Q7_6_2_C', 'Q7_6_2_D', 'Q7_6_2_E', 'Q7_6_2_F', 'Q7_6_2_G', 'Q7_6_2_G_OTHER', 'Q7_6_3_M', 'Q7_6_3_D', 'Q7_6_4', 'Q7_6_4_OTHER', 'Q7_6_5', 'Q7_6_6_M', 'Q7_6_6_D', 'Q7_6_7', 'Q7_6_8', 'Q7_7_1', 'Q7_7', 'Q7_7_1_D', 'Q7_7_1_H', 'Q7_7_2', 'Q7_7_2_M', 'Q7_7_2_D', 'Q7_7_3', 'Q7_7_4', 'Q7_7_4_D', 'Q7_7_4_H', 'Q7_7_5', 'Q7_8', 'Q7_8_1', 'Q7_8_2_M', 'Q7_8_2_D', 'Q7_8_3', 'Q7_8_4', 'Q7_8_5_M', 'Q7_8_5_D', 'Q7_8_6', 'Q7_8_7_M', 'Q7_8_7_D', 'Q7_8_8', 'Q7_8_9', 'Q7_8_10', 'Q7_8_11', 'Q7_8_12', 'Q7_8_13', 'Q7_8_14', 'Q7_9', 'Q7_9_1', 'Q7_9_2', 'Q7_9_2_D', 'Q7_9_3', 'Q7_9_3_OTHER', 'Q7_9_4', 'Q7_9_5', 'Q7_9_6', 'Q7_9_7', 'Q7_9_8', 'Q7_9_9', 'Q7_10', 'Q7_10_1', 'Q7_10_2_D', 'Q7_10_3', 'Q7_10_4_N', 'Q7_10_5', 'Q7_10_6', 'Q7_10_7', 'Q7_10_8', 'Q7_10_9', 'Q7_11_1', 'Q7_11', 'Q7_11_2_D', 'Q7_11_2_H', 'Q7_11_3_N', 'Q7_11_4', 'Q7_11_4_OTHER', 'Q7_12', 'Q7_12_1_D', 'Q7_12_1_H', 'Q7_12_1', 'Q7_12_2', 'Q7_12_2_D', 'Q7_12_2_H', 'Q7_12_2_OTHER', 'Q7_12_3_M', 'Q7_12_3_D', 'Q7_12_4', 'Q7_12_4_OTHER', 'Q7_12_5', 'Q7_12_6', 'Q7_12_7', 'Q7_12_8', 'Q7_12_8_OTHER', 'Q7_13', 'Q7_13_1', 'Q7_13_2_M', 'Q7_13_2_D', 'Q7_13_3', 'Q7_13_4', 'Q7_13_5', 'Q7_13_6_M', 'Q7_13_6_D', 'Q7_14', 'Q7_14_1', 'Q7_14_2_M', 'Q7_14_2_D', 'Q7_14_3', 'Q7_14_4_M', 'Q7_14_4_D', 'Q7_14_5', 'Q7_15_1', 'Q7_15', 'Q7_15_2_D', 'Q7_15_2_H', 'Q7_15_2', 'Q7_15_2_OTHER', 'Q7_15_3', 'Q7_15_4_M', 'Q7_15_4_D', 'Q7_15_4', 'Q7_15_5', 'Q7_16', 'Q7_16_2', 'Q7_16_1', 'Q7_16_2_M', 'Q7_16_2_D', 'Q7_16_3', 'Q7_16_4', 'Q7_17_1', 'Q7_17_2_D', 'Q7_17_3', 'Q7_17_4_M', 'Q7_17_4_D', 'Q7_17_5', 'Q7_17_6', 'Q7_18_1', 'Q7_18', 'Q7_18_0', 'Q7_18_2', 'Q7_18_2_D', 'Q7_18_2_H', 'Q7_18_3', 'Q7_18_4', 'Q7_19', 'Q7_19_0', 'Q7_19_1_M', 'Q7_19_1_D', 'Q7_19_2', 'Q7_19_3_M', 'Q7_19_3_D', 'Q7_19_3_H', 'Q7_19_4', 'Q7_19_5_N', 'Q7_19_6', 'Q7_19_7', 'Q7_19_8', 'Q7_19_9', 'Q7_19_10_D', 'Q7_19_11', 'Q7_19_12_M', 'Q7_19_12_D', 'Q7_20', 'Q7_20_1_A', 'Q7_20_1_B', 'Q7_20_1_C', 'Q7_20_1_D', 'Q7_20_1_E', 'Q7_20_1_E_OTHER', 'Q7_20_1', 'Q7_20_2', 'Q7_20_2_OTHER', 'Q7_20_3_M', 'Q7_20_3_D', 'Q7_20_4', 'Q7_21', 'Q7_21_1', 'Q7_21_2', 'Q7_21_3', 'Q7_22', 'Q7_21_3_D', 'Q7_22_1', 'Q7_22_2', 'Q7_22_3', 'Q7_22_3_M', 'Q7_22_3_D', 'Q7_22_4', 'Q7_22_5_A', 'Q7_22_5_B', 'Q7_22_5_C', 'Q7_22_5_D', 'Q7_22_5_D_OTHER', 'Q7_22_6', 'Q7_23', 'Q7_23_1', 'Q7_23_1_D', 'Q7_23_1_H', 'Q7_23_2_M', 'Q7_23_2_D', 'Q7_23_3_NAME', 'Q7_24', 'Q7_24_1', 'Q7_24_2', 'Q7_25', 'Q8_0_A', 'Q8_0_B', 'Q8_0_C', 'Q8_1', 'Q8_1_1_A', 'Q8_1_1_B', 'Q8_1_1_C', 'Q8_1_1_D', 'Q8_1_1_1', 'Q8_1_1_2', 'Q8_1_1_3', 'Q8_1_1_4', 'Q8_1_1_5', 'Q8_1_1_6', 'Q8_1_1_7', 'Q8_1_2_1_N', 'Q8_1_2_2_N', 'Q8_1_2_3_N', 'Q8_1_2_4_N', 'Q8_1_2_5_N', 'Q8_1_2_6_N', 'Q8_1_2_7_N', 'Q8_1_3_1_Y', 'Q8_1_3_1_M', 'Q8_1_3_2_Y', 'Q8_1_3_2_M', 'Q8_1_3_3_Y', 'Q8_1_3_3_M', 'Q8_1_3_4_Y', 'Q8_1_3_4_M', 'Q8_1_3_5_Y', 'Q8_1_3_5_M', 'Q8_1_3_6_Y', 'Q8_1_3_6_M', 'Q8_1_3_7_Y', 'Q8_1_3_7_M', 'Q8_1_4_1_Y', 'Q8_1_4_1_M', 'Q8_1_4_2_Y', 'Q8_1_4_2_M', 'Q8_1_4_3_Y', 'Q8_1_4_3_M', 'Q8_1_4_4_Y', 'Q8_1_4_4_M', 'Q8_1_4_5_Y', 'Q8_1_4_5_M', 'Q8_1_4_6_Y', 'Q8_1_4_6_M', 'Q8_1_4_7_Y', 'Q8_1_4_7_M', 'Q8_1_2', 'Q8_1_2_OTHER', 'Q8_1_3_A', 'Q8_1_3_B', 'Q8_1_3_C', 'Q8_1_3_D', 'Q8_1_3_E', 'Q8_1_3_F', 'Q8_1_3_G', 'Q8_1_3_G_OTHER', 'Q8_1_4', 'Q8_2', 'Q8_2_1_A', 'Q8_2_1_B', 'Q8_2_1_C', 'Q8_2_1_D', 'Q8_2_1_E', 'Q8_2_1_F', 'Q8_2_1_G', 'Q8_2_1_H', 'Q8_2_1_I', 'Q8_2_1_J', 'Q8_2_1_J_OTHER', 'Q8_2_1_HOSPITAL_1', 'Q8_2_1_DATE_ADMISSION_1', 'Q8_2_1_REASON_1', 'Q8_2_1_HOSPITAL_2', 'Q8_2_1_DATE_ADMISSION_2', 'Q8_2_1_REASON_2', 'Q8_2_1_HOSPITAL_3', 'Q8_2_1_DATE_ADMISSION_3', 'Q8_2_1_REASON_3', 'Q8_2_2_Y', 'Q8_2_2_M', 'Q8_2_2', 'Q8_2_3_A', 'Q8_2_3_B', 'Q8_2_3_C', 'Q8_2_3_D', 'Q8_2_3_E', 'Q8_2_3', 'Q8_2_3_OTHER', 'Q8_2_4', 'Q8_2_5', 'Q8_2_6', 'Q8_2_7'];
            IDList_off.forEach(DisableFields);
            $(".Q5_1_3_no_reluctant_unknown").hide();

        }
    });

    $("#Q6_5").on('change', function () {
        if (this.value == 1650 || this.value == 1659||this.value==1938) {
            var IDList_off = ["Q6_5_1"];
            IDList_off.forEach(DisableFields);
            $(".Q6_5_1_part").hide();
        } else {
            $(".Q6_5_1_part").show();
            var IDList_show =
                    ["Q6_5_1"];
            IDList_show.forEach(EnableFields);
        }
    });

    $("#Q6_6_3").on('change', function () {
        if (this.value == 1576) {
            $(".Q6_6_4_part").show();
            var IDList_show =
                    ["Q6_6_4"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q6_6_4"];
            IDList_off.forEach(DisableFields);
            $(".Q6_6_4_part").hide();

        }
    });

    $("#Q6_6_9").on('change', function () {
        if (this.value == 1576) {
            $(".Q6_6_10_part").show();
            var IDList_show = ["Q6_6_10"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q6_6_10"];
            IDList_off.forEach(DisableFields);
            $(".Q6_6_10_part").hide();

        }
    });

    $("#Q6_6_11").on('change', function () {
        if (this.value == 1576) {
            $(".Q6_6_12_part").show();
            var IDList_show = ["Q6_6_12"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q6_6_12"];
            IDList_off.forEach(DisableFields);
            $(".Q6_6_12_part").hide();

        }
    });

    $("#Q7_2").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_2_yes_part").show();
            var IDList_show = ["Q7_2_1", "Q7_2_2"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q7_2_1", "Q7_2_2"];
            IDList_off.forEach(DisableFields);
            $(".Q7_2_yes_part").hide();

        }
    });

    $("#Q7_3").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_3_yes_part").show();
            var IDList_show = ["Q7_3a", "Q7_3b", "Q7_3_1"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q7_3a", "Q7_3b", "Q7_3_1"];
            IDList_off.forEach(DisableFields);
            $(".Q7_3_yes_part").hide();

        }
    });

    $("#Q7_4").on('change', function () {
        if (this.value == 1903) {
            $(".Q7_4_1_part").show();
            var IDList_show = ["Q7_4_1"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q7_4_1"];
            IDList_off.forEach(DisableFields);
            $(".Q7_4_1_part").hide();

        }
    });
    $("#Q7_5").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_5_yes_part").show();
            var IDList_show = ["Q7_5_1", "Q7_5_2"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q7_5_1", "Q7_5_2"];
            IDList_off.forEach(DisableFields);
            $(".Q7_5_yes_part").hide();
        }
    });
    $("#Q7_6").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_6_yes_part").show();
            var IDList_show = ["Q7_6_0", "Q7_6_0_off", "Q7_6_1_D", "Q7_6_1_H"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q7_6_0", "Q7_6_0_off", "Q7_6_1_D", "Q7_6_1_H"];
            IDList_off.forEach(DisableFields);
            $(".Q7_6_yes_part").hide();
        }
    });
    $("#Q7_7").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_7_yes_part").show();
            var IDList_show = ["Q7_7_1_D", "Q7_7_1_H", "Q7_7_2", "Q7_7_2_off"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q7_7_1_D", "Q7_7_1_H", "Q7_7_2", "Q7_7_2_off"];
            IDList_off.forEach(DisableFields);
            $(".Q7_7_yes_part").hide();
        }
    });

    $("#Q7_7_3").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_7_4_part").show();
            var IDList_show = ["Q7_7_4_D", "Q7_7_4_H"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q7_7_4_D", "Q7_7_4_H"];
            IDList_off.forEach(DisableFields);
            $(".Q7_7_4_part").hide();
        }
    });
    $("#Q7_11").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_11_yes_part").show();
            var IDList_show = ["Q7_11_1", "Q7_11_2_D", "Q7_11_2_H"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q7_11_1", "Q7_11_2_D", "Q7_11_2_H"];
            IDList_off.forEach(DisableFields);
            $(".Q7_11_yes_part").hide();
        }
    });

    $("#Q7_12").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_12_yes_part").show();
            var IDList_show = ["Q7_12_1_D", "Q7_12_1_H", "Q7_12_2"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q7_12_1_D", "Q7_12_1_H", "Q7_12_2"];
            IDList_off.forEach(DisableFields);
            $(".Q7_12_yes_part").hide();
            $("#Q7_12_2").val('').trigger('change');
        }
    });

    $("#Q7_12_2").on('change', function () {
        if (this.value == 1908) {
            $(".Q7_12_2_day_part").show();
            var IDList_show = ["Q7_12_2_D", "Q7_12_2_H"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q7_12_2_D", "Q7_12_2_H"];
            IDList_off.forEach(DisableFields);
            $(".Q7_12_2_day_part").hide();
        }
    });

    $("#Q7_14").on('change', function () {
        if (this.value == 1911) {
            $(".Q7_14_1_part").show();
            var IDList_show = ["Q7_14_1"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q7_14_1"];
            IDList_off.forEach(DisableFields);
            $(".Q7_14_1_part").hide();
        }
    });

    $("#Q7_15").on('change', function () {
        
        if (this.value == 1916) {
            $(".Q7_15_1_option_3_hide_part").show();
            var IDList_show = ["Q7_15_1","Q7_15_2_D","Q7_15_2_H","Q7_15_3","Q7_15_4","Q7_15_5"];
            IDList_show.forEach(EnableFields);
        }else if (this.value == 1918) {
            $(".Q7_15_1_option_3_hide_part").hide();
            var IDList_off = ["Q7_15_1","Q7_15_2_D","Q7_15_2_H","Q7_15_3","Q7_15_4","Q7_15_5"];
            IDList_off.forEach(DisableFields);
        } else { 
            $(".Q7_15_1_option_3_hide_part").show();
            var IDList_show = ["Q7_15_2_D","Q7_15_2_H","Q7_15_3","Q7_15_4","Q7_15_5"];
            IDList_show.forEach(EnableFields);
            
            var IDList_off = ["Q7_15_1"];
            IDList_off.forEach(DisableFields);
            $(".Q7_15_1_part").hide();
        }
    });

    $("#Q7_16").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_16_yes_part").show();
            var IDList_show = ["Q7_16_1", "Q7_16_2"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q7_16_1", "Q7_16_2"];
            IDList_off.forEach(DisableFields);
            $(".Q7_16_yes_part").hide();
        }
    });

    $("#Q7_20").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_20_1_part").show();
            var IDList_show = ["Q7_20_1_A", "Q7_20_1_B", "Q7_20_1_C", "Q7_20_1_D", "Q7_20_1_E", "Q7_20_1_E_off"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q7_20_1_A", "Q7_20_1_B", "Q7_20_1_C", "Q7_20_1_D", "Q7_20_1_E", "Q7_20_1_E_off"];
            IDList_off.forEach(DisableFields);
            $(".Q7_20_1_part").hide();
        }
    });

    $("#Q7_21").on('change', function () {
        if (this.value == 1926) {
            $(".Q7_21_yes_part").show();
            var IDList_show = ["Q7_21_1", "Q7_21_2", "Q7_21_3"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q7_21_1", "Q7_21_2", "Q7_21_3"];
            IDList_off.forEach(DisableFields);
            $(".Q7_21_yes_part").hide();
        }
    });

    $("#Q7_22").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_22_yes_part").show();
            var IDList_show = ["Q7_22_1", "Q7_22_2", "Q7_22_3"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q7_22_1", "Q7_22_2", "Q7_22_3"];
            IDList_off.forEach(DisableFields);
            $(".Q7_22_yes_part").hide();
        }
    });

    $("#Q7_23").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_23_1_part").show();
            var IDList_show = ["Q7_23_1_D", "Q7_23_1_H"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q7_23_1_D", "Q7_23_1_H"];
            IDList_off.forEach(DisableFields);
            $(".Q7_23_1_part").hide();
        }
    });
    $("#Q7_24").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_24_yes_part").show();
            var IDList_show = ["Q7_24_1", "Q7_24_2"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q7_24_1", "Q7_24_2"];
            IDList_off.forEach(DisableFields);
            $(".Q7_24_yes_part").hide();
        }
    });

    $("#Q8_1").on('change', function () {
        if (this.value == 1576) {
            $(".Q8_1_yes_part").show();
            var IDList_show = ['Q8_1_1_A', 'Q8_1_2', 'Q8_1_2_OTHER', 'Q8_1_3_A', 'Q8_1_3_B', 'Q8_1_3_C', 'Q8_1_3_D', 'Q8_1_3_E', 'Q8_1_3_F', 'Q8_1_3_G', 'Q8_1_3_G_OTHER', 'Q8_1_4', 'Q8_2', 'Q8_2_1_HOSPITAL_1', 'Q8_2_1_DATE_ADMISSION_1', 'Q8_2_1_REASON_1', 'Q8_2_2', 'Q8_2_3_A', 'Q8_2_3_B', 'Q8_2_3_C', 'Q8_2_3_D', 'Q8_2_3_E', 'Q8_2_3', 'Q8_2_3_OTHER', 'Q8_2_4', 'Q8_2_5', 'Q8_2_6', 'Q8_2_7'];
            IDList_show.forEach(EnableFields);
            var IDList_NotRequired=['Q8_1_1_B', 'Q8_1_1_C', 'Q8_1_1_D','Q8_2_1_HOSPITAL_2', 'Q8_2_1_DATE_ADMISSION_2', 'Q8_2_1_REASON_2', 'Q8_2_1_HOSPITAL_3', 'Q8_2_1_DATE_ADMISSION_3', 'Q8_2_1_REASON_3'];
            IDList_NotRequired.forEach(EnableFieldsWithoutRequired);
        } else {
            var IDList_off = ['Q8_1_1_A', 'Q8_1_1_B', 'Q8_1_1_C', 'Q8_1_1_D', 'Q8_1_2', 'Q8_1_2_OTHER', 'Q8_1_3_A', 'Q8_1_3_B', 'Q8_1_3_C', 'Q8_1_3_D', 'Q8_1_3_E', 'Q8_1_3_F', 'Q8_1_3_G', 'Q8_1_3_G_OTHER', 'Q8_1_4', 'Q8_2', 'Q8_2_1_HOSPITAL_1', 'Q8_2_1_DATE_ADMISSION_1', 'Q8_2_1_REASON_1', 'Q8_2_1_HOSPITAL_2', 'Q8_2_1_DATE_ADMISSION_2', 'Q8_2_1_REASON_2', 'Q8_2_1_HOSPITAL_3', 'Q8_2_1_DATE_ADMISSION_3', 'Q8_2_1_REASON_3', 'Q8_2_2', 'Q8_2_3_A', 'Q8_2_3_B', 'Q8_2_3_C', 'Q8_2_3_D', 'Q8_2_3_E', 'Q8_2_3', 'Q8_2_3_OTHER', 'Q8_2_4', 'Q8_2_5', 'Q8_2_6', 'Q8_2_7'];
            IDList_off.forEach(DisableFields);
            $(".Q8_1_yes_part").hide();
        }
    });

    $("#Q8_1_2").on('change', function () {
        if (this.value == 1938) {
            var IDList_off = ['Q8_1_3_A', 'Q8_1_3_B', 'Q8_1_3_C', 'Q8_1_3_D', 'Q8_1_3_E', 'Q8_1_3_F', 'Q8_1_3_G', 'Q8_1_3_G_OTHER', 'Q8_1_4', 'Q8_2', 'Q8_2_1_HOSPITAL_1', 'Q8_2_1_DATE_ADMISSION_1', 'Q8_2_1_REASON_1', 'Q8_2_1_HOSPITAL_2', 'Q8_2_1_DATE_ADMISSION_2', 'Q8_2_1_REASON_2', 'Q8_2_1_HOSPITAL_3', 'Q8_2_1_DATE_ADMISSION_3', 'Q8_2_1_REASON_3', 'Q8_2_2', 'Q8_2_3_A', 'Q8_2_3_B', 'Q8_2_3_C', 'Q8_2_3_D', 'Q8_2_3_E', 'Q8_2_3', 'Q8_2_3_OTHER', 'Q8_2_4', 'Q8_2_5', 'Q8_2_6', 'Q8_2_7'];
            IDList_off.forEach(DisableFields);
            $(".Q8_1_2_NoWhereTaken_part").hide();

        } else {
            $(".Q8_1_2_NoWhereTaken_part").show();
            var IDList_show = ['Q8_1_3_A', 'Q8_1_3_B', 'Q8_1_3_C', 'Q8_1_3_D', 'Q8_1_3_E', 'Q8_1_3_F', 'Q8_1_3_G', 'Q8_1_3_G_OTHER', 'Q8_1_4', 'Q8_2', 'Q8_2_1_HOSPITAL_1', 'Q8_2_1_DATE_ADMISSION_1', 'Q8_2_1_REASON_1', 'Q8_2_1_HOSPITAL_2', 'Q8_2_1_DATE_ADMISSION_2', 'Q8_2_1_REASON_2', 'Q8_2_1_HOSPITAL_3', 'Q8_2_1_DATE_ADMISSION_3', 'Q8_2_1_REASON_3', 'Q8_2_2', 'Q8_2_3_A', 'Q8_2_3_B', 'Q8_2_3_C', 'Q8_2_3_D', 'Q8_2_3_E', 'Q8_2_3', 'Q8_2_3_OTHER', 'Q8_2_4', 'Q8_2_5', 'Q8_2_6', 'Q8_2_7'];
            IDList_show.forEach(EnableFields);
        }
    });

    $("#Q8_2").on('change', function () {
        if (this.value == 1576) {
            $(".Q8_2_yes_part").show();
            var IDList_required = ['Q8_2_1_HOSPITAL_1', 'Q8_2_1_DATE_ADMISSION_1', 'Q8_2_1_REASON_1'];
            var IDList_show = ['Q8_2_1_HOSPITAL_2', 'Q8_2_1_DATE_ADMISSION_2', 'Q8_2_1_REASON_2', 'Q8_2_1_HOSPITAL_3', 'Q8_2_1_DATE_ADMISSION_3', 'Q8_2_1_REASON_3', 'Q8_2_2', 'Q8_2_3_A', 'Q8_2_3_B', 'Q8_2_3_C', 'Q8_2_3_D', 'Q8_2_3_E', 'Q8_2_3', 'Q8_2_3_OTHER', 'Q8_2_4', 'Q8_2_5', 'Q8_2_6', 'Q8_2_7'];
            IDList_show.forEach(EnableFieldsWithoutRequired);
            IDList_required.forEach(EnableFields);
        } else {
            var IDList_off = ['Q8_2_1_HOSPITAL_1', 'Q8_2_1_DATE_ADMISSION_1', 'Q8_2_1_REASON_1', 'Q8_2_1_HOSPITAL_2', 'Q8_2_1_DATE_ADMISSION_2', 'Q8_2_1_REASON_2', 'Q8_2_1_HOSPITAL_3', 'Q8_2_1_DATE_ADMISSION_3', 'Q8_2_1_REASON_3', 'Q8_2_2', 'Q8_2_3_A', 'Q8_2_3_B', 'Q8_2_3_C', 'Q8_2_3_D', 'Q8_2_3_E', 'Q8_2_3', 'Q8_2_3_OTHER', 'Q8_2_4', 'Q8_2_5', 'Q8_2_6', 'Q8_2_7'];
            IDList_off.forEach(DisableFields);
            $(".Q8_2_yes_part").hide();
        }
    });

    $("#Q8_3").on('change', function () {

        var IDList_off = ['Q8_3_1_VILL_NAME', 'Q8_3_1_BLOCK_NAME', 'Q8_3_1_BLOCK_CODE', 'Q8_3_2_HOSPITAL_NAME', 'Q8_3_2_HOSPITAL_ADDRESS'];
        IDList_off.forEach(DisableFields);
        $(".Q8_3_1_part").hide();
        $(".Q8_3_2_part").hide();

        var IDList_show = ['Q8_4', 'Q8_4_1', 'Q8_4_1_off', 'Q8_4_2'];
        IDList_show.forEach(EnableFields);
        $(".Q8_4_part").show();
        $(".Q8_4_yes_part").show();

        if (this.value == 1825 || this.value == 1827) {
            var IDList_required = ['Q8_3_1_VILL_NAME'];
            var IDList_show = ['Q8_3_1_BLOCK_NAME', 'Q8_3_1_BLOCK_CODE'];
            IDList_show.forEach(EnableFieldsWithoutRequired);
            IDList_required.forEach(EnableFields);
            $(".Q8_3_1_part").show();

        } else if (this.value == 1826) {
            var IDList_show = ['Q8_3_2_HOSPITAL_NAME', 'Q8_3_2_HOSPITAL_ADDRESS'];
            IDList_show.forEach(EnableFields);
            $(".Q8_3_2_part").show();
        } else if (this.value == 1828 || this.value == 1936) {
            var IDList_off = ['Q8_4', 'Q8_4_1', 'Q8_4_1_off', 'Q8_4_2'];
            IDList_off.forEach(DisableFields);
            $(".Q8_4_part").hide();
            $(".Q8_4_yes_part").hide();
        }
    });

    $("#Q8_4").on('change', function () {
        if (this.value == 1576) {
            var IDList_show = ['Q8_4_1', 'Q8_4_1_off', 'Q8_4_2'];
            IDList_show.forEach(EnableFields);
            $(".Q8_4_yes_part").show();

        } else {
            var IDList_off = ['Q8_4_1', 'Q8_4_1_off', 'Q8_4_2'];
            IDList_off.forEach(DisableFields);
            $(".Q8_4_yes_part").hide();
        }
    });

    $("#Q9_1").on('change', function () {

        if (this.value == 1576) {
            $("#Q9_3").val('').trigger('change');
            var IDList_off1 = ["Q9_3"];
            IDList_off1.forEach(DisableFields);
            $(".Q9_3_part").hide();

            $(".Q9_1_no_reluctant_unknown").show();
            var IDList_show = ["Q9_2"];
            IDList_show.forEach(EnableFields);

        } else {
            $("#Q9_2").val('').trigger('change');
            var IDList_off = ["Q9_2"];
            IDList_off.forEach(DisableFields);
            $(".Q9_1_no_reluctant_unknown").hide();

            $(".Q9_3_part").show();
            var IDList_show2 = ["Q9_3"];
            IDList_show2.forEach(EnableFields);

        }
    });

    $("#Q9_2").on('change', function () {
        var IDList_off2 = ["Q9_2_VDATE", "Q9_2_HIGH", "Q9_2_WEIG", "Q9_2_SYMP", "Q9_2_DIAG"
                    , "Q9_2_TRET"];
        IDList_off2.forEach(DisableFields);
        $(".Q9_2_part").hide();

        if (this.value == 1577 || this.value == 1578 || this.value == 1579) {
            var IDList_off2 = ["Q9_2_VDATE", "Q9_2_HIGH", "Q9_2_WEIG", "Q9_2_SYMP", "Q9_2_DIAG"
                        , "Q9_2_TRET"];
            IDList_off2.forEach(DisableFields);
            $(".Q9_2_part").hide();

            $(".Q9_3_part").show();
            var IDList_show = ["Q9_3"];
            IDList_show.forEach(EnableFields);

        } else if (this.value == 1576) {
//            alert("ggg");
            var IDList_off = ["Q9_3"];
            IDList_off.forEach(DisableFields);
            $(".Q9_3_part").hide();

            var IDList_show2 = ["Q9_2_VDATE", "Q9_2_HIGH", "Q9_2_WEIG", "Q9_2_SYMP", "Q9_2_DIAG"
                        , "Q9_2_TRET"];
            IDList_show2.forEach(EnableFields);
            $(".Q9_2_part").show();

        }
    });

    $("#Q9_3").on('change', function () {
        if (this.value == 1576) {
            $(".Q9_3_no_reluctant_unknown").show();
            var IDList_show =
                    ["Q9_4", "Q9_5_ICAUSE", "Q9_5_ICODE", "Q9_5_ACAUSE", "Q9_5_ACODE"
                                , "Q9_5_UCAUSE", "Q9_5_UCODE", "Q9_5_CCAUSE", "Q9_5_CCODE"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off =
                    ["Q9_4", "Q9_5_ICAUSE", "Q9_5_ICODE", "Q9_5_ACAUSE", "Q9_5_ACODE"
                                , "Q9_5_UCAUSE", "Q9_5_UCODE", "Q9_5_CCAUSE", "Q9_5_CCODE"];
            IDList_off.forEach(DisableFields);
            $(".Q9_3_no_reluctant_unknown").hide();

        }
    });


    $("#Q9_6").on('change', function () {
        if (this.value == 1576) {
            $(".Q9_6_yes_part").show();
            var IDList_show =
                    ["Q9_7", "Q9_8"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off =
                    ["Q9_7", "Q9_8"];
            IDList_off.forEach(DisableFields);
            $(".Q9_6_yes_part").hide();

        }
    });

    $("#Q9_9").on('change', function () {
        if (this.value == 1576) {
            $(".9_9_no_reluctant_unknown").show();
            var IDList_show =
                    ["Q9_9_1"];
            IDList_show.forEach(EnableFields);
        } else {
            $("#Q9_9_1").val('').trigger('change');
            var IDList_off =
                    ["Q9_9_1"];
            IDList_off.forEach(DisableFields);
            $(".9_9_no_reluctant_unknown").hide();

        }
    });

    $("#Q9_9_1").on('change', function () {
        var IDList_off =
                    ["Q9_9_2", "Q9_9_3"];
            IDList_off.forEach(DisableFields);
            $(".Q9_9_1_no_reluctant_unknown").hide();
        if (this.value == 1567) {
            $(".Q9_9_1_no_reluctant_unknown").show();
            var IDList_show =
                    ["Q9_9_2", "Q9_9_3"];
            IDList_show.forEach(EnableFields);
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

function EnableFieldsWithoutRequired(item) {
    $('#' + item).attr('disabled', false);
}
