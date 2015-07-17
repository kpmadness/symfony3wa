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
 * @ORM\HasLifecycleCallbacks
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

    private $oldFile;

    private $thumbnails = array("thumb-small" => array(100, 50),
                                "thumb-medium" => array(200, 100),
                                "thumb-large" => array(400, 200));


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
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;

        // Test si j'ai déjà une image
        if ($this->name)
        {
            // J'ajoute dans oldFichier l'ancienne image
            $this->oldFile = $this->name;

            // Ajout de la ligne ci-dessous si l'on modifie uniquement l'image du produit
            // Modification du nom afin que doctrine lance le PreUpdate et le PostUpdate
            //$this->name = null;
        }


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

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        // Permet d'insérer un nom d'image au moment de la sauvegarde en BDD
        // Création d'un nom unique d'image
        $extension = $this->file->guessExtension();
        $this->name = str_replace(' ', '-', $this->alt) . uniqid().'.'.$extension;
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null == $this->file) {
            return;
        }

        // Suppression des anciennes images
        if ($this->oldFile)
        {
            // suppression de l'image principale
            unlink($this->getUploadRootDir() . '/' . $this->oldFile);

            // suppression des thumbnails
            foreach ($this->thumbnails as $key => $thumbnail)
            {
                unlink($this->getUploadRootDir() . '/' . $key . '-' . $this->oldFile);
            }

        }


        $this->file->move($this->getUploadRootDir(), $this->name);

        $imagine = new \Imagine\Gd\Imagine();
        $imagineOpen = $imagine->open($this->getAbsolutePath());

        // Création des thumbnails
        foreach ($this->thumbnails as $key => $value) {

            $imagineOpen->thumbnail(new \Imagine\Image\Box($value[0], $value[1]))
                        ->save($this->getUploadRootDir() . '/' . $key . '-' . $this->name);

        }

    }

    private function getUploadRootDir()
    {
        return __DIR__ . "/../../../../web/" . $this->getUploadDir();
    }


    public function getWebPath($size = null)
    {
        if (array_key_exists("thumb-" . $size, $this->thumbnails)) {
            return $this->getUploadDir() . '/thumb-' . $size . '-' . $this->name;
        } else {
            return $this->getUploadDir() . '/' . $this->name;


        }
    }

    public function getAbsolutePath()
    {
        return $this->getUploadRootDir() . '/' . $this->name;
    }

    public function getUploadDir()
    {
        return "upload/products";

    }

}