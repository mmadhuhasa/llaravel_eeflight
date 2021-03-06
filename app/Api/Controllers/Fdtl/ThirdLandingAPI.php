<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Api\Controllers\Fdtl;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\models\FdtlAPIModel;
use App\models\FDTLStaticTimeModel;
use App\models\TotalFTModel;
use App\models\TotalFDPModel;
use App\models\FirstLandingModel;
use App\models\DayNightTimeModel;

class ThirdLandingAPI {

    public static function insert_data($data) {
        $id = $data['id'];
        $current_landing = $data['current_landing'];
        $aircraft_callsign = $data['aircraft_callsign'];
        $departure_aerodrome3 = $data['departure_aerodrome3'];
        $destination_aerodrome3 = $data['destination_aerodrome3'];
        $date_of_flight3 = $data['date_of_flight3'];
        $entered_departure_time3 = $data['departure_time3'];
        $combined_total_time3 = $data['total_flying_time3'];
        $departure_time_date_format3 = strtotime($entered_departure_time3);
        $total_flying_time3 = strtotime($combined_total_time3);

        //Add Dep Time and Total Flying Time
        $secs = strtotime($combined_total_time3) - strtotime("0000");
        $dep_time_total_time3 = date('Hi', strtotime($entered_departure_time3) + $secs);

        $fdtl_static_row = FDTLStaticTimeModel::get_single_row();
        $reporting_static_time = ($fdtl_static_row) ? $fdtl_static_row->reporting_time : "";
        $flight_static_time = ($fdtl_static_row) ? $fdtl_static_row->flight_time : "";
        $chocks_off_static_time = ($fdtl_static_row) ? $fdtl_static_row->chocks_off : "";
        $chocks_on_static_time = ($fdtl_static_row) ? $fdtl_static_row->chocks_on : "";
        $duty_end_static_time = ($fdtl_static_row) ? $fdtl_static_row->duty_end_time : "";

        $data_array = [
            'id' => $id,
            'aircraft_callsign' => $aircraft_callsign,
            'date_of_flight' => $date_of_flight3,
            'departure_aerodrome' => $departure_aerodrome3,
            'destination_aerodrome' => $destination_aerodrome3,
        ];

        $first_plan_details = FdtlAPIModel::get_previous_plan_data($data_array);
        $i = 0;


        foreach ($first_plan_details as $value) {
            $previous_reporting_time[$i]['reporting_time'] = $value['reporting_time'];
            $previous_flight_time[$i]['flight_time'] = $value['flight_time'];
            $previous_total_ft[$i]['total_ft'] = $value['total_ft'];
            $previous_duty_end_time[$i]['duty_end_time'] = $value['duty_end_time'];
            $previous_split_duty[$i]['split_duty'] = $value['split_duty'];
            $previous_dep_time_total_time[$i]['dep_time_total_time'] = $value['dep_time_total_time'];
            $i++;
        }

//        $reporting_time1 = $previous_reporting_time[0]['reporting_time'];
//        $reporting_time2 = $previous_reporting_time[1]['reporting_time'];
//        $flight_time2 = $previous_flight_time[1]['flight_time'];
//        $total_FT2 = $previous_total_ft[1]['total_ft'];
//        $duty_end_time2 = $previous_duty_end_time[1]['duty_end_time'];
//        $split_duty2 = $previous_split_duty[1]['split_duty'];
//        $dep_time_total_time1 = $previous_dep_time_total_time[0]['dep_time_total_time'];
//        $dep_time_total_time2 = $previous_dep_time_total_time[1]['dep_time_total_time'];
        
//                0-> second
//                1->first



        $reporting_time1 = $previous_reporting_time[1]['reporting_time'];
        $reporting_time2 = $previous_reporting_time[0]['reporting_time'];
        $flight_time2 = $previous_flight_time[0]['flight_time'];
        $total_FT2 = $previous_total_ft[0]['total_ft'];
        $duty_end_time2 = $previous_duty_end_time[0]['duty_end_time'];
        $split_duty2 = $previous_split_duty[0]['split_duty'];
        $dep_time_total_time1 = $previous_dep_time_total_time[1]['dep_time_total_time'];
        $dep_time_total_time2 = $previous_dep_time_total_time[0]['dep_time_total_time'];


        $previous_split_duty_values = $split_duty2;

        $reporting_time3 = date('Hi', strtotime($reporting_static_time, $departure_time_date_format3));
        $flight_time3 = date('Hi', strtotime($flight_static_time, $total_flying_time3));
        $chocks_off3 = date('Hi', strtotime($chocks_off_static_time, $departure_time_date_format3));
        $chocks_on3 = date('Hi', strtotime($chocks_on_static_time, strtotime($dep_time_total_time3)));
        $duty_end_time3 = date('Hi', strtotime($duty_end_static_time, strtotime($chocks_on3)));
        //Subtract $duty_end_time - $reporting_time3
        $secs3 = strtotime($reporting_time3) - strtotime("0000");
        $flight_duty_time3 = date('Hi', strtotime($duty_end_time3) - $secs3);


        //IST times
        $reporting_time_ist3 = "(" . date('Hi', strtotime('+5 hour +30 minutes', strtotime($reporting_time3))) . " IST)";
        $chocks_off_ist3 = "(" . date('Hi', strtotime('+5 hour +30 minutes', strtotime($chocks_off3))) . " IST)";
        $chocks_on_ist3 = "(" . date('Hi', strtotime('+5 hour +30 minutes', strtotime($chocks_on3))) . " IST)";
        $duty_end_time_ist3 = "(" . date('Hi', strtotime('+5 hour +30 minutes', strtotime($duty_end_time3))) . " IST)";

        //Display Hours and Minutes
        $flight_time_only_hours3 = substr($flight_time3, 0, 2);
        $flight_time_hours_format3 = ($flight_time_only_hours3 <= "01") ? " Hour " : " Hours ";
        $flight_time_only_Minutes3 = substr($flight_time3, 2, 2);
        $flight_time_minutes_format3 = ($flight_time_only_Minutes3 <= "01") ? " Minute " : " Minutes ";

        $flight_duty_time_only_hours3 = substr($flight_duty_time3, 0, 2);
        $flight_duty_time_hours_format3 = ($flight_duty_time_only_hours3 <= "01") ? " Hour " : " Hours ";
        $flight_duty_time_only_Minutes3 = substr($flight_duty_time3, 2, 2);
        $flight_duty_time_minutes_format3 = ($flight_duty_time_only_Minutes3 <= "01") ? " Minute " : " Minutes ";



        //split duty calculations
        $last_DET = strtotime($duty_end_time2) - strtotime("0000");
        $split_duty = date('Hi', strtotime($reporting_time3) - $last_DET);

        if (($split_duty >= "0300") && ($split_duty <= "1000")) {
            date_default_timezone_set('UTC');
            $split_duty = strtotime($split_duty) - strtotime("0000");
            $split_duty = $split_duty / 2;
            $split_duty_values = date('Hi', $split_duty);

            $split_duty_calculation_value = self::split_duty_calculations($split_duty_values);


            $split_duty_hours = substr($split_duty_calculation_value, 0, 2);
            $split_duty_hours_format = ($split_duty_hours <= "01") ? " Hour " : " Hours ";
            $split_duty_minutes = substr($split_duty_calculation_value, 2, 2);
            $split_duty_minutes_format = ($split_duty_minutes <= "01") ? " Minute " : " Minutes ";

            $split_duty_display_format = $split_duty_hours . '' . $split_duty_hours_format
                    . '' . $split_duty_minutes . '' . $split_duty_minutes_format;


            if (!preg_match('/\\d/', $previous_split_duty_values)) { // '/[^a-z\d]/i' should also work.
                //contains only characters
                //No split duty in previous landings
                $split_duty_condition_value = 0;
                $split_duty_display_format = $split_duty_display_format;
            } else {
                //contains both characters and numbers or only numbers
                //split duty present in previous landings
                $split_duty_condition_value = 1;
                $split_duty_display_format = $split_duty_display_format;
            }
        } else {
            $split_duty_condition_value = 2;
            $split_duty_display_format = "NOT APPLICABLE";
            $split_duty_calculation_value = "NOT APPLICABLE";
        }


        //return $flight_time. " ".$second_flight_time." ".$First_flight_time ;
        //Total FT (TFT) $First_flight_time + $flight_time;

        $previous_total_ft = strtotime($total_FT2) - strtotime("0000");
        $total_FT3 = date('Hi', strtotime($flight_time3) + $previous_total_ft);

        $total_FT_only_hours = substr($total_FT3, 0, 2);
        $total_FT_hours_format = ($total_FT_only_hours <= "01") ? " Hour " : " Hours ";
        $total_FT_only_Minutes = substr($total_FT3, 2, 2);
        $total_FT_minutes_format = ($total_FT_only_Minutes <= "01") ? " Minute " : " Minutes ";

        $total_FT_display = $total_FT_only_hours . '' . $total_FT_hours_format . '' . $total_FT_only_Minutes . '' .
                $total_FT_minutes_format;

        $day_night_timings = DayNightTimeModel::getAll();
        $night_time_from = ($day_night_timings) ? $day_night_timings->night_time_from : "";
        $night_time_to = ($day_night_timings) ? $day_night_timings->night_time_to : "";

        $total_ft_model = TotalFTModel::getAll($current_landing);
        $day = ($total_ft_model) ? $total_ft_model->day : "";
        $night = ($total_ft_model) ? $total_ft_model->night : "";

        if ((($dep_time_total_time1 >= $night_time_from) && ($dep_time_total_time1 <= $night_time_to)) ||
                (($dep_time_total_time2 >= $night_time_from) && ($dep_time_total_time2 <= $night_time_to))) {
            // Night timings

            if ($total_FT3 > $night) {
                $total_FT_condition_value = '1'; //EXCEED NIGHT
                $total_FT_display_format = $total_FT_display;
            } else {
                $total_FT_condition_value = '0';
                $total_FT_display_format = $total_FT_display;
            }
        } else {
            // Day Timings

            if ($total_FT3 > $day) {
                $total_FT_condition_value = '2'; //EXCEED DAY
                $total_FT_display_format = $total_FT_display;
            } else {
                $total_FT_condition_value = '0';
                $total_FT_display_format = $total_FT_display;
            }
        }

        //Total FDP calculations
        // latest DET $duty_end_time and first rt(first record rt) $First_RT_value
        $First_RT_value1 = strtotime($reporting_time1) - strtotime("0000");
        $total_fdp3 = date('Hi', strtotime($duty_end_time3) - $First_RT_value1);

        //IST format
        $total_fdp_ist3 = date('Hi', strtotime('+5 hour +30 minutes', strtotime($total_fdp3)));

        $total_fdp_only_hours3 = substr($total_fdp3, 0, 2);
        $total_fdp_hours_format3 = ($total_fdp_only_hours3 <= "01") ? " Hour " : " Hours ";
        $total_fdp_only_Minutes3 = substr($total_fdp3, 2, 2);
        $total_fdp_minutes_format3 = ($total_fdp_only_Minutes3 <= "01") ? " Minute " : " Minutes ";

        $total_fdp_display = $total_fdp_only_hours3 . '' . $total_fdp_hours_format3 . '' . $total_fdp_only_Minutes3 . '' .
                $total_fdp_minutes_format3;

        $total_fdp_model = TotalFDPModel::get_max_fdp_for_first_landing($current_landing);
        $fdp = ($total_fdp_model) ? $total_fdp_model->fdp : "";
        $max_12hours_for_min_rest_period = ($total_fdp_model) ? $total_fdp_model->max_12hours_for_min_rest_period : "";


        if ($total_fdp3 <= $fdp) {
            $total_fdp_condition_value = '0';
            $total_fdp_display_format = $total_fdp_display;
        } else {
            $total_fdp_condition_value = '1';
            $total_fdp_display_format = $total_fdp_display;
        }

        $first_char_entered_departure_time = substr($entered_departure_time3, 0, 2);
        $last_char_entered_departure_time = substr($entered_departure_time3, -2, 2);
        $first_char_dep_time_total_time = substr($dep_time_total_time3, 0, 2);
        $last_char_dep_time_total_time = substr($dep_time_total_time3, -2, 2);



        if ((($entered_departure_time3 >= "2030") && ($entered_departure_time3 <= "2359")) ||
                (($first_char_entered_departure_time == 00) && ($last_char_entered_departure_time >= "01") && ($last_char_entered_departure_time <= "30"))
        ) {
            //Last Arrival Time
            //then Refer FDP Table =  MAX FDP - DP // $fdp -  $flight_duty_time
            //1st plan RT + Refer FDP Table -20min'

            $flight_duty_time_convert = strtotime($flight_duty_time3) - strtotime("0000");
            $maximum_fdp = date('Hi', strtotime($fdp) - $flight_duty_time_convert);

            $fdp_sec = strtotime($maximum_fdp) - strtotime("0000");
            $last_arrival_time = date('Hi', strtotime($reporting_time1) + $fdp_sec);
            $minus_20 = strtotime("0020") - strtotime("0000");
            $last_arrival_time_colon_format = date('H:i', strtotime($last_arrival_time) - $minus_20);

            $last_arrival_time = date('Hi', strtotime($last_arrival_time) - $minus_20);


            if (strpos($split_duty_display_format, "NOT APPLICABLE") !== false) {
                $last_arrival_time_value3 = $last_arrival_time;
                $last_arrival_time = $last_arrival_time_colon_format . " (WITHOUT SPLIT DUTY)";
            } else {
                $split_duty_value_strtotime = strtotime($split_duty_calculation_value) - strtotime("0000");
                $last_arrival_time_value3 = date('Hi', strtotime($last_arrival_time) + $split_duty_value_strtotime);
                $last_arrival_time = date('H:i', strtotime($last_arrival_time) + $split_duty_value_strtotime) . " (WITH SPLIT DUTY)";
            }
        } else if ((($dep_time_total_time3 >= "2030") && ($dep_time_total_time3 <= "2359")) ||
                (($first_char_dep_time_total_time == 00) && ($last_char_dep_time_total_time >= "01") && ($last_char_dep_time_total_time <= "30"))
        ) {
            //Last Arrival Time
            //then Refer FDP Table = MAX FDP - (DP/2) 
            // $fdp -  ($flight_duty_time/2)
            //1st plan RT + Refer FDP Table -20min'


            date_default_timezone_set('UTC');
            $flight_duty_time_format = strtotime($flight_duty_time3) - strtotime("0000");
            $flight_duty_time_format = $flight_duty_time_format / 2;
            $flight_duty_time = date('Hi', $flight_duty_time_format);
            $flight_duty_time_convert = strtotime($flight_duty_time) - strtotime("0000");
            $maximum_fdp = date('Hi', strtotime($fdp) - $flight_duty_time_convert);

            $fdp_sec = strtotime($maximum_fdp) - strtotime("0000");
            $last_arrival_time = date('Hi', strtotime($reporting_time1) + $fdp_sec);
            $minus_20 = strtotime("0020") - strtotime("0000");
            $last_arrival_time_colon_format = date('H:i', strtotime($last_arrival_time) - $minus_20);

            $last_arrival_time = date('Hi', strtotime($last_arrival_time) - $minus_20);

            if (strpos($split_duty_display_format, "NOT APPLICABLE") !== false) {
                $last_arrival_time_value3 = $last_arrival_time;
                $last_arrival_time = $last_arrival_time_colon_format . " (WITHOUT SPLIT DUTY)";
            } else {
                $split_duty_value_strtotime = strtotime($split_duty_calculation_value) - strtotime("0000");
                $last_arrival_time_value3 = date('Hi', strtotime($last_arrival_time) + $split_duty_value_strtotime);
                $last_arrival_time = date('H:i', strtotime($last_arrival_time) + $split_duty_value_strtotime) . " (WITH SPLIT DUTY)";
            }
        } else {

            //Last Arrival Time
            //1st plan RT + Refer FDP Table -20min'
            $fdp_sec = strtotime($fdp) - strtotime("0000");
            $last_arrival_time = date('Hi', strtotime($reporting_time1) + $fdp_sec);
            $minus_20 = strtotime("0020") - strtotime("0000");
            $last_arrival_time_colon_format = date('H:i', strtotime($last_arrival_time) - $minus_20);

            $last_arrival_time = date('Hi', strtotime($last_arrival_time) - $minus_20);

            if (strpos($split_duty_display_format, "NOT APPLICABLE") !== false) {
                $last_arrival_time_value3 = $last_arrival_time;
                $last_arrival_time = $last_arrival_time_colon_format . " (WITHOUT SPLIT DUTY)";
            } else {
                $split_duty_value_strtotime = strtotime($split_duty_calculation_value) - strtotime("0000");
                $last_arrival_time_value3 = date('Hi', strtotime($last_arrival_time) + $split_duty_value_strtotime);
                $last_arrival_time = date('H:i', strtotime($last_arrival_time) + $split_duty_value_strtotime) . " (WITH SPLIT DUTY)";
            }
        }


        //Last Dep Time = last arrival time - total flying time

        $total_fly_time = strtotime($combined_total_time3) - strtotime("0000");
        $last_dep_time = date('Hi', strtotime($last_arrival_time) - $total_fly_time);
        $last_dep_time_value3 = $last_dep_time;
        $last_dep_time_ist = "(" . date('Hi', strtotime('+5 hour +30 minutes', strtotime($last_dep_time))) . " IST)";


        if ($split_duty_display_format == "NOT APPLICABLE") {
            $last_dep_time = date('H:i', strtotime($last_arrival_time) - $total_fly_time) . " (WITHOUT SPLIT DUTY)";
        } else {
            $last_dep_time = date('H:i', strtotime($last_arrival_time) - $total_fly_time) . " (WITH SPLIT DUTY)";
        }



        //Next Day Earliest Dep Time
        $first_landing = FirstLandingModel::getAll();
        $fourteen_thirty = ($first_landing) ? $first_landing->fourteen_thirty : "";
        $two_thirty = ($first_landing) ? $first_landing->two_thirty : "";
        $twelve_hours = ($first_landing) ? $first_landing->twelve_hours : "";
        if ($total_fdp3 < $twelve_hours) {
            $fourteen_thirty = strtotime($fourteen_thirty) - strtotime("0000");
            $next_day_earliest_dep_time = date('H:i', strtotime($duty_end_time3) + $fourteen_thirty);
            $next_day_earliest_dep_time_value3 = date('Hi', strtotime($duty_end_time3) + $fourteen_thirty);
            $next_day_earliest_dep_time_ist = "(" . date('Hi', strtotime('+5 hour +30 minutes', strtotime($next_day_earliest_dep_time))) . " IST)";
        } else {
            $two_thirty = strtotime($two_thirty) - strtotime("0000");
            $total_fdp = strtotime($total_fdp3) - strtotime("0000");
            $next_day_earliest_dep_time = date('H:i', strtotime($duty_end_time3) + $two_thirty + $total_fdp);
            $next_day_earliest_dep_time_value3 = date('Hi', strtotime($duty_end_time3) + $two_thirty + $total_fdp);
            $next_day_earliest_dep_time_ist = "(" . date('Hi', strtotime('+5 hour +30 minutes', strtotime($next_day_earliest_dep_time))) . " IST)";
        }



        $result = [
            "dep_time_total_time3" => $dep_time_total_time3,
            "reporting_time3" => $reporting_time3 . " GMT " . $reporting_time_ist3,
            "chocks_off3" => $chocks_off3 . " GMT " . $chocks_off_ist3,
            "chocks_on3" => $chocks_on3 . " GMT " . $chocks_on_ist3,
            "duty_end_time3" => $duty_end_time3 . " GMT " . $duty_end_time_ist3,
            "flight_time3" => $flight_time_only_hours3 . '' . $flight_time_hours_format3 . '' . $flight_time_only_Minutes3
            . '' . $flight_time_minutes_format3,
            "flight_duty_period3" => $flight_duty_time_only_hours3 . "" . $flight_duty_time_hours_format3
            . "" . $flight_duty_time_only_Minutes3 . "" . $flight_duty_time_minutes_format3,
            "split_duty3" => $split_duty_display_format,
            'split_duty3_condition_value' => $split_duty_condition_value,
            "total_FT3" => $total_FT_display_format,
            'total_FT_condition_value' => $total_FT_condition_value,
            "total_fdp3" => $total_fdp_display_format,
            'total_fdp_condition_value' => $total_fdp_condition_value,
            "last_dep_time3" => $last_dep_time,
            "last_arrival_time3" => $last_arrival_time,
            "next_day_take_off3" => $next_day_earliest_dep_time . " GMT " . $next_day_earliest_dep_time_ist,
            'reporting_time3_value' => $reporting_time3,
            'flight_time3_value' => $flight_time3,
            'chocks_off3_value' => $chocks_off3,
            'chocks_on3_value' => $chocks_on3,
            'duty_end_time3_value' => $duty_end_time3,
            'flight_duty_period3_value' => $flight_duty_time3,
            'split_duty3_value' => $split_duty_calculation_value,
            'total_FT3_value' => $total_FT3,
            'total_fdp3_value' => $total_fdp3,
            'last_dep_time3_value' => $last_dep_time_value3,
            'last_arrival_time3_value' => $last_arrival_time_value3,
            'next_day_take_off3_value' => $next_day_earliest_dep_time_value3,
        ];
        return $result;
    }

    public static function split_duty_calculations($split_duty_value) {

        $split_duty_min_1st_digit = substr($split_duty_value, 0, 1);
        $split_duty_min_2nd_digit = substr($split_duty_value, 1, 1);
        $split_duty_min_3rd_digit = substr($split_duty_value, 2, 1);
        $split_duty_min_4th_digit = substr($split_duty_value, 3, 1);

        $digits1 = ['0', '1', '2']; // take 0
        $digits2 = ['3', '4', '5', '6', '7']; //take 5
        $digits3 = ['8', '9']; //increment 2nd digit

        if (in_array($split_duty_min_4th_digit, $digits1)) {
            $split_duty_display = $split_duty_min_1st_digit . '' . $split_duty_min_2nd_digit . '' . $split_duty_min_3rd_digit . '0';
        } else if (in_array($split_duty_min_4th_digit, $digits2)) {
            $split_duty_display = $split_duty_min_1st_digit . '' . $split_duty_min_2nd_digit . '' . $split_duty_min_3rd_digit . '5';
        } else {
            //2238
            //2240
            $third_digit = $split_duty_min_3rd_digit + 1;
            $split_duty_mins = $third_digit . '0';

            //2260
            if ($split_duty_mins == '60') {
                $second_digit = $split_duty_min_2nd_digit + 1;
                $split_duty_display = $split_duty_min_1st_digit . '' . $second_digit . '00';
            } else {
                $split_duty_display = $split_duty_min_1st_digit . '' . $split_duty_min_2nd_digit . '' . $split_duty_mins;
            }
        }

        return $split_duty_display;
    }

}
