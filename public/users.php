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
                $results = $database->select("chat",["username", "active", "role"]);
                echo "<p> Usuarios: </p><br/>";
                echo "<table style=\"color:white;\">
                        <tr>
                            <th>Username</th>
                            <th>Status</th>
                            <th>Role</th>
                        </tr>";
                foreach ($results as $result) {
                    echo "<tr><td>".$result["username"]."</td>".
                            "<td>". $result["active"]."</td>".
                            "<td>". $result["role"]."</td></tr>";
                }
            ?>
        </div>
</div>
</body>
</html>
