<?php

namespace Troiswa\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * ProductCover
 *
 * @ORM\Table(name="product_cover")
 * @ORM\Entity(repositoryClass="Troiswa\BackBundle\Entity\ProductCoverRepository")
 */
class ProductCover
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
     * @ORM\Column(name="name", type="string", length=30)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=50)
     */
    private $alt;

    /**
     *
     * @Assert\Image(mimeTypes = {"image/png", "image/jpeg"}, mimeTypesMessage = "Choisissez un fichier Image valide")
     *
     */
    private $file;

   

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
     * Set name
     *
     * @param string $name
     * @return ProductCover
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set alt
     *
     * @param string $alt
     * @return ProductCover
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string 
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set file
     *
     */
    public function setFile(UploadedFile $file=null)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     */
    public function getFile()
    {
        return $this->file;
    }

    public function upload()
    {
        if(null==$this->file){
            return;
        }

        $extension = $this->file->guessExtension();

//        $nameImage=$this->file->getClientOriginalName();

        $nameImage=$this->alt."-".uniqid().".".$extension;

        $this->file->move($this->getUploadRootDir(), $nameImage);

        $this->name=$nameImage;

        // Création des thumbnails
        $imagine = new \Imagine\Gd\Imagine();
        $imagine
            ->open($this->getAbsolutePath())
            ->thumbnail(new \Imagine\Image\Box(350, 160))
            ->save($this->getAbsolutePath().'-thumb-small.'.$extension);


    }

    private function getUploadRootDir()
    {
        return __DIR__."/../../../../web/upload/products";
    }

    public function getWebPath()
    {
        return "upload/products/".$this->name;
    }

    public function getAbsolutePath()
    {
        return $this->getUploadRootDir().'/'.$this->name;
    }


}
