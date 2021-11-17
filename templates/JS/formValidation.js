let inputLengthValidationData = {};

let customErrorMessages = {};

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

function validateInputLength() {
    let errorList = [];
    let inputLengthValidationDataFields = Object.keys(inputLengthValidationData);
    for (let curField of inputLengthValidationDataFields) {
        let element = document.getElementById(curField);
        if (element.value.length > inputLengthValidationData[curField].maxlength) {
            element.classList.add("is-invalid");
            let message = inputLengthValidationData[curField].message;
            let maxlength = inputLengthValidationData[curField].maxlength;
            errorList.push(message + " darf maximal " + maxlength + " Zeichen lang sein.");
        } else {
            element.classList.add("is-valid");
        }
    }

    return errorList;
}

function removePreviousValidation(elements) {
    for (let curElement of elements) {
        let element = document.getElementById(curElement);
        element.classList.remove("is-invalid");
        element.classList.remove("is-valid");
    }
}

function validateCustomErrorMessages() {
    let errorMessages = [];
    let errorFields = Object.keys(customErrorMessages);
    for (curErrorField of errorFields) {
        let input = document.getElementById(curErrorField);
        input.classList.add("is-invalid");
        errorMessages.push(customErrorMessages[curErrorField]);
    }
    customErrorMessages = {};
    return errorMessages;
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