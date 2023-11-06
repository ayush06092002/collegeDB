<?php
require('db.php');

if (isset($_GET['teacher_id']) && isset($_GET['course_name'])) {
    // Collect the teacher_id from the URL
    $teacher_id = $_GET['teacher_id'];
    $course_name = $_GET['course_name'];

    // Begin a transaction for atomic operations
    $conn->begin_transaction();

    $fetch_courses_query = "SELECT course_id FROM courses WHERE course_name = ?";
    $fetch_courses_stmt = $conn->prepare($fetch_courses_query);
    $fetch_courses_stmt->bind_param("s", $course_name);

    if ($fetch_courses_stmt->execute()) {
        $fetch_courses_stmt->store_result();
        $fetch_courses_stmt->bind_result($course_id);

        // Fetch the course_id
        if ($fetch_courses_stmt->fetch()) {
            // Step 1: Delete records from courses_instructors related to the teacher
            $delete_courses_instructors_query = "DELETE FROM courses_instructors WHERE teacher_id = ? AND course_id = ?";
            $delete_courses_instructors_stmt = $conn->prepare($delete_courses_instructors_query);
            $delete_courses_instructors_stmt->bind_param("ii", $teacher_id, $course_id);

            // Execute the deletion query for courses_instructors
            if ($delete_courses_instructors_stmt->execute()) {
                // Step 2: Delete the instructor's record
                $delete_instructor_query = "DELETE FROM instructors WHERE teacher_id = ?";
                $delete_instructor_stmt = $conn->prepare($delete_instructor_query);
                $delete_instructor_stmt->bind_param("i", $teacher_id);

                // Execute the deletion query for instructors
                if ($delete_instructor_stmt->execute()) {
                    // Commit the transaction if all operations were successful
                    $conn->commit();
                    echo "Teacher removed from the course successfully";
                } else {
                    $conn->rollback(); // Rollback the transaction in case of an error
                    echo "Error deleting instructor record: " . $conn->error;
                }
            } else {
                $conn->rollback(); // Rollback the transaction in case of an error
                echo "Error deleting records from courses_instructors: " . $conn->error;
            }
        } else {
            $conn->rollback(); // Rollback the transaction if course_id could not be fetched
            echo "Error fetching course_id.";
        }
    } else {
        $conn->rollback(); // Rollback the transaction in case of an error
        echo "Error fetching course_id: " . $conn->error;
    }

    // Close the prepared statements and the database connection
    $fetch_courses_stmt->close();
    $delete_courses_instructors_stmt->close();
    $delete_instructor_stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
