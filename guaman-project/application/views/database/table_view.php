<div class="row">
    <div class="col-sm-8">
        <div class="card">
            <div class="card-body">
                col-sm-8
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <tbody>
                        <?php
                        foreach ($table_array as $key => $table) {
                            echo "<tr>";
                            /*foreach ($table as $key => $value) {
                                echo "<td>" . $value . "</td>";
                            }*/
                            echo "<td>" . $table["table_title"] . "</td>";
                            echo "</tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
