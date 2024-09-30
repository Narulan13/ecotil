<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" integrity="sha512-PgQMlq+nqFLV4ylk1gwUOgm6CtIIXkKwaIHp/PAIWHzig/lKZSEGKEysh0TCVbHJXCLN7WetD8TFecIky75ZfQ==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <title>TazaTil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <div id="navbar" class="shadow">
        <div id="name" onclick="home()"></div>
        <div id="navicon">
            <a href="course.html" class="nav_q">курс</a>
            <a href="leaderboard.html" class="nav_q">рейтинг</a>
        </div>
        <button class="signin" id='sin'>Кіру</button>
    </div>    
    <div id="mainpage">
        <div id="info_site">
            <div id="text_inf">
                <p class="name_inf">Ана тіліңде сауатты сөйлей біл!</p>
                <p class="txt_inf">Қазақ тілінде сауатты сөйлей аламын деп ойлайсыз ба?</p>
                <p class="txt_inf">Бұл сайт сізге күнделікті жіберілетін қателіктерді анықтап, түзетуге көмектеседі. Қазақ тілінің заңдылықтарымен таныса отырып, тіл тазалығын сақтауға мүмкіндік береді.</p>
                <button id="go_course" href="course.html">Курсқа өту</button>
            </div>
            <div id="img_inf"></div>
        </div>
        <div id="news">
            <div id="news_l"></div>
            <div id="news_r">
                <h3 id="_news">Жаңалықтар</h3>
                <p id="text_news">Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe maiores cupiditate odio iste culpa, harum numquam a maxime aut temporibus corporis eum praesentium voluptate, necessitatibus vitae architecto! Vero, perferendis facere.</p>
            </div>
        </div>
        <div id="leaderboard">
            <div id="news_r">
                <h3>ТОП 3 ҚОЛДАНУШЫЛАР</h3>
                <div id="people_top_3">
                    <div class="top3">
                        <img src="урахара.png" alt="top1" class="pfp_top">
                        <img src="top1_001.png" alt="tp1" class="place_top">
                        <p>@username</p>
                        <p>rating</p>
                    </div>
                    <div class="top3">
                        <img src="урахара.png" alt="top1" class="pfp_top">
                        <img src="top2_001.png" alt="tp1" class="place_top">
                        <p>@username</p>
                        <p>rating</p>
                    </div>
                    <div class="top3">
                        <img src="урахара.png" alt="top1" class="pfp_top">
                        <img src="top3_001.png" alt="tp1" class="place_top">
                        <p>@username</p>
                        <p>rating</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>