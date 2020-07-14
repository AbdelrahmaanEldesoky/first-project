<?php
session_start();
$noNevbar = '';
$pageTitle = 'LogIN';


if(isset($_SESSION['Admin'])){
    header("Location: home.php");
}

require_once 'init.php';



//check user coming in http post

if($_SERVER['REQUEST_METHOD']=='POST'){
    $Admin = $_POST["user"];
    $password =sha1($_POST["pass"]);




    //check if the user in database
    $stm= DB("SELECT * FROM 
                                            `user`
                                        WHERE     
                                            userName = ?
                                        AND 
                                            password = ?
                                        AND 
                                            groupId = 1",
                                        [$Admin,$password]);
     $row =$stm->fetch();
     $Sql = $stm->rowCount();

    // if count > 0 mean the database record this user

    if ($Sql > 0){
     //   echo $Sql;
        $_SESSION['userId'] = $row['userId'];
        $_SESSION['Admin'] = $Admin;

       header("Location:home.php");
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
<?php require_once  $tpl . 'footer.php';?>