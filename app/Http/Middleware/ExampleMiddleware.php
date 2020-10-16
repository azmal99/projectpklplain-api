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

namespace App\Http\Middleware;

use Closure;

/**
 * The Foo class.
 *
 * @version Release: 1.0
 */
class ExampleMiddleware
{
    /**
     * Handle an incoming request.
     *
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}
