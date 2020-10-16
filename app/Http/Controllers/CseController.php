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

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Update; //File Model
use App\Users;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\QueryBuilder\AllowedFilter;
/**
 * The Foo class.
 *
 * @version Release: 1.0
 */
class CseController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function cse()
    {
        $users = DB::table('users')
            ->select('name', 'email', 'type', 'id')
            ->where('users.type', 'CSE')
            ->get();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Show CSE',
            'data' => [
                'users' => $users,
            ],
        ], 200)
            ->header('Access-Control-Allow-Origin', '*');
    }
}
