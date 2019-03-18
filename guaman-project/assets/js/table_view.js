var output = "";

$(document).ready(function () {
	output += "<ul id='table-list' class='jsl-open table-list'>";
	tree("", 0);
	output += "</ul>";

	$("#table-list-container").html(output);

	JSLists.applyToList('table-list', 'ALL');
});


function loadTable(table_name) {
	$.getJSON(base_url + "database/get_table/" + table_name + "/1/desc", function (data) {
		$("#data-table").dataTable().remove();
		$("#table-container").html("");

		html = "";
		html += "<div class=\'my-4\'>\n    <button class=\'btn btn-primary\' onclick=\'insertRow()\'><i class=\"fas fa-plus\"></i> " + lang.new_row_button + "</button>\n    <button class=\'btn btn-primary\' onclick=\'loadTable(\"" + table_name + "\")\'><i class=\"fas fa-redo\"></i> " + lang.reload_page_button + "</button>\n</div>";

		html += "<table class=\"table table\" id=\"data-table\" >";

		console.log(data);
		html += "<thead><tr>";
		html += "<tr>";
		console.log(data[0]);


		columns = [];
		column_nice_names = [];

		Object.keys(data[0]).forEach(function (k) {
			columns.push(k);
			column_nice_names.push(data[0][k]);
		});

		console.log(columns);
		console.log(column_nice_names);

		for (var i = 0; i < column_nice_names.length; i++) {
			html += "<th>" + column_nice_names[i] + "</th>";
		}

		html += "</tr>";

		html += "</tr></thead>";

		html += "<tbody>";
		for (var i = 1; i < data.length; i++) {
			html += "<tr>";
			console.log(data[i]);

			for (var k = 0; k < columns.length; k++) {
				html += "<td class='data-cell-container' data-id='" + (data[i]["id"]) + "' data-row='" + (i - 1) + "' data-column='" + columns[k] + "'><input type='text' class='form-control data-cell' value='" + data[i][columns[k]] + "'><span hidden>" + data[i][columns[k]] + "</span></td>";
			}

			html += "</tr>";
		}
		html += "</tbody></table>";

		console.log(html);
		$("#table-container").html(html);
		setTimeout(function () {
			$("#data-table").DataTable({
				language: data_table_strings
			});

			$("#data-table").parent().css("overflow-x", "scroll");
		}, 1);


		$(".data-cell-container").focusout(function () {
			newValue = $(this).children().eq(0).val();
			update_table_field(table_name, $(this).data("column"), $(this).data("id"), newValue);
		});

	})
		.done(function () {
			console.log("success");
		})
		.fail(function () {
			console.log("error");
		})
}

/**
 *
 * @param table_name string
 * @param column string
 * @param id int
 * @param newValue string
 */
function update_table_field(table_name, column, id, newValue) {
	$.post(base_url + "database/update_field", {
		table_name: table_name,
		column: column,
		id: id,
		value: newValue
	}, function (data) {
		console.log(data);
	})
}

function hasThisAsParentFolder(needle, haystack) {
	for (var i = 0; i < haystack.size; i++) {
		if (needle === haystack[i].parent_folder) {
			return true;
		}
	}
	return false;
}

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
	for (var a = 0; a < tables.length; a++) {
		if (current_folder_id === tables[a].parent_folder) {
			output += '<li onclick="loadTable(\'' + tables[a].table_name + '\')"><i class="fa fa-file-text-o" aria-hidden="true"></i> <i class=\'fas fa-database\'></i> ' + tables[a].table_title + "</li>";
		}
	}

	if (level !== 0) {
		output += "</ul>";
		output += "</li>";
	}

}

