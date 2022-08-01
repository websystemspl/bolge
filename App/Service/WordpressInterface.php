<?php
declare(strict_types = 1);

namespace Bolge\App\Service;

use Symfony\Component\HttpFoundation\Request;

interface WordpressInterface
{
    public function authenticateCookieLoggedIn(Request $request): ?int;
    public function database();
    public function get_header();
    public function get_footer();
	public function getAdminUrlFromRoute(string $route, array $values = []): ?string;
    public function add_action($hook_name, $callback, $priority = 10, $accepted_args = 1);
    public function add_filter($hook_name, $callback, $priority = 10, $accepted_args = 1);
    public function wp_validate_auth_cookie($cookie = '', $scheme = '');
    public function wp_redirect($location, $status = 302, $x_redirect_by = 'WordPress');
    public function home_url($path = '', $scheme = null);
    public function menu_page_url($menu_slug, $echo = \true);
    public function update_option($option, $value, $autoload = \null);
    public function get_option($option, $default = \false);
    public function sendMail($to, $subject, $message, $headers = '', $attachments = array());
    public function get_permalink($post = 0, $leavename = \false);
    public function do_action($tag, ...$arg);
    public function apply_filters($tag, $value);
    public function wp_enqueue_style($handle, $src = '', $deps = array(), $ver = \false, $media = 'all');
    public function wp_enqueue_script($handle, $src = '', $deps = array(), $ver = \false, $in_footer = \false);
    public function plugins_url($path = '', $plugin = '');
    public function add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function = '', $icon_url = '', $position = \null);
    public function add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function = '', $position = \null);
}
