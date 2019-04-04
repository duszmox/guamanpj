<?php
/**
 * Created by PhpStorm.
 * User: Fazekas RoboTeam
 * Date: 3/17/2019
 * Time: 9:44 PM
 */


function custom_db_actions($table_name, $result_array, $column_names)
{

    $result_array_ = $result_array;
    foreach ($result_array_ as $key => $row) {
        $result_array_[$key]['legutobb_updatelve'] = date('m/d/Y h:i:s a', time());


        if (isset($result_array_[$key]['kiker_netto'])) {
            $result_array_[$key]['kiker_netto'] = number_format((float)$result_array_[$key]['kiker_netto'], 2, ".", " ");
        }
        if (isset($result_array_[$key]['beker_netto'])) {
            $result_array_[$key]['beker_netto'] = number_format((float)$result_array_[$key]['beker_netto'], 2, ".", " ");
        }
        if (isset($result_array_[$key]['eladasi_ar'])) {
            $result_array_[$key]['eladasi_ar'] = number_format((float)$result_array_[$key]['eladasi_ar'], 2, ".", " ");
        }
        if (isset($result_array_[$key]['bekerulo_ar'])) {
            $result_array_[$key]['bekerulo_ar'] = number_format((float)$result_array_[$key]['bekerulo_ar'], 2, ".", " ");
        }
        if (isset($result_array_[$key]['beszerzesi_ar'])) {
            $result_array_[$key]['beszerzesi_ar'] = number_format((float)$result_array_[$key]['beszerzesi_ar'], 2, ".", " ");
        }
        if (isset($result_array_[$key]['tervezett_eladasi_ar'])) {
            $result_array_[$key]['tervezett_eladasi_ar'] = number_format((float)$result_array_[$key]['tervezett_eladasi_ar'], 2, ".", " ");
        }
        if (isset($result_array_[$key]['eladasi_ar'])) {
            $result_array_[$key]['eladasi_ar'] = number_format((float)$result_array_[$key]['eladasi_ar'], 2, ".", " ");
        }
        if (isset($result_array_[$key]['beszer_ar'])) {
            $result_array_[$key]['beszer_ar'] = number_format((float)$result_array_[$key]['beszer_ar'], 2, ".", " ");
        }
        if (isset($result_array_[$key]['netto_eladasi_ar'])) {
            $result_array_[$key]['netto_eladasi_ar'] = number_format((float)$result_array_[$key]['netto_eladasi_ar'], 2, ".", " ");
        }
        if (isset($result_array_[$key]['brutto_eladasi_ar'])) {
            $result_array_[$key]['brutto_eladasi_ar'] = number_format((float)$result_array_[$key]['brutto_eladasi_ar'], 2, ".", " ");
        }
        if (isset($result_array_[$key]['eladasi_ar'])) {
            $result_array_[$key]['eladasi_ar'] = number_format((float)$result_array_[$key]['eladasi_ar'], 2, ".", " ");
        }
        if (isset($result_array_[$key]['indulo_ar'])) {
            $result_array_[$key]['indulo_ar'] = number_format((float)$result_array_[$key]['indulo_ar'], 2, ".", " ");
        }
        if (isset($result_array_[$key]['vegso_ar'])) {
            $result_array_[$key]['vegso_ar'] = number_format((float)$result_array_[$key]['vegso_ar'], 2, ".", " ");
        }
        if (isset($result_array_[$key]['kozepar'])) {
            $result_array_[$key]['kozepar'] = number_format((float)$result_array_[$key]['kozepar'], 2, ".", " ");
        }
        if (isset($result_array_[$key]['celar'])) {
            $result_array_[$key]['celar'] = number_format((float)$result_array_[$key]['celar'], 2, ".", " ");
        }
        if (isset($result_array_[$key]['mennyi_max'])) {
            $result_array_[$key]['mennyi_max'] = number_format((float)$result_array_[$key]['mennyi_max'], 2, ".", " ");
        }
        if (isset($result_array_[$key]['netto_beszer_ar'])) {
            $result_array_[$key]['netto_beszer_ar'] = number_format((float)$result_array_[$key]['netto_beszer_ar'], 2, ".", " ");
        }
        if (isset($result_array_[$key]['alkatresz_koltseg'])) {
            $result_array_[$key]['alkatresz_koltseg'] = number_format((float)$result_array_[$key]['alkatresz_koltseg'], 2, ".", " ");
        }
        if (isset($result_array_[$key]['profit'])) {
            $result_array_[$key]['profit'] = number_format((float)$result_array_[$key]['profit'], 2, ".", " ");
        }


    }
    switch ($table_name) {

        case "guaman_keresesilista":
            foreach ($result_array_ as $key => $row) {
                if (is_numeric((float)$result_array_[$key]['indulo_ar']) && is_numeric((float)$result_array_[$key]['vegso_ar'])) {
                    $result_array_[$key]['kozepar'] = number_format(((float)$result_array_[$key]['indulo_ar'] + (float)$result_array_[$key]['vegso_ar']) / 2, 2, ".", " ");
                    $result_array_[$key]['celar'] = number_format((float)$result_array_[$key]['kozepar'] * 0.8, 2, ".", " ");
                }
            }
            break;
        /*case "guaman_keszlet":
            foreach ($result_array_ as $key => $row) {
                if (is_numeric((float)$result_array_[$key]['eladasi_ar']) && is_numeric((float)$result_array_[$key]['beszerzesi_ar'])) {
                    $result_array_[$key]['afa'] = number_format(round(((float)$result_array_[$key]['eladasi_ar'] - (float)$result_array_[$key]['beszerzesi_ar']) / 1.27, 2), 2, ".", " ");
                    $result_array_[$key]['netto_profit'] = number_format(round(((float)$result_array_[$key]['eladasi_ar'] -
                            (float)$result_array_[$key]['beszerzesi_ar']) - (((float)$result_array_[$key]['eladasi_ar'] - (float)$result_array_[$key]['beszerzesi_ar']) / 1.27), 2), 2,".", " ");
                    if ((float)$result_array_[$key]['eladasi_ar'] != 0) {
                        $result_array_[$key]['%'] = (round($result_array_[$key]['netto_profit'] / (float)$result_array_[$key]['eladasi_ar'], 4))*100 . " %";
                    }
                };
            }
            break;*/
        case "guaman_telefon":
            foreach ($result_array_ as $key => $row) {
                if (is_numeric((float)$result_array_[$key]['kiker_netto']) && is_numeric((float)$result_array_[$key]['beker_netto'])) {
                    $result_array_[$key]['netto_profit'] = number_format((float)$result_array_[$key]['kiker_netto'] - (float)$result_array_[$key]['beker_netto'], 2, ".", " ");
                    if ((float)$result_array_[$key]['kiker_netto'] != 0) {
                        $result_array_[$key]['netto_%'] = (round((float)$result_array_[$key]['netto_profit'] / (float)$result_array_[$key]['kiker_netto'], 4)) * 100 . " %";
                    }


                }
            }

            break;
        case "guaman_gadget":
            foreach ($result_array_ as $key => $row) {
                if (is_numeric((float)$result_array_[$key]['kiker_netto']) && is_numeric((float)$result_array_[$key]['beker_netto'])) {
                    $result_array_[$key]['netto_profit'] = number_format((float)$result_array_[$key]['kiker_netto'] - (float)$result_array_[$key]['beker_netto'], 2, ".", " ");
                    if ((float)$result_array_[$key]['kiker_netto'] != 0) {
                        $result_array_[$key]['netto_%'] = (round((float)$result_array_[$key]['netto_profit'] / (float)$result_array_[$key]['kiker_netto'], 4)) * 100 . " %";
                    }
                }
            }
            break;
        case "guaman_orakkiegeszitok":
            foreach ($result_array_ as $key => $row) {
                if (is_numeric((float)$result_array_[$key]['kiker_netto']) && is_numeric((float)$result_array_[$key]['beker_netto'])) {

                    $result_array_[$key]['netto_profit'] = number_format((float)$result_array_[$key]['kiker_netto'] - (float)$result_array_[$key]['beker_netto'], 2, ".", " ");
                    if ((float)$result_array_[$key]['kiker_netto'] != 0) {
                        $result_array_[$key]['netto_%'] = (round((float)$result_array_[$key]['netto_profit'] / (float)$result_array_[$key]['kiker_netto'], 4)) * 100 . " %";
                    }
                }
            }
            break;
        case "guaman_tablet":
            foreach ($result_array_ as $key => $row) {
                if (is_numeric((float)$result_array_[$key]['kiker_netto']) && is_numeric((float)$result_array_[$key]['beker_netto'])) {

                    $result_array_[$key]['netto_profit'] = number_format((float)$result_array_[$key]['kiker_netto'] - (float)$result_array_[$key]['beker_netto'], 2, ".", " ");
                    if ((float)$result_array_[$key]['kiker_netto'] != 0) {
                        $result_array_[$key]['netto_%'] = (round((float)$result_array_[$key]['netto_profit'] / (float)$result_array_[$key]['kiker_netto'], 4)) * 100 . " %";
                    }
                }
            }
            break;
        case "guaman_keszlet":
            foreach ($result_array_ as $key => $row) {
                if (is_numeric((float)$result_array_[$key]['eladasi_ar']) && is_numeric((float)$result_array_[$key]['beszerzesi_ar'])) {

                    $result_array_[$key]['netto_profit'] = number_format(round(((float)$result_array_[$key]['eladasi_ar'] - (float)$result_array_[$key]['beszerzesi_ar']) / 1.27, 2), 2, ".", " ");
                    $result_array_[$key]['afa'] = number_format(round(((float)$result_array_[$key]['eladasi_ar'] - (float)$result_array_[$key]['beszerzesi_ar']) - (((float)$result_array_[$key]['eladasi_ar'] - (float)$result_array_[$key]['beszerzesi_ar']) / 1.27), 2), 2, ".", " ");
                    if ((float)$result_array_[$key]['eladasi_ar'] != 0) {
                        $result_array_[$key]['%'] = (round($result_array_[$key]['netto_profit'] / (float)$result_array_[$key]['eladasi_ar'], 4)) * 100 . " %";
                    };
                }
            }
            break;
        case "guaman_forgalom":
            foreach ($result_array_ as $key => $row) {
                if (is_numeric((float)$result_array_[$key]['eladasi_ar']) && is_numeric((float)$result_array_[$key]['beszerzesi_ar'])) {

                    $result_array_[$key]['netto_profit'] = number_format(round(((float)$result_array_[$key]['eladasi_ar'] -
                            (float)$result_array_[$key]['beszerzesi_ar']) / 1.27, 2), 2, ".", " ");
                    $result_array_[$key]['afa'] = number_format(round(((float)$result_array_[$key]['eladasi_ar'] - (float)$result_array_[$key]['beszerzesi_ar']) -
                        (((float)$result_array_[$key]['eladasi_ar'] - (float)$result_array_[$key]['beszerzesi_ar']) / 1.27), 2), 2, ".", " ");
                    if ((float)$result_array_[$key]['eladasi_ar'] != 0) {
                        $result_array_[$key]['%'] = (round($result_array_[$key]['netto_profit'] / (float)$result_array_[$key]['eladasi_ar'], 4)) * 100 . " %";
                    };
                }
            }
            break;
        case "guaman_hasznaltsales":
            foreach ($result_array_ as $key => $row) {
                if (is_numeric((float)$result_array_[$key]['beszer_ar']) && is_numeric((float)$result_array_[$key]['brutto_eladasi_ar'])) {

                    $result_array_[$key]['netto_profit'] = number_format(round(((float)$result_array_[$key]['brutto_eladasi_ar'] - (float)$result_array_[$key]['beszer_ar']) * 0.2126, 2), 2, ".", " ");
                    $result_array_[$key]['afa'] = number_format(round(((float)$result_array_[$key]['brutto_eladasi_ar'] - (float)$result_array_[$key]['beszer_ar']) - (((float)$result_array_[$key]['afa'])), 2), 2, ".", " ");
                    $result_array_[$key]['netto_eladasi_ar'] = number_format(round(((float)$result_array_[$key]['brutto_eladasi_ar'] - (float)$result_array_[$key]['afa']), 2), 2, ".", " ");
                    if ((float)$result_array_[$key]['netto_eladasi_ar'] != 0) {
                        $result_array_[$key]['netto_%'] = (round($result_array_[$key]['netto_profit'] / (float)$result_array_[$key]['netto_eladasi_ar'], 4)) * 100 . " %";
                    };
                }
            }
            break;
        case "guaman_partnersales":
            foreach ($result_array_ as $key => $row) {
                if (is_numeric((float)$result_array_[$key]['netto_beszer_ar']) && is_numeric((float)$result_array_[$key]['brutto_eladasi_ar'])) {

                    $result_array_[$key]['netto_profit'] = number_format(round(((float)$result_array_[$key]['brutto_eladasi_ar'] - (float)$result_array_[$key]['netto_beszer_ar']) * 0.2126, 2), 2, ".", " ");
                    $result_array_[$key]['afa'] = number_format(round(((float)$result_array_[$key]['brutto_eladasi_ar']
                            - (float)$result_array_[$key]['netto_beszer_ar']) - (((float)$result_array_[$key]['afa'])), 2), 2, ".", " ");
                    $result_array_[$key]['netto_eladasi_ar'] = number_format(round(((float)$result_array_[$key]['brutto_eladasi_ar'] - (float)$result_array_[$key]['afa']), 2), 2, ".", " ");
                    if ((float)$result_array_[$key]['netto_eladasi_ar'] != 0) {
                        $result_array_[$key]['netto_%'] = (round($result_array_[$key]['netto_profit'] / (float)$result_array_[$key]['netto_eladasi_ar'], 4)) * 100 . " %";
                    };
                }
            }
            break;
        case "guaman_szervizsales":
            foreach ($result_array_ as $key => $row) {
                if (is_numeric((float)$result_array_[$key]['jav_ara']) && is_numeric((float)$result_array_[$key]['alkatresz_koltseg'])) {

                    $result_array_[$key]['profit'] = number_format(round(((float)$result_array_[$key]['jav_ara'] - (float)$result_array_[$key]['alkatresz_koltseg']), 2), 2, ".", " ");

                }
            }
            break;
        case "guaman_tartozeksales":
            foreach ($result_array_ as $key => $row) {
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
            }
            break;
        case "guaman_szerviznaplo":
            foreach ($result_array_ as $key => $row) {

                $date1 = $result_array_[$key]['szerviz_kezdet_datum'];
                $date2 = $result_array_[$key]['szerviz_vege_datum'];

                $diff = abs(strtotime($date2) - strtotime($date1));
                $result_array_[$key]['jav_ido'] = floor($diff / (60 * 60 * 24)) . " " . lang("day");

            }
            break;
    }

    if ($table_name == "guaman_forgalom") {
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

        /*
        for ($i = 0; $i < sizeof($result_array_); $i++) {
            foreach ($result_array_[$i] as $key => $value) {
                if ($value === null) {
                    $result_array_[$i][$key] = "";
                }
            }
        }
        */
    }


    return $result_array_;

}


