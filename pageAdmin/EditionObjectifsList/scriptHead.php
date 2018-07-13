</script>
<script type="text/x-template" id="objectifsList">
	<div>
		<div class="modal fade" id="modalObj" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
			<div class="modal-dialog modal-lg" style="border-radius: 15px;">
				<div class="modal-content" style="background-color: #EBEBEB;border-radius: 15px;">
					<div class="modal-body" v-if="$store.getters.getSelectedObj != null">
						<h1>Edition objectif list</h1>
						<div class="trait"></div>
						<div style="margin-top:40px;">
							<input class="form-control" type="text" v-model="$store.getters.getSelectedObj.name"/>
						</div>
						<div>
							<ck-editor id="idObj" v-model="$store.getters.getSelectedObj.content" />
						</div>
						<div class="align-btn-center">
							<button v-if="isSame()" class="btn-mscpi btn-not-check btn-not-allowed">Enregistrer</button>
							<button v-else class="btn-mscpi" @click="saveIt($store.getters.getSelectedObj)">Enregistrer</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<table class="tableObj">
			<thead>
				<tr>
					<th>id</th>
					<th>name</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="obj in $store.state.objectifsList.lst">
					<td>{{ obj.id }}</td>
					<td>{{ obj.name }}</td>
					<td><button class="btn-mscpi" @click="editOne(obj)">Editer</button></td>
				</tr>
			</tbody>
		</table>
	</div>
</script>

<script type="text/javascript" charset="utf-8">
	
	store.registerModule('objectifsList', {
		state: {
			lst: <?=json_encode($this->objs)?>,
			selected: null
		},
		mutations: {
			OBJ_LIST_SET_SELECTED: function(state, payload) {
				state.selected = JSON.parse(JSON.stringify(payload));
			},
			OBJ_UPDATE: function(state, payload) {
				state.lst = state.lst.map(function(elm) {
					if (elm.id == payload.id)
						return (payload)
					return(elm);
				})
				state.selected = state.lst.find(function(elm) {
					return (elm.id == payload.id);
				})
			}
		},
		actions: {
			SAVE_OBJ_LIST: function(context, payload) {
				return (new Promise(function(resolve, reject) {
					Vue.http.post('ajax_request.php', {
							req: 'AjaxObjList',
							action: 'update',
							data: payload,
							token: "<?=$_SESSION['csrf'][0]?>"
						},
						{emulateJSON: true}).then(
							function (res) {
								context.commit("OBJ_UPDATE", res.body);
								resolve(res.body);
							},
							function (res) {
								if (typeof res.body.err != 'undefined')
									msgBox.show(res.body.err);
								else 
									msgBox.show("La mise a jours de l'objectif a échoué !");
								reject();
						}
					)
				}));
			}
		},
		getters: {
			getSelectedObj: function(state, getters) {
				return (state.selected);
			},
			getOriginalObj: function(state, getters) {
				if (getters.getSelectedObj == null)
					return (null);
				return (state.lst.find(function(elm) {
					return (elm.id == getters.getSelectedObj.id)
				}));
			}
		}
	});

	Vue.component(
		'objectifsList',
		{
			computed: {
			},
			methods: {
				editOne: function(elm) {
					this.$store.commit("OBJ_LIST_SET_SELECTED", elm)
					$('#modalObj').modal('show');
				},
				isSame: function(){
					if (
						this.$store.getters.getSelectedObj == null ||
						this.$store.getters.getOriginalObj == null
					)
						return (false);
					if (
						this.$store.getters.getSelectedObj.name != this.$store.getters.getOriginalObj.name || 
						this.$store.getters.getSelectedObj.content != this.$store.getters.getOriginalObj.content
					)
						return (false);
					return (true);
				},
				saveIt: function(toSave) {
					this.$store.dispatch('SAVE_OBJ_LIST', toSave).then(function() {
						$('#modalObj').modal('hide');
					}, function() {});
				}

			},
			template: '#objectifsList'
		}
	);
