
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link href='https://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body{
            background-image: url(img/back_log_002.svg);
            padding: 50px;
            font-family: Comfortaa;
            color: black;
            background-image: url('../img/8798.svg');
            background-size: cover;
        }
        .regcard{
            max-width: 600px;
            margin: 0 auto;
            padding: 50px;
            box-shadow: 0px 7px 29px 0px rgba(123, 160, 152, 0.5);
            border-radius: 30px;
            background-color: #fff;
        }
        .formgroup{
            margin-bottom: 30px;
        }
        .btn{
            background-color: rgb(123, 160, 152);
            box-shadow: 0 0 50px rgb(123, 160, 152);
            border: 0;
            transition: 500ms;
        }
        .btn:hover{
            background-color: transparent;
            border: rgb(123, 160, 152, 0.5) 1px solid;
            transform: scale(0.9);
            box-shadow: none;
            color: black;
        }
        .text_reg{
            color: black;
            font-size: 22px;
            text-align: center;
            margin-bottom: 30px;
        }
        .already_text a{
            margin-left: 20px;
        }
    </style>
</head>
<body>
    <div class="regcard">
        <div class="text_reg"> Тіркелу </div>
        <?php
            require_once "../db.php";
            session_start();

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $fullname = $_POST["fullname"];
                $email = $_POST["email"];
                $password = $_POST["password"];
                $reppassword = $_POST["reppassword"];
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $errors = array();
                $file_name = $_FILES['photo']['name'];
                $tempname = $_FILES['photo']['tmp_name'];
                $folder = '../profile_photo_users/'.$file_name;
                $color = '#ffffffff';
                if (empty($fullname) || empty($email) || empty($password) || empty($reppassword)) {
                    array_push($errors, "Барлық жол толуы қажет");
                }
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    array_push($errors, "Email пошта қате жазылған");
                }
                if (strlen($password) < 8) {
                    array_push($errors, "Құпия сөз кемінде 8 символдан аз болмауы тиіс");
                }
                if ($password !== $reppassword ) {
                    array_push($errors, "Құпия сөз сәйкес келмейді");
                }
                
                $sql = "SELECT * FROM users WHERE email = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $rowCount = mysqli_stmt_num_rows($stmt);
                if($rowCount > 0){
                    array_push($errors, "Осы Email пошта бұрын тіркелген!");
                }
                
                if (count($errors) > 0) {
                    foreach ($errors as $error) {
                        echo "<div class='alert alert-danger'>$error</div>";
                    }
                } else {
                    move_uploaded_file($tempname, $folder);
                    $sql = "INSERT INTO users (username, email, password, photo, color) VALUES (?, ?, ?, ?, ?)";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, "sssss", $fullname, $email, $passwordHash, $file_name, $color);
                    mysqli_stmt_execute($stmt);
                    $userId = mysqli_insert_id($conn); // Получаем ID только что созданного пользователя
                    $_SESSION['currentUser'] = $userId; // Сохраняем ID пользователя в сессии
                    echo "<div class='alert alert-success'>Жүйеге сәтті тіркелдіңіз!</div>";
                }
            }
        ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <div class="formgroup">
                <input type="text" class="form-control" name="fullname" placeholder="Лақап ат(Никнейм):">
            </div>
            <div class="formgroup">
                <input type="email" class="form-control" name="email" placeholder="Email:">
            </div>
            <div class="formgroup">
                <input type="password" class="form-control" name="password" placeholder="Құпия сөз:">
            </div>
            <div class="formgroup">
                <input type="password" class="form-control" name="reppassword" placeholder="Құпия сөзді қайталаңыз:">
            </div>
            <div class="formgroup">
                <p>Аватар/Сурет жүткеңіз: </p>
                <input type="file" name="photo" accept=".jpg, .png, .svg, .gif, .jpeg, .webp">
            </div>
            <div class="formgroup">
                <input type="submit" class="btn btn-primary" value="Регистрация" name="submit">
            </div>
        </form>
        <div"><p class="already_text fff">Жүйеге тіркелдіңіз бе?<a href="login.php" class="already_text">Жүйеге кіру</a></p></div>
    </div>
</body>
</html>
