$( document ).ready(function() {

    var nbrep = 0;

    function disabchoice () {
        $('#inputword').prop('disabled', true);
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

    $("#inputword").keyup(function(){
        var wordp = $(this).val();
        if ( wordp.length >= 1 ) {
            $.ajax({
                type: "POST",
                url: "/interview/search/" + wordp,
                dataType: 'json',
                timeout: 3000,
                success: function(response){
                    var words = JSON.parse(response.data);
                    html = "";
                    for (i = 0; i < words.length; i++) {
                        html +=
                            '<div class="chip tochoose" id="'+ words[i].id +'"> # ' + words[i].word + '</div>'
                    }
                    $('#wordautocomp').html(html);
                    $('.chip').on('click', function() {
                        if ($(this).hasClass("tochoose")) {
                            nbrep++;
                            $(this).addClass('chosen').removeClass('tochoose').append('<i class="close material-icons">close</i>').appendTo($("#chipchosen"));
                            console.log("j'inscremente");
                            if (nbrep == 5) {
                                disabchoice();
                                $('#nbresponse').html('Vous avez atteint le maximum de réponses autorisées.');
                            }
                            else {
                                $('#nbresponse').html('Il vous reste encore maximum ' + (5 - nbrep) + ' reponses à donner.');
                            }
                        }
                            //    $('#ajaxbundle_contact_town').val($(this).text());
                            //    $('#wordautocomp').html('');
                        else {
                            nbrep--;
                            console.log('je delete v0');
                            if (nbrep == 4) {
                                enabchoice ()
                            }
                            $(this).remove();
                            $('#nbresponse').html('Il vous reste encore jusqu\'à ' + (5-nbrep) + ' reponses à donner.');

                        }
                    });


                        //      var elemid = $(this).attr('id');
                        //     $(elemid).prop("checked", false);
                },
                error: function() {
                    $('#wordautocomp').text('Ajax call error');
                }
            });
        } else {
            $('#wordautocomp').html('');
        }
    });

    $("#noidea").click(function(){
        $.ajax({
            type: "POST",
            url: "/interview/searchhelp",
            dataType: 'json',
            timeout: 3000,
            success: function(response){
                var wordh = JSON.parse(response.data);
                html = "";
                for (i = 0; i < wordh.length; i++) {
                    html +=
                        '<div class="chip tochoose" id="'+ wordh[i].id +'"> # ' + wordh[i].word + '<i class="close material-icons">close</i></div>'
                }
                $('#wordautocomp').html(html);
                $('#wordautocomp .tochoose').on('click', function() {
                    nbrep ++;
                    $(this).addClass('chosen').removeClass('tochoose').appendTo($("#chipchosen"));

                    if (nbrep == 5) {
                        disabchoice();
                        $('#nbresponse').html('Vous avez atteint le maximum de réponses autorisées.');
                    }
                    else {
                        $('#nbresponse').html('Il vous reste encore maximum ' + (5 - nbrep) + ' reponses à donner.');
                    }

               //     $('#ajaxbundle_contact_town').val($(this).text());
               //     $('#wordautocomp').html('');
                });
            },
            error: function() {
                $('#wordautocomp').text('Ajax call error');
            }
        });

    });

});