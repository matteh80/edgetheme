jQuery(document).ready(function( $ ) {

    //Change time when slider
    $('#klasser_starttime').change(function() {
        starttime = $(this).val();
        endhour = parseInt(starttime.substring(0,2))+1;
        endhour = endhour.toString();
        if(endhour.length == 1) {
            endhour = "0"+endhour;
        }
        endminute = starttime.substring(3,5);
        endtime = endhour+":"+endminute;
        $('#klasser_endtime').val(endtime);
    })

    /*$('#klasser_endtime').change(function() {
        endtime = $(this).val();
        starthour = parseInt(endtime.substring(0,2))-1;
        starthour = starthour.toString();
        if(starthour.length == 1) {
            starthour = "0"+starthour;
        }
        startminute = endtime.substring(3,5);
        starttime = starthour+":"+startminute;
        $('#klasser_starttime').val(starttime);
    })*/

    // Change dansstil
    $('select').on('change', function (e) {
        var optionSelected = $("option:selected", this).attr("id");
        var valueSelected = this.id;

        $('#dansstilchecklist input:checkbox').removeAttr('checked');

        $('#dansstilchecklist input[value="'+optionSelected+'"]').attr('checked','checked');
    });

});

