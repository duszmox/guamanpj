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
<script>
	var data_table_strings = {
		processing:     "Traitement en cours...",
		search:         "Rechercher&nbsp;:",
		lengthMenu:    "Afficher _MENU_ &eacute;l&eacute;ments",
		info:           "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
		infoEmpty:      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
		infoFiltered:   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
		infoPostFix:    "",
		loadingRecords: "Chargement en cours...",
		zeroRecords:    "Aucun &eacute;l&eacute;ment &agrave; afficher",
		emptyTable:     "Aucune donnée disponible dans le tableau",
		paginate: {
			first:      "Premier",
			previous:   "Pr&eacute;c&eacute;dent",
			next:       "Suivant",
			last:       "Dernier"
		},
		aria: {
			sortAscending:  ": activer pour trier la colonne par ordre croissant",
			sortDescending: ": activer pour trier la colonne par ordre décroissant"
		}
	}
</script>
<script async src="<?php echo js_url("table_view.js"); ?>"></script>
