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
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $test_id = intval($_GET['test_id']);
    $score = intval($_GET['score']);
    if($score%2!=0){
        $score -= 1;
    }
    $score /= 2;
    $total_questions = 0;
    $res = mysqli_query($conn, "SELECT * FROM questions WHERE topic_id = $test_id");

    while ($row = mysqli_fetch_assoc($res)) {
        $question_id = $row['id'];
        $correct_answer = $row['cor_ans'];
        $arr = explode('/', $correct_answer); 
        echo "<script>console.log('Правильные ответы для вопроса $question_id: " . json_encode($arr) . "');</script>";
        if ($row['type'] == 'radio') {
            if (isset($_POST['answer_' . $question_id])) {
                $user_answer = intval($_POST['answer_' . $question_id]);

                if (in_array($user_answer, $arr)) {
                    $score++;
                }
            }
        } elseif ($row['type'] == 'checkbox') {
            if (isset($_POST['answer_' . $question_id])) {
                $user_answers = $_POST['answer_' . $question_id];
                if (!is_array($user_answers)) {
                    $user_answers = [$user_answers];
                }
                if (empty(array_diff($arr, $user_answers)) && empty(array_diff($user_answers, $arr))) {
                    $score++;
                }
            }
            
        }

        $total_questions++;
    }

    $percentage = ($total_questions > 0) ? ($score / $total_questions) * 100 : 0;
    $currentUser = intval($_COOKIE['currentUser']);
    $stmt = $conn->prepare("INSERT INTO completed_topics (user_id, topic_id, score, percentage) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiid", $currentUser, $test_id, $score, $percentage);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $usr = mysqli_query($conn, "SELECT rating FROM users WHERE id = $currentUser");
        $usr_row = mysqli_fetch_assoc($usr);
        $new_rating = $usr_row['rating'] + $score;
        $update_stmt = $conn->prepare("UPDATE users SET rating = ? WHERE id = ?");
        $update_stmt->bind_param("ii", $new_rating, $currentUser);
        $update_stmt->execute();

        echo "<div class='main'>";
        echo "<h2>Тест аяқталды!</h2>";
        echo "<p>Сіз $total_questions сұрақтың $score жауап бердіңіз!.</p>";
        echo "<p>Сіздің нәтижеңіз: $percentage%</p>"; 
        echo "<a href='course.php'><button class='btn'>Курс бетіне өту</button></a>";
        echo "</div>";
    } else {
        echo "<p>Ошибка при сохранении результата. Попробуйте еще раз.</p>";
    }

    $stmt->close();
}
?>
</body>
</html>
