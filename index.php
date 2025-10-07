<?php
session_start();
$regnoError = '';

try {
    // PDO connection
    $dsn = "mysql:host=localhost;dbname=evotingdb;charset=utf8mb4";
    $username = "root";
    $password = "";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Throw exceptions
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    $pdo = new PDO($dsn, $username, $password, $options);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $input = trim($_POST['regno'] ?? '');

        if (
            !preg_match('/^\d{4}-\d{2}-\d{5}$/', $input) &&
            !preg_match('/^[a-zA-Z0-9._%+-]+@studmc\.kiu\.ac\.ug$/', $input)
        ) {
            $regnoError = 'Please enter a valid registration number or KIU student email address.';
        } else {
            // Prepare statement
            $stmt = $pdo->prepare("SELECT user_id, reg_no, email, full_name FROM users WHERE reg_no = :input OR email = :input");
            $stmt->execute(['input' => $input]);
            $row = $stmt->fetch();

            if ($row) {
                $_SESSION['user_id'] = $row['user_id'];
                header("Location: public/otpverify.php");
                exit();
            } else {
                $regnoError = 'User not found.';
            }
        }
    }
} catch (PDOException $e) {
    // Handle PDO exceptions (database errors)
    $regnoError = "Database error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Voting Portal</title>
</head>
<body>
    <div class="min-h-screen flex flex-col relative">
        <img src="public/assets/defaults/a90b6aa3853d0a6252e1e4a556c0ce077bee0506.jpg" alt="#" class="absolute inset-0 w-full h-full object-cover blur-sm brightness-50">
        <div class="w-full h-[100vh] flex justify-center items-center px-4 relative z-10">
            <div class="bg-white shadow-lg px-8 md:px-12 w-[90%] md:w-[400px] gap-4 py-12 flex justify-center items-center flex-col ">
                <img src="public/assets/defaults/logo.png" alt="" class="w-[80%]">
                <p class="text-black w-full text-center text-xl font-bold mb-4">Voting portal</p>
                <form action="index.php" method="POST" class="flex flex-col w-[90%]">
                    <input type="text" name="regno" placeholder="Email or Registration Number" class="w-full border border-gray-300 p-2 mb-4 outline-none placeholder:text-sm" value="<?php echo htmlspecialchars($_POST['regno'] ?? ''); ?>">
                    <?php if ($regnoError): ?>
                        <p class="text-red-500 text-sm mb-2"><?php echo $regnoError; ?></p>
                    <?php endif; ?>
                    <button class="w-full bg-green-700 p-2 text-white cursor-pointer">Continue</button>
                </form>
                <p class="text-gray-400 mt-10 text-[13px]">Please use your registration number or KIU student email address (e.g. xxxxxx@stdwc.kiu.ac.ug) to login. For assistance please visit ICT office.</p>
            </div>
        </div>
    </div>
</body>
</html>