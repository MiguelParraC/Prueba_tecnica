function change_product(e) {
    flag  = true;
    row = e.parentElement.parentElement.parentElement;
    product_element = row.children[0].children[0].children[0];
    stock_element = row.children[2].children[0].children[0];
    flag = not_repeat_product(e);
    if (flag) {
        $.ajax({
            // la URL para la petición
            url: 'index.php?r=productsouts/getstock',
            type: 'GET',
            dataType: 'json',
            data: {
                product_element: product_element.value,
            },
            success: function (data) {
                stock_element.value = data.stock;

                if (data.stock == 0) {
                    swal({
                        title: `No hay stock del producto`,
                        text: 'El producto seleccionado no cuenta con stock en este momento. SELECCIONE OTRO',
                        icon: 'error',
                        button: 'Salir',
                    });
                    product_element.value = '';
                    stock_element.value = '';
                }

            },
        });
    } else {
        swal({
            title: `El producto ya se encuentra seleccionado`,
            text: 'Seleccione un producto diferente',
            icon: 'info',
            button: 'Salir',
        });
    }

}

function change_quantity(e) {
    row = e.parentElement.parentElement.parentElement;
    stock = row.children[2].children[0].children[0];

    if (parseInt(e.value,10) > parseInt(stock.value,10)) {
        e.value = stock.value;
        swal({
            title: `Cantidad ingresada mayor al stock`,
            text: 'Solo puede poner una cantidad igual o menor a la cantidad del stock',
            icon: 'error',
            button: 'Salir',
        });
    }
}

function not_repeat_product(e) {
    flag = true;
    separating = e.id.split('-');
    position = separating[2];

    multiple_input = document.getElementById('w1');
    rows = multiple_input.getElementsByClassName('multiple-input-list__item');

    for (let i = 0; i < rows.length; i++) {
        if (i == position) { continue; }
        product = rows[i].children[0].children[0].children[0].value;
        // comparando el producto de la fila con el seleccionado
        if(product == e.value){
            e.value = '';
            flag = false;
            return flag;
        } 

    }
    return flag;
}