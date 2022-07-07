<?php
declare(strict_types = 1);

namespace Bolge\App\Controller\Admin;

use Doctrine\ORM\EntityManagerInterface;
use Bolge\App\Core\Controller;
use Symfony\Component\HttpFoundation\Response;
use Bolge\App\Service\ViewInterface;
use Bolge\App\Core\FrameworkInterface;

class TestController extends Controller
{
    private ViewInterface $view;
    private EntityManagerInterface $em;
    private FrameworkInterface $framework;

    public function __construct(ViewInterface $view, EntityManagerInterface $em, FrameworkInterface $framework)
    {
        $this->view = $view;
        $this->em = $em;
        $this->framework = $framework;
    }

    public function indexAction(): Response
    {
        return $this->view->render('admin/test-index.html.twig');
    }
}
