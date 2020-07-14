<?php
ob_start();
session_start();
if(isset($_SESSION['Admin'])){
    $pageTitle = 'Home';
    include 'init.php';
    echo '<pre>';
    ?>
    <div class="container mb-3 card-group">
        <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
            <div class="card-body">
                <h1 class="text-center">Members</h1>
                <h1 class="text-center"> <?php echo countItem('userId','user');?></h1>            </div>
  </div>

        <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
    <div class="card-body">
        <h1 class="text-center">Item</h1>
        <h1 class="text-center"> <?php echo countItem('idItem','item');?></h1>
    </div>
  </div>
        <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
    <div class="card-body">
        <h1 class="text-center">Comment</h1>
        <h1 class="text-center"> 200</h1>
    </div>
  </div>
        <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
            <div class="card-body">
                <h1 class="text-center">Categories</h1>
                <h1 class="text-center"> <?php echo countItem('id','categories');?></h1>
            </div>
        </div>
    </div>
</div>

    <div  class="container row row-cols-1 row-cols-md-3">

              <?php $getRecord = getRecord('*','item','name','6');
                    foreach($getRecord as $item){ ?>
                       <div class="col mb-4">
                        <div class="card">
                            <img src="..." class="card-img-top" alt="...">
                            <?php if($item['approve']==0){?>
                                <a class="btn btn-danger" href="item.php?do=Approve&idItem=<?php echo  $item["idItem"];   ?> ">Approve</a>
                            <?php  } ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $item['name']; ?></h5>
                                <p class="card-text"></p>
                                <small class="text-muted">date: <?php echo $item['date']; ?></small>
                            </div>
                            <script> </script>
                            <form action="" method="POST" >
                            <div class="card-footer">
                                <input type="text" class="form-control" name="comment" placeholder="comment">
                            </div>
                            </form>

                        </div>
                       </div>
                    <?php } ?>


    </div>


  <?php
   include '../include/template/footer.php';

}else{
    header("Location: ../index.php");;
}


ob_end_flush();
?>