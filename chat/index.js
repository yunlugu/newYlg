var app = require('express')();
var http = require('http').createServer(app);
var io = require('socket.io')(http);

var Redis = require('ioredis');
var redis = new Redis('6379', '127.0.0.1');

app.get('/', function(req, res){
  res.sendfile('index.html');
});

http.listen(6001, function() {
    console.log('Server is running!');
});

function handler(req, res) {
    res.writeHead(200);
    res.end('');
}

io.on('connection', function(socket) {
    console.log('connected');
    socket.on('chat message', function(msg){
      console.log('message: ' + msg);
    });
});

redis.psubscribe('*', function(err, count) {
    console.log(count);
});

redis.on('pmessage', function(subscribed, channel, message) {
    console.log(subscribed);
    console.log(channel);
    console.log(message);

    message = JSON.parse(message);
    console.log(message.event);
    io.emit(channel + ':' + message.event, message.data);
});
