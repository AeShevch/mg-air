'use strict';

(function () {
  var productsContainer = document.querySelector('.js-products-list');
  var products = productsContainer.children;

  var onFormChange = function onFormChange(evt) {
    document.cookie = 'grid=' + evt.target.value;
    var _iteratorNormalCompletion = true;
    var _didIteratorError = false;
    var _iteratorError = undefined;

    try {
      for (var _iterator = products[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
        var product = _step.value;
        product.classList = 'col-6 ' + evt.target.value;
      }
    } catch (err) {
      _didIteratorError = true;
      _iteratorError = err;
    } finally {
      try {
        if (!_iteratorNormalCompletion && _iterator.return != null) {
          _iterator.return();
        }
      } finally {
        if (_didIteratorError) {
          throw _iteratorError;
        }
      }
    }
  };

  document.forms.gridSwitcher.addEventListener('change', onFormChange);
})();