$( document ).ready(function() {

    var nbrep = 0;

    function disabchoice () {
        $('#inputword').val("").prop('disabled', true);
        $("#noidea").prop('disabled', true);
        $('#wordautocomp').empty();
        console.log("disab use");
        //       document.getElementById("tags").value = "5 mots choisis, vous êtes au maximum !"
    }

    function enabchoice () {
        $('#inputword').prop('disabled', false);
        $("#noidea").prop('disabled', false);
        console.log("enab use");

    }

    function putchips (word) {
        html = "";
        for (i = 0; i < word.length; i++) {
            if ($('#chassebundle_interview_answers_' + word[i].id).is(':checked')){
            }
            else {
                html +=
                    '<div class="chip tochoose" id="'+ word[i].id +'"> # ' + word[i].word + '</div>'
            }
        }
        $('#wordautocomp').html(html);
    }

    $("#inputword").keyup(function(){
        var wordp = $(this).val();
        if ( wordp.length >= 1 ) {
            $.ajax({
                type: "POST",
                url: "/interview/search/" + wordp,
                dataType: 'json',
                timeout: 3000,
                success: function(response){
                    var result = JSON.parse(response.data);
                    putchips(result)},
                error: function() {
                    $('#wordautocomp').text('Ajax call error');
                }
            });
        }
    });

    $("#noidea").click(function(){
        $.ajax({
            type: "POST",
            url: "/interview/searchhelp",
            dataType: 'json',
            timeout: 3000,
            success: function(response){
                var result = JSON.parse(response.data);
                putchips(result)},
            error: function() {
                $('#wordautocomp').text('Ajax call error');
            }
        });

    });

    $(document).on('click', '.chip', function() {
        var chipclicked = '#chassebundle_interview_answers_' + $(this).attr('id');
        if ($(this).hasClass("tochoose")) {
            if ($(chipclicked).is(':checked')) {
                $('#nbresponse').html('Mot déjà selectionné ! mais il reste '+ (5 - nbrep))
            }
            else
            {
                nbrep++;
                $(chipclicked).prop( "checked", true );
                $(this).addClass('chosen').removeClass('tochoose').append('<i class="close material-icons">close</i>').appendTo($("#chipchosen"));
                console.log("j'incremente");
                if (nbrep == 5) {
                    disabchoice();
                    $('#nbresponse').html('Vous avez atteint le maximum de réponses autorisées.');
                }
                else {
                    $('#nbresponse').html('Il vous reste encore maximum ' + (5 - nbrep) + ' reponses à donner.');
                }
            }
        }
        else {
            nbrep--;
            console.log('je delete v0');
            $(chipclicked).prop("checked", false);
            $(this).remove();
            if (nbrep == 4) {
                enabchoice();
            }
            $('#nbresponse').html('Il vous reste encore jusqu\'à ' + (5-nbrep) + ' reponses à donner.');
        }
    });
});