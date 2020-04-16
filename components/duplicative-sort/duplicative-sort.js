'use strict';

(function () {
  var sortToDuplicate = document.getElementById('sorter');
  var duplicativeSort = document.getElementById('duplicative-sorter');
  duplicativeSort.value = sortToDuplicate.value;

  var onSelectChange = function onSelectChange(evt) {
    sortToDuplicate.value = evt.target.value;
    document.forms.filter.submit();
  };

  duplicativeSort.addEventListener('change', onSelectChange);
})();