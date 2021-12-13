<?php

    require("ViewBasis.php");
    require("ViewInterface.php");

    /**
     * the view for the register page
     */
    class LogOut extends ViewBasis implements ViewInterface {

        /**
         * render method for the logout page. a GET request loggs the user out and returns the logout page
         *
         * @return string rendered html string
         */
        public function render() : string {
            if ($_SERVER["REQUEST_METHOD"] !== "GET") {
                http_response_code(405); // Invalid method
                return "{}";
            }
            $templateProperties = [];
            $this->controller->logOut();
            $templateProperties["header"] = "<meta http-equiv = 'refresh' content = '5; url = Login' />";
            $templateProperties["content"] = $this->openTemplate("templates/logout/logout.php");
            $templateProperties["script"] = "";
            return $this->openTemplate("templates/pageTemplate.php", $templateProperties);
        }

    }

?>