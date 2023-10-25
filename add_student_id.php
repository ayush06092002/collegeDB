<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require('db.php');

    // Collect data from the form
    $student_name = $_POST['student_name'];
    $department = $_POST['department'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Validate the data (add more validation as needed)
    if (empty($student_name) || empty($department) || empty($password)) {
        echo "Student name, department, and password are required fields.";
        exit();
    }

    // Check if the department exists in the courses table
    $check_department_sql = "SELECT COUNT(*) FROM courses WHERE department = ?";
    $check_department_stmt = $conn->prepare($check_department_sql);
    $check_department_stmt->bind_param("s", $department);
    $check_department_stmt->execute();
    $check_department_stmt->bind_result($department_count);
    $check_department_stmt->fetch();
    $check_department_stmt->close();

    if ($department_count == 0) {
        echo "The department does not exist. Please enter a valid department.";
        echo '<script type="text/javascript">
            setTimeout(function(){
                window.location = "create_student_id.php";
            }, 3000);
        </script>';
        exit();
    }

    // Generate the unique roll number
    $year = date("y"); // Get the last two digits of the current year
    $next_roll_number = 1;

    // Determine the next roll number based on the existing entries
    $next_roll_query = "SELECT MAX(SUBSTRING(roll_number, 6)) FROM students WHERE department = ?";
    $next_roll_stmt = $conn->prepare($next_roll_query);
    $next_roll_stmt->bind_param("s", $department);
    $next_roll_stmt->execute();
    $next_roll_stmt->bind_result($max_roll_number);
    $next_roll_stmt->fetch();
    $next_roll_stmt->close();

    if (!is_null($max_roll_number)) {
        $next_roll_number = intval($max_roll_number) + 1;
    } else {
        // If no roll numbers exist for the department, set the initial roll number to "001"
        $next_roll_number = 1;
    }

    // Format the roll number
    $roll_number = $year . $department . sprintf("%03d", $next_roll_number);

    // Insert the new student into the students table
    $insert_student_sql = "INSERT INTO students (roll_number, student_name, department, password) VALUES (?, ?, ?, ?)";
    $insert_student_stmt = $conn->prepare($insert_student_sql);
    $insert_student_stmt->bind_param("ssss", $roll_number, $student_name, $department, $password);

    if ($insert_student_stmt->execute()) {
        echo "Student ID created successfully!";
        echo '<script type="text/javascript">
            setTimeout(function(){
                window.location = "create_student_id.php";
            }, 3000);
        </script>';
    } else {
        echo "Error: " . $insert_student_stmt->error;
    }

    $insert_student_stmt->close();
    $conn->close();
}
