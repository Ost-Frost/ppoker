<?php

    require("ViewBasis.php");
    require("ViewInterface.php");

    /**
     * the view for the Game page. The game page is for API only. automatically returns 404 and empty JSON when rendered.
     */
    class Game extends ViewBasis implements ViewInterface {
        public function render() : string {
            http_response_code(404); // page not found
            return "{}";
        }

    }

?>