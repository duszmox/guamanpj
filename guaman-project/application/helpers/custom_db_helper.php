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

    switch ($table_name) {

        case "guaman_keresesilista":
            foreach ($result_array_ as $key => $row) {
                if (is_numeric($result_array_[$key]['indulo_ar']) AND is_numeric($result_array_[$key]['vegso_ar'])) {
                    $result_array_[$key]["kozepar"] = ($result_array_[$key]["indulo_ar"] + $result_array_[$key]["vegso_ar"]) / 2;
                    $result_array_[$key]["celar"] = $result_array_[$key]["indulo_ar"] * 0.8;
                }
            }
            break;
        case "guaman_tartozeksales":
            foreach ($result_array_ as $key => $row) {
                if (is_numeric($result_array_[$key]['brutto_eladasi_ar']) && is_numeric($result_array_[$key]['beszerzesi_ar'])) {
                    $result_array_[$key]['afa'] = round(($result_array_[$key]['brutto_eladasi_ar'] - $result_array_[$key]['beszerzesi_ar']) * 0.2126, 2);
                    $result_array_[$key]['netto_profit'] = $result_array_[$key]['brutto_eladasi_ar'] - $result_array_[$key]['beszerzesi_ar'] - $result_array_[$key]['afa'];
                    $result_array_[$key]['netto_eladasi_ar'] = round(($result_array_[$key]['brutto_eladasi_ar'] - $result_array_[$key]['afa']), 2);
                    if ($result_array_[$key]['netto_eladasi_ar'] != 0) {
                        $result_array_[$key]["netto_%"] = round(100 * $result_array_[$key]["netto_profit"] / $result_array_[$key]["netto_eladasi_ar"], 2);
                    } else {
                        $result_array_[$key]["netto_%"] = "0 %";
                    }
                }
            }

            break;
        /*case "guaman_telefon":
        case "guaman_tablet":
        case "guaman_orakkiegeszitok":
        case "guaman_gadget":
        case "guaman_keszletujkeszulek":
            foreach ($result_array_ as $key => $row) {
                if (is_numeric($result_array_[$key]['beszerzesi_ar']) AND is_numeric($result_array_[$key]['eladasi_ar'])) {
                    $result_array_[$key]["netto_profit"] = $result_array_[$key]["kiker_netto"] - $result_array_[$key]["beker_netto"];
                    if ($result_array_[$key]['kiker_netto'] != 0) {
                        $result_array_[$key]["netto_%"] = round(($result_array_[$key]["netto_profit"] / $result_array_[$key]["kiker_netto"]) * 100,2);
                    }
                }
            }
            break;
*/
        case "guaman_hasznaltsales":
        case "guaman_partnersales" :
        case "guaman_gadgetsales" :
        case "guaman_sales" :
            foreach ($result_array_ as $key => $row) {
                if (is_numeric($result_array_[$key]['brutto_eladasi_ar']) && is_numeric($result_array_[$key]['beszerzesi_ar'])) {
                    $result_array_[$key]['afa'] = round(($result_array_[$key]['brutto_eladasi_ar'] - $result_array_[$key]['beszerzesi_ar']) * 0.2126, 2);
                    $result_array_[$key]['netto_profit'] = $result_array_[$key]['brutto_eladasi_ar'] - $result_array_[$key]['beszerzesi_ar'] - $result_array_[$key]['afa'];
                    $result_array_[$key]['netto_eladasi_ar'] = round(($result_array_[$key]['brutto_eladasi_ar'] - $result_array_[$key]['afa']), 2);
                    if ($result_array_[$key]['netto_eladasi_ar'] != 0) {
                        $result_array_[$key]["netto_%"] = round(100 * $result_array_[$key]["netto_profit"] / $result_array_[$key]["netto_eladasi_ar"], 2);
                    } else {
                        $result_array_[$key]["netto_%"] = "0 %";
                    }
                } else {
                    $result_array_[$key]['brutto_eladasi_ar'] = 0;
                    $result_array_[$key]['beszerzesi_ar'] = 0;
                    $result_array_[$key]["netto_%"] = "0 %";

                }
                $date1 = $result_array_[$key]['beszer_datum'];
                $date2 = $result_array_[$key]['eladas_datum'];
                $diff = abs(strtotime($date2) - strtotime($date1));
                $result_array_[$key]['forgasi_nap'] = floor($diff / (60 * 60 * 24)) . " " . lang("day");

            }
            break;

        case "guaman_szerviznaplo":
            foreach ($result_array_ as $key => $row) {
                $date1 = $result_array_[$key]['szerviz_kezdet_datum'];
                $date2 = $result_array_[$key]['szerviz_vege_datum'];
                $diff = abs(strtotime($date2) - strtotime($date1));
                $result_array_[$key]['forgasi_nap'] = floor($diff / (60 * 60 * 24)) . " " . lang("day");
            }
            break;

        case "guaman_keszlet":
        case "guaman_keszletujkeszulek":
            foreach ($result_array_ as $key => $row) {
                if (is_numeric($result_array_[$key]['eladasi_ar']) && is_numeric($result_array_[$key]['beszerzesi_ar'])) {
                    $result_array_[$key]['afa'] = round((((int)$result_array_[$key]['eladasi_ar'] - (int)$result_array_[$key]['beszerzesi_ar']) * 0.2126), 2);
                    $result_array_[$key]['netto_profit'] = ($result_array_[$key]['eladasi_ar'] - $result_array_[$key]['beszerzesi_ar']) - $result_array_[$key]['afa'];
                    if ($result_array_[$key]['eladasi_ar'] == 0) {
                        $result_array_[$key]["%"] = "0";
                    } else {
                        $result_array_[$key]["%"] = round(($result_array_[$key]["netto_profit"] / $result_array_[$key]["eladasi_ar"]) * 100, 2);
                    }
                }
            }
            break;


        case "guaman_disztribuciosreport":
            $result_array_ = array();
            for ($current_month = 1; $current_month <= 12; $current_month++) {
                $ci =& get_instance();
                $result_array_[$current_month - 1]["honap"] = $current_month;


                $szemelyesatvetelcount = 0;
                $futarcount = 0;

                $dh = array();
                $full_array = $ci->Database_model->get_table("kiszallitas_datum, szallitasi_megjegyzes, type", "guaman_disztribucio", "id", "asc");


                foreach ($full_array as $key => $value) {
                    if ($full_array[$key]["type"] == "Használt") {
                        $dh[] = $full_array[$key];
                    }
                }
              foreach ($dh as $dh_row) {
                    if (trim_month(get_month($dh_row["kiszallitas_datum"])) == $current_month && strtolower($dh_row["szallitasi_megjegyzes"]) == "személyes átvétel") {
                        $szemelyesatvetelcount++;
                    } else if (trim_month(get_month($dh_row["kiszallitas_datum"])) == $current_month && strtolower($dh_row["szallitasi_megjegyzes"]) == "posta") {
                        $futarcount++;
                    }
                }

                $dp = array();
                $full_array = $ci->Database_model->get_table("kiszallitas_datum, szallitasi_megjegyzes, type", "guaman_disztribucio", "id", "asc");

                foreach ($full_array as $key => $value) {
                    if ($full_array[$key]["type"] == "Partner") {
                        $dp[] = $full_array[$key];
                    }
                }

                foreach ($dp as $dp_row) {
                    if (trim_month(get_month($dp_row["kiszallitas_datum"])) == $current_month && strtolower($dp_row["szallitasi_megjegyzes"]) == "személyes átvétel") {
                        $szemelyesatvetelcount++;
                    } else if (trim_month(get_month($dp_row["kiszallitas_datum"])) == $current_month && strtolower($dp_row["szallitasi_megjegyzes"]) == "posta") {
                        $futarcount++;
                    }
                }

                $result_array_[$current_month - 1]["id"] = $current_month;
                $result_array_[$current_month - 1]["honap"] = $current_month;
                $result_array_[$current_month - 1]["szemelyes_atvetel"] = $szemelyesatvetelcount;

                $result_array_[$current_month - 1]["futar"] = $futarcount;

                $sum = $futarcount + $szemelyesatvetelcount;
                // 0-val nem osztunk
                if ($sum <= 0) {
                    $sum = 1;
                }

                $result_array_[$current_month - 1]["%_a"] = round($szemelyesatvetelcount / ($sum) * 100, 2);
                $result_array_[$current_month - 1]["%_b"] = round($futarcount / ($sum) * 100, 2);

            }
            break;

        /*case "guaman_forgalom":
            $ci =& get_instance();
            $result_array_ = array();

            $hasznalt_sales = $ci->Database_model->get_table("*", "guaman_hasznaltsales", "id", "asc");
            $partner_sales = $ci->Database_model->get_table("*", "guaman_partnersales", "id", "asc");

            foreach ($hasznalt_sales as $hasznalt_sale) {
                $result_array_[] = $hasznalt_sale;
            }

            foreach ($partner_sales as $partner_sale) {
                $result_array_[] = $partner_sale;
            }
            return $result_array_;
*/
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

                foreach ($keszlet as $gadget) {
                    if (trim_month(get_month($gadget["beker_datuma"])) == $current_month) {
                        switch (strtolower($gadget["beszerzesi_platform"])) {
                            case "partner":
                                $result_array_[$i]["beszerzesi_partner_db"]++;
                                break;
                            case "jf":
                                $result_array_[$i]["jofogas_db"]++;
                                break;
                            case "ha":
                                $result_array_[$i]["hardverapro_db"]++;
                                break;
                            case "fb":
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
                $result_array_[$i]["beszerzesi_partner_%"] = round(100 * ($result_array_[$i]["beszerzesi_partner_db"] / $sum), 2);
                $result_array_[$i]["jofogas_%"] = round(100 * ($result_array_[$i]["jofogas_db"] / $sum), 2);
                $result_array_[$i]["hardverapro_%"] = round(100 * ($result_array_[$i]["hardverapro_db"] / $sum), 2);
                $result_array_[$i]["facebook_marketplace_%"] = round(100 * ($result_array_[$i]["facebook_marketplace_db"] / $sum), 2);

            }

            break;

        case "guaman_beszerzesireportpartner":
            $CI =& get_instance();

            /*$telefon = $CI->Database_model->get_table("*", "guaman_telefon", "id", "ASC");
            $orakkiegeszitok = $CI->Database_model->get_table("*", "guaman_orakkiegeszitok", "id", "ASC");
            $tablet = $CI->Database_model->get_table("*", "guaman_tablet", "id", "ASC");


            $merged_arrays = array($telefon, $tablet, $orakkiegeszitok);
            */
            //  $merged_arrays = $CI->Database_model->get_table("*", "guaman_keszletujkeszulek", "id", "ASC");

            $gadgets = array();
            $full_array = $CI->Database_model->get_table("*", "guaman_keszletujkeszulek", "id", "ASC");
            foreach ($full_array as $key => $value) {

                $gadgets[] = $full_array[$key];

            }
            $merged_arrays = array($gadgets);

            for ($current_month = 1; $current_month <= 12; $current_month++) {
                $i = $current_month - 1;
                $result_array_[$i]["honap"] = $current_month;
                $result_array_[$i]["id"] = $current_month;

                $result_array_[$i]["bravophone_db"] = 0;
                $result_array_[$i]["gegeszoft_db"] = 0;
                $result_array_[$i]["alibaba_db"] = 0;
                $result_array_[$i]["facebook_marketplace_db"] = 0;
                foreach ($merged_arrays as $key => $value) {
                    foreach ($value as $gadget) {
                        if (trim_month(get_month($gadget["beker_datuma"])) == $current_month) {
                            switch (strtolower($gadget["beszerzesi_platform"])) {
                                case "bravophone":
                                    $result_array_[$i]["bravophone_db"]++;
                                    break;
                                case "gegeszoft":
                                    $result_array_[$i]["gegeszoft_db"]++;
                                    break;
                                case "alibaba":
                                    $result_array_[$i]["alibaba_db"]++;
                                    break;
                                case "facebook":
                                    $result_array_[$i]["facebook_marketplace_db"]++;
                                    break;
                            }
                        }
                    }
                }


                // Összegzés:
                $sum =
                    $result_array_[$i]["bravophone_db"] +
                    $result_array_[$i]["gegeszoft_db"] +
                    $result_array_[$i]["alibaba_db"] +
                    $result_array_[$i]["facebook_marketplace_db"];

                // 0-val nem osztunk még 0-t sem!
                if ($sum == 0) {
                    $sum = 1;
                }

                // Százalékok:
                $result_array_[$i]["bravophone_%"] = round(100 * ($result_array_[$i]["bravophone_db"] / $sum), 2);
                $result_array_[$i]["gegeszoft_%"] = round(100 * ($result_array_[$i]["gegeszoft_db"] / $sum), 2);
                $result_array_[$i]["alibaba_%"] = round(100 * ($result_array_[$i]["alibaba_db"] / $sum), 2);
                $result_array_[$i]["facebook_marketplace_%"] = round(100 * ($result_array_[$i]["facebook_marketplace_db"] / $sum), 2);

            }
            break;
        case "guaman_beszerzesireportgadget":
            $CI =& get_instance();
            $result_array_ = array();

            $gadgets = array();
            $full_array = $CI->Database_model->get_table("*", "guaman_keszletujkeszulek", "id", "ASC");
            foreach ($full_array as $key => $value) {
                if ($full_array[$key]["type"] == "Gadget") {
                    $gadgets[] = $full_array[$key];
                }
            }
            $merged_arrays = array($gadgets);
            for ($current_month = 1; $current_month <= 12; $current_month++) {
                $i = $current_month - 1;
                $result_array_[$i]["id"] = $current_month;
                $result_array_[$i]["honap"] = $current_month;

                $result_array_[$i]["phonemax_db"] = 0;
                $result_array_[$i]["mobilpro_db"] = 0;
                $result_array_[$i]["alibaba_db"] = 0;
                $result_array_[$i]["bravophone_db"] = 0;
                foreach ($merged_arrays as $key => $value) {
                    foreach ($value as $gadget) {
                        if (trim_month(get_month($gadget["beker_datuma"])) == $current_month) {
                            switch (strtolower($gadget["beszerzesi_platform"])) {
                                case "phonemax":
                                    $result_array_[$i]["phonemax_db"]++;
                                    break;
                                case "mobilpro":
                                    $result_array_[$i]["mobilpro_db"]++;
                                    break;
                                case "alibaba":
                                    $result_array_[$i]["alibaba_db"]++;
                                    break;
                                case "bravophone":
                                    $result_array_[$i]["bravophone_db"]++;
                                    break;
                            }
                        }
                    }
                }


                // Összegzés:
                $sum =
                    $result_array_[$i]["phonemax_db"] +
                    $result_array_[$i]["mobilpro_db"] +
                    $result_array_[$i]["alibaba_db"] +
                    $result_array_[$i]["bravophone_db"];

                // 0-val nem osztunk még 0-t sem!
                if ($sum == 0) {
                    $sum = 1;
                }

                // Százalékok:
                $result_array_[$i]["phonemax_%"] = round(100 * ($result_array_[$i]["phonemax_db"] / $sum), 2);
                $result_array_[$i]["mobilpro_%"] = round(100 * ($result_array_[$i]["mobilpro_db"] / $sum), 2);
                $result_array_[$i]["alibaba_%"] = round(100 * ($result_array_[$i]["alibaba_db"] / $sum), 2);
                $result_array_[$i]["bravophone_%"] = round(100 * ($result_array_[$i]["bravophone_db"] / $sum), 2);

            }
            break;
        case "guaman_salesplatformreporthasznalt":
            $CI =& get_instance();
            $result_array_ = array();

            $hasznaltsales = array();
            $full_array = $CI->Database_model->get_table("*", "guaman_sales", "id", "ASC");
            foreach ($full_array as $key => $value) {
                if ($full_array[$key]["type"] == "Használt") {
                    $hasznaltsales[] = $full_array[$key];
                }
            }
            for ($current_month = 1; $current_month <= 12; $current_month++) {
                $i = $current_month - 1;
                $result_array_[$i]["honap"] = $current_month;
                $result_array_[$i]["id"] = $current_month;

                $result_array_[$i]["webshop_db"] = 0;
                $result_array_[$i]["instagram_db"] = 0;
                $result_array_[$i]["visszatero_db"] = 0;
                $result_array_[$i]["hasznalt_alma_db"] = 0;
                $result_array_[$i]["jofogas_db"] = 0;
                $result_array_[$i]["hardverapro_db"] = 0;
                $result_array_[$i]["facebook_db"] = 0;

                foreach ($hasznaltsales as $hasznaltsale) {
                    if (trim_month(get_month($hasznaltsale["beszer_datum"])) == $current_month) {
                        switch (strtolower($hasznaltsale["platform"])) {
                            case "ws":
                                $result_array_[$i]["webshop_db"]++;
                                break;
                            case "ig":
                                $result_array_[$i]["instagram_db"]++;
                                break;
                            case "vt":
                                $result_array_[$i]["visszatero_db"]++;
                                break;
                            case "ha":
                                $result_array_[$i]["hasznalt_alma_db"]++;
                                break;
                            case "jf":
                                $result_array_[$i]["jofogas_db"]++;
                                break;
                            case "hr":
                                $result_array_[$i]["hardverapro_db"]++;
                                break;
                            case "fb":
                                $result_array_[$i]["facebook_db"]++;
                                break;

                        }
                    }
                }


                // Összegzés:
                $sum =
                    $result_array_[$i]["webshop_db"] +
                    $result_array_[$i]["instagram_db"] +
                    $result_array_[$i]["visszatero_db"] +
                    $result_array_[$i]["hasznalt_alma_db"] +
                    $result_array_[$i]["jofogas_db"] +
                    $result_array_[$i]["hardverapro_db"] +
                    $result_array_[$i]["facebook_db"];

                // 0-val nem osztunk még 0-t sem!
                if ($sum == 0) {
                    $sum = 1;
                }

                // Százalékok:
                $result_array_[$i]["webshop_%"] = round(100 * ($result_array_[$i]["webshop_db"] / $sum), 2);
                $result_array_[$i]["instagram_%"] = round(100 * ($result_array_[$i]["instagram_db"] / $sum), 2);
                $result_array_[$i]["visszatero_%"] = round(100 * ($result_array_[$i]["visszatero_db"] / $sum), 2);
                $result_array_[$i]["hasznalt_alma_%"] = round(100 * ($result_array_[$i]["hasznalt_alma_db"] / $sum), 2);
                $result_array_[$i]["jofogas_%"] = round(100 * ($result_array_[$i]["jofogas_db"] / $sum), 2);
                $result_array_[$i]["hardverapro_%"] = round(100 * ($result_array_[$i]["hardverapro_db"] / $sum), 2);
                $result_array_[$i]["facebook_%"] = round(100 * ($result_array_[$i]["facebook_db"] / $sum), 2);

            }
            break;
        case
        "guaman_salesplatformreportgadget":
            $CI =& get_instance();
            $result_array_ = array();

            $gadgets = array();
            $full_array = $CI->Database_model->get_table("*", "guaman_sales", "id", "ASC");

            foreach ($full_array as $key => $value) {
                if ($full_array[$key]["type"] == "Gadget") {
                    $gadgets[] = $full_array[$key];
                }
            }

            for ($current_month = 1; $current_month <= 12; $current_month++) {
                $i = $current_month - 1;
                $result_array_[$i]["honap"] = $current_month;
                $result_array_[$i]["id"] = $current_month;

                $result_array_[$i]["webshop_db"] = 0;
                $result_array_[$i]["instagram_db"] = 0;
                $result_array_[$i]["visszatero_db"] = 0;
                $result_array_[$i]["hasznalt_alma_db"] = 0;
                $result_array_[$i]["jofogas_db"] = 0;
                $result_array_[$i]["hardverapro_db"] = 0;
                $result_array_[$i]["facebook_db"] = 0;

                foreach ($gadgets as $gadget) {
                    if (trim_month(get_month($gadget["beszer_datum"])) == $current_month) {
                        switch (strtolower($gadget["platform"])) {
                            case "ws":
                                $result_array_[$i]["webshop_db"]++;
                                break;
                            case "ig":
                                $result_array_[$i]["instagram_db"]++;
                                break;
                            case "vt":
                                $result_array_[$i]["visszatero_db"]++;
                                break;
                            case "ha":
                                $result_array_[$i]["hasznalt_alma_db"]++;
                                break;
                            case "jf":
                                $result_array_[$i]["jofogas_db"]++;
                                break;
                            case "hr":
                                $result_array_[$i]["hardverapro_db"]++;
                                break;
                            case "fb":
                                $result_array_[$i]["facebook_db"]++;
                                break;

                        }
                    }
                }

                // Összegzés:
                $sum =
                    $result_array_[$i]["webshop_db"] +
                    $result_array_[$i]["instagram_db"] +
                    $result_array_[$i]["visszatero_db"] +
                    $result_array_[$i]["hasznalt_alma_db"] +
                    $result_array_[$i]["jofogas_db"] +
                    $result_array_[$i]["hardverapro_db"] +
                    $result_array_[$i]["facebook_db"];

                // 0-val nem osztunk még 0-t sem!
                if ($sum == 0) {
                    $sum = 1;
                }

                // Százalékok:
                $result_array_[$i]["webshop_%"] = round(100 * ($result_array_[$i]["webshop_db"] / $sum), 2);
                $result_array_[$i]["instagram_%"] = round(100 * ($result_array_[$i]["instagram_db"] / $sum), 2);
                $result_array_[$i]["visszatero_%"] = round(100 * ($result_array_[$i]["visszatero_db"] / $sum), 2);
                $result_array_[$i]["hasznalt_alma_%"] = round(100 * ($result_array_[$i]["hasznalt_alma_db"] / $sum), 2);
                $result_array_[$i]["jofogas_%"] = round(100 * ($result_array_[$i]["jofogas_db"] / $sum), 2);
                $result_array_[$i]["hardverapro_%"] = round(100 * ($result_array_[$i]["hardverapro_db"] / $sum), 2);
                $result_array_[$i]["facebook_%"] = round(100 * ($result_array_[$i]["facebook_db"] / $sum), 2);
            }


            break;
        case
        "guaman_salesplatformreportpartner":
            $CI =& get_instance();
            $result_array_ = array();

            $report_partner = array();
            $full_array = $CI->Database_model->get_table("*", "guaman_sales", "id", "ASC");
            foreach ($full_array as $key => $value) {
                if ($full_array[$key]["type"] == "Partner") {
                    $report_partner[] = $full_array[$key];
                }
            }
            for ($current_month = 1; $current_month <= 12; $current_month++) {
                $i = $current_month - 1;
                $result_array_[$i]["honap"] = $current_month;
                $result_array_[$i]["id"] = $current_month;

                $result_array_[$i]["webshop_db"] = 0;
                $result_array_[$i]["instagram_db"] = 0;
                $result_array_[$i]["visszatero_db"] = 0;
                $result_array_[$i]["hasznalt_alma_db"] = 0;
                $result_array_[$i]["jofogas_db"] = 0;
                $result_array_[$i]["hardverapro_db"] = 0;
                $result_array_[$i]["facebook_db"] = 0;

                foreach ($report_partner as $row) {
                    if (trim_month(get_month($row["beszer_datum"])) == $current_month) {
                        switch (strtolower($row["platform"])) {
                            case "ws":
                                $result_array_[$i]["webshop_db"]++;
                                break;
                            case "ig":
                                $result_array_[$i]["instagram_db"]++;
                                break;
                            case "vt":
                                $result_array_[$i]["visszatero_db"]++;
                                break;
                            case "ha":
                                $result_array_[$i]["hasznalt_alma_db"]++;
                                break;
                            case "jf":
                                $result_array_[$i]["jofogas_db"]++;
                                break;
                            case "hr":
                                $result_array_[$i]["hardverapro_db"]++;
                                break;
                            case "fb":
                                $result_array_[$i]["facebook_db"]++;
                                break;

                        }
                    }

                }


                // Összegzés:
                $sum =
                    $result_array_[$i]["webshop_db"] +
                    $result_array_[$i]["instagram_db"] +
                    $result_array_[$i]["visszatero_db"] +
                    $result_array_[$i]["hasznalt_alma_db"] +
                    $result_array_[$i]["jofogas_db"] +
                    $result_array_[$i]["hardverapro_db"] +
                    $result_array_[$i]["facebook_db"];

                // 0-val nem osztunk még 0-t sem!
                if ($sum == 0) {
                    $sum = 1;
                }

                // Százalékok:
                $result_array_[$i]["webshop_%"] = round(100 * ($result_array_[$i]["webshop_db"] / $sum), 2);
                $result_array_[$i]["instagram_%"] = round(100 * ($result_array_[$i]["instagram_db"] / $sum), 2);
                $result_array_[$i]["visszatero_%"] = round(100 * ($result_array_[$i]["visszatero_db"] / $sum), 2);
                $result_array_[$i]["hasznalt_alma_%"] = round(100 * ($result_array_[$i]["hasznalt_alma_db"] / $sum), 2);
                $result_array_[$i]["jofogas_%"] = round(100 * ($result_array_[$i]["jofogas_db"] / $sum), 2);
                $result_array_[$i]["hardverapro_%"] = round(100 * ($result_array_[$i]["hardverapro_db"] / $sum), 2);
                $result_array_[$i]["facebook_%"] = round(100 * ($result_array_[$i]["facebook_db"] / $sum), 2);

            }
            break;
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

