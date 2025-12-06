<?php
$msg = "";
$pdo = new PdoMethods();

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admins WHERE email = :email";
    $bindings = [[':email', $email, 'str']];
    
    $records = $pdo->selectBinded($sql, $bindings);

    if($records != 'error' && count($records) == 1){
        if(password_verify($password, $records[0]['password'])){
            $_SESSION['access'] = true;
            $_SESSION['name'] = $records[0]['name'];
            $_SESSION['status'] = $records[0]['status'];
            header('Location: index.php?page=welcome');
            exit;
        } else {
            $msg = "Invalid credentials";
        }
    } else {
        $msg = "Invalid credentials";
    }
}
?>