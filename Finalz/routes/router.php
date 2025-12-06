<?php
// Security Logic
if ($page === 'login') {
    require_once 'controllers/loginProc.php'; // Logic for login
    require_once 'views/loginForm.php';       // The form view
} 
else {
    // If not logged in, redirect to login
    if (!isset($_SESSION['access']) || $_SESSION['access'] !== true) {
        header('Location: index.php?page=login');
        exit;
    }

    // Routing Logic
    if ($page === 'welcome') {
        require_once 'views/welcome.php';
    }
    elseif ($page === 'addContact') {
        require_once 'controllers/addContactProc.php';
        require_once 'views/addContactForm.php';
    }
    elseif ($page === 'deleteContacts') {
        require_once 'controllers/deleteContactProc.php';
        require_once 'views/deleteContactsTable.php';
    }
    elseif ($page === 'addAdmin') {
        if ($_SESSION['status'] !== 'admin') {
            header('Location: index.php?page=login');
            exit;
        }
        require_once 'controllers/addAdminProc.php';
        require_once 'views/addAdminForm.php';
    }
    elseif ($page === 'deleteAdmins') {
        if ($_SESSION['status'] !== 'admin') {
            header('Location: index.php?page=login');
            exit;
        }
        require_once 'controllers/deleteAdminProc.php';
        require_once 'views/deleteAdminTable.php';
    }
    elseif ($page === 'logout') {
        session_unset();
        session_destroy();
        header('Location: index.php?page=login');
        exit;
    }
    else {
        header('Location: index.php?page=login');
        exit;
    }
}
?>