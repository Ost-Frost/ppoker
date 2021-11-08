<?php

    require("ViewBasis.php");
    require("ViewInterface.php");

    /**
     * the view for the Home page
     */
    class Home extends ViewBasis implements ViewInterface {
        public function render() : string {
            $templateProperties = [];
            $templateProperties["header"] = "";
            $templateProperties["content"] = $this->openTemplate("templates/home/home.php");
            $templateProperties["script"] = "";
            return $this->openTemplate("templates/navBarTemplate.php", $templateProperties);
        }

    }

?>