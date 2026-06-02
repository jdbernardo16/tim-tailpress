<?php

namespace TailPress\Walkers;

use Walker_Nav_Menu;

class FooterNavWalker extends Walker_Nav_Menu
{
    public function start_el(&$output, $item, $depth = 0, $args = [], $id = 0)
    {
        $output .= '<a href="' . esc_url($item->url) . '" class="font-garet font-light text-sm text-black hover:opacity-70 transition-opacity">';
        $output .= esc_html($item->title);
        $output .= '</a>';
    }

    public function start_lvl(&$output, $depth = 0, $args = []) {}

    public function end_lvl(&$output, $depth = 0, $args = []) {}
}
