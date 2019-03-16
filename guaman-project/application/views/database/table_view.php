<style>

</style>
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
		function openFolder(folder_name, current_folder) {
			//todo jQuery: Nyissa ki a folder, minden childnak tegye a display-ét visible-vé none-ról. Emellett az onclick folder, az legyen closeFolder(), és a .html-jében pedig változtassa meg az ikont, <i class="fa fa-angle-up"></i>, visible, és invisible classok létrehozva
			//todo minden táblához hozzá lett adva egy parentfoler_ tag, és a folder neve.
			//todo a mappákat is tegye bele a parentfolderbe, és csak a MAIN maradjon kint
		}

		function closeFolder() {
			//todo display = none, jQuery

		}
	</script>

	<div class="col-sm-4">
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered" width="100%" cellspacing="0">
						<?php
						/*
						foreach ($table_array as $key => $table) {
							echo "<tr>";
							/*foreach ($table as $key => $value) {
                                echo "<td>" . $value . "</td>";
                            }
							echo "<td class='parentfolder_" . $table["parent_folder"] . " 'onclick='loadTable(\"" . $table["table_name"] . "\")'>" .
								"<i class='fas fa-database'></i> " . $table["table_title"] .
								"</td>";
							echo "</tr>";
						}
						foreach ($folder_array as $key => $folder) {
							echo "<tr><div class='folder_" . $folder["folder_name"] . "'>\n";
							/*foreach ($table as $key => $value) {
                                echo "<td>" . $value . "</td>";
                            }
							echo "<td  onclick='openFolder(\"" . $folder["folder_name"] . "\"'>\n" .
								"<i class='fas fa-folder'></i> " . $folder["folder_title"] . "  <i class=\"fa fa-angle-down\"></i>\n" .
								"</td>\n";
							echo "</div></tr>\n";
						}*/


						?>
						<script>
							var folders = <?php echo json_encode($folder_array); ?>;
							var tables = <?php echo json_encode($table_array); ?>;

							function hasThisAsParentFolder(needle, haystack) {
								for (var i = 0; i < haystack.size; i++) {
									if (needle === haystack[i].parent_folder) {
										return true;
									}
								}
								return false;
							}

							var output = "";

							function tree(current_folder, level) {

								for (var i = 0; i < level; i++) {
									output += "-";
								}
								output += " " + current_folder;
								// Ha a current_folder egy foldernek a parentje:
								for (var i = 0; i < folders.length; i++) {
									if (current_folder === folders[i].parent_folder) {
										tree(folders[i].parent_folder, level + 1);
									}
								}

								// Ha a current_folder egy table-nek a parentje:
								/*for (var i = 0; i < folders.length; i++) {
									if (current_folder === tables[i].parent_folder) {
										tree(folders[i].parent_folder, level + 1);
									}
								}*/

							}
							//tree("", 1);
							//console.log(output);
						</script>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	var data_table_strings = {
		processing: "<?php echo lang("processing_message");?>",
		search: "<?php echo lang("searcher_message");?>",
		lengthMenu: "<?php echo lang("shown_pages_start_message") . "_MENU_" . lang("shown_pages_end_message");?>",
		info: "",
		infoEmpty: "",
		infoFiltered: "",
		infoPostFix: "",
		loadingRecords: "<?php echo lang("records_loading_message");?>",
		zeroRecords: "<?php echo lang("records_zero_message");?>",
		emptyTable: "<?php echo lang("empty_table_message");?>",
		paginate: {
			first: "<?php echo lang("first_page_message");?>",
			previous: "<?php echo lang("previous_page_message");?>",
			next: "<?php echo lang("next_page_message");?>",
			last: "<?php echo lang("last_page_message");?>"
		},
		aria: {
			sortAscending: "<?php echo lang("asc_table_message");?>",
			sortDescending: "<?php echo lang("desc_table_message");?>"
		}
	};

	var base_url = "<?php echo base_url(); ?>";
</script>

<script async src="<?php echo js_url("table_view.js"); ?>"></script>
