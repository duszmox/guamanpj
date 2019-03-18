
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

	var lang = {"reload_page_button": "Frissítés", "new_row_button": "Új sor hozzáadás"};

	var base_url = "<?php echo base_url(); ?>";


	var folders = <?php echo json_encode($folder_array); ?>;
	var tables = <?php echo json_encode($table_array); ?>;


</script>

<style>
	#table-list-container ul {
		list-style-type: none;
	}

	#table-list-container li {
		cursor: pointer;
	}

	#data-table input {
		min-width: 100px !important;
	}

	#table-list-container ul, #table-list-container ul > ul {
		margin-left: 1em;
		padding-left: 1em;
		list-style-position: inside;
	}
</style>

<script async src="<?php echo js_url("table_view.js"); ?>"></script>
