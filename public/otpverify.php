
<?php
    include '../includes/db.php'; // $conn is MySQLi
include '../includes/otp.php';
include '../includes/functions.php';

// Make sure user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}
// print_r($_SESSION);
$user_id = $_SESSION['user_id'];

try {
    // Fetch user info
    $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
    if (!$stmt) {
        throw new Exception($conn->error);
    }
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_info = $result->fetch_assoc();
    $stmt->close();

    // Check if form submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $input = trim($_POST['otp'] ?? '');

        if (isset($_SESSION['otp_code']) && $input === $_SESSION['otp_code']) {
            // Mark OTP as used
            $updateStmt = $conn->prepare("UPDATE user_otps SET is_used = 1 WHERE user_id = ?");
            if (!$updateStmt) {
                throw new Exception($conn->error);
            }
            $updateStmt->bind_param("i", $user_id);
            $updateStmt->execute();
            $updateStmt->close();

            // Unset OTP from session for security
            unset($_SESSION['otp_code']);

            // Redirect to dashboard
                        // Fetch user data
            $getuser = getUserWithOtp($conn, $_SESSION['user_id']);

            // Check the user's role and redirect accordingly
            if (isset($_SESSION['user_data']['role']) && $_SESSION['user_data']['role'] === "admin") {
                header("Location: admin/index.php");
                exit;
            } else {
                header("Location: dashboard.php");
                exit;
            }
        } else {
            // Invalid OTP
            $_SESSION['error'] = "Invalid OTP!";
            header('Location: ../index.php');
            exit;
        }
    }
} catch (Exception $e) {
    // Handle errors
    error_log("Database error: " . $e->getMessage());
    $_SESSION['error'] = "An internal error occurred. Please try again.";
    header('Location: ../index.php');
    exit;
}
?>















<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>OTP Verification</title>
</head>
<body>
    <div class="min-h-screen flex flex-col relative">
        <img src="../public/assets/defaults/a90b6aa3853d0a6252e1e4a556c0ce077bee0506.jpg" alt="#" class="absolute inset-0 w-full h-full object-cover blur-sm brightness-50">
        <div class="w-full h-[100vh] flex justify-center items-center px-4 relative z-10">
            <div class="bg-white shadow-lg px-8 md:px-12 w-[90%] md:w-[400px] gap-4 py-12 flex justify-center items-center flex-col ">
                <img src="../public/assets/defaults/download.png " alt="" class="w-[100px] rounded-full">
                <p class="text-black w-full text-center text-xl font-bold">Student Verification</p>
                <div class="px-0 mb-2 md:mb-0 md:mt-[10px] md:mb-[10px] text-[16px]">
                    <?php if (!empty($user_info)){
                        echo '<div>';

                        echo '<p class="text-gray-800 text-[14px]">Name <br>' . '</p>';
                        echo  '<p class="text-[16px]">'. htmlspecialchars($user_info['full_name']) . '</p>';

                        echo '<p class="text-gray-800 text-[14px]">Email <br>' . '</p>';
                        echo '<p class="text-[16px]">' . htmlspecialchars($user_info['email']) . '</p>';

                        echo '<p class="text-gray-800 text-[14px]">Registration Number: <br>' . '</p>';
                        echo '<p class="text-[16px]">'. htmlspecialchars($user_info['reg_no'] ?? 'N/A') . '</p>';

                        echo '<p class="text-gray-800 text-[14px]">Department <br>' . '</p>';
                        echo '<p class="text-[16px]">' . htmlspecialchars($user_info['department'] ?? 'N/A') . '</p>';

                        echo '</div>';                          

                    }
                        
                    ?>
                </div>
                
                <form action="otpverify.php" method="POST" class="flex flex-col w-[90%]">
                    <input type="text" name="otp" placeholder="OTP" class="w-full border border-gray-300 p-2 mb-4 outline-none placeholder:text-sm" value="<?php echo htmlspecialchars($_POST['otp'] ?? ''); ?>">
                    <button class="w-full bg-green-700 p-2 text-white cursor-pointer">Continue</button>
                </form>
            </div>

        </div>
    </div>
</body>
</html>
