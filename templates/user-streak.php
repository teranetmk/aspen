<div id="streak">
	<?php if ($streak >= $threshold): ?>
		You're on a <b style="font-size: 11px; font-weight: 600; color: #1073CF;"><?= $streak ?></b> week streak. Way to go!
	<?php else: ?>
		Almost there! Streaks display after <b style="color: var(--blue); font-size:1.5em; text-decoration:underline;"> <?= $threshold ?></b> consecutive weeks of production
	<?php endif ?>
</div>
