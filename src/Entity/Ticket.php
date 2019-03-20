<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TicketRepository")
 */
class Ticket
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

       /**
     * @ORM\Column(type="integer")
     */

    private $commandeId;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $surname;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

     /**
     * @ORM\Column(type="string", length=255)
     */
    private $nationality;

    /**
     * @ORM\Column(type="datetime")
     */
    private $birth;

        /**
     * @ORM\Column(type="integer")
     */
    private $age;


  /**
   * @ORM\Column(name="reduction", type="boolean")
   */
  private $reduction ;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Commande", inversedBy="tickets")
    * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
     */
    private $commande;

/**
     * Constructor
     *
     * @param Commande $commande
     */
    public function __construct(Commande $commande = null)
    {
        $this->commande= $commande;

    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }


    public function getCommande(): ?Commande
    {
        return $this->commande;
    }


    public function getId(): ?int
    {
        return $this->id;

    }
    public function getCommaneId(): ?int
    {
        return $this->commandeId;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getPrice(): ?int

    {
        
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(string $nationality): self
    {
        $this->nationality = $nationality;

        return $this;
    }

    public function getBirth(): ?\DateTimeInterface
    {
        
        return $this->birth;
    }

    public function setBirth(\DateTimeInterface $birth): self
    {
        $this->birth = $birth;
        
        
        return $this;
    }
 
    public function getAge(): ?int

    {
        
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }  
   
    
  /**
   * @param bool $reduction
   */
  public function setReduction($reduction)
  {
    $this->reduction = $reduction;
  }

  /**
   * @return bool
   */
  public function getReduction()
  {
    return $this->reduction;
  }

    


}
