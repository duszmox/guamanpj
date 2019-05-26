<div class="row">
    <div class="col-sm-auto table-div-container" style="visibility: hidden;position: relative;z-index: 1"
         id="data-table-column">
        <div class="card col-sm-auto" style="margin-right: 20px;margin-left: 20px;">
            <div class="card-body">

                <div class="responsive-table" id="table-container">
                    <!--h3 class="align-center"><?php echo lang("table_body_placeholder"); ?></h3-->
                </div>

            </div>
        </div>
    </div>

    <div class="card shadow-lg" id="sidebar-right" style="position: absolute; right:20px; z-index: 100; max-width: 400px;">
        <div class="card-header">
            <ul class="nav nav-pills card-header-pills float-right">
                <li class="nav-item">
                    <a id="show-table-list-btn" class="nav-link" style="cursor: pointer;"
                       onclick="sidebarNav('filters')">
                        Szűrők
                    </a>
                </li>
                <li class="nav-item">
                    <a id="show-filters-btn" class="nav-link active" style="cursor: pointer"
                       onclick="sidebarNav('tables')">
                        Táblák
                    </a>
                </li>
            </ul>
        </div>

        <div class="card-body" id="sidebar-body">
            <div id="filters-container-o" style="display: none;">
                Filterek
            </div>
            <div id="table-list-container-o">
                <h2>Táblák</h2>
                <div class="card-body folders-container" id="table-list-container">
                    ...
                </div>
            </div>
        </div>

    </div>

</div>
<script>

    function sidebarNav(pressedButton) {
        if (pressedButton === "filters") {
            if ($("#filters-container-o").is(":visible")) {
                $("#filters-container-o").hide();
            } else {
                $("#sidebar-body").show();

                $("#show-filters-btn").removeClass("active");
                $("#show-table-list-btn").addClass("active");

                $("#filters-container-o").show();
                $("#table-list-container-o").hide();
            }
        } else if (pressedButton === "tables") {
            if ($("#table-list-container-o").is(":visible")) {
                $("#table-list-container-o").hide();
            } else {
                $("#sidebar-body").show();

                $("#show-filters-btn").addClass("active");
                $("#show-table-list-btn").removeClass("active");

                $("#table-list-container-o").show();
                $("#filters-container-o").hide();
            }
        }
        if ($("#filters-container-o").is(":hidden") && $("#table-list-container-o").is(":hidden")) {
            $("#sidebar-body").hide();
        }
    }

    $(window).click(function() {
        $("#filters-container-o").hide();
        $("#table-list-container-o").hide();
        $("#sidebar-body").hide();

        $("#show-table-list-btn").removeClass("active");
        $("#show-filters-btn").removeClass("active");

    });

    $("#sidebar-right").click(function (event) {
        event.stopPropagation();
    });


        var data_table_strings = {
        processing: "<?php echo lang("processing_message"); ?>",
        search: "<?php echo lang("searcher_message"); ?>",
        lengthMenu: "<?php echo lang("shown_pages_start_message") . "_MENU_" . lang("shown_pages_end_message"); ?>",
        info: "",
        infoEmpty: "",
        infoFiltered: "",
        infoPostFix: "",
        loadingRecords: "<?php echo lang("records_loading_message"); ?>",
        zeroRecords: "<?php echo lang("records_zero_message"); ?>",
        emptyTable: "<?php echo lang("empty_table_message"); ?>",
        paginate: {
            first: "<?php echo lang("first_page_message"); ?>",
            previous: "<?php echo lang("previous_page_message"); ?>",
            next: "<?php echo lang("next_page_message"); ?>",
            last: "<?php echo lang("last_page_message"); ?>"
        },
        aria: {
            sortAscending: "<?php echo lang("asc_table_message"); ?>",
            sortDescending: "<?php echo lang("desc_table_message"); ?>"
        }
    };

    var lang = {
        "reload_page_button": "<?php echo lang("reload_page_button_title"); ?>",
        "new_row_button": "<?php echo lang("add_row_button_title"); ?>",
        "move_row_button": "<?php echo lang("move_row_title"); ?>",
        "actions": "<?php echo lang("actions_button_title"); ?>",
        "excelexport": "<?php echo lang("download-in-excel"); ?>",

    };


    var base_url = "<?php echo base_url(); ?>";


    var folders = <?php /** @var array $folder_array */
        echo json_encode($folder_array); ?>;
    var tables = <?php /** @var array $table_array */
        echo json_encode($table_array); ?>;

    var nonEditableTables = <?php /** @var array $nonEditableTables */
        echo json_encode($nonEditableTables); ?>;

</script>

<script async src="<?php echo js_url("data_output_helper.js"); ?>"></script>
<script async src="<?php echo js_url("table_view.js"); ?>"></script>


<style>
    #table-list-container ul {
        list-style-type: none;
    }

    #table-list-container li {
        cursor: pointer;
    }

    #data-table input {
        min-width: 100px !important;
    }

    #table-list-container ul, #table-list-container ul > ul {
        margin-left: 1em;
        padding-left: 1em;
        list-style-position: inside;
    }

    .tables-container {
        display: inline-block;

    }

    .excel-btn {
        background: #1c7430;
        border-color: #1c7430;
        display: inline-block;
    }
    .nav-link:hover.active{
        color: white !important;
    }
</style>
