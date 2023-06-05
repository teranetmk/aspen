<?php echo get_field('pharmacist_id') ?>
<table id="pay-rates-table">
	<tbody>
		<tr class="heading">
			<th>Tier</th>
			<th>CMR Rate</th>
			<th>TMR Rate</th>
		</tr>
		<?php foreach ($rows as $title => $rates): ?>
		<tr class="<?= $tier == $title ? "{$title} active" : "{$title}" ?>">
			<th><?= $title ?></th>
			<td>$<?= number_format($rates['cmr'], 2) ?></td>
			<td>$<?= number_format($rates['tmr'], 2) ?></td>
		</tr>
		<?php endforeach ?>
	</tbody>
</table>

<style>
#pay-rates-table {
	width: 100%;
	text-align: left;
	line-height: 2.4;
	border-collapse: collapse;
}
#pay-rates-table img {
	vertical-align: middle;
}
#pay-rates-table th {
	text-align: center;
	text-transform: capitalize;
	color: #b1b7c6;
    font-weight: 600;
}

#pay-rates-table td {
	text-align: center;
	font-weight: 600;;
	/* color: var(--blue); */
	color: #1073CF;

}
#pay-rates-table tr {
	filter: grayscale(1);
	opacity: 0.5;
}

#pay-rates-table tr:first-child,
#pay-rates-table tr.active {
	filter: grayscale(0);
	opacity: 1;
}

#pay-rates-table tr:first-child > th {
	color: black;
	font-weight: normal;
	font-family: "DM Serif Display";
	font-size: 20px;
}
	
#pay-rates-table tr.active th {
	font-weight: 600;
	/* color: var(--blue); */
	color: #1073CF;
}

/* #pay-rates-table tr:not(:last-child) th,
#pay-rates-table tr:not(:last-child) td {
	border-bottom: 1px solid #e9ebeb;
} */
</style>