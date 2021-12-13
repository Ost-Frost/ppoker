<?php

    require("ViewBasis.php");
    require("ViewInterface.php");

    /**
     * the view for the MissingPage page
     */
    class MissingPage extends ViewBasis implements ViewInterface {

        /**
         * render method for the missingPage page. All Requests render the missingPage page
         *
         * @return string rendered html string
         */
        public function render() : string {
            http_response_code(404); // page not found
            $templateProperties = [];
            $templateProperties["header"] = "";
            $templateProperties["content"] = $this->openTemplate("templates/missingPage/missingPage.php");
            $templateProperties["script"] = "";
            return $this->openTemplate("templates/pageTemplate.php", $templateProperties);
        }

    }

?>