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
 */

namespace App\Http\Controllers;

use App\Company; //File Model
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * The Foo class.
 *
 * @version Release: 1.0
 */
class DashboardCSEController extends Controller
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

    //List User
    public function companies($userId)
    {
        //$company = Company::all();
        $companies = DB::table('pawoon2.companies')
            ->select(DB::raw("COUNT('pawoon2.companies') as total"))
            ->where('pawoon1.user_companies.user_id', $userId)
            ->join('pawoon1.user_companies', 'pawoon1.user_companies.company_id', '=', 'pawoon2.companies.id')
            ->get();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Count',
            'data' => [
                'companies' => $companies,
            ],
        ], 200)
            ->header('Access-Control-Allow-Origin', '*');
    }

    public function outlets($userId)
    {
        $outlets = DB::table('pawoon2.outlets')
            ->select(DB::raw("COUNT('pawoon2.outlets') as total"))
            ->where('pawoon1.user_companies.user_id', $userId)
            ->join('pawoon2.companies', 'pawoon2.outlets.company_id', '=', 'pawoon2.companies.id')
            ->join('pawoon1.user_companies', 'pawoon1.user_companies.company_id', '=', 'pawoon2.companies.id')
            ->get();
        return response()->json([
            'success' => true,
            'message' => 'Jumlah Outlets',
            'data' => [
                'outlets' => $outlets,
            ],
        ], 200)
            ->header('Access-Control-Allow-Origin', '*');
    }

    public function devices($userId)
    {
        $devices = DB::table('pawoon2.devices')
            ->select(DB::raw("COUNT('pawoon2.devices') as total"))
            ->where('pawoon1.user_companies.user_id', $userId)
            ->join('pawoon2.companies', 'pawoon2.devices.company_id', '=', 'pawoon2.companies.id')
            ->join('pawoon1.user_companies', 'pawoon1.user_companies.company_id', '=', 'pawoon2.companies.id')
            ->get();
        return response()->json([
            'success' => true,
            'message' => 'Jumlah Outlets',
            'data' => [
                'devices' => $devices,
            ],
        ], 200)
            ->header('Access-Control-Allow-Origin', '*');
    }

    public function transactions($userId)
    {
        $transactions = DB::table('pawoon2.transactions')
            ->select(DB::raw("COUNT('pawoon2.transactions') as total"))
            ->where('pawoon1.user_companies.user_id', $userId)
            ->join('pawoon2.outlets', 'pawoon2.transactions.outlet_id', '=', 'pawoon2.outlets.id')
            ->join('pawoon2.companies', 'pawoon2.outlets.company_id', '=', 'pawoon2.companies.id')
            ->join('pawoon1.user_companies', 'pawoon1.user_companies.company_id', '=', 'pawoon2.companies.id')
            ->get();
        return response()->json([
            'success' => true,
            'message' => 'Jumlah Transactions',
            'data' => [
                'transactions' => $transactions,
            ],
        ], 200)
            ->header('Access-Control-Allow-Origin', '*');
    }
}
