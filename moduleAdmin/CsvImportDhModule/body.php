<?php
if ($vue === 0) {
	?>
	<div class="row">
		<div class="col-md-6">
		<h1>Importer un nouveau fichier</h1>
		<?php
		include("upload_form.php");
		?>
		</div>
		<?php
		$oldFiles = scandir ("../cache/importsCsv/dh/old/");
		echo "<h1>Imports precedents</h1>";
		echo "<ul>";
		foreach ($oldFiles as $elm) {
			if ($elm === "." || $elm === "..")
				continue;
			?>
			<li><a href="?p=<?=$GLOBALS['GET']['p']?>&oldImport=<?=$elm?>"><?=$elm?></a></li>
			<?php
		}
		?>
		<ul>
	</div>
	<?php
}
else if ($vue === 1)
	include("tableData.php");
else if ($vue === 2)
	include("tableData.php");
else if ($vue === 3)
	include("showNewData.php");

