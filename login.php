<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["signup"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];

        if (empty($email) || empty($password)) {
            $_SESSION["error"] = "Email and password are required.";
        } else {
            try {
                $db = new PDO('sqlite:base.db');
                $stmt = $db->prepare('INSERT INTO users (email, password) VALUES (:email, :password)');
                $stmt->bindParam(':email', $email);
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt->bindParam(':password', $password_hash);
                $stmt->execute();
                $_SESSION["message"] = "Account created successfully.";
            } catch (PDOException $e) {
                $_SESSION["error"] = "Account creation failed: " . $e->getMessage();
            }
        }
    }else {
        $email = $_POST["email"];
        $password = $_POST["password"];

        if (empty($email) || empty($password)) {
            $_SESSION["error"] = "Email and password are required.";
        } else {
            try {
                $db = new PDO('sqlite:base.db');
                $stmt = $db->prepare('SELECT id, password FROM users WHERE email = :email');
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                $user = $stmt->fetch();
                if ($user !== false && password_verify($password, $user['password'])) {
                    $_SESSION["user_id"] = $user["id"];
                    header("Location: /dashboard");
                } else {
                    $_SESSION["error"] = "Invalid email or password.";
                }
            } catch (PDOException $e) {
                $_SESSION["error"] = "Connection failed: " . $e->getMessage();
            }
        }
    }
}
?>
