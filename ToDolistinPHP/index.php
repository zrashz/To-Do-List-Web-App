<?php
// Database connection
$host = 'localhost';
$db = 'todo_list';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add task
if (isset($_POST['add'])) {
    $task = $_POST['task'];
    $sql = "INSERT INTO tasks (task) VALUES ('$task')";
    $conn->query($sql);
}

// Delete task
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM tasks WHERE id=$id";
    $conn->query($sql);
}

// Mark task as done
if (isset($_GET['done'])) {
    $id = $_GET['done'];
    $sql = "UPDATE tasks SET status='done' WHERE id=$id";
    $conn->query($sql);
}

// Fetch tasks
$sql = "SELECT * FROM tasks";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Simple To-Do List</title>
    <style>
        body { font-family: Arial, sans-serif; background:rgb(210, 161, 161); }
        .container { width: 50%; margin: 50px auto; background: rgb(174, 165, 165); padding: 20px; border-radius: 8px; }
        h2 { text-align: center; }
        form { display: flex; justify-content: space-between; }
        input[type='text'] { width: 80%; padding: 8px; }
        button { padding: 8px 15px; background: #28a745; color: white; border: none; border-radius: 4px; }
        table { width: 100%; margin-top: 20px; }
        th, td { padding: 10px; text-align: center; }
        .done { text-decoration: line-through; color: gray; }
        a { text-decoration: none; color: white; padding: 5px 10px; border-radius: 4px; }
        .delete { background: #dc3545; }
        .done-btn { background: #007bff; }
    </style>
</head>
<body>
    <div class="container">
        <h2>My To-Do List</h2>
        <form method="POST">
            <input type="text" name="task" placeholder="New task" required>
            <button type="submit" name="add">Add</button>
        </form>
        <table border="2">
            <tr>
                <th>Task</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td class="<?php echo $row['status'] == 'done' ? 'done' : ''; ?>"> <?php echo $row['task']; ?> </td>
                    <td>
                        <?php if ($row['status'] != 'done'): ?>
                            <a class="done-btn" href="?done=<?php echo $row['id']; ?>">Done</a>
                        <?php endif; ?>
                        <a class="delete" href="?delete=<?php echo $row['id']; ?>">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>