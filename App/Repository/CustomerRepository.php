<?php

namespace Bolge\App\Repository;

use Doctrine\ORM\EntityRepository;
use Bolge\App\Core\Core;
use Doctrine\ORM\Query\ResultSetMapping;
use Bolge\App\Entity\Customer;
use Doctrine\Common\Collections\Criteria;

class CustomerRepository extends EntityRepository
{
    // public function canAddDomainToLicense(int $licenseId)
    // {
    //     /** @var QueryBuilder $qb */
    //     $qb = $this->createQueryBuilder('l')
    //         ->where('l.id = :id')
    //         ->setParameter('id', $licenseId)
    //     ;

    //     $license = $qb->getQuery()->getOneOrNullResult();

    //     if((int) $license->getLimit() === 0) {
    //         return true;
    //     }

    //     if((int) $license->getLimit() > count($license->getDomains())) {
    //         return true;
    //     }

    //     return false;
    // }


    // public function findExpires($days)
    // {
    //     $dateNow = new \DateTime('now');
    //     $dateFuture = new \DateTime('now');
    //     $dateFuture->add(new \DateInterval('P5D'));
        

    //     /** @var QueryBuilder $qb */
    //     $qb = $this->createQueryBuilder('l')
    //         ->andWhere('l.expiry BETWEEN :now AND :future')
    //         ->setParameter('now', $dateNow->format("Y-m-d"))
    //         ->setParameter('future', $dateFuture->format("Y-m-d"))
    //     ;

    //     $result = $qb->getQuery()->getResult();
    
    //     return $result;          
    // }
}
