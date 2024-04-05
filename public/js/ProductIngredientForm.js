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
        const addBtn = clone.querySelector(ProductIngredientForm.btnAddLineSelector);
        const removeBtn = clone.querySelector(ProductIngredientForm.btnRemoveLineSelector);
        clone.id = '';
        clone.classList.remove('hidden');
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

        return clone;
    }
}
