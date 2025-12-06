<?php
$pdo = new PdoMethods();
$msg = "";
$tbody = "";

if(isset($_POST['delete'])){
    if(isset($_POST['chkbx'])){
        foreach($_POST['chkbx'] as $id){
            $sql = "DELETE FROM admins WHERE id = :id";
            $bindings = [[':id', $id, 'int']];
            $result = $pdo->otherBinded($sql, $bindings);
        }
        if($result == 'noerror'){
            $msg = "Admin(s) deleted";
        } else {
             $msg = "Could not delete the admins";
        }
    }
}

$rows = $pdo->selectBinded("SELECT * FROM admins", []);

if($rows != 'error' && count($rows) > 0){
    foreach($rows as $row){
        $tbody .= "<tr>
            <td>{$row['name']}</td>
            <td>{$row['email']}</td>
            <td>{$row['password']}</td>
            <td>{$row['status']}</td>
            <td><input type='checkbox' name='chkbx[]' value='{$row['id']}'></td>
        </tr>";
    }
} else {
    $tbody .= "<tr><td colspan='5'>There are no records to display</td></tr>";
}
?>