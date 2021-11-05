<?php

    require("ViewBasis.php");
    require("ViewInterface.php");

    class Login extends ViewBasis implements ViewInterface {

        public function render() : string {


            ob_start();
            require "templates/register.php";
            $html=ob_get_contents();
            ob_end_clean();
            return $html;
        }

    }

?>