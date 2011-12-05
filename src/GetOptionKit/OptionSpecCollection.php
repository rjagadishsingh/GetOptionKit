<?php
/*
 * This file is part of the GetOptionKit package.
 *
 * (c) Yo-An Lin <cornelius.howl@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */
namespace GetOptionKit;

class OptionSpecCollection
{
    public $data;

    function __construct()
    {
        $this->data = array();
    }

    function addFromSpecString($specString,$description = null,$key = null)
    {
        // parse spec
        $spec = new OptionSpec($specString);
        if( $description )
            $spec->description = $description;
        if( $key )
            $spec->key = $key;
        $this->add( $spec );
        return $spec;
    }

    function add($spec )
    {
        $this->data[ $spec->getId() ] = $spec;
    }

    /* get spec by spec id */
    function get($id)
    {
        return @$this->data[ $id ];
    }

    function size()
    {
        return count($this->data);
    }

    function all()
    {
        return $this->data;
    }

    function toArray()
    {
        $array = array();
        foreach($this->data as $k => $spec) {
            $item = array();
            if( $spec->long )
                $item['long'] = $spec->long;
            if( $spec->short )
                $item['short'] = $spec->short;
            $item['description'] = $spec->description;
            $array[] = $item;
        }
        return $array;
    }

    function printOptions( $class = 'GetOptionKit\OptionPrinter' )
    {
        $printer = new $class( $this );
        if( !( $printer instanceof \GetOptionKit\OptionPrinterInterface )) {
            throw new Exception("$class does not implement GetOptionKit\OptionPrinterInterface.");
        }
        $printer->printOptions();
    }

}
