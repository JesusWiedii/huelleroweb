<?php include("db.php") ?>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Huellero</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

</head>

<body background="img/fondo1.jpeg">

    <div class="col-xs-12 col-md-12"><img src="img/verticalwiedii.svg" alt="" class="imgwiedii" style="width: 100%;
        height: 12vw;"></div>
    
    
    <form action="include/process.php" method="post">
        <div class="row card-body">
            <div class="col-xs-2 col-md-2"></div>
            <div class="col-xs-8 col-md-8">
            <?php if(@$_GET['Empty']==true){?>
<div class="aler-light text-danger my-3" style="Background: white;"><?php echo $_GET['Empty'] ?></div>
    <?php }?>
                <input class="ingusu" type=text placeholder=Usuario name=username autofocus />
                <input class="ingusu" type=password autocomplete=off placeholder=Contraseña name=password />
                <p><button class="bvolver bingusu btn btn-succes btn-block" type=submit value=Ingresar name=entrar>
                        Ingresar</button></p>
                        <?php if(@$_GET['Invalid']==true){?>
<div class="aler-light text-danger my-3" style="Background: white;"><?php echo $_GET['Invalid'] ?></div>
    <?php }?>
            </div>
            <div class="col-xs-2 col-md-2"></div>
        </div>

    </form>



</body>
<footer>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/reloj.js"></script>
    <script src="js/funciones.js"></script>

</footer>

</html>