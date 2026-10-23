<?php

//indexed arrays
$timeSlots = ["Morning", "Afternoon", "Evening"];

echo "<h2>Indexed Array - Time Slots</h2>";
echo $timeSlots[0] . "<br>";
echo $timeSlots[1] . "<br>";
echo $timeSlots[2] . "<br>";

//associative arrays
$request = [
    "course" => "IS 6465",
    "topic" => "PHP arrays",
    "status" => "Pending review"
];
echo "<h2>Associative Array - Tutoring Request</h2>";
echo "<strong>Topic:</strong> " . htmlspecialchars($request["topic"], ENT_QUOTES, "UTF-8") . "<br>";

//multidimensional arrays
$requests = [
    ["student" => "Amina", "course" => "IS 6465", "status" => "Pending review"],
    ["student" => "Diego", "course" => "IS 6495", "status" => "Matched"]
];

echo "<h2>Multidimensional Array - Student Requests</h2>";

foreach ($requests as $studentRequest) {
    echo "<p>";
    echo "<strong>Student:</strong> " . htmlspecialchars($studentRequest["student"], ENT_QUOTES, "UTF-8") . "<br>";
    echo "<strong>Course:</strong> " . htmlspecialchars($studentRequest["course"], ENT_QUOTES, "UTF-8") . "<br>";
    echo "<strong>Status:</strong> " . htmlspecialchars($studentRequest["status"], ENT_QUOTES, "UTF-8");
    echo "</p>";
}

//foreach
$courses = ["IS 6465", "IS 6495", "IS 6570"];

echo "<h2>Foreach Loop - Course Dropdown</h2>";
echo '<label for="course">Select a course:</label> ';
echo '<select name="course" id="course">';

foreach ($courses as $course) {
    echo "<option value='' . htmlspecialchars($course, ENT_QUOTES, 'UTF-8') . ''>";
    echo htmlspecialchars($course, ENT_QUOTES, "UTF-8") . "</option>";
}

echo '</select>';
echo '<br>';



?>

