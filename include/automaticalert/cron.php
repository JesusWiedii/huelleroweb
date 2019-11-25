<?php include("../../db.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
$nameuser = '';
$mailuser = '';
$HOST = 'smtp.gmail.com';
$USERNAMECORREO = 'huellero.wiedii@gmail.com';
$PASSWORDC = 'huella2019wiedii';
$NAMEC = 'Huellero Wiedii';
$PORTC = 587;
$bodymesage = 'hola';
$subjectmsg = 'Registro huella';
$altbodymsg = 'Registro exitoso';
// $nameuser = 'tiburoncin';
// $mailuser = 'jesus.becerra@wiedii.co';


$query = "SELECT a.id, TIMEDIFF(CURTIME(), h_entry), TIMEDIFF(CURTIME(), h_departure), 
            TIMEDIFF(CURTIME(), h_d_lunch),TIMEDIFF(CURTIME(), h_e_lunch)
        FROM alert a, usuarios u 
        WHERE u.estado='Si'
        and u.id=a.id";
$result = mysqli_query($conn, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $id_user = $row['id'];
        $diff_entry = $row['TIMEDIFF(CURTIME(), h_entry)'];
        $diff_departure = $row['TIMEDIFF(CURTIME(), h_departure)'];
        $diff_d_lunch = $row['TIMEDIFF(CURTIME(), h_d_lunch)'];
        $diff_e_lunch = $row['TIMEDIFF(CURTIME(), h_e_lunch)'];
        

        $query = "SELECT COUNT(Fecha) AS total 
                    FROM registro 
                    WHERE id='$iduser' 
                    and Fecha=CURDATE()";
        $resultm = mysqli_query($conn, $query);
        $var = mysqli_fetch_assoc($resultm);
        $num = $var['total'];
        $querydata = "SELECT nombre_usu, correo 
                    FROM usuarios 
                    WHERE id='$id_user'";
        $resultd = mysqli_query($conn, $querydata);
        $rowd = mysqli_fetch_assoc($resultd);
        $nameuser = $rowd['nombre_usu'];
        $mailuser = $rowd['correo'];
        
        if ($num == 0) {
            if (!empty($diff_entry) &&  $diff_entry<='00:20:00') {
                $correo = 'si';
                $bodymesage = 'El dia de hoy no ha ingresado la huella '
                    . date("d/m/Y");
            } else {
                $correo = 'no';
            }
        }
        else {
            $query = "SELECT  departure_time 
                            FROM registro 
                            WHERE id= '$iduser'
                            and Fecha=CURDATE()  
                            GROUP BY departure_time 
                            ORDER BY Id_fecha DESC LIMIT 1";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_array($result);
            $t_out = $row['departure_time'];
            if (empty($t_out)) {
                if (!empty($diff_e_lunch) && $diff_e_lunch <= '00:10:00' && $diff_e_lunch >= '-00:10:00') {
                    $correo = 'si';
                    $bodymesage = 'No se le olvide registrar la huella para salir a almorzar '
                        . date("d/m/Y");
                } elseif (
                    !empty($diff_departure) &&  $diff_departure <= '00:10:00' &&
                    $diff_departure >= '-00:10:00'
                ) {
                    $correo = 'si';
                    $bodymesage = 'No se le olvide registrar la huella al salir '
                        . date("d/m/Y");
                }
                else {$correo= 'no'; }
            } else {
                if (!empty($diff_d_lunch) && $diff_d_lunch <= '00:10:00' && $diff_d_lunch >= '-00:10:00') {
                    $correo = 'si';
                    $bodymesage = 'No se le olvide registrar la huella que acaba de llegar de almorzar '
                        . date("d/m/Y");
                }
            }
        }
        switch ($correo) {
            case 'si':
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
                case 'no':
                break;
        }
    }
} else {
    echo 'no funciona';
}

?>