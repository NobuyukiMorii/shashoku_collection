//画面サイズを取得する
function getScreenSize() {
    var s = "横幅 = " + window.parent.screen.width + " / 高さ = " + window.parent.screen.height;
    document.getElementById("ScrSize").innerHTML = s;
}
//ウィンドウサイズを取得する
function getWindowSize() {
    var sW,sH,s;
    sW = window.innerWidth;
    sH = window.innerHeight;

    s = "横幅 = " + sW + " / 高さ = " + sH;
 
    document.getElementById("WinSize").innerHTML = s;
}
function showFlashMessage(message) {
    var flashMessage = $("<div id='flashMessage' class='message'>"+message+"</div>");
    $("#l-main")[0].insertBefore(flashMessage[0], $("#l-main")[0].childNodes[0]);
    setTimeout(function(){
        $("#flashMessage").animate({ opacity: 'hide',}, { duration: 1000, easing: 'swing',});
    }, 1500);
}
function deleteFlashMessage() {
    if($("#flashMessage")) {
        setTimeout(function(){
            $("#flashMessage").animate({ opacity: 'hide',}, { duration: 1000, easing: 'swing',});
        }, 1500);
    }
}