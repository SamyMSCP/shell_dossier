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
class StoreModuleModalStack extends StoreModule {

	public static function getVuexState() {
		$rt = [];
		$rt['stack'] = [];
		return ($rt);
	}

	public static function getVuexActions() {
		$rt = "";
		$rt .= "
			set_block: function(context, payload) {
				if (typeof payload.component == 'undefined')
					return (false);
				var title = (typeof payload.title != 'undefined') ? payload.title : '';
				context.commit('modal_stack_push', {
					tag: 'component-modal-block-mscpi-noname',
					config: {
						props: payload
					},
					componentContent: {tag: payload.component}
				});
			},
			set_incoherence: function(context, payload) {
				context.commit('modal_stack_push', {
					tag: 'component-modal-coherence-noname',
					config: {
						props: payload
					}
				});
			},
			modal_stack_push: function(context, payload) {
				return (context.commit('modal_stack_push', payload));
			},
			modal_stack_pop: function(context, payload) {
				return (context.commit('modal_stack_pop'));
			},
			modal_message_box: function(context, payload) {
				var args = {
					tag: 'component-message-box-noname',
					config: payload.config,
					content: payload.content
				};
				if (typeof payload.notClose != 'undefined')
					args['notClose'] = payload.notClose;
				context.commit('modal_stack_push', args);
			},
		";
		return ($rt);
	}

	public static function getVuexMutations() {
		$rt = "";
		$rt .= "modal_stack_push: function(state, payload) {
			if (
				typeof payload === 'undefined' || 
				typeof payload.tag === 'undefined'
			)
				return (false);
			state.modules.StoreModuleModalStack.stack.push(payload);
			return (true);
		},
		modal_stack_pop: function(state, payload) {
			if (state.modules.StoreModuleModalStack.stack.length < 1)
				return (false);
			state.modules.StoreModuleModalStack.stack.pop();
			return (true);
		},
		";
		return ($rt);
	}

	public static function getVuexGetters() {
		$rt = "";
		$rt .= "getModalStackTop: function(state, getters) {
			if (state.modules.StoreModuleModalStack.stack.length < 1)
				return (null);
			return (state.modules.StoreModuleModalStack.stack[state.modules.StoreModuleModalStack.stack.length - 1]);
		},";
		return ($rt);
	}
}
