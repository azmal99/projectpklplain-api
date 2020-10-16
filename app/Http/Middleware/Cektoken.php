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
use App\Users;

/**
 * The Foo class.
 *
 * @version Release: 1.0
 */
class Cektoken
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {
        if ($request->has('api_token')) {
            $checkToken = Users::where('api_token', $apiToken)->first();
            if ($checkToken == null) {
                $res['success'] = false;
                $res['message'] = 'Permission not allowed';
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        }
        return $next($request);
    }
}
