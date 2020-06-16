<?php

defined('MOODLE_INTERNAL') || die();


mb2_add_shortcode('boxes', 'mb2_shortcode_boxes');
mb2_add_shortcode('boxesicon', 'mb2_shortcode_boxes');
mb2_add_shortcode('boxesimg', 'mb2_shortcode_boxes');
mb2_add_shortcode('boxescontent', 'mb2_shortcode_boxes');


function mb2_shortcode_boxes ($atts, $content= null){
	extract(mb2_shortcode_atts( array(
		'columns' =>'1', // max 5
		'size' => '',
		'type' => 1,
		'margin' => '',
		'custom_class' => ''
	), $atts));


	$output = '';

	$GLOBALS['box_type'] = $type;

	$cls = $size === 'small' ? ' boxes-small' : '';
	$cls .= $custom_class ? ' ' . $custom_class : '';

	$style = $margin !='' ? ' style="padding:' . $margin . ';"' : '';

	$output .= '<div class="theme-boxes col-' . $columns . $cls . ' clearfix"' . $style . '>';

	$output .= mb2_do_shortcode($content);

	$output .= '</div>';


	return $output;

	// This is require for other boxes type
	// Icons or images
	unset($GLOBALS['box_type']);

}


mb2_add_shortcode('boximg', 'mb2_shortcode_boximg');


function mb2_shortcode_boximg ($atts, $content = null){
	extract(mb2_shortcode_atts( array(
		'image' =>'',
		'link' =>'',
		'type' => '',
		'link_target' =>'',
		'target' =>'',
		'color' =>'',
		'useimg' => 1
	), $atts));


	$output = '';
	$title_color_span = '';
	$istarget = $target ? $target : $link_target;

	if ($type == '' && isset($GLOBALS['box_type']))
	{
		$type = $GLOBALS['box_type'];
	}

	$tstyle = '';
	$style = $color!='' ? ' style="background-color:' . $color . ';"' : '';

	if ($type == 2 || $type == 3)
	{
		$tstyle = $style;
		$title_color_span = '<span class="theme-boximg-color"' . $tstyle . '></span>';
	}

	$boxCls = $useimg == 1 ? ' useimg' : '';
	$boxCls .= ' type-' . $type;

	$output .= '<div class="theme-box">';
	$output .= $link !='' ? '<a href="' . $link . '" target="' . $istarget . '">' : '';
	$output .= '<div class="theme-boximg' . $boxCls . '">';
	$output .= $useimg == 1 ? '<div class="vtable-wrapp">' : '';
	$output .= $useimg == 1 ? '<div class="vtable">' : '';
	$output .= $useimg == 1 ? '<div class="vtable-cell">' : '';
	$output .= $content ? '<h4><span class="theme-title-text">' . format_text($content, FORMAT_HTML) . '</span>' . $title_color_span . '</h4>' : '';
	$output .= $useimg == 1 ? '</div>' : '';
	$output .= $useimg == 1 ? '</div>' : '';
	$output .= $useimg == 1 ? '</div>' : '';
	$output .= $useimg == 1 ? '<img src="' . $image . '" alt="">' : '';
	$output .= $type == 1 ? '<div class="theme-boximg-color"' . $style . '></div>' : '';
	$output .= '<div class="theme-boximg-img" style="background-image:url(\'' . $image . '\');background-repeat:no-repeat;background-position:50% 50%;background-size:cover;"></div>';
	$output .= '</div>';
	$output .= $link !='' ? '</a>' : '';
	$output .= '</div>';

	return $output;

}







mb2_add_shortcode('boxicon', 'mb2_shortcode_boxicon');


function mb2_shortcode_boxicon ($atts, $content = null){
	extract(mb2_shortcode_atts( array(
		'icon' =>'fa-rocket',
		'type' => '',
		'title'=> '',
		'link' => '',
		'color' => 'primary',
		'link_target' =>'',
		'target' =>'',
		'readmore' => ''
	), $atts));


	$output = '';
	$istarget = $target ? $target : $link_target;

	if ($type == '' && isset($GLOBALS['box_type']))
	{
		$type = $GLOBALS['box_type'];
	}

	$pref = theme_mb2nl_font_icon_prefix($icon);

	if (!$readmore && theme_mb2nl_check_for_tags($content, 'a'))
	{
		$link = 0;
	}

	$output .= '<div class="theme-box">';
	$output .= $link ? '<a href="' . $link . '" target="' . $istarget . '">' : '';
	$output .= '<div class="theme-boxicon type-' . $type . ' color-' . $color . '">';
	$output .= '<div class="theme-boxicon-icon">';
	$output .= '<i class="' . $pref . $icon . '"></i>';
	$output .= '</div>';
	$output .= $link ? '</a>' : '';
	$output .= '<div class="theme-boxicon-content">';

	if ($title)
	{
		$output .= '<h4>';
		$output .= $link ? '<a href="' . $link . '" target="' . $istarget . '">' : '';
		$output .= format_text($title, FORMAT_HTML);
		$output .= $link ? '</a>' : '';
		$output .= '</h4>';
	}

	$output .= mb2_do_shortcode(format_text($content, FORMAT_HTML));

	if ($link && $readmore)
	{
		$output .= '<a class="theme-boxicon-readmore btn btn-primary" href="' . $link . '" target="' . $istarget . '">' . $readmore . '</a>';
	}

	$output .= '</div>';
	$output .= '</div>';
	$output .= '</div>';


	return $output;

}









mb2_add_shortcode('boxcontent', 'mb2_shortcode_boxcontent');

function mb2_shortcode_boxcontent ($atts, $content = null){
	extract(mb2_shortcode_atts( array(
		'icon' =>'',
		'type' => '',
		'title'=> '',
		'link' =>'',
		'linktext' =>'Read more',
		'color' => 'primary',
		'link_target' =>'',
		'target' =>''
	), $atts));


	$output = '';
	$istarget = $target ? $target : $link_target;

	if ($type == '' && isset($GLOBALS['box_type']))
	{
		$type = $GLOBALS['box_type'];
	}

	$pref = theme_mb2nl_font_icon_prefix($icon);
	$boxCls = $icon !='' ? ' isicon' : ' noicon';
	$boxCls .= $link !='' ? ' islink' : '';


	$output .= '<div class="theme-box">';

	$output .= '<div class="theme-boxcontent type-' . $type . ' color-' . $color . $boxCls . '">';
	$output .= '<div class="theme-boxcontent-content">';
	$output .=  $icon !='' ?'<div class="theme-boxcontent-icon">' : '';
	$output .=  $icon !='' ? '<i class="' . $pref . $icon . '"></i>' : '';
	$output .=  $icon !='' ?'</div>' : '';
	$output .= $title !='' ? '<h4>' . format_text($title, FORMAT_HTML) . '</h4>' : '';
	$output .= mb2_do_shortcode(format_text($content, FORMAT_HTML));
	$output .= $link !='' ? '<div class="theme-boxcontent-readmore"><a class="btn btn-sm" href="' . $link . '" target="' . $istarget . '">' . $linktext . '</a></div>' : '';
	$output .= '</div>';
	$output .= '</div>';
	$output .= '</div>';


	return $output;

}
