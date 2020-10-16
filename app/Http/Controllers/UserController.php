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

use App\Users; //File Model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UserExport;

/**
 * The Foo class.
 *
 * @version Release: 1.0
 */
class UserController extends Controller
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
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index()
    {
        $users = Users::all();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Melihat Table User',
            'data' => [
                'users' => $users,
            ],
        ], 200)
            ->header('Access-Control-Allow-Origin', '*');
    }
    //SHOW
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function show($uuid)
    {
        $users = Users::where('uuid', $uuid)->first();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Show User',
            'data' => [
                'user' => $users,
            ],
        ], 200)
            ->header('Access-Control-Allow-Origin', '*');
    }
    //CREATE
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function store(Request $request)
    {
        $users = new Users();
        $users->name = ($request->input('name'));
        $users->email = ($request->input('email'));
        $users->password = Hash::make($request->input('password'));
        $users->type = ($request->input('type'));

        if ($users->name != "" && $users->email != "" && $users->password != "" && $users->type != "") {
            $uuid4 = Uuid::uuid4();
            $users->uuid = $uuid4->toString();
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
        return response()->json([
            'success' => false,
            'message' => 'Gagal Tambah User',
            'data' => [''],
        ], 201)
            ->header('Access-Control-Allow-Origin', '*');
    }

    // UPDATE
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function update(Request $request, $uuid)
    {
        $users = Users::where('uuid', $uuid)->first();
        if ($users) {
            $users->update($request->all());
        }

        $users->name = $request->input('name');
        $users->email = $request->input('email');
        $users->password = Hash::make($request->input('password'));
        $users->type = $request->input('type');
        $users->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Update User',
            'data' => [
                'user' => $users,
            ],
        ], 201)
            ->header('Access-Control-Allow-Origin', '*');
    }
    //DELETE
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function destroy($uuid)
    {
        //$users = DB::table('users')->find($uuid);
        $users = Users::where('uuid', $uuid)->first();
        $users->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Delete User',
            'data' => [
                'user' => $users,
            ],
        ], 201)
            ->header('Access-Control-Allow-Origin', '*');
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function receiveInformation()
    {
        if (Response::ajax()) {
            return "OK";
        }
    }
}
