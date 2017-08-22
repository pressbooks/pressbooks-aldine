<?php

namespace App;

use Sober\Controller\Controller;

class Home extends Controller
{
    function block_count() {
        $c = 0;
      foreach(['home-block-one', 'home-block-two', 'home-block-three', 'home-block-four', 'home-block-five'] as $block) {
          if (is_active_sidebar($block)) {
              $c++;
          }
      }
      return $c;
    }
}
