class OrderForm {
    static btnAddLineSelector = '.add-line-ProductOrder';
    static btnRemoveLineSelector = '.remove-line-ProductOrder';
    static containerLineSelector = '.container-line-ProductOrder';
    static lineOrderClass = 'line-ProductOrder';
    static lineOrderCloneSelector = '#line-clone-ProductOrder';
    static keyLine = 0;


    constructor() {
        OrderForm.addListeners();
    }

    static addListeners()
    {
        const addBtns = document.querySelectorAll(OrderForm.btnAddLineSelector);
        const removeBtns = document.querySelectorAll(OrderForm.btnRemoveLineSelector);

        if (addBtns) {
            addBtns.forEach((btn) => {
                btn.addEventListener('click', (event) => OrderForm.addNewLine(event));
            });
        }
        if (removeBtns) {
            removeBtns.forEach((btn) => {
                btn.addEventListener('click', (event) => OrderForm.removeLine(event));
            });
        }
    }

    static addNewLine(event)
    {
        const clone = OrderForm.getClone();
        const container = document.querySelector(OrderForm.containerLineSelector);
        container.append(clone);
        new ProductIngredientForm();
    }

    static removeLine(event)
    {
        const line = OrderForm.getLineOrder(event.target);
        line.remove()
    }

    static getLineOrder(element)
    {
        while(element = element.parentElement) {
            if (element.classList.contains(OrderForm.lineOrderClass)) {
                return element;
            }
        }
    }

    static getClone()
    {
        OrderForm.keyLine++;
        const clone = document.querySelector(OrderForm.lineOrderCloneSelector).cloneNode(true);
        const productID = clone.querySelector('#product_id');
        const productCount = clone.querySelector('#product_count');
        const ingredientID = clone.querySelector('#ingredient_id');
        const ingredientCount = clone.querySelector('#ingredient_count');
        const addBtn = clone.querySelector(OrderForm.btnAddLineSelector);
        const removeBtn = clone.querySelector(OrderForm.btnRemoveLineSelector);
        clone.id = '';
        clone.classList.remove('hidden');
        addBtn.remove();
        removeBtn.addEventListener('click', (event) => OrderForm.removeLine(event));
        removeBtn.classList.remove('hidden');
        productID.setAttribute('name', "products[" + OrderForm.keyLine + "][id]");
        productCount.setAttribute('name', "products[" + OrderForm.keyLine + "][count]");
        ingredientID.setAttribute('name', "products[" + OrderForm.keyLine + "][ingredients][0][id]");
        ingredientCount.setAttribute('name', "products[" + OrderForm.keyLine + "][ingredients][0][count]");

        return clone;
    }
}
