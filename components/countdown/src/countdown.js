'use strict';
(function () {
    const SECONDS_IN_MINUTE = 60;
    const SECONDS_IN_HOUR = SECONDS_IN_MINUTE * 60;
    const SECONDS_IN_DAY = SECONDS_IN_HOUR * 24;

    let timers = document.querySelectorAll('.js-countdown');
    let currentDate = new Date();
    let UtcOffset = currentDate.getTimezoneOffset() * SECONDS_IN_MINUTE;
    let dateUntilArr;
    let dateUntilISO;
    let timeRemainingMiliSec;
    let timeRemainingSec;
    let timeRemainingArr = [];
    let days;
    let hours;
    let minutes;
    let seconds;

    let getTimeRemaining = function (timer) {
        dateUntilArr = timer.dataset.dateUntil.split('.');
        dateUntilISO = dateUntilArr[2] + '-' + dateUntilArr[1] + '-' + dateUntilArr[0];
        timeRemainingMiliSec = Date.parse(dateUntilISO) - Date.parse(new Date());
        timeRemainingSec = timeRemainingMiliSec / 1000 + UtcOffset;
        days = Math.floor(timeRemainingSec / SECONDS_IN_DAY);
        hours = Math.floor(timeRemainingSec % SECONDS_IN_DAY / SECONDS_IN_HOUR);
        seconds = timeRemainingSec % SECONDS_IN_MINUTE;
        minutes = Math.floor(timeRemainingSec % SECONDS_IN_HOUR / SECONDS_IN_MINUTE);

        return {
            'all': timeRemainingSec,
            'seconds' : seconds,
            'minutes' : minutes,
            'hours' : hours,
            'days' : days
        }

    };

    let updateTime = function (timer, timeArr) {
        timer.querySelector('.js-countdown-seconds').textContent = timeArr.seconds;
        timer.querySelector('.js-countdown-minutes').textContent = timeArr.minutes;
        timer.querySelector('.js-countdown-hours').textContent = timeArr.hours;
        timer.querySelector('.js-countdown-days').textContent = timeArr.days;
    };

    let init = function (timer, index) {
        window['interval_' + index] = setInterval(function () {
            let timeArr = getTimeRemaining(timer);
            updateTime(timer, timeArr);

            if (timeArr['all'] <= 0) {
                clearInterval(window['interval_' + index]);
            }
        }, 1000);
    };

    timers.forEach(function (timer, index) {
        init(timer, index);
    });

    window.countdown = {

    };
})();
