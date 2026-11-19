<nav class="navbar navbar-dark bg-primary"><div class="container"><a class="navbar-brand" href="../index.php">Peer Tutoring Hub</a><div class="d-flex gap-3 align-items-center flex-wrap">
<?php if(!empty($user)): ?>
<a class="text-white" href="profile.php">My Profile</a>
<?php if(in_array($user['role'],['Student','Administrator'],true)): ?><a class="text-white" href="requests.php">Requests</a><?php endif; ?>
<?php if($user['role']==='Student'): ?><a class="text-white" href="request-form.php">Request a Session</a><?php endif; ?>
<?php if($user['role']==='Administrator'): ?><a class="text-white" href="manage-users.php">Manage Users</a><?php endif; ?>
<form method="post" action="logout.php"><?=csrfField()?><button class="btn btn-light btn-sm">Log out</button></form>
<?php else: ?><a class="text-white" href="login.php">Login</a><a class="text-white" href="register.php">Register</a><?php endif; ?>
</div></div></nav>
