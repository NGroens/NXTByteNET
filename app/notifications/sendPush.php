<?php

function sendPush($push_user, $push_title, $push_message, $push_url = null, $push_url_title = null){
    curl_setopt_array($ch = curl_init(), array(
        CURLOPT_URL => "https://api.pushover.net/1/messages.json",
        CURLOPT_POSTFIELDS => array(
            //TODO
            // change pushover key
            "token" => 'ax412h5819kd5n1egwndk3ts37fon1',
            "user" => $push_user,
            "title" => $push_title,
            "url" => $push_url,
            "url_title" => $push_url_title,
            "message" => $push_message,
        ),
        CURLOPT_SAFE_UPLOAD => true,
        CURLOPT_RETURNTRANSFER => true,
    ));
    curl_exec($ch);
    curl_close($ch);
}