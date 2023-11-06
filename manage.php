<!DOCTYPE html>
<html>

<head>
    <title>Admin Management Panel</title>
    <link rel="stylesheet" type="text/css" href="styles_manage.css">
</head>

<body>
    <h1>Admin Management Panel</h1>

    <!-- Tabbed navigation -->
    <div class="tab">
        <button class="tablinks" onclick="openTab(event, 'studentsTab')">Students</button>
        <button class="tablinks" onclick="openTab(event, 'teachersTab')">Teachers</button>
        <button class="tablinks" onclick="openTab(event, 'coursesTab')">Courses</button>
    </div>

    <!-- Students Tab -->
    <div id="studentsTab" class="tabcontent">
        <h2>Manage Students</h2>
        <br>
        <input type="text" id="studentSearchInput" oninput="searchStudents()" placeholder="Search for students...">
        <button class="searchButton" onclick="searchStudents()">Search</button>
        <table>
            <tbody>
                <?php
                include('db.php');

                // Fetch student data along with their approved courses from the database
                $query = "SELECT s.roll_number, s.student_name, s.department, ac.course_name FROM students s
                LEFT JOIN approved_courses ac ON s.roll_number = ac.student_roll_number";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    echo '<table>';
                    echo '<tr><th>Roll Number</th><th>Name</th><th>Department</th><th>Approved Course</th><th>Action</th></tr>';
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo '<td>' . $row['roll_number'] . '</td>';
                        echo '<td>' . $row['student_name'] . '</td>';
                        echo '<td>' . $row['department'] . '</td>';
                        echo '<td>' . $row['course_name'] . '</td>';
                        echo '<td><a href="delete_student.php?roll_number=' . $row['roll_number'] . '&course_name=' . $row['course_name'] . '">Delete</a></td>';
                        echo '</tr>';
                    }
                    echo '</table>';
                } else {
                    echo 'No students found.';
                }
                ?>


            </tbody>
        </table>
    </div>
    <br>
    <!-- Teachers Tab -->
    <div id="teachersTab" class="tabcontent">
        <h2>Manage Teachers</h2>
        <br>
        <input type="text" id="teacherSearchInput" oninput="searchTeachers()" placeholder="Search for teachers...">
        <button class="searchButton" onclick="searchTeachers()">Search</button>
        <table>
            <tbody>
                <?php
                include('db.php');

                // Fetch teacher data along with their courses and departments from the database
                $query = "SELECT i.teacher_id, i.teacher_name, i.department, c.course_name
          FROM instructors i
          LEFT JOIN courses_instructors ci ON i.teacher_id = ci.teacher_id
          LEFT JOIN courses c ON ci.course_id = c.course_id";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    echo '<table>';
                    echo '<tr><th>Teacher ID</th><th>Name</th><th>Department</th><th>Course</th><th>Action</th></tr>';
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo '<td>' . $row['teacher_id'] . '</td>';
                        echo '<td>' . $row['teacher_name'] . '</td>';
                        echo '<td>' . $row['department'] . '</td>';
                        echo '<td>' . $row['course_name'] . '</td>';
                        echo '<td><a href="delete_teacher.php?teacher_id=' . $row['teacher_id'] . '&course_name=' . $row['course_name'] . '">Delete</a></td>';
                        echo '</tr>';
                    }
                    echo '</table>';
                } else {
                    echo 'No teachers found.';
                }
                ?>

            </tbody>
        </table>
    </div>

    <!-- Courses Tab -->
    <div id="coursesTab" class="tabcontent">
        <h2>Manage Courses</h2>
        <br>
        <input type="text" id="courseSearchInput" oninput="searchCourses()" placeholder="Search for courses...">
        <button class="searchButton" onclick="searchCourses()">Search</button>
        <table>
            <tbody>
                <?php
                include('db.php');

                // Fetch course data along with the count of students enrolled in each course
                $query = "SELECT c.course_id, c.course_name, c.course_code, c.department, COUNT(ac.student_roll_number) AS student_count
          FROM courses c
          LEFT JOIN approved_courses ac ON c.course_name = ac.course_name
          GROUP BY c.course_id, c.course_name, c.course_code, c.department";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    echo '<table>';
                    echo '<tr><th>Course Name</th><th>Course Code</th><th>Department</th><th>Student Count</th><th>Action</th></tr>';
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo '<td>' . $row['course_name'] . '</td>';
                        echo '<td>' . $row['course_code'] . '</td>';
                        echo '<td>' . $row['department'] . '</td>';
                        echo '<td>' . $row['student_count'] . '</td>';
                        echo '<td><a href="delete_course.php?course_name=' . $row['course_name'] . '">Delete</a></td>';
                        echo '</tr>';
                    }
                    echo '</table>';
                } else {
                    echo 'No courses found.';
                }
                ?>

            </tbody>
        </table>
    </div>

    <script>
        // JavaScript function to switch tabs
        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        function searchStudents() {
            // Get the input value for searching
            var searchInput = document.getElementById("studentSearchInput").value.toLowerCase();

            // Get all the rows in the table
            var rows = document.querySelectorAll("#studentsTab table tbody tr");

            // Loop through each row and hide/show based on the search input
            for (var i = 0; i < rows.length; i++) {
                var cells = rows[i].getElementsByTagName("td");
                if (cells.length >= 4) {
                    var rollNumber = cells[0].textContent.toLowerCase();
                    var name = cells[1].textContent.toLowerCase();
                    var department = cells[2].textContent.toLowerCase();
                    var course = cells[3].textContent.toLowerCase();

                    if (
                        rollNumber.includes(searchInput) ||
                        name.includes(searchInput) ||
                        department.includes(searchInput) ||
                        course.includes(searchInput)
                    ) {
                        rows[i].style.display = ""; // Show the row
                    } else {
                        rows[i].style.display = "none"; // Hide the row
                    }
                }
            }
        }

        function searchTeachers() {
            // Get the input value for searching
            var searchInput = document.getElementById("teacherSearchInput").value.toLowerCase();

            // Get all the rows in the table
            var rows = document.querySelectorAll("#teachersTab table tbody tr");

            // Loop through each row and hide/show based on the search input
            for (var i = 0; i < rows.length; i++) {
                var cells = rows[i].getElementsByTagName("td");
                if (cells.length >= 4) {
                    var teacherId = cells[0].textContent.toLowerCase();
                    var teacherName = cells[1].textContent.toLowerCase();
                    var department = cells[2].textContent.toLowerCase();
                    var course = cells[3].textContent.toLowerCase();

                    if (
                        teacherId.includes(searchInput) ||
                        teacherName.includes(searchInput) ||
                        department.includes(searchInput) ||
                        course.includes(searchInput)
                    ) {
                        rows[i].style.display = ""; // Show the row
                    } else {
                        rows[i].style.display = "none"; // Hide the row
                    }
                }
            }
        }

        function searchCourses() {
            // Get the input value for searching
            var searchInput = document.getElementById("courseSearchInput").value.toLowerCase();

            // Get all the rows in the table
            var rows = document.querySelectorAll("#coursesTab table tbody tr");

            // Loop through each row and hide/show based on the search input
            for (var i = 0; i < rows.length; i++) {
                var cells = rows[i].getElementsByTagName("td");
                if (cells.length >= 4) {
                    var courseName = cells[0].textContent.toLowerCase();
                    var courseCode = cells[1].textContent.toLowerCase();
                    var department = cells[2].textContent.toLowerCase();
                    var studentCount = cells[3].textContent.toLowerCase();

                    if (
                        courseName.includes(searchInput) ||
                        courseCode.includes(searchInput) ||
                        department.includes(searchInput) ||
                        studentCount.includes(searchInput)
                    ) {
                        rows[i].style.display = ""; // Show the row
                    } else {
                        rows[i].style.display = "none"; // Hide the row
                    }
                }
            }
        }
    </script>
</body>

</html>