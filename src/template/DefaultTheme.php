<?php


namespace Themes\DefaultTheme;


use WingingIT\Themes\Theme;

class <THEMENAME> implements Theme
{

    private $key = '<THEMENAME>';
    private $name = 'Default theme';
    private $version = '0.1';
    private $layout = 'layout';
    private $bladeNameSpace = '<THEMENAME>';

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @return string
     */
    public function getLayout(): string
    {
        return $this->layout;
    }

    /**
     * @return string
     */
    public function getBladeNameSpace(): string
    {
        return $this->bladeNameSpace;
    }
}