$( document ).ready(function() {
    $("#chassebundle_job_domain").change(function(){
        var domain = $(this).val();
        $.ajax({
            type: "POST",
            url: "/job/choose/" + domain,
            dataType: 'json',
            timeout: 3000,
            success: function(response){
                var jobs = JSON.parse(response.data);
                html = "";
                for (i = 0; i < jobs.length; i++) {
                    html += "<option value=" + i + ">" +jobs[i].name + "</option>";
                }
                console.log(html);
                $('#job_choices').html(html).material_select();
            },
            error: function() {
                $('#job_choices').text('Ajax call error');
            }
        });
    });
});