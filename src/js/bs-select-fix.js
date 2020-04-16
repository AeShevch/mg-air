const selects = document.querySelectorAll('.selectpicker');
const onSelectChange = (evt) => {
    evt.target.parentElement.querySelector('.dropdown-menu').classList.remove('show');
    $('.selectpicker').selectpicker('refresh');
};
selects.forEach((select) => select.addEventListener('change', onSelectChange));

