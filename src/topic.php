<?php
    require_once "db.php";

    class Topic {
        private $topicName;
        private $extraInfo;
        private $topicID;

        private $db;

        public function __construct($topicName) {
            $this->topicName = $topicName;

            $this->db = new Database();
        }

        public function getTopicName() {
            return $this->topicName;
        }

        public function getExtraInfo() {
            return $this->extraInfo;
        }

        public function getTopicID() {
            return $this->topicID;
        }

        public function setExtraInfo($extraInfo) {
            $this->extraInfo = $extraInfo;
        }

        
        public function topicExists() {
            $query = $this->db->selectTopicQuery(["topicID" => $this->topicID]);

            if ($query["success"]) {
                $topic = $query["data"]->fetch(PDO::FETCH_ASSOC);

                if ($topic) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return $query;
            }
        }

        public function selectTopicByID($topicID) {
            $query = $this->db->selectTopicQuery(["topicID" => $topicID]);
            if ($query["success"]) {
                $topic = $query["data"]->fetch(PDO::FETCH_ASSOC);

                if ($topic) {
                    return $topic["topicName"];
                } else {
                    return "Empty topic";
                }
            } else {
                return $query;
            }
        }

        public function createTopic($extraInfo) {
            $query = $this->db->insertTopicQuery(["topicName" => $this->topicName, "extraInfo" => $extraInfo]);

            return $query;
        }
    }
?>