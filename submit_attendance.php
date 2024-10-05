<?php
// Include the database connection (assumes db.php connects to both databases if needed)
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $attendance_data = $_POST['attendance']; // Attendance data from the form
    $date = $_POST['date']; // Date for the attendance

    // Loop through each student's attendance data
    foreach ($attendance_data as $reg_no => $status) {
        // Prepare an SQL statement to insert or update the attendance record
        $sql = "INSERT INTO attendance_system.attendance (reg_no, date, status) 
                VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE status=?";
        
        // Prepare the statement
        $stmt = $conn->prepare($sql);
        
        // Bind the parameters
        // Use 's' for string data type since reg_no is likely a string (VARCHAR)
        $stmt->bind_param("ssss", $reg_no, $date, $status, $status);

        // Execute the query
        $stmt->execute();
        
        // Close the prepared statement
        $stmt->close();
    }

    echo "Attendance records updated successfully.";
}

// Close the database connection
$conn->close();
?>
