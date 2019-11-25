<?php include("../db.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
$nameuser = '';
$mailuser = '';
$HOST = 'smtp.gmail.com';
$USERNAMECORREO = 'huellero.wiedii@gmail.com';
$PASSWORDC = 'huella2019wiedii';
$NAMEC = 'Huellero Wiedii';
$PORTC = 587;
$n = $_POST['operacion'];
$user = $_POST['user'];
$subjectmsg = 'Registro huella';
$altbodymsg = 'Registro exitoso';
if (!empty($user)) {
    if (isset($_POST['operacion'])) {
        $query = "SELECT * FROM usuarios WHERE huella=$user";
        $resultr = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($resultr);
        $nameuser = $row['nombre_usu'];
        $mailuser = $row['correo'];
        $iduser = $row['id'];
        if (mysqli_num_rows($resultr) == 1) {
            switch ($n) {
                case 'registro':
                    $query = "SELECT COUNT(Fecha) AS total 
                                FROM registro 
                                WHERE id='$iduser' 
                                and Fecha=CURDATE()";
                    $resultm = mysqli_query($conn, $query);
                    $var = mysqli_fetch_assoc($resultm);
                    $num = $var['total'];
                    if ($num == 0) {
                        $getin = "INSERT INTO registro (Fecha , entry_time, id) 
                                    VALUES (CURDATE(), CURTIME(),'$iduser')";
                        $result = mysqli_query($conn, $getin);
                        if ($result) {
                            //         $alertmsg = "<script>
                            // alert('Se ha registrado de forma correcta');location.href='../index.php'</script>";
                            echo "<script>alert('Se ha registrado de forma correcta');
                            location.href='../index.php'</script>";
                            // $bodymesage = 'Su ingreso ha sido registrado de forma correcta' . date(": d/m/Y-h:i:sa");
                        } else echo ("<script>
                            alert('No ha guardado, error en la base de datos');window.history.back()</script>");
                    } else {

                        $query = "SELECT  Id_fecha, departure_time, TIMEDIFF(CURTIME(), departure_time), 
                                            TIMEDIFF(CURTIME(), entry_time) 
                                    FROM registro 
                                    WHERE id= '$iduser'
                                    and Fecha=CURDATE()  
                                    GROUP BY  Id_fecha, departure_time 
                                    ORDER BY Id_fecha DESC LIMIT 1";
                        $result = mysqli_query($conn, $query);
                        $row = mysqli_fetch_array($result);
                        $t_out = $row['departure_time'];
                        $id_fecha = $row['Id_fecha'];
                        $time1 = $row['TIMEDIFF(CURTIME(), departure_time)'];
                        $time2 = $row['TIMEDIFF(CURTIME(), entry_time)'];
                        if ($result and ($time1 >= '00:15:00' or $time2 >= '00:15:00')) {
                            if (empty($t_out)) {
                                $query = "UPDATE registro 
                                set departure_time = CURTIME() 
                                WHERE Id_fecha='$id_fecha'";
                                $result = mysqli_query($conn, $query);
                                if ($result) {
                                    //         $alertmsg = "<script>
                                    // alert('Se ha registrado de forma correcta');location.href='../index.php'</script>";
                                    echo "<script>alert('Se ha registrado de forma correcta');
                                    location.href='../index.php'</script>";
                                    // $bodymesage = 'Su salida ha sido registrado de forma correcta'
                                    //     . date(": d/m/Y-h:i:sa");
                                } else echo ("<script>
                                    alert('No ha guardado, error en la base de datos');window.history.back()</script>");
                            } else {
                                $getin = "INSERT INTO registro (Fecha , entry_time, id) 
                                    VALUES (CURDATE(), CURTIME(),'$iduser')";
                                $result = mysqli_query($conn, $getin);
                                if ($result) {
                                    //         $alertmsg = "<script>
                                    // alert('Se ha registrado de forma correcta');location.href='../index.php'</script>";
                                    echo "<script>alert('Se ha registrado de forma correcta');
                                    location.href='../index.php'</script>";
                                    // $bodymesage = 'Su ingreso ha sido registrado de forma correcta'
                                    //     . date(": d/m/Y-h:i:sa");
                                } else echo ("<script>
                                    alert('No ha guardado, error en la base de datos');window.history.back()</script>");
                            }
                        } else {
                            echo ("<script> alert('Su registro ya fue realizado hace menos de 15 minutos');
                            window.history.back()</script>");
                        }
                    }
                    break;
                case 'correo':

                    $query = "SELECT  Fecha, departure_time, entry_time  
                    FROM registro 
                    WHERE id= '$iduser'
                    and Fecha <= CURDATE() and Fecha >= DATE_SUB(CURDATE(), INTERVAL 15 DAY)
                    GROUP BY  Fecha, departure_time, entry_time  
                    ORDER BY Fecha DESC, entry_time DESC ";
                    $result = mysqli_query($conn, $query);
                    $html = "";
                    $bodymesage = 'Este es el informe de las entradas y salidas de los ultimos 15 dias: 
                        ' . $nameuser . ' 
                    <table class="table table-bordered" style="font-size: 25px;"id="tablausu">
                        <thead>
                        <tr>
                            <th>Fecha de ingreso</th>
                            <th>Hora de ingreso</th>
                            <th>Hora de salida</th>
                        </tr> </thead>
                        <tbody>
                        ';
                    while ($row = mysqli_fetch_assoc($result)) {
                        $bodymesage .= '
                            <tr>
                                <td>' . $row['Fecha'] . '</td>
                                <td>' . $row['entry_time'] . '</td>
                                <td>' . $row['departure_time'] . '</td>
                            </tr>';
                    }
                    $bodymesage .= '</tbody></table>';
                    $alertmsg = "<script>
                    alert('Su registro se ha enviado de forma correcta');location.href='../index.php'</script>";

                    $mail = new PHPMailer(true);
                    try {

                        $mail->SMTPDebug = 0;
                        $mail->isSMTP();
                        $mail->Host       = $HOST;
                        $mail->SMTPAuth   = true;
                        $mail->Username   = $USERNAMECORREO;
                        $mail->Password   = $PASSWORDC;
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port       = $PORTC;
                        $mail->setFrom($USERNAMECORREO, $NAMEC);
                        $mail->addAddress($mailuser, $nameuser);
                        $mail->isHTML(true);
                        $mail->Subject = $subjectmsg;
                        $mail->Body    = $bodymesage;
                        $mail->AltBody = $altbodymsg;
                        $mail->send();
                        echo $alertmsg;
                    } catch (Exception $e) {
                        echo "<script>alert('El mensaje no pudo ser enviado. Mailer Error: {$mail->ErrorInfo}');
                            window.history.back()</script>";
                    }
                    break;
            }
        } else echo ("<script>
        alert('La huella no se reconoce');location.href='../index.php'</script>");
    }
} else echo ("<script>
        alert('El campo esta vacio');window.history.back()</script>");
?>