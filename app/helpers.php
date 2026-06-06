<?php

use Illuminate\Support\Facades\App;

if (! function_exists('format_price')) {
    function format_price(float $number, int $decimals = 2): string
    {
        $formatted = number_format($number, $decimals, '.', ',');

        if (App::getLocale() === 'ne') {
            $nepaliDigits = ['०', '१', '२', '३', '४', '५', '६', '७', '८', '९'];
            $englishDigits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
            $formatted = str_replace($englishDigits, $nepaliDigits, $formatted);
        }

        return $formatted;
    }
}
