<?php
require_once 'classes/Pdo_methods.php';
require_once 'classes/StickyForm.php';

$sticky = new StickyForm();
$msg = "";

$config = [
    'masterStatus' => ['error' => false],
    'fname'   => ['id'=>'fname', 'name'=>'fname', 'type'=>'text', 'label'=>'First Name', 'required'=>true, 'value'=>'', 'regex'=>'name', 'errorMsg'=>'Name must be alpha characters only.'],
    'lname'   => ['id'=>'lname', 'name'=>'lname', 'type'=>'text', 'label'=>'Last Name', 'required'=>true, 'value'=>'', 'regex'=>'name', 'errorMsg'=>'Name must be alpha characters only.'],
    'email'   => ['id'=>'email', 'name'=>'email', 'type'=>'text', 'label'=>'Email', 'required'=>true, 'value'=>'', 'regex'=>'email', 'errorMsg'=>'Invalid email address.'],
    'password'=> ['id'=>'password', 'name'=>'password', 'type'=>'password', 'label'=>'Password', 'required'=>true, 'value'=>'', 'regex'=>'password', 'errorMsg'=>'Password cannot be blank.'],
    'status'  => ['id'=>'status', 'name'=>'status', 'type'=>'select', 'label'=>'Status', 'required'=>true, 'regex'=>'status', 'selected'=>'', 'options'=>[''=>'Select Status', 'staff'=>'Staff', 'admin'=>'Admin']]
];

if(isset($_POST['addAdmin'])){
    
    $config = $sticky->validateForm($_POST, $config);

    
    if($config['password']['required'] && empty($config['password']['value'])){
        $config['password']['error'] = $config['password']['errorMsg'];
        $config['masterStatus']['error'] = true;
    }

    if($config['masterStatus']['error'] == false){
        $pdo = new PdoMethods();
        $sql = "SELECT email FROM admins WHERE email = :email";
        $res = $pdo->selectBinded($sql, [[':email', $config['email']['value'], 'str']]);
        
        if(count($res) > 0){
            $config['email']['error'] = "Email already exists.";
            $config['masterStatus']['error'] = true;
        }
    }

    if($config['masterStatus']['error'] == false){
        
        $fullName = $config['fname']['value'] . " " . $config['lname']['value'];
        $hashed = password_hash($config['password']['value'], PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO admins (name, email, password, status) VALUES (:name, :email, :password, :status)";
        $bindings = [
            [':name', $fullName, 'str'],
            [':email', $config['email']['value'], 'str'],
            [':password', $hashed, 'str'],
            [':status', $config['status']['selected'], 'str']
        ];
        
        $pdo = new PdoMethods();
        $result = $pdo->otherBinded($sql, $bindings);

        if($result == 'noerror'){
            $msg = "<p>Admin Added</p>";
            // Clear the form values on success
            foreach($config as $k => &$v){
                if($k == 'masterStatus') continue;
                if(isset($v['value'])) $v['value'] = '';
                if(isset($v['selected'])) $v['selected'] = '';
            }
        } else {
            $msg = "<p>There was an error adding the record</p>";
        }
    }
}
?>