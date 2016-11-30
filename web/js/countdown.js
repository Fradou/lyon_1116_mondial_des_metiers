function countdown()

{
    var countdown = document.getElementById("countdown");
    var current_date = new Date();
    var event_date = new Date("Nov 30 18:00:00 2016");
    var total_seconds = (event_date - current_date) / 1000;


    if (total_seconds > 0)
    {
        var days = Math.floor(total_seconds / (60 * 60 * 24));
        var hours = Math.floor((total_seconds - (days * 60 * 60 * 24)) / (60 * 60));
        var minutes = Math.floor((total_seconds - ((days * 60 * 60 * 24 + hours * 60 * 60))) / 60);
        var seconds = Math.floor(total_seconds - ((days * 60 * 60 * 24 + hours * 60 * 60 + minutes * 60)));
        var et = "et";
        var word_day = "jours,";
        var word_hour = "heures,";
        var word_minute = "minutes,";
        var word_second = "secondes";
        if (days == 0)
        {
            days = '';
            word_day = '';
        }
        else if (days == 1)
        {
            word_day = "jour,";
        }
        if (hours == 0)
        {
            hours = '';
            word_hour = '';
        }
        else if (hours == 1)
        {
            word_hour = "heure,";
        }
        if (minutes == 0)
        {
            minutes = '';
            word_minute = '';
        }
        else if (minutes == 1)
        {
            word_minute = "minute,";
        }
        if (seconds == 0)
        {
            seconds = '';
            word_second = '';
            et = '';
        }
        else if (seconds == 1)
        {
            word_second = "seconde";
        }
        if (minutes == 0 && hours == 0 && days == 0)
        {
            et = "";
        }
        countdown.innerHTML = days + ' ' + word_day + ' ' + hours + ' ' + word_hour + ' ' + minutes + ' ' + word_minute + ' ' + et + ' ' + seconds + ' ' + word_second;
    }

    var actualisation = setTimeout("countdown()", 1000);
}

countdown();
