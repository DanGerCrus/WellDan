class ProductIngredientForm {
    static btnAddLineSelector = '.add-line-Ingredient';
    static btnRemoveLineSelector = '.remove-line-Ingredient';
    static containerLineSelector = '.container-line-Ingredient';
    static lineIngredientClass = 'line-Ingredient';
    static lineIngredientCloneSelector = '#line-clone-Ingredient';
    static keyLine = 0;

    constructor() {
        ProductIngredientForm.addListeners();
    }

    static addListeners()
    {
        const addBtns = document.querySelectorAll(ProductIngredientForm.btnAddLineSelector);
        const removeBtns = document.querySelectorAll(ProductIngredientForm.btnRemoveLineSelector);
        const inputCheckBox = document.querySelectorAll('.input_checkbox');
        const containerLines = document.querySelectorAll('.' + ProductIngredientForm.lineIngredientClass);

        if (addBtns) {
            addBtns.forEach((btn) => {
                btn.addEventListener('click', (event) => ProductIngredientForm.addNewLine(event));
            });
        }
        if (removeBtns) {
            removeBtns.forEach((btn) => {
                btn.addEventListener('click', (event) => ProductIngredientForm.removeLine(event));
            });
        }

        if (containerLines) {
            containerLines.forEach((line) => {
                const ingredientID = line.querySelector('#ingredient_id');
                const count = line.querySelector('#ingredient_count');
                const ingredientPrice = ingredientID.selectedOptions[0].getAttribute('data-price')
                const ingredientKkal = ingredientID.selectedOptions[0].getAttribute('data-kkal')
                const price = line.querySelector('#ingredient_price');
                const kkal = line.querySelector('#ingredient_kkal');
                ingredientID.addEventListener('change', (event) => ProductIngredientForm.refreshPrice(event));
                count.addEventListener('change', (event) => ProductIngredientForm.refreshPrice(event));
                price.innerHTML = +ingredientPrice * +count.value;
                kkal.innerHTML = +(+ingredientKkal * +count.value).toFixed(2);
            })
        }
        if (inputCheckBox) {
            inputCheckBox.forEach((checkBox) => {
                checkBox.addEventListener('change', (event) => {
                    const target = event.target;
                    if (target.checked) {
                        target.value = 2;
                    } else {
                        target.value = 1;
                    }
                });
            })
        }
    }

    static addNewLine(event)
    {
        const container = ProductIngredientForm.getContainer(event.target);
        const productKey = container.getAttribute('data-productKey');
        const clone = ProductIngredientForm.getClone(productKey);

        container.append(clone);
    }

    static getContainer(element)
    {
        while(element = element.parentElement) {
            if (element.classList.contains('container-line-Ingredient')) {
                return element;
            }
        }
    }

    static getLine(element)
    {
        while(element = element.parentElement) {
            if (element.classList.contains('line-Ingredient')) {
                return element;
            }
        }
    }

    static removeLine(event)
    {
        const line = ProductIngredientForm.getLineIngredient(event.target);
        line.remove()
    }

    static getLineIngredient(element)
    {
        while(element = element.parentElement) {
            if (element.classList.contains(ProductIngredientForm.lineIngredientClass)) {
                return element;
            }
        }
    }

    static getClone(productKey)
    {
        ProductIngredientForm.keyLine++;
        const clone = document.querySelector(ProductIngredientForm.lineIngredientCloneSelector).cloneNode(true);
        const ingredientID = clone.querySelector('#ingredient_id');
        const count = clone.querySelector('#ingredient_count');
        const ingredientPrice = ingredientID.selectedOptions[0].getAttribute('data-price')
        const ingredientKkal = ingredientID.selectedOptions[0].getAttribute('data-kkal')
        const price = clone.querySelector('#ingredient_price');
        const kkal = clone.querySelector('#ingredient_kkal');
        const addBtn = clone.querySelector(ProductIngredientForm.btnAddLineSelector);
        const removeBtn = clone.querySelector(ProductIngredientForm.btnRemoveLineSelector);
        clone.id = '';
        clone.classList.remove('hidden');
        ingredientID.addEventListener('change', (event) => ProductIngredientForm.refreshPrice(event));
        count.addEventListener('change', (event) => ProductIngredientForm.refreshPrice(event));
        addBtn.remove();
        removeBtn.addEventListener('click', (event) => ProductIngredientForm.removeLine(event));
        removeBtn.classList.remove('hidden');
        if (productKey == null) {
            ingredientID.setAttribute('name', "ingredients[" + ProductIngredientForm.keyLine + "][id]");
            count.setAttribute('name', "ingredients[" + ProductIngredientForm.keyLine + "][count]");
        } else {
            ingredientID.setAttribute('name', "products[" + productKey + "][ingredients][" + ProductIngredientForm.keyLine + "][id]");
            count.setAttribute('name', "products[" + productKey + "][ingredients][" + ProductIngredientForm.keyLine + "][count]");
        }
        price.innerHTML = +ingredientPrice * +count.value;
        kkal.innerHTML = +(+ingredientKkal * +count.value).toFixed(2);

        return clone;
    }

    static refreshPrice(event)
    {
        const line = ProductIngredientForm.getLine(event.target)
        const ingredientID = line.querySelector('#ingredient_id');
        const ingredientPrice = ingredientID.selectedOptions[0].getAttribute('data-price')
        const ingredientKkal = ingredientID.selectedOptions[0].getAttribute('data-kkal')
        const count = line.querySelector('#ingredient_count');
        const price = line.querySelector('#ingredient_price');
        const kkal = line.querySelector('#ingredient_kkal');

        price.innerHTML = +ingredientPrice * +count.value;
        kkal.innerHTML = +(+ingredientKkal * +count.value).toFixed(2);
    }
}
