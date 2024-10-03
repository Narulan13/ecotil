<?php
require_once "../db.php";

if (isset($_COOKIE['currentUser'])) {
    $currentUser = $_COOKIE['currentUser'];
    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE id = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt, "i", $currentUser);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $profilePhoto = $row['photo'];
        $username = $row['username'];
        $rating = $row['rating'];
        $regDate = $row['reg-date'];
    } else {
        echo "Пользователь не найден";
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Курс</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<nav id="navbar" class="navbar-custom">
    <div class="logo left">
        <a href="homepage.php"><img src="../img/logo_001.svg" alt="logo_ecotil"></a>
    </div>
    <div class="nav_text">
        <a href="course.php" class="nav_text_">Курс</a>
        <a href="rating.php" class="nav_text_">Рейтинг</a>
        <a href="newspage.php" class="nav_text_">Жаңалықтар</a>
    </div>
    <div class="right profile_photo sigma">
        <img src="../profile_photo_users/<?php echo $profilePhoto; ?>" class='profile_photo' onclick="window.location.href = '../src/profilepage.php'">
    </div>
    
    <div class="right mobile-menu"id="bar_sec">
        <i id="bar" class="fa-solid fa-bars" onclick="toggleMenu()"></i>
    </div>
    <div id="mobileNav" class="mobile-nav">
        <a href="course.php" class="nav_text_">Курс</a>
        <a href="rating.php" class="nav_text_">Рейтинг</a>
        <a href="newspage.php" class="nav_text_">Жаңалықтар</a>
        <div class="right profile_photo">
        <img src="../profile_photo_users/<?php echo $profilePhoto; ?>" class='profile_photo' onclick="window.location.href = '../src/profilepage.php'">
    </div>
    </div>
</nav>

<div class="testSEC">
    <?php 
        $test_id = intval($_GET['test_id']);
        $res = mysqli_query($conn, "SELECT * FROM interactive_tasks WHERE topic_id = $test_id");
        if (!$res) {
            echo "Error in query: " . mysqli_error($conn);
            exit();
        } else  {
            while($row = mysqli_fetch_assoc($res)) {
                $question = $row['question'];
                $link = $row['link'];
                ?> 
                    <p><?php echo $question ?></p>
                    <br>
                    <iframe loading="lazy" src="<?php echo $link ?>" style="border:0px;width:100%;height:500px" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe>
                <?php
            }
        }
    ?>
</div>
<footer>
    <div class="footer-container">
        <div class="footer--logo">
            <img src="../img/logo_001.svg" alt="logo">
        </div>
        <div class="footer-links">
            <h3>Байланыстар</h3>
            <ul>
                <li><a href="https://www.instagram.com/bnarulan">Instagram</a></li>
                <li><a href="https://t.me/bnarulan">Telegram</a></li>
            </ul>
        </div>
    </div>
</footer>
<script src="../js/script.js"></script>
</body>
</html>
