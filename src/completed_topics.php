<?php
require_once "../db.php";
    $currentUser = $_GET['user_id'];
    $res = mysqli_query($conn, "SELECT * FROM users WHERE id = $currentUser LIMIT 1");
    if ($row = mysqli_fetch_assoc($res)) {
        $profilePhoto = $row['photo'];
        $username = $row['username'];
        $rating = $row['rating'];
        $regDate = $row['reg-date'];
    } else {
        echo "Пользователь не найден";
    }
?>
<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль</title>
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
    <section class="pr-block compl">
        <?php
            $completed_topics_res = mysqli_query($conn, "SELECT * FROM completed_topics WHERE user_id = $currentUser");
            
            if (mysqli_num_rows($completed_topics_res) > 0) {
                while ($completed_topic = mysqli_fetch_assoc($completed_topics_res)) {
                    $topic_id = $completed_topic['topic_id'];
                    $topic_res = mysqli_query($conn, "SELECT title FROM topics WHERE id = $topic_id");
                    
                    if ($topic_row = mysqli_fetch_assoc($topic_res)) {
                        ?>
                        <div class="topic_card">
                            <h2><?php echo htmlspecialchars($topic_row['title']); ?></h2>
                            <p>Нәтиже: <?php echo $completed_topic['percentage']; ?>%</p>
                        </div>
                        <?php
                    }
                }
            } else {
                echo "<p>Қолданушы әлі бірде-бір тақырыпты аяқтаған жоқ.</p>";
            }
        ?>
    </section>

    <footer>
        <div class="footer-container">
            <div class="footer--logo">
                <img src="../img/logo_001.svg" alt="logo">
            </div>
            <div class="footer-links">
                <h3>Байланыстар</h3>
                <ul>
                    <li><a href="#">Instagram</a></li>
                    <li><a href="#">LinkedIn</a></li>
                    <li><a href="#">GitHub</a></li>
                    <li><a href="#">Telegram</a></li>
                </ul>
            </div>
        </div>
    </footer>

    <script src="../js/script.js"></script>
</body>
</html>