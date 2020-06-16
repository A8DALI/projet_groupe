<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     * @Assert\NotBlank(message="Le pseudo est obligatoire")
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="L'email est obligatoire")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=155)
     * @Assert\NotBlank(message="Le mot de passe est obligatoire")
     */
    private $mdp;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $role = 'ROLE_USER';

    /**
     * @ORM\ManyToOne(targetEntity=Ville::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="La ville est obligatoire")
     */
    private $ville;

    /**
     * @ORM\ManyToOne(targetEntity=Genre::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Le choix de genre est obligatoire")
     */
    private $genre;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

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

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): self
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getVille(): ?Ville
    {
        return $this->ville;
    }

    public function setVille(?Ville $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getGenre(): ?Genre
    {
        return $this->genre;
    }

    public function setGenre(?Genre $genre): self
    {
        $this->genre = $genre;

        return $this;
    }
}
