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
    <div class="" style="position: absolute;right:20px ;z-index: 1;background-color: #ffffff !important;">
        <div class="card col-sm-auto">
            <div class="card-header card-header-2 ">
                <h2 class="d-inline tables_label"><?php echo lang("tables_label"); ?></h2>

                <div class="hideshowbtn d-inline">
                    <form class="d-inline" action="" method="post">
                        <input name="zero" class="btn btn-primary d-inline" id="show-or-hide-btn"
                               style="margin-bottom: 10px; float: right;"
                               type="button" value="<?php echo lang("tables_button_hide") ?>"
                               onclick="change(getElementById('show-or-hide-btn'))"/>
                    </form>
                    <hr>
                    <script>
                        function change(el) {
                            if (el.value === "<?php echo lang("tables_button_hide")?>") {
                                el.value = "<?php echo lang("tables_button_show")?>";
                                var folderContainer = $("div.folders-container");
                                folderContainer.toggle("fast", function () {

                                });


                                $(".tables_label").text("");


                            } else {
                                el.value = "<?php echo lang("tables_button_hide")?>";
                                $("div.folders-container").toggle("fast", function () {

                                });
                                $(".tables_label").text("<?php echo lang("tables_title")?>");
                            }
                        }
                    </script>


                </div>
                <div class="card-body folders-container" id="table-list-container">
                    ...
                </div>
            </div>
        </div>
    </div>
</div>

<script>
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

    var lang = {
        "reload_page_button": "<?php echo lang("reload_page_button_title");?>",
        "new_row_button": "<?php echo lang("add_row_button_title");?>",
        "move_row_button": "<?php echo lang("move_row_title");?>",
        "actions": "<?php echo lang("actions_button_title");?>",

    };


    var base_url = "<?php echo base_url(); ?>";


    var folders = <?php /** @var array $folder_array */
        echo json_encode($folder_array); ?>;
    var tables = <?php /** @var array $table_array */
        echo json_encode($table_array); ?>;

    var nonEditableTables = <?php /** @var array $nonEditableTables */ echo json_encode($nonEditableTables); ?>;
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
</style>
