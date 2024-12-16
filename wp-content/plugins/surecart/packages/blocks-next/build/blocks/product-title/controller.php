<?php
$is_link = ( isset( $attributes['isLink'] ) && $attributes['isLink'] );
$rel     = ! empty( $attributes['rel'] ) ? $attributes['rel'] : '';

return 'file:./view.php';
