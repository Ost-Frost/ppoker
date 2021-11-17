<?php

    require("ViewBasis.php");
    require("ViewInterface.php");

    /**
     * the view for the register page
     */
    class Register extends ViewBasis implements ViewInterface {

        /**
         * render method for the register page. a GET request returns the register page, while a POST request tries to register a new user.
         * If the user data is invalid the register page is returned with a script that shows the user the wrong data.
         *
         * @return string rendered html string
         */
        public function render() : string {

            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                if ($this->controller->validateData()) {
                    $checkUserName = $this->model->checkUserName();
                    $checkEmail = $this->model->checkEmail();
                    if (!$this->controller->validateUserExists($checkUserName, $checkEmail)) {
                        return $this->renderPOSTInvalidData();
                    }
                    $this->controller->hashPassword();
                    if (!isset($_POST["password"])) {
                        return $this->renderPOSTUnknownFailure();
                    }
                    if (!$this->model->addUser()) {
                        return $this->renderPOSTUnknownFailure();
                    }
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
            $registerTemplateProperties = $this->controller->getRegisterTemplateProperties();
            $templateProperties["content"] = $this->openTemplate("templates/register/register.php", $registerTemplateProperties);
            $templateProperties["script"] = "<script src='JS/formValidation.js'></script>";
            $templateProperties["script"] .= "<script src='JS/registrierung.js'></script>";
            return $this->openTemplate("templates/pageTemplate.php", $templateProperties);
        }

        /**
         * renders the page after a POST request and a successful registration of the user
         *
         * @return string rendered html string
         */
        private function renderPOSTSuccess() : string {
            $templateProperties = [];
            $templateProperties["header"] = "";
            $templateProperties["content"] = $this->openTemplate("templates/register/registerSuccess.php", []);
            $templateProperties["script"] = "";
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
            $registerTemplateProperties = $this->controller->getRegisterTemplateProperties();
            $templateProperties["content"] = $this->openTemplate("templates/register/register.php", $registerTemplateProperties);
            $templateProperties["script"] = "<script src='JS/formValidation.js'></script>";
            $templateProperties["script"] .= "<script src='JS/registrierung.js'></script>";
            $templateProperties["script"] .= "<script>";
            $templateProperties["script"] .= '    customErrorMessages = {' . $this->controller->getCustomErrorStrings() . '};';
            $templateProperties["script"] .= "    document.addEventListener('DOMContentLoaded', () => {";
            $templateProperties["script"] .= "        validateAll();";
            $templateProperties["script"] .= "    });";
            $templateProperties["script"] .= "</script>";
            return $this->openTemplate("templates/pageTemplate.php", $templateProperties);
        }

        /**
         * renders the page after a POST request and an error occured in the registration process
         *
         * @return string rendered html string
         */
        private function renderPOSTUnknownFailure() : string {
            $templateProperties = [];
            $templateProperties["header"] = "";
            $templateProperties["content"] = $this->openTemplate("templates/register/registerFailure.php", []);
            $templateProperties["script"] = "";
            return $this->openTemplate("templates/pageTemplate.php", $templateProperties);
        }

    }

?>