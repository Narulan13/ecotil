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

    <div class="testSEC">
    <?php 
        $test_id = intval($_GET['test_id']);
        $res = mysqli_query($conn, "SELECT * FROM questions WHERE topic_id = $test_id");
        $has_questions = false;
    ?>
        <form action="submit_test.php?test_id=<?php echo $test_id?>" method="POST">
            <?php 
            while($row = mysqli_fetch_assoc($res)){
                $has_questions = true;
            ?>
            <div>
                <p><?php echo htmlspecialchars($row['question']); ?></p>
                <?php
                    $i = 0;
                    $str = $row['options'];
                    $arr = explode('/', $str);
                    while($i < $row['count'] && isset($arr[$i])){
                ?>
                    <label>
                        <input type="<?php echo $row['type']?>" name="answer_<?php echo $row['id']; ?>" value="<?php echo $i+1?>">
                        <?php echo htmlspecialchars($arr[$i]); ?>
                    </label>
                    <br>
                <?php 
                    $i++;
                    } 
                ?>
            </div>
            <hr>
            <?php } 
            if($has_questions){ 
            ?>
            <div>
                <button type="submit">Тестті аяқтау</button>
            </div>
            <?php } else {
                echo "<p>Сұрақтар жоқ.</p>";
            }
            ?>
        </form>
    </div>


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
