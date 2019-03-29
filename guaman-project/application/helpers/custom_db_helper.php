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

    }
    switch ($table_name) {

        case "guaman_keresesilista":
            foreach ($result_array_ as $key => $row) {
                if (is_numeric((float)$result_array_[$key]['indulo_ar']) && is_numeric((float)$result_array_[$key]['vegso_ar'])) {
                    $result_array_[$key]['kozepar'] = ((float)$result_array_[$key]['indulo_ar'] + (float)$result_array_[$key]['vegso_ar']) / 2;
                    $result_array_[$key]['celar'] = (float)$result_array_[$key]['kozepar'] * 0.8;
                }
            }
            break;
        case "guaman_keszlet":
            foreach ($result_array_ as $key => $row) {
                if (is_numeric((float)$result_array_[$key]['eladasi_ar']) && is_numeric((float)$result_array_[$key]['beszerzesi_ar'])) {
                    $result_array_[$key]['afa'] = round(((float)$result_array_[$key]['eladasi_ar'] - (float)$result_array_[$key]['beszerzesi_ar']) / 1.27, 2);
                    $result_array_[$key]['netto_profit'] = round(((float)$result_array_[$key]['eladasi_ar'] - (float)$result_array_[$key]['beszerzesi_ar']) - (((float)$result_array_[$key]['eladasi_ar'] - (float)$result_array_[$key]['beszerzesi_ar']) / 1.27), 2);
                    if ((float)$result_array_[$key]['eladasi_ar'] != 0) {
                        $result_array_[$key]['%'] = (round($result_array_[$key]['netto_profit'] / (float)$result_array_[$key]['eladasi_ar'], 4) * 100) . " %";
                    }
                };
            }
            break;
        case "guaman_telefon":
            foreach ($result_array_ as $key => $row) {
                if (is_numeric((float)$result_array_[$key]['kiker_brutto']) && is_numeric((float)$result_array_[$key]['beker_brutto'])) {

                    $result_array_[$key]['netto_profit'] = (float)$result_array_[$key]['kiker_brutto'] - (float)$result_array_[$key]['beker_brutto'];
                    if ((float)$result_array_[$key]['kiker_brutto'] != 0) {
                        $result_array_[$key]['netto_%'] = round((float)$result_array_[$key]['netto_profit'] / (float)$result_array_[$key]['kiker_brutto'],4 ) *100 . " %";
                    }
                }
            }

            break;
        case
        "guaman_gadget":
            foreach ($result_array_ as $key => $row) {
                if (is_numeric((float)$result_array_[$key]['kiker_brutto']) && is_numeric((float)$result_array_[$key]['beker_brutto'])) {
                    $result_array_[$key]['netto_profit'] = (float)$result_array_[$key]['kiker_brutto'] - (float)$result_array_[$key]['beker_brutto'];
                    if ((float)$result_array_[$key]['kiker_brutto'] != 0) {
                        $result_array_[$key]['netto_%'] = round((float)$result_array_[$key]['netto_profit'] / (float)$result_array_[$key]['kiker_brutto'], 4) * 100 . " %";
                    }
                }
            }
            break;
        case "guaman_orakkiegeszitok":
            foreach ($result_array_ as $key => $row) {
                if (is_numeric((float)$result_array_[$key]['kiker_brutto']) && is_numeric((float)$result_array_[$key]['beker_brutto'])) {

                    $result_array_[$key]['netto_profit'] = (float)$result_array_[$key]['kiker_brutto'] - (float)$result_array_[$key]['beker_brutto'];
                    if ((float)$result_array_[$key]['kiker_brutto'] != 0) {
                        $result_array_[$key]['netto_%'] = (round((float)$result_array_[$key]['netto_profit'] / (float)$result_array_[$key]['kiker_brutto'], 4) * 100) . " %";
                    }
                }
            }
            break;
        case "guaman_tablet":
            foreach ($result_array_ as $key => $row) {
                if (is_numeric((float)$result_array_[$key]['kiker_brutto']) && is_numeric((float)$result_array_[$key]['beker_brutto'])) {

                    $result_array_[$key]['netto_profit'] = (float)$result_array_[$key]['kiker_brutto'] - (float)$result_array_[$key]['beker_brutto'];
                    if ((float)$result_array_[$key]['kiker_brutto'] != 0) {
                        $result_array_[$key]['netto_%'] = (round((float)$result_array_[$key]['netto_profit'] / (float)$result_array_[$key]['kiker_brutto'], 4) * 100) . " %";
                    }
                }
            }
            break;
        case "guaman_keszlet":
            foreach ($result_array_ as $key => $row) {
                if (is_numeric((float)$result_array_[$key]['eladasi_ar']) && is_numeric((float)$result_array_[$key]['beszerzesi_ar'])) {

                    $result_array_[$key]['afa'] = round(((float)$result_array_[$key]['eladasi_ar'] - (float)$result_array_[$key]['beszerzesi_ar']) / 1.27, 2);
                    $result_array_[$key]['netto_profit'] = round(((float)$result_array_[$key]['eladasi_ar'] - (float)$result_array_[$key]['beszerzesi_ar']) - (((float)$result_array_[$key]['eladasi_ar'] - (float)$result_array_[$key]['beszerzesi_ar']) / 1.27), 2);
                    if ((float)$result_array_[$key]['eladasi_ar'] != 0) {
                        $result_array_[$key]['%'] = (round($result_array_[$key]['netto_profit'] / (float)$result_array_[$key]['eladasi_ar'], 4) * 100) . " %";
                    };
                }
            }
            break;
        case "guaman_forgalom":
            foreach ($result_array_ as $key => $row) {
                if (is_numeric((float)$result_array_[$key]['eladasi_ar']) && is_numeric((float)$result_array_[$key]['beszerzesi_ar'])) {

                    $result_array_[$key]['afa'] = round(((float)$result_array_[$key]['eladasi_ar'] - (float)$result_array_[$key]['beszerzesi_ar']) / 1.27, 2);
                    $result_array_[$key]['netto_profit'] = round(((float)$result_array_[$key]['eladasi_ar'] - (float)$result_array_[$key]['beszerzesi_ar']) - (((float)$result_array_[$key]['eladasi_ar'] - (float)$result_array_[$key]['beszerzesi_ar']) / 1.27), 2);
                    if ((float)$result_array_[$key]['eladasi_ar'] != 0) {
                        $result_array_[$key]['%'] = (round($result_array_[$key]['netto_profit'] / (float)$result_array_[$key]['eladasi_ar'], 4) * 100) . " %";
                    };
                }
            }
            break;
        case "guaman_hasznaltsales":
            foreach ($result_array_ as $key => $row) {
                if (is_numeric((float)$result_array_[$key]['beszer_ar']) && is_numeric((float)$result_array_[$key]['brutto_eladasi_ar'])) {

                    $result_array_[$key]['afa'] = round(((float)$result_array_[$key]['brutto_eladasi_ar'] - (float)$result_array_[$key]['beszer_ar']) * 0.2126, 2);
                    $result_array_[$key]['netto_profit'] = round(((float)$result_array_[$key]['brutto_eladasi_ar'] - (float)$result_array_[$key]['beszer_ar']) - (((float)$result_array_[$key]['afa'])), 2);
                    $result_array_[$key]['netto_eladasi_ar'] = round(((float)$result_array_[$key]['brutto_eladasi_ar'] - (float)$result_array_[$key]['afa']), 2);
                    if ((float)$result_array_[$key]['netto_eladasi_ar'] != 0) {
                        $result_array_[$key]['netto_%'] = (round($result_array_[$key]['netto_profit'] / (float)$result_array_[$key]['netto_eladasi_ar'], 4) * 100) . " %";
                    };
                }
            }
            break;
        case "guaman_partnersales":
            foreach ($result_array_ as $key => $row) {
                if (is_numeric((float)$result_array_[$key]['netto_beszer_ar']) && is_numeric((float)$result_array_[$key]['brutto_eladasi_ar'])) {

                    $result_array_[$key]['afa'] = round(((float)$result_array_[$key]['brutto_eladasi_ar'] - (float)$result_array_[$key]['netto_beszer_ar']) * 0.2126, 2);
                    $result_array_[$key]['netto_profit'] = round(((float)$result_array_[$key]['brutto_eladasi_ar'] - (float)$result_array_[$key]['netto_beszer_ar']) - (((float)$result_array_[$key]['afa'])), 2);
                    $result_array_[$key]['netto_eladasi_ar'] = round(((float)$result_array_[$key]['brutto_eladasi_ar'] - (float)$result_array_[$key]['afa']), 2);
                    if ((float)$result_array_[$key]['netto_eladasi_ar'] != 0) {
                        $result_array_[$key]['netto_%'] = (round($result_array_[$key]['netto_profit'] / (float)$result_array_[$key]['netto_eladasi_ar'], 4) * 100) . " %";
                    };
                }
            }
            break;
        case "guaman_szervizsales":
            foreach ($result_array_ as $key => $row) {
                if (is_numeric((float)$result_array_[$key]['jav_ara']) && is_numeric((float)$result_array_[$key]['alkatresz_koltseg'])) {

                    $result_array_[$key]['profit'] = round(((float)$result_array_[$key]['jav_ara'] - (float)$result_array_[$key]['alkatresz_koltseg']), 2);

                }
            }
            break;
        case "guaman_tartozeksales":
            foreach ($result_array_ as $key => $row) {
                if (is_numeric((float)$result_array_[$key]['netto_beszerzesi_ar']) && is_numeric((float)$result_array_[$key]['brutto_eladasi_ar'])) {

                    $result_array_[$key]['afa'] = round(((float)$result_array_[$key]['brutto_eladasi_ar'] - (float)$result_array_[$key]['netto_beszerzesi_ar']) * 0.2126, 2);
                    $result_array_[$key]['netto_profit'] = round(((float)$result_array_[$key]['brutto_eladasi_ar'] - (float)$result_array_[$key]['netto_beszerzesi_ar']) - (((float)$result_array_[$key]['afa'])), 2);
                    $result_array_[$key]['netto_eladasi_ar'] = round(((float)$result_array_[$key]['brutto_eladasi_ar'] - (float)$result_array_[$key]['afa']), 2);
                    if ((float)$result_array_[$key]['netto_eladasi_ar'] != 0) {
                        $result_array_[$key]['netto_%'] = (round($result_array_[$key]['netto_profit'] / (float)$result_array_[$key]['netto_eladasi_ar'], 4) * 100) . " %";
                    };
                }
            }
            break;
    }


    return $result_array_;
}
