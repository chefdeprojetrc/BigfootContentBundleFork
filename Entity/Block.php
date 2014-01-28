<?php
namespace Bigfoot\Bundle\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/** @ORM\MappedSuperclass */
class Block
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=255)
     */
    protected $label;

    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer")
     */
    protected $position = 1;

    /**
     * @var Template
     *
     * @ORM\ManyToOne(targetEntity="Template", inversedBy="blocks")
     * @ORM\JoinColumn(name="template_id", referencedColumnName="id")
     */
    private $template;

    /**
     * @var array
     *
     * @ORM\Column(name="params", type="array")
     */
    protected $params;

    /**
     * @var datetime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @var datetime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    protected $updated;

    /**
     * @Gedmo\Blameable(on="create")
     * @ORM\Column(name="created_by", type="string", nullable=true)
     */
    protected $createdBy;

    /**
     * @Gedmo\Blameable(on="update")
     * @ORM\Column(name="updated_by", type="string", nullable=true)
     */
    protected $updatedBy;

    /**
     * @param $name string
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->params[$name] = $value;
    }

    /**
     * @param $name string
     * @return null
     */
    public function __get($name)
    {
        if (sizeof($this->params) > 0 && array_key_exists($name, $this->params)) {
            return $this->params[$name];
        }

        return null;
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
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active = true;

    /**
     * Set label
     *
     * @param string $label
     * @return Widget
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return integer
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
     * @param \Bigfoot\Bundle\ContentBundle\Entity\Template $template
     * @return Block
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

    /**
     * Set active
     *
     * @param boolean $active
     * @return StaticContent
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
     * Set Parameters
     */
    public function setParams($params)
    {
        $this->params= $params;

        return $this;
    }

    /**
     * Get parameters
     *
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Page
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Page
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Get createdBy
     *
     * @return string
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Get updatedBy
     *
     * @return string
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }
}
