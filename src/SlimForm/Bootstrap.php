<?php
namespace SlimForm;

use Doctrine\Common\Annotations\Reader as ReaderInterface;

class Bootstrap {
    private static $_instance;

    protected $_view;

    protected $_ngOpen = '[[';
    protected $_ngClose = ']]';

    protected $_entityManagerCallable;

    protected $_entityManager;

    private function __construct() {

    }

    public static function getInstance() {
        if (!isset(self::$_instance)) {
            self::$_instance = new Bootstrap();
        }
        return self::$_instance;
    }

    public function setEntityManagerCallable($callable) {
        if (!is_callable($callable)) {
            throw new \InvalidArgumentException('The provided parameter is not callable.');
        }
        $this->_entityManagerCallable = $callable;
        return $this;
    }

    public function getEntityManager() {
        if (!isset($this->_entityManager)) {
            if (!isset($this->_entityManagerCallable)) {
                throw new \RuntimeException('Please provide a callable to this bootstrap class which returns the entity manager.');
            }
            $this->_entityManager = call_user_func($this->_entityManagerCallable);
        }
        return $this->_entityManager;
    }

    public function setAnnotationReader(ReaderInterface $reader) {
        Reader::setAnnotationReader($reader);
        return $this;
    }

    public function setView(\Slim\Views\Twig $view) {
        $slimFormTemplatePath = realpath(implode(DIRECTORY_SEPARATOR, array(__DIR__, '..', 'templates')));
        $view->getInstance()->addExtension(new \SlimForm\Twig\Extension());
        $loader = $view->getInstance()->getLoader()->addPath($slimFormTemplatePath);
        $this->_view = $view;
        return $this;
    }

    public function getView() {
        if (!isset($this->_view)) {
            throw new \RuntimeException('Unable to get view before it was set in SlimForm Bootstrap.');
        }
        return $this->_view;
    }

    /**
     * @param string $ngClose
     */
    public function setNgClose($ngClose)
    {
        $this->_ngClose = $ngClose;
    }

    /**
     * @return string
     */
    public function getNgClose()
    {
        return $this->_ngClose;
    }

    /**
     * @param string $ngOpen
     */
    public function setNgOpen($ngOpen)
    {
        $this->_ngOpen = $ngOpen;
    }

    /**
     * @return string
     */
    public function getNgOpen()
    {
        return $this->_ngOpen;
    }



}