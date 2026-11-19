<?php
if(PHP_SAPI!=='cli'){http_response_code(404);exit;}
require_once __DIR__.'/../config/db.php';require_once __DIR__.'/../services/userService.php';if($argc!==4){fwrite(STDERR,"Usage: php create-admin.php NAME EMAIL PASSWORD\n");exit(1);}try{$pdo=openDatabase();$id=registerUser($pdo,$argv[1],$argv[2],$argv[3],$argv[3],'Administrator',true);$u=findUserById($pdo,$id);echo 'Created '.$u['email'].' — '.$u['role'].PHP_EOL;}catch(Throwable $e){fwrite(STDERR,$e->getMessage().PHP_EOL);exit(1);}
