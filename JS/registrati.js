// espressioni regolari per la validazione dei campi
const regex = [];
regex["email"] = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
regex["cel"] = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/;

function checkRegistrazione() {
    let text = "";
    let elements = document.getElementById("registrationForm").elements;

    let inputsKO = "";

    for(let i = 0; elements && elements.length > i; ++i) {
        if(validInput(elements[i], regex[elements[i].name] )) {
            inputsKO += elements[i].name + ", ";
        }
    }

    if(!inputsKO.length) {
        text += "Input " + inputsKO + " non valido/i";
    }
    
    if(document.getElementById("password").value != document.getElementById("repeatpassword").value) {
        text += "Le password non coincidono. ";
    }

    let diff_ms = Date.now() - new Date(document.getElementById("nascita").value);
    let age_dt = new Date(diff_ms); 
  
    if(Math.abs(age_dt.getUTCFullYear() - 1970 < 18)) {
        text += "Devi essere maggiorenne per poterti iscrivere.";
    }

    document.getElementById("error").innerHTML = text;

}

function validInput(input, regex) {
    return input.value != "" && regex.test(input.value)
}

