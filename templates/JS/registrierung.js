inputLengthValidationData = {
    floatingUserName : {
        message : "Der Benutzername",
        maxlength: 20
    },
    floatingFirstName : {
        message : "Der Vorname",
        maxlength: 50
    },
    floatingLastName : {
        message : "Der Nachname",
        maxlength: 50
    },
    floatingEmail : {
        message : "Die E-Mail Adresse",
        maxlength: 100
    },
    floatingPassword : {
        message : "Das Passwort",
        maxlength: 50
    },
}

function validateAll(event) {
    let errorMessages = [];
    removePreviousValidation(["floatingUserName", "floatingFirstName", "floatingLastName", "floatingEmail", "floatingEmailRepeat", "floatingPassword", "floatingPasswordRepeat"]);

    // Validierung
    errorMessages.push(validateNotEmpty(["floatingUserName", "floatingFirstName", "floatingLastName", "floatingEmail", "floatingEmailRepeat", "floatingPassword", "floatingPasswordRepeat"]))
    errorMessages.push(validateEmailRepeat());
    errorMessages.push(validatePasswortRepeat());
    errorMessages.push(validateEmail());
    errorMessages = errorMessages.concat(validateInputLength());
    errorMessages = errorMessages.concat(validateCustomErrorMessages());

    // Error Messages in HTML anzeigen
    error = showErrorMessages(errorMessages);
    if (error) {
        event.preventDefault();
    }
}

function validateEmailRepeat() {
    let input1 = document.getElementById("floatingEmail");
    let input2 = document.getElementById("floatingEmailRepeat");

    if (input1.value !== input2.value) {
        input2.classList.add("is-invalid");
        return "Die E-Mail-Adressen stimmen nicht überein.";
    }
    input2.classList.add("is-valid");
    return "";
}

function validateEmail() {

    let input = document.getElementById("floatingEmail");

    // ------- Quelle: https://stackoverflow.com/questions/46155/how-to-validate-an-email-address-in-javascript ----
    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    let isValid = re.test(String(input.value).toLowerCase());
    // -------------------------------------------------------------------------------------------------------------

    if (!isValid) {
        input.classList.add("is-invalid");
        return "Bitte geben Sie eine gültige E-Mail Adresse ein.";
    }
    input.classList.add("is-valid");
    return "";
}

function validatePasswortRepeat() {
    let input1 = document.getElementById("floatingPassword");
    let input2 = document.getElementById("floatingPasswordRepeat");

    if (input1.value !== input2.value) {
        input2.classList.add("is-invalid");
        return "Die Passwörter stimmen nicht überein.";
    }
    input2.classList.add("is-valid");
    return "";
}

document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("submitButton").addEventListener("click", validateAll);
});