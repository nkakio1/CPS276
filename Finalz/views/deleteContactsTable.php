<?php require_once 'includes/navigation.php'; ?>
<h1>Delete Contact(s)</h1>
<?php if($msg) echo "<p>$msg</p>"; ?>
<form method="post" action="index.php?page=deleteContacts">
    <button type="submit" name="delete" class="btn btn-danger mb-3">Delete</button>
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Address</th>
                <th>City</th>
                <th>State</th>
                <th>Phone</th>
                <th>Email</th>
                <th>DOB</th>
                <th>Contact</th>
                <th>Age</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php echo $tbody; ?>
        </tbody>
    </table>
</form>