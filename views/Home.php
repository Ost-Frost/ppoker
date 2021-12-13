<?php

    require("ViewBasis.php");
    require("ViewInterface.php");

    /**
     * the view for the Home page
     */
    class Home extends ViewBasis implements ViewInterface {

        /**
         * render method for the home page. a GET request returns the home page
         *
         * @return string rendered html string
         */
        public function render() : string {
            if ($_SERVER["REQUEST_METHOD"] !== "GET") {
                http_response_code(405); // Invalid method
                return "{}";
            }
            $templateProperties = [];
            $templateProperties["header"] = "";
            $templateProperties["content"] = $this->openTemplate("templates/home/home.php");
            $templateProperties["script"] = "";
            return $this->openTemplate("templates/navBarTemplate.php", $templateProperties);
        }

    }

?>