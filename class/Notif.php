<?php
class Notif
{
	public static function set($name, $message)
	{
		$_SESSION["notif_" . str_replace(" ", "_", $name)] = $message;
	}
	public static function setNoClose($name, $message)
	{
		$_SESSION["notifNoClose_" . str_replace(" ", "_", $name)] = $message;
	}
	public static function setNoCloseBig($name, $message)
	{
		$_SESSION["notifNoCloseBig_" . str_replace(" ", "_", $name)] = $message;
	}
	public static function setBig($name, $message)
	{
		$_SESSION["notifBig_" . str_replace(" ", "_", $name)] = $message;
	}
	public static function draw($name, $message, $noClose) {
		?>
		<div style="display::none" class="modal fade modal_push_info_<?=$name?>" <?php echo ($noClose) ? ' data-backdrop="static" data-keyboard="false" ' : ' ' ;?>tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
			<div class="modal-dialog">
				<div class="modal-content" style="background-color:#EBEBEB;">
					<div class="modal-header">
						<?php
						if (!$noClose)
						{
							?>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="module/ApercuDeMonPorteFeuillev3/img/Close-Jaune.svg" alt="" /></button>
							<?php
						}
						?>
						<?php
						/*
						<h4 class="modal-tite" style="text-align: center;">MEILLEURESCPI.COM - INFORMATION<h4>
						*/
						?>
					</div>
						<?php
						//dbg($message);
						//exit();
						/*
						<div class="traitOrange"></div>
						*/
						?>
					<div class="modal-body">
						<div style="color:#505050;font-family: 'Open Sans', sans-serif;font-size:18px;text-align:center;"><?=$message?></div>
					</div>
					<div class="modal-footer">
						<?php echo ($noClose) ? ' ' : ' <button type="button" class="btn-mscpi" data-dismiss="modal">Fermer</button> ' ;?>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript" charset="utf-8">
			$(".modal_push_info_<?=$name?>").on('shown.bs.modal', function(){
				$(this).css({paddingRight:""});
			});
		</script>
		<?php
		return ('modal_push_info_' . $name);
	}
	public static function drawBig($name, $message, $noClose) {
		?>
		<div style="display::none" class="bigmodal modal fade modal_push_info_<?=$name?>" <?php echo ($noClose) ? ' data-backdrop="static" data-keyboard="false" ' : ' ' ;?>tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
			<div class="modal-dialog" style="min-width: 90%; ">
				<div class="modal-content" style="background-color:#EBEBEB;">
					<div class="modal-header">
						<?php
						if (!$noClose)
						{
							?>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="module/ApercuDeMonPorteFeuillev3/img/Close-Jaune.svg" alt="" /></button>
							<?php
						}
						?>
						<?php
						/*
						<h4 class="modal-tite" style="text-align: center;">MEILLEURESCPI.COM - INFORMATION<h4>
						*/
						?>
					</div>
					<?php
					/*
					<div class="traitOrange"></div>
					*/
					?>
					<div class="modal-body">
						<div style="color:#505050;font-family: 'Open Sans', sans-serif;font-size:18px;text-align:center;"><?=$message?></div>
					</div>
					<div class="modal-footer">
						<?php echo ($noClose) ? ' ' : ' <button type="button" class="btn-mscpi" data-dismiss="modal">Fermer</button> ' ;?>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript" charset="utf-8">
			$(".modal_push_info_<?=$name?>").on('shown.bs.modal', function(){
				$(this).css({paddingRight:""});
			});
		</script>
		<?php
		return ('modal_push_info_' . $name);
	}
	public static function getAll() {
		$all = array();
		foreach($_SESSION as $key => $notif) {
			if (strncmp($key, "notifNoClose_", 13) === 0) {
				if ($notif != "")
					$all[] = self::draw($key, $notif, true);
				$_SESSION[$key] = "";
				unset($_SESSION[$key]);
			}
		}
		foreach($_SESSION as $key => $notif) {
			if (strncmp($key, "notif_", 6) === 0) {
				if ($notif != "")
					$all[] = self::draw($key, $notif, false);
				$_SESSION[$key] = "";
				unset($_SESSION[$key]);
			}
		}
		foreach($_SESSION as $key => $notif) {
			if (strncmp($key, "notifNoCloseBig_", 16) === 0) {
				if ($notif != "")
					$all[] = self::drawBig($key, $notif, true);
				$_SESSION[$key] = "";
				unset($_SESSION[$key]);
			}
		}
		foreach($_SESSION as $key => $notif) {
			if (strncmp($key, "notifBig_", 9) === 0) {
				if ($notif != "")
					$all[] = self::drawBig($key, $notif, false);
				$_SESSION[$key] = "";
				unset($_SESSION[$key]);
			}
		}
		echo '<script type="text/javascript" charset="utf-8">
		';
		foreach ($all as $key => $elm)
		{
			if ($key != 0)
			{
				?>
				$('.<?=$all[$key - 1]?>').on('hidden.bs.modal', function () {
					$('.<?=$elm?>').modal('show');
				})
				<?php
			}
			else
				echo "
				window.onload = function () {
					$('." . $elm . "').modal('show');\n
					
				};";
			
		}
		//exit();
		echo "</script>";
	}
}
