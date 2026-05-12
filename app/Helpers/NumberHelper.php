<?php

namespace App\Helpers;

class NumberHelper
{
    public static function terbilang($angka)
    {
        $angka = abs($angka);
        $baca = array("", "SATU", "DUA", "TIGA", "EMPAT", "LIMA", "ENAM", "TUJUH", "DELAPAN", "SEMBILAN", "SEPULUH", "SEBELAS");
        $terbilang = "";

        if ($angka < 12) {
            $terbilang = " " . $baca[$angka];
        } else if ($angka < 20) {
            $terbilang = self::terbilang($angka - 10) . " BELAS ";
        } else if ($angka < 100) {
            $terbilang = self::terbilang($angka / 10) . " PULUH " . self::terbilang($angka % 10);
        } else if ($angka < 200) {
            $terbilang = " SERATUS" . self::terbilang($angka - 100);
        } else if ($angka < 1000) {
            $terbilang = self::terbilang($angka / 100) . " RATUS " . self::terbilang($angka % 100);
        } else if ($angka < 2000) {
            $terbilang = " SERIBU" . self::terbilang($angka - 1000);
        } else if ($angka < 1000000) {
            $terbilang = self::terbilang($angka / 1000) . " RIBU " . self::terbilang($angka % 1000);
        } else if ($angka < 1000000000) {
            $terbilang = self::terbilang($angka / 1000000) . " JUTA " . self::terbilang($angka % 1000000);
        }

        return trim($terbilang);
    }
}