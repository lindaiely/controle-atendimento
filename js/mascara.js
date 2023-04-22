const format = (field, event) => {
    if(event.keyCode == 8) return; //sai da função
    if(event.keyCode == 9) return; //sai da função

    let key = event.key //valor atual que foi digitado

    let mask = field.getAttribute("data-mask") //pega a mascara definida no campo
    let value = field.value //valor total da string q esta no campo
    let tamString = value.length //tamanho da string

    let keyMask = mask.charAt(tamString)
    if(keyMask == "" || keyMask == null){
        event.preventDefault()
        return;
    }

    switch(keyMask){
        case '9':
            var regex = new RegExp("\\d")
            if(!regex.test(key)){
                event.preventDefault()
                return;
            }
        break;

        case 'A':
            var regex = new RegExp("[a-z]", "i")
            if(!regex.test(key)){
                event.preventDefault()
                return;
            }
        break;

        default :
            field.value = field.value + keyMask;
            format(field, event)
    }
}

document.querySelectorAll("[data-mask]").forEach((field) => {
    field.addEventListener("keydown", (event) => {
        format(field, event)
    })
})