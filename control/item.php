<?php

//=====================================================================================================================
//any page
//=====================================================================================================================
ob_start();
session_start();
if (isset($_SESSION['Admin'])) {
    $pageTitle = '';
    $frameError=array();
    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

//if the page in mean page

    if ($do == 'Manage') {

        $stm= DB("SELECT 
                                       item.*, categories.name 
                           as          catName,
                                       user.userName 
                           FROM        item 
                           INNER JOIN  categories  
                           ON          categories.id = item.idCat 
                           INNER JOIN  `user`  
                           ON          `user`.userId = item.idUser");
        $rows =$stm->fetchAll();
        $Sql = $stm->rowCount();

        ?>



        <table class="table table-dark">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">date</th>
                <th scope="col">country</th>
                <th scope="col">City</th>
                <th scope="col">price</th>
                <th scope="col">states</th>
                <th scope="col">categories</th>
                <th scope="col">member</th>
            </tr>
            </thead>
            <?php foreach ($rows as $row){?>
                <tbody>
                <tr>
                    <th scope="row"><?php echo $row['idItem']?></th>
                    <td><?php echo $row['name'];?></td>
                    <td><?php echo $row['description'];?></td>
                    <td><?php echo $row['date'];?></td>
                    <td><?php echo $row['country'];?></td>
                    <td><?php echo $row['city'];  ?></td>
                    <td><?php echo $row['price'];  ?></td>
                    <td><?php echo $row['states'];?></td>
                    <td><?php echo $row['catName'];  ?></td>
                    <td><?php echo $row['userName'];?></td>
                    <td>


                        <a class="btn btn-success" href="item.php?do=Edit&idItem=<?php echo  $row["idItem"]   ?> ">Edit</a>
                        <a class="btn btn-danger" href="item.php?do=Delete&idItem=<?php echo  $row["idItem"]   ?> ">Delete</a>
                        <?php if($row['approve']==0){?>
                            <a class="btn btn-danger" href="item.php?do=Approve&idItem=<?php echo  $row["idItem"]   ?> ">Approve</a>
                        <?php } ?>

                    </td>
                </tr>
                </tbody>
            <?php } ?>
        </table>
        <?php

        echo '<a class="btn btn-primary" href="item.php?do=Add">Add new Item</a>';

    }elseif ($do == 'Approve'){



            $idItem = isset($_GET['idItem']) && is_numeric($_GET['idItem']) ? intval($_GET['idItem']) : 0;
            echo $idItem;
            $count = countItem('idItem', 'item');

            if ($count > 0) {
                $stm = DB("UPDATE item SET approve=1 WHERE  idItem = ? ",[$idItem]);
                echo $stm->rowCount();
                RedirectHome('error','back','0');
            }




    } elseif ($do == 'Edit') {

        $idItem = isset($_GET['idItem']) && is_numeric($_GET['idItem']) ?  intval($_GET['idItem']) : 0;

        $stm= DB("SELECT * FROM `item` WHERE idItem = ?" , [$idItem]);
        $row =$stm->fetch();
        $Sql = $stm->rowCount();
        echo $Sql;
        echo $idItem;
        if($Sql > 0 ){ ?>
            <form class="container col-sm-6" action="?do=Update" method="POST">
                <input type="hidden" name="ID" value="<?php echo $idItem?>">
                <div class="form-group">
                    <label >Name Item</label>
                    <input type="text" name="name" required="required" value="<?php echo $row['name']?>" class="form-control" >
                </div>
                <div class="form-group">
                    <label >Description</label>
                    <textarea type="text" name="desc" required="required" value="<?php echo $row['description']?>" class="form-control" ></textarea>
                </div>
                <div class="form-group">
                    <label >Country</label>
                    <input type="text" name="country" required="required" value="<?php echo $row['country']?>" class="form-control" >
                </div>
                <div class="form-group">
                    <label >city</label>
                    <input type="text" name="city" required="required" value="<?php echo $row['city']?>" class="form-control" >
                </div>
                <div class="form-group">
                    <label >price</label>
                    <input type="number" name="price" required="required" value="<?php echo $row['price']?>" class="form-control" >
                </div>

                <div>
                    <label>States</label>
                    <select name="states" class="custom-select" id="inputGroupSelect01">
                        <option selected>...</option>
                        <option value="new">NEW</option>
                        <option value="like new">LIKe NEW</option>
                        <option value="old">OLD</option>
                        <option value="very old">VERY OLD</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
            <?php

        }
    }elseif ($do == 'Delete'){
        $idItem = isset($_GET['idItem']) && is_numeric($_GET['idItem']) ?  intval($_GET['idItem']) : 0;

        $stm= DB("SELECT * FROM `item` WHERE idItem = ?" , [$idItem]);
        $Sql = $stm->rowCount();
        if($Sql > 0 ){
            $stm = DB("DELETE  FROM `item` WHERE idItem = :zuser",[],'delete');
            $stm->bindParam(':zuser',$idItem);
            $stm->execute();
            echo $stm->rowCount() . ' ok';

        }


    } elseif ($do == 'Update ') {


        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $idItem = $_POST["ID"];
            $Name = $_POST["name"];
            $Description = $_POST["desc"];
            $price = $_POST['country'];
            $city = $_POST["city"];
            $country = $_POST["country"];
            $states = $_POST["states"];
            if(empty($Name)){
                $frameError[]='<div class="alert alert-danger" role="alert">item name is invalid</div>';
            }
            if(empty($Description)){
                $frameError[]='<div class="alert alert-danger" role="alert"> Description?? </div>';
            }
            if(empty($price)){
                $frameError[]='<div class="alert alert-danger" role="alert"> price???? </div>';
            }
            if(empty($city)){
                $frameError[]='<div class="alert alert-danger" role="alert"> city?? </div>';
            }
            if(empty($country)){
                $frameError[]='<div class="alert alert-danger" role="alert"> country?? </div>';
            }
            if(empty($states)){
                $frameError[]='<div class="alert alert-danger" role="alert"> state?? </div>';
            }

            foreach ($frameError as $error){
                echo $error .' '. '<br/>';
            }
            if( empty($frameError)){
                $stm = DB("UPDATE user SET
                                                    name = ?,
                                                    description = ?,
                                                    price = ?,
                                                    country = ?,
                                                    city = ?,
                                                    states = ? 
                                             WHERE  idItem = ? "
                                                    ,[$Name,$Description,$price,$country,$city,$states,$idItem]);
                echo $stm->rowCount();
            }
        }

    } elseif ($do == 'Add') {
        echo 'welcome in Add';
        ?>
        <form class="container col-sm-6" action="?do=Insert" method="POST">
            <div class="form-group">
                <label >Item Name</label>
                <input type="text" name="name" required="required"  class="form-control" >
            </div>



            <div class="form-group">
                <label>Description</label>
                <textarea type="text" name="desc"  class="form-control" ></textarea>
            </div>
            <div class="form-group">
                <label>Price</label>
                <input type="number" name="price" required="required" class="form-control"  >
            </div>
            <div class="form-group">
                <label >country</label>
                <input type="text" name="country" required="required" class="form-control"  >
            </div>
            <div class="form-group">
                <label >City</label>
                <input type="text" name="city"  class="form-control"  >
            </div>
        <div>
            <label>States</label>
            <select name="states" class="custom-select" id="inputGroupSelect01">
                <option selected>...</option>
                <option value="new">NEW</option>
                <option value="like new">LIKe NEW</option>
                <option value="old">OLD</option>
                <option value="very old">VERY OLD</option>
            </select>
        </div>
        <div>
            <label>Members</label>
            <select name="member" class="custom-select" id="inputGroupSelect01">
                <?php   $stm= DB("SELECT * FROM `user`");
                $rows =$stm->fetchAll();
                $Sql = $stm->rowCount();
               echo '<option selected>...</option>';
                foreach ($rows as $row ){
                    echo '<option value="' .$row['userId'] .'">'. $row["userName"] . '</option>';
                }
                ?>
            </select>
        </div>
            <div>
                <label>Categories</label>
                <select name="catg" class="custom-select" id="inputGroupSelect01">
                    <?php   $stm= DB("SELECT * FROM `categories`");
                    $rows =$stm->fetchAll();
                    $Sql = $stm->rowCount();
                    echo '<option selected>...</option>';
                    foreach ($rows as $row ){
                        echo '<option value="' .$row['id'] .'">'. $row["name"] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>

        <?php
    }elseif ($do=='Insert') {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $itemName = (!empty ($_POST['name'])) ? $_POST['name'] : $frameError[] = '<div class="alert alert-danger" role="alert">Item Name is empty</div>';
        $Description = (!empty($_POST['desc'])) ? $_POST['desc'] : $frameError[] = '<div class="alert alert-danger" role="alert">put dicreption this item</div>';
        $Price = (!empty($_POST['price'])) ? $_POST['price'] : $frameError[] = '<div class="alert alert-danger" role="alert">price???</div>';
        $country = (!empty($_POST['country'])) ? $_POST['country'] : $frameError[] = '<div class="alert alert-danger" role="alert">country??</div>';
        $City = (!empty($_POST['city'])) ? $_POST['city'] : $frameError[] = '<div class="alert alert-danger" role="alert">city</div>';
        $States = (!empty($_POST['states'])) ? $_POST['states'] : $frameError[] = '<div class="alert alert-danger" role="alert">states??</div>';
        $Member = (!empty($_POST['member'])) ? $_POST['member'] : $frameError[] = '<div class="alert alert-danger" role="alert">states??</div>';
        $Catg = (!empty($_POST['catg'])) ? $_POST['catg'] : $frameError[] = '<div class="alert alert-danger" role="alert">states??</div>';




            foreach ($frameError as $error){
                echo $error . '<br/>';
            }
            if(!empty($frameError)){
               RedirectHome($error,'back');

            }else{
                $stm =DB("INSERT INTO `item` (`name`,`description`,`price`,`country`,`city`,`states`,`idUser`,`idCat`,`date`)
                                   VALUES (?,?,?,?,?,?,?,?,now())",
                    [ $itemName, $Description, $Price, $country,$City,$States,$Member,$Catg]);
                echo $stm->rowCount();
                RedirectHome('done','null','3','users.php?do=Manage');
            }


            }





    } else {
    header('Location: index.php');
        }
}
ob_end_flush();