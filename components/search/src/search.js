"use strict";
// TODO
// 2. Добавить категории
(function () {
  /*
   * Константы
   * */
  const FAST_RESULT_TEMPLATE = document
    .getElementById("search-fast-results-item")
    .content.querySelector(".js-fast-result-item-template");
  const FORM = document.querySelector(".js-search-form");
  const SEARCH_INPUT = FORM.querySelector(".js-search-input");
  const SEARCH_BTN_SEND = FORM.querySelector(".js-do-search");
  const FAST_RESULTS = FORM.querySelector(".js-search-fast-results");
  const CLOSE_BTN_MOBILE = FORM.querySelector(".js-close-search");
  const INPUT_MODIFICATOR = "a-search__input_opened";
  const CLOSE_BTN_MODIFICATOR = "a-search__close_hidden";
  // Минимальная длина введённой строки, при которой начинается поиск быстрых результатов
  const textLengthMin = 3;
  // Коды клавиш
  const DOWN_BTN = 40;
  const UP_BTN = 38;
  const FIRST_ALLOWED_BTN = 48;
  const LAST_ALLOWED_BTN = 90;

  /*
   * Вспомогательные переменные
   * */
  let searchResult;
  let links;
  // Контейнер для вёрстки результатов быстрого поиска
  let fragment = document.createDocumentFragment();

  /*
   * Хэндлеры
   * */
  // Нажатие на esc закрывает быстрые результаты
  let _onEscPress = function (evt) {
    window.utils.isEscapeEvent(evt, _clearResults);
  };
  // Нажатие клавиш на инпуте поиска - ввод текста и клавиша «Вниз»
  let _onSearchInputKeyup = function (evt) {
    let inputText = evt.target.value;

    // Ждём нажатие только на буквы и цифры
    if (evt.keyCode >= FIRST_ALLOWED_BTN && evt.keyCode <= LAST_ALLOWED_BTN) {
      // Если кол-во символов больше или равно заданному, то выводим результаты
      if (inputText.length >= textLengthMin) {
        _showFastResults(inputText);
        // Вешаем хэндлер на нажтие ESC
        document.addEventListener("keydown", _onEscPress);
      } else {
        _clearResults();
      }
    }

    // Если нажали на клавишу вниз - фокусируемся на первом результате
    if (evt.keyCode === DOWN_BTN) {
      evt.preventDefault();
      let results = document.querySelectorAll(".js-fast-result-link");
      if (results) {
        results[0].focus();
      }
    }
  };
  // Нажатие клавиш вверх-вниз на результатах поиска
  let _onFastResultKeyUp = function (evt) {
    evt.stopPropagation();
    evt.preventDefault();
    if (evt.keyCode === DOWN_BTN) _moveFocus("next");
    if (evt.keyCode === UP_BTN) _moveFocus("previous");
  };
  // Клик вне результатов
  let _clickOutsideResults = function (evt) {
    window.utils.isClickOutside(evt, FORM, _clearResults);
  };
  // Клик по крестику в поиске
  let _onSearchClearClick = function () {
    _clearResults();
  };
  // Клик по кнопке закрытия мобильного поиска
  let _onCloseMobileClick = function (evt) {
    evt.preventDefault();
    SEARCH_INPUT.classList.remove(INPUT_MODIFICATOR);
    CLOSE_BTN_MOBILE.classList.add(CLOSE_BTN_MODIFICATOR);
  };
  let _onOpenMobileSearch = function (evt) {
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
  let _setHandlers = function () {
    SEARCH_INPUT.addEventListener("keydown", _onSearchInputKeyup);
    CLOSE_BTN_MOBILE.addEventListener("click", _onCloseMobileClick);
    SEARCH_BTN_SEND.addEventListener("click", _onOpenMobileSearch);
  };

  // Принимает строку и получает объект с найденными по этой строке товарами
  let getSearchData = function (text) {
    fetch(`${mgBaseDir}/catalog`, {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: window.utils.objToString({ fastsearch: "true", text: text }),
    })
      .then((response) => response.json())
      .then((result) => {
        searchResult = result;
      });
    return searchResult;
  };

  // Генерирует вёрстку с результатами поиска из шаблона
  let _createFastResultFragment = function (resultsObj) {
    if (resultsObj !== undefined) {
      // Очищаем фрагмент
      fragment.innerHtml = "";
      // И для каждого товара в результатах поиска создаём вёрстку и записываем во фрагмент
      resultsObj.item.items.catalogItems.forEach(function (result) {
        // Копируем шаблон
        let resultItem = FAST_RESULT_TEMPLATE.cloneNode(true);

        // Заполняем вёрстку данными
        // Ссылка
        let link = resultItem.querySelector(".js-fast-result-link");
        link.href = result.link;
        link.title = result.title;
        // Картинка
        let img = link.querySelector(".js-fast-result-img");
        img.src = result.image_url;
        img.alt = result.image_alt;
        img.title = result.image_title;
        // Заголовок, цена и категория
        link.querySelector(".js-fast-result-title").textContent = result.title;
        link.querySelector(".js-fast-result-category").textContent =
          "Категория / Подкатегория / Подкатегория";
        link.querySelector(".js-fast-result-price").textContent =
          result.price + " " + result.currency;

        // Вставляем полученную вёрстку во фрагмент
        fragment.appendChild(resultItem);
      });
      return fragment;
    }
  };

  // Выводит результаты поиска
  let _showFastResults = function (text) {
    let searchResults = getSearchData(text);
    if (searchResults !== undefined) {
      // Очищаем результаты
      _clearResults();
      // Вставляем вёрстку
      FAST_RESULTS.appendChild(_createFastResultFragment(searchResults));

      // Вешаем хэндлеры на нажатия клавиш вверх-вниз
      links = FAST_RESULTS.querySelectorAll(".js-fast-result-link");
      [...links].forEach(function (result) {
        result.addEventListener("keydown", _onFastResultKeyUp);
      });

      // Вешаем хэндлер на клик вне результатов
      document.addEventListener("click", _clickOutsideResults);

      // Вешаем хэндлер на клик на крестик в поиске
      SEARCH_INPUT.addEventListener("search", _onSearchClearClick);
    }
  };

  // Сдвигает фокус в указанном в параметре направлении
  let _moveFocus = function (direction) {
    // Сейчас в фокусе
    let focusedEl = document.activeElement;
    // Индекс элемента, на котором фокус
    const currentIndex = Array.prototype.indexOf.call(links, focusedEl);

    // Если двигаем фокус назад, то следующий элемент имеет индекс n + 1, если вперёд, то n - 1
    const nextEl =
      direction === "next" ? links[currentIndex + 1] : links[currentIndex - 1];

    const preventPreviousFocus = direction === "previous" && currentIndex === 0;

    // Если есть следующий элемент или это не первый, то фокусируемся на следующем
    if (nextEl && !preventPreviousFocus) nextEl.focus();
    // Если это первый элемент, то фокусируемся на инпуте поиска
    if (preventPreviousFocus) SEARCH_INPUT.focus();
  };

  let _clearResults = function () {
    FAST_RESULTS.innerHTML = "";

    // Удаляем хэндлеры
    document.removeEventListener("click", _clickOutsideResults);
    document.removeEventListener("click", _onSearchClearClick);
    document.removeEventListener("keydown", _onEscPress);
    document.removeEventListener("keydown", _onFastResultKeyUp);
  };

  /*
   * Инициализация модуля
   * */
  let init = function () {
    _setHandlers();
  };

  init();

  /*
   * Интерфейс
   * */
  window.search = {
    getData: getSearchData,
  };
})();
