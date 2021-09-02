<link rel="stylesheet" href="css/bootstrap.css" />
<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="css/style.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

<?php

session_start();

require "authentication.php";
include "helper-functions.php";

$connection = new mysqli($server, $sqlUsername, $sqlPassword, $databaseName);
$accountId = $_SESSION["accountId"];
$adultId = $_SESSION["adultId"];
$spouseId = $_SESSION["spouseId"];
// $childQuery = "SELECT c.LastName, c.FirstName, c.DateOfBirth, c.Gender, c.GradeLevel FROM CHILD AS c, PAR_CH_REL AS r, ADULT AS a, ACCOUNT AS x WHERE x.AccountID = $accountId AND x.PrimaryUserID = a.AdultID AND r.AdultID = a.AdultID AND r.ChildID = c.ChildID";
// Show all children with associations to
$myChildrenQuery = "SELECT c.FirstName, c.LastName, c.DateOfBirth, c.Gender, c.GradeLevel FROM CHILD AS c, PAR_CH_REL AS r WHERE c.ChildID = r.ChildID AND r.AdultID = $adultId";
$myResult = $connection->query($myChildrenQuery);
$spouseChildrenQuery = "SELECT c.FirstName, c.LastName, c.DateOfBirth, c.Gender, c.GradeLevel FROM CHILD AS c, PAR_CH_REL AS r WHERE c.ChildID = r.ChildID AND r.AdultID = $spouseId";
$spouseResult = $connection->query($spouseChildrenQuery);
$connection->close();

?>
<div class="p-3">
    <h4>Your children:</h4>
    <?= queryToTable($myResult); ?>
    <a class="btn btn-default" href="add-child.php">Add Child</a>
    <h4>Your Spouse's children:</h4>
    <?= queryToTable($spouseResult); ?>
</div>