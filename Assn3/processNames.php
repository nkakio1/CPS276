<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>add names</title>
  </head>
  <body>
    <div class="container">
    <h1>Add Names</h1>
    <form method="post" action="index.php">
    <input type="submit" name="addName" class="btn btn-primary" value="Add Name">
    <input type="submit" name="clearNames" class="btn btn-primary" value="Clear Names">
    <div class="form-group">
      <label for="name">Enter Name</label>
      <input type="text" class="form-control" id="name" name="name" >
    </div>
    <div class="form-group">
      <label for="namelist">List of Names</label>
      <textarea style="height: 500px;" class="form-control" id="namelist" name="namelist"></textarea>
    </div>
    
  </form>
</div>