<?php

defined('MOODLE_INTERNAL') || die();


mb2_add_shortcode('button', 'mb2_shortcode_button');

function mb2_shortcode_button($atts, $content= null){

	extract(mb2_shortcode_atts( array(
		'type' => 'default',
		'size' => '',
		'link' => '#',
		'target' => '',
		'icon'=> '',
		'icon_size'=> '18',
		'icon_pos'=> 'before',
		'ttpos'=>'top',
		'tttext'=> '',
		'fw' => 0,
		'rounded'=>0,
		'custom_class'=>'',
		'margin'=>'',
		'border'=>0,
		'attribute'=>'',
		'center' => 0
	), $atts));

	$output = '';

	$iconpref = theme_mb2nl_font_icon_prefix($icon);

	// Define some button parameters
	$iconname = $icon;

	// Button icon
	$btnicon = '';

	if ($icon !='')
	{
		$btnicon = ' <i class="' . $iconpref . $iconname . '"></i> ';
	}


	$btntitle = $tttext ? ' title="' . $tttext . '"' : '';


	$btntext = '<span class="btn-intext">' . $content . '</span>';


	// Define button css class
	$btncls = $type;
	$btncls .= $size ? ' btn-' . $size : '';
	$btncls .= $tttext !='' ? ' tmpl-tooltip' : '';
	$btncls .= $icon_pos === 'before' ? ' btn-icon-before' : ' btn-icon-after';
	$btncls .= $rounded == 1 ? ' btn-rounded' : '';
	$btncls .= $border == 1 ? ' btn-border' : '';
	$btncls .= $fw == 1 ? ' btn-full' : '';
	$btncls .= $custom_class ? ' ' . $custom_class : '';


	// Additional button attribute
	$isattribute = $attribute !='' ? ' ' . $attribute : '';


	// Button style
	$style = $margin !='' ? ' style="margin:' . $margin . '"' : '';


	// Define button data attribute
	$btndata = $tttext !='' ? ' data-placement="' . $ttpos . '"' : '';

	$output .= ($center && !$fw) ? '<div style="text-align:center;" class="clearfix">' : '';
	$output .= '<a href="' . $link . '" target="' . $target . '" class="btn btn-' . $btncls . '"' . $style . $btntitle . $btndata . $isattribute . '>';
	$output .= $icon_pos == 'before' ? $btnicon . $btntext : $btntext . $btnicon;
	$output .= '</a>';
	$output .= ($center && !$fw) ? '</div>' : '';

	return $output;

}
