<?php
function language($phrase){
    static $language =array(
      'home-admin'=>'Home',
        'categories'=>'Categories',
        'members' => 'Members'
    );
    return $language[$phrase];
}

