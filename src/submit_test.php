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
    <title>Тест аяқталды!</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .btn {
            background-color: #45624e;
            border-color: transparent;
            width: 120px;
            height: 50px;
            margin-top: 30px;
            border-radius: 20px;
            color: #ffff;
            transition: 300ms;
            font-family: "Comfortaa", "sans-serif";
            cursor: pointer;
        }
        .main {
            width: 100%;
            text-align: center;
        }
    </style>
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
    
    <div class="right mobile-menu" id="bar_sec">
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
<div class="main test_">
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $test_id = intval($_GET['test_id']);
    $score = intval($_GET['score']);
    $total_questions = 0;

    // Получаем все вопросы, связанные с текущим тестом
    $res = mysqli_query($conn, "SELECT * FROM questions WHERE topic_id = $test_id");

    // Подсчитываем общее количество вопросов
    $total_questions = mysqli_num_rows($res);

    echo "<h2 style='margin: 30px 0;'>Тест аяқталды!</h2>";
    
    // Вычисляем процент правильных ответов
    $percentage = ($total_questions > 0) ? ($score / $total_questions) * 100 : 0;
    $percentage = round($percentage, 2);
    $currentUser = intval($_COOKIE['currentUser']);

    // Вставляем результаты в базу данных
    $stmt = $conn->prepare("INSERT INTO completed_topics (user_id, topic_id, score, percentage) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiid", $currentUser, $test_id, $score, $percentage);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Обновляем рейтинг пользователя
        $usr = mysqli_query($conn, "SELECT rating FROM users WHERE id = $currentUser");
        $usr_row = mysqli_fetch_assoc($usr);
        $new_rating = $usr_row['rating'] + $score;

        $update_stmt = $conn->prepare("UPDATE users SET rating = ? WHERE id = ?");
        $update_stmt->bind_param("ii", $new_rating, $currentUser);
        $update_stmt->execute();

        // Выводим сообщение о результатах теста
        echo "<div class='main'>";
        echo "<p>Сіз $total_questions сұрақтың $score дұрыс жауап бердіңіз!</p>";
        echo "<p>Сіздің нәтижеңіз: $percentage%</p>"; 
        echo "<a href='course.php'><button class='btn' style='margin-bottom: 30px;'>Курс бетіне өту</button></a>";
        echo "</div>";
    } else {
        echo "<p>Ошибка при сохранении результата. Попробуйте еще раз.</p>";
    }

    echo '<b style="font-size: 20px">Дұрыс жауаптар: </b><br><br>';

    // Выводим правильные ответы на каждый вопрос
    while ($row = mysqli_fetch_assoc($res)) {
        $question_id = $row['id'];
        $question_text = $row['question']; 
        $correct_answer = $row['cor_ans'];
        $arr = explode('/', $correct_answer);
        $options = $row['options'];
        $arr2 = explode('/', $options);
        $arr3 = [];
        $r = 0;

        if($row['type'] == 'audio') {
            $arr3[0] = $arr[0];
        } else {
            while ($r < count($arr)) {
                $arr3[$r] = ($arr2[$arr[$r]-1]);
                $r++;
            }
        }

        // Отображаем вопрос и правильные ответы
        echo "<div class='question_block' style='display: flex; flex-direction: column; gap: 15px'>";
        echo "<p><strong>Сұрақ № $question_id:</strong> $question_text</p>";
        echo "<p style='font-family: Inter, sans-serif; margin-bottom: 20px;'>Дұрыс жауап: " . implode(', ', $arr3) . "</p>";
        echo "</div>";
    }

    $stmt->close();
}
?>
</div>

<!-- Стили для правильных и неправильных ответов -->
<style>
    .correct {
        color: green;
        font-weight: bold;
    }
    .incorrect {
        color: red;
        font-weight: bold;
    }
    .question_block {
        margin-bottom: 20px;
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
    }
</style>

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
</body>
</html>
