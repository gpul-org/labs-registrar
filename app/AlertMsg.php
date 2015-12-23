<?php namespace Registration;


class AlertMsg
{
    private $className;
    private $text;

    /**
     * @return mixed
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * AlertMsg constructor.
     * @param $className
     * @param $text
     */
    public function __construct($className, $text)
    {
        $this->className = $className;
        $this->text = $text;
    }
}