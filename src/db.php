<?php
    class Database {
        private $connection;
        private $insertTopicStatement;
        private $selectTopicStatement;

        public function __construct() {
            $config = parse_ini_file("../config/config.ini", true);

            $host = $config['db']['host'];
            $dbname = $config['db']['name'];
            $user = $config['db']['user'];
            $password = $config['db']['password'];

            $this->init($host, $dbname, $user, $password);
        }

        private function init($host, $dbname, $user, $password) {
            try {
                $this->connection = new PDO("mysql:host=$host;dbname=$dbname", $user, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

                $this->prepareStatements();
            } catch(PDOException $e) {
                return "Connection failed: " . $e->getMessage();
            }
        }

        private function prepareStatements() {
            $sql = "INSERT INTO topic(topicName, extraInfo) VALUES (:topicName, :extraInfo)";
            $this->insertTopicStatement = $this->connection->prepare($sql);

            $sql = "SELECT * FROM topic WHERE topicID=:topicID";
            $this->selectTopicStatement = $this->connection->prepare($sql);
        }

        public function insertTopicQuery($data) {
            try {
                // ["topicName" => "...", "extraInfo => "..."]
                $this->insertTopicStatement->execute($data);

                return ["success" => true];
            } catch(PDOException $e) {
                return ["success" => false, "error" => $e->getMessage()];
            }
        }

        public function selectTopicQuery($data) {
            try {
                // ["topicID" => "..."]
                $this->selectTopicStatement->execute($data);

                return ["success" => true, "data" => $this->selectTopicStatement];
            } catch(PDOException $e) {
                return ["success" => false, "error" => $e->getMessage()];
            }
        }
    }
?>