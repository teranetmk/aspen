<div id="csp-table">
	<div id="close-csp-table" onclick="oxyCloseModal();">
		
		<svg width="22" height="21" viewBox="0 0 22 21" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
		<rect width="22" height="21" fill="url(#pattern0)"/>
		<defs>
		<pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
		<use xlink:href="#image0_154_298" transform="scale(0.0454545 0.047619)"/>
		</pattern>
		<image id="image0_154_298" width="22" height="21" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABYAAAAVCAYAAABCIB6VAAABbklEQVRIid3Uv0sCYRzH8bf2QyMOoUAIoqOlIDAimpoKGqqhMduDHKK5JYj+gpYaClqaimhpqCWoqclAkiASCkMwz6QOCTv1rOEK8u6ee4Rw6Ts9D1+e1/A8n+/jq1YqnzSh/M1A/xNcfSOZyKNVvY6a6Jln4pn3BuFSju3NDJMHOSa206RdcRP9+oHo1gvTW2lWr17lcPK0wHrBWmvZIjMO/Bs9MogDUGPvROO8KIEHhtoZ+7Wvx+2oVeGeDoaVesfnzLGJnngkevBhO6ywP15m7diOKpwtq6itUliM20uEgjBuLYRG+jlcCNZdS6OoB/yDq+xMtDlbgQA7S2JUApvoiTSxy4qzZRjEdkVR9ITld+weRU9YnIqL+aBHFCWwceuOnq2oREadD2rhT2gy+P6u7IqqfhClRcuWuJFNXmS2m41uN/Sn7LifxbkwU/LJw/rdUjX6BrsICXNjomfypFAY6+10dAWT9/dq2kf/BW/CwKlkcYCuAAAAAElFTkSuQmCC"/>
		</defs>
		</svg>

	</div>

	<div class="csp-title">
		<h4>CSP Details</h4>
		<div  class="ct-div-block" style="position: relative;">
			<div class="ct-code-block tooltip tooltip-icon">
				<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
					<rect width="16" height="16" fill="white"></rect>
					<path d="M0.375 8C0.375 9.63844 0.463281 10.9295 0.689631 11.948C0.915035 12.9622 1.27234 13.683 1.79467 14.2053C2.31699 14.7277 3.03782 15.085 4.05204 15.3104C5.07053 15.5367 6.36156 15.625 8 15.625C9.63844 15.625 10.9295 15.5367 11.948 15.3104C12.9622 15.085 13.683 14.7277 14.2053 14.2053C14.7277 13.683 15.085 12.9622 15.3104 11.948C15.5367 10.9295 15.625 9.63844 15.625 8C15.625 6.36156 15.5367 5.07053 15.3104 4.05204C15.085 3.03782 14.7277 2.31699 14.2053 1.79467C13.683 1.27234 12.9622 0.915035 11.948 0.689631C10.9295 0.463281 9.63844 0.375 8 0.375C6.36156 0.375 5.07053 0.463281 4.05204 0.689631C3.03782 0.915035 2.31699 1.27234 1.79467 1.79467C1.27234 2.31699 0.915035 3.03782 0.689631 4.05204C0.463281 5.07053 0.375 6.36156 0.375 8Z" stroke="black" stroke-width="0.75" stroke-linecap="round" stroke-linejoin="round"></path>
					<path fill-rule="evenodd" clip-rule="evenodd" d="M8.66666 11.3333C8.66666 11.7015 8.36818 12 7.99999 12C7.63181 12 7.33333 11.7015 7.33333 11.3333V7.33333C7.33333 6.96514 7.63181 6.66667 7.99999 6.66667C8.36818 6.66667 8.66666 6.96514 8.66666 7.33333V11.3333ZM7.99999 6C7.63181 6 7.33333 5.70152 7.33333 5.33333C7.33333 4.96514 7.63181 4.66667 7.99999 4.66667C8.36818 4.66667 8.66666 4.96514 8.66666 5.33333C8.66666 5.70152 8.36818 6 7.99999 6Z" fill="black"></path>
				</svg>
			</div>
			<div class="ct-text-block tooltip_text" style="display: none;">
					<?php  echo tct_field("v3_csp_popup")?>
			</div>
		</div>
	</div>

	<table>
		<tbody>
			<?php foreach ($rows as $key => $items): ?>
				<tr class="tr_csp_<?= $key?>">
					<?php foreach ($items as $item): ?>
						<td><?= $item ?></td>
					<?php endforeach ?>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	<h4 style="text-align: right;">My Average CSPs: <span><?= do_shortcode('[aspen_user_csp_average]') ?></span></h4>
</div>

<style>

#modal-3970-1011 {
	border: 1px solid #1073CF;
	border-radius: 15px;
}
#csp-table {
	font-family: "Monterrat";
	padding: 30px;
	position: relative;
}

#csp-table .csp-title {
	display: flex;
	gap: 10px;
	
}
#close-csp-table {
	position: absolute;
	top: 30px;
	right: 30px;
	cursor: pointer;
}
#csp-table h4 {
	font-size: 26px;
	font-family: 'DM Serif Display' !important;
	font-weight: 400;
}
#csp-table h4 > span {
	color: var(--blue);
}
#csp-table table {
	width: 100%;
	margin: 20px 0;
	text-align: left;
	line-height: 2.2;
	border: 2px solid black;
	border-radius: 15px;
	border-collapse: collapse;
}
#csp-table td {
	padding: 20px;
	text-align: center;
}
#csp-table tr:not(:last-child) th,
#csp-table tr:not(:last-child) td {
	border-bottom: 1px solid #000;
}
#csp-table tr.tr_csp_1 {
	border-bottom: 4px solid #000;
}
#csp-table tr:first-child td {
	font-weight: bold;
}
#csp-table td:first-child {
	font-weight: bold;
}
#csp-table td:not(:last-child) {
	border-right: 1px solid #000;
}
</style>