// espressioni regolari per la validazione dei campi
const regex = [];
regex["email"] = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
regex["nome"] = /^[a-zA-Z]*$/;
regex["nomeComune"] = /^[a-zA-Z]*$/;
regex["nomeProprio"] = /^[a-zA-Z]*$/;
regex["nomeScientifico"] = /^[a-zA-Z]*$/;
regex["cognome"] = /^[a-zA-Z]*$/;
regex["messaggio"] = /^[a-zA-Z0-9]*$/;
regex["descrizioneImmagine"] = /^[a-zA-Z0-9]*$/;
regex["descrizioneEvento"] = /^[a-zA-Z0-9]*$/;
regex["numeroTelefono"] = /^([\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6})*$/;
regex["password"] = /^[a-zA-Z0-9!.@#$%^&*]+$/;
regex["ripetiPassword"] = /^[a-zA-Z0-9!.@#$%^&*]+$/;
regex["nascita"] = /^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/;
regex["data"] = /^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/;
regex["prezzo"] = /^[[0-9]{1,2}(.)[0-9]{1,2}$/;


var checkForm = (function(idForm) {
    let text = "";
    let elements = document.forms[idForm].getElementsByTagName("input");

    let inputsKO = "";

    for(let i = 0; elements && elements.length > i; ++i) {
        if(elements[i].type != "submit" && elements[i].type != "file" && !validInput(elements[i], regex[elements[i].name] )) {
            inputsKO += elements[i].name + ", ";
        }
    }

    if(idForm == "registrationForm")
        text += checkRegistrazione();

    if(inputsKO.length) {
        text += "Input " + inputsKO + " non valido/i";
        alert(text);
    }

    return text.length == 0;
});

function checkRegistrazione() {
    let text = "";

    if(document.getElementById("password").value != document.getElementById("ripetiPassword").value) {
        text += "Le password non coincidono. ";
    }

    let diff_ms = Date.now() - new Date(document.getElementById("nascita").value);
    let age_dt = new Date(diff_ms); 

    if(Math.abs(age_dt.getUTCFullYear() - 1970 < 18)) {
        text += "Devi essere maggiorenne per poterti iscrivere.";
    }

    return text;

}

function validInput(input, regex) {
    return input.value != "" && regex.test(input.value)
}
