$(function () {

    $("#Q1_6").on('change', function () {
        if (this.value == 1568) {
            var IDList_off = ["Q1_6a", "Q1_6_1", "Q1_6_2", "Q1_6_2_off"];
            IDList_off.forEach(DisableFields);
            $(".Q1_6_yes").hide();

        } else {
            $(".Q1_6_yes").show();
            var IDList_show = ["Q1_6a", "Q1_6_1", "Q1_6_2", "Q1_6_2_off"];
            IDList_show.forEach(EnableFields);
        }
    });

    $("#Q1_6a").on('change', function () {
        if (this.value == 1624) {
            var IDList_off = ["Q1_6_1", "Q1_6_2", "Q1_6_2_off"];
            IDList_off.forEach(DisableFields);
            $(".Q1_6a_yes").hide();

        } else {
            $(".Q1_6a_yes").show();
            var IDList_show = ["Q1_6_1", "Q1_6_2", "Q1_6_2_off"];
            IDList_show.forEach(EnableFields);
        }
    });

    $("#Q1_6_1").on('change', function () {
        if (this.value == 1860) {
            $(".Q1_6_2_part").show();
            var IDList_show = ["Q1_6_2", "Q1_6_2_off"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q1_6_2", "Q1_6_2_off"];
            IDList_off.forEach(DisableFields);
            $(".Q1_6_2_part").hide();
        }
    });

    $("#Q5_1").on('change', function () {
        if (this.value == 1576) {
            $(".Q5_1_no_reluctant_unknown").show();
            var IDList_show = ["Q5_1_1", "Q5_1_2", "Q5_1_3", "Q5_1_4", "Q5_1_5", "Q5_1_6", "Q5_1_7_D", "Q5_1_7_H", "Q5_1_8"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q5_1_1", "Q5_1_2", "Q5_1_3", "Q5_1_4", "Q5_1_5", "Q5_1_6", "Q5_1_7_D", "Q5_1_7_H", "Q5_1_8"];
            IDList_off.forEach(DisableFields);
            $(".Q5_1_no_reluctant_unknown").hide();
        }
    });

    $("#Q5_1_8").on('change', function () {
        if (this.value == 1577 || this.value == 1578 || this.value == 1579) {
            var IDList_off = ['Q6_1', 'Q6_1_1', 'Q6_1_2', 'Q6_1_3', 'Q6_1_4_D', 'Q6_1_5', 'Q6_1_6', 'Q6_1_7', 'Q6_1_8', 'Q6_1_8_off', 'Q6_1_9_0', 'Q6_1_9_1', 'Q6_1_9_2', 'Q6_1_9_3_alive', 'Q6_1_9_3_dead', 'Q6_1_9_3_Normal_delivery', 'Q6_1_9_4', 'Q6_1_9_5', 'Q6_2_1', 'Q6_2_2_M', 'Q6_2_2_D', 'Q6_2_3', 'Q6_2_4', 'Q6_2_5', 'Q6_2_6', 'Q6_2_7', 'Q6_3_1', 'Q6_3_2_M', 'Q6_3_2_D', 'Q6_3_3', 'Q6_3_3_off', 'Q6_3_4', 'Q6_3_4_off', 'Q6_3_5', 'Q6_3_6', 'Q6_3_6_off', 'Q6_3_7', 'Q6_3_8', 'Q6_3_9', 'Q6_3_10_A', 'Q6_3_10_B', 'Q6_3_10_C', 'Q6_3_10_D', 'Q6_3_10_E', 'Q6_3_10_E_off', 'Q6_3_11', 'Q6_3_12', 'Q6_3_13', 'Q6_3_14', 'Q6_3_15_A', 'Q6_3_15_B', 'Q6_3_15_C', 'Q6_3_15_D', 'Q6_3_15_E', 'Q6_3_15_F', 'Q6_3_15_F_off', 'Q6_3_16_Y', 'Q6_3_16_M', 'Q6_3_17', 'Q6_3_18_Y', 'Q6_3_18_M', 'Q6_3_19', 'Q6_3_20', 'Q6_3_20_off', 'Q6_3_21', 'Q6_3_22', 'Q6_3_22_off', 'Q6_3_23', 'Q6_4', 'Q6_4a', 'Q6_4b', 'Q6_4c', 'Q6_4d_M', 'Q6_4d_D', 'Q6_4_1', 'Q6_4_2', 'Q6_4_3', 'Q6_4_4_M', 'Q6_4_4_D', 'Q6_4_5_A', 'Q6_4_5_B', 'Q6_4_5_C', 'Q6_4_5_D', 'Q6_4_5_E', 'Q6_4_5_F', 'Q6_4_5_G', 'Q6_4_5_G_off', 'Q6_4_6', 'Q6_5_1', 'Q6_5_1_1', 'Q6_5_2_M', 'Q6_5_2_D', 'Q6_5_3', 'Q6_5_4', 'Q6_5_5', 'Q6_6_1', 'Q6_6_2_A', 'Q6_6_2_B', 'Q6_6_2_C', 'Q6_6_2_D', 'Q6_6_2_E', 'Q6_6_2_F', 'Q6_6_2_F_off', 'Q6_6_3', 'Q6_6_3_off', 'Q6_6_3_1', 'Q6_6_3_2_M', 'Q6_6_3_2_D', 'Q6_6_4_A', 'Q6_6_4_B', 'Q6_6_4_C', 'Q6_6_4_D', 'Q6_6_4_E', 'Q6_6_4_E_off', 'Q6_6_5_M', 'Q6_6_5_D', 'Q6_6_6', 'Q6_6_7', 'Q6_7_1', 'Q6_7_1a', 'Q6_7_2_M', 'Q6_7_2_D', 'Q6_7_3', 'Q6_7_4', 'Q6_7_5', 'Q6_7_6', 'Q6_7_7', 'Q6_8_1', 'Q6_8_2_M', 'Q6_8_2_D', 'Q6_8_3', 'Q6_8_4_M', 'Q6_8_4_D', 'Q6_8_4_1', 'Q6_8_4_2_M', 'Q6_8_4_2_D', 'Q6_8_5', 'Q6_8_6', 'Q6_8_7', 'Q6_8_8', 'Q6_8_9', 'Q6_8_10', 'Q6_8_11', 'Q6_8_12', 'Q6_8_13', 'Q6_8_14', 'Q6_9_1', 'Q6_9_2', 'Q6_9_3', 'Q6_9_4', 'Q6_9_5', 'Q6_9_6', 'Q6_9_6_1', 'Q6_9_7', 'Q6_9_8', 'Q6_9_8_off', 'Q6_10_1', 'Q6_10_2_D', 'Q6_10_2_H', 'Q6_10_3', 'Q6_10_3_off', 'Q6_10_4', 'Q6_11_1', 'Q6_11_2', 'Q6_11_2_off', 'Q6_11_3', 'Q6_11_3_off', 'Q6_11_4', 'Q6_11_5_D', 'Q6_11_5_H', 'Q6_12_1', 'Q6_12_1a', 'Q6_12_2_D', 'Q6_12_2_H', 'Q6_12_3', 'Q6_12_4', 'Q6_13_1', 'Q6_13_2', 'Q6_13_2_off', 'Q6_13_3', 'Q6_14_1', 'Q6_14_2', 'Q6_14_3_M', 'Q6_14_3_D', 'Q6_15_2', 'Q6_15_3_M', 'Q6_15_3_D', 'Q6_15_4', 'Q6_15_5', 'Q6_16', 'Q6_16a', 'Q6_16b', 'Q6_16_1', 'Q6_16_2', 'Q6_16_3', 'Q6_16_4', 'Q6_17_1', 'Q6_17_2_D', 'Q6_17_2_H', 'Q6_17_3', 'Q6_17_4_D', 'Q6_17_4_H', 'Q6_17_5', 'Q6_17_6', 'Q6_18_1', 'Q7_1', 'Q7_1_4', 'Q7_2', 'Q7_2_3_D', 'Q7_2_4', 'Q7_2_5', 'Q7_2_6', 'Q7_2_7', 'Q6_15_1', 'Q6_18_2', 'Q6_18_2_off', 'Q6_18_3_Y', 'Q6_18_3_M', 'Q6_18_3_D', 'Q6_19_1', 'Q6_19_2', 'Q6_19_3', 'Q6_20_1', 'Q6_20_2', 'Q6_20_3', 'Q6_20_4a', 'Q6_20_4b', 'Q6_20_5_A', 'Q6_20_5_B', 'Q6_20_5_C', 'Q6_20_5_D', 'Q6_20_5_D_off', 'Q6_21_1', 'Q6_21_2_M', 'Q6_21_2_D', 'Q6_21_3', 'Q7_1_1_A', 'Q7_1_1_A_off', 'Q7_1_1_B', 'Q7_1_1_B_off', 'Q7_1_1_C', 'Q7_1_1_C_off', 'Q7_1_1_D', 'Q7_1_1_D_off', 'Q7_1_2', 'Q7_1_2_off', 'Q7_1_3_A', 'Q7_1_3_B', 'Q7_1_3_C', 'Q7_1_3_D', 'Q7_1_3_E', 'Q7_1_3_F', 'Q7_1_3_F_off', 'Q7_2_1_1_HCODE', 'Q7_2_1_1_DATE', 'Q7_2_1_1_CAUSE', 'Q7_2_1_2_HCODE', 'Q7_2_1_2_DATE', 'Q7_2_1_2_CAUSE', 'Q7_2_1_3_HCODE', 'Q7_2_1_3_DATE', 'Q7_2_1_3_CAUSE', 'Q7_2_2', 'Q7_2_3_A', 'Q7_2_3_B', 'Q7_2_3_C', 'Q7_2_3_D_off'];
            IDList_off.forEach(DisableFields);
            $(".Q5_1_8_no_reluctant_unknown").hide();
        } else {
            $(".Q5_1_8_no_reluctant_unknown").show();
            var IDList_show = ['Q6_1', 'Q6_1_1', 'Q6_1_2', 'Q6_1_3', 'Q6_1_4_D', 'Q6_1_5', 'Q6_1_6', 'Q6_1_7', 'Q6_1_8', 'Q6_1_8_off', 'Q6_1_9_0', 'Q6_1_9_1', 'Q6_1_9_2', 'Q6_1_9_3_alive', 'Q6_1_9_3_dead', 'Q6_1_9_3_Normal_delivery', 'Q6_1_9_4', 'Q6_1_9_5', 'Q6_2_1', 'Q6_2_2_M', 'Q6_2_2_D', 'Q6_2_3', 'Q6_2_4', 'Q6_2_5', 'Q6_2_6', 'Q6_2_7', 'Q6_3_1', 'Q6_3_2_M', 'Q6_3_2_D', 'Q6_3_3', 'Q6_3_3_off', 'Q6_3_4', 'Q6_3_4_off', 'Q6_3_5', 'Q6_3_6', 'Q6_3_6_off', 'Q6_3_7', 'Q6_3_8', 'Q6_3_9', 'Q6_3_10_A', 'Q6_3_10_B', 'Q6_3_10_C', 'Q6_3_10_D', 'Q6_3_10_E', 'Q6_3_10_E_off', 'Q6_3_11', 'Q6_3_12', 'Q6_3_13', 'Q6_3_14', 'Q6_3_15_A', 'Q6_3_15_B', 'Q6_3_15_C', 'Q6_3_15_D', 'Q6_3_15_E', 'Q6_3_15_F', 'Q6_3_15_F_off', 'Q6_3_16_Y', 'Q6_3_16_M', 'Q6_3_17', 'Q6_3_18_Y', 'Q6_3_18_M', 'Q6_3_19', 'Q6_3_20', 'Q6_3_20_off', 'Q6_3_21', 'Q6_3_22', 'Q6_3_22_off', 'Q6_3_23', 'Q6_4', 'Q6_4a', 'Q6_4b', 'Q6_4c', 'Q6_4d_M', 'Q6_4d_D', 'Q6_4_1', 'Q6_4_2', 'Q6_4_3', 'Q6_4_4_M', 'Q6_4_4_D', 'Q6_4_5_A', 'Q6_4_5_B', 'Q6_4_5_C', 'Q6_4_5_D', 'Q6_4_5_E', 'Q6_4_5_F', 'Q6_4_5_G', 'Q6_4_5_G_off', 'Q6_4_6', 'Q6_5_1', 'Q6_5_1_1', 'Q6_5_2_M', 'Q6_5_2_D', 'Q6_5_3', 'Q6_5_4', 'Q6_5_5', 'Q6_6_1', 'Q6_6_2_A', 'Q6_6_2_B', 'Q6_6_2_C', 'Q6_6_2_D', 'Q6_6_2_E', 'Q6_6_2_F', 'Q6_6_2_F_off', 'Q6_6_3', 'Q6_6_3_off', 'Q6_6_3_1', 'Q6_6_3_2_M', 'Q6_6_3_2_D', 'Q6_6_4_A', 'Q6_6_4_B', 'Q6_6_4_C', 'Q6_6_4_D', 'Q6_6_4_E', 'Q6_6_4_E_off', 'Q6_6_5_M', 'Q6_6_5_D', 'Q6_6_6', 'Q6_6_7', 'Q6_7_1', 'Q6_7_1a', 'Q6_7_2_M', 'Q6_7_2_D', 'Q6_7_3', 'Q6_7_4', 'Q6_7_5', 'Q6_7_6', 'Q6_7_7', 'Q6_8_1', 'Q6_8_2_M', 'Q6_8_2_D', 'Q6_8_3', 'Q6_8_4_M', 'Q6_8_4_D', 'Q6_8_4_1', 'Q6_8_4_2_M', 'Q6_8_4_2_D', 'Q6_8_5', 'Q6_8_6', 'Q6_8_7', 'Q6_8_8', 'Q6_8_9', 'Q6_8_10', 'Q6_8_11', 'Q6_8_12', 'Q6_8_13', 'Q6_8_14', 'Q6_9_1', 'Q6_9_2', 'Q6_9_3', 'Q6_9_4', 'Q6_9_5', 'Q6_9_6', 'Q6_9_6_1', 'Q6_9_7', 'Q6_9_8', 'Q6_9_8_off', 'Q6_10_1', 'Q6_10_2_D', 'Q6_10_2_H', 'Q6_10_3', 'Q6_10_3_off', 'Q6_10_4', 'Q6_11_1', 'Q6_11_2', 'Q6_11_2_off', 'Q6_11_3', 'Q6_11_3_off', 'Q6_11_4', 'Q6_11_5_D', 'Q6_11_5_H', 'Q6_12_1', 'Q6_12_1a', 'Q6_12_2_D', 'Q6_12_2_H', 'Q6_12_3', 'Q6_12_4', 'Q6_13_1', 'Q6_13_2', 'Q6_13_2_off', 'Q6_13_3', 'Q6_14_1', 'Q6_14_2', 'Q6_14_3_M', 'Q6_14_3_D', 'Q6_15_2', 'Q6_15_3_M', 'Q6_15_3_D', 'Q6_15_4', 'Q6_15_5', 'Q6_16', 'Q6_16a', 'Q6_16b', 'Q6_16_1', 'Q6_16_2', 'Q6_16_3', 'Q6_16_4', 'Q6_17_1', 'Q6_17_2_D', 'Q6_17_2_H', 'Q6_17_3', 'Q6_17_4_D', 'Q6_17_4_H', 'Q6_17_5', 'Q6_17_6', 'Q6_18_1', 'Q7_1', 'Q7_1_4', 'Q7_2', 'Q7_2_3_D', 'Q7_2_4', 'Q7_2_5', 'Q7_2_6', 'Q7_2_7', 'Q6_15_1', 'Q6_18_2', 'Q6_18_2_off', 'Q6_18_3_Y', 'Q6_18_3_M', 'Q6_18_3_D', 'Q6_19_1', 'Q6_19_2', 'Q6_19_3', 'Q6_20_1', 'Q6_20_2', 'Q6_20_3', 'Q6_20_4a', 'Q6_20_4b', 'Q6_20_5_A', 'Q6_20_5_B', 'Q6_20_5_C', 'Q6_20_5_D', 'Q6_20_5_D_off', 'Q6_21_1', 'Q6_21_2_M', 'Q6_21_2_D', 'Q6_21_3', 'Q7_1_1_A', 'Q7_1_1_A_off', 'Q7_1_1_B', 'Q7_1_1_B_off', 'Q7_1_1_C', 'Q7_1_1_C_off', 'Q7_1_1_D', 'Q7_1_1_D_off', 'Q7_1_2', 'Q7_1_2_off', 'Q7_1_3_A', 'Q7_1_3_B', 'Q7_1_3_C', 'Q7_1_3_D', 'Q7_1_3_E', 'Q7_1_3_F', 'Q7_1_3_F_off', 'Q7_2_1_1_HCODE', 'Q7_2_1_1_DATE', 'Q7_2_1_1_CAUSE', 'Q7_2_1_2_HCODE', 'Q7_2_1_2_DATE', 'Q7_2_1_2_CAUSE', 'Q7_2_1_3_HCODE', 'Q7_2_1_3_DATE', 'Q7_2_1_3_CAUSE', 'Q7_2_2', 'Q7_2_3_A', 'Q7_2_3_B', 'Q7_2_3_C', 'Q7_2_3_D_off'];
            IDList_show.forEach(EnableFieldsWithoutRequired);
        }
    });


    $("#Q6_1").on('change', function () {
        if (this.value == 1577 || this.value == 1578 || this.value == 1579) {
            var IDList_off = ["Q6_1_1", "Q6_1_2", "Q6_1_3", "Q6_1_4_D", "Q6_1_5", "Q6_1_6", "Q6_1_7", "Q6_1_8", "Q6_1_9_0", "Q6_1_9_1", "Q6_1_9_2"
                        , "Q6_1_9_3_alive", "Q6_1_9_3_dead", "Q6_1_9_3_Normal_delivery", "Q6_1_9_4", "Q6_1_9_5"];
            IDList_off.forEach(DisableFields);
            $(".Q6_1_no_reluctant_unknown").hide();
        } else {
            $(".Q6_1_no_reluctant_unknown").show();
            var IDList_show = ["Q6_1_1", "Q6_1_2", "Q6_1_3", "Q6_1_4_D", "Q6_1_5", "Q6_1_6", "Q6_1_7", "Q6_1_8", "Q6_1_9_0", "Q6_1_9_1", "Q6_1_9_2"
                        , "Q6_1_9_3_alive", "Q6_1_9_3_dead", "Q6_1_9_3_Normal_delivery", "Q6_1_9_4", "Q6_1_9_5"];
            IDList_show.forEach(EnableFields);
        }
    });

    $("#Q6_1_3").on('change', function () {
        if (this.value == 1576) {
            $(".Q6_1_3_no_reluctant_unknown").show();
            var IDList_show = ["Q6_1_4_D"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q6_1_4_D"];
            IDList_off.forEach(DisableFields);
            $(".Q6_1_3_no_reluctant_unknown").hide();
        }
    });
    $("#Q6_2_1").on('change', function () {
        if (this.value == 1576) {
            $(".Q6_2_1_no_reluctant_unknown").show();
            var IDList_show = ["Q6_2_2_M", "Q6_2_2_D", "Q6_2_3", "Q6_2_4", "Q6_2_5", "Q6_2_6"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q6_2_2_M", "Q6_2_2_D", "Q6_2_3", "Q6_2_4", "Q6_2_5", "Q6_2_6"];
            IDList_off.forEach(DisableFields);
            $(".Q6_2_1_no_reluctant_unknown").hide();
        }
    });

    $("#Q6_3_1").on('change', function () {
        if (this.value == 1576) {
            $(".Q6_3_1_yes").show();
            var IDList_show = ["Q6_3_2_M", "Q6_3_2_D", "Q6_3_3", "Q6_3_3_off", "Q6_3_4", "Q6_3_4_off"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q6_3_2_M", "Q6_3_2_D", "Q6_3_3", "Q6_3_3_off", "Q6_3_4", "Q6_3_4_off"];
            IDList_off.forEach(DisableFields);
            $(".Q6_3_1_yes").hide();
        }
    });

    $("#Q6_3_6").on('change', function () {
        if (this.value > 1683 && this.value < 1690) {
            $(".Q6_3_6_applicable").show();
            var IDList_show = ["Q6_3_7"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q6_3_7"];
            IDList_off.forEach(DisableFields);
            $(".Q6_3_6_applicable").hide();
        }
    });

    $("#Q6_3_12").on('change', function () {
        if (this.value == 1576) {
            $(".Q6_3_12_yes").show();
            var IDList_show = ["Q6_3_13"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q6_3_13"];
            IDList_off.forEach(DisableFields);
            $(".Q6_3_12_yes").hide();
        }
    });
    $("#Q6_3_14").on('change', function () {
        if (this.value == 1576) {
            $(".Q6_3_14_yes").show();
            var IDList_show = ["Q6_3_15_A", "Q6_3_15_B", "Q6_3_15_C", "Q6_3_15_D", "Q6_3_15_E", "Q6_3_15_F", "Q6_3_15_F_off"
                        , "Q6_3_16_Y", "Q6_3_16_M"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q6_3_15_A", "Q6_3_15_B", "Q6_3_15_C", "Q6_3_15_D", "Q6_3_15_E", "Q6_3_15_F", "Q6_3_15_F_off"
                        , "Q6_3_16_Y", "Q6_3_16_M"];
            IDList_off.forEach(DisableFields);
            $(".Q6_3_14_yes").hide();
        }
    });

    $("#Q6_3_17").on('change', function () {
        if (this.value == 1576) {
            $(".Q6_3_17_yes").show();
            var IDList_show = ["Q6_3_18_Y", "Q6_3_18_M"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q6_3_18_Y", "Q6_3_18_M"];
            IDList_off.forEach(DisableFields);
            $(".Q6_3_17_yes").hide();
        }
    });

    $("#Q6_3_19").on('change', function () {
        if (this.value == 1576) {
            $(".Q6_3_19_yes").show();
            var IDList_show = ["Q6_3_20", "Q6_3_20_off"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q6_3_20", "Q6_3_20_off"];
            IDList_off.forEach(DisableFields);
            $(".Q6_3_19_yes").hide();
        }
    });


    $("#Q6_3_21").on('change', function () {
        if (this.value == 1576) {
            $(".Q6_3_21_yes").show();
            var IDList_show = ["Q6_3_22", "Q6_3_22_off", "Q6_3_23"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q6_3_22", "Q6_3_22_off", "Q6_3_23"];
            IDList_off.forEach(DisableFields);
            $(".Q6_3_21_yes").hide();
        }
    });

    $("#Q6_4").on('change', function () {
        if (this.value == 1948) {
            $(".Q6_4_yes").show();
            var IDList_show = ["Q6_4a"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q6_4a"];
            IDList_off.forEach(DisableFields);
            $(".Q6_4_yes").hide();
            $("#Q6_4a").val('').trigger('change');
        }
    });

    $("#Q6_4a").on('change', function () {
        if (this.value == 1576) {
            $(".Q6_4a_yes").show();
            var IDList_show = ["Q6_4b"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q6_4b"];
            IDList_off.forEach(DisableFields);
            $(".Q6_4a_yes").hide();
            $("#Q6_4b").val('').trigger('change');
        }
    });
    $("#Q6_4b").on('change', function () {
        if (this.value == 1576) {
            $(".Q6_4b_yes").show();
            var IDList_show = ["Q6_4c"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q6_4c"];
            IDList_off.forEach(DisableFields);
            $(".Q6_4b_yes").hide();
            $("#Q6_4c").val('').trigger('change');
        }
    });
    $("#Q6_4c").on('change', function () {
        if (this.value == 1576) {
            $(".Q6_4c_yes").show();
            var IDList_show = ["Q6_4d_M", "Q6_4d_D"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q6_4d_M", "Q6_4d_D"];
            IDList_off.forEach(DisableFields);
            $(".Q6_4c_yes").hide();
        }
    });

    $("#Q6_4_3").on('change', function () {
        if (this.value == 1576) {
            $(".Q6_4_4_part").show();
            var IDList_show = ["Q6_4_4_M", "Q6_4_4_D"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q6_4_4_M", "Q6_4_4_D"];
            IDList_off.forEach(DisableFields);
            $(".Q6_4_4_part").hide();
        }
    });
    $("#Q6_5_1_1").on('change', function () {
        if (this.value == 1576) {
            $(".Q6_5_2_part").show();
            var IDList_show = ["Q6_5_2_M", "Q6_5_2_D"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q6_5_2_M", "Q6_5_2_D"];
            IDList_off.forEach(DisableFields);
            $(".Q6_5_2_part").hide();
        }
    });

    $("#Q6_5_3").on('change', function () {
        if (this.value == 1576) {
            $(".Q6_5_4_part").show();
            var IDList_show = ["Q6_5_4"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q6_5_4"];
            IDList_off.forEach(DisableFields);
            $(".Q6_5_4_part").hide();
        }
    });

    $("#Q6_6_1").on('change', function () {
        if (this.value == 1576) {
            $(".Q6_6_1_yes").show();
            var IDList_show = ["Q6_6_2_A", "Q6_6_2_B", "Q6_6_2_C",
                "Q6_6_2_D", "Q6_6_2_E", "Q6_6_2_F", "Q6_6_2_F_off", "Q6_6_3", "Q6_6_3_off"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q6_6_2_A", "Q6_6_2_B", "Q6_6_2_C",
                "Q6_6_2_D", "Q6_6_2_E", "Q6_6_2_F", "Q6_6_2_F_off", "Q6_6_3", "Q6_6_3_off"];
            IDList_off.forEach(DisableFields);
            $(".Q6_6_1_yes").hide();
        }
    });

    $("#Q6_6_3_1").on('change', function () {
        if (this.value == 1576) {
            $(".Q6_6_3_2_part").show();
            var IDList_show = ["Q6_6_3_2_M", "Q6_6_3_2_D"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q6_6_3_2_M", "Q6_6_3_2_D"];
            IDList_off.forEach(DisableFields);
            $(".Q6_6_3_2_part").hide();
        }
    });

    $("#Q6_7_1").on('change', function () {
        if (this.value == 1576) {
            $(".Q6_7_1_yes").show();
            var IDList_show = ["Q6_7_1a", "Q6_7_2_M", "Q6_7_2_D", "Q6_7_3", "Q6_7_4", "Q6_7_5", "Q6_7_6"
                        , "Q6_7_7"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q6_7_1a", "Q6_7_2_M", "Q6_7_2_D", "Q6_7_3", "Q6_7_4", "Q6_7_5", "Q6_7_6"
                        , "Q6_7_7"];
            IDList_off.forEach(DisableFields);
            $(".Q6_7_1_yes").hide();
        }
    });

    $("#Q6_8_1").on('change', function () {
        if (this.value == 1576) {
            $(".Q6_8_2_part").show();
            var IDList_show = ["Q6_8_2", "Q6_8_2_M", "Q6_8_2_D"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q6_8_2", "Q6_8_2_M", "Q6_8_2_D"];
            IDList_off.forEach(DisableFields);
            $(".Q6_8_2_part").hide();
        }
    });

    $("#Q6_8_3").on('change', function () {
        if (this.value == 1576) {
            $(".Q6_8_4_part").show();
            var IDList_show = ["Q6_8_4_M", "Q6_8_4_D"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q6_8_4_M", "Q6_8_4_D"];
            IDList_off.forEach(DisableFields);
            $(".Q6_8_4_part").hide();
        }
    });
    $("#Q6_8_4_1").on('change', function () {
        if (this.value == 1576) {
            $(".Q6_8_4_2_part").show();
            var IDList_show = ["Q6_8_4_2_M", "Q6_8_4_2_D"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q6_8_4_2_M", "Q6_8_4_2_D"];
            IDList_off.forEach(DisableFields);
            $(".Q6_8_4_2_part").hide();
        }
    });

    $("#Q6_9_1").on('change', function () {
        if (this.value == 1576) {
            $(".Q6_9_1_yes").show();
            var IDList_show = ["Q6_9_2", "Q6_9_3", "Q6_9_4", "Q6_9_5", "Q6_9_6", "Q6_9_6_1", "Q6_9_7"
                        , "Q6_9_8", "Q6_9_8_off"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q6_9_2", "Q6_9_3", "Q6_9_4", "Q6_9_5", "Q6_9_6", "Q6_9_6_1", "Q6_9_7"
                        , "Q6_9_8", "Q6_9_8_off"];
            IDList_off.forEach(DisableFields);
            $(".Q6_9_1_yes").hide();
        }
    });


    $("#Q6_9_7").on('change', function () {
        if (this.value == 1576) {
            $(".Q6_9_8_part").show();
            var IDList_show = ["Q6_9_8", "Q6_9_8_off"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q6_9_8", "Q6_9_8_off"];
            IDList_off.forEach(DisableFields);
            $(".Q6_9_8_part").hide();
        }
    });

    $("#Q6_10_1").on('change', function () {
        if (this.value == 1576) {
            $(".Q6_10_1_yes").show();
            var IDList_show = ["Q6_10_2_D", "Q6_10_2_H", "Q6_10_3", "Q6_10_3_off", "Q6_10_4"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q6_10_2_D", "Q6_10_2_H", "Q6_10_3", "Q6_10_3_off", "Q6_10_4"];
            IDList_off.forEach(DisableFields);
            $(".Q6_10_1_yes").hide();
        }
    });

    $("#Q6_11_1").on('change', function () {
        if (this.value == 1576) {
            $(".Q6_11_1_yes").show();
            var IDList_show = ["Q6_11_2", "Q6_11_2_off", "Q6_11_3", "Q6_11_3_off", "Q6_11_4", "Q6_11_5_D", "Q6_11_5_H"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q6_11_2", "Q6_11_2_off", "Q6_11_3", "Q6_11_3_off", "Q6_11_4", "Q6_11_5_D", "Q6_11_5_H"];
            IDList_off.forEach(DisableFields);
            $(".Q6_11_1_yes").hide();
        }
    });

    $("#Q6_12_1").on('change', function () {
        if (this.value == 1576) {
            $(".Q6_12_1_yes").show();
            var IDList_show = ["Q6_12_1a", "Q6_12_2_D", "Q6_12_2_H", "Q6_12_3", "Q6_12_4"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q6_12_1a", "Q6_12_2_D", "Q6_12_2_H", "Q6_12_3", "Q6_12_4"];
            IDList_off.forEach(DisableFields);
            $(".Q6_12_1_yes").hide();
        }
    });

    $("#Q6_12_3").on('change', function () {
        if (this.value == 1576) {
            $(".Q6_12_4_part").show();
            var IDList_show = ["Q6_12_4"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q6_12_4"];
            IDList_off.forEach(DisableFields);
            $(".Q6_12_4_part").hide();
        }
    });

    $("#Q6_13_1").on('change', function () {
        if (this.value == 1576) {
            $(".Q6_13_1_yes").show();
            var IDList_show = ["Q6_13_2", "Q6_13_2_off", "Q6_13_3", "Q6_13_4"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q6_12_4"];
            IDList_off.forEach(DisableFields);
            $(".Q6_13_1_yes").hide();
        }
    });

    $("#Q6_14_1").on('change', function () {
        if (this.value == 1624) {
            $(".Q6_14_1_yes").show();
            var IDList_show = ["Q6_14_2", "Q6_14_3_M", "Q6_14_3_D"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q6_14_2", "Q6_14_3_M", "Q6_14_3_D"];
            IDList_off.forEach(DisableFields);
            $(".Q6_14_1_yes").hide();
        }
    });

    $("#Q6_15_2").on('change', function () {
        if (this.value == 1576) {
            $(".Q6_15_3_part").show();
            var IDList_show = ["Q6_15_3_M", "Q6_15_3_D"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q6_15_3_M", "Q6_15_3_D"];
            IDList_off.forEach(DisableFields);
            $(".Q6_15_3_part").hide();
        }
    });

    $("#Q6_15_4").on('change', function () {
        if (this.value == 1962) {
            var IDList_off = ["Q6_15_5"];
            IDList_off.forEach(DisableFields);
            $(".Q6_15_5_part").hide();
        } else {

            $(".Q6_15_5_part").show();
            var IDList_show = ["Q6_15_5"];
            IDList_show.forEach(EnableFields);
        }
    });

    $("#Q6_16").on('change', function () {
        if (this.value == 1948) {
            $(".Q6_16_less_than_one_year").show();
            var IDList_show = ["Q6_16a", "Q6_16b"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q6_16a", "Q6_16b"];
            IDList_off.forEach(DisableFields);
            $(".Q6_16_less_than_one_year").hide();
        }
    });

    $("#Q6_16_1").on('change', function () {
        if (this.value == 1576) {
            $(".Q6_16_1_yes").show();
            var IDList_show = ["Q6_16_2", "Q6_16_3", "Q6_16_4"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q6_16_2", "Q6_16_3", "Q6_16_4"];
            IDList_off.forEach(DisableFields);
            $(".Q6_16_1_yes").hide();
        }
    });

    $("#Q6_17_1").on('change', function () {
        if (this.value == 1576) {
            $(".Q6_17_2_part").show();
            var IDList_show = ["Q6_17_2_D", "Q6_17_2_H"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q6_17_2_D", "Q6_17_2_H"];
            IDList_off.forEach(DisableFields);
            $(".Q6_17_2_part").hide();
        }
    });

    $("#Q6_17_3").on('change', function () {
        if (this.value == 1576) {
            $(".Q6_17_3_yes").show();
            var IDList_show = ["Q6_17_4_D", "Q6_17_4_H", "Q6_17_5", "Q6_17_6"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q6_17_4_D", "Q6_17_4_H", "Q6_17_5", "Q6_17_6"];
            IDList_off.forEach(DisableFields);
            $(".Q6_17_3_yes").hide();
        }
    });

    $("#Q6_18_1").on('change', function () {
        if (this.value == 1576) {
            $(".Q6_18_1_yes").show();
            var IDList_show = ["Q6_18_2", "Q6_18_2_off", "Q6_18_3_Y", "Q6_18_3_M", "Q6_18_3_D"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q6_18_2", "Q6_18_2_off", "Q6_18_3_Y", "Q6_18_3_M", "Q6_18_3_D"];
            IDList_off.forEach(DisableFields);
            $(".Q6_18_1_yes").hide();
        }
    });

    $("#Q6_19_1").on('change', function () {
        if (this.value == 1576) {
            $(".Q6_19_1_yes").show();
            var IDList_show = ["Q6_19_2", "Q6_19_3"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q6_19_2", "Q6_19_3"];
            IDList_off.forEach(DisableFields);
            $(".Q6_19_1_yes").hide();
        }
    });

    $("#Q6_20_1").on('change', function () {
        if (this.value == 1576) {
            $(".Q6_20_1_yes").show();
            var IDList_show = ["Q6_20_2", "Q6_20_3"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q6_20_2", "Q6_20_3"];
            IDList_off.forEach(DisableFields);
            $(".Q6_20_1_yes").hide();
        }
    });
    
     $("#Q6_20_4b").on('change', function () {
        if (this.value == 1576) {
            $(".Q6_20_5_part").show();
            var IDList_show = ['Q6_20_5_A', 'Q6_20_5_B', 'Q6_20_5_C', 'Q6_20_5_D', 'Q6_20_5_D_off'];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ['Q6_20_5_A', 'Q6_20_5_B', 'Q6_20_5_C', 'Q6_20_5_D', 'Q6_20_5_D_off'];
            IDList_off.forEach(DisableFields);
            $(".Q6_20_5_part").hide();
        }
    });

    $("#Q6_21_1").on('change', function () {
        if (this.value == 1576) {
            $(".Q6_21_1_yes").show();
            var IDList_show = ["Q6_21_2_M", "Q6_21_2_D", "Q6_21_3"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q6_21_2_M", "Q6_21_2_D", "Q6_21_3"];
            IDList_off.forEach(DisableFields);
            $(".Q6_21_1_yes").hide();
        }
    });


    $("#Q7_1").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_1_yes").show();
            var IDList_required = ["Q7_1_1_A", "Q7_1_1_A_off"];
            var IDList_show = ["Q7_1_1_B", "Q7_1_1_B_off",
                "Q7_1_1_C", "Q7_1_1_C_off", "Q7_1_1_D", "Q7_1_1_D_off", "Q7_1_2", "Q7_1_2_off"];
            IDList_show.forEach(EnableFieldsWithoutRequired);
            IDList_required.forEach(EnableFields);
        } else {
            var IDList_off = ["Q7_1_1_A", "Q7_1_1_A_off", "Q7_1_1_B", "Q7_1_1_B_off",
                "Q7_1_1_C", "Q7_1_1_C_off", "Q7_1_1_D", "Q7_1_1_D_off", "Q7_1_2", "Q7_1_2_off"];
            IDList_off.forEach(DisableFields);
            $(".Q7_1_yes").hide();
            $("#Q7_1_2").val('').trigger('change');
        }
    });

    $("#Q7_1_2").on('change', function () {
        if (this.value > 1649 && this.value < 1938) {
            $(".Q7_1_2_applicable").show();
            var IDList_show = [
                "Q7_1_3_A", "Q7_1_3_B", "Q7_1_3_C", "Q7_1_3_D", "Q7_1_3_E", "Q7_1_3_F", "Q7_1_3_F_off",
                "Q7_1_4", "Q7_2"];
            IDList_show.forEach(EnableFields);

        } else {
            var IDList_off = [
                "Q7_1_3_A", "Q7_1_3_B", "Q7_1_3_C", "Q7_1_3_D", "Q7_1_3_E", "Q7_1_3_F", "Q7_1_3_F_off",
                "Q7_1_4", "Q7_2"];
            IDList_off.forEach(DisableFields);
            $(".Q7_1_2_applicable").hide();
            $("#Q7_2").val('').trigger('change');

        }
    });

    $("#Q7_2").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_2_yes").show();
            var IDList_required = ["Q7_2_1_1_HCODE", "Q7_2_1_1_DATE", "Q7_2_1_1_CAUSE"];
             var IDList_show = ["Q7_2_1_2_HCODE",
                "Q7_2_1_2_DATE", "Q7_2_1_2_CAUSE", "Q7_2_1_3_HCODE", "Q7_2_1_3_DATE", "Q7_2_1_3_CAUSE", "Q7_2_2",
                "Q7_2_3_A", "Q7_2_3_B", "Q7_2_3_B", "Q7_2_3_C", "Q7_2_3_D", "Q7_2_3_D_off", "Q7_2_4", "Q7_2_5", "Q7_2_6",
                "Q7_2_7"];
            IDList_show.forEach(EnableFieldsWithoutRequired);
            IDList_required.forEach(EnableFields);

        } else {
            var IDList_off = ["Q7_2_1_1_HCODE", "Q7_2_1_1_DATE", "Q7_2_1_1_CAUSE", "Q7_2_1_2_HCODE",
                "Q7_2_1_2_DATE", "Q7_2_1_2_CAUSE", "Q7_2_1_3_HCODE", "Q7_2_1_3_DATE", "Q7_2_1_3_CAUSE", "Q7_2_2",
                "Q7_2_3_A", "Q7_2_3_B", "Q7_2_3_B", "Q7_2_3_C", "Q7_2_3_D", "Q7_2_3_D_off", "Q7_2_4", "Q7_2_5", "Q7_2_6",
                "Q7_2_7"];
            IDList_off.forEach(DisableFields);
            $(".Q7_2_yes").hide();
        }
    });


    $("#Q7_3").on('change', function () {
        if (this.value == 1826) {
            $(".Q7_3_health_service_institute").show();
            var IDList_show = ["Q7_3_1_Hname_Haddress", "Q7_3_2"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q7_3_1_Hname_Haddress", "Q7_3_2"];
            IDList_off.forEach(DisableFields);
            $(".Q7_3_health_service_institute").hide();
            $("#Q7_3_2").val('').trigger('change');
        }
    });


    $("#Q7_3_2").on('change', function () {
        if (this.value == 1576) {
            $(".Q7_3_2_yes").show();
            var IDList_show = ["Q7_3_3", "Q7_3_3_off", "Q7_3_4"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q7_3_3", "Q7_3_3_off", "Q7_3_4"];
            IDList_off.forEach(DisableFields);
            $(".Q7_3_2_yes").hide();
        }
    });

    $("#Q8_1").on('change', function () {
        if (this.value == 1576) {
            $(".Q8_1_yes").show();
            var IDList_show = ["Q8_1_1", "Q8_1_1_SYMP", "Q8_1_1_DIAG", "Q8_1_1_TRET", "Q8_1_2_weight_1", "Q8_1_2_weight_2"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q8_1_1", "Q8_1_1_SYMP", "Q8_1_1_DIAG", "Q8_1_1_TRET", "Q8_1_2_weight_1", "Q8_1_2_weight_2"];
            IDList_off.forEach(DisableFields);
            $(".Q8_1_yes").hide();
        }
    });

    $("#Q8_2").on('change', function () {
        if (this.value == 1576) {
            $(".Q8_2_yes").show();
            var IDList_show = ["Q8_2_1"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q8_2_1"];
            IDList_off.forEach(DisableFields);
            $(".Q8_2_yes").hide();
            $("#Q8_2_1").val('').trigger('change');
        }
    });

    $("#Q8_2_1").on('change', function () {
        if (this.value == 1567) {
            $(".Q8_2_1_yes").show();
            var IDList_show = ["Q8_2_2_ICAUSE", "Q8_2_2_ICODE", "Q8_2_2_ACAUSE", "Q8_2_2_ACODE", "Q8_2_2_UCAUSE", "Q8_2_2_UCODE", "Q8_2_2_CCAUSE", "Q8_2_2_CCODE"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q8_2_2_ICAUSE", "Q8_2_2_ICODE", "Q8_2_2_ACAUSE", "Q8_2_2_ACODE", "Q8_2_2_UCAUSE", "Q8_2_2_UCODE", "Q8_2_2_CCAUSE", "Q8_2_2_CCODE"];
            IDList_off.forEach(DisableFields);
            $(".Q8_2_1_yes").hide();
        }
    });

    $("#Q8_2_3").on('change', function () {
        if (this.value == 1576) {
            $(".Q8_2_3_yes").show();
            var IDList_show = ["Q8_2_4", "Q8_2_5"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q8_2_4", "Q8_2_5"];
            IDList_off.forEach(DisableFields);
            $(".Q8_2_3_yes").hide();
        }
    });

    $("#Q8_3").on('change', function () {
        if (this.value == 1576) {
            $(".Q8_3_yes").show();
            var IDList_show = ["Q8_3_1"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q8_3_1"];
            IDList_off.forEach(DisableFields);
            $(".Q8_3_yes").hide();
            $("#Q8_3_1").val('').trigger('change');
        }
    });

    $("#Q8_3_1").on('change', function () {
        if (this.value == 1567) {
            $(".Q8_3_1_yes").show();
            var IDList_show = ["Q8_3_2", "Q8_3_3"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q8_3_2", "Q8_3_3"];
            IDList_off.forEach(DisableFields);
            $(".Q8_3_1_yes").hide();
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
