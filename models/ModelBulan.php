<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ModelBulan extends Model
{
	public static function ambilSemuaBulan(){
		$bulan = [
			1  => "Januari",
			2  => "Februari",
			3  => "Maret",
			4  => "April",
			5  => "Mei",
			6  => "Juni",
			7  => "Juli",
			8  => "Agustus",
			9  => "September",
			10 => "Oktober",
			11 => "November",
			12 => "Desember",
		];
		return $bulan ;
	}
	public function ambilNamaBulan($bulan)
    {
        if ($bulan == 1) {
            return "Januari";
        }elseif ($bulan == 2) {
            return "Februari";
        }elseif ($bulan == 3) {
            return "Maret";
        }elseif ($bulan == 4) {
            return "April";
        }elseif ($bulan == 5) {
            return "Mei";
        }elseif ($bulan == 6) {
            return "Juni";
        }elseif ($bulan == 7) {
            return "Juli";
        }elseif ($bulan == 8) {
            return "Agustus";
        }elseif ($bulan == 9) {
            return "September";
        }elseif ($bulan == 10) {
            return "Oktober";
        }elseif ($bulan == 11) {
            return "November";
        }elseif ($bulan == 12) {
            return "Desember";
        }else{
            return "Bulan Invalid";
        }
    }
}