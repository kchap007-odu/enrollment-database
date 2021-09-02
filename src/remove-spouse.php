<link rel="stylesheet" href="css/bootstrap.css" />
<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="css/style.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />


<?php

require "authentication.php";
// include "misc-variables.php";
include "helper-functions.php";

session_start();

$connection = createNewConnection();

// Get AccountID and AdultID for current user
$primaryAccountId = $_SESSION["accountId"];
$primaryAdultID = $_SESSION["adultId"];

$spouseAccountIDQuery = "SELECT AccountID FROM ACCOUNT WHERE SpouseID = $primaryAdultID";
$spouseAccountIDresult = $connection->query($spouseAccountIDQuery);
$spouseAccountID = $spouseAccountIDresult->fetch_object()->AccountID;

// Add spouse to this account
$updateQuery = "UPDATE `ACCOUNT` SET `SpouseID` = NULL WHERE `AccountID` = $primaryAccountId;";
// Add this account to spouse account
$updateQuery .= "UPDATE `ACCOUNT` SET `SpouseID` = NULL WHERE `AccountID` = $spouseAccountID";
mysqli_multi_query($connection, $updateQuery);
// Store the error, if any.
$errorMessage = $connection->error;

// Go back to profile
header("Location: my-profile.php");