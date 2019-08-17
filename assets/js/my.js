

var panel = $(".panel-count").length;
function getRandomRgb() {
    var num = Math.round(0xffffff * Math.random());
    var r = num >> 16;
    var g = num >> 8 & 255;
    var b = num & 255;
    return 'rgb(' + r + ', ' + g + ', ' + b + ')';
}
for(var i = 1; i <= panel ; i++){
	var rgb = [];
    rgb.push(Math.floor(Math.random() * 255));
    //document.getElementsByClassName('panel-color'+i).style.backgroundColor = 'rgb('+ rgb.join(',') + ')';
   $(".panel-color"+i + ".panel-heading").css("backgroundColor", getRandomRgb());
}




//carousel slider


  

   


