<?php
/**
 * Created by PhpStorm.
 * User: Yann
 * Date: 01/12/2016
 * Time: 22:16
 */

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Latest compiled and minified JavaScript -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script   src="https://code.jquery.com/jquery-3.1.1.min.js"   integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="   crossorigin="anonymous"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB1TsNTF0YVjxJNe-Tb_6zRXIy8Ey-VZDM"
            type="text/javascript"></script>
    <script src="http://www.webglearth.com/v2/api.js"></script>
    <script>
        var geocoder;
        var earth;
        function initialize() {
            geocoder = new google.maps.Geocoder();
            earth = new WE.map('earth_div');
            WE.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(earth);
            loadmarker();
            /*var marker = WE.marker([51.5, -0.09]).addTo(earth);
             marker.bindPopup("<b>Calais</b><br>Adresse;Remplissage<br /><span style='font-size:10px;color:#999'>Tip: Another popup is hidden in Cairo..</span>", {maxWidth: 150, closeButton: true}).openPopup();
             */
            /*var marker2 = WE.marker([30.058056, 31.228889]).addTo(earth);
             marker2.bindPopup("<b>Cairo</b><br>Yay, you found me!", {maxWidth: 120, closeButton: false});
             */
            //var markerCustom = WE.marker([50, -9], '/img/logo-webglearth-white-100.png', 100, 24).addTo(earth);

            earth.setView([48.856614, 2.3522219000000177], 3);
            var before = null;
            requestAnimationFrame(function animate(now) {
                var c = earth.getPosition();
                var elapsed = before? now - before: 0;
                before = now;
                earth.setCenter([c[0], c[1] + 0.1*(elapsed/30)]);
                requestAnimationFrame(animate);
            });
        }
        function loadmarker(){

            $.ajax({
                url : 'list_refuge.php', // La ressource ciblée
                type : 'GET', // Le type de la requête HTTP.
                //datatype: json,
                success : function(info, statut){ // code_html contient le HTML renvoyé
                    //alert(info);
                    var data = JSON.parse(info);
                    console.info(data);
                    console.info(data["1"].lat);
                    //console.info(info[0]);
                    //console.info(info[0]);
                    //alert(info.length);
                    var marker;
                    for (var property in data) {
                        if (data.hasOwnProperty(property)) {
                            marker = WE.marker([parseFloat(data[property].lat), parseFloat(data[property].lng)]).addTo(earth);
                        }
                    }
                    // WE.marker([51.5, -0.09]).addTo(earth);
                }
                //data : 'utilisateur=' + nom_user;
            });

        }
        function codeAddress() {
            var loc = [];
            var adresse = document.getElementById('adresse').value;
            var nom = document.getElementById('nom').value;
            var niveau = document.getElementById('niveau').value;


            geocoder.geocode({'address': adresse}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    loc[0] = results[0].geometry.location.lat();
                    loc[1] = results[0].geometry.location.lng();

                    //alert( loc ); // the place where loc contains geocoded coordinates
                    var marker = WE.marker([loc[0], loc[1]]).addTo(earth);
                    marker.bindPopup("<b>" + nom + "</b><br>" + adresse + "<br /><span style='font-size:10px;color:#999'>niveau : " + niveau + "</span>", {
                        maxWidth: 150,
                        closeButton: true
                    }).openPopup();
                    requestAnimationFrame(animate);

                    /*map.setCenter(results[0].geometry.location.lat());
                     var marker = new google.maps.Marker({
                     map: map,
                     position: results[0].geometry.location
                     });*/
                } else {
                    alert('Geocode was not successful for the following reason: ' + status);
                }
            });
        }

    </script>
    <style>
        html, body {
            padding: 0;
            margin: 0;
            background-color: white;
        }

        label {
            color: white
        }

        #earth_div {
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            position: absolute
        }
    </style>
    <title>Refug'here</title>
</head>
<body onload="initialize()">
<div class="container">
    <div class="row">
        <!-- Pour eviter de rafraichir la page -->
        <form onsubmit="return false">
            <!-- Text input-->
            <div class="col-md-3">
                <label class="col-md-3 control-label" for="adresse">Adresse</label>
                <div class="col-md-9">
                    <input id="adresse" name="adresse" type="text" placeholder="Indiquez votre adresse"
                           class="form-control input-md" required="">
                </div>
            </div>

            <!-- Text input-->
            <div class="col-md-3">
                <label class="col-md-4 control-label" for="nom">nom</label>
                <div class="col-md-8">
                    <input id="nom" name="nom" type="text" placeholder="nom du camps" class="form-control input-md"
                           required="">

                </div>
            </div>

            <!-- Select Basic -->
            <div class="col-md-3">
                <label class="col-md-4 control-label" for="niveau">Niveau</label>
                <div class="col-md-8">
                    <select id="niveau" name="niveau" class="form-control">
                        <option value="vide">Vide</option>
                        <option value="intermediaire">Intermédiaire</option>
                        <option value="plein">Plein</option>
                    </select>
                </div>
            </div>

            <!-- Button -->
            <div class="col-md-3">
                <div class="col-md-8">
                    <!--<button id="localiser" name="localiser" class="btn btn-primary">Localiser</button>-->
                    <input class="btn btn-primary" id="localiser" type="submit" name="localiser" value="Localiser"
                           onclick="codeAddress()"/></br/>
                </div>
            </div>
            <!--<input type="submit"  name="localiser" value="Localiser" onclick="codeAddress()"  /></br/>-->
        </form>
        <br/>
    </div>
    <div class="row">
        <div id="earth_div"></div>
    </div>

</div>
<?php
/*
$base = new mysqli("127.0.0.1", "root", "", "ni2016");
if ($base->connect_errno) {
echo "Echec lors de la connexion à MySQL : (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
$sql="SELECT * FROM camp_webgl";
$res = mysqli_query($base,$sql);
while($resultat=mysqli_fetch_array($res)){
echo $resultat['nom'];
echo "<script>";
    var marker = WE.marker([51.5, -0.09]).addTo(earth);
    marker.bindPopup("<b>Calais</b><br>Adresse;Remplissage<br /><span style='font-size:10px;color:#999'>Tip: Another popup is hidden in Cairo..</span>", {maxWidth: 150, closeButton: true}).openPopup();


    }*/
    ?>

    </body>
    </html>
