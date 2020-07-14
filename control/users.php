<?php
ob_start();
session_start();
if (isset($_SESSION['Admin'])) {
    $pageTitle = '';
    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    $frameError=array();
    if ($do == 'Manage'){
        $stm= DB("SELECT * FROM  `user` WHERE  groupId = 0");
        $rows =$stm->fetchAll();
        $Sql = $stm->rowCount();
       ?>
        <div>
            <div class="container">
            <table class="table table-dark">
                <thead>
                <tr>
                    <th scope="col">#ID</th>
                    <th scope="col">userName</th>
                    <th scope="col">Email</th>
                    <th scope="col">Date</th>
                    <th scope="col">control</th>
                </tr>
                </thead>
                <tbody>

                    <?php
                    foreach ($rows as $row){
                        echo '<tr>';
                       echo '<td>' . $row['userId'] . '</td>';
                       echo '<td>' . $row['userName'] . '</td>';
                       echo '<td>' . $row['email'] . '</td>';
                        echo '<td>' . $row['date'] . '</td>';
                       echo '<td>
                        <a class="btn btn-success" href="users.php?do=Edit&userId='. $row['userId'] . ' ">Edit</a>
                        <a class="btn btn-danger" href="users.php?do=Delete&userId='. $row['userId'] . '">Delete</a>
                        </td>';
                       echo '</tr>';}?>
                </tbody>
            </table>
                <a class="btn btn-primary" href="users.php?do=Add">Add new Member</a>
            </div>

        </div>
<?php

    }elseif ($do == 'Add'){
        ?>
        <form class="container col-sm-6" action="?do=Insert" method="POST">
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
            <div class="form-group">
                <label for="exampleInputPassword1">Group ID</label>
                <input type="number" name="groupID"  class="form-control"  >
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>

<?php
    }elseif ($do=='Insert'){
        $frameError= array();
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $userName = (!empty ($_POST['name'])) ? $_POST['name'] : $frameError[]='<div class="alert alert-danger" role="alert">your Name is empty</div>' ;
            $Email = (!empty($_POST['email'])) ? $_POST['email'] : $frameError[]='<div class="alert alert-danger" role="alert">your Email is empty</div>';
            $Password = ($_POST['password'] == $_POST['confirmPassword']) ? sha1($_POST['password']) : $frameError[]='<div class="alert alert-danger" role="alert">your password is invalid</div>';
            $groupId = $_POST['groupID'];

            foreach ($frameError as $error){
                echo $error . '<br/>';
            }

            if(empty($frameError)){
                 $check = checkUser('userName','user',$userName);
                if($check > 0 ){
                    $error ='change this name';
                    RedirectHome($error,'back');
                }else{
                    $stm =DB("INSERT INTO `user` (`userName`,`email`,`password`,`groupId`,`date`) VALUES (?,?,?,?,now())",[ $userName, $Email, $Password,  $groupId]);
                    RedirectHome('done','null','2','users.php?do=Manage');
                }
            }
        }else{
            RedirectHome('you can not open this page directly');
        }

    }elseif ($do == 'Edit'){

        $userID = isset($_GET['userId']) && is_numeric($_GET['userId']) ?  intval($_GET['userId']) : 0;

        $stm= DB("SELECT * FROM `user` WHERE userId = ?" , [$userID]);
        $row =$stm->fetch();
        $Sql = $stm->rowCount();
        if($Sql > 0 ){ ?>

            <form class="container col-sm-6" action="?do=Update" method="POST">
                <input type="hidden" name="ID" value="<?php echo $userID?>">
            <div class="form-group">
                <label >User Name</label>
                <input type="text" name="name" required="required" value="<?php echo $row['userName']?>" class="form-control" >
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" name="email" required="required" value="<?php echo $row['email']?>" class="form-control" >
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="hidden" name="oldPassword" value="<?php echo $row['password']?>" >
                <input type="password" name="newPassword" class="form-control"  >
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
            <?php

        }
    }elseif ($do == 'Delete'){
        $userID = isset($_GET['userId']) && is_numeric($_GET['userId']) ?  intval($_GET['userId']) : 0;

        $stm= DB("SELECT * FROM `user` WHERE userId = ?" , [$userID]);
        $Sql = $stm->rowCount();
        if($Sql > 0 ){
            $stm = DB("DELETE  FROM `user` WHERE userId = :zuser",[],'delete');
            $stm->bindParam(':zuser',$userID);
            $stm->execute();
            echo $stm->rowCount() . ' ok';

        }
    }elseif($do == 'Update') {

        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $Id = $_POST["ID"];
            $Name = $_POST["name"];
            $Email = $_POST["email"];
            $pass = empty($_POST['newPassword']) ? $_POST['oldPassword'] : sha1($_POST['newPassword']);
            if(empty($Name)){
                $frameError[]='<div class="alert alert-danger" role="alert">you name is invalid</div>';
            }
            if(empty($Email)){
                $frameError[]='<div class="alert alert-danger" role="alert">you Email is invalid</div>';
            }
            foreach ($frameError as $error){
                echo $error .' '. '<br/>';
            }
            if( empty($frameError)){
                $stm = DB("UPDATE user SET userName = ? , email = ? , password = ? WHERE userId = ? " ,[$Name,$Email,$pass,$Id]);
                 echo $stm->rowCount();
            }
        }
    }
}else{header('Location: index.php');}


include '../include/template/footer.php';
ob_end_flush();
?>