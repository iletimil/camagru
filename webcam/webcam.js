var video = document.getElementById('video');
var canvas = document.getElementById('canvas');
var context = canvas.getContext('2d');
var canvas2 = document.getElementById('canvas2');
var context2 = canvas2.getContext('2d');
var stickers = document.querySelectorAll( '.stickers' );

//go thru every sticker and assign event listener
console.log(stickers[1]);



stickers.forEach( function( item ){
    item.onclick = function(){
        console.log( item );
    }
})

// Get access to the camera!
if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia)
{
   navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream)
   {
       video.srcObject = stream;
   });
}

var image = new Image();
image.src = '../stickers/titan.png';
setInterval(() => {
	context.drawImage(video, 0, 0, 640, 480);
    context.drawImage(image,0,0,640,480);
}, 16);

// Trigger photo take
document.getElementById("snap").addEventListener("click", function() {
	context2.drawImage(video, 0, 0, 640, 480);
     context2.drawImage(image,0,0,640,480);
    document.getElementById("img").value = canvas2.toDataURL();
});