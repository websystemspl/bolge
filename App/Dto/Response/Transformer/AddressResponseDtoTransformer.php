<?php

declare(strict_types=1);

namespace Bolge\App\Dto\Response\Transformer;

use Bolge\App\Dto\Exception\UnexpectedTypeException;
use Bolge\App\Dto\Response\AddressResponseDto;
use Bolge\App\Entity\Address;

class AddressResponseDtoTransformer extends AbstractResponseDtoTransformer
{
    /**
     * @param Address $address
     *
     * @return AddressResponseDto
     */
    public function transformFromObject($address): AddressResponseDto
    {
        if (!$address instanceof Address) {
            throw new UnexpectedTypeException('Expected type of Address but got ' . \get_class($address));
        }

        $dto = new AddressResponseDto();
        $dto->country = $address->getCountry();
        $dto->city = $address->getCity();
        $dto->address = $address->getAddress();
        $dto->postCode = $address->getPostCode();
        $dto->created = $address->getCreated();
       
        return $dto;
    }
}