<?php
require_once 'inc/connect.php';

$slides = $bdd->prepare('SELECT * FROM contact_information WHERE data LIKE "slide_%"');
if ($slides->execute()) {
    $slideGroup = $slides->fetchAll(PDO::FETCH_ASSOC);
}

 ?>
<span id="sl_play" class="sl_command"></span>
<span id="sl_pause" class="sl_command"></span>

<span id="sl_i1" class="sl_command sl_i"></span>
<span id="sl_i2" class="sl_command sl_i"></span>
<span id="sl_i3" class="sl_command sl_i"></span>
<span id="sl_i4" class="sl_command sl_i"></span>

<section id="slideshow">
	<a class="play_commands pause" href="#sl_pause" title="Maintain paused">Pause</a>
	<a class="play_commands play" href="#sl_play" title="Play the animation">Play</a>

	<div class="container">
		<div class="c_slider"></div>
		<div class="slider">
            <?php foreach ($slideGroup as $slideUnit): ?>
                <?php $slide = explode(',',$slideUnit['value']); ?><figure><img src="<?= $slide['2']; ?>" alt="" width="640px" height="310px" /><figcaption><?= $slide['0']; ?><br><small><?= $slide['1']; ?></small></figcaption></figure>
            <?php endforeach; ?>
		</div>
	</div>

	<span id="timeline"></span>
</section>
