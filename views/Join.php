<?php

    require("ViewBasis.php");
    require("ViewInterface.php");

    /**
     * the view for the register page
     */
    class Join extends ViewBasis implements ViewInterface {

        /**
         * render method for the register page. a GET request returns the register page, while a POST request tries to register a new user.
         * If the user data is invalid the register page is returned with a script that shows the user the wrong data.
         *
         * @return string rendered html string
         */
        public function render() : string {
            $templateProperties = [];
            $data = $this->model->getJoinStructure();
            $templateProperties["header"] = "";
            $templateProperties["content"] = $this->openTemplate("templates/join/join.php");
            $templateProperties["script"] = "<script src='JS/join.js'></script>";
            return $this->openTemplate("templates/pageTemplate.php", $templateProperties);
        }

    }

?>