<?php
require_once __DIR__.'/../includes/auth.php';postOnly();logoutSession();header('Location: login.php',true,303);exit;
