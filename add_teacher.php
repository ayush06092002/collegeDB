<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require('db.php');

    // Collect data from the form
    $teacher_username = $_POST['teacher_username'];
    $department = $_POST['department'];
    $is_head = isset($_POST['is_head']) ? 1 : 0;
    $assigned_courses = $_POST['assigned_courses']; // Array of assigned course IDs

    // Validate the data (add more validation as needed)
    if (empty($teacher_username) || empty($department) || empty($assigned_courses)) {
        echo "Teacher username, department, and assigned courses are required fields.";
        exit();
    }

    // Fetch teacher details from the teachers table
    $fetch_teacher_sql = "SELECT teacher_id, teacher_name FROM teachers WHERE username = ?";
    $fetch_teacher_stmt = $conn->prepare($fetch_teacher_sql);
    $fetch_teacher_stmt->bind_param("s", $teacher_username);
    $fetch_teacher_stmt->execute();
    $fetch_teacher_stmt->bind_result($teacher_id, $teacher_name);
    $fetch_teacher_stmt->fetch();
    $fetch_teacher_stmt->close();

    if (empty($teacher_id)) {
        echo "Teacher with the provided username does not exist.";
        echo '<script type="text/javascript">
            setTimeout(function(){
                window.location = "create_teacher.php";
            }, 4000);
        </script>';
        exit();
    }
    // Check if the assigned courses are already assigned to other instructors
    $check_course_assignment_sql = "SELECT c.course_name FROM courses_instructors ci
    JOIN courses c ON ci.course_id = c.course_id
    WHERE ci.course_id = ?";
    $check_course_assignment_stmt = $conn->prepare($check_course_assignment_sql);

    foreach ($assigned_courses as $course_id) {
        $check_course_assignment_stmt->bind_param("i", $course_id);
        $check_course_assignment_stmt->execute();
        $check_course_assignment_stmt->bind_result($course_name);
        $check_course_assignment_stmt->fetch();

        if (!empty($course_name)) {
            echo "The course '$course_name' is already assigned to another instructor.";
            echo '<script type="text/javascript">
                setTimeout(function(){
                    window.location = "create_teacher.php";
                }, 4000);
            </script>';
            exit();
        }
    }

    $check_course_assignment_stmt->close();
    // Check if the entered department matches the department of the selected courses
    $course_department_check_sql = "SELECT department FROM courses WHERE course_id = ?";
    $course_department_check_stmt = $conn->prepare($course_department_check_sql);

    foreach ($assigned_courses as $course_id) {
        $course_department_check_stmt->bind_param("i", $course_id);
        $course_department_check_stmt->execute();
        $course_department_check_stmt->bind_result($course_department);
        $course_department_check_stmt->fetch();

        if ($course_department !== $department) {
            echo "The department entered does not match the department of the selected course.";
            echo '<script type="text/javascript">
                 setTimeout(function(){
                     window.location = "create_teacher.php";
                 }, 4000);
             </script>';
            exit();
        }
    }
    $course_department_check_stmt->close();

    // Check if there is already a head for the specified department
    if ($is_head) {
        $check_head_sql = "SELECT teacher_id FROM instructors WHERE department = ? AND is_head = 1 LIMIT 1";
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
    // $insert_teacher_sql = "INSERT INTO instructors (teacher_id, teacher_name, department, is_head) VALUES (?, ?, ?, ?)";
    // $insert_teacher_stmt = $conn->prepare($insert_teacher_sql);
    // $insert_teacher_stmt->bind_param("issi", $teacher_id, $teacher_name, $department, $is_head);

    // if ($insert_teacher_stmt->execute()) {


    //     // Assign courses to the teacher by inserting into the courses_instructors table
    //     if (!empty($assigned_courses)) {
    //         $assign_courses_sql = "INSERT INTO courses_instructors (teacher_id, course_id) VALUES (?, ?)";
    //         $assign_courses_stmt = $conn->prepare($assign_courses_sql);

    //         foreach ($assigned_courses as $course_id) {
    //             // Bind the instructor_id and course_id for the assignment
    //             $assign_courses_stmt->bind_param("ii", $teacher_id, $course_id);
    //             $assign_courses_stmt->execute();
    //         }

    //         $assign_courses_stmt->close();
    //     }

    //     echo "Teacher and assigned courses added successfully!";
    //     echo '<script type="text/javascript">
    //     setTimeout(function(){
    //         window.location = "create_teacher.php";
    //     }, 3000);
    // </script>';
    // } else {
    //     echo "Error: " . $insert_teacher_stmt->error;
    // }
    // Check if the teacher is already in the instructors table
    $check_teacher_sql = "SELECT teacher_id FROM instructors WHERE teacher_id = ?";
    $check_teacher_stmt = $conn->prepare($check_teacher_sql);
    $check_teacher_stmt->bind_param("i", $teacher_id);
    $check_teacher_stmt->execute();
    $check_teacher_stmt->store_result();

    if ($check_teacher_stmt->num_rows === 0) {
        // Teacher is not in the instructors table, so add them
        $insert_teacher_sql = "INSERT INTO instructors (teacher_id, teacher_name, department, is_head) VALUES (?, ?, ?, ?)";
        $insert_teacher_stmt = $conn->prepare($insert_teacher_sql);
        $insert_teacher_stmt->bind_param("issi", $teacher_id, $teacher_name, $department, $is_head);
        $insert_teacher_stmt->execute();
        $insert_teacher_stmt->close();
    } else {
        // Teacher is already in the instructors table, so check if the assigned department matches
        $check_assigned_department_sql = "SELECT department FROM instructors WHERE teacher_id = ?";
        $check_assigned_department_stmt = $conn->prepare($check_assigned_department_sql);
        $check_assigned_department_stmt->bind_param("i", $teacher_id);
        $check_assigned_department_stmt->execute();
        $check_assigned_department_stmt->bind_result($assigned_department);
        $check_assigned_department_stmt->fetch();
        $check_assigned_department_stmt->close();

        if ($assigned_department === $department) {
            // Department matches, so allow course assignment
            // You can insert the assigned courses into courses_instructors here
        } else {
            echo "The department assigned to the teacher previously does not match the current department.";
            echo '<script type="text/javascript">
                setTimeout(function(){
                    window.location = "create_teacher.php";
                }, 4000);
            </script>';
            exit();
        }
    }


    $check_teacher_stmt->close();

    // Assign courses to the teacher by inserting into the courses_instructors table
    if (!empty($assigned_courses)) {
        $assign_courses_sql = "INSERT INTO courses_instructors (teacher_id, course_id) VALUES (?, ?)";
        $assign_courses_stmt = $conn->prepare($assign_courses_sql);

        foreach ($assigned_courses as $course_id) {
            // Check if the department of the assigned course matches the department of the teacher
            $course_department_check_sql = "SELECT department FROM courses WHERE course_id = ?";
            $course_department_check_stmt = $conn->prepare($course_department_check_sql);
            $course_department_check_stmt->bind_param("i", $course_id);
            $course_department_check_stmt->execute();
            $course_department_check_stmt->bind_result($course_department);
            $course_department_check_stmt->fetch();
            $course_department_check_stmt->close();

            if ($course_department === $department) {
                // Bind the teacher_id and course_id for the assignment
                $assign_courses_stmt->bind_param("ii", $teacher_id, $course_id);
                $assign_courses_stmt->execute();
            }
        }

        $assign_courses_stmt->close();
    }

    echo "Teacher and assigned courses added successfully!";
    echo '<script type="text/javascript">
            setTimeout(function(){
                window.location = "create_teacher.php";
            }, 3000);
        </script>';

    $insert_teacher_stmt->close();
    $conn->close();
}
