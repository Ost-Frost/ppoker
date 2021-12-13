<?php

    /**
     * base model class. all models have to extend this class
     */
    class ModelBasis {

        /**
         * link to the connected database
         */
        protected $dbLink;

        /**
         * builds up a connection to the database
         */
        public function dbConnect() {
            if (is_null($this->dbLink)) {
                $this->dbLink = mysqli_connect("localhost", "root", "", "ppoker") or die("database connection failed");
            }
        }

        /**
         * closes an existing connection to the database
         */
        public function dbClose() {
            if ($this->dbCheckConnection()) {
                mysqli_close($this->dbLink);
                $this->dbLink = null;
            }
        }

        /**
         * executes an sql query and returns the response. Needs an existing database connection
         *
         * @param string sql query to resolve
         *
         * @return array resolved query
         */
        public function dbSQLQuery(string $sql) {
            if ($this->dbCheckConnection()) {
                return mysqli_query($this->dbLink, $sql);
            } else {
                return false;
            }
        }

        /**
         * checks if the connection to the database works
         *
         * @return boolean true if the connection works, false otherwise
         */
        public function dbCheckConnection() {
            if (is_null($this->dbLink)) {
                return false;
            } else if (!$this->dbLink) {
                return false;
            } else {
                return true;
            }
        }

        /**
         * checks if the sql query is valid and returns data
         *
         * @return boolean true if the sql query is valid and returns data, false otherwise
         */
        public function checkSQLQuery($sqlQuery, $closeDBConnection=true) {
            $sqlQueryExists = true;
            $this->dbConnect();
            $response = $this->dbSQLQuery($sqlQuery);
            if ($closeDBConnection) {
                $this->dbClose();
            }
            if (!$response || is_null(mysqli_fetch_assoc($response))) {
                $sqlQueryExists = false;
            }
            return $sqlQueryExists;
        }

        /**
         * checks if the given gameID exists
         *
         * @return boolean true the gameID exists, false otherwise
         */
        public function checkGameID() {
            if (!isset($_POST["gameID"]) || $_POST["gameID"] === "") {
                return false;
            }
            $userID = $_SESSION["userID"];
            $gameID = $_POST["gameID"];
            $sqlQuery = "SELECT s.SpielID FROM spiele s INNER JOIN spielkarte sk ON s.SpielID = sk.SpielID ";
            $sqlQuery .= "WHERE sk.UserID='$userID' AND s.SpielID='$gameID' AND sk.UserStatus='0'";
            return $this->checkSqlQuery($sqlQuery);
        }

    }

?>