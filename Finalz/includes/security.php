<?php
if(!isset($_SESSION['access']) || $_SESSION['access'] !== true){
    header('Location: index.php?page=login');
    exit;
}
?>