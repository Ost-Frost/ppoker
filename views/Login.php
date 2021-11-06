<?php

    require("ViewBasis.php");
    require("ViewInterface.php");

    class Login extends ViewBasis implements ViewInterface {

        public function render() : string {

            if ($_SERVER["REQUEST_METHOD"] === "POST") {

            } else if ($_SERVER["REQUEST_METHOD"] === "GET") {
                $templateProperties = [];
                $templateProperties["header"] = "";
                $templateProperties["content"] = $this->openTemplate("templates/login.php", []);
                $templateProperties["script"] = "<script src='JS/login.js'></script>";
                return $this->openTemplate("templates/pageTemplate.php", $templateProperties);
            }
        }

    }

?>