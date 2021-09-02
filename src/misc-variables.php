<?php
$states = array(
    "AL", "AK", "AS", "AZ", "AR", "CA", "CO", "CT", "DE", "FL",
    "GA", "HI", "ID", "IL", "IN", "IA", "KS", "KY", "LA", "ME",
    "MD", "MA", "MI", "MN", "MS", "MO", "MT", "NE", "NV", "NH",
    "NJ", "NM", "NY", "NC", "ND", "OH", "OK", "OR", "PA", "RI",
    "SC", "SD", "TN", "TX", "UT", "VA", "WA", "WV", "WI", "WY",
);

$genders = array(
    "M" => "Male",
    "F" => "Female",
    "O" => "Unspecified"
);

$gradeLevels = array(
    "K", "1", "2", "3", "4", "5", "6",
    "7", "8", "9", "10", "11", "12"
);

$navbarElements = array(
    "Logged In" => array(
        "Dashboard" => array(
            "icon" => "fa fa-dashboard",
            "target" => "targetframe",
            "url" => "dashboard.php"
        ),
        "View Profile" => array(
            "icon" => "fa fa-user",
            "target" => "targetframe",
            "url" => "my-profile.php"
        ),
        "View Child Information" => array(
            "icon" => "fa fa-users",
            "target" => "targetframe",
            "url" => "my-children.php"
        ),
        "View Course Offerings" => array(
            "icon" => "fa fa-calendar",
            "target" => "targetframe",
            "url" => "course-offerings.php"
        ),
        "View Enrolled Courses" => array(
            "icon" => "fa fa-file-text-o",
            "target" => "targetframe",
            "url" => "classes.php"
        ),
        "View Tuition" => array(
            "icon" => "fa fa-credit-card",
            "target" => "targetframe",
            "url" => "tuition.php"
        ),
        "Log Out" => array(
            "icon" => "fa fa-sign-out",
            "target" => "_self",
            "url" => "logout.php"
        )
    ),
    "Logged Out" => array(
        "Log In" => array(
            "icon" => "fa fa-sign-in",
            "target" => "targetframe",
            "url" => "login.php"
        ),
        "Sign Up" => array(
            "icon" => "fa fa-user-plus",
            "target" => "targetframe",
            "url" => "signup.php"
        )
    )
);
