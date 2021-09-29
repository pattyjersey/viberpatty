<?php

$access_token = "4e0c26777aa7e55f-7e08d417b24ba5b3-ee4f469af648656c";

$request = file_get_contents("php://input");
$input = json_decode($request, true);

if($input['event']=='webhook') {
    $webhook_response['status'] = 0;
    $webhook_response['status_message'] = "ok";
    $webhook_response['event_types'] = "delivered";
    echo json_encode($webhook_response);
    die;
}

elseif($input['event']=='message'){
    $text_received = strtolower($input['message']['text']);
    $sender_id = $input['sender']['id'];
    $sender_name = $input['sender']['name'];

    if($text_received=="Attendance"){
        $message_to_reply = "Hello, ".$sender_name.". How can I help you?";
    }
    else{
        $message_to_reply = "Welcome, Staff";
    }
    

    $data['auth_token'] = $access_token;
    $data['receiver'] = $sender_id;
    $data['type'] = "text";
    $data['text'] = $message_to_reply;
    sendMessage($data);
}

function sendMessage($data) {
    $url = "https://chatapi.viber.com/pa/send_message";
    $jsonData = json_encode($data);
    $ch = curl_init($url);
    curl_setopt($ch,CURLOPT_POST,1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$jsonData);
    curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
    $result = curl_exec($ch);
    return $result;
}


?>