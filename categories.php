<?php
include 'init.php';

?>
<div class="container">
    <h1 class="text-center"><?php echo str_replace( '-',' ',$_GET['pagename']); ?><h1>


        <?php foreach (getItem($_GET['pageid']) as $item){ ?>
          <div class="card">
        <img src="..." class="card-img-top" alt="...">
        <div class="card-body">
            <h3 class="card-title"> <?php echo $item['name'];?></h3>
            <h5 class="card-text"> <?php echo $item['description'];?></h5>
            <h6 class="card-text"><small class="text-muted"></small><?php echo $item['date'] .' ' . ' price ' . $item['price'];?> LE</h6>
        </div>
    </div>


<?php } ?>


</div>