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
use Illuminate\Contracts\Auth\Factory as Auth;
use App\User;
/**
 * The Foo class.
 *
 * @version Release: 1.0
 */
class Admin
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {
        if ($apiToken = $request->header('api_token')) {

            if ($user = User::where('api_token', $apiToken)->first()) {

                $type = $user->type;
                //dd($type);
                if ($type == 'admin') {
                    return $next($request);
                }
            }
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
