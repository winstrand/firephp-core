<?php
// Authors:
// - cadorn, Christoph Dorn <christoph@christophdorn.com>, Copyright 2007, New BSD License
// - qbbr, Sokolov Innokenty <sokolov.innokenty@gmail.com>, Copyright 2011, New BSD License
// - cadorn, Christoph Dorn <christoph@christophdorn.com>, Copyright 2011, MIT License
// - marwin, Martin Winstrand <martin.winstrand@gmail.com>, Copyright 2025, MIT License

/**
 * ***** BEGIN LICENSE BLOCK *****
 *
 * [MIT License](http://www.opensource.org/licenses/mit-license.php)
 *
 * Copyright (c) 2007+ [Christoph Dorn](http://www.christophdorn.com/)
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * ***** END LICENSE BLOCK *****
 *
 * @copyright   Copyright (C) 2007+ Christoph Dorn
 * @author      Christoph Dorn <christoph@christophdorn.com>
 * @license     [MIT License](http://www.opensource.org/licenses/mit-license.php)
 * @package     FirePHPCore
 */

namespace FirePHP;

if (!class_exists('FirePHP', false)) {
    require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'FirePHP.class.php';
}

/**
 * Sends the given data to the FirePHP Firefox Extension.
 * The data can be displayed in the Firebug Console or in the
 * "Server" request tab.
 *
 * @see http://www.firephp.org/Wiki/Reference/Fb
 * @param mixed $Object
 * @return true
 * @throws Exception
 */
function fb()
{
    $instance = FirePHP::getInstance(true);

    $args = func_get_args();
    return call_user_func_array(array($instance, 'fb'), $args);
}


class FB
{
    /**
     * Set an Insight console to direct all logging calls to
     *
     * @param object $console The console object to log to
     * @return void
     */
    public static function setLogToInsightConsole(mixed $console)
    {
        FirePHP::getInstance(true)->setLogToInsightConsole($console);
    }

    /**
     * Enable and disable logging to Firebug
     *
     * @see FirePHP->setEnabled()
     * @param boolean $enabled TRUE to enable, FALSE to disable
     * @return void
     */
    public static function setEnabled(bool $enabled)
    {
        FirePHP::getInstance(true)->setEnabled($enabled);
    }

    /**
     * Check if logging is enabled
     *
     * @see FirePHP->getEnabled()
     * @return boolean TRUE if enabled
     */
    public static function getEnabled() : bool
    {
        return FirePHP::getInstance(true)->getEnabled();
    }

    /**
     * Specify a filter to be used when encoding an object
     *
     * Filters are used to exclude object members.
     *
     * @see FirePHP->setObjectFilter()
     * @param string $class The class name of the object
     * @param array $filter An array or members to exclude
     * @return void
     */
    public static function setObjectFilter(string $class, array $filter)
    {
      FirePHP::getInstance(true)->setObjectFilter($class, $filter);
    }

    /**
     * Set some options for the library
     *
     * @see FirePHP->setOptions()
     * @param array $options The options to be set
     * @return void
     */
    public static function setOptions(array $options)
    {
        FirePHP::getInstance(true)->setOptions($options);
    }

    /**
     * Get options for the library
     *
     * @see FirePHP->getOptions()
     * @return array The options
     */
    public static function getOptions() : mixed
    {
        return FirePHP::getInstance(true)->getOptions();
    }

    /**
     * Log object to firebug
     *
     * @see http://www.firephp.org/Wiki/Reference/Fb
     * @param mixed $object
     * @return true
     * @throws Exception
     */
    public static function send(): bool
    {
        $args = func_get_args();
        return call_user_func_array(array(FirePHP::getInstance(true), 'fb'), $args);
    }

    /**
     * Start a group for following messages
     *
     * Options:
     *   Collapsed: [true|false]
     *   Color:     [#RRGGBB|ColorName]
     *
     * @param string $name
     * @param array $options OPTIONAL Instructions on how to log the group
     * @return true
     */
    public static function group(string $name, array $options=null): bool
    {
        return FirePHP::getInstance(true)->group($name, $options);
    }

    /**
     * Ends a group you have started before
     *
     * @return true
     * @throws Exception
     */
    public static function groupEnd() : bool
    {
        return self::send(null, null, FirePHP::GROUP_END);
    }

    /**
     * Log object with label to firebug console
     *
     * @see FirePHP::LOG
     * @param mixed $object
     * @param string $label
     * @return true
     * @throws Exception
     */
    public static function log(mixed $object, ?string $label=null) : bool
    {
        return self::send($object, $label, FirePHP::LOG);
    }

    /**
     * Log object with label to firebug console
     *
     * @see FirePHP::INFO
     * @param mixed $object
     * @param string $label
     * @return true
     * @throws Exception
     */
    public static function info(mixed $object, ?string $label=null) : bool
    {
        return self::send($object, $label, FirePHP::INFO);
    }

    /**
     * Log object with label to firebug console
     *
     * @see FirePHP::WARN
     * @param mixed $object
     * @param string $label
     * @return true
     * @throws Exception
     */
    public static function warn(mixed $object, ?string $label=null) : bool
    {
        return self::send($object, $label, FirePHP::WARN);
    }

    /**
     * Log object with label to firebug console
     *
     * @see FirePHP::ERROR
     * @param mixed $object
     * @param string $label
     * @return true
     * @throws Exception
     */
    public static function error(mixed $object, ?string $label=null) : bool
    {
        return self::send($object, $label, FirePHP::ERROR);
    }

    /**
     * Dumps key and variable to firebug server panel
     *
     * @see FirePHP::DUMP
     * @param string $key
     * @param mixed $variable
     * @return true
     * @throws Exception
     */
    public static function dump(string $key, mixed $variable) : bool
    {
        return self::send($variable, $key, FirePHP::DUMP);
    }

    /**
     * Log a trace in the firebug console
     *
     * @see FirePHP::TRACE
     * @param string $label
     * @return true
     * @throws Exception
     */
    public static function trace(string $label) : bool
    {
        return self::send($label, FirePHP::TRACE);
    }

    /**
     * Log a table in the firebug console
     *
     * @see FirePHP::TABLE
     * @param string $label
     * @param string $table
     * @return true
     * @throws Exception
     */
    public static function table(string $label, string $table) : bool
    {
        return self::send($table, $label, FirePHP::TABLE);
    }

}
