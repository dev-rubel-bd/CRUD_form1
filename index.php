<?php
$conn = new mysqli('localhost', 'root', 'mysql', 'crud');


// create
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_task'])) {
    $task_name = $_POST['task_name'];
    $date = $_POST['date'];
    $sql = "INSERT INTO task (t_name, date) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $task_name, $date);
    $stmt->execute();
    $stmt->close();
    header("Location: index.php");
    exit();
}

// Delete 
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM task WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: index.php");
    exit();
}


$sql = "SELECT * FROM task";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>CRUD</title>
</head>
<body>
    <form class="crud_container" action="" method="POST">
        <input type="hidden" name="task_id" value="">
        <div class="form-data">
            <label for="task-name">Fill Task Name:</label>
            <input type="text" name="task_name" value=" " required>
        </div>

        <div class="form-data">
            <label for="date">Select Task Date:</label>
            <input type="date" name="date" value=" " required>
        </div>

        <div>
            <button class="add-btn" type="submit" name="add_task">Add</button>
        </div>
    </form>

    <div class="crud_container">
        <h2>My Tasks</h2>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <hr>
                <div class="print-data">
                    <h3>Task Name: <?php echo htmlspecialchars($row['t_name']); ?></h3>
                    <p>Date: <?php echo htmlspecialchars($row['date']); ?></p>
                </div>
                <div>
                    <button>Edit</button></a>
                    <a href="index.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');"><button>Delete</button></a>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</body>
</html>
