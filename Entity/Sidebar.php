<?php

namespace Bigfoot\Bundle\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Sidebar
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Bigfoot\Bundle\ContentBundle\Entity\SidebarRepository")
 */
class Sidebar
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
     * @Gedmo\Slug(fields={"title"}, updatable=true, unique=true)
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @var string
     *
     * @Gedmo\Translatable
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var Template
     *
     * @ORM\ManyToOne(targetEntity="Template", inversedBy="sidebars")
     * @ORM\JoinColumn(name="template_id", referencedColumnName="id")
     */
    private $template;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active = true;

    /**
     * @var ArrayCollection $staticcontent
     *
     * @ORM\OneToMany(targetEntity="StaticContent", mappedBy="sidebar", cascade={"persist", "remove", "merge"})
     */
    private $staticcontent;

    /**
     * @var ArrayCollection $widget
     *
     * @ORM\OneToMany(targetEntity="Widget", mappedBy="sidebar", cascade={"persist", "remove", "merge"})
     */
    private $widget;

    /**
     * @Gedmo\Locale
     */
    protected $locale;

    public function __toString()
    {
        return $this->title;
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
     * Set slug
     *
     * @param string $slug
     * @return Sidebar
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
     * Set title
     *
     * @param string $title
     * @return Sidebar
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
     * Set active
     *
     * @param boolean $active
     * @return Sidebar
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
     * Constructor
     */
    public function __construct()
    {
        $this->staticcontent = new \Doctrine\Common\Collections\ArrayCollection();
        $this->widget = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add staticcontent
     *
     * @param \Bigfoot\Bundle\ContentBundle\Entity\StaticContent $staticcontent
     * @return Sidebar
     */
    public function addStaticcontent(\Bigfoot\Bundle\ContentBundle\Entity\StaticContent $staticcontent)
    {
        $this->staticcontent[] = $staticcontent;

        return $this;
    }

    /**
     * Remove staticcontent
     *
     * @param \Bigfoot\Bundle\ContentBundle\Entity\StaticContent $staticcontent
     */
    public function removeStaticcontent(\Bigfoot\Bundle\ContentBundle\Entity\StaticContent $staticcontent)
    {
        $this->staticcontent->removeElement($staticcontent);
    }

    /**
     * Get staticcontent
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStaticcontent()
    {
        return $this->staticcontent;
    }

    /**
     *
     * Get Block
     *
     * @return ArrayCollection
     */
    public function getBlock()
    {
        $tabBlock = array_merge($this->staticcontent->toArray(), $this->widget->toArray());

        Sidebar::aasort($tabBlock,"position");

        return new ArrayCollection($tabBlock);
    }

    /**
     * Sort a multi array by key
     *
     * @param $array
     * @param $key
     */
    public static function aasort (&$array, $key) {
        $sorter=array();
        $ret=array();
        reset($array);
        foreach ($array as $ii => $va) {
            $sorter[$ii]=$va->{$key};
        }
        asort($sorter);
        foreach ($sorter as $ii => $va) {
            $ret[$ii]=$array[$ii];
        }
        $array=$ret;
    }

    /**
     * Add widget
     *
     * @param \Bigfoot\Bundle\ContentBundle\Entity\Widget $widget
     * @return Sidebar
     */
    public function addWidget(\Bigfoot\Bundle\ContentBundle\Entity\Widget $widget)
    {
        $this->widget[] = $widget;

        return $this;
    }

    /**
     * Remove widget
     *
     * @param \Bigfoot\Bundle\ContentBundle\Entity\Widget $widget
     */
    public function removeWidget(\Bigfoot\Bundle\ContentBundle\Entity\Widget $widget)
    {
        $this->widget->removeElement($widget);
    }

    /**
     * Get widget
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getWidget()
    {
        return $this->widget;
    }

    /**
     * @param \Bigfoot\Bundle\ContentBundle\Entity\Template $template
     * @return Sidebar
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @return \Bigfoot\Bundle\ContentBundle\Entity\Template
     */
    public function getTemplate()
    {
        return $this->template;
    }

    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }
}
