<?php

namespace WsLicenseManager\Test\Mock;

use Symfony\Component\HttpFoundation\Request;
use WsLicenseManager\App\Core\FrameworkInterface;

class FrameworkMock implements FrameworkInterface
{
    public function get_header()
    {

    }
    
    public function get_footer()
    {

    }
    
    public function add_action($hook_name, $callback, $priority = 10, $accepted_args = 1)
    {

    }
    
    public function add_filter($hook_name, $callback, $priority = 10, $accepted_args = 1)
    {

    }
    
    public function wp_validate_auth_cookie($cookie = '', $scheme = '')
    {

    }
    
    public function authenticateCookieLoggedIn(Request $request)
    {

    }
    
    public function wp_redirect($location, $status = 302, $x_redirect_by = 'WordPress')
    {

    }
    
    public function home_url($path = '', $scheme = null)
    {

    }
    
    public function menu_page_url($menu_slug, $echo = \true)
    {

    }
    
    public function database()
    {

    }
    
    public function update_option($option, $value, $autoload = \null)
    {

    }
    
    public function get_option($option, $default = \false)
    {

    }
    
    public function sendMail($to, $subject, $message, $headers = '', $attachments = array())
    {

    }
    
    public function get_permalink($post = 0, $leavename = \false)
    {

    }
    
    public function do_action($tag, ...$arg)
    {

    }
    
    public function apply_filters($tag, $value)
    {

    }
    
    public function get_users($args = array())
    {

    }
    
}