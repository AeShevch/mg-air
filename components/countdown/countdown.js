'use strict';

(function () {
  var SECONDS_IN_MINUTE = 60;
  var SECONDS_IN_HOUR = SECONDS_IN_MINUTE * 60;
  var SECONDS_IN_DAY = SECONDS_IN_HOUR * 24;
  var timers = document.querySelectorAll('.js-countdown');
  var currentDate = new Date();
  var UtcOffset = currentDate.getTimezoneOffset() * SECONDS_IN_MINUTE;
  var dateUntilArr;
  var dateUntilISO;
  var timeRemainingMiliSec;
  var timeRemainingSec;
  var timeRemainingArr = [];
  var days;
  var hours;
  var minutes;
  var seconds;

  var getTimeRemaining = function getTimeRemaining(timer) {
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
      'seconds': seconds,
      'minutes': minutes,
      'hours': hours,
      'days': days
    };
  };

  var updateTime = function updateTime(timer, timeArr) {
    timer.querySelector('.js-countdown-seconds').textContent = timeArr.seconds;
    timer.querySelector('.js-countdown-minutes').textContent = timeArr.minutes;
    timer.querySelector('.js-countdown-hours').textContent = timeArr.hours;
    timer.querySelector('.js-countdown-days').textContent = timeArr.days;
  };

  var init = function init(timer, index) {
    window['interval_' + index] = setInterval(function () {
      var timeArr = getTimeRemaining(timer);
      updateTime(timer, timeArr);

      if (timeArr['all'] <= 0) {
        clearInterval(window['interval_' + index]);
      }
    }, 1000);
  };

  timers.forEach(function (timer, index) {
    init(timer, index);
  });
  window.countdown = {};
})();