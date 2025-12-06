<?php
$pdo = new PdoMethods();
$msg = "";
$tbody = "";

if(isset($_POST['delete'])){
    if(isset($_POST['chkbx'])){
        foreach($_POST['chkbx'] as $id){
            $sql = "DELETE FROM contacts WHERE id = :id";
            $bindings = [[':id', $id, 'int']];
            $result = $pdo->otherBinded($sql, $bindings);
        }
        if($result == 'noerror'){
            $msg = "Contact(s) deleted";
        } else {
            $msg = "Could not delete the contacts";
        }
    }
}

$rows = $pdo->selectBinded("SELECT * FROM contacts", []);

if($rows != 'error' && count($rows) > 0){
    foreach($rows as $row){
        $tbody .= "<tr>
            <td>{$row['fname']}</td>
            <td>{$row['lname']}</td>
            <td>{$row['address']}</td>
            <td>{$row['city']}</td>
            <td>{$row['state']}</td>
            <td>{$row['phone']}</td>
            <td>{$row['email']}</td>
            <td>{$row['dob']}</td>
            <td>{$row['contacts']}</td>
            <td>{$row['age']}</td>
            <td><input type='checkbox' name='chkbx[]' value='{$row['id']}'></td>
        </tr>";
    }
} else {
    $tbody .= "<tr><td colspan='11'>There are no records to display</td></tr>";
}
?>