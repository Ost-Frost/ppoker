<?php

    require("ViewBasis.php");
    require("ViewInterface.php");

    /**
     * the view for the register page
     */
    class Register extends ViewBasis implements ViewInterface {

        /**
         * render method for the register page. a GET request returns the register page, while a POST request tries to register a new user.
         * if the user data is invalid the register page is returned with a script that shows the user the wrong data
         *
         * @return string rendered html string
         */
        public function render() : string {

            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                if ($this->controller->validateData()) {
                    //$this->model->addUser();
                    $templateProperties = [];
                    $templateProperties["header"] = "";
                    $templateProperties["content"] = $this->openTemplate("templates/registerSuccess.php", []);
                    $templateProperties["script"] = "";
                    return $this->openTemplate("templates/pageTemplate.php", $templateProperties);
                } else {
                    $templateProperties = [];
                    $templateProperties["header"] = "";
                    $registerTemplateProperties = $this->controller->getRegisterTemplateProperties();
                    $templateProperties["content"] = $this->openTemplate("templates/register.php", $registerTemplateProperties);
                    $templateProperties["script"] =  "<script src='JS/registrierung.js'></script>";
                    $templateProperties["script"] .= "<script>";
                    $templateProperties["script"] .= "    document.addEventListener('DOMContentLoaded', () => {";
                    $templateProperties["script"] .= "        validateAll();";
                    $templateProperties["script"] .= "    });";
                    $templateProperties["script"] .= "</script>";
                    return $this->openTemplate("templates/pageTemplate.php", $templateProperties);
                }
            } else if ($_SERVER["REQUEST_METHOD"] === "GET") {
                $templateProperties = [];
                $templateProperties["header"] = "";
                $registerTemplateProperties = $this->controller->getRegisterTemplateProperties();
                $templateProperties["content"] = $this->openTemplate("templates/register.php", $registerTemplateProperties);
                $templateProperties["script"] = "<script src='JS/registrierung.js'></script>";
                return $this->openTemplate("templates/pageTemplate.php", $templateProperties);
            }
        }

    }

?>