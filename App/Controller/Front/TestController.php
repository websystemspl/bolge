<?php
declare(strict_types = 1);

namespace Bolge\App\Controller\Front;

use Bolge\App\Entity\Customer;
use Bolge\App\Service\ViewInterface;
use Websystems\BolgeCore\Controller;
use Doctrine\ORM\EntityManagerInterface;
use Bolge\App\Service\KeyGeneratorInterface;
use Websystems\BolgeCore\FrameworkInterface;
use Symfony\Component\HttpFoundation\Response;

class TestController extends Controller
{
    private ViewInterface $view;
    private EntityManagerInterface $em;

    public function __construct(ViewInterface $view, EntityManagerInterface $em, KeyGeneratorInterface $keyGenerator)
    {
        $this->view = $view;
        $this->em = $em;
    }

    public function indexAction(): Response
    {
        $customers = $this->em->getRepository(Customer::class)->findAll();

        return $this->view->render('test.html.twig', [
            'customers' => $customers,
        ]);
    }
}
