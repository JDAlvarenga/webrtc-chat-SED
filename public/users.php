<?php
require_once 'vendor/autoload.php';

$handler = new \ByJG\Session\JwtSession('webchatsed.tk', 'your super secret key', 5);
$handler->replaceSessionHandler(true);

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
    

<div class="ui one column doubling stackable grid container" id="loadingDesign">
        <div class="column loginParts" id="whiteLoginPart" style="color:white;">
            <div class="ui left icon input" style="display: flex;">
            <h1 style="color: white;flex: 1;">Listado de usuarios </h1>
            <form id="logout" action="/logout">
                <button class="ui teal labeled icon button" type="submit">
                    <i class="rocketchat icon"></i>
                    Cerrar sesion
                </button>
            </form>
            </div>

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
                if ($database->has("chat", [
                     "AND" => [
                         "username" => $_SESSION['user'],//DataUser
                         "active" => false
                     ]
                 ])
                
                ){
                    session_destroy();
                    echo '<form id="logoutForm" action="/index" method="post">';//Go to login
                    echo '<input type=\'hidden\' name=\'status\' id=\'errorActive\' value="yes">';
                    echo "</form>";
                    echo '<script type="text/javascript">
                        document.getElementById("logoutForm").submit();
                        </script>
                    ';
                            

                 }

                if(isset($_POST['userid'])){
                    if(isset($_POST['enable'])){
                        $database->update("chat", [
                           "active" => 1
                       ], ["id[=]" => $_POST['userid']]);
                    }else{
                     if(isset($_POST['disable'])){
                        $database->update("chat", [
                           "active" => 0
                       ], ["id[=]" => $_POST['userid']]);
                    }else{
                        if(isset($_POST['makeadmin'])){
                            $database->update("chat", [
                               "role" => 1
                           ], ["id[=]" => $_POST['userid']]);
                        }else{
                            if(isset($_POST['makeuser'])){
                                $database->update("chat", [
                                   "role" => 2
                               ], ["id[=]" => $_POST['userid']]);
                            }
                        }
                    }
                    $_POST['userid'] = null;
                   $_POST['enable'] = null;
                   $_POST['disable'] = null;
                   $_POST['makeadmin'] =null;
                   $_POST['makeuser'] = null;
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
                $results = $database->select("chat",["id","username", "active", "role"], 
                ["username[!]" => $_SESSION['user']]);
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
                        
                          <td>
                            <h4 class="ui image header">
                              <div class="content">
                                '.$result["username"].'
                                <div class="sub header">'
                                .print_role_message($result["role"]).'
                              </div>
                            </div>
                          </h4></td>
                          <td>
                            <div class="ui left action input">
                            <form method=\'post\' action=\'\'> 
                                '.get_button_message($result["active"]).'
                                <input type=\'hidden\' name=\'userid\' id=\'userid\' value="'.$result["id"].'">
                                </form>
                            <form method=\'post\' action=\'\'> '
                                .get_button_role($result["role"])  .'
                                <input type=\'hidden\' name=\'userid\' id=\'userid\' value="'.$result["id"].'">
                            </form>
                            </div>
                          </td>                          
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
                function print_role_message($role){
                    if($role =="1"){
                        return 'Administrador';
                    }else{
                        return 'Usuario';
                    }
                }

                function get_button_role($string){
                    if($string == "1"){
                        return '
                                <button class="ui orange icon button" type="submit">
                                    Hacer User
                                </button>
                                <input type=\'hidden\' name=\'makeuser\' id=\'makeuser\' value="yes">
                            ';
                        //return "Desactivar";
                    }
                    else{
                        return '
                                <button class="ui teal icon button" type="submit" >
                                    Hacer Admin
                                </button>
                                <input type=\'hidden\' name=\'makeadmin\' id=\'makeadmin\' value="yes">
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
