function check_stock(e){
    // revisando si es está intentando disminuir más de lo que ya existe en el stock
    aux_stock = document.getElementById('productspool-aux_stock').value;
    if(e.value < aux_stock) {
        swal({
            title: `No se tiene permitido reducir el stock`,
            text: 'Solo es posible aumentar el stock',
            icon: 'error',
            button: 'Salir',
        });
        e.value = aux_stock;
    }
}