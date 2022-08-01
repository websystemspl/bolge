<?php
declare(strict_types = 1);

namespace Bolge\App\EventSubscriber;

use Websystems\BolgeCore\BolgeCore;
use Bolge\App\Service\SettingsInterface;
use Bolge\App\Service\WordpressInterface;
use Websystems\BolgeCore\Event\BootEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Websystems\BolgeCore\Event\HttpKernelRequestEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class WordpressAdminSubscriber implements EventSubscriberInterface
{
    private ?Response $response;
    private SettingsInterface $settings;
    private WordpressInterface $wordpress;

    public function __construct(SettingsInterface $settings, WordpressInterface $wordpress)
    {
        $this->settings = $settings;
        $this->wordpress = $wordpress;
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

	/**
	 * Add link to settings on plugin list in wp-admin
	 *
	 * @return void
	 */
    public function pluginSettingsLink()
    {
        $this->wordpress->add_filter('plugin_action_links_' . $this->settings->get()->plugin_slug . '/' . $this->settings->get()->plugin_slug . '.php', [$this, 'settingsLinkInPlugins']);
    }

    /**
     * link to settings on plugin list in wp-admin
     *
     * @param array $links
     * @return array
     */
    public function settingsLinkInPlugins(array $links): array
    {
        $url = '<a href="'. $this->wordpress->getAdminUrlFromRoute('admin_test') .'">' . __( 'Settings', 'bolge' ) . '</a>';
        array_unshift($links, $url);
        return $links;
    }

	/**
	 * Add menu pages to wp-admin menu
	 *
	 * @param BootEvent $bootEvent
	 * @return void
	 */
    public function addAdminPages(BootEvent $bootEvent)
    {
        $this->response = $bootEvent->getResponse();
        $this->wordpress->add_action('admin_menu', [$this, 'adminMenuPageList'], 1);
    }

    /**
     * Admin menu page list
     *
     * @return void
     */
    public function adminMenuPageList(): void
    {
        $this->wordpress->add_menu_page( __( 'Bolge', 'bolge' ), __( 'Bolge', 'bolge' ),'manage_options','test',[$this, 'printResponse'],'dashicons-admin-network',10);
    }

    /**
     * Enqueue assets
     *
     * @return void
     */
    public function loadAssets()
    {
        $this->wordpress->add_action('admin_enqueue_scripts', [$this, 'assets'], 99);
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
    public function assets(): void
    {
        $this->wordpress->wp_enqueue_style( 'admin-styles', $this->wordpress->plugins_url() . '/' . $this->settings->get()->plugin_slug_url . '/' . $this->settings->get()->urls->WS_URL_DIST . '/css/admin.css' );
        $this->wordpress->wp_enqueue_script( 'admin-scripts', $this->wordpress->plugins_url() . '/' . $this->settings->get()->plugin_slug_url . '/' . $this->settings->get()->urls->WS_URL_DIST . '/js/admin.js' );
    }

	/**
	 * Fix http request for symfony routing in wp-admin
	 *
	 * @param HttpKernelRequestEvent $event
	 * @return void
	 */
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
