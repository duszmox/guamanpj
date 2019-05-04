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

function custom_db_actions($table_name, $result_array, $column_names, $columns)
{

    $result_array_ = $result_array;
    foreach ($result_array_ as $key => $row) {


        switch ($table_name) {

            case "guaman_keresesilista":

                if (is_numeric($result_array_[$key]['indulo_ar']) AND is_numeric($result_array_[$key]['vegso_ar'])) {
                    $result_array_[$key]["kozepar"] = ($result_array_[$key]["indulo_ar"] + $result_array_[$key]["vegso_ar"]) / 2;
                    $result_array_[$key]["celar"] = $result_array_[$key]["indulo_ar"] * 0.8;
                }

                break;
            case "guaman_telefon":
            case "guaman_tablet":
            case "guaman_orakkiegeszitok":
            case "guaman_gadget":
                if (is_numeric($result_array_[$key]['beker_netto']) AND is_numeric($result_array_[$key]['kiker_netto'])) {
                    $result_array_[$key]["netto_profit"] = $result_array_[$key]["kiker_netto"] - $result_array_[$key]["beker_netto"];
                    if ($result_array_[$key]['kiker_netto'] != 0) {
                        $result_array_[$key]["netto_%"] = round(($result_array_[$key]["netto_profit"] / $result_array_[$key]["kiker_netto"]), 4) * 100 . ' %';
                    }
                }
                break;

            case "guaman_hasznaltsales":
            case "guaman_partnersales" :
            case "guaman_tartozeksales" :
                if (is_numeric($result_array_[$key]['brutto_eladasi_ar']) && is_numeric($result_array_[$key]['beszerzesi_ar'])) {
                    $result_array_[$key]['netto_profit'] = round((($result_array_[$key]['brutto_eladasi_ar'] - $result_array_[$key]['beszerzesi_ar']) * 0.2126), 2);
                    $result_array_[$key]['afa'] = ($result_array_[$key]['brutto_eladasi_ar'] - $result_array_[$key]['beszerzesi_ar']) - $result_array_[$key]['netto_profit'];
                    $result_array_[$key]['netto_eladasi_ar'] = round(($result_array_[$key]['brutto_eladasi_ar'] - $result_array_[$key]['afa']), 2);
                    if ($result_array_[$key]['netto_eladasi_ar'] != 0) {
                        $result_array_[$key]["netto_%"] = round(($result_array_[$key]["netto_profit"] / $result_array_[$key]["netto_eladasi_ar"]), 4) * 100 . ' %';
                    }
                    $date1 = $result_array_[$key]['beszer_datum'];
                    $date2 = $result_array_[$key]['eladas_datum'];
                    $diff = abs(strtotime($date2) - strtotime($date1));
                    $result_array_[$key]['forgasi_nap'] = floor($diff / (60 * 60 * 24)) . " " . lang("day");
                }
                break;

            case "guaman_szerviznaplo":
                $date1 = $result_array_[$key]['szerviz_kezdet_datum'];
                $date2 = $result_array_[$key]['szerviz_vege_datum'];
                $diff = abs(strtotime($date2) - strtotime($date1));
                $result_array_[$key]['forgasi_nap'] = floor($diff / (60 * 60 * 24)) . " " . lang("day");
                break;

            case "guaman_keszlet":
                if (is_numeric($result_array_[$key]['eladasi_ar']) || is_numeric($result_array_[$key]['beszerzesi_ar'])) {
                    $result_array_[$key]['netto_profit'] = round((($result_array_[$key]['eladasi_ar'] - $result_array_[$key]['beszerzesi_ar']) * 0.2126), 2);
                    $result_array_[$key]['afa'] = ($result_array_[$key]['eladasi_ar'] - $result_array_[$key]['beszerzesi_ar']) - $result_array_[$key]['netto_profit'];
                    if ($result_array_[$key]['eladasi_ar'] != 0) {
                        $result_array_[$key]["%"] = round(($result_array_[$key]["netto_profit"] / $result_array_[$key]["eladasi_ar"]), 4) * 100 . ' %';
                    }
                }
                break;


            case "guaman_disztribuciosreport":
                // TODO befejezni
                $ci =& get_instance();

                $current_month = $row["honap"]; // 01, 02, 03...
                $szemelyesatvetelcount = 0;
                $futarcount = 0;

                $dh = $ci->Database_model->get_table("kiszallitas_datum, szallitasi_megjegyzes", "guaman_disztribucioshasznalt", "id", "asc");
                foreach ($dh as $dh_row) {
                    if (get_month($dh_row["kiszallitas_datum"]) == $current_month && $dh_row["szallitasi_megjegyzes"] == "személyes átvétel") {
                        $szemelyesatvetelcount++;
                    } else if (get_month($dh_row["kiszallitas_datum"]) == $current_month && $dh_row["szallitasi_megjegyzes"] == "posta") {
                        $futarcount++;
                    }
                }

                $dp = $ci->Database_model->get_table("kiszallitas_datum, szallitasi_megjegyzes", "guaman_disztribuciospartnerkeszulekek", "id", "asc");
                foreach ($dp as $dp_row) {
                    if (get_month($dp_row["kiszallitas_datum"]) == $current_month && $dp_row["szallitasi_megjegyzes"] == "személyes átvétel") {
                        $szemelyesatvetelcount++;
                    } else if (get_month($dp_row["kiszallitas_datum"]) == $current_month && $dp_row["szallitasi_megjegyzes"] == "posta") {
                        $futarcount++;
                    }
                }

                $result_array_[$key]["szemelyes_atvetel"] = $szemelyesatvetelcount;
                $result_array_[$key]["futar"] = $futarcount;
                if (isset($szemelyesatvetelcount) && isset($futarcount)) {
                    if (($szemelyesatvetelcount + $futarcount) != 0) {
                        $result_array_[$key]["%_a"] = round($szemelyesatvetelcount / ($szemelyesatvetelcount + $futarcount) * 100, 2) . " %";
                        $result_array_[$key]["%_b"] = round($futarcount / ($szemelyesatvetelcount + $futarcount) * 100, 2) . " %";
                    }

                }

                break;

            case "guaman_forgalom":

                $result_array_ = array();

                $ci =& get_instance();

                $hasznalt_sales = $ci->Database_model->get_table("*", "guaman_hasznaltsales", "id", "asc");
                $partner_sales = $ci->Database_model->get_table("*", "guaman_partnersales", "id", "asc");

                foreach ($hasznalt_sales as $hasznalt_sale) {
                    $result_array_[] = $hasznalt_sale;
                }

                foreach ($partner_sales as $partner_sale) {
                    $result_array_[] = $partner_sale;
                }

                return $result_array_;
            case "guaman_beszerzesireporthasznalt":
                $CI =& get_instance();
                $result_array_ = array();

                $keszlet = $CI->Database_model->get_table("*", "guaman_keszlet", "id", "ASC");

                for ($current_month = 1; $current_month <= 12; $current_month++) {
                    $i = $current_month - 1;
                    $result_array_[$i]["honap"] = $current_month;

                    $result_array_[$i]["beszerzesi_partner_db"] = 0;
                    $result_array_[$i]["jofogas_db"] = 0;
                    $result_array_[$i]["hardverapro_db"] = 0;
                    $result_array_[$i]["facebook_marketplace_db"] = 0;

                    foreach ($keszlet as $item) {
                        if (trim_month(get_month($item["beker_datuma"])) == $current_month) {
                            switch ($item["beszerzesi_platform"]) {
                                case "Partner":
                                    $result_array_[$i]["beszerzesi_partner_db"]++;
                                    break;
                                case "JF":
                                    $result_array_[$i]["jofogas_db"]++;
                                    break;
                                case "HA":
                                    $result_array_[$i]["hardverapro_db"]++;
                                    break;
                                case "FB":
                                    $result_array_[$i]["facebook_marketplace_db"]++;
                                    break;
                            }
                        }
                    }

                    // Összegzés:
                    $sum =
                        $result_array_[$i]["beszerzesi_partner_db"] +
                        $result_array_[$i]["jofogas_db"] +
                        $result_array_[$i]["hardverapro_db"] +
                        $result_array_[$i]["facebook_marketplace_db"];

                    // 0-val nem osztunk még 0-t sem!
                    if ($sum == 0) {
                        $sum = 1;
                    }

                    // Százalékok:
                    $result_array_[$i]["beszerzesi_partner_%"] = 100 * ($result_array_[$i]["beszerzesi_partner_db"] / $sum);
                    $result_array_[$i]["jofogas_%"] = 100 * ($result_array_[$i]["jofogas_db"] / $sum);
                    $result_array_[$i]["hardverapro_%"] = 100 * ($result_array_[$i]["hardverapro_db"] / $sum);
                    $result_array_[$i]["facebook_marketplace_%"] = 100 * ($result_array_[$i]["facebook_marketplace_db"] / $sum);

                }


        }


    }


    return $result_array_;

}


function trim_month($month)
{
    $month = trim($month);
    while (mb_substr($month, 0, 1) == "0") {
        $month = mb_substr($month, 1, strlen($month) - 1);
    }
    return $month;
}

// TODO megjelenítésre vonatkozó cuccok átrakása JS-be