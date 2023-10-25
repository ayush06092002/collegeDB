<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require('db.php');

    // Collect data from the form
    $course_name = $_POST['course_name'];
    $course_code = $_POST['course_code'];
    $department = $_POST['department'];

    // Validate the data (add more validation as needed)
    if (empty($course_name) || empty($course_code) || empty($department)) {
        echo "Course name, course code, and department are required fields.";
        exit();
    }

    // Check if the course with the same name already exists in the same department
    $check_sql = "SELECT course_id FROM courses WHERE course_name = ? AND department = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ss", $course_name, $department);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        echo "A course with the same name already exists in this department.\n";
        echo '<script type="text/javascript">
            setTimeout(function(){
                window.location = "create_course.php";
            }, 5000);
        </script>'; 
    }

    // Insert the new course into the database
    $sql = "INSERT INTO courses (course_name, course_code, department) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $course_name, $course_code, $department);

    if ($stmt->execute()) {
        echo "Course added successfully!";
        echo '<script type="text/javascript">
            setTimeout(function(){
                window.location = "create_course.php";
            }, 3000);
        </script>';
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
