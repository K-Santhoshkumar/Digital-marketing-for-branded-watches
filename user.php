<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, apikey");
header("Content-Type: application/json");

define("SUPABASE_URL", "https://eppxrgnnkrrlzoihgvhq.supabase.co");
define("SUPABASE_API_KEY", "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVwcHhyZ25ua3JybHpvaWhndmhxIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc0MjE0NjMzOCwiZXhwIjoyMDU3NzIyMzM4fQ.qKWyf_r0T3J6kQAL7gnTtsMSQI1L2f8dtX7uBI4mOsk");


function fetchUserProfile($user_id) {
    $url = SUPABASE_URL . "/rest/v1/user_profile?user_id=eq.$user_id&select=*";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "apikey: " . SUPABASE_API_KEY,
        "Authorization: Bearer " . SUPABASE_API_KEY,
        "Content-Type: application/json"
    ]);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code !== 200) {
        return ["error" => "Failed to fetch profile", "status" => $http_code];
    }

    $data = json_decode($response, true);
    return $data ? $data[0] : null;
}

function updateUserProfile($data) {
    $user_id = $data["user_id"];
    
    $profileData = [
        "user_id" => $user_id,
        "name" => $data["name"],
        "phone" => $data["phone"],
        "address" => $data["address"],
        "brand" => $data["brand"]
    ];

    $url = SUPABASE_URL . "/rest/v1/user_profile";
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "apikey: " . SUPABASE_API_KEY,
        "Authorization: Bearer " . SUPABASE_API_KEY,
        "Content-Type: application/json",
        "Prefer: resolution=merge"
    ]);

    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($profileData));

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return ["status" => $http_code, "response" => json_decode($response, true)];
}

// Handle Requests
$method = $_SERVER["REQUEST_METHOD"];
if ($method === "GET" && isset($_GET["user_id"])) {
    $user_id = $_GET["user_id"];
    echo json_encode(fetchUserProfile($user_id));
} elseif ($method === "POST") {
    $inputData = json_decode(file_get_contents("php://input"), true);
    echo json_encode(updateUserProfile($inputData));
} else {
    echo json_encode(["error" => "Invalid request method"]);
}
?>
