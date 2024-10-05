<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Attendance</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        table {
            width: 60%;
            margin: auto;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #a52a2a;
            color: white;
        }
        input[type="checkbox"] {
            transform: scale(1.5);
        }
        h1 {
            text-align: center;
            color: #a52a2a;
        }
    </style>
</head>
<body>

    <h1>Mark Attendance</h1>
    
    <form action="submit_attendance.php" method="post">
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required>
        
        <table>
            <tr>
                <th>Register Number</th>
                <th>Name</th>
                <th>Present/Absent</th>
            </tr>
            <?php
            include 'db.php';

            // Fetch all students with their name and reg_no
            $sql = "SELECT id, name, reg_no FROM user_management.users";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Loop through each student and create a table row
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['reg_no']) . "</td>
                            <td>" . htmlspecialchars($row['name']) . "</td>
                            <td><input type='checkbox' name='attendance[" . htmlspecialchars($row['id']) . "]' value='Present' checked></td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No students found.</td></tr>";
            }

            $conn->close();
            ?>
        </table>
        
        <div style="text-align: center; margin-top: 20px;">
            <button type="submit">Submit Attendance</button>
        </div>
    </form>

</body>
</html>
