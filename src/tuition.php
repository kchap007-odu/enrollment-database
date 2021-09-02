<link rel="stylesheet" href="css/bootstrap.css" />
<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="css/style.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

<?php
require "authentication.php";
require "helper-functions.php";

session_start();
$connection = createNewConnection();

$adultId = $_SESSION["adultId"];
// $findChildrenQuery = "SELECT DISTINCT c.ChildID, c.LastName, c.FirstName FROM CHILD AS c, PAR_CH_REL AS r WHERE c.ChildId = r.ChildID AND r.AdultID = $adultId";
// $findChildrenQueryResult = $connection->query($findChildrenQuery);
$isTeacherQuery = "SELECT * FROM ROLES AS r, ROLE_REL AS rr WHERE r.RoleID = rr.RoleID AND rr.AdultID = $adultId AND r.Role = 'Teacher'";
$isTeacherResult = $connection->query($isTeacherQuery);

$discountRate = ($isTeacherResult->num_rows > 0) ? 0.90 : 1;

if ($discountRate < 1) {
    createFeedbackBanner("Teacher discount applied", "");
}

$tuitionQuery = "SELECT c.FirstName, c.LastName, SUM(COST) AS Subtotal, SUM(Cost) * $discountRate AS Total FROM ACTIVITY AS a, ENROLLMENT AS e, ADULT AS d, PAR_CH_REL AS r, CHILD AS c WHERE d.AdultID = $adultId AND r.AdultID = d.AdultID AND c.ChildID = r.ChildID AND c.ChildID = e.ChildID AND e.ActivityID = a.ActivityID GROUP BY r.ChildID";
$tuitionResult = $connection->query($tuitionQuery);
$connection->close();
?>

<body>
    <div class="p-3">
        <!-- Create a new table for each child -->
        <?php queryToTable($tuitionResult); ?>
    </div>
</body>