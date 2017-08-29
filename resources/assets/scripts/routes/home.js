const WPAPI = require( 'wpapi' );

export default {
  init() {
    // JavaScript to be fired on the home page
    let books = $('.books');
    let pb = new WPAPI({ endpoint: 'http://pressbooks.dev/wp-json' });
    pb.books = pb.registerRoute( 'pressbooks/v2', '/books/' );

    function loadNextPage() {
      let nextpage = books.attr('data-next-page');
      if (typeof nextpage !== typeof undefined && nextpage !== false) {
        const total = parseInt($('.books').attr('data-total-pages'));
        const page = parseInt($('.books').attr('data-next-page'));
        pb.books().perPage(3).page(page).then(function(data) {
          data.forEach((book) => {
            books.slick('slickAdd', `<div class="book w-100 bg-secondary b--secondary">
              <p class="subject tc ma0"><a href="">Fiction</a></p>
              <p class="title tc ma0"><a href="${book.link}">${book.metadata.name}</a></p>
              <p class="read-more tl ma0"><a href="${book.link}">About this book &rarr;</a></p>
            </div>`); // TODO Localize
          });
          if (page < total) {
            books.attr('data-next-page', page + 1);
          } else {
            books.removeAttr('data-next-page');
          }
        }).catch(function(err) { // TODO handle error
          console.error(err); //  eslint-disable-line
        });
      }
    }

    books.on('init', () => {
      loadNextPage();
    })

    books.slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      infinite: false,
      mobileFirst: true,
      prevArrow: '.latest-books .navigation .previous',
      nextArrow: '.latest-books .navigation .next',
      responsive: [
        {
          breakpoint: 960,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
          },
        },
      ],
      variableWidth: true,
    });

    books.on('afterChange', (slick, currentSlide) => {
      if((parseInt($('.slick-active:last').attr('data-slick-index')) + 1) === currentSlide.slideCount) {
        loadNextPage(true);
      }
    })
  },
  finalize() {
  },
};
