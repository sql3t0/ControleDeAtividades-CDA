<?php
/*
 * TIPOS DE OPCAO
 * -> start_timer 
 * -> save_time
*/

function ControlTimer($opt,$id,$nome){
    include("conexao.php");

    if ($opt == "start_timer") {
        $date = new DateTime();
        $time_stamp = $date->getTimestamp();
        //sql p/ criar nova linha na tabela timer
        $new_time_sql = "INSERT INTO timer VALUES ('".$id."','".$nome."', '00:00:00')";
        $conn->query($new_time_sql);
        //sql p/ criar nova linha na tabela de time_stamps
        $sql = "INSERT INTO time_stamps VALUES ('".$id."', '{$time_stamp}')";
        $result = $conn->query($sql);
        //sql p/ alterar o status_time na tabela de Tarefa
        $sql_alt_status = "UPDATE tarefa SET status_time = '1' WHERE id =".$id;//id_atividade
        $conn->query($sql_alt_status);

        $status = "iniciado";
    } elseif ($opt == "save_time") {
        $sql = "SELECT * FROM time_stamps WHERE id =".$id;
        $result = $conn->query($sql);

        $old_time_stamp;
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $old_time_stamp = $row["time_stamp"];
            }
        }

        $sql = "DELETE FROM time_stamps WHERE id =".$id;//id_ativiadade
        $result = $conn->query($sql);

        $date = new DateTime();
        $time_stamp = $date->getTimestamp();
        $new_time = explode(":", date('H:i:s', ($time_stamp - $old_time_stamp)));
        echo $time_stamp." - ".$old_time_stamp." = ".$new_time;
        
        $sql = "SELECT * FROM timer WHERE id =".$id;//id_atividade
        $result = $conn->query($sql);

        $old_time;
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $old_time = explode(":", $row["time"]);
            }
        }

        $hour = intval($old_time[0] + $new_time[0]);
        $minute = intval($old_time[1] + $new_time[1]);
        $second = intval($old_time[2] + $new_time[2]);
        while ($second >= 60) {
            $second = $second - 60;
            $minute++;
        }
        while ($minute >= 60) {
            $minute = $minute - 60;
            $hour++;
        }
        if ($second < 10)
            $second = "0" . strval($second);
        if ($minute < 10)
            $minute = "0" . strval($minute);
        if ($hour < 10)
            $hour = "0" . strval($hour);
 
        $time = "{$hour}:{$minute}:{$second}";

        $sql = "UPDATE timer SET time = '{$time}' WHERE id =".$id;//id_atividade
        $result = $conn->query($sql);

        $status = "encerrado";
    }
    $conn->close();

    return $status;
}

?>