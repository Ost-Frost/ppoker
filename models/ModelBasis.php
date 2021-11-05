<?php
    class ModelBasis {

        protected mysqli $dbLink;

        function dbConnect() {
            if (is_null($this->dbLink)) {
                $this->dbLink = mysqli_connect("localhost", "root", "", "ppoker") or die("database connection failed");
            }
        }

        function dbClose() {
            if (!is_null($this->dbLink)) {
                mysqli_cose($this->dbLink);
                $this->dbLink = null;
            }
        }

        function dbSQLQuery(string $sql) {
            return mysqli_query($this->dbLink, $sql);
        }

    }

?>