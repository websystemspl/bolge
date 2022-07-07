<?php
declare(strict_types = 1);

namespace Bolge\App\Controller\Api;

use Bolge\App\Core\Controller;
use Bolge\App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Bolge\App\Dto\Response\Transformer\CustomerResponseDtoTransformer;

class TestController extends Controller
{
    private $em;
    private $customerResponseDtoTransformer;

    public function __construct(EntityManagerInterface $em, CustomerResponseDtoTransformer $customerResponseDtoTransformer)
    {
        $this->em = $em;
        $this->customerResponseDtoTransformer = $customerResponseDtoTransformer;
    }

    /**
     * Get Customers
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function indexAction(): JsonResponse
    {
        $customerCollection = $this->em->getRepository(Customer::class)->findAll();
        $customerCollectionDto = $this->customerResponseDtoTransformer->transformFromObjects($customerCollection);
        $response = new JsonResponse($customerCollectionDto);
        $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT);
        return $response->send();        
    }
}
