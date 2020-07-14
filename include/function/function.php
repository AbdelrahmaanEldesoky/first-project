<?php
/*
 * ASC
 * DESC
 */
/*
 * get categories function
 */

    function getCateg(){
        $getCateg= DB("SELECT * FROM  categories");
        $categories= $getCateg->fetchAll();
           return $categories;
}

function getItemHome($limit=5){
    $getItemHome= DB("SELECT * FROM `item` ORDER BY idItem DESC  LIMIT $limit  ");
    $items= $getItemHome->fetchAll();
    return $items;
}

/*
 * get categories function
 */

function getItem($idcat){
    $getItem= DB("SELECT * FROM `item` where idCat = ? ORDER BY idItem DESC ",[$idcat]);
    $item= $getItem->fetchAll();
    return $item;
}

/*
 * function get title to page v1.0
 */
function getTitle(){
    global $pageTitle;
    if(isset($pageTitle)){echo $pageTitle;}
    else{echo 'default';}
}

/*
 * Home Redirect function v0.1
 * [function accept parameter]
 * $errorMsg = echo the error message
 * $sec = seconds before redirect
 */

function RedirectHome($error,$url=null,$second = 3,$link=null){
   echo $error;
   echo "<div class='alert alert-success' role='alert'>you will redirect after $second</div>";

   if(($url == null) &&($link==null)){
       $url ='home.php';
   }elseif($url == 'back'){
       $url = (isset($_SERVER['HTTP_REFERER'])&&$_SERVER['HTTP_REFERER']='') ? $_SERVER['HTTP_REFERER'] : 'home.php';
   }else{
       $url = $link;
   }


   header("refresh:$second;url=$url");
   exit();
}

/*
 * check item function v1.0
 * check item in database
 * [function accept parameter]
 */

function checkUser($select,$table,$value){
    global $con;
    $stmCheck = DB("SELECT  $select FROM `$table` WHERE $select = ?",[$value]);
    $count = $stmCheck->rowCount();
     return $count;
}


/*
 * count function v1.0
 * function count item
 */

function countItem($item,$table){
    $stmCount = DB("SELECT COUNT($item) FROM `$table`");
    return $stmCount->fetchColumn();
}
/*
 * function last user records
 */

function getRecord($select,$table,$order,$limit=5){
   $stmGet = DB("SELECT $select FROM `$table` ORDER BY $order DESC LIMIT $limit ");
    return $stmGet->fetchAll();
}



