<?php

session_start();

$pageTitle = 'LogIN';


if(isset($_SESSION['user'])){
    header("Location: index.php");
}

require_once 'init.php';

$do = isset($_GET['do']) ? $_GET['do'] : 'login';

if ($do == 'login'){

//check user coming in http post

if($_SERVER['REQUEST_METHOD']=='POST'){
    $user = $_POST["user"];
    $pass =sha1($_POST["pass"]);




    //check if the user in database
    $stm= DB("SELECT * FROM 
                                            `user`
                                        WHERE     
                                            userName = ?
                                        AND 
                                            password = ?
                                        AND 
                                            groupId = 0",
        [$user,$pass]);
    $row =$stm->fetch();
    $Sql = $stm->rowCount();

    // if count > 0 mean the database record this user

    if ($Sql > 0){
        //   echo $Sql;
        $_SESSION['userId'] = $row['userId'];
        $_SESSION['user'] = $user;

        header("Location: index.php");
        exit();
    }
}
?>

    <div class="container">
        <div class="signIn">sign in</div>
        <div class="fold">
            <form action="" method="POST">
                <input type="text" class="form-control" name="user" placeholder="username">
                <input type="password" class="form-control" name="pass" placeholder="password">
                <input type="submit" value="Login">
            </form>
        </div>
    </div>
    </div>
<?php }elseif ($do == 'signup'){
?>


    <form class="container col-sm-6" action="" method="POST">
        <div class="form-group">
            <label >User Name</label>
            <input type="text" name="name" required="required"  class="form-control" >
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" name="email"  class="form-control" >
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" name="password" required="required" class="form-control"  >
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" name="confirmPassword" required="required" class="form-control"  >
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>

    <?php


//check user coming in http post

    $frameError= array();
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $user = (!empty ($_POST['name'])) ? $_POST['name'] : $frameError[]='<div class="alert alert-danger" role="alert">your Name is empty</div>' ;
        $Email = (!empty($_POST['email'])) ? $_POST['email'] : $frameError[]='<div class="alert alert-danger" role="alert">your Email is empty</div>';
        $Pass = ($_POST['password'] == $_POST['confirmPassword']) ? sha1($_POST['password']) : $frameError[]='<div class="alert alert-danger" role="alert">your password is invalid</div>';


        foreach ($frameError as $error){
            echo $error . '<br/>';
        }

        if(empty($frameError)){
            $check = checkUser('userName','user',$user);
            if($check > 0 ){
                $error ='change this name';
                RedirectHome($error,'back');
            }else{
                $stm =DB("INSERT INTO `user` (`userName`,`email`,`password`,`date`) VALUES (?,?,?,now())",[ $user, $Email, $Pass]);
               $Sql= $stm->rowCount();

                if ($Sql > 0){
                    //   echo $Sql;
                    $_SESSION['userId'] = $Sql['userId'];
                    $_SESSION['user'] = $user;

                    header("Location: index.php");
                    exit();
                }

            }
        }



    }
}


    ?>

<?php require_once  $tpl . 'footer.php';?>