<?php

namespace Tasmidur\LaravelCoupon;

use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Symfony\Component\HttpFoundation\Response;
use Tasmidur\LaravelCoupon\Models\Coupon;
use Tasmidur\LaravelCoupon\Services\CouponCodeGeneratorService;
use Throwable;

class CouponCode
{
    private CouponCodeGeneratorService $couponCodeGeneratorService;
    /**
     * @var Application|mixed
     */
    private mixed $couponModel;


    /**
     * @param CouponCodeGeneratorService $couponCodeGeneratorService
     */
    public function __construct(CouponCodeGeneratorService $couponCodeGeneratorService)
    {
        $this->couponCodeGeneratorService = $couponCodeGeneratorService;
        $this->couponModel = app(config('coupon.model', Coupon::class));
    }

    /**
     * @param string $couponType
     * @param float $price
     * @param array $extraInfo
     * @param int $totalAmount
     * @param Carbon|null $expired_at
     * @return array
     */
    public function createCoupon(string $couponType, float $price, array $extraInfo = [], int $totalAmount = 1, Carbon $expired_at = null): array
    {
        $coupons = [];

        foreach ($this->generateCoupon($totalAmount) as $code) {
            $coupons[] = $this->couponModel->create([
                'code' => $code,
                'code_type' => $couponType,
                'price' => $price,
                'json_data' => $extraInfo,
                'expired_at' => $expired_at,
            ]);
        }

        return $coupons;
    }

    /**
     * @param int $totalAmount
     * @return array
     */
    public function generateCoupon(int $totalAmount): array
    {
        $codes = [];

        for ($i = 1; $i <= $totalAmount; $i++) {
            $codes[] = $this->getUniqueCoupon();
        }

        return $codes;
    }

    /**
     * @throws Throwable
     */
    public function check(string $code)
    {
        $coupon = $this->couponModel->whereCode($code)->first();

        throw_if(empty($coupon),new Exception('The provided code '.$code.' is invalid.',Response::HTTP_NOT_FOUND));

        throw_if($coupon->isExpired(),new Exception('The provided code '.$code.' is already expired.',Response::HTTP_NOT_FOUND));

        return $coupon;
    }

    /**
     * @return string
     */
    protected function getUniqueCoupon(): string
    {
        $code = $this->couponCodeGeneratorService->generateUniqueCoupon();

        while ($this->couponModel->whereCode($code)->count() > 0) {
            $code = $this->couponCodeGeneratorService->generateUniqueCoupon();
        }

        return $code;
    }




}
