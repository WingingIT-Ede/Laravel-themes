<?php


namespace WingingIT\Themes;


interface Theme
{
    public function getKey();
    public function getName();
    public function getVersion();
    public function getLayout();
    public function getBladeNameSpace();
}