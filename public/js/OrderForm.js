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
        const containerLines = document.querySelectorAll('.' + OrderForm.lineOrderClass);

        if (containerLines) {
            containerLines.forEach((line) => {
                const productID = line.querySelector('#product_id');
                const productPrice = productID.selectedOptions[0].getAttribute('data-price')
                const productPriceElement = line.querySelector('#product_price');
                const productKkal = productID.selectedOptions[0].getAttribute('data-kkal')
                const productKkalElement = line.querySelector('#product_kkal');
                const productNoIngredients = productID.selectedOptions[0].getAttribute('data-no_ingredients')
                const productCount = line.querySelector('#product_count');
                const ingredientsForm = line.querySelector('.ingredients_form');
                const ingredientID = line.querySelector('#ingredient_id');
                const ingredientCount = line.querySelector('#ingredient_count');
                const ingredientPrice = ingredientID.selectedOptions[0].getAttribute('data-price')
                const ingredientKkal = ingredientID.selectedOptions[0].getAttribute('data-kkal')
                const ingredientPriceElement = line.querySelector('#ingredient_price');
                const ingredientKkalElement = line.querySelector('#ingredient_kkal');
                ingredientID.addEventListener('change', (event) => OrderForm.refreshProductPrice(event));
                ingredientCount.addEventListener('change', (event) => OrderForm.refreshProductPrice(event));
                productID.addEventListener('change', (event) => OrderForm.refreshProductPrice(event));
                productCount.addEventListener('change', (event) => OrderForm.refreshProductPrice(event));

                if (+productNoIngredients !== 0) {
                    ingredientsForm.classList.add('hidden');
                    ingredientID.setAttribute('disabled', 1)
                    ingredientCount.setAttribute('disabled', 1)
                } else {
                    ingredientsForm.classList.remove('hidden');
                    ingredientID.removeAttribute('disabled')
                    ingredientCount.removeAttribute('disabled')
                }

                ingredientPriceElement.innerHTML = +ingredientPrice * +ingredientCount.value;
                ingredientKkalElement.innerHTML = +(+ingredientKkal * +ingredientCount.value).toFixed(2);
                productPriceElement.innerHTML = (+productPrice * +productCount.value) + (+productCount.value * +ingredientPriceElement.innerHTML);
                productKkalElement.innerHTML = +((+productKkal * +productCount.value) + (+productCount.value * +ingredientKkalElement.innerHTML)).toFixed(2);
                OrderForm.refreshOrderPrice()
            })
        }
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
        const productPrice = productID.selectedOptions[0].getAttribute('data-price')
        const productKkal = productID.selectedOptions[0].getAttribute('data-kkal')
        const productPriceElement = clone.querySelector('#product_price');
        const productKkalElement = clone.querySelector('#product_kkal');
        const productNoIngredients = productID.selectedOptions[0].getAttribute('data-no_ingredients')
        const ingredientsForm = clone.querySelector('.ingredients_form');
        const ingredientID = clone.querySelector('#ingredient_id');
        const ingredientCount = clone.querySelector('#ingredient_count');
        const ingredientPrice = ingredientID.selectedOptions[0].getAttribute('data-price')
        const ingredientKkal = ingredientID.selectedOptions[0].getAttribute('data-kkal')
        const ingredientPriceElement = clone.querySelector('#ingredient_price');
        const ingredientKkalElement = clone.querySelector('#ingredient_kkal');
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
        ingredientID.addEventListener('change', (event) => OrderForm.refreshProductPrice(event));
        ingredientCount.addEventListener('change', (event) => OrderForm.refreshProductPrice(event));
        productID.addEventListener('change', (event) => OrderForm.refreshProductPrice(event));
        productCount.addEventListener('change', (event) => OrderForm.refreshProductPrice(event));

        if (+productNoIngredients !== 0) {
            ingredientsForm.classList.add('hidden');
            ingredientID.setAttribute('disabled', 1)
            ingredientCount.setAttribute('disabled', 1)
        } else {
            ingredientsForm.classList.remove('hidden');
            ingredientID.removeAttribute('disabled')
            ingredientCount.removeAttribute('disabled')
        }

        ingredientPriceElement.innerHTML = +ingredientPrice * +ingredientCount.value;
        productPriceElement.innerHTML = (+productPrice * +productCount.value) + (+productCount.value * +ingredientPriceElement.innerHTML);
        ingredientKkalElement.innerHTML = +(+ingredientKkal * +ingredientCount.value).toFixed(2);
        productKkalElement.innerHTML = +(+(+productKkal * +productCount.value) + +(+productCount.value * +ingredientKkalElement.innerHTML)).toFixed(2);
        OrderForm.refreshOrderPrice()

        return clone;
    }

    static refreshProductPrice(event)
    {
        const line = OrderForm.getLineOrder(event.target)
        const productID = line.querySelector('#product_id');
        const productCount = line.querySelector('#product_count');
        const productPrice = productID.selectedOptions[0].getAttribute('data-price')
        const productKkal = productID.selectedOptions[0].getAttribute('data-kkal')
        const productPriceElement = line.querySelector('#product_price');
        const productKkalElement = line.querySelector('#product_kkal');
        const productNoIngredients = productID.selectedOptions[0].getAttribute('data-no_ingredients')
        const ingredientsForm = line.querySelector('.ingredients_form');
        const ingredientID = line.querySelector('#ingredient_id');
        const ingredientCount = line.querySelector('#ingredient_count');
        const ingredientPrice = ingredientID.selectedOptions[0].getAttribute('data-price')
        const ingredientKkal = ingredientID.selectedOptions[0].getAttribute('data-kkal')
        const ingredientPriceElement = line.querySelector('#ingredient_price');
        const ingredientKkalElement = line.querySelector('#ingredient_kkal');

        if (+productNoIngredients !== 0) {
            ingredientsForm.classList.add('hidden');
            ingredientID.setAttribute('disabled', 1)
            ingredientCount.setAttribute('disabled', 1)
        } else {
            ingredientsForm.classList.remove('hidden');
            ingredientID.removeAttribute('disabled')
            ingredientCount.removeAttribute('disabled')
        }

        ingredientPriceElement.innerHTML = +ingredientPrice * +ingredientCount.value;
        productPriceElement.innerHTML = (+productPrice * +productCount.value) + (+productCount.value * +ingredientPriceElement.innerHTML);
        ingredientKkalElement.innerHTML = +(+ingredientKkal * +ingredientCount.value).toFixed(2);
        productKkalElement.innerHTML = +(+(+productKkal * +productCount.value) + +(+productCount.value * +ingredientKkalElement.innerHTML)).toFixed(2);
        OrderForm.refreshOrderPrice()
    }

    static refreshOrderPrice()
    {
        const orderPriceElement = document.querySelector('span#order_price')
        const orderKkalElement = document.querySelector('span#order_kkal')
        let orderPrice = 0
        let orderKkal = 0
        const containerLines = document.querySelectorAll('.' + OrderForm.lineOrderClass);
        containerLines.forEach((line) => {
            const productPrice = line.querySelector('#product_price')
            const productKkal = line.querySelector('#product_kkal')
            orderPrice += +productPrice.innerHTML
            orderKkal += +(+productKkal.innerHTML).toFixed(2)
        })
        orderPriceElement.innerHTML = orderPrice
        orderKkalElement.innerHTML = orderKkal
    }
}
