<?php
// Include the database connection (ensure this file contains the correct database credentials)
include("conn.php");

// Parse the JSON data from the request body
$data = json_decode(file_get_contents("php://input"), true);
$ACTIVEID = $_GET["ACTIVEID"];  // Default to '2' if ACTIVEID is not provided

// Initialize the response array
$response = ["success" => false, "message" => ""];

// SQL query with parameterized binding for security
$sql = "SELECT 
    m1.MEMBER_FIRST_NAME,
    m1.MEMBER_LAST_NAME,
    m1.MEMBER_ACCOUNT,
    m1.MEMBER_PHONE,
    r1.REGISTER_TOTAL_PRICE,
    r1.REGISTER_COUNT,
    IFNULL(r1.REGISTER_PAIED, 0) AS REGISTER_PAIED,
    r1.ACTIVITY_ID 
FROM register r1 
LEFT JOIN activity a1 ON a1.ACTIVITY_ID = r1.ACTIVITY_ID 
LEFT JOIN member m1 ON r1.MEMBER_ID = m1.MEMBER_ID
WHERE a1.ACTIVITY_ID = :ACTIVEID";

// Prepare the SQL statement
$pstmt = $pdo->prepare($sql);

// Bind the ACTIVEID parameter to the value
$pstmt->bindValue(':ACTIVEID', $ACTIVEID, PDO::PARAM_INT);

// Execute the query
$pstmt->execute();

// Fetch all results
$inquireActivity = $pstmt->fetchAll(PDO::FETCH_ASSOC);

// Check if any data was returned
if ($inquireActivity) {
    $response["success"] = true;
    $response["message"] = "Data retrieved successfully.";
    $response["data"] = $inquireActivity;
} else {
    $response["message"] = "No data found for the given ACTIVEID.";
}

// Return the response as a JSON object
echo json_encode($response);
?>