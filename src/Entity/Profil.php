<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\ProfilRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     routePrefix="/admin",
 *     subresourceOperations={
 *          "get_profils_users"={
 *                  "method"="GET",
 *                  "path"="/profils/{id}/users",
 *                  "requirements"={"id"="\d+"},
 *                  "access_control"="(is_granted('ROLE_Administrateur'))",
 *                  "access_control_message"="Vous n'avez pas access à cette Ressource"
 *          }
 *     },
 *     collectionOperations={
 *      "post"={
 *          "method"="POST",
 *          "path"="/profils"
 *       },
 *      "get"={
 *          "method"="GET",
 *          "path"="/profils"
 *     },
 *
 *     },
 *     itemOperations={
 *          "get"={"path"="/profils/{id}",
 *                  "requirements"={"id"="\d+"},
 *                   "normalization_context"={"groups"={"get_profils"}},
 *                  "access_control"="(is_granted('ROLE_Administrateur'))",
 *                  "access_control_message"="Vous n'avez pas access à cette Ressource"
 *          },
 *          "put"={"path"="/profils/{id}",
 *                  "requirements"={"id"="\d+"},
 *                  "access_control"="(is_granted('ROLE_Administrateur'))",
 *                  "access_control_message"="Vous n'avez pas access à cette Ressource"
 *          },
 *          "delete"={"path"="/profils/{id}",
 *                  "requirements"={"id"="\d+"},
 *                  "access_control"="(is_granted('ROLE_Administrateur'))",
 *                  "access_control_message"="Vous n'avez pas access à cette Ressource"
 *          }
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\ProfilRepository")
 */
class Profil
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups ({"get_profils"})
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="profil")
     * @ApiSubresource
     */
    private $users;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_deleted=false;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setProfil($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getProfil() === $this) {
                $user->setProfil(null);
            }
        }

        return $this;
    }

    public function getIsDeleted(): ?bool
    {
        return $this->is_deleted;
    }

    public function setIsDeleted(bool $is_deleted): self
    {
        $this->is_deleted = $is_deleted;

        return $this;
    }
}
