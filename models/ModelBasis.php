<?php

    /**
     * base model class. all models have to extend this class
     */
    class ModelBasis {

        /**
         * link to the connected database
         */
        protected mysqli $dbLink;

        /**
         * builds up a connection to the database
         */
        function dbConnect() {
            if (is_null($this->dbLink)) {
                $this->dbLink = mysqli_connect("localhost", "root", "", "ppoker") or die("database connection failed");
            }
        }

        /**
         * closes an existing connection to the database
         */
        function dbClose() {
            if (!is_null($this->dbLink)) {
                mysqli_cose($this->dbLink);
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
        function dbSQLQuery(string $sql) {
            if (!is_null($this->dbLink)) {
                return mysqli_query($this->dbLink, $sql);
            } else {
                return null;
            }
        }

    }

?>