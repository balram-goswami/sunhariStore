<?php

namespace App\Services;

use App\Models\Commission;

class CommissionService
{
    public function calculate($orderTotal)
    {
        $settings = Commission::first(); 

        if (!$settings) {
            return 0;
        }

        $commission = 0;

        if ($settings->type === 'percentage') {
            $commission = ($settings->value / 100) * $orderTotal;
        } else {
            $commission = $settings->value;
        }

        // Apply minimum limit
        if (!is_null($settings->min_amount) && $commission < $settings->min_amount) {
            $commission = $settings->min_amount;
        }

        // Apply maximum limit
        if (!is_null($settings->max_amount) && $commission > $settings->max_amount) {
            $commission = $settings->max_amount;
        }

        return $commission;
    }
}
