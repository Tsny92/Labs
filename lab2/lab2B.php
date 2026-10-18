<?php

// Lab 2B: PHP Functions and Basic Objects

echo '<h1>Lab 2B: Functions and Objects</h1>';

// 1. Function with Parameters and Return Value
echo '<h2>1. Function with Parameters and Return Value</h2>';

function formatName($first, $middle, $last)
{
    // TODO: Clean the capitalization of each name.
    // TODO: Return the complete name as one string.
    $first = ucfirst(strtolower($first));
    $middle = ucfirst(strtolower($middle));
    $last = ucfirst(strtolower($last));

    return "$first $middle $last";
}

// TODO: Call formatName() using sample data.
echo formatName("mARIA", "aNN", "cHEN") . "<br>";

// 2. Function That Returns an Array
echo '<h2>2. Function That Returns an Array</h2>';

function cleanNameParts($first, $middle, $last)
{
    // TODO: Return an array containing the cleaned name parts.
        $first = ucfirst(strtolower($first));
    $middle = ucfirst(strtolower($middle));
    $last = ucfirst(strtolower($last));

    return [$first, $middle, $last];
}

// TODO: Call cleanNameParts() and display one item from the array.
$nameParts = cleanNameParts("mARIA", "aNN", "cHEN");

echo "First name: " . $nameParts[0] . "<br>";

// 3. Variable Scope
echo '<h2>3. Variable Scope</h2>';

$first = 'Maria';
$last = 'Chen';

function buildFullName()
{
    // TODO: Use the global keyword to access $first and $last.
    // Return the complete name.
        global $first, $last;

    return "$first $last";
}

// TODO: Call buildFullName() and display the result.
echo buildFullName() . "<br>";
function buildFullName2($first, $last)
{
    // TODO: Return the complete name using the parameters.
    return "$first $last";
}

// TODO: Call buildFullName2() and display the result.
echo buildFullName2($first, $last) . "<br>";

// 4. Static Variable
echo '<h2>4. Static Variable</h2>';

function nextTicketNumber()
{
    // TODO: Use a static variable so this function returns
    // 1 on its first call, 2 on its second call, and so on.
        static $ticket = 0;

    $ticket++;

    return $ticket;
}

// TODO: Call the function at least twice.
echo "First ticket: " . nextTicketNumber() . "<br>";
echo "Second ticket: " . nextTicketNumber() . "<br>";

// 5. User Class
echo '<h2>5. User Class</h2>';

class User
{
    public $name;
    public $email;

    // TODO: Create a display() method that returns the user's name.
        public function display()
    {
        return $this->name;
    }
}

// TODO: Create a User object.
// TODO: Assign a name and email.
// TODO: Display the result of the display() method.
$user = new User();

$user->name = "Maria Chen";
$user->email = "maria@example.com";

echo $user->display() . "<br>";

// 6. Constructor and Password Hashing
echo '<h2>6. Constructor and Password Hashing</h2>';

class User2
{
    public $name;
    private $passwordHash;

    // TODO: Create a constructor that receives a name and password.
    // Store the name and create a password hash using password_hash().
        public function __construct($name, $password)
    {
        $this->name = $name;
        $this->passwordHash = password_hash($password, PASSWORD_DEFAULT);
    }
}

// TODO: Create one User2 object and display it using print_r().
$user2 = new User2("Maria Chen", "TestPassword123!");

echo "<pre>";
print_r($user2);
echo "</pre>";