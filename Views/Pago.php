<?php include 'Views\Parciales\Head.php'; ?>

<link rel="stylesheet" href="Views/css/SPago.css">

<?php include 'Views\Parciales\Nav.php'; ?>

<div class="container">
        <div class="course-list">
            <h2>Lista de Cursos</h2>
            <div class="course" id="course-dg">
                <div class="course-info">
                    <h3>Diseño Gráfico</h3>
                    <div class="course-dropdown">
                        <label for="dg-options">Selecciona una opción:</label>
                        <select id="dg-options" data-course="Diseño Gráfico"
                            onchange="handleDropdownChange(this, 'dg')">
                            <option value="non">-- Elige una opción --</option>
                            <option value="full" data-price="40">Curso Completo - $40</option>
                            <option value="level1" data-price="15">Nivel 1 - $15</option>
                            <option value="level2" data-price="15">Nivel 2 - $15</option>
                            <option value="level3" data-price="15">Nivel 3 - $15</option>
                        </select>
                    </div>
                </div>
                <div class="course-actions">
                    <button onclick="updateCart('dg')">Actualizar Carrito</button>
                </div>
            </div>

            <div class="course" id="course-id">
                <div class="course-info">
                    <h3>Ilustración Digital</h3>
                    <div class="course-dropdown">
                        <label for="id-options">Selecciona una opción:</label>
                        <select id="id-options" data-course="Ilustración Digital"
                            onchange="handleDropdownChange(this, 'id')">
                            <option value="non">-- Elige una opción --</option>
                            <option value="full" data-price="50">Curso Completo - $50</option>
                            <option value="level1" data-price="10">Nivel 1 - $10</option>
                            <option value="level2" data-price="10">Nivel 2 - $10</option>
                            <option value="level3" data-price="10">Nivel 3 - $10</option>
                            <option value="level4" data-price="10">Nivel 4 - $10</option>
                            <option value="level5" data-price="10">Nivel 5 - $10</option>
                        </select>
                    </div>
                </div>
                <div class="course-actions">
                    <button onclick="updateCart('id')">Actualizar Carrito</button>
                </div>
            </div>
        </div>

        <div class="cart">
            <h2>Carrito de Compras</h2>
            <div class="cart-header">
                <span>Curso</span>
                <span>Detalle</span>
                <span>Precio</span>
            </div>
            <div class="cart-items" id="cartItems"></div>
            <div class="cart-total" id="cartTotal">Total: $0</div>

            <!-- Botón para vaciar el carrito -->
            <button class="clear-cart-btn" onclick="clearCart()">Vaciar Carrito</button>

            <div class="payment-method">
                <h3>Método de Pago</h3>
                <select id="paymentMethod">
                    <option value="">Seleccione un método de pago</option>
                    <option value="tarjeta">Tarjeta de Crédito/Débito</option>
                    <option value="paypal">PayPal</option>
                    <option value="transferencia">Transferencia Bancaria</option>
                </select>
            </div>

            <button class="checkout-btn" onclick="checkout()">Proceder al Pago</button>
        </div>
    </div>

<script src="Views\js\JPago.js"> </script>

<?php include 'Views\Parciales\Footer.php'; ?> 