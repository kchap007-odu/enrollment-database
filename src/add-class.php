<link rel="stylesheet" href="css/bootstrap.css" />
<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="css/style.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

<?php
require "authentication.php";
include "helper-functions.php";

session_start();
$childId = $_SESSION["addCourseChildId"];
// Query to list only classes not already enrolled.
$connection = createNewConnection();

if (isset($_POST["cancel"])) {
    unset($_SESSION["addCourseChildId"]);
    header("Location: classes.php");
    exit;
}

if (isset($_POST["courseId"]) & !empty($_POST["courseId"])) {
    $imploded = implode(", ", $_POST["courseId"]);
    $classQuery = "SELECT ActivityID, RegularClass FROM ACTIVITY WHERE ActivityID IN ($imploded) ORDER BY RegularClass DESC";
    $classResult = $connection->query($classQuery);
    while ($line = $classResult->fetch_assoc()) {
        $activityId = $line["ActivityID"];
        $addQuery = "INSERT INTO ENROLLMENT(ActivityID, ChildID) VALUES($activityId, $childId)";
        $connection->query($addQuery);
    }
    unset($_SESSION["addCourseChildID"]);
    header("Location: classes.php");
}

$childInfoQuery = "SELECT FirstName, LastName FROM CHILD WHERE ChildID = $childId";
$childInfo = $connection->query($childInfoQuery);
$childAssoc = $childInfo->fetch_assoc();

$enrolledQuery = "SELECT COUNT(*) AS NumEnrolled FROM ENROLLMENT WHERE ChildID = $childId";
$enrolledResult = $connection->query($enrolledQuery);
$numEnrolled = $enrolledResult->fetch_object()->NumEnrolled;

if ($numEnrolled > 0) {
    // Needs to be handled differently if student is not currently enrolled in any classes.
    $nonEnrolledClassesQuery = "SELECT ActivityID, Name, Room, BeginTime, EndTime, REPLACE(REPLACE(RegularClass, 0, 'After School'), 1, 'Standard') AS CourseType FROM ACTIVITY WHERE ActivityID NOT IN (SELECT a.ActivityID FROM ENROLLMENT AS e, ACTIVITY AS a WHERE a.ActivityID = e.ActivityID AND ChildID = $childId)";
} else {
    $nonEnrolledClassesQuery = "SELECT a.ActivityID, a.Name, a.Room, a.BeginTime, a.EndTime, REPLACE(REPLACE(a.RegularClass, 0, 'After School'), 1, 'Standard') AS CourseType FROM ACTIVITY AS a";
}
$nonEnrolledClassResult = $connection->query($nonEnrolledClassesQuery);
?>

<body>

    <div class="p-3">
        <h3> Add courses for <?= $childAssoc["FirstName"] ?> <?= $childAssoc["LastName"] ?> </h3>
        <form action="" method="post">
            <?= queryToSelectionTable($nonEnrolledClassResult); ?>
            <button type="submit" name="add" value="">Add</button>
            <button type="submit" name="cancel" value="">Cancel</button>
        </form>
    </div>

</body>

<?php
$connection->close();
?>