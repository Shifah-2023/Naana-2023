<?php
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Step 6: Verify token and show the password reset form
    $currentTimestamp = date("Y-m-d H:i:s");
    $sql = "SELECT email, expiry_timestamp FROM password_reset WHERE token = :token AND expiry_timestamp >= :currentTimestamp";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':token', $token, PDO::PARAM_STR);
    $stmt->bindParam(':currentTimestamp', $currentTimestamp, PDO::PARAM_STR);
    $stmt->execute();

    $row = $stmt->fetch();

    if ($row) {
        $email = $row['email'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newPassword = $_POST['new_password'];
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

            // Update the user's password in the users table
            $sql = "UPDATE users SET password = :password WHERE email = :email";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            // Delete the used token from the password_reset table
            $sql = "DELETE FROM password_reset WHERE email = :email";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            // Redirect the user to a login page or a success message
            header("Location: ../../auth-login.php");
            exit();
        } else {
            // Show the password reset form
            echo "<h2>Reset Password for $email</h2>";
            echo "<form method='post' action='reset_password.php?token=$token'>";
            echo "New Password: <input type='password' name='new_password' required><br>";
            echo "<input type='submit' value='Reset Password'>";
            echo "</form>";
        }
    } else {
        // Token is invalid or expired, display an error message
        echo "Invalid or expired token.";
    }
} else {
    // Token is missing, display an error message or redirect to the password reset request page
    echo "Token is missing.";
}
