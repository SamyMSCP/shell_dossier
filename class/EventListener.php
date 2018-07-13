<?php
/**
 * Created by PhpStorm.
 * User: vthomas
 * Date: 17/01/2018
 * Time: 15:39
 */

class EventListener
{
	private static $_event_list = [];


	public static function init() {
		if (!isset($_SESSION['event-lister']))
			$_SESSION['event-lister'] = [];
		self::$_event_list = $_SESSION['event-lister'];
	}
/*
 * EventListener::event
 * Search for an event if exist.
 */
	public static function event($event = "") {
		if ($event == ""){
			$list = [];
			foreach (static::$_event_list as $key => $elm) {
				$list[] = ["event" => $key, "action" => $elm['action'], "description" => $elm['description'], "autodismiss" => $elm['autodismiss']];

			}
			return ($list);
		}
		else {
			if (!isset(static::$_event_list[$event]))
				return (null);
			return (static::$_event_list[$event]);

		}
	}


/*
 * EventListener::on("parapluie", function ($params) { notification($params); }, "yep");
 * When we emit "parapluie" this will execute function with params
 * If have one parameters: You can pass it directly
 * If have more parameters, function must get a parameters with an array.
 * Sending an array and parse it from the handler
 *
 * on -> will create an handler
 */
	public static function on($event, $action, $params = null, $autodismiss = false, $descrip = "") {
		if (self::event($event) != null)
			throw new Exception("Un evenement '$event' a deja été déclarer");

		$_SESSION['event-lister'][$event] = ["action" => $action, "params" => $params, "description" => $descrip, "autodismiss" => $autodismiss];
		self::init();
	}

	public static function unhandle($event) {
		if (self::event($event) == null)
			throw new Exception("Aucun evenement '$event' n'a été déclarer");
		unset($_SESSION['event-lister'][$event]);
		self::init();
	}
/*
 * EventListener::emit is for emit an event.
 * Event must be declared before emit them.
 */
	public static function emit($event, $params = []){
		$data = self::event($event);

		if ($data == null)
			throw new Exception("Cet evenement n'existe pas. Pensez a le creer avec EventListener::on");
		$params = (count($params) == 0) ? $data['params'] : $params;
		call_user_func_array($data['action'], $params);
		if ($data['autodismiss'] == true)
			self::unhandle($event);
	}

/*
 * This is a debug function for print all event store in session.
 */
	public static function print() {
		$list = self::event();
		echo "<br><table border='1' cellspacing='0' style='width: 100vw;'><tr><th>Event Name</th><th>Action</th><th>Auto-Dismiss</th><th>Description</th></tr>";
		foreach ($list as $event) {
			?>
			<tr>
				<td><?=$event['event']?></td>
				<td><?=$event['action']?></td>
				<td><?=($event['autodismiss']) ? "true" : "false"?></td>
				<td><?=$event['description']?></td>
			</tr>
			<?php
		}
		echo "</table>";
	}

/* ****************************************************************************************************************** *
 *                                           JS HANDLERS AND EVENT LISTENER
 * Here we create somes link with JS for handle JS event and pass it to PHP for execute some PHP
/* ****************************************************************************************************************** */


/*
 * EventListener::createJSEmitter
 * This function will create a new JS Ajax code for send request on JS event
 * Exemple:
 *   EventListener::createJSEmitter("#test", "click", "parapluie", true)
 * This will create code between script balise for emit "parapluie" event when we "click" on "#test"
 */

	public static function createJSEmitter($element, $event, $phpEvent, $balise = false) {
		if ($balise)
			echo "<script>";
		?>
			document.querySelector("<?=$element?>").addEventListener("<?=$event?>", function () {
				console.log("<?=$phpEvent?>");
				$.post('ajax_request.php', {
					req: "EventListener",
					action: "emit",
					token: "<?=$_SESSION['csrf'][0]?>",
					data: {
						event: "<?=$phpEvent?>"
					}
				}, function (data, status) {
					console.log("OK", data, status);
				});
			});

		<?php
		if ($balise)
			echo "</script>";
	}
}