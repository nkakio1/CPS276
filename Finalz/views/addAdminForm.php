<?php require_once 'includes/navigation.php'; ?>

<h1>Add Admin</h1>

<?php echo $msg; ?>

<form method="post" action="index.php?page=addAdmin">
    <div class="row mb-3">
        <div class="col-md-6">
            <?php echo $sticky->renderInput($config['fname']); ?>
        </div>
        <div class="col-md-6">
            <?php echo $sticky->renderInput($config['lname']); ?>
        </div>
    </div>
    
    <div class="row mb-3">
        <div class="col-md-4">
            <?php echo $sticky->renderInput($config['email']); ?>
        </div>
        <div class="col-md-4">
            <?php echo $sticky->renderPassword($config['password']); ?>
        </div>
        <div class="col-md-4">
            <?php echo $sticky->renderSelect($config['status']); ?>
        </div>
    </div>
    
    <button type="submit" name="addAdmin" class="btn btn-primary">Add Admin</button>
</form>