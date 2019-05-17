var output = "";

$(document).ready(function () {
    output += "<ul id='table-list' class='jsl-open table-list'>";
    tree("", 0);
    output += "</ul>";

    $("#table-list-container").html(output);

    JSLists.applyToList('table-list', 'ALL');
});


function loadTable(table_name, menuOfTables = true) {
    if (menuOfTables) {
        change(document.getElementById('show-or-hide-btn'));
    }

    $.getJSON(base_url + "database/get_table/" + table_name + "/1/desc", function (data) {
            $.post(base_url + "permissions/has_permission/" + table_name + "_table_edit", function (canEdit) {


                switch (canEditTable[table_name]) {
                    case "1":
                        canEdit = false;
                        break;
                    case "0":
                        canEdit = true;

                        break;
                }


                console.log(canEdit);
                console.log(table_name);
                console.log(base_url + "permissions/has_permission/" + table_name + "_table_edit");
                let columns = [];
                let column_nice_names = [];
                let col_types = [];


                Object.keys(data[0]).forEach(function (k) {
                    columns.push(k);
                    column_nice_names.push(data[0][k].nice_name);
                    col_types.push(data[0][k].type);
                });

                $("#data-table").dataTable().remove();
                $("#table-container").html("");
                let html = "";
                html += "<h2>" + get_nice_table_name(table_name) + "</h2>";


                // Load header buttons
                html += "<div class=\'my-4\'>\n    ";
                if (canEdit) {
                    html += "<button class=\'btn btn-primary\' onclick=\'insertRow(\"" + table_name + "\")\'><i class=\"fas fa-plus\"></i> " + lang.new_row_button + "</button>\n    ";
                }
                html += "<button class=\'btn btn-primary\' onclick=\'loadTable(\"" + table_name + "\", false)\'><i class=\"fas fa-redo\"></i> " + lang.reload_page_button + "</button>";
                html += "\n</div>";


                html += "<table class=\"table table\" id=\"data-table\" >";

                // Display table headers
                html += "<thead><tr><tr>";
                for (let i = 0; i < column_nice_names.length; i++) {
                    html += "<th>" + column_nice_names[i] + "</th>";
                }
                if (canEdit) {
                    html += "<th>" + lang.actions + "</th>";
                }
                html += "</tr></tr></thead>";

                html += "<tbody>";
                for (let i = 1; i < data.length; i++) {
                    html += "<tr>";
                    for (let k = 0; k < columns.length; k++) {
                        if (data[i][columns[k]] === undefined) {
                            data[i][columns[k]] = "";
                        }


                        html += "<td class='data-cell-container' data-id='" + (data[i]["id"]) + "' data-row='" + (i - 1) + "' data-column='" + columns[k] + "'>";

                        let cell_body = "";
                        switch (col_types[k]) {
                            case "text":
                                if (canEdit) {
                                    cell_body = "<input type=\"text\" class=\"form-control data-cell\" value=\'" + data[i][columns[k]] + "\'>";
                                    cell_body += "<span hidden>" + data[i][columns[k]] + "</span>";
                                } else {
                                    cell_body = "<span>" + data[i][columns[k]] + "</span>";
                                }
                                break;
                            case "date":
                                if (canEdit) {
                                    cell_body = "<input type=\"date\" class=\"form-control data-cell\" value=\'" + data[i][columns[k]] + "\'>";
                                    cell_body += "<span hidden>" + data[i][columns[k]] + "</span>";
                                } else {
                                    cell_body = "<span>" + data[i][columns[k]] + "</span>";
                                }
                                break;
                            case "money":
                                let cell_value = data[i][columns[k]];
                                if (isNumeric(cell_value)) {
                                    cell_value = numberWithSpaces(cell_value);


                                } else {
                                    cell_value = "0";
                                    data[i][columns[k]] = "0";
                                }


                                if (canEdit) {
                                    // language=HTML
                                    cell_body = "<input type=\"text\" pattern=\'[0-9]|\\s\' value=\'" + cell_value + "\' class=\'form-control\'/>";
                                    cell_body += "<span hidden>" + cell_value + " " + data[i][columns[k]] + "</span>";

                                } else {
                                    cell_body += "<span>" + cell_value + "</span>";
                                    cell_body += "<span hidden>" + cell_value + " " + data[i][columns[k]] + "</span>";
                                }
                                break;
                            default:
                                if (canEdit) {
                                    cell_body = "<input type=\"text\" class=\"form-control data-cell\" value=\'" + data[i][columns[k]] + "\'>";
                                    cell_body += "<span hidden>" + data[i][columns[k]] + "</span>";
                                } else {
                                    cell_body = "<span>" + data[i][columns[k]] + "</span>";
                                }
                        }

                        html += cell_body;

                        html += "</td>";
                    }

                    if (canEdit) {
                        html += "<td><a href='" + base_url + "database/move_row/" + table_name + "/" + data[i]["id"] + "' target='_blank' class='btn btn-primary'>" + lang.move_row_button + "</a></td>";
                    }
                    html += "</tr>";
                }
                html += "</tbody></table>";

                $("#table-container").html(html);
                setTimeout(function () {
                    $("#data-table").DataTable({
                        language: data_table_strings
                    });

                    $("#data-table").parent().css("overflow-x", "scroll");

                    $("#data-table-column").css("visibility", "visible");
                }, 1);

                $(".data-cell-container").focusout(function () {
                    let newValue = $(this).children().eq(0).val();
                    let column = $(this).data("column");

                    let col_id;
                    for (let b = 0; b < columns.length; b++) {
                        if (columns[b] === column) {
                            col_id = b;
                            break;
                        }
                    }

                    switch (col_types[col_id]) {
                        case "money":
                            newValue = newValue.toLowerCase();
                            newValue = newValue.replace(/\s/g, '');
                            newValue = newValue.replace("/ft/g", ""); // TODO (?) global currency
                    }
                    update_table_field(table_name, column, $(this).data("id"), newValue);
                });

            })
                .done(function () {
                    console.log("success");
                })
                .fail(function () {
                    console.log("error");
                })
        }
    )
    ;

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
        //console.log(data);
    })
}

function get_nice_table_name(table_name) {
    for (let i = 0; i < tables.length; i++) {
        if (tables[i].table_name === table_name) return tables[i].table_title;
    }
    return "";
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
    for (let a = 0; a < tables.length; a++) {
        if (current_folder_id === tables[a].parent_folder) {
            output += '<li onclick="loadTable(\'' + tables[a].table_name + '\')"><i class="fa fa-file-text-o" aria-hidden="true"></i> <i class=\'fas fa-database\'></i> ' + tables[a].table_title + "</li>";
        }
    }

    if (level !== 0) {
        output += "</ul>";
        output += "</li>";
    }

}

function insertRow(table_name) {
    $.post(base_url + "database/insert_new_row/" + table_name, function (data) {
        if (data === "success") {
            //alert("ok");
        }/* else {
            alert("Unexpected error. Please contact with the developers! [support@guamanpj.com]");
        }*/
    })/*.fail(function () {
        alert("Unexpected error. Please contact with the developers! [support@guamanpj.com]");
    })*/.always(function () {
        loadTable(table_name);
    });
}

function numberWithSpaces(number) {
    let parts = number.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, " ");
    return parts.join(".");
}

function isNumeric(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}