<?php

namespace Hoathis\SymfonyConsoleBridge\Formatter;

use Hoa\Console\Cursor;
use Symfony\Component\Console\Formatter\OutputFormatterStyleInterface;

class OutputFormatterStyle implements OutputFormatterStyleInterface
{
    protected $foreground;
    protected $background;
    protected $options = array();

    function __construct($foreground = null, $background = null, array $options = array())
    {
        $this
            ->setForeground($foreground)
            ->setBackground($background)
            ->setOptions($options)
        ;
    }

    public function setForeground($color = null)
    {
        $this->foreground = $color;

        return $this;
    }

    public function setBackground($color = null)
    {
        $this->background = $color;

        return $this;
    }

    public function setOption($option)
    {
        $this->options[] = $option;

        return $this;
    }

    public function unsetOption($option)
    {
        if (false !== ($key = array_search($option, $this->options))) {
            unset($this->options[$key]);
        }

        return $this;
    }

    public function setOptions(array $options)
    {
        foreach ($options as $option) {
            $this->setOption($option);
        }

        return $this;
    }

    public function apply($text)
    {
        ob_start();

        $attributes = array();

        if (null !== $this->foreground) {
            $attributes[] = sprintf('fg(%s)', $this->foreground);
        }

        if (null !== $this->background) {
            $attributes[] = sprintf('bg(%s)', $this->background);
        }

        Cursor::colorize(implode(' ', array_merge($attributes, $this->options)));
        echo $text;
        Cursor::colorize('fg(default) bg(default) n');

        return ob_get_clean();
    }
}
