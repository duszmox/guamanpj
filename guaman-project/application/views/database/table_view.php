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
							echo "<td onclick='loadTable(\"" . base_url() . "\", \"" . $table["table_name"] . "\")'>" . $table["table_title"] . "</td>";
							echo "</tr>";
						}
						?>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<script async src="<?php echo js_url("table_view.js"); ?>"></script>
