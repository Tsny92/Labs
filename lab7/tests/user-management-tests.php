<?php
require_once __DIR__.'/../includes/auth.php';
$pdo=openDatabase(':memory:');foreach(['setup-database.sql','upgrade-to-user-management.sql'] as $f)$pdo->exec(file_get_contents(__DIR__.'/../database/'.$f));
$failed=0;function check($ok,$label){global $failed;echo ($ok?'PASS ':'FAIL ').$label.PHP_EOL;if(!$ok)$failed++;}function blocked($fn){try{$fn();return false;}catch(InvalidArgumentException $e){return true;}}
$p='ClassroomPassword123';$a=registerUser($pdo,'Admin','admin@example.com',$p,$p,'Administrator',true);$s=registerUser($pdo,'Student','student@example.com',$p,$p,'Student');$t=registerUser($pdo,'Tutor','tutor@example.com',$p,$p,'Tutor');
check(findUserById($pdo,$s)['status']==='Active'&&studentForUser($pdo,$s)&&findUserById($pdo,$t)['role']==='Tutor','UM-01 student and tutor registration');
check(blocked(fn()=>registerUser($pdo,'Duplicate','student@example.com',$p,$p,'Student')),'UM-01 duplicate email');
check(blocked(fn()=>registerUser($pdo,'Fake','fake@example.com',$p,$p,'Administrator')),'UM-01 public admin denied');
check(blocked(fn()=>registerUser($pdo,'Fake','fake@example.com','short','short','Student')),'UM-01 short password denied');
check(findUserById($pdo,$s)['email']==='student@example.com','UM-02 profile lookup');
check(count(searchUsers($pdo,'Student','Student','Active'))===1,'UM-03 search and filters');
saveProfile($pdo,$s,'Updated','updated@example.com');check(studentForUser($pdo,$s)['student_email']==='updated@example.com'&&findUserById($pdo,$s)['role']==='Student','UM-04 profile synchronization');
check(blocked(fn()=>changePassword($pdo,$s,'wrong',$p,$p)),'UM-05 wrong current password');
changePassword($pdo,$s,$p,'NewClassroomPassword123','NewClassroomPassword123');check(!authenticateUser($pdo,'updated@example.com',$p)&&authenticateUser($pdo,'updated@example.com','NewClassroomPassword123'),'UM-05 old password fails, new succeeds');
check(blocked(fn()=>changeAccess($pdo,$s,$t,'Administrator','Active')),'UM-06 non-admin denied');changeAccess($pdo,$a,$t,'Student','Active');check(studentForUser($pdo,$t)!==false,'UM-06 role change creates student link');
changeAccess($pdo,$a,$t,'Student','Inactive');check(!authenticateUser($pdo,'tutor@example.com',$p),'UM-07 inactive login denied');check(blocked(fn()=>changeAccess($pdo,$a,$a,'Administrator','Inactive')),'UM-07 last active administrator protected');
check(blocked(fn()=>deleteAccount($pdo,$a,$t))&&findUserById($pdo,$t),'UM-08 deletion blocked by policy');
check(authenticateUser($pdo,'admin@example.com',$p)&&!authenticateUser($pdo,'admin@example.com','wrong'),'UM-09 credentials verified');
$input=['course'=>'IS 6465','reason'=>'Help with PHP forms please.','topics'=>['Exam review'],'preferreddate'=>date('Y-m-d',strtotime('+10 days')),'preferredtime'=>'Morning','student_email'=>'forged@example.com'];$id=submitAuthenticatedRequest($pdo,findUserById($pdo,$s),$input);check(findRequest($pdo,$id,$s)&&!findRequest($pdo,$id,$t),'UC01 ownership and forged identity ignored');check(count(listRequests($pdo,'','',$s))===1,'UC02 own requests only');check(blocked(fn()=>deleteAccount($pdo,$a,$s)),'UM-08 related records block deletion');
$_SESSION=['csrf_token'=>'test'];check(validCsrf(['csrf_token'=>'test'])&&!validCsrf(['csrf_token'=>'bad'])&&!validCsrf([]),'CSRF comparison');
echo "UM-10 and browser session regeneration require manual HTTP tests.\n";exit($failed?1:0);
