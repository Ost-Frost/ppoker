<?php

    require("ViewBasis.php");
    require("ViewInterface.php");

    class Register extends ViewBasis implements ViewInterface {

        public function render() : string {

            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                if ($this->controller->validateData()) {
                    $this->model->addUser();
                } else {

                }
            } else if ($_SERVER["REQUEST_METHOD"] === "GET") {
                $templateProperties = [];
                $templateProperties["header"] = "";
                $templateProperties["content"] = $this->openTemplate("templates/register.php", []);
                $templateProperties["script"] = "<script src='JS/registrierung.js'></script>";
                return $this->openTemplate("templates/pageTemplate.php", $templateProperties);
            }
        }

    }

?>