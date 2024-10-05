<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reg_no = $_POST['reg_no'];

    // Get student ID and name based on reg_no
    $sql = "SELECT id, name FROM user_management.users WHERE reg_no=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $reg_no);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($student_id, $student_name);
    $stmt->fetch();
    $stmt->close();

    ?>
    
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>View Attendance</title>
        <!-- Link to the external CSS file -->
        <link rel="stylesheet" href="stu_view.css">
    </head>
    <body>
    
    <?php

    if ($student_id) {
        // Get attendance records for the student
        $sql = "SELECT date, status FROM attendance WHERE student_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $result = $stmt->get_result();

        echo "<div class='attendance-container'>";
        echo "<h2>Attendance Records for $student_name (Reg No: $reg_no)</h2>";
        if ($result->num_rows > 0) {
            echo "<table class='attendance-table'>
                    <tr>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['date']) . "</td>
                        <td>" . htmlspecialchars($row['status']) . "</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No attendance records found.</p>";
        }
        echo "</div>";
        $stmt->close();
    } else {
        echo "<p>Student with Register Number $reg_no not found.</p>";
    }

    ?>

    </body>
    </html>

    <?php
}

$conn->close();
?>
