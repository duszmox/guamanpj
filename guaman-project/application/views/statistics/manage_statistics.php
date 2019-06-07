<div class="container bg-white shadow p-5">
    <a href="<?php echo base_url("statistics/");?>" class="d-block text-decoration-none" style="color: inherit">
        <strong>
            <i class="fas fa-chevron-left"></i>
            <?php echo lang('homepage_label')?>
        </strong>
    </a>
    <h2 class="d-inline-block">
        <?php echo lang("statistics_label") ?>
    </h2>
    <?php
    if (has_permission("admin")) {
        ?><a class='btn btn-primary float-right'
             href='<?php echo base_url("statistics/add"); ?>'><i
                class="fas fa-plus"></i> <?php echo lang("statistics_add"); ?></a><?php
    }
    ?>
    <div id="statistics-list-container" class="responsive-table mt-3">

    </div>

</div>

<script>
    var base_url = "<?php echo base_url()?>";
    var can_edit_stats = <?php echo has_permission("edit_stats") ? "true" : "false"; ?>;
    lang = {
        "id": "<?php echo lang('bid_id');?>",
        "stat_name": "<?php echo lang('statistics_name');?>",
        "type": "<?php echo lang('type_label');?>",
        "actions": "<?php echo lang('actions_button_title');?>",
        "remove_stat": "<?php echo lang('delete-row-title');?>",
        "confirm_delete_statistics": "<?php echo lang('delete_confirm_statistics')?>",
        "view_stat": "<?php echo lang('watch_label')?>"
    };

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

    function loadTable() {
        $.post(base_url + "statistics/get_statistics_list/", function (data) {
            if (data.error !== undefined) {
                alert(data.error);
                return;
            }
            console.log(data);

            let html = "<table class='table'>";
            html += "<thead>";
            html += "<tr>";
            html += "<th>" + lang.stat_name + "</th>";
            html += "<th>" + lang.type + "</th>";
            html += "<th>" + lang.actions + "</th>";
            html += "</tr>";
            html += "</thead>";

            html += "<tbody>";
            for (var i = 0; i < data.length; i++) {
                html += "<tr>";

                html += "<td>" + data[i].statistics_name + "</td>";
                html += "<td>" + data[i].type_name + "</td>";

                html += "<td>";

                if (can_edit_stats) {
                    html += "<button class='btn btn-danger mr-1 mb-1' onclick='remove(" + data[i].id + ")'><i class=\"fas fa-trash-alt\"></i> " + lang.remove_stat + "</button>";
                }
                html += "<a href='" + base_url + "statistics/view/" + data[i].id + "' class='btn btn-info mb-1'><i class=\"fas fa-chart-line\"></i> " + lang.view_stat + "</a>";

                html += "</td>";

                html += "</tr>";
            }

            html += "</tbody></table>";
            $("#statistics-list-container").html(html);

            setTimeout(function () {
                $("#statistics-list-container table").DataTable({
                    language: data_table_strings
                });
            }, 1);
        })
    }

    function remove(id) {
        if (confirm(lang.confirm_delete_statistics)) {
            $.post(base_url + "statistics/remove/" + id).done(function (data) {
                if (data.error !== undefined) {
                    alert(data.error);
                }
                loadTable();
            });
        }
    }
</script>