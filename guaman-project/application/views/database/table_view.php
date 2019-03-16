
<div class="row">
	<div class="col-sm-8">
		<div class="card">
			<div class="card-body">

				<div class="responsive-table" id="table-container">

				</div>

			</div>
		</div>
	</div>
	<div class="col-sm-4">
		<div class="card">
			<div class="card-header">
				<h2><?php echo lang("tables_label"); ?></h2>
			</div>
			<div class="card-body" id="table-list-container">
				...
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

	var output = "<ul id='table-list' class='jsl-open table-list'>";

	function get_folder_title_by_id(folder_id) {
		for (var i = 0; i < folders.length; i++) {
			if (folders[i].id === folder_id) {
				return folders[i].folder_title;
			}
		}
		return "";
	}

	function tree(current_folder_id, level) {
		if (level !== 0) {
			output += "<li>";
			output += '<i class="fa fa-folder-o" aria-hidden="true"></i>';
			output += "<i class=\"fas fa-folder\"></i> <b>" + get_folder_title_by_id(current_folder_id) + "</b>";

			// Ha a current_folder egy foldernek a parentje:
			output += "<ul class='table-list'>";
		}
		for (var i = 0; i < folders.length; i++) {
			if (current_folder_id === folders[i].parent_folder) {
				tree(folders[i].id, level + 1);
			}
		}


		// Ha a current_folder egy table-nek a parentje:
		for (var i = 0; i < tables.length; i++) {
			if (current_folder_id === tables[i].parent_folder) {
				output += '<li onclick="loadTable(\'' + tables[i].table_name + '\')"><i class="fa fa-file-text-o" aria-hidden="true"></i> <i class=\'fas fa-database\'></i> ' + tables[i].table_title + "</li>";
			}
		}

		if (level !== 0) {
			output += "</ul>";
			output += "</li>";
		}

	}

	tree("", 0);

	output += "</ul>";
	$("#table-list-container").html(output);

	JSLists.applyToList('table-list', 'ALL');
</script>

<style>
	#table-list-container ul {
		list-style-type: none;
	}
</style>

<script async src="<?php echo js_url("table_view.js"); ?>"></script>
