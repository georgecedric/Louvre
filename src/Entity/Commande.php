<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(type="datetime")
     */
    private $dateofpurchase;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateofvisit;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tickettype;

    /**
     * @ORM\Column(type="integer")
     */
    private $nomberofticket;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

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

    public function getDateofpurchase(): ?\DateTimeInterface
    {
        return $this->dateofpurchase;
    }

    public function setDateofpurchase(\DateTimeInterface $dateofpurchase): self
    {
        $this->dateofpurchase = $dateofpurchase;

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

    public function getDateofvisit(): ?\DateTimeInterface
    {
        return $this->dateofvisit;
    }

    public function setDateofvisit(\DateTimeInterface $dateofvisit): self
    {
        $this->dateofvisit = $dateofvisit;

        return $this;
    }

    public function getTickettype(): ?string
    {
        return $this->tickettype;
    }

    public function setTickettype(string $tickettype): self
    {
        $this->tickettype = $tickettype;

        return $this;
    }

    public function getNomberofticket(): ?int
    {
        return $this->nomberofticket;
    }

    public function setNomberofticket(int $nomberofticket): self
    {
        $this->nomberofticket = $nomberofticket;

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
}
