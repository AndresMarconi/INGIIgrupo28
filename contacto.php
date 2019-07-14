<?php
    echo '<!DOCTYPE html>'."\n";
    echo '<html>'."\n";
        include('head.html');
        echo '<body>'."\n";
            include('navbar.html');
            echo "
                <div class='contact-clean'>
                    <form method='post'>
                        <h2 class='text-center'>Contact us</h2>
                        <div class='form-group'>
                            <input class='form-control' type='text' name='name' placeholder='Nombre'>
                        </div>
                        <div class='form-group'>
                            <input class='form-control is-invalid' type='email' name='email' placeholder='Email'>
                        </div>
                        <div class='form-group'>
                            <textarea class='form-control' rows='14' name='message' placeholder='ingrese su mensaje'></textarea>
                        </div>
                        <div class='form-group'><button class='btn btn-primary' type='submit' name='enviar'>Enviar</button></div>
                    </form>
                </div>
            ";
            include('footer.html');
        echo "\n".'</body>'."\n";
    echo '</html>';
    if (isset($_POST['enviar'])) {
        include('objetos.php');
        $nombre = $_POST['name'];
        $asun = "Consulta HomeSwitchHome";
        $email = $_POST['email'];
        $mensaje = $_POST['message'];

        //$mensaje = $nombre."<br>".$_POST['message'];

        $mensajePredem = "
            Muchas gracias por ponerse en contacto con HomeSwitchHome, pronto nos estaremos comunicando con ustedes.<br><br>
            Saludos Cordiales,<br><br>
            El Equipo de HomeSwitchHome.
            ";

        $env = new Envio();
        $est1 = $env->enviarAConsultor($nombre, $asun, $email, $mensaje, "guille2358@gmail.com");
        $est2 =  $env->enviarACliente($nombre, $asun, $email, $mensajePredem);

        //mail($email,$asun,$mensaje,$headers);

        echo "<script languaje= 'javascript'>";
        echo "alert ('Su mail se envio correctamente');";
        echo "</script>";
    }
?>