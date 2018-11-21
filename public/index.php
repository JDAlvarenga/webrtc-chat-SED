<html>
<head>
  <link rel="stylesheet" type="text/css" href="src/shared/semantic/semantic.min.css">
  <link rel="stylesheet" href="src/css/login.css" type="text/css" media="screen" />
</head>
<body>
<div class="ui two column doubling stackable grid container" id="loginDesign">
  <div class="column loginParts" id="blueLoginPart">
     <img src="src/assets/leftLoginImage.jpg" alt="Login Image" height="auto" width="100%"> 
  </div>
  <div class="column loginParts" id="whiteLoginPart">
    <div class="ui left icon input">
        <input id="username" type="text" placeholder="Ingrese usuario...">
        <i class="user icon"></i>
    </div>
    <br>
    <div class="ui left icon input">
        <input id="username" type="password" placeholder="Ingrese contrasna...">
        <i class="key icon"></i>
    </div>
    <br>
    <br>
    <br>
    <br>

    <div class="ui left action input">
        <button class="ui teal labeled icon button" onclick="startConection()">
        <i class="rocketchat icon"></i>
        Iniciar ConexionTest
        </button>
    </div>
  </div>
</div>
<script src="src/js/jquery-3.3.1.min.js"></script>
<script src="src/shared/semantic/semantic.min.js"></script>
<script src="src/js/mockChat.js"></script>
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

</body>
</html> 

