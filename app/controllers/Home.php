<?php

namespace App;

use Sober\Controller\Controller;

class Home extends Controller
{
    public function blockCount()
    {
        $c = 0;
        foreach ([
            'home-block-one',
            'home-block-two',
            'home-block-three',
            'home-block-four',
            'home-block-five'
        ] as $block) {
            if (is_active_sidebar($block)) {
                $c++;
            }
        }
        return $c;
    }

    public function home_blocks()
    {
        $blocks = [];
        for ($i = 0; $i < 5; $i++) {
            if ($i === 0) {
                if (Home::getNextBlock()) {
                    $blocks[] = Home::getNextBlock();
                }
            } elseif ($i > 0) {
                if (Home::getNextBlock($blocks[$i - 1])) {
                    $blocks[] = Home::getNextBlock($blocks[$i - 1]);
                } else {
                    break;
                }
            }
        }

        return $blocks;
    }

    public static function getNextBlock($current_block = null)
    {
        switch ($current_block) {
            case 'home-block-one':
                $next_block = 'home-block-two';
                break;
            case 'home-block-two':
                $next_block = 'home-block-three';
                break;
            case 'home-block-three':
                $next_block = 'home-block-four';
                break;
            case 'home-block-four':
                $next_block = 'home-block-five';
                break;
            case 'home-block-five':
                $next_block = null;
                break;
            default:
                $next_block = 'home-block-one';
        }
        if (! $next_block) {
            return false;
        } elseif (is_active_sidebar($next_block)) {
            return $next_block;
        } else {
            Home::getNextBlock($next_block);
        }
    }
}
