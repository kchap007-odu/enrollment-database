<link rel="stylesheet" href="css/bootstrap.css" />
<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="css/style.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

<?php

require "authentication.php";
include "helper-functions.php";

$connection = createNewConnection();

if (isset($_POST["email"]) & isset($_POST["lastName"]) & isset($_POST["firstName"]) & isset($_POST["password"]) & isset($_POST["rePassword"])) {
    $email = $_POST["email"];
    $lastName = $_POST["lastName"];
    $firstName = $_POST["firstName"];
    $password = $_POST["password"];
    $rePassword = $_POST["rePassword"];

    if ($password != $rePassword) {
        $errorMessage = "Passwords do not match.";
    } else {
        $query = "SELECT AccountID FROM ACCOUNT AS acc, ADULT AS a WHERE a.FirstName = '$firstName' AND a.LastName = '$lastName' AND a.Email = '$email' AND acc.PrimaryUserID = a.AdultID";
        $result = $connection->query($query);

        if ($result->num_rows != 1) {
            $errorMessage = "Cannot find user account associated with the provided information.";
        } else {
            $accountId = $result->fetch_object()->AccountID;
            $md5Pass = md5($password);
            $updateQuery = "UPDATE ACCOUNT SET Password = '$md5Pass' WHERE AccountID = $accountId";
            $updateResult = $connection->query($updateQuery);
            $errorMessage = $updateResult->error;
        }
    }
    createFeedbackBanner("Password updated successfully.", $errorMessage);
}

$connection->close();
?>

<div class="p-3">

    <form action="" method="post">
        <div class="form-group col-md-4">
            <label for="email">Email:</label>
            <input name="email" type="email" class="form-control" id="email" placeholder="john.doe@example.com">
        </div>
        <div class="form-group col-md-4">
            <label for="firstName">First Name:</label>
            <input name="firstName" type="text" class="form-control" id="firstName" placeholder="John">
        </div>
        <div class="form-group col-md-4">
            <label for="lastName">Last Name:</label>
            <input name="lastName" type="text" class="form-control" id="lastName" placeholder="Doe">
        </div>


        <div class="form-group col-md-6">
            <label for="password">Password:</label>
            <input name="password" type="password" class="form-control" id="password" placeholder="Password">
        </div>
        <div class="form-group col-md-6">
            <label for="rePassword">Retype Password:</label>
            <input name="rePassword" type="password" class="form-control" id="rePassword" placeholder="Password">
        </div>

        <button class="btn btn-default">Reset password</button>
    </form>

</div>