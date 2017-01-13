$( document ).ready(function() {
    $('#chassebundle_job_domain').change(function () {
        console.log($(this).val());
            var domain = $(this).val();
            $.ajax({
                type: "POST",
                url: "/interview/choose/" + domain,
                dataType: 'json',
                timeout: 3000,
                success: function (response) {
                    var jobs = JSON.parse(response.data);
                    html = "<option value='' disabled selected>Choisis le métier</option>";
                    for (i = 0; i < jobs.length; i++) {
                        html += "<option value=" + jobs[i].id + ">" + jobs[i].name + "</option>";
                    }
                    $('#chassebundle_job_name').html(html).material_select();
                },
                error: function () {
                    $('#chassebundle_job_name').text('Ajax call error');
                }
            });
    });
    $(document).on('change','#chassebundle_job_name', function (){
        console.log($(this).val());
    } )
});