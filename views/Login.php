<?php

    require("ViewBasis.php");
    require("ViewInterface.php");

    /**
     * the view for the login page
     */
    class Login extends ViewBasis implements ViewInterface {

        /**
         * render method for the login page. a GET request returns the login page, while a POST request tries to login the user.
         * if the user data is invalid the login page is returned with a script that shows the user the wrong data
         *
         * @return string rendered html string
         */
        public function render() : string {

            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $this->model->dbConnect();
                if (!$this->model->dbCheckConnection()) {
                    return $this->renderPOSTUnknownError();
                }
                $userData = $this->model->getUserData();
                $this->model->dbClose();
                if (!$userData) {
                    return $this->renderPOSTInvalidData();
                }
                if ($this->controller->validateUserPassword($userData["password"])) {
                    $this->controller->logInUser($userData["userID"]);
                    return $this->renderPOSTSuccess();
                } else {
                    return $this->renderPOSTInvalidData();
                }
            } else if ($_SERVER["REQUEST_METHOD"] === "GET") {
                return $this->renderGET();
            } else {
                http_response_code(405); // Invalid method
                return "{}";
            }
        }

        /**
         * renders the page after a GET Request
         *
         * @return string rendered html string
         */
        private function renderGET() : string {
            $templateProperties = [];
            $templateProperties["header"] = "";
            $templateProperties["content"] = $this->openTemplate("templates/login/login.php", ["userName" => ""]);
            $templateProperties["script"] = "<script src='JS/formValidation.js'></script>";
            $templateProperties["script"] .= "<script src='JS/login.js'></script>";
            return $this->openTemplate("templates/pageTemplate.php", $templateProperties);
        }


        /**
         * renders the page after a POST request and an error occured in the login process
         *
         * @return string rendered html string
         */
        private function renderPOSTUnknownError() : string {
            $templateProperties = [];
            $templateProperties["header"] = "";
            $userName = "";
            if (isset($_POST["userName"]) && $_POST["userName"] != "") {
                $userName = $_POST["userName"];
            }
            $loginTemplateProperties = [];
            $loginTemplateProperties["userName"] = $userName;
            $templateProperties["content"] = $this->openTemplate("templates/login/login.php", $loginTemplateProperties);
            $templateProperties["script"] = "<script src='JS/formValidation.js'></script>";
            $templateProperties["script"] .= "<script src='JS/login.js'></script>";
            $templateProperties["script"] .= "<script>";
            $templateProperties["script"] .= "    document.addEventListener('DOMContentLoaded', () => {";
            $templateProperties["script"] .= "        showErrorMessages(['Ein unbekannter Fehler ist aufgetreten. Bitte versuchen Sie es später erneut.']);";
            $templateProperties["script"] .= "    });";
            $templateProperties["script"] .= "</script>";
            return $this->openTemplate("templates/pageTemplate.php", $templateProperties);
        }


        /**
         * renders the pager after a POST request and the user inserted invalid data
         *
         * @return string rendered html string
         */
        private function renderPOSTInvalidData() : string {
            $templateProperties = [];
            $templateProperties["header"] = "";
            $userName = "";
            if (isset($_POST["userName"]) && $_POST["userName"] != "") {
                $userName = $_POST["userName"];
            }
            $loginTemplateProperties = [];
            $loginTemplateProperties["userName"] = $userName;
            $templateProperties["content"] = $this->openTemplate("templates/login/login.php", $loginTemplateProperties);
            $templateProperties["script"] = "<script src='JS/formValidation.js'></script>";
            $templateProperties["script"] .= "<script src='JS/login.js'></script>";
            $templateProperties["script"] .= "<script>";
            $templateProperties["script"] .= "    document.addEventListener('DOMContentLoaded', () => {";
            $templateProperties["script"] .= "        errorHighlightAll();";
            $templateProperties["script"] .= "        showErrorMessages(['Der Benutzername oder das Passwort ist falsch.']);";
            $templateProperties["script"] .= "    });";
            $templateProperties["script"] .= "</script>";
            return $this->openTemplate("templates/pageTemplate.php", $templateProperties);
        }

        /**
         * renders the page after a POST request and a successful login of the user
         *
         * @return string rendered html string
         */
        private function renderPOSTSuccess() : string {
            $templateProperties = [];
            $templateProperties["header"] = "<meta http-equiv='refresh' content='0; URL=Home'>";
            $templateProperties["content"] = $this->openTemplate("templates/login/loginSuccess.php", []);
            $templateProperties["script"] = "";
            return $this->openTemplate("templates/pageTemplate.php", $templateProperties);
        }

    }

?>