<?php
$conn=new mysqli('localhost','root','mysql','crud');
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
    <?php
    $tasks=[];
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $task_name=$_POST["task_name"];
        $task_date=$_POST["task_date"];
        if(!empty($task_name) && !empty($task_date)){
            $stmt=$conn->prepare("INSERT INTO task(t_name,date) VALUES(? ,?)") ;
            $stmt->bind_param("ss",$task_name,$task_date);
            $stmt->execute();
            $stmt->close();
        }
    }

    $sql="SELECT*FROM task";
    $result=$conn->query($sql);


    ?>
    
    <form class="crud_container" action="" method="POST">
        <div class="form-data">
            <label for="task-name">Fill Task Name:</label>
            <input type="text" name="task_name" required>
        </div>

        <div class="form-data">
            <label for="date">Select Task Date:</label>
            <input type="date" name="task_date" required>
        </div>

        <div>
            <button type="submit">Add</button>
        </div>
    </form>

    <div class="crud_container">
        <h2>My Tasks</h2>
        <?php
        if($result->num_rows >0):
            while($row= $result->fetch_assoc()):
        ?>
     <div class="print-data">
                    <h3>Task Name: <?php echo htmlspecialchars($row['t_name']);  ?><h3>
                    <button>Edit</button>
                </div>
                <div class="print-data">
                    <p>Date: <?php echo htmlspecialchars($row['date']);?></p>
                    <button>Edit</button>
                </div>
                <?php
                endwhile;
                endif;
                ?>
    </div>
</body>
</html>
