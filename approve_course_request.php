<!DOCTYPE html>
<html>
<head>
    <title>Approve Course Requests</title>
    <link rel="stylesheet" type="text/css" href="stylesApprRequests.css">
</head>
<body>
    <div class="container">
        <h2>Approve Course Requests</h2>
        <table class="request-table">
            <thead>
                <tr>
                    <th>Student Roll Number</th>
                    <th>Course Name</th>
                    <th>Instructor Name</th>
                    <th>Request Date</th>
                    <th colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Include the script to fetch requests
                require('fetch_requests.php');
                
                if (count($requests) > 0) {
                    foreach ($requests as $request) {
                        echo "<tr>";
                        echo "<td>" . $request['student_roll_number'] . "</td>";
                        echo "<td>" . $request['course_name'] . "</td>";
                        echo "<td>" . $request['teacher_name'] . "</td>";
                        echo "<td>" . $request['request_date'] . "</td>";
                        echo "<td><a href='approve_request.php?id=" . $request['id'] . "&action=approve'>Approve</a></td>";
                        echo "<td><a href='approve_request.php?id=" . $request['id'] . "&action=reject'>Reject</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No pending requests</td></tr>";
                }
                
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
