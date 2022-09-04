<?php

namespace App\Models\Traits;

use App\Enums\CurrencyType;
use App\Models\Currency;

trait HandleCurrency
{
    public function currencies()
    {
        return $this->belongsToMany(Currency::class)
            ->withPivot('amount');
    }

    public function currency($type)
    {
        return $this->currencies()
            ->where('currencies.working_title', $type)
            ->first() ?? 0;
    }

    public function setCurrency(CurrencyType $currency, int $value = 0)
    {
        $currency = $this->currency($currency);
        $currency->pivot->amount = $value;
        $currency->pivot->save();
    }

    public function addCurrency(CurrencyType $currency, int $value = 1)
    {
        $currency = $this->currency($currency);
        ($currency->pivot?->amount < ($currency->maximum ?? INF))
            ? $currency->pivot->amount += $value
            : $currency->pivot->amount = $currency->maximum;

        $currency->pivot->save();
    }

    public function removeCurrency(CurrencyType $currency, int $value = 1)
    {
        $currency = $this->currency($currency);
        ($currency->pivot?->amount > $value)
            ? $currency->pivot->amount -= $value
            : $currency->pivot->amount -= 0;

        $currency->pivot->save();
    }
}
