<?php

class ComponentDevtools extends ComponentGenerator {

	protected static $_dependances = [];
	protected static $_componentName = "component-devtools";

	private function __construct() { }

	private function __destruct() {}

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$rt = "";
		$rt .= "
			<div class='DevTools' :class='{active: isActive}' >
				<div class='barre'>
					<div class='name'>
						MSCPI <span style='color:red;'>DEVTOOLS</span>
					</div>
					<div class='btn' @click='setPage(\"PAGES\")' :class='{selected: page == \"PAGES\"}'>
						PAGES
					</div>
					<div class='btn' @click='setPage(\"ENTITY\")' :class='{selected: page == \"ENTITY\"}'>
						ENTITY
					</div>
					<div class='btn' @click='setPage(\"PROCEDURES\")' :class='{selected: page == \"PROCEDURES\"}'>
						PROCEDURES
					</div>
					<div class='btn' @click='setPage(\"ACTIONS\")' :class='{selected: page == \"ACTIONS\"}'>
						ACTIONS
					</div>
					<div class='btn' :class='{isHide: !isActive}' @click='close()' style='border-color:red;color:red;'>
						CLOSE
					</div>
				</div>
				<div v-if='page == \"PAGES\"' class='content'>
					<slot name='PAGES'></slot>
				</div>
				<div v-if='page == \"ENTITY\"' class='content'>
					<slot name='ENTITY'></slot>
				</div>
				<div v-if='page == \"PROCEDURES\"' class='content'>
					<slot name='PROCEDURES'></slot>
				</div>
				<div v-if='page == \"ACTIONS\"' class='content'>
					<slot name='ACTIONS'></slot>
				</div>
				";
		$rt.= " </div> ";
		return ($rt);
	}

	protected static function getComponent($class, $config) {
		$componentName = static::getComponentName($class);
		$templateId = static::getTemplateId($class);

		return ("
			Vue.component(
				'$componentName',
				{
					data: function() {
						return ({isActive: false, page: ''});
					},
					methods: {
						close: function() {
							this.isActive = false;
							this.page = '';
						},
						setPage: function(pageName) {
							this.isActive = true;
							this.page = pageName;
						}
					},
					template: '#$templateId'
				}
			);
		");
	}
}

