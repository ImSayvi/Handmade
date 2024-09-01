




document.addEventListener('DOMContentLoaded', () => {
    const form = document.forms['addCategoryForm'];
    const fileDiv = document.querySelector('.fileDiv');
    const addFileCheck = form['addFileCheck'];
    const formSwitch = form.querySelector('.form-check-label');
    const p = form.querySelector('.small');


    function updateFileDiv() {
        if (addFileCheck.checked) {
            fileDiv.classList.remove('visually-hidden');
            formSwitch.innerText = 'Dodaj zdjecie tytułowe do kategorii';
            p.innerText = '';
        } else {
            fileDiv.classList.add('visually-hidden');
            formSwitch.innerText = ' Nie dodawaj tytułowego zdjęcia do kategorii';
            p.innerText = 'Dodane zostanie domyślne zdjęcie';
        }
    }

    updateFileDiv();

    addFileCheck.addEventListener('change', updateFileDiv);
});