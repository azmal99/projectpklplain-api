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
namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
/**
 * The Foo class.
 *
 * @version Release: 1.0
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'type', 'api_token',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'api_token',
    ];


    //protected $primaryKey = 'uuid';

}
