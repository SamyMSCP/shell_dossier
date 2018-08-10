<?php
/**
 * Created by PhpStorm.
 * User: vthomas
 * Date: 15/05/2018
 * Time: 14:29
 */
?>

<span
	class='tooltip-class'
>
	<div
		@mouseover="enable"
		@mouseleave="disable"
	>
		<slot>
		</slot>
	</div>
    <div class="tp-show" v-if="is_show" :class='{alignRight: alignRight}'>
        <div class="header">
            {{ title }}
        </div><br v-if="title !== '' && content !== ''">
        <div class="content" v-html="content">
        </div>
    </div>
</span>
