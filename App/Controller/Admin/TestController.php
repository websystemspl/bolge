<?php
declare(strict_types = 1);

namespace Bolge\App\Controller\Admin;

use Doctrine\ORM\EntityManagerInterface;
use Websystems\BolgeCore\Controller;
use Symfony\Component\HttpFoundation\Response;
use Bolge\App\Service\ViewInterface;

class TestController extends Controller
{
    private ViewInterface $view;
    private EntityManagerInterface $em;

    public function __construct(ViewInterface $view, EntityManagerInterface $em)
    {
        $this->view = $view;
        $this->em = $em;
    }

    public function indexAction(): Response
    {
        return $this->view->render('admin/test-index.html.twig');
    }
}
