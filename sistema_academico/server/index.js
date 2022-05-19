const express = require('express'),
    server = express(),
    port = 3001;

server.use(express.json());

server.get('/chat', function(req, resp){
    resp.send('Hola mundo');

});

server.get('/usuarios', function(req, resp){
    console.log(req.body);
    resp.send('Bienvenidos al sitio de chats');
});

server.listen(port, function(event){
    console.log(`Server running on port ${port}`);
});