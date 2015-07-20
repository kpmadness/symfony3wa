<?php

namespace Troiswa\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Troiswa\BackBundle\Entity\Product;


/**
 * Category
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Troiswa\BackBundle\Repository\CategoryRepository")
 */
class Category
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
     * @ORM\Column(name="title", type="string", length=25)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=200)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="categ")
     */
    protected $products;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Category
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
     * @return Category
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
     * Set position
     *
     * @param integer $position
     * @return Category
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }


    /**
     *
     * @Assert\True(message="Le titre de cette catégorie doit être 'Accueil'")
     *
     */
    public function isCategoryValid()
    {
        if($this->position==0 && $this->title!="Accueil"){
            return false;
        }
    }

    /**
     * @Assert\True(message="Le titre doit commencer par une majuscule")
     */
//    public function isTitle()
//    {
//
//        if($this->title==ucfirst(strtolower($this->title))){
//            return false;
//        }
//
//        return true;
//    }

    /**
     * @Assert\Callback()
     */
    public function validate(ExecutionContextInterface $context)
    {

        $titleConvert = ucfirst($this->title);

        // check if the name is actually a fake name
        if ($this->getTitle()!=$titleConvert) {
            // If you're using the new 2.5 validation API (you probably are!)
            $context->buildViolation('Votre titre "{{ value }}" ne commence pas par une majuscule !')
                ->atPath('title')
                ->setParameter("{{ value }}", $this->title)
                ->addViolation();
        }

        return true;
    }


    /**
     * Add products
     *
     * @param \Troiswa\BackBundle\Entity\Product $products
     * @return Category
     */
    public function addProduct(\Troiswa\BackBundle\Entity\Product $products)
    {
//        die("test");
        $this->products[] = $products;
        $products->setCateg($this);

        return $this;
    }

    /**
     * Remove products
     *
     * @param \Troiswa\BackBundle\Entity\Product $products
     */
    public function removeProduct(\Troiswa\BackBundle\Entity\Product $products)
    {
        $this->products->removeElement($products);
        $products->setCateg(null);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProducts()
    {
        return $this->products;
    }
}
