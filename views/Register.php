<?php

    require("ViewBasis.php");
    require("ViewInterface.php");

    class Register extends ViewBasis implements ViewInterface {

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
                    echo "hi";
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