<?php
    require_once "topic.php";
    require_once "utility.php";

    header("Content-type: application/json");
    // header("Access-Control-Allow-Origin", "*");

    $requestURL = $_SERVER["REQUEST_URI"];

    if(preg_match("/topicInsert$/", $requestURL)) {
        topicInsert();
    } elseif(preg_match("/topicSelect$/", $requestURL)) {
        topicSelect();
    }  elseif(preg_match("/topicTest$/", $requestURL)) {
        topicTest();
    } else {
        echo json_encode(["error" => "URL not found"]);
    }

    function topicInsert() {
        $errors = [];
        $response = [];
        $topic;

        if ($_POST) {
            $data = json_decode($_POST["data"], true);

            $topicName = isset($data["topicName"]) ? testInput($data["topicName"]) : "";
            $extraInfo = isset($data["extraInfo"]) ? testInput($data["extraInfo"]) : "";

            if (!$topicName) {
                $errors[] = "Името на темата е задължително поле";
            }

            if ($topicName) {
                $topic = new Topic($topicName);
                $exists = $topic->topicExists();
    
                if ($exists) {
                    $errors[] = "Тази тема вече съществува";
                } else {
                    $topic->createTopic($extraInfo);
                }
            }
        } else {
            $errors[] = "Невалидна заявка";
        }

        if($errors) {
            $response = ["success" => false, "error" => $errors];
        } else {
            $message = "Успешно добавихте тема!";
            $response = ["success" => true, "message" => $message];
        }

        echo json_encode($response);
    }

    function topicSelect() {
        $response = [];

        $topic = new Topic("");
        $topicName = $topic->selectTopicByID(1);
        if ($topicName) {
            $response = ["success" => true, "message" => $topicName];
        } else {
            $errors = "Успешно добавихте тема!";
            $response = ["success" => false, "error" => $errors];
        }

        echo json_encode($response);
    }

    function topicTest() {
        $incomingContentType = $_SERVER['CONTENT_TYPE'];
        if ($incomingContentType != 'application/json') {
            header($_SERVER['SERVER_PROTOCOL'] . ' 500 INTERNAL SERVER ERROR ');
            exit();
        }
        $content = trim(file_get_contents("php://input"));
        $data = json_decode($content, true);
        $topicName = $data["topicName"];
        $extraInfo = $data["extraInfo"];
        if ($topicName) {
            $topic = new Topic($topicName);
            $exists = $topic->topicExists();

            if ($exists) {
                $errors[] = "Тази тема вече съществува";
                $response = ["success" => false, "message" => $errors];
            } else {
                $topic->createTopic($extraInfo);
                $message = 'You successfully inserted topic' . ' ' . $topicName . ' with extra info: ' . $extraInfo;
                $response = ["success" => true, "message" => $message];
            }
         } else {
            $response = ["success" => false, "message" => "Topic name is required!"];
        }
        
        echo json_encode($response);
    }