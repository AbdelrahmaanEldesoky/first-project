<?php
ob_start();
session_start();

    include 'init.php';


?>




    <div class=" card-deck col-sm-4 col-md-8  ">
<?php foreach (getItemHome() as $item){?>
    <div class="card">
        <img src="..." class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title"><?php echo $item['name'];?></h5>
            <p class="card-text"><?php echo $item['description'];?></p>
            <p class="card-text"><small class="text-muted"><?php echo $item['date'];?></small></p>
        </div>
    </div>
<?php }?>

</div>










<?php require_once  $tpl . 'footer.php';?>