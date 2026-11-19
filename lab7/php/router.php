<?php
$path=rawurldecode(parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH)?:'/');
if($path==='/')return false;
if(!preg_match('~^/(?:index\.php|php/[a-z-]+\.php|css/[a-zA-Z0-9_.-]+\.css)$~D',$path)||$path==='/php/router.php'){http_response_code(404);exit('Not found');}
return false;
