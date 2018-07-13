</script>
<script type="text/x-template" id="fourchetteRemunerationTable">
	<div class="divTable">
		<div class="divTableHeader" style="position:absolute;">
			<div class="societeClass"> Société de gestion </div>
			<div class="scpiClass"> Scpi </div>
			<div class="fourchetteClass"> Date d'execution </div>
			<div class="fourchetteClass"> Tranche basse </div>
			<div class="fourchetteClass"> Tranche haute </div>
		</div>
		<div style="height:32px;"></div>
		<div v-for="societe in $store.getters.getAllSocieteGestion" class="showDetails clickEdit arrayBox">
			<div class="societeClass">
				{{ societe.name }}
			</div>
			<div>
				<div v-for="scpi in $store.getters.getScpiForSocieteGestion(societe.id)"  class="showDetails">
					<div class="scpiClass">
						{{ scpi.name }}
					</div>
					<div>
						<div v-for="fourchette in $store.getters.getFourchettesForScpi(scpi.id)"  class="showDetails">
							<div class="fourchetteClass">
								{{	fourchette.date_execution | date }}
							</div>
							<div class="fourchetteClass">
								{{	fourchette.tranche_basse }}
							</div>
							<div class="fourchetteClass">
								{{	fourchette.tranche_haute }}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</script>
<script type="text/javascript" charset="utf-8">
	store.registerModule('fourchetteRemuneration', {
		state: {
			lst: <?=json_encode($this->fourchetteRemunerationDatas)?>,
			selectedFourchette: {},
			token: "<?=$_SESSION['csrf'][0]?>"
		},
		getters: {
			getFourchettesForScpi: function(state, getters) {
				return (function(id_scpi){
					return (state.lst.filter(function(elm) {
						return (elm.id_scpi == id_scpi);
					}));
				});
			}
		},
		mutations : {
		},
		actions : {
		}
	});

</script>
<script type="text/javascript" charset="utf-8">
	Vue.component(
		'fourchetteRemunerationTable',
		{
			template: "#fourchetteRemunerationTable"
		}
	);
