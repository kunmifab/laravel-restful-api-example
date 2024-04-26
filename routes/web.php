<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-database-connection', function () {
    try {
        // Attempt to fetch some data from the database
        $results = DB::select('select * from information_schema.tables limit 1');
        return response()->json(['success' => true, 'message' => 'Database connection successful']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
    }
});
