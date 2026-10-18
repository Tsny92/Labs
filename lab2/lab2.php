<?php

// Lab 2: PHP Expressions and Control Structures

echo '<h1>Lab 2A: Expressions and Control Structures</h1>';

// 1. Expressions and Operators
echo '<h2>1. Expressions and Operators</h2>';

$x = -5;

// TODO: Write an expression that calculates:
// y = 3(abs(2x) + 4)
$y = 3 * (abs(2 * $x) + 4);

echo "The value of y is: $y<br>";

// 2. Boolean Comparisons
echo '<h2>2. Comparisons</h2>';

// TODO: Use var_dump() to compare:
// 2 > 1
// 2 == 3
// "5" == 5
// "5" === 5
var_dump(2 > 1);
var_dump(2 == 3);
var_dump("5" == 5);
var_dump("5" === 5);

// 3. Unary Operators
echo '<h2>3. Unary Operators</h2>';

$c = 5;

// TODO: Create variables that demonstrate unary minus, unary plus,
// and pre-increment. Display the results.
$negative = -$c;
$positive = +$c;
$incremented = ++$c;

echo "Unary minus: $negative<br>";
echo "Unary plus: $positive<br>";
echo "Pre-increment: $incremented<br>";

// 4. Operator Precedence
echo '<h2>4. Operator Precedence</h2>';

// TODO: Compare the results of these two expressions:
// 2 + 3 * 4
// (2 + 3) * 4
$result1 = 2 + 3 * 4;
$result2 = (2 + 3) * 4;

echo "Without parentheses: $result1<br>";
echo "With parentheses: $result2<br>";

// 5. Assignment Associativity
echo '<h2>5. Assignment Associativity</h2>';

// TODO: Assign 0 to $level, $score, and $time in one statement.
// Display each variable.
$level = $score = $time = 0;

echo "Level: $level<br>";
echo "Score: $score<br>";
echo "Time: $time<br>";

// 6. Equality and Assignment
echo '<h2>6. Equality and Assignment</h2>';

// TODO: Create variables with equal and unequal values.
// Use var_dump() to compare them with == and ===.
$num1 = 5;
$num2 = "5";
$num3 = 10;

echo "Equal values with ==: ";
var_dump($num1 == $num2);
echo "<br>";

echo "Equal values with ===: ";
var_dump($num1 === $num2);
echo "<br>";

echo "Unequal values with ==: ";
var_dump($num1 == $num3);
echo "<br>";

echo "Unequal values with ===: ";
var_dump($num1 === $num3);
echo "<br>";

// 7. Logical Operators
echo '<h2>7. Logical Operators</h2>';

$a = 1;
$b = 0;

// TODO: Use var_dump() to demonstrate &&, ||, and !.
echo "AND operator: ";
var_dump($a && $b);
echo "<br>";

echo "OR operator: ";
var_dump($a || $b);
echo "<br>";

echo "NOT operator: ";
var_dump(!$a);
echo "<br>";

// 8. Scholarship Decision with if...else
echo '<h2>8. Scholarship Decision with if...else</h2>';

$gpa = 3.59;

// TODO: Use if...else to display whether the student receives a scholarship.
if ($gpa >= 3.5) {
    echo "The student receives a scholarship.<br>";
} else {
    echo "The student does not receive a scholarship.<br>";
}

// 9. Scholarship Decision with if...elseif...else
echo '<h2>9. Scholarship Decision with if...elseif...else</h2>';

// TODO: Use if...elseif...else to display:
// Full scholarship for GPA 3.7 or higher
// Partial scholarship for GPA 3.5 through 3.69
// No scholarship otherwise
if ($gpa >= 3.7) {
    echo "Full scholarship<br>";
} elseif ($gpa >= 3.5) {
    echo "Partial scholarship<br>";
} else {
    echo "No scholarship<br>";
}

// 10. Access Status
echo '<h2>10. Access Status</h2>';

$status = 'pending';

// TODO: Use a switch statement to display a message for:
// approved, pending, and all other statuses
switch ($status) {
    case 'approved':
        echo "Access approved<br>";
        break;

    case 'pending':
        echo "Access pending<br>";
        break;

    default:
        echo "Access status unknown<br>";
        break;
}

// 11. While Loop
echo '<h2>11. While Loop</h2>';

$fuel = 10;

// TODO: Create a while loop.
// Display "There is enough fuel" while fuel is greater than 1.
// Decrease fuel during each repetition.
while ($fuel > 1) {
    echo "There is enough fuel<br>";
    $fuel--;
}

// 12. Multiplication Table
echo '<h2>12. Multiplication Table</h2>';

// TODO: Create a for loop that displays the 12-times table
// from 1 through 12.
for ($i = 1; $i <= 12; $i++) {
    $result = 12 * $i;
    echo "12 x $i = $result<br>";
}