var output = "";

var filters;
var previousTableName = "";
var TABLE_NAME = undefined;

var columns = [];
var column_nice_names = [];
var col_types = [];

var filterTypes = [
    {
        name: "checkbox",
        niceName: "Jelölőnégyzetes" // TODO lang
    },
    {
        name: "select",
        niceName: "Lenyíló lista" // TODO lang
    }
];

const Toast = Swal.mixin({
    toast: true,
    position: 'bottom-end',
    showConfirmButton: false,
    timer: 3000
});


$(document).ready(function () {
    output += "<ul id='table-list' class='jsl-open table-list'>";
    tree("", 0);
    output += "</ul>";

    $("#table-list-container").html(output);

    JSLists.applyToList('table-list', 'ALL');
});

function sidebarNav(pressedButton) {
    if (pressedButton === "filters") {
        if ($("#filters-container-o").is(":visible")) {
            $("#filters-container-o").hide();
        } else {
            $("#sidebar-body").show();

            $("#show-filters-btn").removeClass("btn-outline-custom");
            $("#show-table-list-btn").addClass("btn-outline-custom");

            $("#filters-container-o").show();
            $("#table-list-container-o").hide();
        }
    } else if (pressedButton === "tables") {
        if ($("#table-list-container-o").is(":visible")) {
            $("#table-list-container-o").hide();
        } else {
            $("#sidebar-body").show();

            $("#show-filters-btn").addClass("btn-outline-custom");
            $("#show-table-list-btn").removeClass("btn-outline-custom");

            $("#table-list-container-o").show();
            $("#filters-container-o").hide();
        }
    }
    if ($("#filters-container-o").is(":hidden") && $("#table-list-container-o").is(":hidden")) {
        $("#sidebar-body").hide();
    }
}


function closeRightSidebar() {
    $("#filters-container-o").hide();
    $("#table-list-container-o").hide();
    $("#sidebar-body").hide();

    $("#show-table-list-btn").removeClass("btn-outline-custom");
    $("#show-filters-btn").removeClass("btn-outline-custom");
}

$(window).click(function () {
    closeRightSidebar();
});

$("#sidebar-right").click(function (event) {
    event.stopPropagation();
});


/**
 *
 * @param tableName
 * @returns filters
 */
function getFiltersByTable(tableName) {
    filters = undefined;
    $.ajax({
        type: 'POST',
        url: base_url + "database/get_filters/" + tableName,
        success: function (data) {
            filters = data;
        },
        async: false
    }).fail(function () {
        internetConnectionProblemAlert();
    });
    if (filters === undefined) internetConnectionProblemAlert();
    return filters;
}

function internetConnectionProblemAlert() {
    Toast.fire({
        type: 'error',
        title: 'Ellenőrizd az internetkapcsolatot!' // TODO lang
    });
}

function generateHTMLCheckboxInput(options, filterName) {
    var out = "";
    for (let i = 0; i < options.length; i++) {
        out += "<div class='checkbox-input-container'>";

        out += "<span class='checkbox-label'>" + options[i].niceName + "</span> ";
        out += "<input type='checkbox' name='" + filterName + "_" + options[i].name + "' id='" + filterName + "_" + options[i].name + "' checked>";

        out += "</div>";
    }
    return out;
}

function getHTMLFilterInputs(table_name) {
    if (filters === undefined) return;
    if (filters.error !== undefined) {
        alert(filters.error);
        return;
    }

    let html = "";

    // filter: niceName, name, column
    for (let i = 0; i < filters.length; i++) {
        if (filters[i] === undefined) continue;

        // CUSTOM CUCC
        html += "<div class='filter-container'>";
        switch (filters[i].type) {
            case "money":
                html += filters[i].niceName + ": " + generateHTMLSelect([
                    {
                        "name": "greater_than",
                        "niceName": ">"
                    },
                    {
                        "name": "less_than",
                        "niceName": "<"
                    },
                    {
                        "name": "equal_to",
                        "niceName": "="
                    }
                ], filters.name);

                break;
            case "checkbox":
                html += "<fieldset><legend>" + filters[i].niceName + "</legend>";
                html += generateHTMLCheckboxInput(filters[i].customData.options, filters[i].name);
                html += "</fieldset>";
        }
        html += "</div>";

    }

    html += "<button class='btn btn-primary mt-2' onclick='loadTable(\"" + table_name + "\", true)'><i class=\"fas fa-sliders-h\"></i> Szűrés<!-- TODO LANG --></button>";
    return html;
}

/**
 * input data: [{name: ""}, niceName: ""]
 * id: elect tag's id
 */

function generateHTMLSelect(data, htmlId) {
    let out = "<select class='form-control d-inline-block w-auto' id='" + htmlId + "' name='" + htmlId + "'>";
    for (let i = 0; i < data.length; i++) {
        out += "<option name='" + data[i].name + "' id='" + data[i].name + "'>" + data[i].niceName + "</option>";
    }
    out += "</select>";
    return out;
}

function getPHPFiltersFromHTML() {
    // CUSTOM CUCC
    let phpFilters = [];

    for (let i = 0; i < filters.length; i++) {
        let phpFilter = {};

        phpFilter.type = filters[i].type;
        phpFilter.column = filters[i].column;
        switch (filters[i].type) {
            case "checkbox":
                phpFilter.name = filters[i].name;
                phpFilter.checkedOptions = getCheckedOptions(filters[i]);
                break;
        }

        phpFilters.push(phpFilter);
    }

    return phpFilters;
}

/**
 * Gets checked option names (e.g.: hasznalt, gadget, stb)
 * @param filter
 */
function getCheckedOptions(filter) {
    let checkedOptions = [];
    for (let i = 0; i < filter.customData.options.length; i++) {
        let id = filter.name + "_" + filter.customData.options[i].name;
        let isChecked = $("#" + id).is(":checked");
        if (isChecked) {
            checkedOptions.push(filter.customData.options[i].name);
        }
    }
    return checkedOptions;
}

function loadTable(table_name) {

    TABLE_NAME = table_name;

    // Load filter inputs when you changed table
    if (previousTableName !== table_name) {
        getFiltersByTable(table_name);
        $("#filter-container").html(getHTMLFilterInputs(table_name));
    }
    previousTableName = table_name;


    // Get filters
    let phpFilters = [];
    if (filters !== undefined && filters.length !== 0) {
        phpFilters = getPHPFiltersFromHTML();
        console.log("Na itt vannak: " + phpFilters);
    }

    var rawData;

    $.post(base_url + "database/get_table/" + table_name + "/1/desc", {"filters": phpFilters}, function (data) {
            $.post(base_url + "permissions/has_permission/" + table_name + "_table_edit", function (canEdit) {
                console.log(data);

                rawData = data;

                if (nonEditableTables.includes(table_name)) {
                    canEdit = false;
                }

                console.log(table_name);

                columns = [];
                column_nice_names = [];
                col_types = [];

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
                    html += "<button class=\'btn btn-primary mt-1\' onclick=\'insertRow(\"" + table_name + "\")\'><i class=\"fas fa-plus\"></i> " + lang.add_row_button_title + "</button>\n    ";
                }
                html += "\n</div>";

                html += "<table class=\"table table\" id=\"data-table\" >";
                // Display table headers
                html += "<thead><tr>";
                for (let i = 0; i < column_nice_names.length; i++) {
                    html += "<th>" + column_nice_names[i] + "</th>";
                }
                if (canEdit) {
                    html += "<th>" + lang.actions_button_title + "</th>";
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
                        html += "<td><button onclick='moveRow(\"" + table_name + "\", \"" + data[i]["id"] + "\")' class='btn btn-primary'>" + lang.move_row_title + "</button></td>";
                    }
                    html += "</tr>";
                }
                html += "</tbody></table>";


                var exportOptions = {
                    format: {
                        body: function (data, row, column, node) {
                            return rawData[row + 1][columns[column]];
                        }
                    }
                };

                $("#table-container").html(html);
                setTimeout(function () {
                    $("#data-table").DataTable({
                        language: data_table_strings,
                        dom:
                            "<'row'<'col-sm-12'B>>" +
                            "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                            "<'row'<'col-sm-12'tr>>" +
                            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                        //'Bflrtip',
                        scrollX: true,
                        buttons: [
                            {
                                text: "<i class=\"fas fa-redo\"></i> " + lang.reload_page_button_title,
                                action: function (e, dt, node, config) {
                                    loadTable(table_name);
                                },
                                className: "btn btn-primary"
                            },
                            {
                                text: "<i class=\"fas fa-copy\"></i> Vágólap",
                                extend: 'copyHtml5',
                                className: "btn btn-primary",
                                exportOptions: exportOptions
                            },
                            {
                                text: "<i class=\"fas fa-file-excel\"></i> Excel",
                                extend: 'excelHtml5',
                                className: "btn btn-primary",
                                exportOptions: exportOptions
                            },
                            {
                                text: "<i class=\"fas fa-file-csv\"></i> CSV",
                                extend: 'csvHtml5',
                                className: "btn btn-primary",
                                exportOptions: exportOptions
                            },
                            {
                                text: "<i class=\"fas fa-file-pdf\"></i> PDF",
                                extend: 'pdfHtml5',
                                className: "btn btn-primary",
                                exportOptions: exportOptions
                            }
                        ]
                    });

                    $("#data-table").parent().css("overflow-x", "scroll");

                    $("#data-table-column").css("visibility", "visible");
                    $(".buttons-html5").addClass("btn btn-primary")
                }, 1);

                $(".data-cell-container").focusout(function () {
                    let newValue = $(this).children().eq(0).val();
                    let column = $(this).data("column");
                    let row = $(this).data("row");

                    let col_id;
                    for (let b = 0; b < columns.length; b++) {
                        if (columns[b] === column) {
                            col_id = b;
                            break;
                        }
                    }

                    newValue = getBackData(newValue, col_types[col_id]);
                    update_table_field(table_name, column, $(this).data("id"), newValue);
                    rawData[row + 1][column] = newValue;
                });


            })
                .done(function () {
                    console.log("success");

                    closeRightSidebar();
                })
                .fail(function () {
                    alert("Please check your internet connection!"); // TODO lang
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
    }).done(function () {
        Toast.fire({
            type: 'success',
            title: 'Sikeres mentés' // TODO lang
        })
    }).fail(function () {
        internetConnectionProblemAlert()
    })
}

function moveRow(tableName, rowId) {
    console.log(tableName + " " + rowId);


    $.getJSON(base_url + "database/get_compatible_tables/" + tableName, {}, function (data) {
        if (data.error !== undefined) {
            Swal.fire({
                type: "error",
                "titleText": "Upsz...", // TODO lang
                "text": data.error
            })
        } else {
            let options = {};
            for (let i = 0; i < data.length; i++) {
                options[data[i].table_name] = data[i].table_title;
            }
            Swal.fire({
                titleText: "Áthelyezés", // TODO lang
                text: "Sor áthelyezése ebbe a táblába:",
                showCancelButton: true,
                type: "question",
                cancelButtonColor: '#d33',
                cancelButtonText: "Mégsem",
                confirmButtonText: 'Áthelyezés',
                input: 'select',
                inputOptions: options,
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.post(base_url + "database/move_row/", {
                        fromTable: tableName,
                        toTable: result.value,
                        rowId: rowId
                    })
                        .done(function (data) {
                            if (data === "success") {
                                loadTable(tableName);
                                Toast.fire({
                                    type: "success",
                                    title: "Sikeres áthelyezés" // TODO lang
                                });
                            } else if (data.error !== undefined) {
                                Toast.fire({
                                    type: "error",
                                    title: data.error
                                });
                                loadTable(tableName);
                            }
                        })
                        .fail(function () {
                            internetConnectionProblemAlert()
                        });
                }
            })
        }
    })
        .fail(function () {
            internetConnectionProblemAlert()
        });


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
        console.log("DATA=" + data);
        if (data === " success") {
            Toast.fire({
                type: 'success',
                title: 'Sor hozzáadva' // TODO lang
            });
        } else if (data.error !== undefined) {
            Toast.fire({
                type: 'error',
                title: data.error
            })
        }

    })
        .fail(function () {
            internetConnectionProblemAlert()
        })
        .always(function () {
            loadTable(table_name);
        });
}


function isNumeric(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}

function editFilters() {
    if (TABLE_NAME === undefined) {
        Swal.fire({
            title: "Válassz ki egy táblát!", // TODO lang
            type: "warning"
        });
        return;
    }

    let output = "";
    output += "<div>";

    for (let i = 0; i < filters.length; i++) {
        output += "<div class='row p-2 filter-settings-filter-row' onclick='editFilter(" + i + ")'>";
        output += "<div class='col-8 text-left'><b>" + filters[i].niceName + "</b></div>";
        output += "<div class='col-4 text-right'>" + getNiceFilterTypeName(filters[i].type) + "</div>";
        output += "</div>";
    }
    output += "<div class='row p-2 filter-settings-filter-row'><div class='col-12'><i class=\"fas fa-plus\"></i> Új filter hozzáadása</div></div>"; // TODO lang

    output += "</div>";
    Swal.fire({
        title: "Szűrők szerkesztése", // TODO lang
        html: output
    })
}


function getNiceFilterTypeName(filterTypeName) {
    for (let i = 0; i < filterTypes.length; i++) {
        if (filterTypes[i].name === filterTypeName) return filterTypes[i].niceName;
    }
    return "";
}

function editFilter(filterIndex) {
    filter = filters[filterIndex];


    let output = "";
    output += "<div class='p-3'>";

    output += "<div class='row p-1'>";
    output += "<div class='col-7'><input class='form-control' placeholder='Szűrő neve' name='filter-name' value='" + escapeHtml(filter.niceName) + "' /></div>"; // todo lang
    output += "<div class='col-5'><select class='form-control w-100' name='filter-type' onchange='loadFilterCustomDataFields($(this).val(), " + filterIndex + ")'>";
    for (let i = 0; i < filterTypes.length; i++) {
        let selectedTag = filter.type === filterTypes[i].name ? " selected" : "";
        output += "<option value='" + escapeHtml(filterTypes[i].name) + "'" + selectedTag + ">" + escapeHtml(filterTypes[i].niceName) + "</option>";
    }
    output += "</select></div>";
    output += "</div>";

    output += "<div class='d-flex p-1'>";
    output += "<div class='text-left mr-2 p-1'><span>Szűrt oszlop:</span></div>"; // TODO lang
    output += "<div class='flex-grow-1'><select class='form-control w-100' name='filtered-column'>";
    for (let i = 0; i < columns.length; i++) {


        output += "<option value='" + escapeHtml(columns[i]) + "'>" + escapeHtml(column_nice_names[i]) + "</option>"
    }
    output += "</select></div>";
    output += "</div>";


    output += "<div id='enter-custom-data'></div>";
    output += "</div>";

    Swal.fire({
        title: filter.niceName,
        html: output
    });

    loadFilterCustomDataFields(filter.type, filterIndex);
}

function escapeHtml(unsafe) {
    return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

function loadFilterCustomDataFields(filterType, filterIndex = undefined) {
    let output = "";

    let filter = filters[filterIndex];

    switch (filterType) {
        case "checkbox":
        case "select":
            output += "<div class='row p-2'><div class='col-auto'><label class='text-left'>Értékek:</label></div></div>"; // TODO lang
            output += "<div id='filter-options'>";

            if (filter !== undefined && filter.customData !== undefined && filter.customData.options !== undefined) {
                for (let i = 0; i < filter.customData.options.length; i++) {
                    option = filter.customData.options[i];
                    output += "<div class='row p-1'>";
                    output += "<div class='col-5'><input class='form-control' data-label='optionName' value='" + escapeHtml(option.name) + "'></div>";
                    output += "<div class='col-5'><input class='form-control' data-label='optionNiceName' value='" + escapeHtml(option.niceName) + "'></div>";
                    output += "<div class='col-1'><i style='margin: 50%; cursor: pointer' class=\"far fa-trash-alt c-pointer\"></i></div>";
                    output += "</div>";
                }
            }

            output += "</div>";
            break;
    }
    $("#enter-custom-data").html(output);
}