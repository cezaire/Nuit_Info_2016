<?php
/**
 * Created by PhpStorm.
 * User: Yann
 * Date: 01/12/2016
 * Time: 23:38
 */


$base = new mysqli("127.0.0.1", "root", "", "ni2016");
if ($base->connect_errno) {
    echo "Echec lors de la connexion à MySQL : (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
    $sql="SELECT * FROM camp_webgl";
    $res = mysqli_query($base,$sql);
    $i=1;
while($resultat=mysqli_fetch_assoc($res)) {
    $tableau[$i] = $resultat;
    $i++;
}
echo json_encode($tableau);
?>