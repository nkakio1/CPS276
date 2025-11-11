<?php
require_once 'Classes/StickyForm.php';
$sticky = new StickyForm();
$sticky->handleRequest($_POST ?? []);
/*

    Why does StickyForm extend Validation instead of including validation logic directly? What are the benefits of this design?

    Explain what "sticky form" means. How does it improve user experience compared to a non-sticky form?

    Describe the validation process. When does validation occur, and what happens if validation fails?

    Explain the purpose of the $formConfig array. What information does it store, and how is it used throughout the form lifecycle?

    What is the purpose of masterStatus['error'] in the form configuration? How does it coordinate validation across multiple form fields?

*/
?>
<html><head>
    <title>Sticky Form Assignment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<div class="container mt-5">
<p>&nbsp;</p>

<?= $sticky->flashError() ?>
<?= $sticky->flashSuccess() ?>

<form method="post" action="">
        <div class="row">
             <div class="col-md-6">
                <div class="mb-3">
    <label for="first_name">First Name</label>
    <input type="text" class="form-control" id="first_name" name="firstName" value="<?= $sticky->v('firstName') ?>">
    <?= $sticky->e('firstName') ?>
</div>            </div>

             <div class="col-md-6">
                <div class="mb-3">
    <label for="last_name">Last Name</label>
    <input type="text" class="form-control" id="last_name" name="lastName" value="<?= $sticky->v('lastName') ?>">
    <?= $sticky->e('lastName') ?>
</div>            </div>
        </div>

         <div class="row">
            <div class="col-md-4">
                <div class="mb-3">
    <label for="email">Email</label>
    <input type="text" class="form-control" id="email" name="email" value="<?= $sticky->v('email') ?>">
    <?= $sticky->e('email') ?>
</div>            </div>
            <div class="col-md-4">
                <div class="mb-3">
    <label for="password1">Password</label>
    <input type="text" class="form-control" id="password1" name="password1" value="<?= $sticky->v('password1') ?>">
    <?= $sticky->e('password1') ?>
</div>            </div>
            <div class="col-md-4">
                <div class="mb-3">
    <label for="password2">Confirm Password</label>
    <input type="text" class="form-control" id="password2" name="password2" value="<?= $sticky->v('password2') ?>">
    <?= $sticky->e('password2') ?>
</div>            </div>
        </div>

        <input type="submit" class="btn btn-primary" value="Register">
    </form>

    <table class="table table-bordered mt-2">
      <tbody>
        <tr>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email</th>
          <th>Password</th>
        </tr>
        <?= $sticky->renderUserRowsOnly()  ?>
      </tbody>
    </table>
</div>

</body></html>
