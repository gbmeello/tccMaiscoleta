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

abstract class ApiController extends Controller
{
    abstract function store(Request $request);
    abstract function list(Request $request);
    abstract function update(Request $request, $id);
    abstract function delete($id);
}