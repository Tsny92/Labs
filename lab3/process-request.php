<?php


if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit("Method not allowed. Please submit the tutoring request form.");
}

$course = trim($_POST["course"] ?? "");
$topic = trim($_POST["topic"] ?? "");
$preferredTime = $_POST["preferredtime"] ?? "";
$preferredDate = trim($_POST["preferreddate"] ?? "");

$errors = [];
$allowedCourses = ["IS 6465", "IS 6495", "IS 6570"];
$allowedTimes = ["Morning", "Afternoon", "Evening"];

if (!in_array($course, $allowedCourses, true)) {
    $errors["course"] = "Select a valid course.";
}

if (!in_array($preferredTime, $allowedTimes, true)) {
    $errors["preferred_time"] = "Select a valid preferred time.";
}

if ($topic === "" || mb_strlen($topic) > 120) {
    $errors["topic"] = "Enter a topic of 1 to 120 characters.";
}

$date = DateTime::createFromFormat("!Y-m-d", $preferredDate);
$validDate = $date && $date->format("Y-m-d") === $preferredDate;

if (!$validDate) {
    $errors["preferred_date"] = "Enter a valid preferred date.";
} elseif ($date < new DateTime("today")) {
    $errors["preferred_date"] = "Preferred date cannot be in the past.";
}

if ($errors) {
    echo "<h1>Please correct the following errors:</h1>";
    echo "<ul>";

    foreach ($errors as $error) {
        echo "<li>" . htmlspecialchars($error, ENT_QUOTES, "UTF-8") . "</li>";
    }

    echo "</ul>";
    echo '<p><a href="request-form.html">Back to request form</a></p>';
    exit;
}

echo "<h1>Request received</h1>";

echo "<p><strong>Course:</strong> " .
    htmlspecialchars($course, ENT_QUOTES, "UTF-8") . "</p>";

echo "<p><strong>Topic:</strong> " .
    htmlspecialchars($topic, ENT_QUOTES, "UTF-8") . "</p>";

echo "<p><strong>Preferred Date:</strong> " .
    htmlspecialchars($preferredDate, ENT_QUOTES, "UTF-8") . "</p>";

echo "<p><strong>Preferred Time:</strong> " .
    htmlspecialchars($preferredTime, ENT_QUOTES, "UTF-8") . "</p>";

echo "<p><strong>Status:</strong> Pending review</p>";

echo '<p><a href="request-form.html">Submit another request</a></p>';

?>