<!DOCTYPE html>
<html>
<head>
    <title>Approved Courses</title>
    <link rel="stylesheet" type="text/css" href="stylesApprCourses.css">
</head>
<body>
    <div class="container">
        <h2>Approved Courses</h2>
        <?php
        // Include the PHP script to fetch approved courses
        include('fetch_approved_courses.php');
        ?>
        <table class="course-table">
            <thead>
                <tr>
                    <th>Course ID</th>
                    <th>Course Name</th>
                    <th>Course Description</th>
                    <th>Instructor Name</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through the approved courses and display them in the table
                foreach ($approved_courses as $course) {
                    echo "<tr>";
                    echo "<td>" . $course['course_id'] . "</td>";
                    echo "<td>" . $course['course_name'] . "</td>";
                    echo "<td>" . $course['course_description'] . "</td>";
                    echo "<td>" . $course['instructor_name'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
