<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "school_management";

// Создаем подключение
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверяем подключение
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_student'])) {
    $name = $_POST['name'];
    $group_id = $_POST['group_id'];

    $sql = "INSERT INTO students (name, group_id) VALUES ('$name', $group_id)";
    
    if ($conn->query($sql) === TRUE) {
        echo "Новый студент успешно добавлен!";
    } else {
        echo "Ошибка: " . $sql . "<br>" . $conn->error;
    }
}
?>

<h3>Добавить нового студента</h3>
<form method="POST">
    Имя студента: <input type="text" name="name" required><br>
    Группа:
    <select name="group_id">
        <?php
        $groups = $conn->query("SELECT * FROM groups");
        while($row = $groups->fetch_assoc()) {
            echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
        }
        ?>
    </select>
    <input type="submit" name="add_student" value="Добавить студента">
    <h3>Список студентов</h3>
    <?php
    $sql = "SELECT students.id, students.name, groups.name AS group_name FROM students LEFT JOIN groups ON students.group_id = groups.id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Группа</th>
            </tr>";
    
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["id"]. "</td>
                <td>" . $row["name"]. "</td>
                <td>" . ($row["group_name"] ? $row["group_name"] : "Не привязан") . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "Нет студентов.";
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_group'])) {
    $group_name = $_POST['group_name'];

    $sql = "INSERT INTO groups (name) VALUES ('$group_name')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Новая группа успешно добавлена!";
    } else {
        echo "Ошибка: " . $sql . "<br>" . $conn->error;
    }
}
?>

<h3>Добавить новую группу</h3>
<form method="POST">
    Название группы: <input type="text" name="group_name" required><br>
    <input type="submit" name="add_group" value="Добавить группу">
</form>
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['assign_group'])) {
    $student_id = $_POST['student_id'];
    $group_id = $_POST['group_id'];

    $sql = "UPDATE students SET group_id = $group_id WHERE id = $student_id";
    
    if ($conn->query($sql) === TRUE) {
        echo "Студент успешно привязан к группе!";
    } else {
        echo "Ошибка: " . $sql . "<br>" . $conn->error;
    }
}

<h3>Привязать студента к группе</h3>
<form method="POST">
    Выберите студента:
    <select name="student_id">
        <?php
        $students = $conn->query("SELECT * FROM students");
        while($row = $students->fetch_assoc()) {
            echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
        }
        ?>
    </select>
    
    Выберите группу:
    <select name="group_id">
        <?php
        $groups = $conn->query("SELECT * FROM groups");
        while($row = $groups->fetch_assoc()) {
            echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
        }
        ?>
    </select>
    
    <input type="submit" name="assign_group" value="Привязать студента к группе">
</form>


$sql = "SELECT students.name AS student_name, groups.name AS group_name 
        FROM students 
        LEFT JOIN groups ON students.group_id = groups.id";

$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "Студент: " . $row["student_name"] . " - Группа: " . $row["group_name"] . "<br>";
    }
} else {
    echo "Нет студентов.";
}

$mysqli->close();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $course_id = $_POST['course_id'];

    $stmt = $mysqli->prepare("INSERT INTO student_courses (student_id, course_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $student_id, $course_id);

    if ($stmt->execute()) {
        echo "Студент успешно зарегистрирован на курс.";
    } else {
        echo "Ошибка: " . $stmt->error;
    }

    $stmt->close();
}

<form method="post">
    ID Студента: <input type="text" name="student_id" required><br>
    ID Курса: <input type="text" name="course_id" required><br>
    <input type="submit" value="Зарегистрировать">
</form>


$sql = "SELECT courses.name AS course_name, COUNT(student_courses.student_id) AS student_count 
        FROM courses 
        LEFT JOIN student_courses ON courses.id = student_courses.course_id 
        GROUP BY courses.name";

$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "Курс: " . $row["course_name"] . " - Количество студентов: " . $row["student_count"] . "<br>";
    }
} else {
    echo "Нет курсов.";
}

$mysqli->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];

    $stmt = $mysqli->prepare("DELETE FROM students WHERE id = ?");
    $stmt->bind_param("i", $student_id);

    if ($stmt->execute()) {
        echo "Студент успешно удален.";
    } else {
        echo "Ошибка: " . $stmt->error;
    }

    $stmt->close();
}

<form method="post">
    ID Студента: <input type="text" name="student_id" required><br>
    <input type="submit" value="Удалить студента">
</form>

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $new_name = $_POST['new_name'];

    $stmt = $mysqli->prepare("UPDATE students SET name = ? WHERE id = ?");
    $stmt->bind_param("si", $new_name, $student_id);

    if ($stmt->execute()) {
        echo "Имя студента успешно обновлено.";
    } else {
        echo "Ошибка: " . $stmt->error;
    }

    $stmt->close();
}

<form method="post">
ID Студента: <input type="text" name="student_id" required><br>
    Новое имя: <input type="text" name="new_name" required><br>
    <input type="submit" value="Обновить имя">
</form>

$sql = "SELECT teachers.name AS teacher_name, courses.name AS course_name 
        FROM teachers 
        LEFT JOIN courses ON teachers.id = courses.teacher_id";

$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "Преподаватель: " . $row["teacher_name"] . " - Курс: " . ($row["course_name"] ? $row["course_name"] : 'Нет курса') . "<br>";
    }
} else {
    echo "Нет преподавателей.";
}

$mysqli->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_name = $_POST['student_name'];

    $stmt = $mysqli->prepare("SELECT students.name AS student_name, groups.name AS group_name 
                               FROM students 
                               LEFT JOIN groups ON students.group_id = groups.id 
                               WHERE students.name LIKE ?");
    $like_name = "%" . $student_name . "%";
    $stmt->bind_param("s", $like_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Студент: " . $row["student_name"] . " - Группа: " . ($row["group_name"] ? $row["group_name"] : 'Нет группы') . "<br>";
        }
    } else {
        echo "Студенты не найдены.";
    }

    $stmt->close();
}

<form method="post">
    Имя студента: <input type="text" name="student_name" required><br>
    <input type="submit" value="Поиск">
</form>

$sql = "SELECT students.name AS student_name 
        FROM students 
        WHERE group_id IS NULL";

$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "Студент без группы: " . $row["student_name"] . "<br>";
    }
} else {
    echo "Нет студентов без группы.";
}

$mysqli->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_name = $_POST['course_name'];

    $stmt = $mysqli->prepare("INSERT INTO courses (name) VALUES (?)");
    $stmt->bind_param("s", $course_name);

    if ($stmt->execute()) {
        echo "Курс успешно добавлен.";
    } else {
        echo "Ошибка: " . $stmt->error;
    }

    $stmt->close();
}

<form method="post">
    Название курса: <input type="text" name="course_name" required><br>
    <input type="submit" value="Добавить курс">
</form>

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $teacher_name = $_POST['teacher_name'];

    $stmt = $mysqli->prepare("INSERT INTO teachers (name) VALUES (?)");
    $stmt->bind_param("s", $teacher_name);

    if ($stmt->execute()) {
        echo "Преподаватель успешно добавлен.";
    } else {
        echo "Ошибка: " . $stmt->error;
    }

    $stmt->close();
}

<form method="post">
    Имя преподавателя: <input type="text" name="teacher_name" required><br>
    <input type="submit" value="Добавить преподавателя">
</form>

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_name = $_POST['course_name'];

    $stmt = $mysqli->prepare("SELECT students.name AS student_name 
                               FROM students 
                               JOIN student_courses ON students.id = student_courses.student_id 
                               JOIN courses ON student_courses.course_id = courses.id 
                               WHERE courses.name LIKE ?");
    $like_name = "%" . $course_name . "%";
    $stmt->bind_param("s", $like_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Студент: " . $row["student_name"] . "<br>";
        }
    } else {
        echo "Нет студентов, зарегистрированных на этот курс.";
    }

    $stmt->close();
}

<form method="post">
    Название курса: <input type="text" name="course_name" required><br>
    <input type="submit" value="Поиск">
</form>

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_id = $_POST['course_id'];

    $stmt = $mysqli->prepare("DELETE FROM courses WHERE id = ?");
    $stmt->bind_param("i", $course_id);

    if ($stmt->execute()) {
        echo "Курс успешно удален.";
    } else {
        echo "Ошибка: " . $stmt->error;
    }

    $stmt->close();
}

<form method="post">
    ID курса для удаления: <input type="number" name="course_id" required><br>
    <input type="submit" value="Удалить курс">
</form>

// Получаем группы для выбора
$groups_result = $mysqli->query("SELECT id, name FROM groups");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $group_id = $_POST['group_id'];

    $stmt = $mysqli->prepare("SELECT students.name AS student_name 
                               FROM students 
                               WHERE group_id = ?");
    $stmt->bind_param("i", $group_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Студент: " . $row["student_name"] . "<br>";
        }
    } else {
        echo "Нет студентов в этой группе.";
    }

    $stmt->close();
}

<form method="post">
    Выберите группу:
    <select name="group_id" required>
        <?php while ($row = $groups_result->fetch_assoc()): ?>
            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
        <?php endwhile; ?>
    </select><br>
    <input type="submit" value="Показать студентов">
</form>

$sql = "SELECT students.name AS student_name, COUNT(student_courses.course_id) AS course_count 
        FROM students 
        JOIN student_courses ON students.id = student_courses.student_id 
        GROUP BY students.id 
        HAVING course_count > 1";

$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "Студент: " . $row["student_name"] . " - Количество курсов: " . $row["course_count"] . "<br>";
    }
} else {
    echo "Нет студентов, зарегистрированных на несколько курсов.";
}

$mysqli->close();

$sql = "SELECT teachers.name AS teacher_name, COUNT(student_courses.student_id) AS total_students 
        FROM teachers 
        LEFT JOIN courses ON teachers.id = courses.teacher_id 
        LEFT JOIN student_courses ON courses.id = student_courses.course_id 
        GROUP BY teachers.id";

$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "Преподаватель: " . $row["teacher_name"] . " - Количество студентов: " . ($row["total_students"] ? $row["total_students"] : 0) . "<br>";
    }
} else {
    echo "Нет преподавателей.";
}

$mysqli->close();
?>