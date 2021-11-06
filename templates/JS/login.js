function validateAll(event) {
    let errorMessages = [];
    removePreviousValidation();

    // Validierung
    errorMessages.push(validateNotEmpty(["floatingUserName", "floatingPassword"]));

    // Error Messages in HTML anzeigen
    error = showErrorMessages(errorMessages);
    if (error) {
        event.preventDefault();
    }
}

function validateNotEmpty(fields) {
    let errorFields = [];
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
    let elements = ["floatingUserName", "floatingPassword"];
    for (let curElement of elements) {
        let element = document.getElementById(curElement);
        element.classList.remove("is-invalid");
        element.classList.remove("is-valid");
    }
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