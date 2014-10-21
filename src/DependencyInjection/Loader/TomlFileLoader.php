<?php

/**
 * This file is part of Bldr.io
 *
 * (c) Aaron Scherer <aequasi@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE
 */

namespace Bldr\DependencyInjection\Loader;

use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Yosymfony\Toml\Parser as TomlParser;

/**
 * @author Rob Loach <robloach@gmail.com>
 */
class TomlFileLoader extends JsonFileLoader
{
    use SupportsTrait;

    private $tomlParser;

    /**
     * Loads the Toml File
     *
     * @param string $file
     *
     * @throws \Symfony\Component\DependencyInjection\Exception\InvalidArgumentException
     * @return array
     */
    protected function loadFile($file)
    {
        if (!stream_is_local($file)) {
            throw new InvalidArgumentException(sprintf('This is not a local file "%s".', $file));
        }

        if (!file_exists($file)) {
            throw new InvalidArgumentException(sprintf('The service file "%s" is not valid.', $file));
        }

        if (null === $this->tomlParser) {
            $this->tomlParser = new TomlParser();
        }

        return $this->tomlParser->parse(file_get_contents($file), true);
    }
}
