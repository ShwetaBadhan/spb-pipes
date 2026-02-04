<?php

if (!function_exists('convertNumberToWords')) {
    function convertNumberToWords($number) {
        $number = floor($number);
        
        $ones = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten', 
                 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];
        $tens = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];
        
        if ($number < 20) {
            return $ones[$number];
        }
        
        if ($number < 100) {
            return trim($tens[floor($number / 10)] . ' ' . $ones[$number % 10]);
        }
        
        if ($number < 1000) {
            return trim($ones[floor($number / 100)] . ' Hundred ' . convertNumberToWords($number % 100));
        }
        
        if ($number < 100000) {
            return trim(convertNumberToWords(floor($number / 1000)) . ' Thousand ' . convertNumberToWords($number % 1000));
        }
        
        if ($number < 10000000) {
            return trim(convertNumberToWords(floor($number / 100000)) . ' Lakh ' . convertNumberToWords($number % 100000));
        }
        
        return trim(convertNumberToWords(floor($number / 10000000)) . ' Crore ' . convertNumberToWords($number % 10000000));
    }
}