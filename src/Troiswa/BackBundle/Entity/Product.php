<?php

namespace Troiswa\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Troiswa\BackBundle\Entity\ProductRepository")
 * @ORM\Table(name="product")
 */
class Product
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="title", type="string", length=100)
     * @Assert\NotBlank(message="Attention")
     * @Assert\NotNull()
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(name="description", type="text")
     * @Assert\NotBlank(message="Attention")
     * @Assert\NotNull()
     */
    private $description;

    /**
     * @var float
     * @ORM\Column(name="price", type="float")
     * @Assert\NotBlank(message="Attention")
     * @Assert\NotNull()
     */
    private $price;

    /**
     * @var boolean
     * @ORM\Column(name="active", type="boolean")
     * @Assert\NotBlank(message="Attention")
     * @Assert\NotNull()
     */
    private $active;

    /**
     * @var integer
     * @ORM\Column(name="quantity", type="integer")
     * @Assert\NotBlank(message="Attention")
     * @Assert\GreaterThan ( value = 0 )
     * @Assert\NotNull()
     */
    private $quantity;


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
     * Set title
     *
     * @param string $title
     * @return Product
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Product
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     * @return Product
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
}