<?php

namespace App\Http\Library;

class LocationDistance
{
  /**
   *2地点間の緯度経度から直線距離を求める
   *$lat1 => 地点1の緯度
   *$lon1 => 地点1の経度
   *$lat2 => 地点1の緯度
   *$lon2 => 地点1の経度
   */
  public function __invoke($lat1, $lon1, $lat2, $lon2)
  {
    $lat_average = deg2rad($lat1 + (($lat2 - $lat1) / 2)); //2点の緯度の平均
    $lat_difference = deg2rad($lat1 - $lat2); //2点の緯度差
    $lon_difference = deg2rad($lon1 - $lon2); //2点の経度差
    $curvature_radius_tmp = 1 - 0.00669438 * pow(sin($lat_average), 2);
    $meridian_curvature_radius = 6335439.327 / sqrt(pow($curvature_radius_tmp, 3)); //子午線曲率半径
    $prime_vertical_circle_curvature_radius = 6378137 / sqrt($curvature_radius_tmp); //卯酉線曲率半径

    //2点間の距離
    $distance = pow($meridian_curvature_radius * $lat_difference, 2) + pow($prime_vertical_circle_curvature_radius * cos($lat_average) * $lon_difference, 2);
    $distance = sqrt($distance);

    $distance_unit = round($distance);
    if ($distance_unit < 1000) { //1000m以下ならメートル表記
      $distance_unit = $distance_unit . "m";
    } else { //1000m以上ならkm表記
      $distance_unit = round($distance_unit / 100);
      $distance_unit = ($distance_unit / 10) . "km";
    }

    //$hoge['distance']で小数点付きの直線距離を返す（メートル）
    //$hoge['distance_unit']で整形された直線距離を返す（1000m以下ならメートルで記述 例：836m ｜ 1000m以下は小数点第一位以上の数をkmで記述 例：2.8km）
    return array("distance" => $distance, "distance_unit" => $distance_unit);
  }
}
