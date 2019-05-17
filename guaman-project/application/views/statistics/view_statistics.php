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
    <div id="statistics-container">

    </div>

</div>

<script async src="<?php echo js_url("data_output_helper.js"); ?>"></script>
<script>

    $(document).ready(function () {
        loadTable();
    });

    var base_url = "<?php echo base_url(); ?>";
    var statId = <?php echo $statistics["id"] ?>;

    function loadTable() {
        $.post(base_url + "statistics/get_source_table/" + statId)
            .done(function (data) {
                if (data.error !== undefined) {
                    alert(data.error);
                } else {
                    console.log(data);

                    let column_names = [];
                    let nice_column_names = [];
                    let col_types = [];


                    Object.keys(data.columns).forEach(function (k) {
                        column_names.push(k);
                        nice_column_names.push(data.columns[k].nice_column_name);
                        col_types.push(data.columns[k].type);
                    });


                    console.log(column_names);
                    let html = "";


                    html += "<table class='table'>";
                    html += "<thead><tr>";
                    for (var i = 0; i < nice_column_names.length; i++) {
                        html += "<th>" + nice_column_names[i] + "</th>";
                    }
                    html += "</tr></thead>";

                    html += "<tbody>";
                    for (var i = 0; i < data.table.length; i++) {
                        html += "<tr>";

                        keys = Object.keys(data.table[0]);

                        for (var j = 0; j < keys.length; j++) {
                            html += "<td>" + getCellBody(data.table[i][keys[j]], col_types[j], false) + "</td>";
                        }

                        html += "</tr>";
                    }
                    html += "</tbody>";

                    $("#statistics-container").html(html);
                }
            })
            .fail(function () {

            });

    }
</script>