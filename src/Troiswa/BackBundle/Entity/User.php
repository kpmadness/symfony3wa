<?php

namespace Troiswa\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Troiswa\BackBundle\Validator\TelValid as TelValid;
use Troiswa\BackBundle\Validator\PasswordCheck as PasswordCheck;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Troiswa\BackBundle\Repository\UserRepository")
 * @UniqueEntity("mail")
 * @UniqueEntity("pseudo")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255, unique=true)
     */
    private $mail;

    /**
     * @var string
     * @ORM\Column(name="phone", type="string", length=255)
     * @TelValid
     *
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="pseudo", type="string", length=255, unique=true)
     */
    private $pseudo;

    /**
     * @var string
     * @ORM\Column(name="password", type="string", length=255)
     * @PasswordCheck
     *
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="birth_date", type="date")
     */
    private $birthdate;

//    /**
//     * @var string
//     *
//     * @ORM\Column(name="username", type="string", length=100)
//     */
//    private $username;

    /**
     *
     * @ORM\OneToMany(targetEntity="UserCoupon", mappedBy="user")
     *
     */
    private $coupon;


    /**
     * @ORM\ManyToMany(targetEntity="Role")
     * @ORM\JoinTable(name="user_role",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_role", referencedColumnName="id")
     *   }
     * )
     */
    private $roles;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->coupon = new ArrayCollection();
        $this->roles = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set mail
     *
     * @param string $mail
     * @return User
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string 
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return User
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set pseudo
     *
     * @param string $pseudo
     * @return User
     */
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * Get pseudo
     *
     * @return string 
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set birthdate
     *
     * @param \DateTime $birthdate
     * @return User
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime 
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }


    /**
     * @Assert\Callback()
     */
    public function validate(ExecutionContextInterface $context)
    {

        // check if the name is actually a fake name
        if ($this->pseudo=="admin") {
            $context->buildViolation('Le pseudo "{{ value }}" n\'est pas possible !')
                ->atPath('pseudo')
                ->setParameter("{{ value }}", $this->pseudo)
                ->addViolation();
        }

        if ($this->password=="admin") {
            $context->buildViolation('Le mot de passe saisi : "{{ value }}" n\'est pas valide!')
                ->atPath('password')
                ->setParameter("{{ value }}", $this->password)
                ->addViolation();
        }

        return true;
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return Role[] The user roles
     */
    public function getRoles()
    {
        //return array('ROLE_USER');
        return $this->roles->toArray();
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->pseudo;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }


    /**
     * Add coupon
     *
     * @param \Troiswa\BackBundle\Entity\UserCoupon $coupon
     * @return User
     */
    public function addCoupon(\Troiswa\BackBundle\Entity\UserCoupon $coupon)
    {
        $this->coupon[] = $coupon;

        return $this;
    }

    /**
     * Remove coupon
     *
     * @param \Troiswa\BackBundle\Entity\UserCoupon $coupon
     */
    public function removeCoupon(\Troiswa\BackBundle\Entity\UserCoupon $coupon)
    {
        $this->coupon->removeElement($coupon);
    }

    /**
     * Get coupon
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCoupon()
    {
        return $this->coupon;
    }

    /**
     * Add roles
     *
     * @param \Troiswa\BackBundle\Entity\Role $roles
     * @return User
     */
    public function addRole(\Troiswa\BackBundle\Entity\Role $roles)
    {
        $this->roles[] = $roles;

        return $this;
    }

    /**
     * Remove roles
     *
     * @param \Troiswa\BackBundle\Entity\Role $roles
     */
    public function removeRole(\Troiswa\BackBundle\Entity\Role $roles)
    {
        $this->roles->removeElement($roles);
    }

    public function serialize()
    {
        return serialize(array($this->id));
    }

    public function unserialize($serialized)
    {
        list ($this->id) = unserialize($serialized);
    }
}
