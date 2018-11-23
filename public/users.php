</<!DOCTYPE html>
<html>
<head>
    <title>WebChat P2P SED</title>
  <link rel="stylesheet" href="src/css/main.css" type="text/css" media="screen" />
  <link rel="stylesheet" type="text/css" href="src/shared/semantic/semantic.min.css">
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
                    $updated_value = 1;
                    if($_POST['userid'] == 1){
                        $updated_value = 0;
                    }
                   $database->update("chat", [
                       "active" => $updated_value
                   ], ["id[=]" => $_POST['userid']]);
                }
                $results = $database->select("chat",["id","username", "active", "role"]);
                echo "<p> Usuarios: </p><br/>";
                echo ' <table style=\"color:white;\">
                        <tr>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th></th>
                        </tr>';
                foreach ($results as $result) {
                    echo "<tr>
                            <form method='post' action=''> 
                            <td>".$result["username"]."</td>".
                            "<td>". $result["role"]."</td>".
                            "<td>
                                <input type='submit' value=\"".get_button_message($result["active"])."\"/>
                                <input type='hidden' name='userid' id='userid' value=\"".$result["id"]."\">
                            </td>
                            </form>
                            </tr>";
                }

                function get_button_message($string){
                    if($string == "1"){
                        return "Desactivar";
                    }
                    else{
                        return "Activar";
                    }
                }
            ?>
        </div>
</div>
</body>
</html>
