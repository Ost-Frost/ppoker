<!doctype html>
<html lang="de">
    <head>
        <link href="./bootstrap//bootstrap.css" rel="stylesheet">
        <link href="./CSS/registration.css" rel="stylesheet">
    </head>

    <body class="text-center">
        <script src="JS/registrierung.js"></script>

        <!--- angepasst von: https://getbootstrap.com/docs/5.0/examples/sign-in/ --->
        <main class="form-registration">
            <form id="registerBlock" action="Login" method="POST">
                <h1 class="h3 mb-3 fw-normal">Registrierung zum Planning Poker</h1>

                <div class="form-floating">
                    <input type="text" class="form-control" id="floatingUserName">
                    <label for="floatingUserName">Username</label>
                </div>
                <div class="form-floating">
                    <input type="text" class="form-control" id="floatingFirstName">
                    <label for="floatingFirstName">Vorname</label>
                </div>
                <div class="form-floating">
                    <input type="text" class="form-control" id="floatingLastName">
                    <label for="floatingLastName">Nachname</label>
                </div>
                <div class="form-floating">
                    <input type="email" class="form-control" id="floatingEmail">
                    <label for="floatingEmail">E-Mail Addresse</label>
                </div>
                <div class="form-floating">
                    <input type="email" class="form-control" id="floatingEmailRepeat">
                    <label for="floatingEmailRepeat">bitte E-Mail wiederholen</label>
                </div>
                <div class="form-floating">
                    <input type="text" class="form-control" id="floatingPassword">
                    <label for="floatingPassword">Passwort</label>
                </div>
                <div class="form-floating">
                    <input type="text" class="form-control" id="floatingPasswordRepeat">
                    <label for="floatingPasswordRepeat">Passwort wiederholen</label>
                </div>

                <p class="my-1 text-start text-danger" id="invalidFeedbackField"></p>
                <button id="submitButton" class="w-100 btn btn-lg btn-primary my-2" type="submit">Registrieren</button>
            </form>
            <p class="mt-5 mb-3 text-muted">&copy; 2021</p>
        </main>
    </body>
</html>
