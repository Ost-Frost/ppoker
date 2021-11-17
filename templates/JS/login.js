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

function errorHighlightAll() {
    let userNameField = document.getElementById("floatingUserName");
    let passwordField = document.getElementById("floatingPassword");
    userNameField.classList.add("is-invalid");
    passwordField.classList.add("is-invalid");
}

document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("submitButton").addEventListener("click", validateAll);
});