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

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use App\Devices;
use App\UserCompany;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * The Foo class.
 *
 * @version Release: 1.0
 */
class LaporanAdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    //Devices
    public function index()
    {
        //$user_companies = UserCompany::where('user_id', $user_id)->first();
        $devices = DB::table('pawoon2.devices')
            ->select(DB::raw('distinct pawoon2.devices.name as device_name, pawoon2.companies.name as company_name, pawoon2.users.email as email_owner, pawoon2.transactions.device_timestamp as last_transaction, pawoon2.roles_2.name as tier'))
            ->join('pawoon2.companies', 'pawoon2.devices.company_id', '=', 'pawoon2.companies.c_id')
            ->join('pawoon1.user_companies', 'pawoon1.user_companies.company_id', '=', 'pawoon2.companies.c_id')
            ->join('pawoon2.outlets', 'pawoon2.outlets.company_id', '=', 'pawoon2.companies.c_id')
            ->join('pawoon2.transactions', 'pawoon2.transactions.outlet_id', '=', 'pawoon2.outlets.c_id')
            ->join('pawoon2.user_has_companies', 'pawoon2.companies.c_id', '=', 'pawoon2.user_has_companies.company_id')
            ->join('pawoon2.users', 'pawoon2.users.c_id', '=', 'pawoon2.user_has_companies.user_id')
            ->join('pawoon2.model_has_roles', 'pawoon2.model_has_roles.model_id', '=', 'pawoon2.users.u_id')
            ->join('pawoon2.roles', 'pawoon2.model_has_roles.role_id', '=', 'pawoon2.roles.r_id')
            ->join('pawoon2.model_has_roles as model_has_roles_2', 'pawoon2.model_has_roles_2.model_id', '=', 'pawoon2.companies.c_id')
            ->join('pawoon2.roles as roles_2', function ($join) {
                $join->on('pawoon2.model_has_roles_2.role_id', '=', 'pawoon2.roles_2.r_id')
                    ->where('pawoon2.model_has_roles_2.model_type', 'App\Company');
            })
            ->where('pawoon2.roles.r_id', '1')
            //->where('pawoon1.user_companies.user_id', $user_id)
            ->groupBy('pawoon2.devices.d_id')
            ->limit(500)

            // dd($devices->toSql());
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Show devices',
            'data' => [
                'users' => $devices,
            ],
        ], 200)
            ->header('Access-Control-Allow-Origin', '*');
    }

    //Company
    public function show()
    {
        $users = DB::table('pawoon2.users')
            ->select(DB::raw('distinct pawoon2.roles_2.name as tier, pawoon2.companies.name as company_name, pawoon2.users.email as email_owner, FORMAT(pawoon2.transactions.final_amount, 2, "id_ID") as transaction_amount, pawoon2.transactions.device_timestamp as Tanggal'))
            ->where('pawoon2.roles.r_id', '1')
            ->join('pawoon2.user_has_companies', 'pawoon2.users.u_id', '=', 'pawoon2.user_has_companies.user_id')
            ->join('pawoon2.companies', 'pawoon2.companies.c_id', '=', 'pawoon2.user_has_companies.company_id')
            ->join('pawoon1.user_companies', 'pawoon1.user_companies.company_id', '=', 'pawoon2.companies.c_id')
            ->join('pawoon2.model_has_roles', 'pawoon2.model_has_roles.model_id', '=', 'pawoon2.user_has_companies.uhc_id')
            ->join('pawoon2.roles', 'pawoon2.roles.r_id', '=', 'pawoon2.model_has_roles.role_id')
            ->join('pawoon2.outlets', 'pawoon2.outlets.company_id', '=', 'pawoon2.companies.c_id')
            ->join('pawoon2.transactions', 'pawoon2.transactions.outlet_id', '=', 'pawoon2.outlets.o_id')
            ->join('pawoon2.model_has_roles as model_has_roles_2', 'pawoon2.model_has_roles_2.model_id', '=', 'pawoon2.companies.c_id')
            ->join('pawoon2.roles as roles_2', function ($join) {
                $join->on('pawoon2.model_has_roles_2.role_id', '=', 'pawoon2.roles_2.r_id')
                    ->where('pawoon2.model_has_roles_2.model_type', 'App\Company');
            })
            ->groupBy('pawoon2.companies.c_id')
            ->limit(1000)
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
}
