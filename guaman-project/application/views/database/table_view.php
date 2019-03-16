<div class="row">
    <div class="col-sm-8">
        <div class="card">
            <div class="card-body">
                <div class="responsive-table" id="table-container">


                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <?php
                        foreach ($table_array as $key => $table) {
                            echo "<tr>";
                            /*foreach ($table as $key => $value) {
                                echo "<td>" . $value . "</td>";
                            }*/
                            echo "<td onclick='loadTable(\"" . $table["table_name"] . "\")'>" .
                                "<i class='fas fa-database'></i> " . $table["table_title"] .
                                "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var data_table_strings = {
        processing: "<?php echo lang("processing_message");?>",
        search: "<?php echo lang("searcher_message");?>",
        lengthMenu: "<?php echo "_MENU_" . lang("shown_pages_start_message") . lang("shown_pages_end_message");?>",
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

    var base_url = "<?php echo base_url(); ?>";
</script>

<script async src="<?php echo js_url("table_view.js"); ?>"></script>
