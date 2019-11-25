<?php include "header.php"; ?>

<div>
    <form action="../admin.php" method="post" >
            <input class="ingusu"type=text placeholder=Usuario name=txtusuario autofocus/>
            <input class="ingusu" type=password autocomplete=off placeholder=Contraseña name=txtpassword />
            <p><button class="bvolver bingusu btn btn-succes btn-block" type=submit value=Ingresar name=entrar>
            Ingresar</button></p>
    </form>
</div>


<?php include "footer.php"; ?>
