<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require('db.php');

    // Collect data from the form
    $teacher_username = $_POST['teacher_username'];
    $department = $_POST['department'];
    $is_head = isset($_POST['is_head']) ? 1 : 0;
    $assigned_courses = $_POST['assigned_courses']; // Array of assigned courses

    // Validate the data (add more validation as needed)
    if (empty($teacher_username) || empty($department) || empty($assigned_courses)) {
        echo "Teacher username, department, and assigned courses are required fields.";
        exit();
    }

    // Fetch teacher details from the teachers table
    $fetch_teacher_sql = "SELECT teacher_name FROM teachers WHERE username = ?";
    $fetch_teacher_stmt = $conn->prepare($fetch_teacher_sql);
    $fetch_teacher_stmt->bind_param("s", $teacher_username);
    $fetch_teacher_stmt->execute();
    $fetch_teacher_stmt->bind_result($teacher_name);
    $fetch_teacher_stmt->fetch();
    $fetch_teacher_stmt->close();

    if (empty($teacher_name)) {
        echo "Teacher with the provided username does not exist.";
        echo '<script type="text/javascript">
            setTimeout(function(){
                window.location = "create_teacher.php";
            }, 4000);
        </script>';
        exit();
    }

    // Check if there is already a head for the specified department
    if ($is_head) {
        $check_head_sql = "SELECT instructor_id FROM instructors WHERE department = ? AND is_head = 1 LIMIT 1";
        $check_head_stmt = $conn->prepare($check_head_sql);
        $check_head_stmt->bind_param("s", $department);
        $check_head_stmt->execute();
        $check_head_stmt->store_result();

        if ($check_head_stmt->num_rows > 0) {
            echo "A head already exists for this department.";
            echo '<script type="text/javascript">
            setTimeout(function(){
                window.location = "create_teacher.php";
            }, 4000);
        </script>';
            exit();
        }
    }

    // Insert the new teacher into the instructors table
    $insert_teacher_sql = "INSERT INTO instructors (instructor_name, department, is_head) VALUES (?, ?, ?)";
    $insert_teacher_stmt = $conn->prepare($insert_teacher_sql);
    $insert_teacher_stmt->bind_param("ssi", $teacher_name, $department, $is_head);

    if ($insert_teacher_stmt->execute()) {
        // Get the instructor_id of the newly added teacher
        $instructor_id = $insert_teacher_stmt->insert_id;

        // Assign courses to the teacher by inserting into the courses_instructors table
        if (!empty($assigned_courses)) {
            $assign_courses_sql = "INSERT INTO courses_instructors (instructor_id, course_name) VALUES (?, ?)";
            $assign_courses_stmt = $conn->prepare($assign_courses_sql);

            foreach ($assigned_courses as $course_name) {
                $assign_courses_stmt->bind_param("is", $instructor_id, $course_name);
                $assign_courses_stmt->execute();
            }

            $assign_courses_stmt->close();
        }

        echo "Teacher and assigned courses added successfully!";
        echo '<script type="text/javascript">
        setTimeout(function(){
            window.location = "create_teacher.php";
        }, 3000);
    </script>';
    } else {
        echo "Error: " . $insert_teacher_stmt->error;
    }


    $insert_teacher_stmt->close();
    $conn->close();
}
