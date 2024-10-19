function handleDropdownChange(selectElement, courseId) {
    const selectedOption = selectElement.value;
    const levels = selectElement.querySelectorAll('option[value^="level"]');
    const courseName = selectElement.dataset.course;

    if (selectedOption === 'full') {
        // Si se selecciona el curso completo, deshabilitar los niveles y removerlos del carrito
        levels.forEach(levelOption => {
            levelOption.disabled = true;
        });
        removeLevelsFromCart(courseName);
    } else if (selectedOption === "none") {


    } else {
        // Habilitar niveles si no está seleccionado el curso completo
        levels.forEach(levelOption => {
            levelOption.disabled = false;
        });
    }
}

function updateCart(courseId) {
    const cartItems = document.getElementById('cartItems');
    const cartTotal = document.getElementById('cartTotal');
    const selectElement = document.getElementById(`${courseId}-options`);
    const selectedOption = selectElement.value;
    const courseName = document.querySelector(`#course-${courseId} .course-info h3`).innerText;
    const optionDetail = selectElement.options[selectElement.selectedIndex].text;
    const optionPrice = parseFloat(selectElement.options[selectElement.selectedIndex].getAttribute('data-price'));

    // Si se selecciona el curso completo, remover los niveles previos del carrito
    if (selectedOption === 'full') {
        const fullPrice = parseFloat(selectElement.querySelector('option[value="full"]').getAttribute('data-price'));
        removeLevelsFromCart(courseName);  // Remover niveles previos
        addToCart(cartItems, courseName, 'Curso Completo', fullPrice);
    } else if (selectedOption) {
        // Agregar nivel específico al carrito
        addToCart(cartItems, courseName, optionDetail, optionPrice);
    }

    // Actualizar el total sin duplicar precios
    let totalPrice = 0;
    cartItems.querySelectorAll('.cart-item').forEach(item => {
        totalPrice += parseFloat(item.querySelector('span:last-child').innerText.replace('$', ''));
    });

    cartTotal.innerHTML = `Total: $${totalPrice.toFixed(2)}`;
}

function addToCart(cartItems, courseName, detail, price) {
    // Evitar duplicados en el carrito
    const existingItem = Array.from(cartItems.children).find(item => item.getAttribute('data-course') === courseName && item.innerHTML.includes(detail));
    if (!existingItem) {
        const cartItem = document.createElement('div');
        cartItem.className = 'cart-item';
        cartItem.setAttribute('data-course', courseName);
        cartItem.innerHTML = `
            <span>${courseName}</span>
            <span>${detail}</span>
            <span>$${price.toFixed(2)}</span>
        `;
        cartItems.appendChild(cartItem);
    }
}

function removeLevelsFromCart(courseName) {
    const cartItems = document.getElementById('cartItems');
    // Remover solo los niveles, no el curso completo
    cartItems.querySelectorAll(`.cart-item[data-course="${courseName}"]`).forEach(item => {
        if (!item.innerHTML.includes('Curso Completo')) {
            item.remove();
        }
    });
}

function clearCart() {
    const cartItems = document.getElementById('cartItems');
    const cartTotal = document.getElementById('cartTotal');

    // Eliminar todos los elementos del carrito
    cartItems.innerHTML = '';

    // Reiniciar el total a $0
    cartTotal.innerHTML = 'Total: $0';
}

function checkout() {
    const paymentMethod = document.getElementById('paymentMethod').value;
    if (!paymentMethod) {
        alert('Por favor, seleccione un método de pago.');
        return;
    }
    alert('Gracias por su compra. Procederemos con el pago a través de ' + paymentMethod);
}
