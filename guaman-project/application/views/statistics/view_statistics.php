<div class="container bg-white shadow p-5">
    <h2 class="d-inline-block">
        <?php /** @var array $statistics */ //TODO BACK TO STAT LIST LINK
        echo $statistics["statistics_name"]; ?>
    </h2>
    <?php
    if (has_permission("edit_stats")) {
        ?>
    <a class='btn btn-info float-right' href='<?php echo base_url("statistics/edit/" . $statistics["id"]); ?>'>
        <i class="fas fa-edit"></i>
        <?php echo lang("statistics_edit"); ?></a><?php
    }
    ?>
    <canvas id="statChart" style="width: 800px; max-width: 100%; height: 500px; max-height: 60vh;"></canvas>
    <div id="statistics-container" class="mt-5 w-auto overflow-auto p-3">

    </div>

</div>

<link rel="stylesheet" type="text/css" href="<?php echo css_url("Chart.min.css"); ?>">

<script src="<?php echo js_url("Chart.bundle.min.js"); ?>"></script>
<script src="<?php echo js_url("data_output_helper.js"); ?>"></script>
<script>
    var colors = [
        "rgb(54, 162, 235)",
        "rgb(75, 192, 192)",
        "rgba(207,20,20)",
        "rgb(255, 159, 64)",
        "rgb(153, 102, 255)",
        "rgb(255, 99, 132)",
        "rgb(255, 205, 86)",
    ];

    var transparentColors = [
        "rgb(54, 162, 235,0.1)",
        "rgb(75, 192, 192,0.1)",
        "rgba(207,20,20,0.1)",
        "rgb(255, 159, 64,0.1)",
        "rgb(153, 102, 255,0.1)",
        "rgb(255, 99, 132,0.1)",
        "rgb(255, 205, 86,0.1)",
    ];

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

    $(document).ready(function () {
        loadTable();
    });
    var base_url = "<?php echo base_url(); ?>";

    var statId = <?php echo $statistics["id"] ?>;
    var statConfig = <?php echo $statistics["statistics_config"]; ?>;
    var statType = <?php echo $statistics["statistics_type"]; ?>;

    var column_names = [];
    var nice_column_names = [];
    var col_types = [];

    function loadTable() {
        var ctx = $('#statChart');

        $.post(base_url + "statistics/get_source_table/" + statId)
            .done(function (data) {
                if (data.error !== undefined) {
                    alert(data.error);
                } else {
                    console.log(data);


                    Object.keys(data.columns).forEach(function (k) {
                        column_names.push(k);
                        nice_column_names.push(data.columns[k].nice_column_name);
                        col_types.push(data.columns[k].type);
                    });


                    let html = "";


                    html += "<table class='table'>";
                    html += "<thead><tr>";
                    for (let i = 0; i < nice_column_names.length; i++) {
                        html += "<th>" + nice_column_names[i] + "</th>";
                    }
                    html += "</tr></thead>";

                    html += "<tbody>";
                    for (let i = 0; i < data.table.length; i++) {
                        html += "<tr>";

                        for (let j = 0; j < column_names.length; j++) {
                            html += "<td>" + getCellBody(data.table[i][column_names[j]], col_types[j], false) + "</td>";
                        }

                        html += "</tr>";
                    }
                    html += "</tbody>";

                    $("#statistics-container").html(html);

                    setTimeout(function () {
                        $("#statistics-container table").DataTable({
                            language: data_table_strings
                        });

                        $("#statistics-container table").css("overflow-x", "auto");
                        $("#statistics-container table").css("max-width", "100%");

                    }, 1);


                    switch (statType) {
                        case 3:
                            var labelType = getColumnType(statConfig.label);

                            let labels = [];
                            for (let i = 0; i < data.table.length; i++) {
                                labels.push(getDisplayFormat(data.table[i][statConfig.label], labelType));
                            }

                            let datasets = [];
                            for (let i = 0; i < statConfig.datalines.length; i++) {
                                datasets.push({
                                    label: getNiceColumnName(statConfig.datalines[i]),
                                    data: getDataLine(data.table, statConfig.datalines[i]),
                                    backgroundColor: transparentColors[i % transparentColors.length],
                                    borderColor: colors[i % colors.length],
                                    lineTension: 0.3,
                                })
                            }

                            var myChart = new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: labels,
                                    datasets: datasets
                                },
                                options: {
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero: true
                                            }
                                        }]
                                    },
                                    tooltips: {
                                        backgroundColor: "rgb(252,252,252)",
                                        bodyFontColor: "#858796",
                                        titleMarginBottom: 10,
                                        titleFontColor: '#6e707e',
                                        titleFontSize: 14,
                                        borderColor: '#dddfeb',
                                        borderWidth: 1,
                                        xPadding: 15,
                                        yPadding: 15,
                                        displayColors: true,
                                        intersect: false,
                                        caretPadding: 10
                                    }
                                },

                            });
                            break;
                        default:
                            console.log(statType);
                            alert("Ez a megjelenítési forma még kidolgozás alatt áll.");
                    }
                }
            })
            .fail(function () {

            });

    }

    function getNiceColumnName(columnName) {
        for (let i = 0; i < column_names.length; i++) {
            if (column_names[i] === columnName) {
                return nice_column_names[i];
            }
        }
    }

    function getColumnType(columnName) {
        for (let i = 0; i < column_names.length; i++) {
            if (column_names[i] === columnName) {
                return col_types[i];
            }
        }
    }

    function getDataLine(dataTable, column) {
        let dataLine = [];
        for (let i = 0; i < dataTable.length; i++) {
            dataLine.push(dataTable[i][column]);
        }
        return dataLine;
    }


</script>