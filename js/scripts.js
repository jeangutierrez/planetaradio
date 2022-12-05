$(document).ready(function() {
  $(".icons li a").find("img").css({filter:'grayscale(100%)',opacity:0.4});
  $(".icons li a").hover(function() {
    $(this).find("img").stop().css({filter:'grayscale(0)',opacity:1 }, 400);		    
  },function(){
  $(this).find("img").stop().css({filter:'grayscale(100%)',opacity:0.4 }, 400);		   
  });
});

$(window).load(function() {
  setTimeout(function () {				
    $('.spinner').fadeOut();
    $('body').css({overflow:'hidden'});
  }, 200);	
});