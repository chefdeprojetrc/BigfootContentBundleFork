<?php
namespace Bigfoot\Bundle\ContentBundle\Model;

use Symfony\Component\DependencyInjection\Container;

/**
 * Abstract class AbstractWidget
 *
 * All Widget class have to extend this class in order to be listed in the dashboard
 *
 * @package Bigfoot\Bundle\ContentBundle\Model
 */
abstract class AbstractWidget
{
    /**
     * @var array
     */
    protected $parameters = array();

    /**
     * @var Container
     */
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    abstract public function getLabel();

    abstract public function getName();

    abstract public function getDefaultParameters();

    abstract public function getRoute();

    abstract public function getParametersType();

    abstract public function load();

    public function addParameter($key, $value)
    {
        $this->parameters[$key] = $value;

        return $this;
    }

    public function addParameters(array $parameters)
    {
        $this->parameters = array_merge($this->parameters, $parameters);

        return $this;
    }

    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    public function getParameters()
    {
        return $this->parameters;
    }
}
