<?php

namespace TailPress\Walkers;

use Walker_Nav_Menu;

class HeaderNavWalker extends Walker_Nav_Menu
{
    public function start_el(&$output, $item, $depth = 0, $args = [], $id = 0)
    {
        $classes = empty($item->classes) ? [] : (array) $item->classes;
        $has_children = in_array('menu-item-has-children', $classes);
        $is_active = untrailingslashit($item->url) === untrailingslashit(home_url(add_query_arg([])));
        $class_names = ($is_active ? 'text-gold' : 'text-white') . ' font-garet font-light text-base no-underline';
        $class_names .= $depth > 0 ? ' sub-menu-link' : '';

        $output .= '<a href="' . esc_url($item->url) . '" class="' . $class_names . '">';
        $output .= esc_html($item->title);

        if ($has_children) {
            $output .= '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="menu-chevron inline-block ml-1"><path d="m6 9 6 6 6-6"/></svg>';
        }

        $output .= '</a>';
    }

    public function start_lvl(&$output, $depth = 0, $args = [])
    {
        $output .= '<div class="sub-menu">';
    }

    public function end_lvl(&$output, $depth = 0, $args = [])
    {
        $output .= '</div>';
    }
}
