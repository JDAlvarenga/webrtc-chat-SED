<html>
<head>
  <link rel="stylesheet" href="src/css/main.css" type="text/css" media="screen" />
</head>
<body>
<div class="chat">
    <input id="username" type="text" placeholder="Input username" maxlength="128">
    <button onclick="startConection()">Iniciar Coneccion</button>
    <div id="chatOutput"></div>
    <input id="chatInput" type="text" placeholder="Input Text here" maxlength="128">
    <button onclick="enviarMensaje()" id="chatSend">Send</button>
</div>
<script src="src/js/jquery-3.3.1.min.js"></script>
<?php
require 'vendor/autoload.php';

$app = new \atk4\ui\App();   // That's your UI application
$app->initLayout('Centered');

$form = new \atk4\ui\Form(); // Yeah, that's a form!
$app->add($form);

$form->addField('username');    // adds field
$form->onSubmit(function ($form) {
    // implement subscribe here

    return $form->success('Subscribed '.$form->model['email'].' to newsletter.');
});

// Decorate anything
$form->buttonSave->set('Subscribe');
$form->buttonSave->icon = 'mail';

// everything renders automatically

?>
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

        <?php 
	        $message = new \atk4\ui\Message('Yo : ' + data + '\n');
	        $GLOBALS['app']->add($message);
        ?>
        conn.send(username + " : " + data);
    };
</script>
</body>
</html> 

