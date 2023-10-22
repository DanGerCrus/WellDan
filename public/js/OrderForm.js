class OrderForm {
    static btnAddLineSelector = '.add-line-Order';
    static btnRemoveLineSelector = '.remove-line-Order';
    static containerLineSelector = '.container-line-Order';
    static lineOrderClass = 'line-Order';
    static lineOrderCloneSelector = '#line-clone-Order';
    static keyLine = 0;


    constructor() {
        OrderForm.addListeners();
    }

    static addListeners()
    {
        const addBtns = document.querySelectorAll(OrderForm.btnAddLineSelector);
        const removeBtns = document.querySelectorAll(OrderForm.btnRemoveLineSelector);
        const inputCheckBox = document.querySelectorAll('.input_checkbox');

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
        const clone = OrderForm.getClone();
        const container = document.querySelector(OrderForm.containerLineSelector);
        container.append(clone);
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
        const count = clone.querySelector('#count');
        const addBtn = clone.querySelector(OrderForm.btnAddLineSelector);
        const removeBtn = clone.querySelector(OrderForm.btnRemoveLineSelector);
        clone.id = '';
        clone.classList.remove('hidden');
        addBtn.remove();
        removeBtn.addEventListener('click', (event) => OrderForm.removeLine(event));
        removeBtn.classList.remove('hidden');
        productID.setAttribute('name', "products[" + OrderForm.keyLine + "][id]");
        count.setAttribute('name', "products[" + OrderForm.keyLine + "][count]");
        return clone;
    }
}
