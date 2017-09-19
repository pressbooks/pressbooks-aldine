export default {
  init() {
    // JavaScript to be fired on all pages
    $('body').removeClass('no-js').addClass('js');
    $('.toggle').click((event) => {
      event.preventDefault();
      $(event.currentTarget).toggleClass('toggle--active');
      $('.banner__navigation').toggleClass('banner__navigation--visible');
    });
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
