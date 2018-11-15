<?php
/*
 * TIPOS DE OPCAO
 * -> start_timer 
 * -> save_time
 * -> pause_time
*/

function ControlTimer($opt,$id,$nome){
    include("conexao.php");

    if ($opt == "start_timer") {
        // Pega a data/hora atual
        $date = new DateTime("now", new DateTimeZone('America/Fortaleza') ); //SET YOUR DATETIMEZONE
        $time_stamp =  $date->format('Y/m/d H:i:s');
        
        $sql = "SELECT time_stamp FROM time_stamps WHERE id =".$id;
        $result = $conn->query($sql);
        $old_time_stamp;
        if ($result->num_rows > 0) {
            //sql p/ criar nova linha na tabela de time_stamps
            $time_stamp = strtotime($time_stamp);
            $sql = "UPDATE time_stamps SET time_stamp = '{$time_stamp}' WHERE id =".$id;
            $result = $conn->query($sql);
            $sql_alt_status = "UPDATE tarefa SET status_time = '1' WHERE id =".$id;//id_atividade ( 1 = PLAY , 0 = PAUSE )
            $conn->query($sql_alt_status);
            $status = "reiniciado"; 
        }else{
            //sql p/ criar nova linha na tabela timer
            $new_time_sql = "INSERT INTO timer VALUES ('".$id."','".$nome."', '0')";
            $conn->query($new_time_sql);
            //sql p/ criar nova linha na tabela de time_stamps
            $time_stamp = strtotime($time_stamp);
            $sql = "INSERT INTO time_stamps VALUES ('".$id."', '{$time_stamp}')";
            $result = $conn->query($sql);
            //sql p/ alterar o status_time na tabela de Tarefa
            $sql_alt_status = "UPDATE tarefa SET status_time = '1' WHERE id =".$id;//id_atividade ( 1 = PLAY , 0 = PAUSE )
            $conn->query($sql_alt_status);

            $status = "iniciado";
        }
        
    } elseif ($opt == "save_time") {
        $sql = "SELECT time_stamp FROM time_stamps WHERE id =".$id;
        $result = $conn->query($sql);

        $old_time_stamp;
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $old_time_stamp = $row["time_stamp"]; 
            }

            $date = new DateTime("now", new DateTimeZone('America/Fortaleza') ); //SET YOUR DATETIMEZONE
            $time_stamp =  $date->format('Y/m/d H:i:s');
            $difer = strtotime($time_stamp) - $old_time_stamp;

            $sql = "SELECT time FROM timer WHERE id =".$id;
            $result = $conn->query($sql);
            $old_timer;
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $old_timer = $row["time"]; 
                }
                $new_time = $difer + $old_timer;
                $sql = "SELECT * FROM timer WHERE id =".$id;//id_atividade
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $sql = "UPDATE timer SET time = '{$new_time}' WHERE id =".$id;//id_atividade
                    $result = $conn->query($sql);  
                    // Apaga a linha da tarefa correspondente
                    $sql = "DELETE FROM time_stamps WHERE id =".$id;//id_ativiadade
                    $result = $conn->query($sql);

                    $status = "encerrado"; 
                }
            }
        }
        
    }elseif ($opt == "pause_time"){
        // Pega a data/hora atual
        $date = new DateTime("now", new DateTimeZone('America/Fortaleza') ); //SET YOUR DATETIMEZONE
        $time_stamp =  $date->format('Y/m/d H:i:s');
        
        $sql = "SELECT time_stamp FROM time_stamps WHERE id =".$id;
        $result = $conn->query($sql);
        $old_time_stamp;
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $old_time_stamp = $row["time_stamp"]; 
            }
            $difer = strtotime($time_stamp) - $old_time_stamp;

            $sql = "SELECT time FROM timer WHERE id =".$id;
            $result = $conn->query($sql);
            $old_timer;
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $old_timer = $row["time"]; 
                }
                $new_time = $difer + $old_timer;
                $sql = "UPDATE timer SET time = '{$new_time}' WHERE id =".$id;//id_atividade
                $result = $conn->query($sql);  
                // Altera p/play o BT da tarefa correspondente
                $sql_alt_status = "UPDATE tarefa SET status_time = '0' WHERE id =".$id;//id_atividade ( 1 = PLAY , 0 = PAUSE )
                $conn->query($sql_alt_status);
                
                $status = "pausado";
                
            }
            
        }else{echo "Erro ! ID : ".$id."nao encontrado !" ;}
    }
    $conn->close();

    return $status;
}

?>