$(document).ready(function () {

});


function loadTable(baseUrl, table_name) {
	$.getJSON(baseUrl + "database/get_table/" + table_name + "/1/desc", function (data) {
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
				html += "<td><input type='text' class='form-control' value='" + data[i][k] + "'><span class='data-cell'>" + data[i][k] + "</span></td>";
			});

			html += "</tr>";
		}
		html += "</tbody></table>";

		console.log(html);
		$("#table-container").html(html);
		setTimeout(function() {
			$("#data-table").DataTable({
				language: data_table_strings
			});
		}, 1);

	})
		.done(function () {
			console.log("success");
		})
		.fail(function () {
			console.log("error");
		})
}

function update_table_field(tablename, column, id, newValue) {

}
