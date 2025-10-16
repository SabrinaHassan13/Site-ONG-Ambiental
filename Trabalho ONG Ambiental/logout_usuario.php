<?php
session_start(); 

unset($_SESSION['usuario_logado_id']);
unset($_SESSION['usuario_logado_nome']);
unset($_SESSION['usuario_logado_email']);
unset($_SESSION['LAST_ACTIVITY']);

header("Location: index.php");
exit();
?>