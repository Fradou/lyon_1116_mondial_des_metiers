$( document ).ready(function() {
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
                            '<div class="chip" id="'+ words[i].id +'"> # ' + words[i].word + '<i class="close material-icons">close</i></div>'
                    }
                    $('#wordautocomp').html(html);
                    $('#wordautocomp li').on('click', function() {
                        $('#ajaxbundle_contact_town').val($(this).text());
                        $('#wordautocomp').html('');
                    });
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
                        '<div class="chip" id="'+ wordh[i].id +'"> # ' + wordh[i].word + '<i class="close material-icons">close</i></div>'
                }
                $('#wordautocomp').html(html);
                $('#wordautocomp li').on('click', function() {
                    $('#ajaxbundle_contact_town').val($(this).text());
                    $('#wordautocomp').html('');
                });
            },
            error: function() {
                $('#wordautocomp').text('Ajax call error');
            }
        });

    });

});