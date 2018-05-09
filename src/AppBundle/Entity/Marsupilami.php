<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MarsupilamiRepository")
 */
class Marsupilami implements UserInterface
{

    use IdTrait;

    /**
     * @ORM\Column()
     * @ORM\Column(unique=true)
     * @Assert\NotNull()
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     */
    private $name;

    /**
     * @ORM\Column()
     */
    private $password;

    /**
     * @Assert\Type("string")
     * @Assert\Length(min=6)
     */
    private $rawPassword;

    /**
     * @ORM\Column(
     *     type="date",
     * )
     * @Assert\NotNull()
     * @Assert\Date()
     */
    private $birthdate;

    /**
     * @ORM\Column()
     */
    private $family;

    /**
     * @ORM\Column()
     */
    private $race;

    /**
     * @ORM\Column()
     */
    private $food;

    /**
     * @ORM\ManyToMany(targetEntity="Marsupilami")
     */
    private $friends;

    public function __construct()
    {
        $this->friends = new ArrayCollection();
    }

    public function __toString()
    {
        return (string)$this->getName();
    }

    public function removeFriends(Marsupilami $marsupilami)
    {
        if ($this->friends->contains($marsupilami)) {
            $this->friends->removeElement($marsupilami);
        }
        return $this;
    }

    public function addFriends(Marsupilami $marsupilami)
    {
        if (!$this->friends->contains($marsupilami)) {
            $this->friends->add($marsupilami);
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFriends()
    {
        return $this->friends;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getFamily()
    {
        return $this->family;
    }

    /**
     * @param mixed $family
     */
    public function setFamily($family)
    {
        $this->family = $family;
    }

    /**
     * @return mixed
     */
    public function getRace()
    {
        return $this->race;
    }

    /**
     * @param mixed $race
     */
    public function setRace($race)
    {
        $this->race = $race;
    }

    public function getBirthdate()
    {
        return $this->birthdate;
    }

    public function setBirthdate($date)
    {
        $this->birthdate = $date;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getRawPassword()
    {
        return $this->rawPassword;
    }

    public function setRawPassword($rawPassword)
    {
        $this->rawPassword = $rawPassword;
    }

    /**
     * @return mixed
     */
    public function getFood()
    {
        return $this->food;
    }

    /**
     * @param mixed $food
     */
    public function setFood($food)
    {
        $this->food = $food;
    }

    public function getRoles()
    {
        $roles = ['ROLE_USER'];

        return $roles;
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return $this->name;
    }

    public function eraseCredentials()
    {
        $this->rawPassword = null;
    }

}