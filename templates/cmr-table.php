<?php echo get_field('pharmacist_id') ?>
<table id="cmr-table">
	<tbody>
		<?php foreach ($rows as $title => $value): ?>
		<tr class="<?= $tier == $title ? "{$title} active" : "{$title}" ?>">
			<th><img height="32" width="32" src="<?= ASPEN_PLUGIN_URL . "assets/images/medal-{$title}.png" ?>" /></th>
			<th style="color: var(--tier-<?= $title ?>);"><?= $title ?></th>
			<td>$<?= number_format($value, 2) ?></td>
		</tr>
		<?php endforeach ?>
	</tbody>
</table>

<style>
#cmr-table {
	width: 100%;
	text-align: left;
	line-height: 3.2;
	border-collapse: collapse;
}
#cmr-table img {
	vertical-align: middle;
}
#cmr-table th {
	text-align: left;
	text-transform: capitalize;
	color: #b1b7c6;
}
#cmr-table td {
	text-align: right;
	font-weight: 600;;
	color: var(--blue);
}
#cmr-table tr {
	filter: grayscale(1);
	opacity: 0.5;
}

#cmr-table tr.active {
	filter: grayscale(0);
	opacity: 1;
}
#cmr-table tr.active th {
	font-weight: 700;
}

#cmr-table tr:not(:last-child) th,
#cmr-table tr:not(:last-child) td {
	border-bottom: 1px solid #e9ebeb;
}
</style>
