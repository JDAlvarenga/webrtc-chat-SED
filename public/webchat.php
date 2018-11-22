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
                <input id="username" type="text" placeholder="Ingrese usuario...">
                <i class="user icon"></i>
                <div class="ui left action input">
                    <button class="ui teal labeled icon button" onclick="startConection()">
                    <i class="rocketchat icon"></i>
                    Iniciar Coneccion
                    </button>
                </div>
            </div>
            <div id="chatOutput"></div>
            <input id="chatInput" type="text" placeholder="Input Text here" maxlength="128">
            <button onclick="enviarMensaje()" id="chatSend">Send</button>
        </div>
        <script src="src/js/jquery-3.3.1.min.js"></script>
        <script src="src/shared/semantic/semantic.min.js"></script>
        <script>    
            var conn;
            function startConection() {
                if(!conn){
                    conn = new WebSocket(\'ws://149.28.102.58:8080\');    
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

