<?php

namespace Bolge\App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="customers")
 * @ORM\Entity(repositoryClass="Bolge\App\Repository\CustomerRepository")
 */
class Customer
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private int $id;

    /**
     * @ORM\Column(name="first_name", type="string")
     */    
    private string $firstName;

    /**
     * @ORM\Column(name="last_name", type="string")
     */    
    private string $lastName;

    /**
     * @ORM\OneToMany(targetEntity="Address", mappedBy="customer")
     * @var Address[]
     */
    private PersistentCollection $addresses;    

    /**
     * @ORM\Column(name="created", type="datetime")
     * @var DateTime
     */    
    private \DateTime $created;  

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }


    /**
     * Get the value of firstName
     */ 
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set the value of firstName
     *
     * @return  self
     */ 
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get the value of lastName
     */ 
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set the value of lastName
     *
     * @return  self
     */ 
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getAddress($customer)
    {
        if (!isset($this->addresses[$customer])) {
            throw new \InvalidArgumentException("Its not related");
        }

        return $this->addresses[$customer];
    }

    /**
     * Get the value of domains
     *
     */ 
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * Set the value of address
     *
     * @param  Address[]  $addresses
     *
     * @return  self
     */ 
    public function addAddress(Address $address)
    {
        $this->addresses[$address->getLicense()] = $address;

        return $this;
    }

    /**
     * Get the value of created
     */ 
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set the value of created
     *
     * @return  self
     */ 
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }
}
