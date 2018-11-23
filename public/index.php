<html>
  <head>
    <title>WebChat P2P SED</title>
  <link rel="stylesheet" type="text/css" href="src/shared/semantic/semantic.min.css">
  <link rel="stylesheet" href="src/css/login.css" type="text/css" media="screen" />
</head>
<body>
<div class="ui two column doubling stackable grid container" id="loginDesign">
  <div class="column loginParts" id="blueLoginPart">
     <img src="src/assets/leftLoginImage.jpg" alt="Login Image" height="auto" width="100%"> 
  </div>
  <div class="column loginParts" id="whiteLoginPart">
    <form action="/webchat" method="post">
        <div class="ui left icon input">
            <input name="dataU" id="username" type="text" placeholder="Ingrese usuario...">
            <i class="user icon"></i>
        </div>
        <br>
        <div class="ui left icon input">
            <input name="dataP" id="password" type="password" placeholder="Ingrese contrasena...">
            <i class="key icon"></i>
        </div>
        <br>
        <br>
        <br>
        <br>    
        <div class="ui left action input">
            <button class="ui teal labeled icon button" type="submit">
            <i class="rocketchat icon"></i>
            Iniciar Conexion
            </button>
        </div>
    </form> 
    <div id="errorMessage" class="ui negative message" style="display: none;">
          <i class="close icon" onclick="document.getElementById('errorMessage').style.display = 'none';"></i>
          <div class="header">
            Error las credenciales ingresadas no son validas
          </div>
          <p>Intente nuevamente
        </p>
    </div>
    <div id="loginError" class="ui warning message" style="display: none;">
          <i class="close icon" onclick="document.getElementById('loginError').style.display = 'none';"></i>
          <div class="header">
            Error tu usuario ha sido desactivado
          </div>
          <p>Contacta a un administrador
        </p>
    </div>
    <div class="ui icon message">
      <i class="inbox icon"></i>
      <div class="content">
        <div class="header">
          Aun no posees cuenta?
        </div>
        <a href='#'>Crear una ahora!</a>
      </div>
    </div>
  </div>
</div>
<script src="src/js/jquery-3.3.1.min.js"></script>
<script src="src/shared/semantic/semantic.min.js"></script>
<script>    
    var conn;
    function startConection() {
        if(!conn){
            conn = new WebSocket('ws://localhost:8080');    
        }       
        conn.onopen = function(e) {
            var username = document.getElementById('username').value; 
            console.log("Connection established!");
            conn.send(username + " entro al servidor")
        };

        conn.onmessage = function(e) {
            var chatOutput = document.getElementById('chatOutput');                // Create a <h1> element
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
        var username = document.getElementById('username').value; 
        var data = document.getElementById('chatInput').value; 
        console.log("Yo : " + data);
        var chatOutput = document.getElementById('chatOutput');                // Create a <h1> element
        var t = document.createTextNode("Yo : " + data + "\n");     // Create a text node
        var br = document.createElement("BR"); 
        chatOutput.appendChild(t);  
        chatOutput.appendChild(br);
        conn.send(username + " : " + data);
    };
</script>
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
    $datas = $database->select("chat", [
        "username",
        "password"
    ]);
     
    // $datas = array(
    //  [0] => array(
    //      "user_name" => "foo",
    //      "email" => "foo@bar.com"
    //  ),
    //  [1] => array(
    //      "user_name" => "cat",
    //      "email" => "cat@dog.com"
    //  )
    // )
     
    /*foreach($datas as $data)
    {
        echo "username:" . $data["username"] . " - text:" . $data["password"] . "<br/>";
    }*/
?>
<?php
require_once 'vendor/autoload.php';

$handler = new \ByJG\Session\JwtSession('webchatsed.tk', 'your super secret key', 5);
$handler->replaceSessionHandler(true);

  function loginWebchat() {
    echo 'I just ran a php function';
    header("Location: webchat");
  }

  if (isset($_GET['goWebChat'])) {
    echo 'Im alive';
    loginWebchat();
  }

session_start();

error_log("INDEX - > USER:".$_SESSION['user']. " ROLE:". $_SESSION['role']  );

if (isset($_SESSION['user'])) {
    header('Location: webchat.php');
}
  if ( $_POST['status']=='loginError' ) {
    echo '<script language="javascript">
            document.getElementById("errorMessage").style.display = "block";
        </script>
    ';
  }
  if ( $_POST['status']=='errorActive' ) {
    echo '<script language="javascript">
            document.getElementById("loginError").style.display = "block";
        </script>
    ';
  }
?>
</body>
</html> 

