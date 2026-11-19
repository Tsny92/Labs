<?php
require_once __DIR__.'/../config/db.php';
require_once __DIR__.'/../services/userService.php';
require_once __DIR__.'/../services/requestService.php';
function startSession(){if(session_status()===PHP_SESSION_ACTIVE)return;ini_set('session.use_strict_mode','1');ini_set('session.use_only_cookies','1');session_set_cookie_params(['lifetime'=>0,'path'=>'/','secure'=>!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off','httponly'=>true,'samesite'=>'Lax']);session_start();header('Cache-Control: no-store');}
function csrfToken(){startSession();return $_SESSION['csrf_token']??=bin2hex(random_bytes(32));}
function csrfField(){return '<input type="hidden" name="csrf_token" value="'.escapeHtml(csrfToken()).'">';}
function validCsrf($input){return isset($_SESSION['csrf_token'],$input['csrf_token'])&&is_string($input['csrf_token'])&&hash_equals($_SESSION['csrf_token'],$input['csrf_token']);}
function verifyCsrfToken($input){startSession();if(!validCsrf($input)){http_response_code(403);exit('Invalid CSRF token.');}}
function startLogin($u){startSession();session_regenerate_id(true);$_SESSION=['user_id'=>(int)$u['user_id'],'last_activity'=>time()];}
function logoutSession(){startSession();$_SESSION=[];$p=session_get_cookie_params();setcookie(session_name(),'',time()-42000,$p['path'],$p['domain'],$p['secure'],$p['httponly']);session_destroy();}
function requireLogin($pdo){startSession();$u=isset($_SESSION['user_id'])&&time()-($_SESSION['last_activity']??0)<1200?findUserById($pdo,$_SESSION['user_id']):false;if(!$u||$u['status']!=='Active'){logoutSession();header('Location: login.php',true,303);exit;}$_SESSION['last_activity']=time();$_SESSION['display_name']=$u['full_name'];$_SESSION['role']=$u['role'];return $u;}
function requireRole($u,$roles){if(!in_array($u['role'],$roles,true)){http_response_code(403);exit('Not authorized.');}}
function postOnly(){if($_SERVER['REQUEST_METHOD']!=='POST'){http_response_code(405);exit('POST required.');}verifyCsrfToken($_POST);}
function field($name){return is_string($_POST[$name]??null)?$_POST[$name]:'';}
function pageStart($heading){global $user;require __DIR__.'/header.php';require __DIR__.'/nav.php';echo '<main class="container py-4"><h1>'.escapeHtml($heading).'</h1>';}
function pageEnd(){echo '</main>';require __DIR__.'/footer.php';}
function formField($name,$label,$type='text',$value=''){echo '<label class="form-label" for="'.$name.'">'.$label.'</label><input class="form-control mb-3" id="'.$name.'" name="'.$name.'" type="'.$type.'" value="'.escapeHtml($value).'" required>';}
function showError($e){if($e instanceof InvalidArgumentException)$msg=$e->getMessage();else{error_log($e->getMessage());$msg='Unable to save. Check your values or database setup.';}echo '<p class="alert alert-danger">'.escapeHtml($msg).'</p>';}
