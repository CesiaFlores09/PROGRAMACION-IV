const { SocketAddress } = require('net');

const port = 3000;

let express = require('express'),
    app = express(),
    http = require('http').Server(app),
    mongodb = require('mongodb').MongoClient,
    url = 'mongodb://localhost:27017',
    dbName = 'lovemascot',
    socketio = require('socket.io')(http, {
        allowEIO3: true,
        cors: {
            origin: ['https://lovemascot.test.com'],
            credentials: true
        }
    });

socketio.on('connection', socket => {
    console.log('Conectado')
    socket.on('chat', data => {
        socketio.emit(data.id, data.mensaje);
        
    });
});
app.use(express.json());

http.listen(port, function() {
    console.log('listening on http://127.0.0.1:' + port);
});