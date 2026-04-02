<?php

if (!function_exists('convertNumberToWords')) {
    function convertNumberToWords($number, $currency = 'Rupees', $subUnit = 'Paisa')
    {
        if (!is_numeric($number)) return '';
        
        $number = floatval($number);
        
        if ($number < 0) {
            return 'Negative ' . convertNumberToWords(abs($number), $currency, $subUnit);
        }

        // Split into rupees and paisa
        $rupees = floor($number);
        $paisa = round(($number - $rupees) * 100);

        $words = convertIntegerToWords($rupees);
        $result = trim($words) . ' ' . $currency;

        if ($paisa > 0) {
            $paisaWords = convertIntegerToWords($paisa);
            $result .= ' and ' . trim($paisaWords) . ' ' . $subUnit;
        }

        return trim($result) . ' Only';
    }

    // Helper for integer conversion only
    function convertIntegerToWords($number)
    {
        $number = (int) $number;
        
        if ($number == 0) return 'Zero';

        $words = [
            0 => '', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four',
            5 => 'Five', 6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
            10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen',
            14 => 'Fourteen', 15 => 'Fifteen', 16 => 'Sixteen', 17 => 'Seventeen',
            18 => 'Eighteen', 19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
            40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty', 70 => 'Seventy',
            80 => 'Eighty', 90 => 'Ninety', 100 => 'Hundred'
        ];

        if ($number < 21) return $words[$number];
        if ($number < 100) {
            return $words[floor($number / 10) * 10] . 
                   ($number % 10 ? ' ' . $words[$number % 10] : '');
        }
        if ($number < 1000) {
            return $words[floor($number / 100)] . ' Hundred' . 
                   ($number % 100 ? ' ' . convertIntegerToWords($number % 100) : '');
        }
        if ($number < 100000) {
            return convertIntegerToWords(floor($number / 1000)) . ' Thousand' . 
                   ($number % 1000 ? ' ' . convertIntegerToWords($number % 1000) : '');
        }
        if ($number < 10000000) {
            return convertIntegerToWords(floor($number / 100000)) . ' Lakh' . 
                   ($number % 100000 ? ' ' . convertIntegerToWords($number % 100000) : '');
        }
        return convertIntegerToWords(floor($number / 10000000)) . ' Crore' . 
               ($number % 10000000 ? ' ' . convertIntegerToWords($number % 10000000) : '');
    }
}