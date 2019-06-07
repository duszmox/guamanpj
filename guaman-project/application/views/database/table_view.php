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

    <div class="card shadow-lg" id="sidebar-right"
         style="position: absolute; right:20px; z-index: 100; max-width: 400px;">
        <div class="card-header">
            <ul class="nav nav-pills card-header-pills float-right">
                <li class="nav-item">
                    <a id="show-table-list-btn" class="nav-link" style="cursor: pointer;"
                       onclick="sidebarNav('filters')">
                        Szűrők <!--todo lang-->
                    </a>
                </li>
                <li class="nav-item">
                    <a id="show-filters-btn" class="nav-link btn-outline-custom" style="cursor: pointer"
                       onclick="sidebarNav('tables')">
                        <!-- todo lang-->Táblák
                    </a>
                </li>
            </ul>
        </div>

        <div class="card-body" id="sidebar-body">
            <div id="filters-container-o" style="display: none;">
                <h2>
                    Szűrők <!-- todo lang-->
                </h2> <!-- todo lang-->

                <?php if(has_permission("edit_filters")){ ?>
                    <a href="#" onclick="editFilters()" >Beállítások <i class="fas fa-cog"></i></a>
                <?php } ?>
                <div id="filter-container">
                </div>
            </div>
            <div id="table-list-container-o">
                <h2>Táblák</h2> <!-- todo lang-->
                <div class="card-body folders-container" id="table-list-container">
                    ...
                </div>
            </div>
        </div>

    </div>


</div>
<script>


    /*var lang = {

    };
    */
    var lang = <?php echo json_encode(get_instance()->lang->language); ?>;

    var data_table_strings = {
        processing: lang.processing_message,
        search: lang.searcher_message,
        lengthMenu: lang.shown_pages_start_message + "_MENU_" + lang.shown_pages_end_message,
        info: "",
        infoEmpty: "",
        infoFiltered: "",
        infoPostFix: "",
        loadingRecords: lang.records_loading_message,
        zeroRecords: lang.records_zero_message,
        emptyTable: lang.empty_table_message,
        paginate: {
            first: lang.first_page_message,
            previous: lang.previous_page_message,
            next: lang.next_page_message,
            last: lang.last_page_message
        },
        aria: {
            sortAscending: lang.asc_table_message,
            sortDescending: lang.desc_table_message
        }
    };

    var base_url = "<?php echo base_url(); ?>";

    var folders = <?php /** @var array $folder_array */
        echo json_encode($folder_array); ?>;
    var tables = <?php /** @var array $table_array */
        echo json_encode($table_array); ?>;

    var nonEditableTables = <?php /** @var array $nonEditableTables */
        echo json_encode($nonEditableTables); ?>;

</script>

<script src="<?php echo js_url("dataTables.buttons.min.js"); ?>"></script>
<script src="<?php echo js_url("pdfmake.min.js"); ?>"></script>
<script src="<?php echo js_url("jszip.min.js"); ?>"></script>
<script src="<?php echo js_url("vfs_fonts.js"); ?>"></script>
<script async src="<?php echo js_url("data_output_helper.js"); ?>"></script>
<script src="<?php echo js_url("buttons.html5.min.js"); ?>"></script>
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

    .buttons-excel {
        background: #1c7430;
        border-color: #1c7430;
    }

    .buttons-excel:hover {
        background: #218939;
        border-color: #218939;
    }

    .buttons-csv {
        background: #73744c;
        border-color: #73744c;
    }

    .buttons-csv:hover {
        background: #8d8e5d;
        border-color: #8d8e5d;
    }

    .buttons-pdf {
        background: #a22a08;
        border-color: #a22a08;
    }

    .buttons-pdf:hover {
        background: #c2320a;
        border-color: #c2320a;
    }

    .btn-outline-custom {
        border: 1px solid #1c294e;
        border-radius: 5px;
        transition: 0.3s;
        background-color: #1c294e;
        color: white !important;
    }

    .btn-outline-custom:hover {
        background-color: #fff;
        color: #1c294e !important;
    }

    .filter-settings-filter-row{
        border-bottom: 1px solid #e4e4e4;
        transition: 0.3s;
        cursor: pointer;
    }
    .filter-settings-filter-row:hover{
        background-color: #f7f7f7;
    }

</style>
