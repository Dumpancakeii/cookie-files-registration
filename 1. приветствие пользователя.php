<?php
//приветствие пользователя
if (isset($_COOKIE['name'])) {
    echo "Привет, " . $_COOKIE['name'] . "!";
} else {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['name'])) {
        setcookie('name', $_POST['name'], time() + (86400 * 30)); // 30 дней
        echo "Привет, " . $_POST['name'] . "!";
    } else {
        echo '<form method="POST"><input name="name" placeholder="Введите ваше имя"><input type="submit"></form>';
    }
}

//количество посещений страницы
if (isset($_COOKIE['visits'])) {
    $visits = ++$_COOKIE['visits'];
} else {
    $visits = 1;
}
setcookie('visits', $visits, time() + (86400 * 30));
echo "Количество посещений: " . $visits;

//запоминание темы оформления
if (isset($_COOKIE['theme'])) {
    echo '<link rel="stylesheet" type="text/css" href="' . $_COOKIE['theme'] . '.css">';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['theme'])) {
    setcookie('theme', $_POST['theme'], time() + (86400 * 30));
    header("Location: " . $_SERVER['PHP_SELF']);
}

echo '<form method="POST">
        <select name="theme">
            <option value="light">Светлая</option>
            <option value="dark">Тёмная</option>
        </select>
        <input type="submit">
      </form>';

//последняя посещенная страница
if (isset($_COOKIE['last_page'])) {
    header("Location: " . $_COOKIE['last_page']);
    exit();
} else {
    setcookie('last_page', $_SERVER['REQUEST_URI'], time() + (86400 * 30));
}

//запоминание языка интерфейса
if (isset($_COOKIE['language'])) {
    $language = $_COOKIE['language'];
} else {
    $language = 'ru'; // По умолчанию русский
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['language'])) {
    setcookie('language', $_POST['language'], time() + (86400 * 30));
    header("Location: " . $_SERVER['PHP_SELF']);
}

echo '<form method="POST">
        <select name="language">
            <option value="ru">Русский</option>
            <option value="en">Английский</option>
        </select>
        <input type="submit">
      </form>';

//закрытие уведомления
if (isset($_COOKIE['notification_closed'])) {
    // Уведомление закрыто, ничего не показываем
} else {
    echo '<div id="notification">
            Уведомление! <button onclick="closeNotification()">Закрыть</button>
          </div>';
}

echo '<script>
        function closeNotification() {
            document.cookie = "notification_closed=1; path=/; max-age=3600"; // 1 час
            document.getElementById("notification").style.display = "none";
        }
      </script>';

//сохранение данных формы
$name = $email = '';

if (isset($_COOKIE['name'])) {
    $name = $_COOKIE['name'];
}
if (isset($_COOKIE['email'])) {
    $email = $_COOKIE['email'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    setcookie('name', $name, time() + (86400 * 30));
    setcookie('email', $email, time() + (86400 * 30));
    header("Location: " . $_SERVER['PHP_SELF']);
}

echo '<form method="POST">
        <input name="name" placeholder="Ваше имя" value="' . htmlspecialchars($name) . '">
        <input name="email" type="email" placeholder="Ваш email" value="' . htmlspecialchars($email) . '">
        <input type="submit">
      </form>';

//счетчик кликов по кнопке
$clicks = 0;

if (isset($_COOKIE['clicks'])) {
    $clicks = $_COOKIE['clicks'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $clicks++;
    setcookie('clicks', $clicks, time() + (86400 * 30));
}

echo '<form method="POST">
        <button type="submit">Нажми меня!</button>
      </form>';
echo "Количество кликов: " . $clicks;

//ограничение кликов 
$clicks = 0;
$limit = 10;

if (isset($_COOKIE['clicks'])) {
    $clicks = $_COOKIE['clicks'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $clicks < $limit) {
    $clicks++;
    setcookie('clicks', $clicks, time() + (86400 * 30));
}

echo '<form method="POST">
        <button type="submit" ' . ($clicks >= $limit ? 'disabled' : '') . '>Нажми меня!</button>
      </form>';
echo "Количество кликов: " . $clicks;
if ($clicks >= $limit) {
    echo " Достигнут лимит кликов!";
}

//изменение размера текста
$size = 'medium'; // По умолчанию средний размер текста

if (isset($_COOKIE['text_size'])) {
    $size = $_COOKIE['text_size'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $size = $_POST['size'];
    setcookie('text_size', $size, time() + (86400 * 30));
    header("Location: " . $_SERVER['PHP_SELF']);
}

echo '<form method="POST">
        <select name="size">
            <option value="small" ' . ($size == 'small' ? 'selected' : '') . '>Мелкий</option>
            <option value="medium" ' . ($size == 'medium' ? 'selected' : '') . '>Средний</option>
            <option value="large" ' . ($size == 'large' ? 'selected' : '') . '>Крупный</option>
        </select>
        <input type="submit">
      </form>';

echo '<div style="font-size:' . ($size == 'small' ? '12px' : ($size == 'large' ? '24px' : '16px')) . ';">
        Пример текста с размером: ' . $size . '
      </div>'; 

//выбор фона страницы
$background = 'white'; // По умолчанию белый фон

if (isset($_COOKIE['background'])) {
    $background = $_COOKIE['background'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $background = $_POST['background'];
    setcookie('background', $background, time() + (86400 * 30));
    header("Location: " . $_SERVER['PHP_SELF']);
}

echo '<form method="POST">
        <select name="background">
            <option value="white" ' . ($background == 'white' ? 'selected' : '') . '>Белый</option>
            <option value="blue" ' . ($background == 'blue' ? 'selected' : '') . '>Синий</option>
            <option value="green" ' . ($background == 'green' ? 'selected' : '') . '>Зеленый</option>
            <option value="url(image.jpg)" ' . ($background == 'url(image.jpg)' ? 'selected' : '') . '>Изображение</option>
        </select>
        <input type="submit">
      </form>';

echo '<style>body { background-color: ' . $background . '; }</style>';

//сохранение уровня звука
$volume = 50; // По умолчанию 50%

if (isset($_COOKIE['volume'])) {
    $volume = $_COOKIE['volume'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $volume = $_POST['volume'];
    setcookie('volume', $volume, time() + (86400 * 30));
    header("Location: " . $_SERVER['PHP_SELF']);
}

echo '<form method="POST">
        <input type="range" name="volume" min="0" max="100" value="' . $volume . '">
        <input type="submit">
      </form>';
echo "Уровень звука: " . $volume . "%";

//анкетирование с несколькими шагами
$step = isset($_COOKIE['step']) ? $_COOKIE['step'] : 1;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $step++;
    setcookie('step', $step, time() + (86400 * 30));
    header("Location: " . $_SERVER['PHP_SELF']);
}

if ($step > 3) {
    echo "Спасибо за участие!";
    setcookie('step', '', time() - 3600); // Удаляем cookie
    exit();
}

echo '<form method="POST">';
switch ($step) {
    case 1: echo 'Шаг 1: Ваше имя: <input name="name" required><br>'; break;
    case 2: echo 'Шаг 2: Ваш email: <input name="email" required><br>'; break;
    case 3: echo 'Шаг 3: Ваш возраст: <input name="age" type="number" required><br>'; break;
}
echo '<input type="submit" value="Далее">
      </form>';

//счетчик уникальных посетителей
if (!isset($_COOKIE['visited'])) {
    setcookie('visited', 'yes', time() + (86400 * 30));
    echo "Вы новый посетитель!";
} else {
    echo "Вы уже посещали этот сайт.";
}   

//викторина
$questions = [
    1 => "Какой язык программирования используется для веб-разработки?",
    2 => "Какой тег используется для создания гиперссылки?",
    3 => "Что такое PHP?"
];

if (!isset($_COOKIE['answered'])) {
    $answered = [];
} else {
    $answered = json_decode($_COOKIE['answered'], true);
}

foreach ($questions as $key => $question) {
    if (!in_array($key, $answered)) {
        echo "Вопрос " . $key . ": " . $question . "<br>";
        $answered[] = $key;
        setcookie('answered', json_encode($answered), time() + (86400 * 30));
        break;
    }
}

if (count($answered) === count($questions)) {
    echo "Вы ответили на все вопросы!";
}

//проверка возраста
if (isset($_COOKIE['age'])) {
    echo "Ваш возраст: " . $_COOKIE['age'];
} else {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['age'])) {
        setcookie('age', $_POST['age'], time() + (86400 * 30)); // 30 дней
        echo "Ваш возраст: " . $_POST['age'];
    } else {
        echo '<form method="POST">
                <input type="number" name="age" placeholder="Ваш возраст" required>
                <input type="submit" value="Отправить">
              </form>';
    }
}

//запоминание предпочтений фильтров
$filter = isset($_COOKIE['filter']) ? $_COOKIE['filter'] : 'all';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $filter = $_POST['filter'];
    setcookie('filter', $filter, time() + (86400 * 30));
    header("Location: " . $_SERVER['PHP_SELF']);
}

echo '<form method="POST">
        <select name="filter">
            <option value="all" ' . ($filter == 'all' ? 'selected' : '') . '>Все товары</option>
            <option value="electronics" ' . ($filter == 'electronics' ? 'selected' : '') . '>Электроника</option>
            <option value="clothing" ' . ($filter == 'clothing' ? 'selected' : '') . '>Одежда</option>
        </select>
        <input type="submit" value="Применить">
      </form>';
echo "Текущий фильтр: " . $filter;

//список задач
$tasks = isset($_COOKIE['tasks']) ? json_decode($_COOKIE['tasks'], true) : [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['task'])) {
    $tasks[] = $_POST['task'];
    setcookie('tasks', json_encode($tasks), time() + (86400 * 30));
    header("Location: " . $_SERVER['PHP_SELF']);
}

echo '<form method="POST">
        <input type="text" name="task" placeholder="Введите задачу" required>
        <input type="submit" value="Добавить">
      </form>';

echo '<ul>';
foreach ($tasks as $task) {
    echo '<li>' . htmlspecialchars($task) . '</li>';
}
echo '</ul>';

//корзина товаров
$cart = isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart'], true) : [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['product'])) {
    $cart[] = $_POST['product'];
    setcookie('cart', json_encode($cart), time() + (86400 * 30));
    header("Location: " . $_SERVER['PHP_SELF']);
}

echo '<form method="POST">
        <input type="text" name="product" placeholder="Название товара" required>
        <input type="submit" value="Добавить в корзину">
      </form>';

echo '<h2>Корзина:</h2>';
echo '<ul>';
foreach ($cart as $product) {
    echo '<li>' . htmlspecialchars($product) . '</li>';
}
echo '</ul>';

//изменение настроек видимости элементов
$visibility = isset($_COOKIE['visibility']) ? $_COOKIE['visibility'] : 'visible';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $visibility = $_POST['visibility'];
    setcookie('visibility', $visibility, time() + (86400 * 30));
    header("Location: " . $_SERVER['PHP_SELF']);
}

echo '<form method="POST">
        <select name="visibility">
            <option value="visible" ' . ($visibility == 'visible' ? 'selected' : '') . '>Показать</option>
            <option value="hidden" ' . ($visibility == 'hidden' ? 'selected' : '') . '>Скрыть</option>
        </select>
        <input type="submit" value="Применить">
      </form>';

echo '<div style="display: ' . ($visibility == 'visible' ? 'block' : 'none') . ';">
        Эта часть контента может быть скрыта или показана.
      </div>';

//запоминание позиции прокрутки
if (isset($_COOKIE['scroll_position'])) {
    $scrollPosition = $_COOKIE['scroll_position'];
} else {
    $scrollPosition = 0; // Начальная позиция
}

echo '<script>
        window.onload = function() {
            window.scrollTo(0, ' . $scrollPosition . ');
        }

        window.onbeforeunload = function() {
            document.cookie = "scroll_position=" + window.scrollY + "; path=/; max-age=3600"; // Сохраняем позицию при уходе
        }
      </script>';

//случайное приветствие
session_start();

if (!isset($_SESSION['start_time'])) {
    $_SESSION['start_time'] = time();
}

if (isset($_COOKIE['total_time'])) {
    $totalTime = $_COOKIE['total_time'] + (time() - $_SESSION['start_time']);
} else {
    $totalTime = time() - $_SESSION['start_time'];
}
setcookie('total_time', $totalTime, time() + (86400 * 30)); // Сохраняем общее время

echo "Время, проведенное на сайте: " . gmdate("H:i:s", $totalTime);

//таймер времени на сайте
$greetings = ["Привет!", "Добро пожаловать!", "Здравствуйте!", "Хорошего дня!"];

if (!isset($_COOKIE['greeted'])) {
    $randomGreeting = $greetings[array_rand($greetings)];
    setcookie('greeted', 'yes', time() + (86400 * 30)); // Установим cookie
    echo $randomGreeting;
} else {
    echo "Рады вас видеть снова!";
}

//ограничение по времени на сайте
session_start();

if (!isset($_SESSION['first_visit'])) {
    $_SESSION['first_visit'] = time();
}

$timeLimit = 3600; // 1 час

if (time() - $_SESSION['first_visit'] > $timeLimit) {
    echo "Вы превысили лимит времени на сайте.";
} else {
    echo "Время на сайте: " . gmdate("H:i:s", time() - $_SESSION['first_visit']);
}

//мини-игра кликер
$score = 0;

if (isset($_COOKIE['score'])) {
    $score = $_COOKIE['score'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $score++;
    setcookie('score', $score, time() + (86400 * 30));
}

echo '<form method="POST">
        <button type="submit">Кликни меня!</button>
      </form>';
echo "Ваш счёт: " . $score;

//запоминание активной вкладки
$activeTab = isset($_COOKIE['active_tab']) ? $_COOKIE['active_tab'] : 'tab1';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $activeTab = $_POST['tab'];
    setcookie('active_tab', $activeTab, time() + (86400 * 30));
    header("Location: " . $_SERVER['PHP_SELF']);
}

echo '<form method="POST">
        <button name="tab" value="tab1" ' . ($activeTab == 'tab1' ? 'style="font-weight:bold;"' : '') . '>Вкладка 1</button>
        <button name="tab" value="tab2" ' . ($activeTab == 'tab2' ? 'style="font-weight:bold;"' : '') . '>Вкладка 2</button>
      </form>';

if ($activeTab == 'tab1') {
    echo '<div>Содержимое вкладки 1</div>';
} else {
    echo '<div>Содержимое вкладки 2</div>';
}

//тестовый режим
$testMode = isset($_COOKIE['test_mode']) ? $_COOKIE['test_mode'] : 'off';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $testMode = $_POST['mode'];
    setcookie('test_mode', $testMode, time() + (86400 * 30));
    header("Location: " . $_SERVER['PHP_SELF']);
}

echo '<form method="POST">
        <select name="mode">
            <option value="off" ' . ($testMode == 'off' ? 'selected' : '') . '>Отключить тестовый режим</option>
            <option value="on" ' . ($testMode == 'on' ? 'selected' : '') . '>Включить тестовый режим</option>
        </select>
        <input type="submit" value="Применить">
      </form>';

if ($testMode == 'on') {
    echo '<div>Сайт в тестовом режиме!</div>';
}

//ограничение по дате
$dateCheck = '2023-10-01'; // Укажите дату для проверки

if (!isset($_COOKIE['visited_' . $dateCheck])) {
    setcookie('visited_' . $dateCheck, 'yes', strtotime($dateCheck) + (86400 * 30)); // Установим cookie до конца дня
    echo "Вы посетили сайт впервые в этот день!";
} else {
    echo "Вы уже посещали сайт " . $dateCheck;
}

//рекламный баннер
if (!isset($_COOKIE['banner_closed'])) {
    echo '<div id="banner">
            Рекламный баннер <button onclick="closeBanner()">Закрыть</button>
          </div>';
}

echo '<script>
        function closeBanner() {
            document.cookie = "banner_closed=1; path=/; max-age=3600"; // 1 час
            document.getElementById("banner").style.display = "none";
        }
      </script>';

//промокод
$promoUsed = isset($_COOKIE['promo_used']) ? $_COOKIE['promo_used'] : 'no';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['promo_code'] == 'DISCOUNT2023' && $promoUsed == 'no') {
    setcookie('promo_used', 'yes', time() + (86400 * 30)); // Установить факт использования
    echo "Промокод активирован!";
} elseif ($promoUsed == 'yes') {
    echo "Вы уже использовали промокод.";
} else {
    echo '<form method="POST">
            <input type="text" name="promo_code" placeholder="Введите промокод">
            <input type="submit" value="Активировать">
          </form>';
}
?>