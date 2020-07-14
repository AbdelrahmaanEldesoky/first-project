<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand">Shopping Cart</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#app-nav" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="app-nav">
        <div class="navbar-nav">
            <a class="nav-item nav-link active" href="home.php"><?php echo language('home-admin')?> <span class="sr-only">(current)</span></a>
            <a class="nav-item nav-link " href="categories.php?do=Manage"><?php echo language('categories')?></a>
            <a class="nav-item nav-link " href="users.php?do=Manage"><?php echo language('members')?></a>
            <a class="nav-item nav-link " href="item.php?do=Manage">Item</a>
            <li><a href="logout.php">Logout</a></li>
        </div>
    </div>
    <div class="nav navbar-nav navbar">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Abdu</a>
            <ul class="dropdown-menu">
                <li><a href="users.php?do=Edit&userId=<?php echo $_SESSION['userId']?>">Edit profile</a></li>
                <li><a href="#">Setting</a></li>
            </ul>
        </li>
    </div>
</nav>


