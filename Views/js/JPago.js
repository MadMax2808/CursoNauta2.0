function processPurchase(courseId, price) {
    const paymentMethod = document.getElementById('paymentMethod').value;
    if (!paymentMethod) {
        alert('Por favor seleccione un método de pago');
        return;
    }
    
    // Aquí puedes agregar la lógica para procesar el pago directamente
    // Por ejemplo, redirigir a la página de pago correspondiente
    alert('Redirigiendo al proceso de pago...');
    // window.location.href = `proceso-pago.php?curso=${courseId}&metodo=${paymentMethod}&precio=${price}`;
}