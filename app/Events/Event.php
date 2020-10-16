<?php

/**
 * Short description here.
 *
 * PHP version 5
 *
 * @category Foo
 * @package Foo_Helpers
 * @author Marty McFly <mmcfly@example.com>
 * @copyright 2013-2014 Foo Inc.
 * @license MIT License
 * @link http://example.com
 */

namespace App\Events;
/**
 * The Foo class.
 *
 * @version Release: 1.0
 */
use Illuminate\Queue\SerializesModels;

abstract class Event
{
    use SerializesModels;
}
