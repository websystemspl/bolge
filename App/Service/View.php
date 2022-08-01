<?php

namespace Bolge\App\Service;

use Twig\Environment;
use Twig\TwigFunction;
use Twig\Loader\FilesystemLoader;
use Bolge\App\Service\SettingsInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class View implements ViewInterface
{
    private Environment $twig;
    private Session $session;
    private SettingsInterface $settings;
	private UrlGeneratorInterface $urlGenerator;
	private WordpressInterface $wordpress;

    public function __construct(SettingsInterface $settings, UrlGeneratorInterface $urlGenerator, WordpressInterface $wordpress)
    {
        $this->settings = $settings;
        $this->urlGenerator = $urlGenerator;
		$this->wordpress = $wordpress;
        $this->session = new Session();
        $this->buildTwig();
    }

    public function render(string $path, array $params = []): Response
    {
       return new Response($this->twig->render($path, $params));
    }

    public function display(string $path, array $params = [])
    {
        return $this->twig->render($path, $params);
    }

    public function addFlash(string $type, string $message): void
    {
        $this->session = new Session();
        $this->session->getFlashBag()->add(
            $type,
            $message
        );
    }

    private function buildTwig(): void
    {
        $this->loader = new FilesystemLoader(DIR_PATH . $this->settings->get()->paths->WS_PATH_VIEWS);
        $this->twig = new Environment($this->loader, [
            'cache' => DIR_PATH . $this->settings->get()->paths->WS_PATH_CACHE,
            'auto_reload' => true,
            'debug' => false,
            'strict_variables ' => true,
        ]);

        $howManyDays = new TwigFunction('how_many_days', function ($dateNow, $dateto) {
            $dateNow = new \DateTime($dateNow);
            $dateTo = new \DateTime($dateto);
            $days = 0;

            if(1 === $dateTo->diff($dateNow)->invert) {
                $days = $dateTo->diff($dateNow)->days;
            }

            return $days;
        });

        $gettext = new TwigFunction('__', function ($text, $textdomain) {
            return __( $text, $textdomain );
        });

        $getAdminUrlFromRoute = new TwigFunction('get_admin_url_from_route', function ($route, $values = []) {
            return $this->wordpress->getAdminUrlFromRoute($route, $values);
        });

        $nonce = new TwigFunction('wp_nonce_field', function ($nonceField) {
            return wp_nonce_field( $nonceField );
        });

        $urlGeneratorUrl = new TwigFunction('url', function ($name, $parameters = []) {
            return $this->urlGenerator->generate($name, $parameters, false);
        });

        $urlGeneratorPath = new TwigFunction('path', function ($name, $parameters = []) {
            return $this->urlGenerator->generate($name, $parameters, true);
        });

        $stripslashes = new TwigFunction('stripslashes', function ($string) {
            if(empty($string)) {
                return '';
            }
            return stripslashes($string);
        });

        $this->twig->addGlobal("session", $this->session);
        $this->twig->addGlobal("settings", $this->settings->get(true));
        $this->twig->addFunction($gettext);
        $this->twig->addFunction($howManyDays);
        $this->twig->addFunction($stripslashes);
        $this->twig->addFunction($getAdminUrlFromRoute);
        $this->twig->addFunction($nonce);
        $this->twig->addFunction($urlGeneratorUrl);
        $this->twig->addFunction($urlGeneratorPath);
    }
}
