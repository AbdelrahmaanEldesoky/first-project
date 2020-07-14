<?php
//=====================================================================================================================
//any page
//=====================================================================================================================
ob_start();
session_start();
if (isset($_SESSION['Admin'])) {
    $pageTitle = 'Categories';
    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    $frameError=array();
//if the page in mean page

    if ($do == 'Manage') {

        $stm= DB("SELECT * FROM  `categories`");
        $rows =$stm->fetchAll();
        $Sql = $stm->rowCount();

        ?>



        <table class="table table-dark">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Description</th>
      <th scope="col">Order</th>
      <th scope="col">Visibility</th>
      <th scope="col">Comment</th>
      <th scope="col">Ads</th>
    </tr>
  </thead>
            <?php foreach ($rows as $row){?>
  <tbody>
    <tr>
      <th scope="row"><?php echo $row['id']?></th>
      <td><?php echo $row['name'];?></td>
      <td><?php echo $row['description'];?></td>
      <td><?php echo $row['ordaring'];?></td>
      <td><?php if ($row['visibility'] == 0) {echo 'Active';}else{echo 'hidden';}?></td>
      <td><?php if ($row['comment'] == 0) {echo 'Active';}else{echo 'hidden';} ?></td>
      <td><?php if ($row['ads'] == 0) {echo 'Active';}else{echo 'hidden';}  ?></td>
        <td>

            <a class="btn btn-success" href="categories.php?do=Edit&id=<?php echo  $row["id"]   ?> ">Edit</a>
           <a class="btn btn-danger" href="categories.php?do=Delete&id= <?php echo  $row["id"]   ?> ">Delete</a>
        </td>
    </tr>
  </tbody>
            <?php } ?>
</table>
        <?php

       echo '<a class="btn btn-primary" href="categories.php?do=Add">Add new Member</a>';
    } elseif ($do == 'Edit') {

        $ID = isset($_GET['id']) && is_numeric($_GET['id']) ?  intval($_GET['id']) : 0;

        $stm= DB("SELECT * FROM `categories` WHERE id = ?" , [$ID]);
        $row =$stm->fetch();
        $Sql = $stm->rowCount();
        if($Sql > 0 ){ ?>

            <form class="container col-sm-6" action="?do=Update" method="POST">
                <input type="hidden" name="ID" value="<?php echo $ID?>">
                <div class="form-group">
                    <label >Name</label>
                    <input type="text" name="name" required="required" value="<?php echo $row['name']?>" class="form-control" >
                </div>
                <div class="form-group">
                    <label >Description</label>
                    <textarea type="text" name="desc" required="required" value="<?php echo $row['description']?>" class="form-control" ></textarea>
                </div>
                <fieldset class="form-group">
                    <div class="row">
                        <legend class="col-form-label col-sm-2 pt-0">Visible</legend>
                        <div class="col-sm-10">
                            <div class="form-check">

                                <input class="form-check-input" type="radio" name="vis" id="vis-yes" value="0"<?php if($row['visibility']==0){echo 'checked';}?>>
                                <label class="form-check-label" for="vis-yes">
                                    Yes
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="vis" id="vis-no" value="1" <?php if($row['visibility']==1){echo 'checked';}?>>
                                <label class="form-check-label" for="vis-no">
                                    NO
                                </label>
                            </div>
                        </div>
                    </div>
                </fieldset>


                <fieldset class="form-group">
                    <div class="row">
                        <legend class="col-form-label col-sm-2 pt-0">Comment</legend>
                        <div class="col-sm-10">
                            <div class="form-check">

                                <input class="form-check-input" type="radio" name="comm" id="comm-yes" value="0"<?php if($row['comment']==0){echo 'checked';}?>>
                                <label class="form-check-label" for="comm-yes">
                                    Yes
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="comm" id="comm-no" value="1" <?php if($row['comment']==1){echo 'checked';}?>>
                                <label class="form-check-label" for="comm-no">
                                    NO
                                </label>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="form-group">
                    <div class="row">
                        <legend class="col-form-label col-sm-2 pt-0">Ads</legend>
                        <div class="col-sm-10">
                            <div class="form-check">

                                <input class="form-check-input" type="radio" name="ads" id="ads-yes" value="0"<?php if($row['ads']==0){echo 'checked';}?>>
                                <label class="form-check-label" for="ads-yes">
                                    Yes
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="ads" id="ads-no" value="1" <?php if($row['ads']==1){echo 'checked';}?>>
                                <label class="form-check-label" for="ads-no">
                                    NO
                                </label>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
            <?php
        }


    } elseif ($do == 'Update') {

        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $Id = $_POST["ID"];
            $Name = $_POST["name"];
            $Description = $_POST["desc"];
            $Visibility = $_POST["vis"];
            $Comment = $_POST['comm'];
            $ADS = $_POST['ads'];
            echo $Id .  $Name . $Description . $Visibility . $Comment . $ADS ;
            $stm1 = DB("UPDATE categories SET
                                                        name = ?,
                                                        description = ?,
                                                         visibility = ?,
                                                          comment = ?,
                                                           ads = ?
                                                    WHERE  id = ? "
                ,[$Name,$Description,$Visibility,$Comment,$ADS,$Id]);
            echo $stm1->rowCount();


            /*
             * if(empty($Name)){
                $frameError[]='<div class="alert alert-danger" role="alert">you name is invalid</div>';
            }
            if(empty($Email)){
                $frameError[]='<div class="alert alert-danger" role="alert">you Email is invalid</div>';
            }
            foreach ($frameError as $error){
                echo $error .' '. '<br/>';
            }
            if( empty($frameError)){

            }
             *
             */

        }
    } elseif ($do == 'Add') {?>
        <form class="container col-sm-6" action="?do=Insert" method="POST">
            <div class="form-group">
                <label class="col-sm-2 control-label">Name</label>
                <input type="text" name="name" required="required"  class="form-control" >
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Description</label>
                <input type="text" name="dis"  class="form-control" >
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" >ordering</label>
                <input type="number" name="order" class="form-control"  >
            </div>


            <fieldset class="form-group">
                <div class="row">
                    <legend class="col-form-label col-sm-2 pt-0">Visible</legend>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="vis" id="vis-yes" value="0" checked>
                            <label class="form-check-label" for="vis-yes">
                                Yes
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="vis" id="vis-no" value="1">
                            <label class="form-check-label" for="vis-no">
                                NO
                            </label>
                        </div>
                    </div>
                </div>
            </fieldset>
                <fieldset class="form-group">
                            <div class="row">
                                <legend class="col-form-label col-sm-2 pt-0">comment</legend>
                                <div class="col-sm-10">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="comm" id="comm-yes" value="0" checked>
                                        <label class="form-check-label" for="comm-yes">
                                            Yes
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="comm" id="comm-no" value="1">
                                        <label class="form-check-label" for="comm-no">
                                            NO
                                        </label>
                                    </div>
                                </div>
                            </div>

                </fieldset>
                <fieldset class="form-group">
                                        <div class="row">
                                            <legend class="col-form-label col-sm-2 pt-0">ADS</legend>
                                            <div class="col-sm-10">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="ads" id="ads-yes" value="0" checked>
                                                    <label class="form-check-label" for="ads-yes">
                                                        Yes
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="ads" id="ads-no" value="1">
                                                    <label class="form-check-label" for="ads-no">
                                                        NO
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

            </fieldset>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
<?php
    }elseif ($do == 'Delete'){
        $ID = isset($_GET['id']) && is_numeric($_GET['id']) ?  intval($_GET['id']) : 0;
        $stm= DB("SELECT * FROM `categories` WHERE id = ?" , [$ID]);
        $Sql = $stm->rowCount();
        if($Sql > 0 ){
            echo $Sql;
            $stm = DB("DELETE  FROM `categories` WHERE id = :zuser",[],'delete');
            $stm->bindParam(':zuser',$ID);
            $stm->execute();
            echo $stm->rowCount() . ' ok';

        }
    }elseif ($do=='Insert'){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $name = (!empty ($_POST['name'])) ? $_POST['name'] : $frameError[]='<div class="alert alert-danger" role="alert">your Name is empty</div>' ;
            $description = (!empty($_POST['dis'])) ? $_POST['dis'] : $frameError[]='<div class="alert alert-danger" role="alert">your Email is empty</div>';
            $visible = $_POST['vis'];
            $comment = $_POST['comm'];
            $ads = $_POST['ads'];

            foreach ($frameError as $error){
                echo $error . '<br/>';
            }
            if(empty($frameError)){
                $check = checkUser('name','categories',$name);
                if($check > 0 ){
                    $error ='change this name';
                   // RedirectHome($error,'back');
                }else{
                    $stm =DB("INSERT INTO categories (`name`,`description`,`visibility`,`comment`,`ads`) VALUES (?,?,?,?,?)",[ $name, $description, $visible,$comment,$ads]);
                   echo  $stm->rowCount();
                    // RedirectHome('done','null','2','categories.php?do=Manage');
                }
            }
        }else{
            RedirectHome('you can not open this page directly');
        }
    }
}else{header('Location: index.php');}

