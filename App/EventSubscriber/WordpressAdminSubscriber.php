<?php
declare(strict_types = 1);

namespace Bolge\App\EventSubscriber;

use Bolge\App\Core\Core;
use Symfony\Component\HttpFoundation\Response;
use Bolge\App\Core\Event\BootEvent;
use Bolge\App\Core\FrameworkInterface;
use Bolge\App\Service\SettingsInterface;
use Bolge\App\Core\Event\HttpKernelRequestEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class WordpressAdminSubscriber implements EventSubscriberInterface
{
    private ?Response $response;
    private SettingsInterface $settings;
    private FrameworkInterface $framework;

    public function __construct(SettingsInterface $settings, FrameworkInterface $framework)
    {
        $this->settings = $settings;
        $this->framework = $framework;
    }

    public static function getSubscribedEvents()
    {
        return [
            HttpKernelRequestEvent::NAME => [['changeRequestPath', 20]],
            BootEvent::NAME => [
                ['addAdminPages', 20],
                ['loadAssets', 40],
                ['pluginSettingsLink', 60]
            ]
        ];
    }

    public function pluginSettingsLink()
    {
        $this->framework->add_filter('plugin_action_links_' . $this->settings->get()->plugin_slug . '/' . $this->settings->get()->plugin_slug . '.php', [$this, 'settingsLinkInPlugins']);
    }

    /**
     * Add link to settings on plugin list in wp-admin
     *
     * @param array $links
     * @return array
     */
    public function settingsLinkInPlugins(array $links): array
    {
        $url = '<a href="'. Core::getAdminUrlFromRoute('admin_test') .'">' . __( 'Settings', 'bolge' ) . '</a>';
        array_unshift($links, $url);
        return $links;
    }    
    
    public function addAdminPages(BootEvent $bootEvent)
    {
        $this->response = $bootEvent->getResponse();
        $this->framework->add_action('admin_menu', [$this, 'loadToWpAdmin'], 1);
    }

    /**
     * Load templates to admin
     *
     * @return void
     */
    public function loadToWpAdmin(): void
    {
        $this->framework->add_menu_page( __( 'Bolge', 'bolge' ), __( 'Bolge', 'bolge' ),'manage_options','test',[$this, 'printResponse'],'dashicons-admin-network',10);
        //$this->framework->add_submenu_page('dashboard', __( 'Test', 'bolge' ), __( 'Test', 'bolge' ),'manage_options','license',[$this, 'printResponse'],10);  
    }

    /**
     * Enqueue assets
     *
     * @return void
     */
    public function loadAssets()
    {
        $this->framework->add_action('admin_enqueue_scripts', [$this, 'admin_assets'], 99);
    }

    /**
     * Print response content
     *
     * @return void
     */
    public function printResponse()
    {
        if(null !== $this->response) {
            echo $this->response->getContent();
        } else {
            return null;
        }
    }
    
    /**
     * Add assets to admin
     *
     * @return void
     */
    public function admin_assets(): void
    {
        $this->framework->wp_enqueue_style( 'admin-styles', $this->framework->plugins_url() . '/' . $this->settings->get()->plugin_slug_url . '/' . $this->settings->get()->urls->WS_URL_DIST . '/css/admin.css' );
        $this->framework->wp_enqueue_script( 'admin-scripts', $this->framework->plugins_url() . '/' . $this->settings->get()->plugin_slug_url . '/' . $this->settings->get()->urls->WS_URL_DIST . '/js/admin.js' );
    }    
    
    public function changeRequestPath(HttpKernelRequestEvent $event)
    {
        /** @var Request */
        $request = $event->getData();

        /** @var array */
        $pathInfo =  explode("/", $request->server->get("REQUEST_URI"));

        if('/wp-admin/admin.php' !== $request->server->get('SCRIPT_NAME') && $pathInfo[1] === "wp-admin" && isset($pathInfo[3])) {
            $response = new RedirectResponse('/');
            $response->send();
        }
        
        if('/wp-admin/admin.php' === $request->server->get('SCRIPT_NAME')) {

            /** @var array */
            $queryParameters = $request->query->all();

            /** @var string */
            $newPath = '/wp-admin';

            if(!array_key_exists("action", $queryParameters)) {
                $queryParameters['action'] = 'index';
            }

            $newPath .= '/' . $queryParameters['page'];
            $newPath .= '/' . $queryParameters['action'];

            foreach($queryParameters as $key => $queryParameter) {
                if($key != 'page' && $key != 'action') {
                    $newPath .= '/' . $queryParameter;
                }
            }        

            $request->server->set('REQUEST_URI', $newPath);
            $request->server->set('PHP_SELF', '/page.php');
            $request->server->set('SCRIPT_NAME', '/page.php');
        }
    }
}
