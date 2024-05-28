$('.bar').click(function(){
        $('.nav-links').slideToggle({
            start: function() {
                $(this).css('display','flex');
        }
    });
});
//toggle side menu

$('.toggle').click(function(){
    $('#in-ul').slideToggle();
});
$('.users-dropdown>p').click(function(){
   $('.dropdown-content').slideToggle(); 
});
let msg1 = $("#welcome-msg1");
let msg = $("#welcome-msg");
let interval;
//function modifes the left css proprty of hidden div
function modifyHiddenWidth(width) {
    if(msg.width() || msg1.width()){
        if(msg.position().left < 0) {
            msg.css({left: (-1*width)}); 
        }
        if(msg1.position().left < 0) {
            msg1.css({left: (-1*width)});
        }
    }
}
function animateDiv() {
        let scrWidth = $(document).width();
        let msg1pos = msg1.position().left;
        let msgpos = msg.position().left;
        animateTo = msgpos < 0 ? 0 : scrWidth;
        animateTo1 = msg1pos < 0 ? 0 : scrWidth;
    
        msg1.animate({left: animateTo1},1500,function(){
            if($(this).position().left > 0) {
                $(this).css({left: (-1*scrWidth)});
            }
        });
        msg.animate({left: animateTo},1500,function(){
            if($(this).position().left > 0) {
                $(this).css({left: (-1*scrWidth)});
            }
        });
}
function startInterval() {
    interval = setInterval(()=>{
        animateDiv();
    },5000);
}
//when the documment is redy modify the hidden div left css proprty
$(document).ready(function(){
    modifyHiddenWidth($(document).width());
});
//when the documment is resized modify the hidden div left css proprty
$(window).resize(function(){
    modifyHiddenWidth($(this).width());
});

if(msg.width() || msg1.width()) {
    msg1.css({left: (-1*window.screen.width)});
    let animateTo;
    let animateTo1;
    startInterval();
}
