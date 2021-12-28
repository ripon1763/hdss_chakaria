$(function () {

    $("#Q1_14").on('change', function () {
        if (this.value == 1576) {
            $(".Q1_15_part").show();
            var IDList_show = ["Q1_15","Q1_15_off"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q1_15","Q1_15_off"];
            IDList_off.forEach(DisableFields);
            $(".Q1_15_part").hide();
        }
    });
    $("#Q2_2").on('change', function () {
        if (this.value == 1576) {
            $(".Q2_3_part").show();
            var IDList_show = ["Q2_3"];
            IDList_show.forEach(EnableFields);
        } else {
            var IDList_off = ["Q2_3"];
            IDList_off.forEach(DisableFields);
            $(".Q2_3_part").hide();
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
