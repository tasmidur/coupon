<?php

return [

    /*
     * Table that will be used for migration
     */
    'table' => 'coupons',

    /*
     * Model to use
     */
    'model' => \Tasmidur\LaravelCoupon\Models\Coupon::class,

    /*
     * Pivot table name for coupons and other table relation
     */
    'coupon_applied_table' => 'coupon_applied',

    /*
     * List of characters that will be used for Coupon code generation.
     */
    'characters' => '123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz',

    /*
     * Coupon code prefix.
     *
     * Example: course2022
     * Generated Code: course2022-37JH-1PUY
     */
    'prefix' => null,

    /*
     * Coupon code suffix.
     *
     * Example: course2022
     * Generated Code: 37JH-1PUY-course2022
     */
    'suffix' => null,

    /*
     * Separator to be used between prefix, code and suffix.
     */
    'separator' => '-',

    'coupon_format'=>'*****-*****'

];
