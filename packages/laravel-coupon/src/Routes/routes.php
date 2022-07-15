<?php

use Illuminate\Routing\Route;

Route::get('info', ['as' => 'info', 'uses' => 'Tasmidur\LaravelCoupon\Controllers\CouponController@info']);
