<?php
function DB($Statement,$Execute=[],$Type=0,$DB='shop')
{
    $Return = null;
    try
    {
        $conn = new PDO('mysql:host=localhost;dbname='.$DB,'root','',[PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8']); // start a new connect
        $sql = $conn->prepare($Statement);
        if(strtoupper($Type) == 'delete'){
            return $sql;
        }else {
            $sql->execute($Execute);
            return $sql;
        }
        /*
        if ($Sql->rowCount())
        {
            if (strtoupper($Type) === 'GET') $Return = $sql->fetchAll();
            elseif (strtoupper($Type) === 'SET') $Return = 1;
            elseif (strtoupper($Type) === 'ID') $Return = $Conn->lastInsertId();
            else $Return = $Sql;
        }
        */
    }
    /*
     *
     */
    catch (PDOException $e) { print_r($e); } return $Return;
}