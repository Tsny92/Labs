<?php
function userQuery($pdo,$sql,$args=[]){$s=$pdo->prepare($sql);$s->execute($args);return $s;}
function findUserById($pdo,$id){return userQuery($pdo,'SELECT * FROM users WHERE user_id=?',[$id])->fetch();}
function findUserByEmail($pdo,$email){return userQuery($pdo,'SELECT * FROM users WHERE email=?',[$email])->fetch();}
function insertUser($pdo,$name,$email,$hash,$role){userQuery($pdo,'INSERT INTO users(full_name,email,password_hash,role) VALUES(?,?,?,?)',[$name,$email,$hash,$role]);return (int)$pdo->lastInsertId();}
function searchUsers($pdo,$q='',$role='',$status=''){return userQuery($pdo,"SELECT user_id,full_name,email,role,status FROM users WHERE (full_name LIKE ? OR email LIKE ?) AND (?='' OR role=?) AND (?='' OR status=?) ORDER BY full_name",['%'.$q.'%','%'.$q.'%',$role,$role,$status,$status])->fetchAll();}
function updateUserProfile($pdo,$id,$name,$email){userQuery($pdo,'UPDATE users SET full_name=?,email=? WHERE user_id=?',[$name,$email,$id]);userQuery($pdo,'UPDATE students SET student_name=?,student_email=? WHERE user_id=?',[$name,$email,$id]);}
function updateUserPassword($pdo,$id,$hash){userQuery($pdo,'UPDATE users SET password_hash=? WHERE user_id=?',[$hash,$id]);}
function updateUserAccess($pdo,$id,$role,$status){userQuery($pdo,'UPDATE users SET role=?,status=? WHERE user_id=?',[$role,$status,$id]);}
function activeAdminCount($pdo){return (int)userQuery($pdo,"SELECT COUNT(*) FROM users WHERE role='Administrator' AND status='Active'")->fetchColumn();}
function relatedRequestCount($pdo,$id){return (int)userQuery($pdo,'SELECT COUNT(*) FROM tutoring_requests r JOIN students s ON s.student_id=r.student_id WHERE s.user_id=?',[$id])->fetchColumn();}
function studentForUser($pdo,$id){return userQuery($pdo,'SELECT * FROM students WHERE user_id=?',[$id])->fetch();}
function createStudentLink($pdo,$id,$name,$email){userQuery($pdo,'INSERT INTO students(student_name,student_email,user_id) VALUES(?,?,?)',[$name,$email,$id]);}
