<?php

    require("ModelBasis.php");

    /**
     * model for the register page
     */
    class CreateModel extends ModelBasis {

        public function search() : mixed {

            $userName = $_GET["userName"];

            $response = [];
            $sqlQuery = "SELECT Username FROM user WHERE Username LIKE '$userName%'";
            $this->dbConnect();
            $result = $this->dbSQLQuery($sqlQuery);
            while ($row = mysqli_fetch_assoc($result)) {
                $foundUserName = $row["Username"];
                array_push($response, $foundUserName);
            }
            $this->dbClose();
            if (count($response) === 0) {
                return false;
            }
            return $response;
        }

    }

?>