<?php
require_once "../db.php";

if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $errors = array();
    if (empty($email) || empty($password)) {
        array_push($errors, "Email and password are required");
    } else {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);
        if ($user) {
            if (password_verify($password, $user["password"])) {
                setcookie('currentUser', $user['id'], time() + (86400 * 30), "/");
                header("Location: homepage.php");
                exit();
            } else {
                $errors[] = "Құпиясөз қате";
            }
        } else {
            $errors[] = "Терілген пошта тіркелмеген";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <link href='https://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            background-color: #03060c;
            padding: 50px;
            font-family: Comfortaa;
            color: black;
            background-image: url('../img/8798.svg');
            background-size: cover;
        }        
        .logincard {
            max-width: 600px;
            margin: 0 auto;
            padding: 50px;
            box-shadow: 0px 7px 29px 0px rgba(123, 160, 152, 0.5);
            border-radius: 30px;
            background-color: #ffff;
        }
        .formgroup {
            margin-bottom: 30px;
        }
        .btn {
            background-color: rgb(123, 160, 152);
            box-shadow: 0 0 50px rgb(123, 160, 152);
            border: 0;
            transition: 500ms;
        }
        .btn:hover {
            background-color: transparent;
            border: rgb(123, 160, 152) 1px solid;
            transform: scale(0.9);
            box-shadow: none;
            color: black;
        }
        .text_login {
            color: black;
            font-size: 22px;
            text-align: center;
            margin-bottom: 30px;
        }

    </style>
</head>
<body>

<div class="logincard">
    <div class="text_login"> Кіру </div>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error): ?>
                <p><?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <form action="login.php" method="post">
        <div class="formgroup">
            <input type="email" class="form-control" name="email" placeholder="Email:" required>
        </div>
        <div class="formgroup">
            <input type="password" class="form-control" name="password" placeholder="Құпия сөз:" required>
        </div>
        <div class="formgroup">
            <input type="submit" class="btn btn-primary" value="Жүйеге кіру" name="login">
        </div>
    </form>

    <div>
        <p>Жүйеге әлі тіркелмедіңіз бе?  <a href="register.php">Тіркелу</a></p>
    </div>
</div>

</body>
</html>
