var output = "";

$(document).ready(function () {
    output += "<ul id='table-list' class='jsl-open table-list'>";
    tree("", 0);
    output += "</ul>";

    $("#table-list-container").html(output);

    JSLists.applyToList('table-list', 'ALL');
});


function loadTable(table_name, openMenu = true) {
    if (openMenu) {

    }

    $.getJSON(base_url + "database/get_table/" + table_name + "/1/desc", function (data) {
            $.post(base_url + "permissions/has_permission/" + table_name + "_table_edit", function (canEdit) {


                if (nonEditableTables.includes(table_name)) {
                    canEdit = false;
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
                    html += "<button class=\'btn btn-primary mt-1\' onclick=\'insertRow(\"" + table_name + "\")\'><i class=\"fas fa-plus\"></i> " + lang.new_row_button + "</button>\n    ";
                }
                html += "<button class=\'btn btn-primary mt-1\' onclick=\'loadTable(\"" + table_name + "\", false)\'><i class=\"fas fa-redo\"></i> " + lang.reload_page_button + "</button>";
                html += "\n<a type=\"button\" class=\"btn btn-success excel-btn mt-1\"><i class=\"fas fa-file-download\"></i> " + lang.excelexport + "</a>";
                html += "\n</div>";


                html += "<table  class=\"table table\" id=\"data-table\" >";

                // Display table headers
                html += "<thead><tr>";
                for (let i = 0; i < column_nice_names.length; i++) {
                    html += "<th>" + column_nice_names[i] + "</th>";
                }
                if (canEdit) {
                    html += "<th>" + lang.actions + "</th>";
                }
                html += "</tr></thead>";

                html += "<tbody>";
                for (let i = 1; i < data.length; i++) {
                    html += "<tr>";
                    for (let k = 0; k < columns.length; k++) {
                        if (data[i][columns[k]] === undefined) {
                            data[i][columns[k]] = "";
                        }


                        html += "<td class='data-cell-container' data-id='" + (data[i]["id"]) + "' data-row='" + (i - 1) + "' data-column='" + columns[k] + "'>";

                        html += getCellBody(data[i][columns[k]], col_types[k], canEdit);

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
                        language: data_table_strings,
                        dom: 'Bfrtip',
                        buttons: [
                            'copyHtml5',
                            'excelHtml5',
                            'csvHtml5',
                            'pdfHtml5'
                        ]
                    });

                    $("#data-table").parent().css("overflow-x", "scroll");

                    $("#data-table-column").css("visibility", "visible");
                    ExcelReport();
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

                    newValue = getBackData(newValue, col_types[col_id]);
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


function isNumeric(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}
function ExcelReport() {
    var tab_text = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
    tab_text = tab_text + '<head><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>';
    tab_text = tab_text + '<x:Name>Test Sheet</x:Name>';
    tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
    tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>';
    tab_text = tab_text + "<table border='1px'>";

//get table HTML code
    tab_text = tab_text + $('#data-table').html();
    tab_text = tab_text + '</table></body></html>';
    var data_type = 'data:application/vnd.ms-excel';

    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE ");
    console.log(tab_text);
    //For IE
    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
        if (window.navigator.msSaveBlob) {
            var blob = new Blob([tab_text], {type: "application/csv;charset=utf-8;"});
            navigator.msSaveBlob(blob, 'Test file.xls');
        }
    }
//for Chrome and Firefox
    else {
        $('#download-in-excel-button').attr('href', data_type + ', ' + encodeURIComponent(tab_text));
        $('#download-in-excel-button').attr('download', 'Test file.xls');
    }
}

