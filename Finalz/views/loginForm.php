<h1>Login</h1>
<?php if($msg) echo "<p>$msg</p>"; ?>
<form method="post" action="index.php?page=login">
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="text" name="email" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control">
    </div>
    <button type="submit" name="login" class="btn btn-primary">Login</button>
</form>