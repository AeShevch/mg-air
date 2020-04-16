'use strict';
(function () {
    const sortToDuplicate = document.getElementById('sorter');
    const duplicativeSort = document.getElementById('duplicative-sorter');
    duplicativeSort.value = sortToDuplicate.value;

    const onSelectChange = (evt) => {
        sortToDuplicate.value = evt.target.value;
        document.forms.filter.submit();
    };

    duplicativeSort.addEventListener('change', onSelectChange);
})();

