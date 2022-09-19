<?php

namespace Helte\DevTools\Helpers;

use Carbon\Carbon;

class HolidayHelper {
    private const HOLIDAYS = [
        [1, 1],   // Ano Novo
        [28, 2],  // Carnaval
        [1, 3],   // Carnaval
        [2, 3],   // Quarta-Feira de Cinzas
        [15, 4],  // Paixão de Cristo
        [21, 4],  // Tiradentes
        [1, 5],   // Dia Mundial do Trabalho
        [16, 6],  // Corpus Christi
        [7, 9],   // Independência do Brasil
        [12, 10], // Nossa Senhora Aparecida
        [2, 11],  // Finados
        [15, 11], // Proclamação da República
        [25, 12], // Natal
        [30, 12], // Último dia útil do ano
    ];

    /**
     * Pula N dias úteis.
     * 
     * @param  Carbon  $date
     * @param  int  $expire_days
     * @param  Array<array>  $holidays
     * @return Carbon
     */
    public static function addValidDays(Carbon $date, int $expire_days = 3, array $holidays = null) {
        $holidays = $holidays ?? static::HOLIDAYS;
        $holiday_map = static::buildHolidayMap($holidays);
        $date = $date->copy();

        $date = static::skipBusinessDays($date, $expire_days, $holiday_map);
        
        return $date;
    }
    
    /**
     * Pula N horas úteis.
     * 
     * @param  Carbon  $date
     * @param  int  $expire_hours
     * @param  Array<array>  $holidays
     * @return Carbon
     */
    public static function addValidHours(Carbon $date, int $expire_hours = 3, array $holidays = null) {
        $holidays = $holidays ?? static::HOLIDAYS;
        $holiday_map = static::buildHolidayMap($holidays);
        $date = $date->copy();

        $hours_per_day = 24;
        $expire_days = (int) ($expire_hours / $hours_per_day);
        $expire_hours = $expire_hours % $hours_per_day;
        
        $date = static::skipBusinessDays($date, $expire_days, $holiday_map);
        $date->addHours($expire_hours);
        $date = static::skipWhileIsHoliday($date, $holiday_map);

        return $date;
    }

    /**
     * Aplica lógica para pular dias úteis.
     * 
     * @param  Carbon  $date
     * @param  int  $expire_days
     * @param  Array<string,bool>  $holiday_map
     * @return Carbon
     */
    private static function skipBusinessDays(Carbon $date, int $expire_days, array $holiday_map) {
        while ($expire_days > 0) {
            $date->addDay();
            $is_business_day = static::checkBusinessDay($date, $holiday_map);
            
            if ($is_business_day) {
                $expire_days -= 1;
            }
        }

        return $date;
    }

    /**
     * Pula 0 ou mais dias de uma data até que ela se torne um dia útil.
     * 
     * @param  Carbon  $date
     * @param  Array<string,bool>  $holiday_map
     * @return Carbon
     */
    private static function skipWhileIsHoliday(Carbon $date, array $holiday_map) {
        while (static::checkHoliday($date, $holiday_map)) {
            $date->addDay();
        }

        return $date;
    }

    /**
     * Faz um mapa com cada feriado recebido sendo uma string 'MM-DD'.
     * 
     * @param  Array<array>  $holidays
     * @return Array<string,bool>
     */
    private static function buildHolidayMap(array $holidays) {
        return collect($holidays)->mapWithKeys(function (array $holiday) {
            $day = zero_pad($holiday[0], 2);
            $month = zero_pad($holiday[1], 2);

            return ["$month-$day" => true];
        })
        ->toArray();
    }

    /**
     * Verifica se uma data é dia útil.
     * 
     * @param  Carbon  $date
     * @param  Array<string,bool>  $holiday_map
     * @return bool
     */
    private static function checkBusinessDay(Carbon $date, array $holiday_map) {
        if ($date->isWeekend()) {
            return false;
        }

        $month_day = $date->format('m-d');
        
        if (isset($holiday_map[$month_day])) {
            return false;
        }

        return true;
    }

    /**
     * Verifica se uma data é feriado ou final de semana.
     * 
     * @param  Carbon  $date
     * @param  Array<string,bool>  $holiday_map
     * @return bool
     */
    private static function checkHoliday(Carbon $date, array $holiday_map) {
        return !static::checkBusinessDay($date, $holiday_map);
    }
}
