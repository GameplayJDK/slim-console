<?php

/**
 * The MIT License (MIT)
 * Copyright (c) 2019 GameplayJDK
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated
 * documentation files (the "Software"), to deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the
 * Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
 * WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
 * OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace Slim\Console;

use Slim\Console\ArgvParser;
use Slim\Console\Middleware\ConsoleMiddleware;
use Slim\Http\Environment;

/**
 * Class Console.
 *
 * @package Slim\Console
 * @author GameplayJDK<github@gameplayjdk.de>
 * @version 1.0
 */
class Console
{
    const SAPI_CLI = 'cli';
    const SAPI_CGI = 'cgi';

    /**
     * @var ArgvParserInterface
     */
    private $argvParser;

    /**
     * Console constructor.
     *
     * Create a new console object and set the argv parser to the given argv parser. If omitted, it will be set to a new
     * instance of `ArgvParser\DirectArgvParser`.
     *
     * @param ArgvParserInterface|null $argvParser
     */
    public function __construct(?ArgvParserInterface $argvParser = null)
    {
        $this->argvParser = $argvParser ?: (new ArgvParser\DirectArgvParser());
    }

    /**
     * Check whether the console is supported right now. This should be called doing:
     *
     * <code>
     * $configuration['environment'] = $console->getEnvironment();
     * </code>
     *
     * @return bool
     */
    public function isSupported(): bool
    {
        $phpSapiName = php_sapi_name();

        return (static::SAPI_CLI === $phpSapiName) || (strpos($phpSapiName, static::SAPI_CGI) !== false);
    }

    /**
     * Return the mocked environment containing the `REQUEST_URI` which is created from the given argv array using the
     * currently set argv parser.
     *
     * @param array $argv
     * @return Environment
     */
    public function getEnvironment(array $argv): Environment
    {
        return Environment::mock([
            'REQUEST_URI' => $this->parse($argv),
        ]);
    }

    /**
     * Forward the call to the currently set argv parser. This function may be overridden in extending console classes.
     *
     * @param array $argv
     * @return string
     */
    protected function parse(array $argv): string
    {
        return $this->argvParser->parse($argv);
    }

    /**
     * @return ArgvParserInterface
     */
    public function getArgvParser(): ArgvParserInterface
    {
        return $this->argvParser;
    }

    /**
     * @param ArgvParserInterface $argvParser
     */
    public function setArgvParser(ArgvParserInterface $argvParser): void
    {
        $this->argvParser = $argvParser;
    }

    /**
     * Shortcut for creating a new console middleware. Equivalent to:
     *
     * <code>
     * $consoleMiddleware = new ConsoleMiddleware();
     * $consoleMiddleware->setConsole($console);
     * </code>
     *
     * @return ConsoleMiddleware
     */
    public function getMiddleware(): ConsoleMiddleware
    {
        $consoleMiddleware = new ConsoleMiddleware();
        $consoleMiddleware->setConsole($this);

        return $consoleMiddleware;
    }
}
