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
use App\Company;
use App\UserCompany;
use App\Users;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\QueryBuilder\AllowedFilter;
/**
 * The Foo class.
 *
 * @version Release: 1.0
 */
class CompanyController extends Controller
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
    public function show($uuid)
    {
        //$company = Company::where('uuid', $uuid)->first();
        $companies = DB::table('pawoon2.companies')
            ->select('pawoon2.companies.c_id as id', 'pawoon2.companies.uuid as uuid', 'pawoon2.companies.name as name', 'pawoon2.companies.address as address', 'pawoon2.companies.phone as phone')
            ->where('pawoon2.companies.uuid', $uuid)
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Show Company',
            'data' => [
                'user' => $companies,
            ],
        ], 200)
            ->header('Access-Control-Allow-Origin', '*');
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function destroy($uscoId)
    {
        $userCompany = UserCompany::where('usco_id', $uscoId)->first();
        $userCompany->delete();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Delete User',
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
    public function index($uuid)
    {
        $user = Users::where('uuid', $uuid)->first();
        //if ($userCompany){
        $users = DB::table('pawoon2.users')
            ->select('pawoon2.companies.uuid', 'pawoon2.companies.name as company_name', 'pawoon2.users.email as email_owner', 'pawoon1.user_companies.c_id as id')
            ->where('pawoon2.roles.r_id', '1')
            ->where('pawoon1.user_companies.user_id', $user->id)
            ->join('pawoon2.user_has_companies', 'pawoon2.users.us_id', '=', 'pawoon2.user_has_companies.user_id')
            ->join('pawoon2.companies', 'pawoon2.companies.c_id', '=', 'pawoon2.user_has_companies.company_id')
            ->join('pawoon1.user_companies', 'pawoon1.user_companies.company_id', '=', 'pawoon2.companies.id')
            ->join('pawoon2.model_has_roles', 'pawoon2.model_has_roles.model_id', '=', 'pawoon2.user_has_companies.uhc_id')
            ->join('pawoon2.roles', 'pawoon2.roles.r_id', '=', 'pawoon2.model_has_roles.role_id')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Show User',
            'data' => [
                'user' => $users,
            ],
        ], 200)
            ->header('Access-Control-Allow-Origin', '*');
        //}
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function list($uuid)
    {
        //$user = UserCompany::where('user_id', $id)->first();
        $users = DB::table('pawoon2.companies')
            ->select('pawoon2.companies.c_id as id', 'pawoon2.companies.uuid', 'pawoon2.companies.name', 'pawoon2.companies.address', 'pawoon2.companies.phone')
            ->where('pawoon1.users.uuid', '<>', $uuid)
            ->where('pawoon1.users.type', '=', 'CSM')
            ->join('pawoon1.user_companies', 'pawoon1.user_companies.company_id', '=', 'pawoon2.companies.c_id')
            ->join('pawoon1.users', 'pawoon1.user_companies.user_id', '=', 'pawoon1.users.id')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Melihat Table Company',
            'data' => [
                'user' => $users,
            ],
        ], 200)
            ->header('Access-Control-Allow-Origin', '*');
    }
}
