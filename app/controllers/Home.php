<?php

namespace Aldine;

use Sober\Controller\Controller;

class Home extends Controller
{
    public function blockCount()
    {
        $c = 0;
        foreach ([
            'home-block-1',
            'home-block-2',
            'home-block-3',
            'home-block-4',
            'home-block-5'
        ] as $block) {
            if (is_active_sidebar($block)) {
                $c++;
            }
        }
        return $c;
    }

    public function homeBlocks()
    {
        $blocks = [];
        for ($i = 0; $i < 5; $i++) {
            if (is_active_sidebar("home-block-$i")) {
                $blocks[] = "home-block-$i";
            }
        }

        return $blocks;
    }
}
