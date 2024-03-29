$(function () {
  var jcarousel = $('.jcarousel');
  jcarousel
  .on('jcarousel:reload jcarousel:create', function () {
    jcarousel.jcarousel('items').width(jcarousel.innerWidth());
  })

  .jcarousel({
    wrap: 'circular',
    transitions: Modernizr.csstransitions ? {
      transforms:   Modernizr.csstransforms,
      transforms3d: Modernizr.csstransforms3d,
      easing: 'ease'
    } : false
  });
  jcarousel.jcarouselAutoscroll({
    interval: 4000
  });
  $('.jcarousel-control-prev')
  .on('jcarouselcontrol:active', function() {
    $(this).removeClass('inactive');
  })
  .on('jcarouselcontrol:inactive', function() {
    $(this).addClass('inactive');
  })
  .jcarouselControl({
    target: '-=1'
  });
  $('.jcarousel-control-next')
  .on('jcarouselcontrol:active', function() {
    $(this).removeClass('inactive');
  })
  .on('jcarouselcontrol:inactive', function() {
    $(this).addClass('inactive');
  })
  .on('click', function(e) {
    e.preventDefault();
  })
  .jcarouselControl({
    target: '+=1'
  });
  $('.jcarousel-pagination')
  .on('jcarouselpagination:active', 'a', function() {
    $(this).addClass('active');
  })
  .on('jcarouselpagination:inactive', 'a', function() {
    $(this).removeClass('active');
  })
  .on('click', function(e) {
    e.preventDefault();
  })
  .jcarouselPagination({
    item: function(page) {
      return '<a href="#' + page + '">' + page + '</a>';
    }
  });
});
