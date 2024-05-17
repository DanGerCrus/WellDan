function hiddenForm() {
    const check = document.querySelector('.no_ingredients')
    const form = document.querySelector('.ingredients_form');
    if (check.checked) {
        form.classList.add('hidden');
        form.querySelector('#ingredient_id').setAttribute('disabled', 1)
        form.querySelector('#ingredient_count').setAttribute('disabled', 1)
    } else {
        form.classList.remove('hidden');
        form.querySelector('#ingredient_id').removeAttribute('disabled')
        form.querySelector('#ingredient_count').removeAttribute('disabled')
    }
}

document.querySelector('.no_ingredients').addEventListener('click',() => hiddenForm())
