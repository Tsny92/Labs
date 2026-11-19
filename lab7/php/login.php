<?php
require_once __DIR__.'/../includes/auth.php';startSession();$error=false;
if($_SERVER['REQUEST_METHOD']==='POST'){verifyCsrfToken($_POST);$u=authenticateUser(openDatabase(),field('email'),field('password'));if($u){startLogin($u);header('Location: profile.php',true,303);exit;}$error=true;}
pageStart('Log in');if(isset($_GET['registered']))echo '<p>Account created. Please log in.</p>';if($error)echo '<p class="alert alert-danger">Invalid credentials or inactive account.</p>';echo '<form method="post">'.csrfField();formField('email','Email','email');formField('password','Password','password');echo '<button class="btn btn-primary">Log in</button></form>';pageEnd();
