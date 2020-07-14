<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <title><?php getTitle() ?></title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand">Shopping Cart</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#app-nav" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="app-nav">
        <div class="navbar-nav">



            <?php foreach (getCateg() as $categ){
          echo  '<a class="nav-item nav-link active" href="categories.php?pageid='. $categ['id'] . '&pagename='. str_replace(' ','-',$categ['name']) . '">' . $categ["name"] . '<span class="sr-only">(current)</span></a>';
             } ?>
        </div>
    </div>
    <div class="nav navbar-nav navbar">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Abdu</a>
            <ul class="dropdown-menu">
                <?php if(isset($_SESSION['user'])){?>

                <li><a href="#">Edit profile</a></li>
                <li><a href="#">Setting</a></li>
                <li><a href="logout.php">Logout</a></li>
                <?php
                    }else{?>
                <li><a href="loginSignup.php?do=login">login</a></li>
                <li><a href="loginSignup.php?do=signup">SignUp</a></li>
                <?php  }?>
            </ul>
        </li>
    </div>
</nav>



