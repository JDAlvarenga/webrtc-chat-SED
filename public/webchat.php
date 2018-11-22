<html>
<head>
  <link rel="stylesheet" href="src/css/main.css" type="text/css" media="screen" />
  <link rel="stylesheet" type="text/css" href="src/shared/semantic/semantic.min.css">
  <link rel="stylesheet" href="src/css/webchat.css" type="text/css" media="screen" />
</head>
<body>
    <div class="ui one column doubling stackable grid container" id="loadingDesign">
        <div class="column loginParts" id="whiteLoginPart">
            <div class="ui icon message">
              <i class="notched circle loading icon"></i>
              <div class="content">
                <div class="header">
                  Just one second
                </div>
                <p>We're fetching that content for you.</p>
              </div>
            </div>
        </div>
    </div>
    
<?php
    // If you installed via composer, just use this code to require autoloader on the top of your projects.
    require 'vendor/autoload.php';
     
    // Using Medoo namespace
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
        "username" => $_POST['dataU'],//DataUser
        "password" => $_POST['dataP']//DataPass
    ]
    ]))
    {
        $result = '
        <div class="chat">    
            <div class="ui left icon input">
                <input id="username" type="text" placeholder="Nickname para sala...">
                <i class="user icon"></i>
                <div class="ui buttons left action input">
                    <button class="ui green labeled icon button" onclick="startConection()" id="startConection">
                    <i class="rocketchat icon"></i>
                        Iniciar Conexion
                    </button>
                    <div class="or" data-text="O"></div>
                    <button class="ui gray labeled icon button" id="closeConection">
                        Cerrar Conexion
                    </button>
                </div>
            </div>
            <div id="chatOutput"></div>
            <input id="chatInput" type="text" placeholder="Ingresar mensaje..." maxlength="128">
            <div class="ui left action input">
                <button class="ui gray labeled icon button" id="sendMessageButton">
                <i class="telegram plane icon"></i>
                Enviar Mensaje
                </button>
            </div>
        </div>
        <script src="src/js/jquery-3.3.1.min.js"></script>
        <script src="src/shared/semantic/semantic.min.js"></script>
        <script>    
            var conn;
            function closeConection(){
                conn.close();
                $("#sendMessageButton").attr(\'class\', \'ui gray labeled icon button\');  
                $("#closeConection").attr(\'class\', \'ui gray labeled icon button\');  
                $("#startConection").attr(\'class\', \'ui green labeled icon button\'); 

                $("#startConection").on(\'click\', function (e) {
                    startConection();
                }); 

                $("#sendMessageButton").off(\'click\'); 
                $("#chatInput").off(\'keyup\');
                $("#closeConection").off(\'click\'); 
                conn=null;
            }

            function startConection() {
                if(!conn){
                    conn = new WebSocket(\'ws://149.28.102.58:8080\'); 
                    $("#sendMessageButton").attr(\'class\', \'ui teal labeled icon button\');  
                    $("#closeConection").attr(\'class\', \'ui red labeled icon button\');  
                    $("#startConection").attr(\'class\', \'ui gray labeled icon button\');  

                    $("#startConection").off(\'click\');  

                    $("#sendMessageButton").on(\'click\', function (e) {
                        enviarMensaje();
                    }); 
                    $("#chatInput").on(\'keyup\', function (e) {
                        if (e.keyCode == 13) {
                            enviarMensaje();
                        }
                    });
                    $("#closeConection").on(\'click\', function (e) {
                        closeConection();
                    }); 
                }       
                conn.onopen = function(e) {
                    var username = document.getElementById(\'username\').value; 
                    console.log("Connection established!");
                    conn.send(username + " entro al servidor")
                };

                conn.onmessage = function(e) {
                    var chatOutput = document.getElementById(\'chatOutput\');                // Create a <h1> element
                    var t = document.createTextNode(e.data);     // Create a text node
                    var br = document.createElement("BR"); 
                    chatOutput.appendChild(t);  
                    chatOutput.appendChild(br);  
                    console.log(e.data);
                };

                conn.onerror = function(e) {
                    console.log(e);
                };

                conn.onclose = function(e) {
                    console.log(e);
                };
            };
            function enviarMensaje() {
                var username = document.getElementById(\'username\').value; 
                var data = document.getElementById(\'chatInput\').value; 
                console.log("Yo : " + data);
                var chatOutput = document.getElementById(\'chatOutput\');                // Create a <h1> element
                var t = document.createTextNode("Yo : " + data + "\n");     // Create a text node
                var br = document.createElement("BR"); 
                chatOutput.appendChild(t);  
                chatOutput.appendChild(br);
                document.getElementById(\'chatInput\').value= "";
                conn.send(username + " : " + data);
            };
            

        </script>
        <script language="javascript">
            document.getElementById("loadingDesign").style.display = "none";
        </script>
        ';
    }
    else
    {
        //echo "Login error.";
        $_POST['status']='loginError';
        echo '<form id="myForm" action="/" method="post">';//Go to login
            foreach ($_POST as $a => $b) {
                echo '<input type="hidden" name="'.htmlentities($a).'" value="'.htmlentities($b).'">';
            }
        echo "</form>";
        echo '<script type="text/javascript">
                document.getElementById("myForm").submit();
              </script>
             ';
        //header('Location: index');
    }
?>
<div id="webchatDesign"><?php echo $result; ?></div> 
</body>
</html> 

