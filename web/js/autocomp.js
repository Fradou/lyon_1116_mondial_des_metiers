$(document).ready( function() {
    /** $('#tags').on('autocompletechange change', function () {
        $('#tagsname').html('You selected: ' + this.value);
    }).change(); **/

    var nbrep = 0;

    function disabchoice () {
        $('#tags').prop('disabled', true);
        document.getElementById("tags").value = "5 mots choisis, vous êtes au maximum !"
    }
    function enabchoice () {
        document.getElementById("tags").value = "";
        $('#tags').prop('disabled', false);
    }

    $('#tags').change(function () {
        var respchosen = $(this).val();
        var resppos = jQuery.inArray(respchosen, response);
        var idchosen = '#chassebundle_interview_answers_'+ (resppos +1);


        if (resppos == -1 ) {
            $('#tagsname').html('Mauvais mot, reessayez !');
            document.getElementById("tags").value = "";

        }
        else if ($(idchosen).is(':checked')) {
            $('#tagsname').html('Mot déjà selectionné connard !');
            document.getElementById("tags").value = "";

        }
        else {
            nbrep ++;

            $('#tagsname').html('');
            $(idchosen).prop( "checked", true );
            document.getElementById("tags").value = "";

            $('#tagdisplay').after(
                '<div class="chip" id="'+idchosen+'">' + respchosen + '<i class="close material-icons">close</i></div>');

            if (nbrep == 5) {
                disabchoice();
                $('#nbresponse').html('Vous avez atteint le maximum de réponses autorisées.');
            }
            else {
                $('#nbresponse').html('Il vous reste encore maximum ' + (5 - nbrep) + ' reponses à donner.');
            }

        }

    });


    $(document).on('click', '.chip', function() {

        nbrep--;
        if (nbrep == 4) {
            enabchoice ()
        }

        var elemid = $(this).attr('id');
        $(elemid).prop("checked", false);
        $(this).remove();
        $('#nbresponse').html('Il vous reste encore maximum ' + (5-nbrep) + ' reponses à donner.');
    });
});

/**
 $('#tags').on('change', function () {


   }).change();

 $('#tags').on('autocompleteselect', function (e, ui) {
        $('#tagsname').html('You selected: ' + ui.item.value);
        nbrep ++
    });
 **/
