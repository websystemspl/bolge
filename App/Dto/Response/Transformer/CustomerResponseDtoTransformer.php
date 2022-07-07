<?php

declare(strict_types=1);

namespace Bolge\App\Dto\Response\Transformer;

use Bolge\App\Entity\Customer;
use Bolge\App\Dto\Response\CustomerResponseDto;
use Bolge\App\Dto\Exception\UnexpectedTypeException;
use Bolge\App\Dto\Response\Transformer\AbstractResponseDtoTransformer;

class CustomerResponseDtoTransformer extends AbstractResponseDtoTransformer
{
    private AddressResponseDtoTransformer $addressResponseDtoTransformer;

    public function __construct(
        AddressResponseDtoTransformer $addressResponseDtoTransformer
    ) {
        $this->addressResponseDtoTransformer = $addressResponseDtoTransformer;
    }

    /**
     * @param Customer $customer
     *
     * @return CustomerResponseDto
     */
    public function transformFromObject($customer): CustomerResponseDto
    {
        if (!$customer instanceof Customer) {
            throw new UnexpectedTypeException('Expected type of Customer but got ' . \get_class($customer));
        }

        $dto = new CustomerResponseDto();
        $dto->firstName = $customer->getFirstName();
        $dto->lastName = $customer->getLastName();
        $dto->addresses = $this->addressResponseDtoTransformer->transformFromObjects($customer->getAddresses());
        $dto->created = $customer->getCreated();
        
        return $dto;
    }
}