<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandeRepository")
 */
class Commande
{

    
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

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
    private $email;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateVisit;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ticketType;

    /**
     * @ORM\Column(type="integer")
     */
    private $numberTicket;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;


     /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ticket", mappedBy="commande", cascade={"persist"}, orphanRemoval=true)
     * @ORM\JoinColumn(nullable=false)
     
     */
    private $tickets;

    public function __construct()
  {
    $this->createAt   = new \Datetime();
    
     $this->tickets   = new ArrayCollection();
    
  }

    
    public function getId(): ?int
    {
        return $this->id;
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


    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getdateVisit(): ?\DateTimeInterface
    {
        return $this->dateVisit;
    }

    public function setdateVisit(\DateTimeInterface $dateVisit): self
    {
        $this->dateVisit = $dateVisit;

        return $this;
    }

    public function getTicketType(): ?string
    {
        return $this->ticketType;
    }

    public function setTicketType(string $ticketType): self
    {
        $this->ticketType = $ticketType;

        return $this;
    }

    public function getNumberTicket(): ?int
    {
        return $this->numberTicket;
    }

    public function setNumberTicket(int $numberTicket): self
    {
        $this->numberTicket = $numberTicket;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

     /**
     * Add ticket
     *
     * @param Ticket $ticket
     *
     * @return Commande
     */
    public function addTicket(Ticket $ticket)
    {
        $this->tickets[] = $ticket;
        $ticket->setCommande($this);

        return $this;
    }

    /**
     * Remove ticket
     *
     * @param Ticket $ticket
     */
    public function removeTicket(Ticket $ticket)
    {
        $this->tickets->removeElement($ticket);
    }

    /**
     * Get tickets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTickets()
    {
        return $this->tickets;
    }

 
}
