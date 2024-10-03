<?php
require_once "../db.php";
if (isset($_COOKIE['currentUser'])) {
    $currentUser = $_COOKIE['currentUser'];
    $res = mysqli_query($conn, "SELECT * FROM users WHERE id = $currentUser LIMIT 1");
    if ($row = mysqli_fetch_assoc($res)) {
        $profilePhoto = $row['photo'];
        $username = $row['username'];
        $rating = $row['rating'];
        $regDate = $row['reg-date'];
    } else {
        echo "Пользователь не найден";
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
    <title>ecotil</title>
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

    <section id="main_info">
        <div id="text_inf" class="left">
            <p class="name_inf">Ана тіліңде сауатты сөйлей біл!</p>
            <p class="txt_inf">Қазақ тілінде сауатты сөйлей аламын деп ойлайсыз ба?</p>
            <p class="txt_inf">Бұл сайт сізге күнделікті жіберілетін қателіктерді анықтап, түзетуге көмектеседі. Қазақ тілінің заңдылықтарымен таныса отырып, тіл тазалығын сақтауға мүмкіндік береді.</p>
            <a href="../src/course.php"><button id="go_course">Курсқа өту</button></a>
        </div>
        <div id="img_inf" class="right">
            <img src="../img/info_001.svg" alt="img_1">
        </div>
    </section>

    <section id="news">
        <div class="left news_img">
            <img src="../img/news_001.svg" alt="news_img">
        </div>
        <div class="right news_txt">
            <?php 
                $res = mysqli_query($conn, "SELECT * FROM news ORDER BY id DESC LIMIT 1");
                while ($row = mysqli_fetch_assoc($res)) {
                    $date = $row['date'];
                    $content = $row['content'];
                    $link = $row['link']; ?>
                    <p class="news_title">Жаңалықтар</p>
                    <p class="news_date"><?php echo $date ?></p>
                    <p class="news_content"><?php echo $content ?></p>
                    <a href="../src/newspage.php"><button class="btn">Өту <i class="fa-solid fa-arrow-up-right-from-square" id="linkbtn"></i></button></a>
                <?php }
            ?>
        </div>
    </section>

    <section id="top3">
        <p class="top_txt">Үздік 3 қолданушы</p>
        <div class="list_top3 left right">
            <?php
            $res = mysqli_query($conn, "SELECT * FROM users ORDER BY rating DESC LIMIT 3");
            $medals = ["../img/top1_001.png", "../img/top2_001.png", "../img/top3_001.png"];
            $index = 0;
            while ($row = mysqli_fetch_assoc($res)) { ?>
                <div class="card">
                    <div class="img-container">
                        <img src="../profile_photo_users/<?php echo $row['photo']; ?>" alt="<?php echo ($index + 1); ?>st" class="top3pfp">
                        <img src="<?php echo $medals[$index]; ?>" alt="medal<?php echo ($index + 1); ?>st" class="medal">
                    </div>
                    <p class="us">@<?php echo $row['username']; ?></p>
                    <span class="tooltiptext">Білім ұпайлары: <?php echo $row['rating']; ?></span>
                </div>
            <?php
                $index++;
            }
            ?>
        </div>
    </section>
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
