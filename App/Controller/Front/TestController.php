<?php
declare(strict_types = 1);

namespace Bolge\App\Controller\Front;

use Bolge\App\Entity\Customer;
use Bolge\App\Service\ViewInterface;
use Bolge\App\Service\WordpressInterface;
use Websystems\BolgeCore\Controller;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class TestController extends Controller
{
    private ViewInterface $view;
    private EntityManagerInterface $em;
    private WordpressInterface $wordpress;

    public function __construct(ViewInterface $view, EntityManagerInterface $em, WordpressInterface $wordpress)
    {
        $this->view = $view;
        $this->em = $em;
        $this->wordpress = $wordpress;
    }

    public function indexAction(): Response
    {
		$this->wordpress->add_filter('pre_get_document_title', function(){
			return 'TEST PAGE TITLE';
		});

        $customers = $this->em->getRepository(Customer::class)->findAll();

        return $this->view->render('test.html.twig', [
            'customers' => $customers,
        ]);
    }
}
