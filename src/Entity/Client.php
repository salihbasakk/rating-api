<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\UniqueConstraint;
use JsonSerializable;

#[ORM\Table(name: 'client')]
#[UniqueConstraint(name: 'UNIQ_70E4FA78F85E0677', columns: ['username'])]
#[Index(fields: ['username'], name: 'username_idx')]
#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client extends BaseEntity implements JsonSerializable
{
    #[Column(name: 'first_name', type: 'string', length: 96, nullable: false)]
    private string $firstName;

    #[Column(name: 'last_name', type: 'string', length: 96, nullable: false)]
    private string $lastName;

    #[Column(name: 'username', type: 'string', length: 128, nullable: false, options: [
        'comment' => 'Email as the username'
    ])]
    private string $username;

    #[Column(name: 'password', type: 'string', length: 96, nullable: false, options: [
        'comment' => 'Use password hash with BCRYPT'
    ])]
    private string $password;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Feedback::class)]
    private Collection $feedback;

    public function __construct()
    {
        $this->feedback = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return Client
     */
    public function setFirstName(string $firstName): Client
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return Client
     */
    public function setLastName(string $lastName): Client
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return Client
     */
    public function setUsername(string $username): Client
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return Client
     */
    public function setPassword(string $password): Client
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return Collection<int, Feedback>
     */
    public function getFeedback(): Collection
    {
        return $this->feedback;
    }

    public function addFeedback(Feedback $feedback): self
    {
        if (!$this->feedback->contains($feedback)) {
            $this->feedback->add($feedback);
            $feedback->setClient($this);
        }

        return $this;
    }

    public function removeFeedback(Feedback $feedback): self
    {
        if ($this->feedback->removeElement($feedback)) {
            if ($feedback->getClient() === $this) {
                $feedback->setClient(null);
            }
        }

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'firstName' => $this->getFirstName(),
            'lastName' => $this->getLastName(),
            'username' => $this->getUsername(),
        ];
    }
}
