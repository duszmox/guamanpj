<?php
/**
 * Created by PhpStorm.
 * User: Fazekas RoboTeam
 * Date: 3/17/2019
 * Time: 9:44 PM
 */
function custom_db_actions($table_name, $result_array, $column_names)
{

	switch ($table_name) {
		case "guaman_social":
			foreach ($result_array as $key => $row) {
				// update $row["bevetel"] ;
			}

			break;


	}


	return $result_array;
}
