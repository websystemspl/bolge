<?php

namespace Bolge\App\Service;

use Symfony\Component\HttpFoundation\Request;

include(ABSPATH . "wp-includes/pluggable.php"); 

class Wordpress implements WordpressInterface
{
    public function __call($function, $arguments) {
 
        if (!function_exists($function)) {
            trigger_error('call to unexisting function ' . $function, E_USER_ERROR);
            return NULL;
        }
        return call_user_func_array($function, $arguments);
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
}
