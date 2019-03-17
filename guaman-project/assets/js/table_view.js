$(document).ready(function () {
});


function loadTable(table_name) {
	$.getJSON(base_url + "database/get_table/" + table_name + "/1/desc", function (data) {
		$("#data-table").dataTable().remove();
		$("#table-container").html("");
		html = "<table class=\"table table\" id=\"data-table\" >";
		console.log(data);
		html += "<thead><tr>";
		html += "<tr>";
		console.log(data[0]);

		Object.keys(data[0]).forEach(function (k) {
			html += "<th>" + data[0][k] + "</th>";
		});

		html += "</tr>";

		html += "</tr></thead>";

		html += "<tbody>";
		for (var i = 1; i < data.length; i++) {
			html += "<tr>";
			console.log(data[i]);

			Object.keys(data[i]).forEach(function (k) {
				html += "<td class='data-cell-container' data-id='" + (data[i]["id"]) + "' data-row='" + (i - 1) + "' data-column='" + data[0][k] + "'><input type='text' class='form-control data-cell' value='" + data[i][k] + "'><span hidden>" + data[i][k] + "</span></td>";
			});

			html += "</tr>";
		}
		html += "</tbody></table>";
		html += "<div class=\'float-right\'>\n    <a href=\"#\" class=\"btn btn-primary btn-icon-split\" style=\'margin-top: 20px;\'>\n        <span class=\'icon\'>\n            <i class=\"fas fa-plus\"></i>\n        </span>\n        <span class=\'text\'>\n            Új hozzáadása\n        </span>\n    </a>\n</div>\n\n";

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
