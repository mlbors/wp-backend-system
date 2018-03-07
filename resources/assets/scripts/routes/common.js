export default {
  init() {
    
    var navlist = [];
    
    $("section.page-section").each(function() {
      var thisLink = $(this);
      var thisId = thisLink.attr('id');
      var thisTarget = $(thisId);
      navlist.push({
        'anchor': thisLink,
        'id': thisId,
        'target': thisTarget,
      });
      thisLink.on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({
          scrollTop: thisTarget.offset().top,
        }, 800);
      });
    });

    $(window).on('scroll resize', function() {
      $.each(navlist, function(e, elem) {
        var placement = document.getElementById(elem.id).getBoundingClientRect();
        if( placement.top <= window.innerHeight && placement.bottom > 0 ) {
          history.pushState({}, '', elem.id);
            return false;
          }
      });
    });

  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
