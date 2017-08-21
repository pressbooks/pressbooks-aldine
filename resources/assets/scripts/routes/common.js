export default {
  init() {
    // JavaScript to be fired on all pages
    $('.toggle-menu').click((event) => {
      event.preventDefault();
      $(event.currentTarget).toggleClass('is-active');
      $('.primary-navigation').toggleClass('is-visible');
    });
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
