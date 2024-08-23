jQuery(function($) {
    $('.velocity-post-carousel').slick({
      slidesToShow: 3,
      slidesToScroll: 1,
      arrows: true,
      focusOnSelect: true,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
            infinite: true,
            dots: true
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2
          }
        }
        ]
    });
    });