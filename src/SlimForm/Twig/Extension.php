<?php
namespace SlimForm\Twig;

class Extension extends \Twig_Extension {
    public function getName()
    {
        return 'slimform';
    }

    public function getFilters() {
        return \SlimForm\Twig\Extension\Filters::getInstance()->getFilters();
    }

    public function getFunctions() {
        return array(
            new \Twig_SimpleFunction('ngOpen', array($this, 'ngOpen')),
            new \Twig_SimpleFunction('ngClose', array($this, 'ngClose')),
        );
    }

    public function ngOpen() {
        return \SlimForm\Bootstrap::getInstance()->getNgOpen();
    }

    public function ngClose() {
        return \SlimForm\Bootstrap::getInstance()->getNgClose();
    }
}