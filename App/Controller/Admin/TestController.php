<?php
declare(strict_types = 1);

namespace Bolge\App\Controller\Admin;

use Bolge\App\Service\ViewInterface;
use Websystems\BolgeCore\Controller;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;

class TestController extends Controller
{
    private ViewInterface $view;
    private EntityManagerInterface $em;
    private ContainerInterface $container;

    public function __construct(ViewInterface $view, EntityManagerInterface $em, ContainerInterface $container)
    {
        $this->view = $view;
        $this->em = $em;
        $this->container = $container;
    }

    public function indexAction(): Response
    {
        return $this->view->render('admin/test-index.html.twig');
    }
}
