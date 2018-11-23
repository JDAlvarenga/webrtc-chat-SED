 <?php
require_once 'vendor/autoload.php';
$handler = new \ByJG\Session\JwtSession('webchatsed.tk', 'your super secret key', 5);
$handler->replaceSessionHandler(true);


session_destroy();

header('Location: index.php');

?>
