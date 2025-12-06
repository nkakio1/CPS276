<nav class="navbar navbar-expand-lg bg-light mb-4">
    <div class="container-fluid">
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link text-primary" href="index.php?page=addContact">Add Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-primary" href="index.php?page=deleteContacts">Delete Contact(s)</a>
                </li>
                
                <?php if(isset($_SESSION['status']) && $_SESSION['status'] === 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link text-primary" href="index.php?page=addAdmin">Add Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-primary" href="index.php?page=deleteAdmins">Delete Admin(s)</a>
                    </li>
                <?php endif; ?>

                <li class="nav-item">
                    <a class="nav-link text-primary" href="index.php?page=logout">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>