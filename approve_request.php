<?php
// Include the database connection script (db.php)
require('db.php');

// Check if an ID parameter is provided in the URL
if (isset($_GET['id'])) {
    // Retrieve the ID from the URL
    $request_id = $_GET['id'];

    // Fetch the request from the requestcourses table
    $fetch_request_query = "SELECT rc.student_roll_number, c.course_name, i.teacher_name, rc.id
                            FROM requestcourses rc
                            JOIN courses c ON rc.course_id = c.course_id
                            JOIN courses_instructors ci ON c.course_id = ci.course_id
                            JOIN instructors i ON ci.teacher_id = i.teacher_id
                            WHERE rc.id = ?";

    $fetch_request_stmt = $conn->prepare($fetch_request_query);
    $fetch_request_stmt->bind_param("i", $request_id);

    if ($fetch_request_stmt->execute()) {
        $fetch_request_result = $fetch_request_stmt->get_result();

        if ($fetch_request_result->num_rows === 1) {
            $request = $fetch_request_result->fetch_assoc();

            // Insert the approved course into the approved_courses table
            $insert_sql = "INSERT INTO approved_courses (course_name, instructor_name, student_roll_number) VALUES (?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bind_param("sss", $request['course_name'], $request['teacher_name'], $request['student_roll_number']);

            if ($insert_stmt->execute()) {
                // Approved course added to approved_courses table successfully

                // Now, delete the request from the requestcourses table
                $delete_request_query = "DELETE FROM requestcourses WHERE id = ?";
                $delete_request_stmt = $conn->prepare($delete_request_query);
                $delete_request_stmt->bind_param("i", $request_id);
                if ($delete_request_stmt->execute()) {
                    // Request deleted successfully
                    header("Location: approve_course_request.php");
                } else {
                    echo "Error deleting request: " . $delete_request_stmt->error;
                }
            } else {
                echo "Error adding course to approved_courses table: " . $insert_stmt->error;
            }
        } else {
            echo "Request not found.";
        }
    } else {
        echo "Error fetching request: " . $fetch_request_stmt->error;
    }

    // Close the prepared statements
    $fetch_request_stmt->close();
    $insert_stmt->close();
    $delete_request_stmt->close();
} else {
    echo "Invalid request.";
}

// Close the database connection
$conn->close();
?>
    