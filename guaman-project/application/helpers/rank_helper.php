<?php

class Ranks{
    public static $LOGGED_OUT = -1;
    public static $LOGGED_IN = 0;
    public static $ADMIN = 1;

    public static function get_nice_name($rank)
    {
        switch ($rank){
            case -1:
                return lang("rank_logged_out");
                break;
            case 0:
                return lang("rank_logged_in");
                break;
            case 1:
                return lang("rank_admin");
                break;
            default:
                return "";
        }
    }
}

/**
 * @param $min_rank int The lowest rank for accessing the page
 */
function require_rank($min_rank){
    if(Account_model::$rank < $min_rank) {
        if($min_rank == Ranks::$ADMIN){
            js_alert("Az oldal megtekintéséhez nincs engedélyed.", base_url("account/login"));

        }
        else if($min_rank == Ranks::$LOGGED_IN){
            js_alert("Az oldal megtekintéséhez be kell jelentkezned.", base_url("account/login"));
        }
        die();
    }
}

