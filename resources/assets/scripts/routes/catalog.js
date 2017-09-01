const jQueryBridget = require('jquery-bridget');
const Isotope = require('isotope-layout');

export default {
  init() {
    // JavaScript to be fired on the catalog page
    jQueryBridget('isotope', Isotope, $);
    let $grid = $('.books');
    $grid.isotope({
      itemSelector: '.book',
      getSortData: {
        title: '.title a',
        subject: '[data-subject]',
        latest: '[data-date-published]',
      },
      sortBy: 'title',
    });
    $('.filters > a').click((e) => {
      e.preventDefault();
      $('.filters').toggleClass('is-active');
      $('.filter-groups > div').removeClass('is-active');
    })
    $('.filter-groups .subjects > a').click((e) => {
      e.preventDefault();
      let id = $(e.currentTarget).attr('href');
      $(`.filter-groups .subjects:not(${id})`).removeClass('is-active');
      $(`.filter-groups ${id}`).toggleClass('is-active');
    })
    $('.filter-groups .licenses > a').click((e) => {
      e.preventDefault();
      let id = $(e.currentTarget).attr('href');
      $(`.filter-groups ${id}`).toggleClass('is-active');
    })
    $('.subjects .filter-list a').click((e) => {
      let subjectValue = $(e.currentTarget).attr('data-filter');
      let licenseValue = $('.licenses .filter-list a.is-active').attr('data-filter');
      if(typeof licenseValue === "undefined") {
        licenseValue = '';
      } else {
        licenseValue = `[data-license="${licenseValue}"]`;
      }
      $('.subjects .filter-list a').removeClass('is-active');
      $(e.currentTarget).addClass('is-active');
      $grid.isotope({ filter: `[data-subject="${subjectValue}"]${licenseValue}` });
    });
    $('.licenses .filter-list a').click((e) => {
      let licenseValue = $(e.currentTarget).attr('data-filter');
      let subjectValue = $('.subjects .filter-list a.is-active').attr('data-filter');
      if(typeof subjectValue === "undefined") {
        subjectValue = '';
      } else {
        subjectValue = `[data-subject="${subjectValue}"]`;
      }
      $('.licenses .filter-list a').removeClass('is-active');
      $(e.currentTarget).addClass('is-active');
      $grid.isotope({ filter: `[data-license="${licenseValue}"]${subjectValue}` });
    });
    $('.sort > a').click((e) => {
      e.preventDefault();
      $('.sort').toggleClass('is-active');
    })
    $('.sorts a').click((e) => {
      let sortBy = $(e.currentTarget).attr('href').substr(1);
      $('.sorts a').removeClass('is-active');
      $(e.currentTarget).addClass('is-active');
      $grid.isotope({sortBy: sortBy});
    });
  },
  finalize() {
  },
};
