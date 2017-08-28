const WPAPI = require( 'wpapi' );

export default {
  init() {
    // JavaScript to be fired on the home page
    let pb = new WPAPI({ endpoint: 'http://pressbooks.dev/wp-json' });
    pb.books = pb.registerRoute( 'pressbooks/v2', '/books/' );
    const total = parseInt($('.navigation').attr('data-total'));
    $('.latest-books .navigation .next, .latest-books .navigation .previous').live('click', (event) => {
      event.preventDefault();
      const page = parseInt($(event.currentTarget).attr('data-page'));
      pb.books().perPage(3).page(page).then(function(data) {
        let books = '', nav = '';
        data.forEach((book) => {
          books = books + `<div class="book">
            <a class="subject" href="">Fiction</a>
            <a class="title" href="${book.link}">${book.metadata.name}</a>
            <a class="read-more" href="${book.link}">About this book &rarr;</a>
          </div>`;
        });
        $('.books').html(books);
        if (page > 1 && page < total) {
          nav = nav + `<a class="previous f1" data-page="${page - 1}" href="/page/${page - 1}/">&larr;</a>
            <a class="next f1" data-page="${page + 1}" href="/page/${page + 1}/">&rarr;</a>`;
        } else if (page > 1 && page === total) {
          nav = nav + `<a class="previous f1" data-page="${page - 1}" href="/page/${page - 1}/">&larr;</a>`;
        } else {
          nav = nav + `<a class="next f1" data-page="${page + 1}" href="/page/${page + 1}/">&rarr;</a>`;
        }
        $('.latest-books .navigation').html(nav);
      }).catch(function(err) {
        console.error(err); // eslint-disable-line
      });
    });
  },
  finalize() {
    // JavaScript to be fired on the home page, after the init JS
  },
};
