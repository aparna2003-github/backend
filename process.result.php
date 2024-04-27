
<?php
// Your existing code for processing user responses goes here...

// Database connection parameters
$servername = "127.0.0.1:3307";
    $username = "root";
    $password = "";
    $dbname = "routeskin";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch user responses
$user_query = "SELECT skin_type, skin_concerns FROM user_responses";
$user_result = $conn->query($user_query);

// if ($user_result->num_rows > 0) {
//     // Loop through each user response
//     while ($user_row = $user_result->fetch_assoc()) {
//         $skin_type = $user_row["skin_type"];
//         $skin_concerns = $user_row["skin_concerns"];
        
        // Query to check if any combination exists in the combination table for the user response
        $combination_query = "SELECT result_link FROM combination WHERE c_skintype = '$skin_type' AND c_skinconcerns = '$skin_concerns'";
        $combination_result = $conn->query($combination_query);
        
        if ($combination_result->num_rows > 0) {
            // Loop through each combination for the user response
            while ($combination_row = $combination_result->fetch_assoc()) {
                // Fetch the HTML page link and redirect the user
                $html_page_link = $combination_row["result_link"];
                header("Location: $html_page_link");
                exit();
            }
        } else {
            // Combination not found in the combination table
            echo "No matching combination found for skin type: $skin_type and skin concerns: $skin_concerns";
        }
//     }
// } else {
//     // No user responses found
//     echo "No user responses found.";
// }

$conn->close();
?>
