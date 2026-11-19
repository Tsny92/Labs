<?php
require_once __DIR__.'/../includes/auth.php';startSession();$pdo=openDatabase();$error=null;
if($_SERVER['REQUEST_METHOD']==='POST'){verifyCsrfToken($_POST);try{registerUser($pdo,field('full_name'),field('email'),field('password'),field('confirm_password'),field('role'));header('Location: login.php?registered=1',true,303);exit;}catch(Throwable $e){$error=$e;}}
pageStart('Create account');if($error)showError($error);echo '<form method="post">'.csrfField();formField('full_name','Full name','text',field('full_name'));formField('email','Email','email',field('email'));formField('password','Password (12–72 bytes)','password');formField('confirm_password','Confirm password','password'); ?>
<label>Account type <select name="role" class="form-select"><option>Student</option><option>Tutor</option></select></label><button class="btn btn-primary">Create account</button></form><?php pageEnd(); ?>
