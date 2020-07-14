<?php
//=====================================================================================================================
//any page
//=====================================================================================================================
ob_start();
session_start();
if (isset($_SESSION['userName'])) {
    $pageTitle = '';
    include '../init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

//if the page in mean page

    if ($do == 'Manage') {
        echo 'welcome in Manage';
    } elseif ($do == 'Edit') {
    } elseif ($do == 'Update ') {
        echo 'welcome in Update';
    } elseif ($do == 'Add') {
        echo 'welcome in Add';
    } else {
        echo 'error';
    }
}else{header('Location: index.php');}
ob_end_flush();


