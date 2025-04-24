<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Content-Type: application/json"); 
    // echo json_encode(['error' => 'Unauthorized access']);
    http_response_code(403);
    exit;
}

// header("Content-Type: application/json");

$apiKey = "AIzaSyDzeOhS2fVFzHHBxGbZCZO60XcNthL9GGc";
$endpoint = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $message = isset($_POST["message"]) ? $_POST["message"] : "";
    

    if (empty($message)) {
        echo json_encode(["error" => "Empty request message"]);
        exit;
    }

    $data = [
        "contents" => [
            [
                "parts" => [
                    ["text" => $message]
                ]
            ]
        ]
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $endpoint . "?key=" . $apiKey);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    if ($httpCode === 200) {
        echo $response;
    } else {
        echo json_encode(["error" => "HTTP Error $httpCode: $error"]);
    }
} else {
    echo json_encode(["error" => "Invalid request"]);
}
?>
