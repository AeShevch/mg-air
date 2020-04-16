"use strict"; // TODO
// 2. Добавить категории

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance"); }

function _iterableToArray(iter) { if (Symbol.iterator in Object(iter) || Object.prototype.toString.call(iter) === "[object Arguments]") return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } }

(function () {
  /*
   * Константы
   * */
  var FAST_RESULT_TEMPLATE = document.getElementById("search-fast-results-item").content.querySelector(".js-fast-result-item-template");
  var FORM = document.querySelector(".js-search-form");
  var SEARCH_INPUT = FORM.querySelector(".js-search-input");
  var SEARCH_BTN_SEND = FORM.querySelector(".js-do-search");
  var FAST_RESULTS = FORM.querySelector(".js-search-fast-results");
  var CLOSE_BTN_MOBILE = FORM.querySelector(".js-close-search");
  var INPUT_MODIFICATOR = "a-search__input_opened";
  var CLOSE_BTN_MODIFICATOR = "a-search__close_hidden"; // Минимальная длина введённой строки, при которой начинается поиск быстрых результатов

  var textLengthMin = 3; // Коды клавиш

  var DOWN_BTN = 40;
  var UP_BTN = 38;
  var FIRST_ALLOWED_BTN = 48;
  var LAST_ALLOWED_BTN = 90;
  /*
   * Вспомогательные переменные
   * */

  var searchResult;
  var links; // Контейнер для вёрстки результатов быстрого поиска

  var fragment = document.createDocumentFragment();
  /*
   * Хэндлеры
   * */
  // Нажатие на esc закрывает быстрые результаты

  var _onEscPress = function _onEscPress(evt) {
    return window.utils.isEscapeEvent(evt, _clearResults);
  }; // Нажатие клавиш на инпуте поиска - ввод текста и клавиша «Вниз»


  var _onSearchInputKeyup = function _onSearchInputKeyup(evt) {
    var inputText = evt.target.value; // Ждём нажатие только на буквы и цифры

    if (evt.keyCode >= FIRST_ALLOWED_BTN && evt.keyCode <= LAST_ALLOWED_BTN) {
      // Если кол-во символов больше или равно заданному, то выводим результаты
      if (inputText.length >= textLengthMin) {
        _showFastResults(inputText); // Вешаем хэндлер на нажтие ESC


        document.addEventListener("keydown", _onEscPress);
      } else {
        _clearResults();
      }
    }

    window.utils.isEnterEvent(evt, _search); // Если нажали на клавишу вниз - фокусируемся на первом результате

    if (evt.keyCode === DOWN_BTN) {
      evt.preventDefault();
      var results = document.querySelectorAll(".js-fast-result-link");
      if (results) results[0].focus();
    }
  }; // Нажатие клавиш вверх-вниз на результатах поиска


  var _onFastResultKeyUp = function _onFastResultKeyUp(evt) {
    if (!window.utils.isEnterEvent(evt)) {
      evt.stopPropagation();
      evt.preventDefault();
      if (evt.keyCode === DOWN_BTN) _moveFocus("next");
      if (evt.keyCode === UP_BTN) _moveFocus("previous");
    }
  }; // Клик вне результатов


  var _clickOutsideResults = function _clickOutsideResults(evt) {
    return window.utils.isClickOutside(evt, FORM, _clearResults);
  }; // Клик по крестику в поиске


  var _onSearchClearClick = function _onSearchClearClick() {
    return _clearResults();
  }; // Клик по кнопке закрытия мобильного поиска


  var _onCloseMobileClick = function _onCloseMobileClick(evt) {
    evt.preventDefault();
    SEARCH_INPUT.classList.remove(INPUT_MODIFICATOR);
    CLOSE_BTN_MOBILE.classList.add(CLOSE_BTN_MODIFICATOR);
  };

  var _onOpenMobileSearch = function _onOpenMobileSearch(evt) {
    if (window.innerWidth < 920) {
      evt.preventDefault();
      SEARCH_INPUT.classList.add(INPUT_MODIFICATOR);
      SEARCH_INPUT.focus();
      CLOSE_BTN_MOBILE.classList.remove(CLOSE_BTN_MODIFICATOR);
    }
  };
  /*
   * Функции
   * */
  // Вешает слушатели


  var _setHandlers = function _setHandlers() {
    SEARCH_INPUT.addEventListener("keydown", _onSearchInputKeyup);
    CLOSE_BTN_MOBILE.addEventListener("click", _onCloseMobileClick);
    SEARCH_BTN_SEND.addEventListener("click", _onOpenMobileSearch);
  }; // Переход на страницу поиска


  var _search = function _search() {
    return window.location.href = mgBaseDir + '/catalog?search=' + SEARCH_INPUT.value;
  }; // Принимает строку и получает объект с найденными по этой строке товарами


  var getSearchData = function getSearchData(text) {
    fetch("".concat(mgBaseDir, "/catalog"), {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded"
      },
      body: window.utils.objToString({
        fastsearch: "true",
        text: text
      })
    }).then(function (response) {
      return response.json();
    }).then(function (result) {
      searchResult = result;
    });
    return searchResult;
  }; // Генерирует вёрстку с результатами поиска из шаблона


  var _createFastResultFragment = function _createFastResultFragment(resultsObj) {
    if (resultsObj !== undefined) {
      // Очищаем фрагмент
      fragment.innerHtml = ""; // И для каждого товара в результатах поиска создаём вёрстку и записываем во фрагмент

      resultsObj.item.items.catalogItems.forEach(function (result) {
        // Копируем шаблон
        var resultItem = FAST_RESULT_TEMPLATE.cloneNode(true); // Заполняем вёрстку данными
        // Ссылка

        var link = resultItem.querySelector(".js-fast-result-link");
        link.href = result.link;
        link.title = result.title; // Картинка

        var img = link.querySelector(".js-fast-result-img");
        img.src = result.image_url;
        img.alt = result.image_alt;
        img.title = result.image_title; // Заголовок, цена и категория

        link.querySelector(".js-fast-result-title").textContent = result.title;
        link.querySelector(".js-fast-result-category").textContent = "Категория / Подкатегория / Подкатегория";
        link.querySelector(".js-fast-result-price").textContent = result.price + " " + result.currency; // Вставляем полученную вёрстку во фрагмент

        fragment.appendChild(resultItem);
      });
      return fragment;
    }
  }; // Выводит результаты поиска


  var _showFastResults = function _showFastResults(text) {
    var searchResults = getSearchData(text);

    if (searchResults !== undefined) {
      // Очищаем результаты
      _clearResults(); // Вставляем вёрстку


      FAST_RESULTS.appendChild(_createFastResultFragment(searchResults)); // Вешаем хэндлеры на нажатия клавиш вверх-вниз

      links = FAST_RESULTS.querySelectorAll(".js-fast-result-link");

      _toConsumableArray(links).forEach(function (result) {
        result.addEventListener("keydown", _onFastResultKeyUp);
      }); // Вешаем хэндлер на клик вне результатов


      document.addEventListener("click", _clickOutsideResults); // Вешаем хэндлер на клик на крестик в поиске

      SEARCH_INPUT.addEventListener("search", _onSearchClearClick);
    }
  }; // Сдвигает фокус в указанном в параметре направлении


  var _moveFocus = function _moveFocus(direction) {
    // Сейчас в фокусе
    var focusedEl = document.activeElement; // Индекс элемента, на котором фокус

    var currentIndex = Array.prototype.indexOf.call(links, focusedEl); // Если двигаем фокус назад, то следующий элемент имеет индекс n + 1, если вперёд, то n - 1

    var nextEl = direction === "next" ? links[currentIndex + 1] : links[currentIndex - 1];
    var preventPreviousFocus = direction === "previous" && currentIndex === 0; // Если есть следующий элемент или это не первый, то фокусируемся на следующем

    if (nextEl && !preventPreviousFocus) nextEl.focus(); // Если это первый элемент, то фокусируемся на инпуте поиска

    if (preventPreviousFocus) SEARCH_INPUT.focus();
  };

  var _clearResults = function _clearResults() {
    FAST_RESULTS.innerHTML = ""; // Удаляем хэндлеры

    document.removeEventListener("click", _clickOutsideResults);
    document.removeEventListener("click", _onSearchClearClick);
    document.removeEventListener("keydown", _onEscPress);
    document.removeEventListener("keydown", _onFastResultKeyUp);
  };
  /*
   * Инициализация модуля
   * */


  var init = function init() {
    return _setHandlers();
  };

  init();
  /*
   * Интерфейс
   * */

  window.search = {
    getData: getSearchData
  };
})();