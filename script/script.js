console.log('test');
    // Dodawanie kategorii
    const addCategoryForm = document.forms['addCategoryForm'];
    const addFileDiv = addCategoryForm.querySelector('.fileDiv');
    const addFileCheck = addCategoryForm['addFileCheck'];
    const addFormSwitch = addCategoryForm.querySelector('.form-check-label');
    const addP = addCategoryForm.querySelector('.small');

    function updateAddFileDiv() {
        
        if (addFileCheck.checked) {
            addFileDiv.classList.remove('visually-hidden');
            addFormSwitch.innerText = 'Dodaj zdjęcie tytułowe do kategorii';
            addP.innerText = '';
        } else {
            addFileDiv.classList.add('visually-hidden');
            addFormSwitch.innerText = 'Nie dodawaj tytułowego zdjęcia do kategorii';
            addP.innerText = 'Dodane zostanie domyślne zdjęcie';
        }
    }

    updateAddFileDiv();
    addFileCheck.addEventListener('change', updateAddFileDiv);


