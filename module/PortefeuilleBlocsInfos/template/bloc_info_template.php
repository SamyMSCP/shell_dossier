<?php
/**
 * Created by PhpStorm.
 * User: vthomas
 * Date: 16/02/2018
 * Time: 16:30
 */
?>
<div class="bloc-info">
	<img class="icon info" :src="this.data.img === 0 ? '/assets/info/i-Blanc.svg' : '/assets/info/i-BleuClair.svg'"/>
	<div class="title text-uppercase" v-html="data.title"></div>
	<div class="tab-content">
		<div class="tab-pane in active">
			<h3>{{ current.data | percent }}</h3>
		</div>
	</div>
	<ul class="nav-year list-inline">
		<li v-for="(el, index) in data.date" :class="(index === data.date.length - 1) ? 'active' : ''">
			<a href="#" data-toggle="tab" @click="changeDate(el.year)">{{el.year}}</a>
		</li>
	</ul>
</div>
