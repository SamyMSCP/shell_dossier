<?php
class StoreModuleCodeVille extends StoreModule {

	public static function getVuexActions() {
		$rt = "
			getCodeVille: function(context, payload) {
				var that = this;
				return (new Promise(function(resolve, reject) {
					Vue.http.post('graph_api.php', {
							Receiver: 'CodeVille',
							Action: 'getCodeVille',
							Datas: payload
						},
						{emulateJSON: true}
					)
					.then (
							function (res) {
								resolve(res.body);
							},
							function (res) {
								reject(res.body);
						}
					);
				}));
			},
		";
		return ($rt);
	}
}
