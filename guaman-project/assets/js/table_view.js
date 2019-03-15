$(document).ready(function () {
	$("#table-data").DataTable();

});


function loadTable(baseUrl, table_name) {
	$.getJSON(baseUrl + "database/get_table/" + table_name + "/1/desc", function (data) {
		$("#table-container").html("");
		html = "<table class=\"table table\" id=\"data-table\" >";
		console.log(data);
		html += "<thead><tr>";
		for (var i = 0; i < data.length; i++) {
			html += "<th>hello</th>";
		}
		html += "</tr></thead>";
		html += "<tbody>";
		for (var i = 0; i < data.length; i++) {
			html += "<tr>";
			console.log(data[i]);

			Object.keys(data[i]).forEach(function (k) {
				html += "<td>" + data[i][k] + "</td>";
			});

			html += "</tr>";
		}
		html += "</tbody></table>";

		console.log(html);
		$("#table-container").html(html);
		$("#data-table").DataTable();

	})
		.done(function () {
			console.log("success");
		})
		.fail(function () {
			console.log("error");
		})
}
