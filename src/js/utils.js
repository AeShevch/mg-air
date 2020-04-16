(function () {
    /*
    * Константы
    * */
    var ESC_KEY = 'Escape';
    var ENTER_KEY = 'Enter';

    /*
    * Хэндлеры
    * */
    // Хэндлер на нажатие клавиши Esc, принимает параметрами эвент и функцию, которую необходимо выполнить
    var isEscapeEvent = function (evt, action) {
        if (evt.key === ESC_KEY) {
            action();
        }
    };
    // Хэндлер на нажатие клавиши Enter, принимает параметрами эвент и функцию, которую необходимо выполнить
    var isEnterEvent = function (evt, action) {
        if (evt.key === ENTER_KEY) {
            action();
        }
    };

    // Получает объект, возвращает строку для передачи по Ajax
    let objToString = function (obj) {
        return Object.keys(obj).map(function (k) {
            return encodeURIComponent(k) + '=' + encodeURIComponent(obj[k])
        }).join('&');
    };

    // Выполняет callback, если клик произошёл вне указанного элемента
    let isClickOutside = function (evt, elem, callback) {
        if (!elem.contains(evt.target)) callback();
    };

    /*
    * Интерфейс
    * */
    window.utils = {
        objToString: objToString,
        isClickOutside: isClickOutside,
        isEscapeEvent: isEscapeEvent,
        isEnterEvent: isEnterEvent
    }
})();
