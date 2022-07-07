<?php

namespace Bolge\App\Repository;

use Doctrine\ORM\EntityRepository;

class AddressRepository extends EntityRepository
{
    public function findByCustomerLastName(string $lastName)
    {
        /** @var QueryBuilder $qb */
        $qb = $this->createQueryBuilder('a')
            ->leftJoin('a.customer', 'customer')
            ->andWhere('customer.last_name = :last_name')
            ->setParameter('last_name', $lastName)
        ;

        $result = $qb->getQuery()->getResult();
        
        return $result;          
    }
}