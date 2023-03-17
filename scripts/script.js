window.onload = function () {


    var years = 0;
    var days = 0;
    var hours = 0;
    var minutes = 0;
    var seconds = 0;
    var tens = 0;
    var appendTens = document.getElementById("tens");
    var appendSeconds = document.getElementById("seconds");
    var appendMinutes = document.getElementById("minutes");
    var appendHours = document.getElementById("hours");
    var appendDays = document.getElementById("days");
    var appendYears = document.getElementById("years");
    var buttonStart = document.getElementById("button-start")
    var buttonStop = document.getElementById("button-stop")
    var buttonReset = document.getElementById("button-reset")
    var Interval;

    buttonStart.onclick = function() {

        clearInterval(Interval);
        Interval = setInterval(startTimer, 10);
    }

    buttonStop.onclick = function() {

        clearInterval(Interval);
    }

    buttonReset.onclick = function() {

        clearInterval(Interval);
        tens = "00";
        seconds = "00";
        minutes = "00";
        hours = "00";
        days = "0";
        years = "0";
        appendTens.innerHTML = tens;
        appendSeconds.innerHTML = seconds;
        appendMinutes.innerHTML = minutes;
        appendHours.innerHTML = hours;
        appendDays.innerHTML = days;
        appendYears.innerHTML = years;
    }

    function startTimer(){
        tens++;
        hours+=43;
        if(tens <= 9){
            appendTens.innerHTML = "0" +tens;
        }

        if(tens > 9){
            appendTens.innerHTML = tens;
        }

        if(tens > 99){
            seconds++;
            appendSeconds.innerHTML = "0" + seconds;
            tens = 0;
            appendTens.innerHTML = "0" + 0;
        }

        if(seconds > 9){
            appendSeconds.innerHTML = seconds;
        }

        if(seconds > 59){
            minutes++;
            appendMinutes.innerHTML = "0" + minutes;
            seconds = 0;
            appendSeconds.innerHTML = "0" + 0;
        }

        if(minutes > 9){
            appendMinutes.innerHTML = minutes;
        }

        if(minutes > 59){
            hours++;
            appendHours.innerHTML = "0" + hours;
            minutes = 0;
            appendMinutes.innerHTML = "0" + 0;
        }

        if(hours > 9){
            appendHours.innerHTML = hours;
        }

        if(hours > 23){
            days++;
            appendDays.innerHTML = days;
            hours = 0;
            appendHours.innerHTML = "0" + 0;
        }

        if(years%4==0){
            if(days > 366){
                years++;
                appendYears.innerHTML = years;
                days = 0;
                appendDays.innerHTML = 0;
            }
        }
        else{
            if(days > 365){
                years++;
                appendYears.innerHTML = years;
                days = 0;
                appendDays.innerHTML = 0;
            }
        }
    }
}