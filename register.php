<?php
require 'includes/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $error_message = '';  // Variable to store error message

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = 'Invalid email format.';
    }

    // Validate password length
    if (strlen($password) < 8) {
        $error_message = 'Password must be at least 8 characters long.';
    }

    // Check if username or email already exists
    if (empty($error_message)) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error_message = 'Username or email already exists.';
        }
        $stmt->close();
    }

    // If there is an error message, show it and prevent page reload
    if ($error_message) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var errorMsg = document.createElement('div');
                errorMsg.textContent = '$error_message';
                errorMsg.style.position = 'fixed';
                errorMsg.style.bottom = '20px';
                errorMsg.style.left = '20px';
                errorMsg.style.backgroundColor = 'red';
                errorMsg.style.color = 'white';
                errorMsg.style.padding = '10px 20px';
                errorMsg.style.borderRadius = '5px';
                errorMsg.style.zIndex = '9999';
                document.body.appendChild(errorMsg);
                
                // Fade out after 3 seconds
                setTimeout(function() {
                    errorMsg.style.transition = 'opacity 1s';
                    errorMsg.style.opacity = 0;
                    setTimeout(function() {
                        errorMsg.remove();
                    }, 1000);
                }, 3000);
            });

            // Prevent form submission (Page Refresh)
            event.preventDefault();
        </script>";
        echo "<center><a href='register.php'>Go Back</a><center>";
        return; // Stop further processing
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insert the new user
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashedPassword);

    if ($stmt->execute()) {
        echo "<script>
            alert('Registration successful!');
            window.location.href = 'index.php';
        </script>";
    } else {
        echo "<script>
            alert('Error: " . $stmt->error . "');
        </script>";
    }

    $stmt->close();
}


require 'frontend/template/register.frontend.php';
?>



