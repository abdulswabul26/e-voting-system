<!-- general helper functions -->

<?php

include '../includes/db.php';

function getUserWithOtp($conn, $user_id) {
    if (isset($_SESSION['user_data']) && $_SESSION['user_data']['user_id'] == $user_id) {
        return $_SESSION['user_data'];
    }

    $sql = "SELECT users.*, user_otps.* 
            FROM users 
            LEFT JOIN user_otps ON users.user_id = user_otps.user_id 
            WHERE users.user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    $_SESSION['user_data'] = $result; // store in session
    return $result;
}
$getuser= getUserWithOtp($conn, $_SESSION['user_id']);
// print_r ($_SESSION);
?>