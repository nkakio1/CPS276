<h1>Login</h1>

<?php if($loginErr): ?>
    <div class="text"><?php echo $loginErr; ?></div>
<?php endif; ?>

<form method="post" action="index.php?page=login">
    
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="text" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>">
        <span class="text-danger"><?php echo $emailErr; ?></span>
    </div>

    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control">
        <span class="text-danger"><?php echo $passwordErr; ?></span>
    </div>

    <button type="submit" name="login" class="btn btn-primary">Login</button>
</form>