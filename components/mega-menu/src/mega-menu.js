"use strict";
(function () {
  /*
   * Инициализация модуля
   * */
  let init = function (id) {
    /*
     * Константы
     * */
    const MENU = document.getElementById(id);
    const BTN_NEXT_SELECTOR = "js-menu-open";
    const BTN_BACK_SELECTOR = "js-menu-back";
    const BTN_BACK = MENU.querySelector("." + BTN_BACK_SELECTOR);
    const BTN_MODIFICATOR_HIDDEN = "a-mega-menu__btn_hidden";
    const BTN_CLOSE = MENU.querySelector(".js-menu-close");
    const SUB_MENU_SELECTOR = "js-submenu";
    const SUB_MENU_MODIFICATOR = "a-mega-menu-submenu-level-deep_opened";

    /*
     * Хэндлеры
     * */
    // Клик на стрелочку подменю
    let onBtnNextClick = function (evt) {
      if (evt.target.classList.contains(BTN_NEXT_SELECTOR)) {
        console.log("click");
        // Открываем вложенное меню
        openSubMenu(
          evt.target.parentElement.querySelector("." + SUB_MENU_SELECTOR)
        );
      }
    };
    // Клик на кнопку «Назад»
    let onBtnBackClick = function (evt) {
      if (evt.target.classList.contains(BTN_BACK_SELECTOR)) {
        // Закрываем текущее меню
        let allOpened = MENU.querySelectorAll("." + SUB_MENU_MODIFICATOR);
        let current = allOpened[allOpened.length - 1];
        closeCurrent(current);

        // Убираем кнопку «Назад»
        let parentUl = current.parentElement.parentElement;
        if (!parentUl.classList.contains(SUB_MENU_SELECTOR)) {
          BTN_BACK.classList.add(BTN_MODIFICATOR_HIDDEN);
        }
      }
    };

    /*
     * Функции
     * */
    let closeCurrent = function (currentMenu) {
      if (currentMenu) currentMenu.classList.remove(SUB_MENU_MODIFICATOR);
    };
    let openSubMenu = function (subMenu) {
      if (subMenu) {
        subMenu.classList.add(SUB_MENU_MODIFICATOR);
        // Если кнопка «Назад» скрыта, показываем её
        if (BTN_BACK.classList.contains(BTN_MODIFICATOR_HIDDEN)) {
          BTN_BACK.classList.remove(BTN_MODIFICATOR_HIDDEN);
        }
      }
    };

    let setHandlers = function () {
      // Чтобы не вешать клик на каждую кнопку, вешаем его на меню и смотрим откуда всплыло
      MENU.addEventListener("click", onBtnNextClick);
      MENU.addEventListener("click", onBtnBackClick);
      // BTN_BACK.addEventListener('click', onBtnBackClick);
    };

    setHandlers();
  };

  window.menu = {
    init: init,
  };
})();
// TODO Переписать на js
$(document).ready(function () {
  /// Prevent closing from click inside dropdown
  $(document).on("click", ".dropdown-menu", function (e) {
    e.stopPropagation();
  });

  // refresh window on resize
  // $(window).on('resize',function(){location.reload();});

  if ($(window).width() < 992) {
    $(".has-megasubmenu a").click(function (e) {
      e.preventDefault();
      $(this).next(".megasubmenu").toggle();

      $(".dropdown").on("hide.bs.dropdown", function () {
        $(this).find(".megasubmenu").hide();
      });
    });

    $(".dropdown-menu a").click(function (e) {
      e.preventDefault();
      if ($(this).next(".submenu").length) {
        $(this).next(".submenu").toggle();
      }
      $(".dropdown").on("hide.bs.dropdown", function () {
        $(this).find(".submenu").hide();
      });
    });
  }

  /// offcanvas onmobile
  $("[data-trigger]").on("click", function (e) {
    e.preventDefault();
    e.stopPropagation();
    var offcanvas_id = $(this).attr("data-trigger");
    $(offcanvas_id).toggleClass("show");
    $("body").toggleClass("offcanvas-active");
    $(".screen-overlay").toggleClass("show");
  });

  $(".js-menu-close, .screen-overlay").click(function (e) {
    $(".screen-overlay").removeClass("show");
    $(".navbar-collapse").removeClass("show");
    $("body").removeClass("offcanvas-active");
  });
}); // document ready //end
