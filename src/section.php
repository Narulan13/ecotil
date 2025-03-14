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
    <div class="topicsSEC">
        <section class="topicsList">
                <?php 
                    $section_id = intval($_GET['section_id']);
                    $topics_res = mysqli_query($conn, "SELECT * FROM topics WHERE section_id = $section_id");
                    $ind = 0;
                    if(mysqli_num_rows($topics_res) == 0){
                        ?>
                        <div>
                            <p>Жақын арада...</p>
                        </div><?php
                    } else {
                    while($row = mysqli_fetch_assoc($topics_res)){
                ?>
                <a href="topics.php?topic_id=<?php echo $row['id']?>">
                    <div class="topics">
                        <p style="font-family: 'Inter', sans-serif;">
                            <?php
                                if($row['section_id'] == $section_id){
                                    echo $row['title'];
                                    $ind += 1;
                                }
                            ?>
                        </p>
                    </div>
                </a>

                <?php 
                    }
                    } 
                ?>
        </section>
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
