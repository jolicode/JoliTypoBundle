<?php
namespace Joli\TypoBundle\Templating\Helper;

use Symfony\Component\Templating\Helper\Helper;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

class JoliTypoHelper extends Helper
{
    private $presets = array();

    public function __construct($presets)
    {
        $this->presets = $presets;
    }

    public function fix($text, $preset = "default")
    {
        if (!isset($this->presets[$preset])) {
            throw new InvalidConfigurationException(sprintf("There is no '%s' preset configured.", $preset));
        }

        return $this->presets[$preset]->fix($text);
    }

    public function getName()
    {
        return 'jolitypo';
    }
}
