<?php

/*
	Manuel d'utilisation du stack modal
	On push un élement à afficher dans la modale directement avec la mutation : modal_stack_push !

	Le contenu à afficher dans la modale est déterminée par le payload:
	{
		tag: 'nom du tag',
		config: {élements de configuration du tag},
		content: [correspondrait à ce qu'il doit y avoir dans l'ement désiré (slot)]
	}
*/
class StoreModuleDocument extends StoreModule {

	public static function getVuexState() {
		$rt = [];
		$rt['lstTypeDocument'] = [
			"PersonnePhysique" => Pp::getRequiredTypeDocument(),
			"PersonneMorale" => Pm::getRequiredTypeDocument()
		];
		return ($rt);
	}

	public static function getVuexActions() {
		$rt = "";
		return ($rt);
	}

	public static function getVuexMutations() {
		$rt = "";
		return ($rt);
	}

	public static function getVuexGetters() {
		$rt = "";
		$rt .= "getLstDocuments: function(state, getters) {
			return (state.modules.StoreModuleDocument.lstTypeDocument);
		},";
		return ($rt);
	}
}
