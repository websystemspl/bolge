<?php
declare(strict_types = 1);

namespace Bolge\App\EventSubscriber;

use Bolge\App\Core\Event\BootEvent;
use Bolge\App\Service\ViewInterface;
use Bolge\App\Core\FrameworkInterface;
use Bolge\App\Service\SettingsInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class WordpressFrontSubscriber implements EventSubscriberInterface
{
    private SettingsInterface $settings;
    private FrameworkInterface $framework;
    private ?Response $response;
    private ?Request $request;
    private EntityManagerInterface $em;
    private ViewInterface $view;

    public function __construct(SettingsInterface $settings, FrameworkInterface $framework, EntityManagerInterface $em, ViewInterface $view)
    {
        $this->settings = $settings;
        $this->framework = $framework;
        $this->em = $em;
        $this->view = $view;
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

    public function loadTemplate($bootEvent)
    {
        $this->response = $bootEvent->getResponse();
        $this->framework->add_filter('template_include', [$this, 'showResponse'], 999, 1);
    }

    public function loadAssets()
    {
        $this->framework->add_action('wp_enqueue_scripts', [$this, 'assets'], 99);
    }

    /**
     * Load templates to front
     *
     * @param string $template
     * @return string|null
     */
    public function showResponse(string $template)//: ?string
    {
        if(null !== $this->response) {
            if("" !== $this->response->getContent()) {
                $this->framework->get_header();
                echo $this->response->getContent();
                $this->framework->get_footer();
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
        $this->framework->wp_enqueue_style( 'front-styles', $this->framework->plugins_url() . '/' . $this->settings->get()->plugin_slug_url . '/' . $this->settings->get()->urls->WS_URL_DIST . '/css/app.css' );
        $this->framework->wp_enqueue_script( 'front-scripts', $this->framework->plugins_url() . '/' . $this->settings->get()->plugin_slug_url . '/' . $this->settings->get()->urls->WS_URL_DIST . '/js/app.js' );
    }
}
