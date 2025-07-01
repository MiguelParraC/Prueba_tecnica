function converToMayus(elemento) {
    var charPos = doGetCaretPosition(elemento); //Obtiene la posición actual del curosr
    elemento.value = elemento.value.toUpperCase();
    setCaretPosition(elemento, charPos); //Setea el cursor en la posicion actual
}

function cuenta_mensaje(elemento, id_contador) {
    // === contador de caracteres para IDX ===
    var mensaje;
    var contador;
    var indice;

    indice = elemento.id.split('-');
    indice = indice[2];
    if (indice == undefined) {
        indice = '';
    }
    // rx-comentario_idx-1
    // variable = typeof (elemento);

    mensaje = document.getElementById(elemento.id);//document.getElementById('rx-comentario_idx-' + i);
    contador= document.getElementById(id_contador);

    // }
    // const target = mensaje_idx.target;
    const longitudMax = mensaje.getAttribute('maxlength');
    const longitudAct = mensaje.value.length;
    contador.innerHTML = `${longitudAct}/${longitudMax}`;

}


function converToMayus(elemento) {
    var charPos = doGetCaretPosition(elemento); //Obtiene la posición actual del curosr
    elemento.value = elemento.value.toUpperCase();
    setCaretPosition(elemento, charPos); //Setea el cursor en la posicion actual
}

function doGetCaretPosition(oField) {

    // Initialize
    var iCaretPos = 0;

    // IE Support
    if (document.selection) {

        // Set focus on the element
        oField.focus();

        // To get cursor position, get empty selection range
        var oSel = document.selection.createRange();

        // Move selection start to 0 position
        oSel.moveStart('character', -oField.value.length);

        // The caret position is selection length
        iCaretPos = oSel.text.length;
    }

    // Firefox support
    else if (oField.selectionStart || oField.selectionStart === '0')
        iCaretPos = oField.selectionDirection === 'backward' ? oField.selectionStart : oField.selectionEnd;

    // Return results
    return iCaretPos;
}

function setCaretPosition(elem, caretPos) {
    if (elem !== null) {
        if (elem.createTextRange) {
            var range = elem.createTextRange();
            range.move('character', caretPos);
            range.select();
        }
        else {
            if (elem.selectionStart) {
                elem.focus();
                elem.setSelectionRange(caretPos, caretPos);
            }
            else
                elem.focus();
        }
    }
}