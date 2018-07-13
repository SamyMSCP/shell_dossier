</script>
<script type="text/javascript" charset="utf-8">

function UserStore() {
	var that = this;
	this.allUsers = <?=json_encode($this->userInformations)?>;
	this.selectedColumns = [];
	this.columnList = <?=json_encode($this->columnList)?>;
	this.toAdd = this.columnList[0];
	this.scpiList = <?=json_encode($this->scpiList)?>;
	this.filters = {};
	this.columnToSort = 'Prénom';
	this.reverseSort = false;
	this.firstNameFilter = [];
	this.enableFilter = false;
	this.enableEditColumns = false;
}

function strcmp(str1,str2){
	return str1.localeCompare(str2)/Math.abs(str1.localeCompare(str2));
}
var myUsers = new UserStore();



Vue.component(
	'usersFilteredToolbar',
	{
		data: function() {
			return (myUsers);
		},
		template: `
		`,
	}
);

Vue.component(
	'usersFiltered',
	{
		props: {
			columns: {
				type: Array,
				default: function() { return ([]); }
			},
			sort: {
				type: String,
				default: ""
			}
		},
		data: function() {
			return (myUsers);
		},
		template: `
			<div>
				<send-message-modale></send-message-modale>
				<div>
					<button class="btn-mscpi" @click.prevent="toggleFilter()" :class="{'btn-not-check': !enableFilter}">utiliser les filtres</button>
					<button class="btn-mscpi" @click.prevent="toggleEditColumns()" :class="{'btn-not-check': !enableEditColumns}">Editer les colonnes</button>
					<send-message-btn :users="filterUsers">Envoyer un message</send-message-btn>
				</div>
				<table border="1" class="tableDh">
					<thead v-if="enableFilter">
						<tr>
							<th v-for="indexColumn in selectedColumns">
								<span v-for="indexFilter in filters[indexColumn.data]">{{indexFilter}} <span @click="removeFilter(indexColumn, indexFilter)">X</span> <br /></span>
								<select @change="addFilter(indexColumn, $event.target)" v-if="indexColumn.data == 'scpiList'"placeholder="Ajouter un filtre" type="text" @keyup.enter="addFilter(indexColumn, $event.target)">
									<option v-for="scpi in scpiList">{{scpi}}</option>
								</select>
								<input v-else placeholder="Ajouter un filtre" type="text" @keyup.enter="addFilter(indexColumn, $event.target)"/>
							</th>
						</tr>
					</thead>
					<thead  v-if="enableEditColumns">
						<th :colspan="selectedColumns.length">
							<select @change="addNewColumnToAdd($event)">
								<option v-for="(newColumn, key) in ColumnNotAdd" :value="key">{{newColumn.name}}</option>
							</select>
						</th>
					</thead>
					<thead>
						<tr>
							<th v-for="(selectedColumn, key) in selectedColumns" @click="setSort(selectedColumn)">


								<div v-if="enableEditColumns"  @click.stop="">
									<select@change="changeColumn($event, selectedColumn.data, key)">
										<option v-for="(col, key2) in columnList" :value="key2">{{col.name}}</option>
									</select>
									<span @click="removeColumn(selectedColumn)">x</span>
								</div>



								<span>
									{{selectedColumn.name}}
								</span>
								<span v-if="columnToSort == selectedColumn && reverseSort">v</span>
								<span v-if="columnToSort == selectedColumn && !reverseSort">^</span>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="user in filterUsers" @click="goToDh(user.id)">
							<td v-for="selectedColumn in selectedColumns" >
								<span v-if="selectedColumn.type == 'number'">{{user[selectedColumn.data]}}</span>
								<span v-else-if="selectedColumn.type == 'euros'">{{user[selectedColumn.data] | euros}}</span>
								<span v-else-if="selectedColumn.type == 'date'">{{user[selectedColumn.data] | tsDate}}</span>
								<span v-else-if="selectedColumn.type == 'pourcent'">{{user[selectedColumn.data] | pourcent}}</span>
								<span v-else-if="selectedColumn.type == 'html'" v-html="user[selectedColumn.data]"></span>
								<ul v-else-if="selectedColumn.type == 'list' || selectedColumn.type == 'listLight'">
									<li v-for="element in user[selectedColumn.data]">{{element}}</li>
								</ul>
								<span v-else>{{user[selectedColumn.data]}}</span>
								
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		`,
		methods: {
			goToDh: function(id) {
				window.open("?p=EditionClient&client=" + id, '_blank');
			},
			toggleEditColumns: function() {
				this.enableEditColumns = !this.enableEditColumns;
			},
			toggleFilter: function() {
				this.enableFilter = !this.enableFilter;
			},
			changeColumn: function(e, key, indexCol) {
				var that = this;
				this.selectedColumns = this.selectedColumns.map(function(elm, i){
					if (i == indexCol)
						return (that.columnList[e.target.value]);
					return (elm);
				});
			},
			setSort: function(col) {
				if (this.columnToSort == col)
					this.reverseSort = !this.reverseSort;
				else
				{
					this.reverseSort = false;
					this.columnToSort = col;
				}
			},
			addFilter: function(indexColumn, elm) {
				this.filters[indexColumn.data].push(elm.value);
				elm.value = '';
			},
			removeFilter: function(indexColumn, indexFilter) {
				this.filters[indexColumn.data] = this.filters[indexColumn.data].filter(function(elm) {
					return (elm != indexFilter);
				});
			},
			removeColumn: function(toRemove) {
				//if (this.selectedColumns.length > 1)
					this.selectedColumns =  this.selectedColumns.filter(function(elm) {
						return elm !== toRemove;
					});
			},
			addNewColumnToAdd: function(elm) {
				this.selectedColumns.push(this.ColumnNotAdd[elm.target.value]);
			}
		},
		computed: {
			ColumnNotAdd: function() {
				that = this;
				return (this.columnList.filter(function(elm) {
					return (that.selectedColumns.indexOf(elm) === -1);
				}));
			},
			filterUsers: function() {
				if (!this.enableFilter)
					return (this.sortedUsers);
				let rt = this.sortedUsers;
				that = this;
				this.selectedColumns.forEach(function(elm) {
					if (elm.type == 'normal')
						rt = myFilterStr(rt, elm.data, that.filters[elm.data]);
					else if (elm.type == 'list')
						rt = myFilterList(rt, elm.data, that.filters[elm.data]);
					else if (elm.type == 'listLight')
						rt = myFilterListLight(rt, elm.data, that.filters[elm.data]);
					else if (
						elm.type == 'number' ||
						elm.type == 'euros' ||
						elm.type == 'pourcent' ||
						elm.type == 'date'
					)
						rt = myFilterNumber(rt, elm.data, that.filters[elm.data]);
					else
						rt = myFilterStrictStr(rt, elm.data, that.filters[elm.data]);
				});
				return (rt);
			},
			sortedUsers: function () {
				that = this;
				if (
					this.columnToSort.type == 'list' ||
					this.columnToSort.type == 'listLight'
				)
				{
					return (this.allUsers.sort(function(a, b) {
						let rt = 1;
						if (that.reverseSort)
							rt = -1;
						if(typeof a[that.columnToSort.data] == 'undefined')
							return (-rt);
						if(typeof b[that.columnToSort.data] == 'undefined')
							return (rt);
						if (that.reverseSort)
							return (b[that.columnToSort.data].length - a[that.columnToSort.data].length);
						return (a[that.columnToSort.data].length - b[that.columnToSort.data].length);
					}));
				}
				else if (
					this.columnToSort.type == 'number' ||
					this.columnToSort.type == 'euros' ||
					this.columnToSort.type == 'pourcent' ||
					this.columnToSort.type == 'date'
				)
				{
					return (this.allUsers.sort(function(a, b) {
						if (that.reverseSort)
							return (Number(b[that.columnToSort.data]) - Number(a[that.columnToSort.data]));
						return (Number(a[that.columnToSort.data]) - Number(b[that.columnToSort.data]));
					}));
				}
				else
				{
					return (this.allUsers.sort(function(a, b) {
						if (that.reverseSort)
							return (String(b[that.columnToSort.data]).localeCompare(String(a[that.columnToSort.data])));
						return (String(a[that.columnToSort.data]).localeCompare(String(b[that.columnToSort.data])));
					}));
				}
			}
		},
		beforeMount: function () {
			that = this;
			this.columnList.forEach(function(elm) {
				Vue.set(that.filters, elm.data, []);
			});
		},
		mounted: function() {
			var that = this;
			this.columns.forEach(function(elm) {
				var rt = that.columnList.find(function(elm2) {
					return elm2.data == elm;
				})
				that.selectedColumns.push(rt);
			});
			var rt = that.columnList.find(function(elm2) {
				return elm2.data == that.sort;
			});
			if (typeof rt == 'undefined')
				rt = this.columnList[0];
			that.columnToSort = rt;
		}
	}
);

function myFilterStrictStr(objectList, paramName, valideList) {
	return (objectList.filter(function(elm) {
		if (valideList.length == 0)
			return (true);
		return valideList.some(function(valide) {
			return elm[paramName] == valide;
		})
	}));
};

function myFilterStr(objectList, paramName, valideList) {
	return (objectList.filter(function(elm) {
		if (valideList.length == 0)
			return (true);
		return valideList.some(function(valide) {
			return elm[paramName].toLowerCase().indexOf(valide.toLowerCase()) !== -1;
		})
	}));
};

function myFilterNumber(objectList, paramName, valideList) {
	return (objectList.filter(function(elm) {
		if (valideList.length == 0)
			return (true);
		return valideList.every(function(valide) {
			valide = valide.trim();
			if (valide.substr(0, 2) == "!=")
				return (elm[paramName] != Number(valide.substr(2)));
			if (valide.substr(0, 2) == ">=")
				return (elm[paramName] >= Number(valide.substr(2)));
			else if (valide.substr(0, 2) == "<=")
				return (elm[paramName] <= Number(valide.substr(2)));
			else if (valide[0] == "+" || valide.substr(0, 1) == ">")
				return (elm[paramName] > Number(valide.substr(1)));
			else if (valide[0] == "-" || valide.substr(0, 1) == "<")
				return (elm[paramName] < Number(valide.substr(1)));
			else if (valide[0] == "=")
				return (elm[paramName] == Number(valide.substr(1)));
			return (elm[paramName] == Number(valide));
		})
	}));
};

function myFilterList(objectList, paramName, valideList) {
	return (objectList.filter(function(elm) {
		if (valideList.length == 0)
			return (true);
		return valideList.every(function(valide) {
			if(typeof elm[paramName] == 'undefined')
				return (false);
			return elm[paramName].some(function(have) {
				return (have == valide);
			});
		})
	}));
};

function myFilterListLight(objectList, paramName, valideList) {
	return (objectList.filter(function(elm) {
		if (valideList.length == 0)
			return (true);
		return valideList.some(function(valide) {
			if(typeof elm[paramName] == 'undefined')
				return (false);
			return elm[paramName].some(function(have) {
				return (have == valide);
			});
		})
	}));
};
