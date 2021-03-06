<?php
declare(strict_types = 1);

namespace Bolge\App\EventSubscriber;

use Bolge\App\Service\SettingsInterface;
use Bolge\App\Service\WordpressInterface;
use Websystems\BolgeCore\Event\BootEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class WordpressFrontSubscriber implements EventSubscriberInterface
{
    private SettingsInterface $settings;
    private WordpressInterface $wordpress;
    private ?Response $response;

    public function __construct(SettingsInterface $settings, WordpressInterface $wordpress)
    {
        $this->settings = $settings;
        $this->wordpress = $wordpress;
    }

    public static function getSubscribedEvents()
    {
        return [
            BootEvent::NAME => [
                ['loadAssets', 20],
                ['loadTemplate', 20],
            ]
        ];
    }

	/**
	 * Load response to wordpress
	 *
	 * @param BootEvent $bootEvent
	 * @return void
	 */
    public function loadTemplate(BootEvent $bootEvent)
    {
        $this->response = $bootEvent->getResponse();
        $this->wordpress->add_filter('template_include', [$this, 'showResponse'], 999, 1);
    }

	/**
	 * Load assets to wordpress
	 *
	 * @return void
	 */
    public function loadAssets(): void
    {
        $this->wordpress->add_action('wp_enqueue_scripts', [$this, 'assets'], 99);
    }

    /**
     * Show response from bolge core
     *
     * @param string $template
     * @return string|null
     */
    public function showResponse(string $template): ?string
    {
        if(null !== $this->response) {
            if("" !== $this->response->getContent()) {

				global $wp_query;
				status_header( 200 );
				$wp_query->is_404=false;

                $this->wordpress->get_header();
                echo $this->response->getContent();
                $this->wordpress->get_footer();
				return null;
            } else {
                return $template;
            }
        } else {
            return $template;
        }
    }

    /**
     * Add assets to front
     *
     * @return void
     */
    public function assets(): void
    {
        $this->wordpress->wp_enqueue_style( 'front-styles', $this->wordpress->plugins_url() . '/' . $this->settings->get()->plugin_slug_url . '/' . $this->settings->get()->urls->WS_URL_DIST . '/css/app.css' );
        $this->wordpress->wp_enqueue_script( 'front-scripts', $this->wordpress->plugins_url() . '/' . $this->settings->get()->plugin_slug_url . '/' . $this->settings->get()->urls->WS_URL_DIST . '/js/app.js' );
    }
}
