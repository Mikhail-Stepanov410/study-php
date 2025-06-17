<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <div class="top_message">
<?php


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if (empty($username) || empty($password)) {
        $message = "Please fill in both username and password.";
    } else {
        $file = "user.txt";
        $users = file_exists($file) ? file($file, FILE_IGNORE_NEW_LINES) : [];

        $userExists = false;

        foreach ($users as $userLine) {
            list($storedUser,) = explode("|", $userLine);
            if ($storedUser === $username) {
                $userExists = true;
                break;
            }
        }

        if ($userExists) {
            $message = "Username already exists.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $line = $username . "|" . $hashedPassword . "\n";
            file_put_contents($file, $line, FILE_APPEND);
            $message = "Welcome " . htmlspecialchars($username) . "!";
        }
    }
}

if (isset($message)) {
    echo "<p>$message</p>";
} 
    ?>

    </div>
    <div class="form">
        
        <form action="index.php" method="post">

            <label for="">Username</label> <br>
            <input type="text" name="username"> <br>
            <label for="">Password</label> <br>
            <input type="password" name="password"> <br>
            <input type="submit" value="Submit" class="submit">

        </form>

    </div>
</body>
</html>
