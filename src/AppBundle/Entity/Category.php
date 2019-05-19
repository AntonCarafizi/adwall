<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
/**
 * Category
 */
class Category
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $parent;

    /**
     * @var string
     */
    private $name;

    private $attributes;

    private $children;

    private $items;

    public function __construct()
    {
        $this->attributes = new ArrayCollection();
        $this->children = new ArrayCollection();
        $this->items = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set parentId
     *
     * @param integer $parentId
     *
     * @return Category
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parentId
     *
     * @return int
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Category
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

    public function __toString() {
        return $this->name;
    }

}

