<?php

    require("ModelBasis.php");

    /**
     * model for the register page
     */
    class CreateModel extends ModelBasis {

        /**
         * gets data for the search API and returns it as an array by searching for every userName or eMail that starts with the requested string
         *
         * @return mixed if at least one user was found the method returns an array with all users, otherwise it returns false
         */
        public function search() : mixed {

            $userName = $_GET["userName"];
            $response = [];
            $sqlQuery = "SELECT Username FROM user WHERE (Username LIKE '$userName%' OR Mail LIKE '$userName%')";
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