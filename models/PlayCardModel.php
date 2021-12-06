<?php
    require("ModelBasis.php");

    /**
     * Model for playing a card
     */
    class PlayCardModel extends ModelBasis {

        /**
         * gets data for the search API and returns it as an array by searching for every userName or eMail that starts with the requested string
         *
         * @return mixed if at least one user was found the method returns an array with all users, otherwise it returns false
         */
        public function playCard() {
            $value = $_REQUEST["value"];
            $gameID = $_REQUEST["gameID"]
            $userID = $_SESSION['userID'];

            $sqlQuery = "UPDATE `spielkarte` SET Karte='$value' UserStatus='2' WHERE UserID='$userID' AND SpielID='$gameID'";
            $this->dbConnect();
            $result = $this->dbSQLQuery($sqlQuery);
            $this->dbClose();

            if($row = $response->fetch_assoc()) {
                if($row == 0) {
                    return false;
                }
                return true;
            }
            return false;
        }
    }
?>