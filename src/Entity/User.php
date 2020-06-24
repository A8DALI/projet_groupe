<?php

	namespace App\Entity;
                        
                        	use App\Repository\UserRepository;
                         use Doctrine\Common\Collections\ArrayCollection;
                         use Doctrine\Common\Collections\Collection;
                        	use Doctrine\ORM\Mapping as ORM;
                        	use PhpParser\Node\Expr\List_;
                        	use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
                        	use Symfony\Component\Security\Core\User\UserInterface;
                        	use Symfony\Component\Validator\Constraints as Assert;
                        
                        	/**
                        	 * @ORM\Entity(repositoryClass=UserRepository::class)
                        	 * @UniqueEntity(fields={"email"}, message="Cet email existe déjà")
                        	 */
                        	class User implements UserInterface, \Serializable
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
                        		 * @ORM\Column(type="string", length=255)
                        		 */
                        		private $mdp;
                        
                        		/**
                        		 * @var string|null
                        		 * @Assert\NotBlank(message="Le mot de passe est obligatoire", groups={"registration"})
                        		 * @Assert\Regex("/^[a-zA-Z0-9_]{6,20}$/", message="Mot de passe non conforme")
                        		 */
                        		private $mdpClair;
                        
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
                        
                        		/**
                        		 * @ORM\Column(type="text", nullable=true)
                        		 */
                        		private $info;
                        
                        		/**
                        		 * @ORM\Column(type="string", length=50, nullable=true)
                        		 */
                        		private $sexe;
                        
                        		/**
                        		 * @ORM\Column(type="string", length=255, nullable=true)
                        		 */
                        		private $image;
                        
                        		/**
                        		 * @ORM\Column(type="integer", nullable=true)
                        		 */
                        		private $age;
               
                          /**
                           * @ORM\OneToMany(targetEntity=Messages::class, mappedBy="auteur")
                           */
                          private $messages;
            
                          public function __construct()
                          {
                              $this->messages = new ArrayCollection();
                          }
                        
                        		/**
                        		 * Permet de pouvoir faire un echo sur un objet user:
                        		 * affichera prénom et nom
                        		 *
                        		 * @return string
                        		 */
                        		public function __toString()
                        		{
                        			return $this->pseudo;
                        		}
                        
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
                        
                        		/**
                        		 * @return string|null
                        		 */
                        		public function getMdpClair(): ?string
                        		{
                        			return $this->mdpClair;
                        		}
                        
                        		/**
                        		 * @param string|null $mdpClair
                        		 * @return User
                        		 */
                        		public function setMdpClair(?string $mdpClair): User
                        		{
                        			$this->mdpClair = $mdpClair;
                        			return $this;
                        		}
                        
                        
                        		public function getRoles()
                        		{
                        			return [$this->getRole()];
                        		}
                        
                        		public function getPassword()
                        		{
                        			return $this->getMdp();
                        		}
                        
                        		public function getSalt()
                        		{
                        			// TODO: Implement getSalt() method.
                        		}
                        
                        		public function getUsername()
                        		{
                        			return $this->getEmail();
                        		}
                        
                        		public function eraseCredentials()
                        		{
                        			// TODO: Implement eraseCredentials() method.
                        		}
                        
                        		public function getInfo(): ?string
                        		{
                        			return $this->info;
                        		}
                        
                        		public function setInfo(?string $info): self
                        		{
                        			$this->info = $info;
                        
                        			return $this;
                        		}
                        
                        		public function getSexe(): ?string
                        		{
                        			return $this->sexe;
                        		}
                        
                        		public function setSexe(?string $sexe): self
                        		{
                        			$this->sexe = $sexe;
                        
                        			return $this;
                        		}
                        
                        		public function getImage()
                        		{
                        			return $this->image;
                        		}
                        
                        		public function setImage($image): self
                        		{
                        			$this->image = $image;
                        
                        			return $this;
                        		}
                        
                        		public function getAge(): ?int
                        		{
                        			return $this->age;
                        		}
                        
                        		public function setAge(?int $age): self
                        		{
                        			$this->age = $age;
                        
                        			return $this;
                        		}
                        
                        		public function serialize()
                        		{
                        			return serialize(
                        				[
                        					$this->pseudo,
                        					$this->age,
                        					$this->info,
                        					$this->ville,
                        					$this->genre,
                        					$this->sexe,
                        					$this->id,
                        					$this->mdp,
                        					$this->role,
                        					$this->email
                        				]
                        			);
                        		}
                        
                        		public function unserialize($serialized)
                        		{
                        			list(
                        					$this->pseudo,
                        					$this->age,
                        					$this->info,
                        					$this->ville,
                        					$this->genre,
                        					$this->sexe,
                        					$this->id,
                        					$this->mdp,
                        					$this->role,
                        					$this->email
                        				) = unserialize($serialized);
                        		}
      
                          /**
                           * @return Collection|Messages[]
                           */
                          public function getMessages(): Collection
                          {
                              return $this->messages;
                          }
   
                          public function addMessage(Messages $message): self
                          {
                              if (!$this->messages->contains($message)) {
                                  $this->messages[] = $message;
                                  $message->setAuteur($this);
                              }
   
                              return $this;
                          }

                          public function removeMessage(Messages $message): self
                          {
                              if ($this->messages->contains($message)) {
                                  $this->messages->removeElement($message);
                                  // set the owning side to null (unless already changed)
                                  if ($message->getAuteur() === $this) {
                                      $message->setAuteur(null);
                                  }
                              }

                              return $this;
                          }
                        	}
