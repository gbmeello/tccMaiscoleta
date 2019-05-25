<?php
/**
 * Created by PhpStorm.
 * User: marci
 * Date: 01/05/2019
 * Time: 14:18
 */

namespace App\Http\Controllers\Api\v1;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

abstract class ApiController extends Controller
{
    public const HTTP_STATUS_SUCCESS = 200;
    public const HTTP_STATUS_CREATED = 201;
    public const HTTP_STATUS_BAD_REQUEST = 400;
    public const HTTP_STATUS_NOT_FOUND = 404;
}