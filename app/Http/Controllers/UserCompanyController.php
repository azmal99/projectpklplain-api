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

use App\UserCompany; //File Model
use App\Users;
use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Illuminate\Database\Query\Builder;

/**
 * The Foo class.
 *
 * @version Release: 1.0
 */
class UserCompanyController extends Controller
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
    public function store(Request $request, $uuid)
    {
        $user = Users::where('uuid', $uuid)->first();
        $company = Company::where('uuid', $request->input('company_uuid'))->first();
        $userCompany = new UserCompany();
        $userCompany->user_id = $user->id;
        $userCompany->company_id = $company->id;
        $userCompany->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Tambah User',
            'data' => [
                'user' => $userCompany,
            ],
        ], 201)
            ->header('Access-Control-Allow-Origin', '*');
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    //CREATE
    public function save(Request $request)
    {
        $users = new UserCompany();
        $users->user_id = ($request->input('user_id'));
        $users->company_id = ($request->input('company_id'));
        $users->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Tambah User',
            'data' => [
                'user' => $users,
            ],
        ], 201)
            ->header('Access-Control-Allow-Origin', '*');
    }
}
