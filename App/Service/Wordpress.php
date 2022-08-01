<?php

namespace Bolge\App\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Generator\UrlGenerator;

include(ABSPATH . "wp-includes/pluggable.php");

class Wordpress implements WordpressInterface
{
	private $container;

	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}

    public function authenticateCookieLoggedIn(Request $request): ?int
    {
        $wordpressLoggedInCookieName = 'wordpress_logged_in_' . md5(\get_site_option('siteurl'));
        if($userId = $this->wp_validate_auth_cookie($request->cookies->get($wordpressLoggedInCookieName), 'logged_in')) {
            return $userId;
        } else {
            return null;
        }
    }

    public function database()
    {
        global $wpdb;
        return $wpdb;
    }

    public function get_header()
    {
        return \get_header();
    }

    public function get_footer()
    {
        return \get_footer();
    }

    /**
     * Generate url to admin page by route
     *
     * @param string $route
     * @param array $values
     * @return ?string
     */
    public function getAdminUrlFromRoute(string $route, array $values = []): ?string
    {
        $generator = new UrlGenerator($this->container->get('routes'), new RequestContext());
        $generated = $generator->generate($route, $values);
        $generated = explode("/", $generated);
        $new = '/wp-admin/admin.php?';
        foreach($generated as $key => $par) {
            if($key === 2) {
                $new .= 'page='.$par;
            }
            if($key === 3) {
                $new .= '&action='.$par;
            }
        }

        $defaults = @$this->container->get('routes')->all()[$route] ?: null;

        foreach($defaults->getDefaults() as $key => $param) {
            if(isset($values[$key])) {
                if($values[$key] === "") {
                    return null;
                }
                $new .= '&'.$key.'='.$values[$key];
            }
        }

        return $new;
    }


    public function add_action($hook_name, $callback, $priority = 10, $accepted_args = 1)
    {
        return \add_action($hook_name, $callback, $priority, $accepted_args);
    }

    public function add_filter($hook_name, $callback, $priority = 10, $accepted_args = 1)
    {
        return \add_filter($hook_name, $callback, $priority, $accepted_args);
    }

    public function wp_validate_auth_cookie($cookie = '', $scheme = '')
    {
        return \wp_validate_auth_cookie($cookie, $scheme);
    }

    public function wp_redirect($location, $status = 302, $x_redirect_by = 'WordPress')
    {
        return \wp_redirect($location, $status, $x_redirect_by);
    }

    public function home_url($path = '', $scheme = null)
    {
        return \home_url($path, $scheme);
    }

    public function menu_page_url($menu_slug, $echo = \true)
    {
        return \menu_page_url($menu_slug, $echo);
    }

    public function update_option($option, $value, $autoload = \null)
    {
        return \update_option($option, $value, $autoload);
    }

    public function get_option($option, $default = \false)
    {
        return \get_option($option, $default);
    }

    public function sendMail($to, $subject, $message, $headers = '', $attachments = array())
    {
        return \wp_mail($to, $subject, $message, $headers, $attachments);
    }

    public function get_permalink($post = 0, $leavename = \false)
    {
        return \get_permalink($post, $leavename);
    }

    public function do_action($tag, ...$arg)
    {
        return \do_action($tag, $arg);
    }

    public function apply_filters($tag, $value)
    {
        return \apply_filters($tag, $value);
    }

    public function wp_enqueue_style($handle, $src = '', $deps = array(), $ver = \false, $media = 'all')
    {
        return \wp_enqueue_style($handle, $src, $deps, $ver, $media);
    }

    public function wp_enqueue_script($handle, $src = '', $deps = array(), $ver = \false, $in_footer = \false)
    {
        return \wp_enqueue_script($handle, $src, $deps, $ver, $in_footer);
    }

    public function plugins_url($path = '', $plugin = '')
    {
        return \plugins_url($path, $plugin);
    }

    public function add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function = '', $icon_url = '', $position = \null)
    {
        return \add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position);
    }

    public function add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function = '', $position = \null)
    {
        return \add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function, $position);
    }
}
