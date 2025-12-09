<?php
$email = "";
$emailErr = "";
$passwordErr = "";
$loginErr = "";

if(isset($_POST['login'])){
    
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(empty($email)){
        $emailErr = "You must enter a valid email";
    }
    
    if(empty($password)){
        $passwordErr = "Password is required";
    }

    if(empty($emailErr) && empty($passwordErr)){
        
        require_once 'classes/Pdo_methods.php'; 
        $pdo = new PdoMethods();

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
                $loginErr = "Invalid credentials"; 
            }
        } else {
            $loginErr = "Invalid credentials"; 
        }
    }
}
?>