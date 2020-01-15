// espressioni regolari per la validazione dei campi
const regex = [];
regex["email"] = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
regex["cel"] = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/;

function checkForm() {
    let text = "";
    let elements = document.getElementById("formContatti").elements;
    let inputsKO = "";

    for(let i = 0; elements && elements.length > i; ++i) {
        if(validInput(elements[i], regex[elements[i].name] )) {
            inputsKO += elements[i].name + ", ";
        }
    }

    if(!inputsKO.length) {
        text += "Input " + inputsKO + " non valido/i";
    }
    
    document.getElementById("error").innerHTML = text;

}

function validInput(input, regex) {
    return input.value != "" && regex.test(input.value)
}