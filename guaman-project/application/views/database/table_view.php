<div class="row">
	<div class="col-sm-8">
		<div class="card">
			<div class="card-body">
				<div class="responsive-table" id="table-container">

				</div>
			</div>
		</div>
	</div>
    <script>
        function openFolder(folder_name) {
            //todo jQuery: Nyissa ki a folder, minden childnak tegye a display-ét visible-vé none-ról. Emellett az onclick folder, az legyen closeFolder(), és a .html-jében pedig változtassa meg az ikont, <i class="fa fa-angle-up"></i>, visible, és invisible classok létrehozva
            if (folder_name !== "main") {
                $('.' + folder_name).addClass('visible').removeClass('invisible').attr("onclick", "closeFolder(folder_name)");
            }
        }

        function closeFolder() {
            //todo display = none, jQuery
            if (folder_name !== "main") {
                $('.' + folder_name).addClass('invisible').removeClass('visible').attr("onclick", "openFolder(folder_name)");
            }
        }
    </script>

	<div class="col-sm-4">
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered" width="100%" cellspacing="0">
						<?php
						foreach ($table_array as $key => $table) {
							echo "<tr>";
							/*foreach ($table as $key => $value) {
                                echo "<td>" . $value . "</td>";
                            }*/
							echo "<td class='" . $table["parent_folder"] . " invisible'onclick='loadTable(\"" . $table["table_name"] . "\")'>" .
								"<i class='fas fa-database'></i> " . $table["table_title"] .
								"</td>";
							echo "</tr>";
						}
                        foreach ($folder_array as $key => $folder) {
                            echo "<tr><div class=''>\n";
                            /*foreach ($table as $key => $value) {
                                echo "<td>" . $value . "</td>";
                            }*/
                            echo "<td class='" . $folder["parent_folder"] . "' onclick='openFolder(\"" . $folder["folder_name"] . "\")'>\n" .
                                "<i class='fas fa-folder'></i> " . $folder["folder_title"] . "  <i class=\"fa fa-angle-down\"></i>\n".
                                "</td>\n";
                            echo "</tr>\n";
                        }
						?>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	var data_table_strings = {
		processing:     "<?php echo lang("processing_message");?>",
		search:         "<?php echo lang("searcher_message");?>",
		lengthMenu:    "<?php echo lang("shown_pages_start_message")."_MENU_".lang("shown_pages_end_message");?>",
		info:           "",
		infoEmpty:      "",
		infoFiltered:   "",
		infoPostFix:    "",
		loadingRecords: "<?php echo lang("records_loading_message");?>",
		zeroRecords:    "<?php echo lang("records_zero_message");?>",
		emptyTable:     "<?php echo lang("empty_table_message");?>",
		paginate: {
			first:      "<?php echo lang("first_page_message");?>",
			previous:   "<?php echo lang("previous_page_message");?>",
			next:       "<?php echo lang("next_page_message");?>",
			last:       "<?php echo lang("last_page_message");?>"
		},
		aria: {
			sortAscending:  "<?php echo lang("asc_table_message");?>",
			sortDescending: "<?php echo lang("desc_table_message");?>"
		}
	};

	var base_url = "<?php echo base_url(); ?>";
</script>

<script async src="<?php echo js_url("table_view.js"); ?>"></script>
