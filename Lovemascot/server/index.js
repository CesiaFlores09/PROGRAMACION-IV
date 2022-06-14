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
        mongodb.connect(url, (err, client) => {
            console.log(data, typeof data);
            if (err) console.log(err);
            const db = client.db(dbName);
            db.collection('chat').find({
                $or: [
                    { by: data.by, to: data.to },
                    { by: data.to, to: data.by }
            ]}).toArray((err, response) => {
                if (err) console.log(err);
                let sortids = [data.by, data.to].sort((a, b) => a - b);
                socket.emit('chat_' + sortids.join('_'), response);
            });
        }); 
    });
    socket.on('sendMsg', data => {
        mongodb.connect(url, (err, client) => {
            if (err) console.log(err);
            const db = client.db(dbName);
            db.collection('chat').insertOne({
                by: data.by,
                to: data.to,
                mensaje: data.mensaje,
            }).then(response => {
                console.log(data)
                socket.emit('sendMsg_' + data.by + '_' + data.to, data);
            }).catch(error => {
                console.log(error);
            }); 
        });
    });
});
app.use(express.json());

http.listen(port, function() {
    console.log('listening on http://127.0.0.1:' + port);
});