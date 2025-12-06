<?php require_once 'includes/navigation.php'; ?>
<h1>Delete Admin(s)</h1>
<?php if($msg) echo "<p>$msg</p>"; ?>
<form method="post" action="index.php?page=deleteAdmins">
    <button type="submit" name="delete" class="btn btn-danger mb-3">Delete</button>
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Password</th>
                <th>Status</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php echo $tbody; ?>
        </tbody>
    </table>
</form>