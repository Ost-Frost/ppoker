function validateAll(event) {
    let errorMessages = [];
    removePreviousValidation();

    // Validierung
    errorMessages.push(validateNotEmpty(["floatingUserName", "floatingFirstName", "floatingLastName", "floatingEmail", "floatingEmailRepeat", "floatingPassword", "floatingPasswordRepeat"]))
    errorMessages.push(validateEmail());
    errorMessages.push(validatePasswort());

    // Error Messages in HTML anzeigen
    error = showErrorMessages(errorMessages);
    if (error) {
        event.preventDefault();
    }
}

function validateNotEmpty(fields) {
    let error = false;

    for (let curField of fields) {
        let element = document.getElementById(curField);
        if (element.value === "") {
            element.classList.add("is-invalid");
            error = true;
        } else {
            element.classList.add("is-valid");
        }
    }

    if (error) {
        return "Bitte füllen sie alle Felder aus.";
    }

    return "";
}

function removePreviousValidation() {
    let elements = ["floatingUserName", "floatingFirstName", "floatingLastName", "floatingEmail", "floatingEmailRepeat", "floatingPassword", "floatingPasswordRepeat"];
    for (let curElement of elements) {
        let element = document.getElementById(curElement);
        element.classList.remove("is-invalid");
        element.classList.remove("is-valid");
    }
}

function validateEmail() {
    let input1 = document.getElementById("floatingEmail");
    let input2 = document.getElementById("floatingEmailRepeat");

    if (input1.value !== input2.value) {
        input2.classList.add("is-invalid");
        return "Die Email-Adressen stimmen nicht überein.";
    }
    input2.classList.add("is-valid");
    return "";
}

function validatePasswort() {
    let input1 = document.getElementById("floatingPassword");
    let input2 = document.getElementById("floatingPasswordRepeat");

    if (input1.value !== input2.value) {
        input2.classList.add("is-invalid");
        return "Die Passwörter stimmen nicht überein.";
    }
    input2.classList.add("is-valid");
    return "";
}

function showErrorMessages(errorMessages) {
    errorField = document.getElementById("invalidFeedbackField");
    errorField.innerHTML = "";
    error = false;

    for (let curErrorMessage of errorMessages) {
        if (curErrorMessage !== "") {
            errorField.innerHTML = errorField.innerHTML + curErrorMessage + "<br>";
            error = true;
        }
    }

    return error;
}

document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("submitButton").addEventListener("click", validateAll);
});