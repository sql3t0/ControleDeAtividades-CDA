<?php
/*
 * TIPOS DE OPCAO
 * -> start_timer 
 * -> save_time
 * -> pause_time
*/

 // Pega a data/hora atual
    $date = new DateTime("now", new DateTimeZone('America/Fortaleza') ); //SET YOUR DATETIMEZONE
    $time_stamp =  $date->format('Y/m/d H:i:s');

    echo 'Time : '.$time_stamp;
    echo '<br/>';
    echo 'TimeStamp : '.strtotime($time_stamp);


?>