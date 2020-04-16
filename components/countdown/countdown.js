'use strict';

(function () {
  /*
  * Константы
  * */
  var SECONDS_IN_MINUTE = 60;
  var SECONDS_IN_HOUR = SECONDS_IN_MINUTE * 60;
  var SECONDS_IN_DAY = SECONDS_IN_HOUR * 24;
  /*
  * Переменные
  * */
  // Главный контейнер таймера

  var timers = document.querySelectorAll('.js-countdown'); // Вычисляем отклонения часового пояса в секундах

  var currentDate = new Date();
  var UtcOffset = currentDate.getTimezoneOffset() * SECONDS_IN_MINUTE; // Объявляем переменные, чтобы не делать это на каждое срабатывание обновления времени

  var dateUntilArr = [];
  var dateUntilISO;
  var timeRemainingMilliSec;
  var timeRemainingSec;
  /*
  * Функции
  * */
  // Возвращает объект с оставшимися днями, часами, секундами и минутами

  var getTimeRemaining = function getTimeRemaining(timer) {
    // Преобразуем полученную дату в ISO
    dateUntilArr = timer.dataset.dateUntil.split('.');
    dateUntilISO = dateUntilArr[2] + '-' + dateUntilArr[1] + '-' + dateUntilArr[0]; // Высчитываем оставшиеся милисекунды

    timeRemainingMilliSec = Date.parse(dateUntilISO) - Date.parse(new Date()); // Переводим в секунды, добавляем отклонение часового пояса

    timeRemainingSec = timeRemainingMilliSec / 1000 + UtcOffset;
    return {
      'all': timeRemainingSec,
      'seconds': timeRemainingSec % SECONDS_IN_MINUTE,
      'minutes': Math.floor(timeRemainingSec % SECONDS_IN_HOUR / SECONDS_IN_MINUTE),
      'hours': Math.floor(timeRemainingSec % SECONDS_IN_DAY / SECONDS_IN_HOUR),
      'days': Math.floor(timeRemainingSec / SECONDS_IN_DAY)
    };
  }; // Обновляет значения таймера


  var updateTime = function updateTime(timer, timeArr) {
    timer.querySelector('.js-countdown-seconds').textContent = timeArr ? timeArr.seconds : 0;
    timer.querySelector('.js-countdown-minutes').textContent = timeArr ? timeArr.minutes : 0;
    timer.querySelector('.js-countdown-hours').textContent = timeArr ? timeArr.hours : 0;
    timer.querySelector('.js-countdown-days').textContent = timeArr ? timeArr.days : 0;
  }; // Запускает таймер


  var init = function init(timer, index) {
    window['interval_' + index] = setInterval(function () {
      var timeArr = getTimeRemaining(timer);
      updateTime(timer, timeArr);

      if (timeArr['all'] <= 0) {
        clearInterval(window['interval_' + index]);
        updateTime(timer);
      }
    }, 1000);
  }; // Запускаем все таймеры на странице


  timers.forEach(function (timer, index) {
    init(timer, index);
  });
})();