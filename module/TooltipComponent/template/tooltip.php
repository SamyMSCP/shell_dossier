<?php
/**
 * Created by PhpStorm.
 * User: vthomas
 * Date: 15/05/2018
 * Time: 14:29
 */
?>
<span class="tp-component">
    <img :src="get_image" class="tp-icon" :class="size"
    @mouseover="enable"
    @mouseleave="disable">
    <div class="tp-show" v-if="is_show">
        <div class="header">
            {{ title }}
        </div><br v-if="title !== '' && content !== ''">
        <div class="content" v-html="content">
        </div>
    </div>
</span>
