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