```php
<?php

if(!$_POST) exit;

// Verificación de dirección de email, no editar.
function isEmail($email) {
	return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$email));
}

if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");
$position_post  = $_POST['position_post'];
$first_name     = $_POST['first_name'];
$last_name      = $_POST['last_name'];
$email          = $_POST['email'];
$comments       = $_POST['comments'];

if(trim($first_name) == '') {
	echo '<div class="error_message">¡Atención! Debes ingresar tu nombre.</div>';
	exit();
} else if(trim($email) == '') {
	echo '<div class="error_message">¡Atención! Por favor ingresa una dirección de email válida.</div>';
	exit();
} else if(!isEmail($email)) {
	echo '<div class="error_message">¡Atención! Has ingresado una dirección de email no válida, inténtalo de nuevo.</div>';
	exit();
}

if(trim($comments) == '') {
	echo '<div class="error_message">¡Atención! Por favor ingresa tu mensaje.</div>';
	exit();
}

if(get_magic_quotes_gpc()) {
	$comments = stripslashes($comments);
}

// Opción de configuración.
// Ingresa la dirección de email a la que deseas que se envíen los correos.
// Ejemplo $address = "juan.perez@tudominio.com";

//$address = "ejemplo@themeforest.net";
$address = "ejemplo@tudominio.com";

// Opción de configuración.
// Ej. El asunto estándar aparecerá como "Han contactado contigo Juan Pérez."

// Ejemplo, $e_subject = '$name . ' te ha contactado a través de Tu Sitio Web.';

$e_subject = 'Han contactado contigo ' . $first_name . '.';

// Opción de configuración.
// Puedes cambiar esto si lo consideras necesario.
// Desarrolladores, quizás deseen agregar más campos al formulario, en cuyo caso deben asegurarse de agregarlos aquí también.

$e_body = "Has sido contactado por $first_name. $first_name seleccionó el servicio de $select_service, su mensaje adicional es el siguiente. El presupuesto máximo del cliente es $select_price, para este proyecto." . PHP_EOL . PHP_EOL;
$e_content = "\"$comments\"" . PHP_EOL . PHP_EOL;
$e_reply = "Puedes contactar a $first_name por email, $email o por teléfono $phone";

$msg = wordwrap( $e_body . $e_content . $e_reply, 70 );

$headers = "From: $email" . PHP_EOL;
$headers .= "Reply-To: $email" . PHP_EOL;
$headers .= "MIME-Version: 1.0" . PHP_EOL;
$headers .= "Content-type: text/plain; charset=utf-8" . PHP_EOL;
$headers .= "Content-Transfer-Encoding: quoted-printable" . PHP_EOL;

if(mail($address, $e_subject, $msg, $headers)) {

	// El email se ha enviado correctamente, muestra una página de éxito.

	echo "<fieldset>";
	echo "<div id='success_page'>";
	echo "<h1>Email Enviado Exitosamente.</h1>";
	echo "<p>Gracias <strong>$first_name</strong>, tu mensaje ha sido enviado.</p>";
	echo "</div>";
	echo "</fieldset>";

} else {

	echo '¡ERROR!';

}

?>
```

