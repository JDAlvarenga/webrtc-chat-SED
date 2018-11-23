<?php
require_once 'vendor/autoload.php';

$handler = new \ByJG\Session\JwtSession('webchatsed.tk', 'your super secret key', 5);
$handler->replaceSessionHandler(true);

error_log("USER:".$_SESSION['user']. " ROLE:". $_SESSION['role']  );

// session_start();

if ( !isset($_SESSION['user']) || $_SESSION['role'] == 2) {
	error_log("ERROR: VAMOS ENTRO PERO NO ERA DE ENTRAR");
	header('Location: index.php');
}

?>


</<!DOCTYPE html>
<html>
<head>
    <title>WebChat P2P SED</title>
  <link rel="stylesheet" type="text/css" href="src/shared/semantic/semantic.min.css">
  <link rel="stylesheet" href="src/css/main.css" type="text/css" media="screen" />
  <link rel="stylesheet" href="src/css/webchat.css" type="text/css" media="screen" />
</head>
<body>
    <form id="logout" action="/logout">
		<button class="ui teal labeled icon button" type="submit">
            <i class="rocketchat icon"></i>
            Cerrar sesion
        </button>
    </form>

<div class="ui one column doubling stackable grid container" id="loadingDesign">
        <div class="column loginParts" id="whiteLoginPart" style="color:white;">
            <h1>Listado de usuarios: <h1>
            <?php
                require 'vendor/autoload.php';
                use Medoo\Medoo;
                $database = new Medoo([
                    // required
                    'database_type' => 'pgsql',
                    'database_name' => 'appchat',
                    'server' => 'localhost',
                    'username' => 'postgres',
                    'password' => 'rootPass',
                
                    // [optional]
                    'charset' => 'utf8mb4',
                    'collation' => 'utf8mb4_general_ci',
                    'port' => 5432

                ]);
                if(isset($_POST['userid'])){
                    if(isset($_POST['enable'])){
                        $database->update("chat", [
                           "active" => $updated_value
                       ], ["id[=]" => $_POST['userid']]);
                       $_POST['userid'] = null;
                       $_POST['enable'] = null;
                       $_POST['disable'] = null;
                    }else{
                     if(isset($_POST['disable'])){
                        $database->update("chat", [
                           "active" => $updated_value
                       ], ["id[=]" => $_POST['userid']]);
                       $_POST['userid'] = null;
                       $_POST['enable'] = null;
                       $_POST['disable'] = null;
                    }   
                    }

                    /*$updated_value = 1;
                    if($_POST['userid'] == 1){
                        $updated_value = 0;
                    }
                   $database->update("chat", [
                       "active" => $updated_value
                   ], ["id[=]" => $_POST['userid']]);
                   $_POST['userid'] = null;/*/
                }
                $results = $database->select("chat",["id","username", "active", "role"]);
                echo "<p> Usuarios: </p><br/>";
                echo '
                    <table class="ui collapsing celled table">
                          <thead>
                            <tr><th>Usuario</th>
                            <th>Accion</th>
                          </tr></tr></thead>
                    <tbody>
                    ';
                /*echo ' <table style=\"color:white;\">
                        <tr>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th></th>
                        </tr>';*/

                foreach ($results as $result) {
                    echo '
                        <tr>
                        <form method=\'post\' action=\'\'> 
                          <td>
                            <h4 class="ui image header">
                              <div class="content">
                                '.$result["username"].'
                                <div class="sub header">'. $result["role"].'
                              </div>
                            </div>
                          </h4></td>
                          <td>
                            <div class="ui left action input">
                                '.get_button_message($result["active"]).'
                                <input type=\'hidden\' name=\'userid\' id=\'userid\' value="'.$result["id"].'">
                            </div>
                          </td>
                          </form>
                        </tr>
                        ';
                    /*echo "<tr>
                            <form method='post' action=''> 
                            <td>".$result["username"]."</td>".
                            "<td>". $result["role"]."</td>".
                            "<td>
                                <input type='submit' value=\"".get_button_message($result["active"])."\"/>
                                <input type='hidden' name='userid' id='userid' value=\"".$result["id"]."\">
                            </td>
                            </form>
                            </tr>";*/
                }
                echo '
                      </tbody>
                </table>
                ';
                function get_button_message($string){
                    if($string == "1"){
                        return '
                                <button class="ui red icon button" type="submit">
                                    Desactivar
                                </button>
                                <input type=\'hidden\' name=\'disable\' id=\'disable\' value="yes">
                            ';
                        //return "Desactivar";
                    }
                    else{
                        return '
                                <button class="ui green icon button" type="submit" >
                                    Activar
                                </button>
                                <input type=\'hidden\' name=\'enable\' id=\'enable\' value="yes">
                        ';
                        //return "Activar";
                    }
                }
            ?>
        </div>
</div>
</body>
<script src="src/js/jquery-3.3.1.min.js"></script>
<script src="src/shared/semantic/semantic.min.js"></script>
</html>
