<?php
declare(strict_types = 1);

namespace Bolge\App\Controller\Front;

use Bolge\App\Core\Controller;
use Bolge\App\Entity\Customer;
use Bolge\App\Service\ViewInterface;
use Bolge\App\Core\FrameworkInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

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
        $customers = $this->em->getRepository(Customer::class)->findAll();

        return $this->view->render('test.html.twig', [
            'customers' => $customers,
        ]);
    }
}
