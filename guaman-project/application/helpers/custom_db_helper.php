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
                $result_array_[$key]['kozepar'] = ((float)$result_array_[$key]['indulo_ar'] + (float)$result_array_[$key]['vegso_ar']) / 2;
                $result_array_[$key]['celar'] = (float)$result_array_[$key]['kozepar'] * 0.8;

            }
            break;
        case "guaman_keszlet":
            foreach ($result_array_ as $key => $row) {
                $result_array_[$key]['afa'] = round(((float)$result_array_[$key]['eladasi_ar'] - (float)$result_array_[$key]['beszerzesi_ar']) / 1.27, 2);
                $result_array_[$key]['netto_profit'] = round(((float)$result_array_[$key]['eladasi_ar'] - (float)$result_array_[$key]['beszerzesi_ar']) - (((float)$result_array_[$key]['eladasi_ar'] - (float)$result_array_[$key]['beszerzesi_ar']) / 1.27), 2);
                if ((float)$result_array_[$key]['eladasi_ar'] != 0) {
                    $result_array_[$key]['%'] = round($result_array_[$key]['netto_profit'] / (float)$result_array_[$key]['eladasi_ar'], 2);
                };
            }
            break;
        case "guaman_telefon":
            foreach ($result_array_ as $key => $row) {
                $result_array_[$key]['netto_profit'] = (float)$result_array_[$key]['kiker_brutto'] - (float)$result_array_[$key]['beker_brutto'];
                if ((float)$result_array_[$key]['kiker_brutto'] != 0) {
                    $result_array_[$key]['netto_%'] = (float)$result_array_[$key]['netto_profit'] / (float)$result_array_[$key]['kiker_brutto'];
                }
            }
            break;
        case "guaman_gadget":
            foreach ($result_array_ as $key => $row) {
                $result_array_[$key]['netto_profit'] = (float)$result_array_[$key]['kiker_brutto'] - (float)$result_array_[$key]['beker_brutto'];
                if ((float)$result_array_[$key]['kiker_brutto'] != 0) {
                    $result_array_[$key]['netto_%'] = (float)$result_array_[$key]['netto_profit'] / (float)$result_array_[$key]['kiker_brutto'];
                }
            }
            break;
        case "guaman_orakkiegeszitok":
            foreach ($result_array_ as $key => $row) {
                $result_array_[$key]['netto_profit'] = (float)$result_array_[$key]['kiker_brutto'] - (float)$result_array_[$key]['beker_brutto'];
                if ((float)$result_array_[$key]['kiker_brutto'] != 0) {
                    $result_array_[$key]['netto_%'] = (float)$result_array_[$key]['netto_profit'] / (float)$result_array_[$key]['kiker_brutto'];
                }
            }
            break;
        case "guaman_tablet":
            foreach ($result_array_ as $key => $row) {
                $result_array_[$key]['netto_profit'] = (float)$result_array_[$key]['kiker_brutto'] - (float)$result_array_[$key]['beker_brutto'];
                if ((float)$result_array_[$key]['kiker_brutto'] != 0) {
                    $result_array_[$key]['netto_%'] = (float)$result_array_[$key]['netto_profit'] / (float)$result_array_[$key]['kiker_brutto'];
                }
            }
            break;
        case "guaman_keszlet":
            foreach ($result_array_ as $key => $row) {
                $result_array_[$key]['afa'] = round(((float)$result_array_[$key]['eladasi_ar'] - (float)$result_array_[$key]['beszerzesi_ar']) / 1.27, 2);
                $result_array_[$key]['netto_profit'] = round(((float)$result_array_[$key]['eladasi_ar'] - (float)$result_array_[$key]['beszerzesi_ar']) - (((float)$result_array_[$key]['eladasi_ar'] - (float)$result_array_[$key]['beszerzesi_ar']) / 1.27), 2);
                if ((float)$result_array_[$key]['eladasi_ar'] != 0) {
                    $result_array_[$key]['%'] = round($result_array_[$key]['netto_profit'] / (float)$result_array_[$key]['eladasi_ar'], 2);
                };
            }
            break;
        case "guaman_forgalom":
            foreach ($result_array_ as $key => $row) {
                $result_array_[$key]['afa'] = round(((float)$result_array_[$key]['eladasi_ar'] - (float)$result_array_[$key]['beszerzesi_ar']) / 1.27, 2);
                $result_array_[$key]['netto_profit'] = round(((float)$result_array_[$key]['eladasi_ar'] - (float)$result_array_[$key]['beszerzesi_ar']) - (((float)$result_array_[$key]['eladasi_ar'] - (float)$result_array_[$key]['beszerzesi_ar']) / 1.27), 2);
                if ((float)$result_array_[$key]['eladasi_ar'] != 0) {
                    $result_array_[$key]['%'] = round($result_array_[$key]['netto_profit'] / (float)$result_array_[$key]['eladasi_ar'], 2);
                };
            }
            break;
    }


    return $result_array_;
}
