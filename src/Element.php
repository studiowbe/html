<?php

namespace Studiow\HTML;

class Element
{

    /**
     * Attributes
     * @var \Studiow\HTML\Attributes 
     */
    public $attributes;

    /**
     * @var string
     */
    private $tagname, $innerHTML;
    private static $voidElements = [
        'area', 'base', 'br', 'col', 'embed', 'hr', 'img', 'input', 'keygen',
        'link', 'meta', 'param', 'source', 'track', 'wbr'
    ];

    /**
     * Constructor
     * @param string $tagname
     * @param string $innerHTML
     * @param array $attributes
     */
    public function __construct($tagname, $innerHTML = null, array $attributes = [])
    {
        $this->setTagName($tagname);
        $this->setInnerHTML($innerHTML);
        $this->attributes = new Attributes($attributes);
    }

    /**
     * Set the tagname
     * @param string $tagname
     * @return \Studiow\HTML\Element
     */
    public function setTagName($tagname)
    {
        $this->tagname = strtolower($tagname);
        return $this;
    }

    /**
     * Get the tagname
     * @return string
     */
    public function getTagName()
    {
        return $this->tagname;
    }

    /**
     * set the content of the element
     * @param string $innerHTML
     * @return \Studiow\HTML\Element
     */
    public function setInnerHTML($innerHTML)
    {
        $this->innerHTML = $innerHTML;
        return $this;
    }

    /**
     * get the content of the element
     * @return string
     */
    public function getInnerHTML()
    {
        return $this->innerHTML;
    }

    /**
     * Check if the current tagname if for a void element
     * @return bool
     */
    public function isVoidElement()
    {
        return in_array($this->getTagName(), self::$voidElements);
    }

    /**
     * Convert element to HTML
     * @return string
     */
    public function __toString()
    {
        if ($this->isVoidElement()) {
            return $this->getOpenTag();
        }
        return $this->getOpenTag() . $this->getInnerHTML() . $this->getCloseTag();
    }

    /**
     * Create HTML open tag, or a HTML5 void tag 
     * @return string
     */
    private function getOpenTag()
    {
        $content = trim("{$this->tagname} " . (string) $this->attributes);
        return "<{$content}>";
    }

    /**
     * Create HTML close tag 
     * @return string
     */
    private function getCloseTag()
    {
        return "</{$this->tagname}>";
    }

    /**
     * Add a class
     * @param string $classname
     * @return \Studiow\HTML\Element
     */
    public function addClass($classname)
    {
        $this->attributes->addClass($classname);
        return $this;
    }

    /**
     * Remove a class
     * @param string $classname
     * @return \Studiow\HTML\Element
     */
    public function removeClass($classname)
    {
        $this->attributes->removeClass($classname);
        return $this;
    }

    /**
     * Determine if the element has a certain class
     * @param string $classname
     * @return bool
     */
    public function hasClass($classname)
    {
        return $this->attributes->hasClass($classname);
    }

    /**
     * Set attribute
     * @param string $name
     * @param mixed $value
     * @return \Studiow\HTML\Element
     */
    public function setAttribute($name, $value)
    {
        $this->attributes[$name] = $value;
        return $this;
    }

    /**
     * Remove attribute
     * @param string $name
     */
    public function removeAttribute($name)
    {
        if (array_key_exists($name, $this->attributes)) {
            unset($this->attributes[$name]);
        }
    }

    /**
     * Get attribute value
     * @param type $name
     * @return mixed null if the attribute does not exist, otherwise the current value of the attribute
     */
    public function getAttribute($name)
    {
        return array_key_exists($name, $this->attributes) ? $this->attributes[$name] : null;
    }

}
