
const socket = new WebSocket("ws://"+ window.location.host +":8080/");
let socket_connected = false;
setTimeout(()=>socket_connected ? null : socket.close(), 2000);
socket.onopen = ()=>{
    socket_connected = true;
    console.log("Socket successfully established.");
}
socket.onclose = ()=>{
    console.log("Using XMLHttpRequest as backup");
}