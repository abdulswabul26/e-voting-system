<!-- // include '../includes/db.php';
// session_start();

// function generateAndStoreOTP($conn) {
//     if (!isset($_SESSION['user_id'])) {
//         return false;
//     }

//     $user_id = $_SESSION['user_id'];

//     // 1. Check if an OTP already exists for this user
//     $stmt = $conn->prepare("SELECT otp_code, expires_at FROM user_otps WHERE user_id = ? LIMIT 1");
//     $stmt->bind_param("i", $user_id);
//     $stmt->execute();
//     $result = $stmt->get_result();
//     $existing_otp = $result->fetch_assoc();
//     $stmt->close();

//     // 2. If OTP exists and is still valid, return it
//     if ($existing_otp && strtotime($existing_otp['expires_at']) < time()) {
//         return $existing_otp['otp_code'];
//     }else{
//             // 3. Otherwise, generate a new OTP
//         $otp = rand(100000, 999999); // 6-digit OTP
//         $expires_at = date("Y-m-d H:i:s", strtotime("+5 minutes"));

//         $stmt = $conn->prepare("
//             INSERT INTO user_otps (user_id, otp_code, expires_at)
//             VALUES (?, ?, ?)
//             ON DUPLICATE KEY UPDATE
//                 otp_code = VALUES(otp_code),
//                 expires_at = VALUES(expires_at)
//         ");
//         $stmt->bind_param("iis", $user_id, $otp, $expires_at);
//         $stmt->execute();
//         $stmt->close();
//     }   

//     // 4. Ideally, send the OTP via email here (omitted for brevity)
//     // check if the otp is beyoud its expiry time
//     // Expire OTPs that are beyond their expiry time for this user
//     // $stmt = $conn->prepare("DELETE FROM user_otps WHERE user_id = ? AND expires_at <= NOW()");
//     // $stmt->bind_param("i", $user_id);
//     // $stmt->execute();
//     // $stmt->close();


//     return $otp;
// }

// // For testing purposes, display the OTP (remove in production)
// $otp = generateAndStoreOTP($conn);
// echo "Your OTP i   s: " . $otp;

// For testing purposes, display the OTP (remove in production)
// $otp = generateAndStoreOTP($conn); -->


<?php
session_start() ;
include '../includes/db.php';

function generateAndStoreOTP($conn) {
    $user_id = $_SESSION['user_id'];
    // $user_id = "1";

    // 1. Check if an OTP already exists for this user
    $stmt = $conn->prepare("SELECT otp_code, expires_at FROM user_otps WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $existing_otp = $result->fetch_assoc();
    $stmt->close();



    // Create an OTP
    if(empty($existing_otp)){
        $otp = rand(100000, 999999); // 6-digit OTP
        $expires_at = date("Y-m-d H:i:s", strtotime("+5 minutes"));

        // Store the OTP
        $stmt = $conn->prepare("INSERT INTO user_otps (user_id, otp_code, expires_at)
                                VALUES (?, ?, ?);"
                              );
        $stmt->bind_param("iis", $user_id, $otp, $expires_at);
        $stmt->execute();
        $stmt->close();
    }else{
        $_SESSION['otp_code'] = $existing_otp['otp_code'];
    }

}
generateAndStoreOTP($conn);
?>