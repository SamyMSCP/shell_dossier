<div class="moduleOpportunityVisual container-fluid">
	<?php /*$this->AdvancedOpResearch */?>
	<div class="row" id="containerOpp">
		<div style="padding: 16px;"
			is="module-opportunity"
			v-for="op in oplist"
			v-bind:id="op.id"
			v-bind:type="op.type"
			v-bind:scpi="op.scpi"
			v-bind:date="op.date"
			v-bind:duree="op.duree"
			v-bind:key-nue="op.key"
			v-bind:tot="op.tot"
			v-bind:parts="op.parts"
			v-bind:price-part="op.price_part"
			v-bind:partiel="op.partiel"
			v-bind:state="op.state"
			v-bind:color-state="op.colorState"
			v-bind:is-ending="op.isEnding"
			v-show="op.show">
		</div>
	</div>
	<div class="op-pagin text-center">
		<ul class="list-inline p-list">
		<?php

			function addPage($i, $txt, $is_active = false, $is_disabled = false){
				if (!empty($is_active))
					$active = "active";
				else
					$active = "";
				if (!empty($is_disabled))
				{
					$active .= " disabled";
					$target = "#";
				}
				else
					$target = "?p=Opportunity&page=$i";
				?>
				<li>
					<a href="<?=$target?>" class=" btn p-list-item <?=$active?>">
						<?=$txt?>
					</a>
				</li>
				<?php
			}

			$current = intval($GLOBALS['GET']['page']);
			if (empty($current) || $current <= 0)
				$current = 1;
			$max_pages = Opportunity::getMaxPage();
			$max_pages = $max_pages / 3 + (($max_pages % 3) ? 1 : 0);
			$max_pages = intval($max_pages);

			if ($max_pages < $current)
				$current = 1;
			$last = $current - 1;
		$next = $current + 1;

			$offset = 2;

			if ($current != 1)
				addPage($last, "<span class='glyphicon glyphicon-chevron-left'></span>", false, false);

			if ($current < $offset)
			{
				$i = 1;
				while ($i < $offset){
					if ($i == $current)
						addPage($i, $i, true, false);
					else
						addPage($i, $i, false, false);
					$i++;
				}
				addPage($i, $i, false, false);
			}
			else
			{
				addPage(1, 1, false, false);
				addPage("", "...", false, true);
			}

			if ($current <= $max_pages - $offset)
			{
				addPage($current - 1, $current - 1, false, false);
				addPage($current, $current, true, false);
				addPage($current + 1, $current + 1, false, false);
				addPage("", "...", false, true);
				addPage($max_pages, $max_pages, false, false);
			}
			else
			{
				$i = $max_pages - $offset;
				while ($i <= $max_pages){
					if ($i == $current)
						addPage($i, $i, true, false);
					else
						addPage($i, $i, false, false);
					$i++;
				}
			}
			if ($current != $max_pages)
				addPage($next, "<span class='glyphicon glyphicon-chevron-right'></span>");
		?>
		</ul>
	</div>
</div>
