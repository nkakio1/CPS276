<?php require_once 'includes/navigation.php'; ?>
<h1>Add Contact</h1>
<?php echo $msg; ?>
<form method="post" action="index.php?page=addContact">
    
    <div class="row mb-3">
        <div class="col-md-6">
            <?php echo $sticky->renderInput($config['fname']); ?>
        </div>
        <div class="col-md-6">
            <?php echo $sticky->renderInput($config['lname']); ?>
        </div>
    </div>
    
    <div class="mb-3">
        <?php echo $sticky->renderInput($config['address']); ?>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <?php echo $sticky->renderInput($config['city']); ?>
        </div>
        <div class="col-md-6">
            <?php echo $sticky->renderSelect($config['state']); ?>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-4">
            <?php echo $sticky->renderInput($config['phone']); ?>
        </div>
        <div class="col-md-4">
            <?php echo $sticky->renderInput($config['email']); ?>
        </div>
        <div class="col-md-4">
            <?php echo $sticky->renderInput($config['dob']); ?>
        </div>
    </div>

    <div class="mb-3">
        <?php echo $sticky->renderRadio($config['age'], '', 'horizontal'); ?>
    </div>

    <div class="mb-3">
        <?php echo $sticky->renderCheckboxGroup($config['contacts'], '', 'horizontal'); ?>
    </div>

    <button type="submit" name="addContact" class="btn btn-primary">Add Contact</button>
</form>