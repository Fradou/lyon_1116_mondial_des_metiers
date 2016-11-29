$(document).ready( function() {
    /** $('#tags').on('autocompletechange change', function () {
        $('#tagsname').html('You selected: ' + this.value);
    }).change(); **/

    var nbrep = 0;
    var nbrepava = response.length;

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

        if (resppos == -1 ) {
            $('#tagsname').html('Mauvais mot, try again');
        }
        else {
            nbrep ++;
            response.splice(resppos, 1);
            $('#tagsname').html('');
            if (nbrep == 5) {
                disabchoice();
                $('#nbresponse').html('Vous avez atteint le maximum de réponses autorisées.');
            }
            else {
                $('#tagdisplay').after(
                    '<div class="chip">' + respchosen + '<i class="close material-icons">close</i></div>');
                $('#nbresponse').html('Il vous reste encore maximum ' + (5 - nbrep) + ' reponses à donner.');
            }

        }

    });


    $(document).on('click', '.chip', function() {
        nbrep--;
        if (nbrep == 4) {
            enabchoice ()
        }
        response.push($(this).val());
        $(this).remove();
        $('#nbresponse').html('Il vous reste encore maximum ' + (5-nbrep) + ' reponses à donner.');
    });
});

/**
 $('#tags').on('change', function () {
       $('#tagsname').html('You selected: ' + this.value);
       nbrep ++;
       $('#nbresponse').html('Il vous reste encore ' + (5- nbrep) + ' reponses à donner')

   }).change();

 $('#tags').on('autocompleteselect', function (e, ui) {
        $('#tagsname').html('You selected: ' + ui.item.value);
        nbrep ++
    });
 **/


/*    for(i=0; i<nbrepava; i++) {
 if (document.getElementById("tags").value != response[i]) {
 $('#tagsname').html('Mauvais mot, try again');
 console.log(i);
 }
 else {
 $('#tagsname').html('');
 nbrep ++;
 if (nbrep == 5) {
 disabchoice();
 $('#nbresponse').html('Vous avez atteint le maximum de réponses autorisées.');
 console.log('une rep de bonne !');
 }
 else {
 $('#nbresponse').html('Il vous reste encore maximum ' + (5 - nbrep) + ' reponses à donner.');
 $('#tagdisplay').after(
 '<div class="chip">' + $('#tags').val() + '<i class="close material-icons">close</i></div>');
 }

 { break;}
 }
 }
 */