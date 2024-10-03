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
    $res = mysqli_query($conn, "SELECT * FROM questions WHERE topic_id = $test_id");
    if (!$res) {
        echo "Error in query: " . mysqli_error($conn);
        exit();
    }
    $has_questions = false;
    ?>
    <form action="submit_test.php?test_id=<?php echo $test_id?>" method="POST" id="testForm"> 
        <?php 
        while ($row = mysqli_fetch_assoc($res)) {
            $has_questions = true;
        ?>
        <div>
            <p><?php echo htmlspecialchars($row['question']); ?></p> <br>
            <div>
                <i><p><?php echo htmlspecialchars($row['question-content']); ?></p></i>
                <b><p><?php echo htmlspecialchars($row['author']) ; ?></p></b>
            </div>
            
            <?php
            $q = 0;
            $i = 0;
            $str = $row['options'];
            $arr = explode('/', $str);

            if ($row['type'] == 'dragdrop') {
                ?>
                <div class="container">
                <div class="zones">
                    <?php
                    
                    $corr = explode('/', $row['cor_ans']);
                    foreach ($corr as $answer) {
                        ?>
                        <div class="questions">
                            <div class="dropzone" data-correct="<?php echo htmlspecialchars($answer)?>"></div>
                        </div>
                        
                        <?php
                    } ?>
                    </div>
                    <div class="ans">
                    <?php
                    
                    while ($i < $row['count']) {
                        ?>
                        <div class="blocks">
                            <div class="draggable" draggable="true" data-id="<?php echo $i + 1;?>"><?php echo htmlspecialchars($arr[$i]) ?></div>
                        </div>
                        <?php $i++;
                    } 
                    ?>
                </div>
                </div>
            <?php 
            } else if($row['type'] == 'checkbox' || $row['type'] == 'radio') {
                foreach ($arr as $index => $option) { ?>
                    <label>
                        <input type="<?php echo htmlspecialchars($row['type']); ?>"
                               name="answer_<?php echo $row['id']; ?><?php echo ($row['type'] == 'checkbox') ? '[]' : ''; ?>"
                               value="<?php echo $index + 1; ?>">
                        <?php echo htmlspecialchars($option); ?>
                    </label>
                    <br>
                <?php 
                }
            }
            else if($row['type'] == 'audio') {
                ?>
                <div class="container_audio">
                    <audio controls >
                        <source src="../audio/<?php echo $row['cor_ans']; ?>.aac" type="audio/aac">
                    </audio>
                    <input type="text" name="answer_<?php echo $row['id']; ?>" class="input_ans">
                </div>
                <?php
            }
            ?>
        </div>
        <?php 
        }
        ?>
        <div>
            <?php if ($has_questions) { ?>
                <button type="submit" id="check" class="btn">Тестті аяқтау</button>
            <?php } else {
                echo "<p>Сұрақтар жоқ.</p>";
            } ?>
        </div>
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
                <li><a href="https://www.instagram.com/bnarulan">Instagram</a></li>
                <li><a href="https://t.me/bnarulan">Telegram</a></li>
            </ul>
        </div>
    </div>
</footer>
<script src="../js/script.js"></script>
</body>
</html>
