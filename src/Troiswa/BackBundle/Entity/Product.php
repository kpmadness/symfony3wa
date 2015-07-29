<?php

namespace Troiswa\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Troiswa\BackBundle\Entity\Tag as Tag;
use Troiswa\BackBundle\Entity\Brand as Brand;
use Troiswa\BackBundle\Entity\Category as Category;
use Troiswa\BackBundle\Entity\ProductCover as ProductCover;

/**
 * @ORM\Entity(repositoryClass="Troiswa\BackBundle\Repository\ProductRepository")
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
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=128)
     * @Gedmo\Slug(fields={"title"})
     */
    private $slug;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="dateCreated", type="datetime")
     */
    private $dateCreated;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="dateUpdated", type="datetime")
     */
    private $dateUpdated;

    /**
     * @var integer
     * @ORM\Column(name="quantity", type="integer")
     * @Assert\NotBlank(message="Attention")
     * @Assert\GreaterThan ( value = 0 )
     * @Assert\NotNull()
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity="Troiswa\BackBundle\Entity\Category", inversedBy="products")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $categ;

    /**
     * @ORM\ManyToOne(targetEntity="Troiswa\BackBundle\Entity\Brand", inversedBy="products")
     * @ORM\JoinColumn(name="brand_id", referencedColumnName="id", nullable=false)
     *
     */
    private $brand;

    /**
     * @ORM\OneToOne(targetEntity="ProductCover", cascade={"persist"})
     * @ORM\JoinColumn(name="product_cover_id", referencedColumnName="id")
     * @Assert\Valid
     */
    private $cover;

    /**
     *
     * @ORM\ManyToMany(targetEntity="Troiswa\BackBundle\Entity\Tag")
     * @ORM\JoinTable(name="product_tag",
     *   joinColumns={
     *     @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="tag_id", referencedColumnName="id")
     *   }
     * )
     *
     */
    private $tag;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tag = new \Doctrine\Common\Collections\ArrayCollection();
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

    /**
     * Set categ
     *
     * @param Category $categ
     * @return Product
     */
    public function setCateg(Category $categ = null)
    {
        $this->categ = $categ;

        return $this;
    }

    /**
     * Get categ
     *
     * @return Category
     */
    public function getCateg()
    {
        return $this->categ;
    }


    /**
     * Set brand
     *
     * @param Brand $brand
     * @return Product
     */
    public function setBrand(Brand $brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return Brand
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set cover
     *
     * @param ProductCover $cover
     * @return Product
     */
    public function setCover(ProductCover $cover = null)
    {
        $this->cover = $cover;

        return $this;
    }

    /**
     * Get cover
     *
     * @return ProductCover
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * Add tag
     *
     * @param Tag $tag
     * @return Product
     */
    public function addTag(Tag $tag)
    {
        $this->tag[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param Tag $tag
     */
    public function removeTag(Tag $tag)
    {
        $this->tag->removeElement($tag);
    }

    /**
     * Get tag
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Product
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return Product
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime 
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set dateUpdated
     *
     * @param \DateTime $dateUpdated
     * @return Product
     */
    public function setDateUpdated($dateUpdated)
    {
        $this->dateUpdated = $dateUpdated;

        return $this;
    }

    /**
     * Get dateUpdated
     *
     * @return \DateTime 
     */
    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }



}
