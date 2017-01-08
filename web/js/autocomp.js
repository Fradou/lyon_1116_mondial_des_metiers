$(document).ready( function() {

    var nbrep = 0;

    function resetfield () {
        document.getElementById("tags").value = "";
    }

    function disabchoice () {
        $('#inputword').prop('disabled', true);
        document.getElementById("tags").value = "5 mots choisis, vous êtes au maximum !"
    }
    function enabchoice () {
        resetfield();
        $('#inputword').prop('disabled', false);
    }

    $('#tags').change(function () {
        var respchosen = $(this).val();
        var resppos = jQuery.inArray(respchosen, response);
        var idchosen = '#chassebundle_interview_answers_'+ (resppos +1);


        if (resppos == -1 ) {
            $('#tagsname').html('Mauvais mot, reessayez !');
            resetfield ();
        }
        else if ($(idchosen).is(':checked')) {
            $('#tagsname').html('Mot déjà selectionné !');
            resetfield ();
        }
        else {
            nbrep ++;

            $('#tagsname').html(' ');
            $(idchosen).prop( "checked", true );
            resetfield ();

            $('#tagdisplay').after(
                '<div class="chip chipchosen" id="'+idchosen+'">' + respchosen + '<i class="close material-icons">close</i></div>'
            );

            if (nbrep == 5) {
                disabchoice();
                $('#nbresponse').html('Vous avez atteint le maximum de réponses autorisées.');
            }
            else {
                $('#nbresponse').html('Il vous reste encore maximum ' + (5 - nbrep) + ' reponses à donner.');
            }

        }

    });

    $(document).on('click', '.chipchosen', function() {

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
