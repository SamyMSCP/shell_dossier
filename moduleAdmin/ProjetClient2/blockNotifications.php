<div v-if="onglet == 3" style="position: relative;display: flex;justify-content: center;align-items: center;">
	<div class="notification_line"></div>
	<div class="timeline_notification">
		<div v-for="(elm, key) in $store.getters.getSelectedProjectNotifications" class="notification_block">
			<img src="<?=$this->getPath()?>img/DiagCircu-Bleu-MS.svg" alt="" class="notification_img"/>
			<div class="cercle_notification"></div>
			<div class="block_message" :class="{top: (key % 2), bottom: !(key % 2)}">
				<div class="flecheTop">
					<svg width="34" height="22">
						<path d="M 0,0 L 34,0 L 16,22 " style="fill:#ebebeb;"></path>
					</svg>
				</div>
				<div class="flecheBottom">
					<svg width="34" height="22">
						<path d="M 0,22 L 34,22 L 16,0 " style="fill:#ebebeb;"></path>
					</svg>
				</div>
				<div  :class="{dateTop: (key % 2), dateBottom: !(key % 2)}">
					{{ elm.date | tsDateStr }}
				</div>
				{{ elm.content}}
			</div>
		</div>
	</div>
	<div class="block_move">
		<div class="left" @click="moveLeftSpeed()"> &lt; </div>
		<div class="right" @click="moveRightSpeed()"> &gt; </div>
	</div>
</div>
