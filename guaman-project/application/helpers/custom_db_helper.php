<?php
/**
 * Created by PhpStorm.
 * User: Fazekas RoboTeam
 * Date: 3/17/2019
 * Time: 9:44 PM
 */

function get_month($date)
{

    return substr($date, -5, 2);
}

function datetostr($date)
{
    switch ($date) {
        case "01":
            $str = "january";
            break;
        case "02":
            $str = "february";
            break;
        case "03":
            $str = "march";
            break;
        case "04":
            $str = "april";
            break;
        case "05":
            $str = "may";
            break;
        case "06":
            $str = "june";
            break;
        case "07":
            $str = "july";
            break;
        case "08":
            $str = "august";
            break;
        case "09":
            $str = "september";
            break;
        case "10":
            $str = "october";
            break;
        case "11":
            $str = "november";
            break;
        case "12":
            $str = "december";
            break;

    }
    return $str;
}

function custom_db_actions($table_name, $result_array, $column_names)
{
    $result_array_ = $result_array;
    foreach ($result_array_ as $key => $row) {

        if (isset($row['kiker_netto'])) {
            $result_array_[$key]['kiker_netto'] = number_format((float)$result_array_[$key]['kiker_netto'], 2, ".", " ");
        }
        if (isset($row['beker_netto'])) {
            $result_array_[$key]['beker_netto'] = number_format((float)$result_array_[$key]['beker_netto'], 2, ".", " ");
        }
        if (isset($row['eladasi_ar'])) {
            $result_array_[$key]['eladasi_ar'] = number_format((float)$result_array_[$key]['eladasi_ar'], 2, ".", " ");
        }
        if (isset($row['bekerulo_ar'])) {
            $result_array_[$key]['bekerulo_ar'] = number_format((float)$result_array_[$key]['bekerulo_ar'], 2, ".", " ");
        }
        if (isset($row['beszerzesi_ar'])) {
            $result_array_[$key]['beszerzesi_ar'] = number_format((float)$result_array_[$key]['beszerzesi_ar'], 2, ".", " ");
        }
        if (isset($row['tervezett_eladasi_ar'])) {
            $result_array_[$key]['tervezett_eladasi_ar'] = number_format((float)$result_array_[$key]['tervezett_eladasi_ar'], 2, ".", " ");
        }
        if (isset($row['eladasi_ar'])) {
            $result_array_[$key]['eladasi_ar'] = number_format((float)$result_array_[$key]['eladasi_ar'], 2, ".", " ");
        }
        if (isset($row['beszer_ar'])) {
            $result_array_[$key]['beszer_ar'] = number_format((float)$result_array_[$key]['beszer_ar'], 2, ".", " ");
        }
        if (isset($row['netto_eladasi_ar'])) {
            $result_array_[$key]['netto_eladasi_ar'] = number_format((float)$result_array_[$key]['netto_eladasi_ar'], 2, ".", " ");
        }
        if (isset($row['brutto_eladasi_ar'])) {
            $result_array_[$key]['brutto_eladasi_ar'] = number_format((float)$result_array_[$key]['brutto_eladasi_ar'], 2, ".", " ");
        }
        if (isset($row['eladasi_ar'])) {
            $result_array_[$key]['eladasi_ar'] = number_format((float)$result_array_[$key]['eladasi_ar'], 2, ".", " ");
        }
        if (isset($row['indulo_ar'])) {
            $result_array_[$key]['indulo_ar'] = number_format((float)$result_array_[$key]['indulo_ar'], 2, ".", " ");
        }
        if (isset($row['vegso_ar'])) {
            $result_array_[$key]['vegso_ar'] = number_format((float)$result_array_[$key]['vegso_ar'], 2, ".", " ");
        }
        if (isset($row['kozepar'])) {
            $result_array_[$key]['kozepar'] = number_format((float)$result_array_[$key]['kozepar'], 2, ".", " ");
        }
        if (isset($row['celar'])) {
            $result_array_[$key]['celar'] = number_format((float)$result_array_[$key]['celar'], 2, ".", " ");
        }
        if (isset($row['mennyi_max'])) {
            $result_array_[$key]['mennyi_max'] = number_format((float)$result_array_[$key]['mennyi_max'], 2, ".", " ");
        }
        if (isset($row['netto_beszer_ar'])) {
            $result_array_[$key]['netto_beszer_ar'] = number_format((float)$result_array_[$key]['netto_beszer_ar'], 2, ".", " ");
        }
        if (isset($row['alkatresz_koltseg'])) {
            $result_array_[$key]['alkatresz_koltseg'] = number_format((float)$result_array_[$key]['alkatresz_koltseg'], 2, ".", " ");
        }
        if (isset($row['profit'])) {
            $result_array_[$key]['profit'] = number_format((float)$result_array_[$key]['profit'], 2, ".", " ");
        }

        switch ($table_name) {

            case "guaman_keresesilista":
                if (is_numeric((float)$result_array_[$key]['indulo_ar']) && is_numeric((float)$result_array_[$key]['vegso_ar'])) {
                    $result_array_[$key]['kozepar'] = number_format(((float)$result_array_[$key]['indulo_ar'] + (float)$result_array_[$key]['vegso_ar']) / 2, 2, ".", " ");
                    $result_array_[$key]['celar'] = number_format((float)$result_array_[$key]['kozepar'] * 0.8, 2, ".", " ");
                }
                break;
            /*case "guaman_keszlet":
                if (is_numeric((float)$result_array_[$key]['eladasi_ar']) && is_numeric((float)$result_array_[$key]['beszerzesi_ar'])) {
                    $result_array_[$key]['afa'] = number_format(round(((float)$result_array_[$key]['eladasi_ar'] - (float)$result_array_[$key]['beszerzesi_ar']) / 1.27, 2), 2, ".", " ");
                    $result_array_[$key]['netto_profit'] = number_format(round(((float)$result_array_[$key]['eladasi_ar'] -
                            (float)$result_array_[$key]['beszerzesi_ar']) - (((float)$result_array_[$key]['eladasi_ar'] - (float)$result_array_[$key]['beszerzesi_ar']) / 1.27), 2), 2,".", " ");
                    if ((float)$result_array_[$key]['eladasi_ar'] != 0) {
                        $result_array_[$key]['%'] = (round($result_array_[$key]['netto_profit'] / (float)$result_array_[$key]['eladasi_ar'], 4))*100 . " %";
                    }
                };
                break;*/
            case "guaman_telefon":
                if (is_numeric((float)$result_array_[$key]['kiker_netto']) && is_numeric((float)$result_array_[$key]['beker_netto'])) {
                    $result_array_[$key]['netto_profit'] = number_format((float)$result_array_[$key]['kiker_netto'] - (float)$result_array_[$key]['beker_netto'], 2, ".", " ");
                    if ((float)$result_array_[$key]['kiker_netto'] != 0) {
                        $result_array_[$key]['netto_%'] = (round((float)$result_array_[$key]['netto_profit'] / (float)$result_array_[$key]['kiker_netto'], 4)) * 100 . " %";
                    }


                }

                break;
            case "guaman_gadget":
                if (is_numeric((float)$result_array_[$key]['kiker_netto']) && is_numeric((float)$result_array_[$key]['beker_netto'])) {
                    $result_array_[$key]['netto_profit'] = number_format((float)$result_array_[$key]['kiker_netto'] - (float)$result_array_[$key]['beker_netto'], 2, ".", " ");
                    if ((float)$result_array_[$key]['kiker_netto'] != 0) {
                        $result_array_[$key]['netto_%'] = (round((float)$result_array_[$key]['netto_profit'] / (float)$result_array_[$key]['kiker_netto'], 4)) * 100 . " %";
                    }
                }
                break;
            case "guaman_orakkiegeszitok":
                    if (is_numeric((float)$result_array_[$key]['kiker_netto']) && is_numeric((float)$result_array_[$key]['beker_netto'])) {

                        $result_array_[$key]['netto_profit'] = number_format((float)$result_array_[$key]['kiker_netto'] - (float)$result_array_[$key]['beker_netto'], 2, ".", " ");
                        if ((float)$result_array_[$key]['kiker_netto'] != 0) {
                            $result_array_[$key]['netto_%'] = (round((float)$result_array_[$key]['netto_profit'] / (float)$result_array_[$key]['kiker_netto'], 4)) * 100 . " %";
                        }
                    }
                break;
            case "guaman_tablet":
                    if (is_numeric((float)$result_array_[$key]['kiker_netto']) && is_numeric((float)$result_array_[$key]['beker_netto'])) {

                        $result_array_[$key]['netto_profit'] = number_format((float)$result_array_[$key]['kiker_netto'] - (float)$result_array_[$key]['beker_netto'], 2, ".", " ");
                        if ((float)$result_array_[$key]['kiker_netto'] != 0) {
                            $result_array_[$key]['netto_%'] = (round((float)$result_array_[$key]['netto_profit'] / (float)$result_array_[$key]['kiker_netto'], 4)) * 100 . " %";
                        }
                    }
                break;
            case "guaman_keszlet":
                    if (is_numeric((float)$result_array_[$key]['eladasi_ar']) && is_numeric((float)$result_array_[$key]['beszerzesi_ar'])) {

                        $result_array_[$key]['netto_profit'] = number_format(round(((float)$result_array_[$key]['eladasi_ar'] - (float)$result_array_[$key]['beszerzesi_ar']) / 1.27, 2), 2, ".", " ");
                        $result_array_[$key]['afa'] = number_format(round(((float)$result_array_[$key]['eladasi_ar'] - (float)$result_array_[$key]['beszerzesi_ar']) - (((float)$result_array_[$key]['eladasi_ar'] - (float)$result_array_[$key]['beszerzesi_ar']) / 1.27), 2), 2, ".", " ");
                        if ((float)$result_array_[$key]['eladasi_ar'] != 0) {
                            $result_array_[$key]['%'] = (round($result_array_[$key]['netto_profit'] / (float)$result_array_[$key]['eladasi_ar'], 4)) * 100 . " %";
                        };
                    }
                break;

            case "guaman_hasznaltsales":
                    if (is_numeric((float)$result_array_[$key]['beszerzesi_ar']) && is_numeric((float)$result_array_[$key]['brutto_eladasi_ar'])) {

                        $result_array_[$key]['netto_profit'] = number_format(round(((float)$result_array_[$key]['brutto_eladasi_ar'] - (float)$result_array_[$key]['beszerzesi_ar']) * 0.2126, 2), 2, ".", " ");
                        $result_array_[$key]['afa'] = number_format(round(((float)$result_array_[$key]['brutto_eladasi_ar'] - (float)$result_array_[$key]['beszerzesi_ar']) - (((float)$result_array_[$key]['afa'])), 2), 2, ".", " ");
                        $result_array_[$key]['netto_eladasi_ar'] = number_format(round(((float)$result_array_[$key]['brutto_eladasi_ar'] - (float)$result_array_[$key]['afa']), 2), 2, ".", " ");
                        if ((float)$result_array_[$key]['netto_eladasi_ar'] != 0) {
                            $result_array_[$key]['netto_%'] = (round($result_array_[$key]['netto_profit'] / (float)$result_array_[$key]['netto_eladasi_ar'], 4)) * 100 . " %";
                        };

                        $date1 = $result_array_[$key]['beszer_datum'];
                        $date2 = $result_array_[$key]['eladas_datum'];

                        $diff = abs(strtotime($date2) - strtotime($date1));
                        $result_array_[$key]['forgasi_nap'] = floor($diff / (60 * 60 * 24)) . " " . lang("day");
                    }
                break;
            case "guaman_partnersales":
                    if (is_numeric((float)$result_array_[$key]['beszerzesi_ar']) && is_numeric((float)$result_array_[$key]['brutto_eladasi_ar'])) {

                        $result_array_[$key]['netto_profit'] = number_format(round(((float)$result_array_[$key]['brutto_eladasi_ar'] - (float)$result_array_[$key]['beszerzesi_ar']) * 0.2126, 2), 2, ".", " ");
                        $result_array_[$key]['afa'] = number_format(round(((float)$result_array_[$key]['brutto_eladasi_ar']
                                - (float)$result_array_[$key]['beszerzesi_ar']) - (((float)$result_array_[$key]['afa'])), 2), 2, ".", " ");
                        $result_array_[$key]['netto_eladasi_ar'] = number_format(round(((float)$result_array_[$key]['brutto_eladasi_ar'] - (float)$result_array_[$key]['afa']), 2), 2, ".", " ");
                        if ((float)$result_array_[$key]['netto_eladasi_ar'] != 0) {
                            $result_array_[$key]['netto_%'] = (round($result_array_[$key]['netto_profit'] / (float)$result_array_[$key]['netto_eladasi_ar'], 4)) * 100 . " %";
                        };

                        $date1 = $result_array_[$key]['beszer_datum'];
                        $date2 = $result_array_[$key]['eladas_datum'];

                        $diff = abs(strtotime($date2) - strtotime($date1));
                        $result_array_[$key]['forgasi_nap'] = floor($diff / (60 * 60 * 24)) . " " . lang("day");
                    }
                break;
            case "guaman_szervizsales":
                    if (is_numeric((float)$result_array_[$key]['jav_ara']) && is_numeric((float)$result_array_[$key]['alkatresz_koltseg'])) {

                        $result_array_[$key]['profit'] = number_format(round(((float)$result_array_[$key]['jav_ara'] - (float)$result_array_[$key]['alkatresz_koltseg']), 2), 2, ".", " ");

                    }
                break;
            case "guaman_tartozeksales":
                    if (is_numeric((float)$result_array_[$key]['netto_beszerzesi_ar']) && is_numeric((float)$result_array_[$key]['brutto_eladasi_ar'])) {

                        $result_array_[$key]['netto_profit'] = number_format(round(((float)$result_array_[$key]['brutto_eladasi_ar'] -
                                (float)$result_array_[$key]['netto_beszerzesi_ar']) * 0.2126, 2), 2, ".", " ");
                        $result_array_[$key]['afa'] = number_format(round(((float)$result_array_[$key]['brutto_eladasi_ar'] -
                                (float)$result_array_[$key]['netto_beszerzesi_ar']) - (((float)$result_array_[$key]['afa'])), 2), 2, ".", " ");
                        $result_array_[$key]['netto_eladasi_ar'] = number_format(round(((float)$result_array_[$key]['brutto_eladasi_ar'] - (float)$result_array_[$key]['afa']), 2), 2, ".", " ");
                        if ((float)$result_array_[$key]['netto_eladasi_ar'] != 0) {
                            $result_array_[$key]['netto_%'] = (round($result_array_[$key]['netto_profit'] / (float)$result_array_[$key]['netto_eladasi_ar'], 4)) * 100 . " %";
                        };
                    }
                break;
            case "guaman_szerviznaplo":

                    $date1 = $result_array_[$key]['szerviz_kezdet_datum'];
                    $date2 = $result_array_[$key]['szerviz_vege_datum'];

                    $diff = abs(strtotime($date2) - strtotime($date1));
                    $result_array_[$key]['jav_ido'] = floor($diff / (60 * 60 * 24)) . " " . lang("day");

                break;
            case "guaman_disztribuciosreport":
                $CI =& get_instance();

                $current_month = $row["honap"]; // 01, 02, 03...
                $szemelyesAtvetelCount = 0;
                $futarCount = 0;

                $dh = $CI->Database_model->get_table("kiszallitas_datum, szallitasi_megjegyzes", "guaman_disztribucioshasznalt", "id", "ASC");
                foreach ($dh as $dh_row) {
                    if (get_month($dh_row["kiszallitas_datum"]) == $current_month && $dh_row["szallitasi_megjegyzes"] == "Személyes átvétel") {
                        $szemelyesAtvetelCount++;
                    } else if (get_month($dh_row["kiszallitas_datum"]) == $current_month && $dh_row["szallitasi_megjegyzes"] == "Posta") {
                        $futarCount++;
                    }
                }

                $dp = $CI->Database_model->get_table("kiszallitas_datum, szallitasi_megjegyzes", "guaman_disztribuciospartnerkeszulekek", "id", "ASC");
                foreach ($dp as $dp_row) {
                    if (get_month($dp_row["kiszallitas_datum"]) == $current_month && $dp_row["szallitasi_megjegyzes"] == "Személyes átvétel") {
                        $szemelyesAtvetelCount++;
                    } else if (get_month($dp_row["kiszallitas_datum"]) == $current_month && $dp_row["szallitasi_megjegyzes"] == "Posta") {
                        $futarCount++;
                    }
                }

                $result_array_[$key]["szemelyes_atvetel"] = $szemelyesAtvetelCount;
                $result_array_[$key]["futar"] = $futarCount;
                break;

            case "guaman_forgalom":
                $result_array_ = array();

                $CI =& get_instance();

                $hasznalt_sales = $CI->Database_model->get_table("*", "guaman_hasznaltsales", "id", "ASC");
                $partner_sales = $CI->Database_model->get_table("*", "guaman_partnersales", "id", "ASC");

                foreach ($hasznalt_sales as $hasznalt_sale) {
                    $result_array_[] = $hasznalt_sale;
                }

                foreach ($partner_sales as $partner_sale) {
                    $result_array_[] = $partner_sale;
                }
                break;

        }

    }


    return $result_array_;

}


