<link rel="stylesheet" href="css/bootstrap.css" />
<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="css/style.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

<?php
require "authentication.php";
include "helper-functions.php";

session_start();

$connection = createNewConnection();

$standardOfferingsQuery = "SELECT Name, Room, BeginTime, EndTime, LastName AS Instructor, Cost FROM ADULT AS a, INSTRUCTOR_REL AS i, ACTIVITY AS c WHERE i.AdultID = a.AdultID AND c.ActivityID = i.ActivityID";
$standardOfferingsResult = $connection->query($standardOfferingsQuery);

$afterSchoolOfferingsQuery = "SELECT Name, Room, BeginTime, EndTime, LastName AS Instructor, Cost FROM ADULT AS a, AFTER_SCH_REL AS i, ACTIVITY AS c WHERE i.AdultID = a.AdultID AND c.ActivityID = i.ActivityID";
$afterSchoolOfferingsResult = $connection->query($afterSchoolOfferingsQuery);

$connection->close();
?>

<body>
    <div class="p-3">
        <h4>Standard Classes:</h4>
        <?= queryToTable($standardOfferingsResult); ?>
        <h4>Extracurricular Activities:</h4>
        <?= queryToTable($afterSchoolOfferingsResult); ?>
    </div>
</body>