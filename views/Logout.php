<?php

    require("ViewBasis.php");
    require("ViewInterface.php");

    /**
     * the view for the register page
     */
    class LogOut extends ViewBasis implements ViewInterface {

        /**
         * render method for the register page. a GET request returns the register page, while a POST request tries to register a new user.
         * If the user data is invalid the register page is returned with a script that shows the user the wrong data.
         *
         * @return string rendered html string
         */
        public function render() : string {
            $templateProperties = [];
            $templateProperties["header"] = "<meta http-equiv = 'refresh' content = '5; url = #' />";
            $templateProperties["content"] = $this->openTemplate("templates/logout/logout.php");
            $templateProperties["script"] = "";
            return $this->openTemplate("templates/pageTemplate.php", $templateProperties);
        }

    }

?>