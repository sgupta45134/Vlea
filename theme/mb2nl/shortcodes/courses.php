<?php

defined('MOODLE_INTERNAL') || die();


mb2_add_shortcode('courses', 'mb2_shortcode_courses');


function mb2_shortcode_courses($atts, $content= null){

	extract(mb2_shortcode_atts(array(
		'limit' => 8,
		'catids' => '',
		'courseids' => '',
		'excourses' => 0,
		'excats' => 0,
		'layout' => 'cols',
		'colnum' => 3,
		'sdots' => 0,
		'sloop' => 0,
		'snav' => 1,
		'sautoplay' => 1,
		'spausetime' => 7000,
		'sanimate' => 600,
		'desclimit' => 25,
		'titlelimit' => 6,
		'gridwidth' => 'normal',
		'link' => 1,
		'readmoretext' => '',
		'prestyle' => 0,
		'custom_class' => '',
		'colors' => '',
		'margin' => '',
		'courseprices' => '',
		'currency' => 'USD:24'
	), $atts));


	$output = '';
	$cls = '';
	$list_cls = '';
	$col_cls = '';

	// Set column style
	$col = 0;
	$col_style = '';
	$list_style = '';
	$slider_data = '';

	// Get content source
	$items_opt = array(
		'limit'=>$limit,
		'catids'=>$catids,
		'excats'=>$excats,
		'excourses' => $excourses,
		'courseids' => $courseids,
		'colors'=>$colors,
		'layout'=> $layout,
		'col_cls' => $col_cls,
		'link' => $link,
		'titlelimit' => $titlelimit,
		'desclimit' => $desclimit,
		'colnum' => $colnum,
		'readmoretext' => $readmoretext,
		'courseprices' => $courseprices,
		'currency' => $currency
	);

	$courses = mb2_shortcode_courses_get_items($items_opt);
	$itemCount = count($courses);
	$carousel = ($layout === 'slidercols' && $itemCount > $colnum);

	// Get corousel options
	$carousel_opt = array(
		'colnum' => $colnum,
		'sdots' => $sdots,
		'sloop' => $sloop,
		'snav' => $snav,
		'sautoplay' => $sautoplay,
		'spausetime' => $spausetime,
		'sanimate' => $sanimate,
		'gridwidth' => $gridwidth
	);


	// Carousel layout
	if ($carousel)
	{
		$list_cls .= ' owl-carousel';
		$col_cls .= ' item';
		$slider_data = theme_mb2nl_shortcodes_slider_data($carousel_opt);
	}

	if ($layout === 'slidercols' && $itemCount <= $colnum)
	{
		$layout = 'cols';
	}

	$cls .= ' ' . $layout;
	$cls .= ' gwidth-' . $gridwidth;
	$cls .= $colnum > 2 ? ' multicol' : '';
	$cls .= $prestyle ? ' ' . $prestyle : '';
	$cls .= ($carousel) ? ' carousel' : ' nocarousel';

	$output .= '<div class="mb2-pb-content mb2-pb-courses clearfix' . $cls . '">';
	$output .= '<div class="mb2-pb-content-inner clearfix">';
	$output .= '<div class="mb2-pb-content-list' . $list_cls . '"' . $slider_data . '>';


	if ($itemCount>1)
	{
		$output .= theme_mb2nl_shortcodes_content_template($courses, $items_opt);
	}
	else
	{
		$output .= get_string('nothingtodisplay');

		if (in_array(theme_mb2nl_site_access(),array('admin','manager','coursecreator')))
		{
			$output .= '<div>';
			$output .= '<a href="' . new moodle_url($CFG->wwwroot . '/course/edit.php',array('category'=>theme_mb2nl_get_category()->id)) . '">' .
			get_string('createnewcourse') . '</a>';
			$output .= '</div>';
		}
	}

	$output .= '</div>';
	$output .= '</div>';
	$output .= '</div>';

	return $output;

}





/*
 *
 * Method to get categories list
 *
 */
function mb2_shortcode_courses_get_items ($options)
{

	global $CFG,$PAGE,$USER,$DB,$OUTPUT,$COURSE;

	require_once($CFG->dirroot . '/course/lib.php');
	if (!theme_mb2nl_moodle_from(2018120300))
    {
        require_once($CFG->libdir. '/coursecatlib.php');
    }


	$output = array();
	$i = 0;

	//$context = $PAGE->context;
	$context = context_course::instance($COURSE->id);
	$coursecat_canmanage = has_capability('moodle/category:manage', $context);


	$catsArr = explode(',', str_replace(' ', '', $options['catids']));
	$coursesArr = explode(',', str_replace(' ', '', $options['courseids']));
	$exCats = $options['excats'];
	$exCourses = $options['excourses'];


	$coursesList = get_courses('all');
	$itemCount = count($coursesList);


	if ($itemCount>0)
	{
		foreach ($coursesList as $course)
		{

			// Get course category
			if (theme_mb2nl_moodle_from(2018120300))
			{
				$cat = core_course_category::get($course->category, IGNORE_MISSING);
			}
			else
			{
				$cat = coursecat::get($course->category, IGNORE_MISSING);
			}

			$course->showitem = true;

			// Check if some category are included/excluded
			if ($catsArr[0])
			{
				$course->showitem = false;

				if ($exCats === 'exclude')
				{
					if (!in_array($course->category,$catsArr))
					{
						$course->showitem = true;
					}
				}
				elseif ($exCats === 'include')
				{
					if (in_array($course->category,$catsArr))
					{
						$course->showitem = true;
					}
				}
			}


			if ($coursesArr[0])
			{
				$course->showitem = false;

				if ($exCourses === 'exclude')
				{
					if (!in_array($course->id,$coursesArr))
					{
						$course->showitem = true;
					}
				}
				elseif ($exCourses === 'include')
				{
					if (in_array($course->id,$coursesArr))
					{
						$course->showitem = true;
					}
				}
			}

			if ($course->category == 0)
			{
				$course->showitem = false;
			}

			if ((!isset($cat->visible) || !$cat->visible) && !$coursecat_canmanage)
			{
				$course->showitem = false;
			}

			if ($course->id == 1)
			{
				$course->showitem = false;
			}


			// Get image url
			// If attachment is empty get image from post
			$imgUrlAtt = theme_mb2nl_shortcodes_content_get_image(array(), false, '', $course->id);
			$imgNameAtt = theme_mb2nl_shortcodes_content_get_image(array(), true, '',  $course->id);

			$moodle33 = 2017051500;
			$placeholder_image = $CFG->version >= $moodle33 ? $OUTPUT->image_url('course-default','theme') : $OUTPUT->pix_url('course-default','theme');

			$course->imgurl = $imgUrlAtt ? $imgUrlAtt : $placeholder_image;
			$course->imgname = $imgNameAtt;


			// Define item elements
			$course->link = new moodle_url($CFG->wwwroot . '/course/view.php', array('id' => $course->id));
			$course->link_edit =  new moodle_url($CFG->wwwroot . '/course/edit.php', array('id' => $course->id));
			$course->edit_text = get_string('editcoursesettings', 'core');
			$course->title = format_text($course->fullname, FORMAT_HTML);
			$course->description = format_text($course->summary);
			$course->details = '&nbsp;';

			if ((isset($cat->visible) && !$cat->visible) && $coursecat_canmanage)
			{
				$course->details = $cat->get_formatted_name() . ' (' . get_string('hidden','theme_mb2nl') . ')';
			}
			elseif ((isset($cat->visible) && $cat->visible))
			{
				$course->details = $cat->get_formatted_name();
			}

			if (isset($course->visible) && !$course->visible)
			{
				$course->title .= ' (' . get_string('hidden','theme_mb2nl') . ')';
			}

			$course->redmoretext = get_string('readmore', 'theme_mb2nl');
			$price = mb2_shortcode_courses_course_price($course->id, $options);
			$course->price = '';

			if ($options['courseprices'])
			{
				$course->price = $price ? $price : '<span class="freeprice">' . get_string('noprice','theme_mb2nl') . '</span>';
			}

		}
	}



	return $coursesList;
}







function mb2_shortcode_courses_course_price ($id, $options)
{

	$output = '';

	$prices = $options['courseprices'];
	$pricesArr = explode(',',str_replace(' ','',$prices));
	$currency = mb2_shortcode_courses_currency($options['currency']);

	foreach($pricesArr as $price)
	{

		$priceArr = explode(':',$price);


		if ($id == $priceArr[0])
		{
			$output .= isset($priceArr[2]) ? '<span class="oldprice"><del>' . $currency . trim($priceArr[2]) . '</del></span>' : '';
			$output .= isset($priceArr[1]) ? '<span class="price">' . $currency . trim($priceArr[1]) . '</span>' : '';
		}

	}

	return $output;

}




function mb2_shortcode_courses_currency ($currency)
{

	$output = '';
	$is_c = '';


	// Get currency symbol
	$currencyarr = explode(':', $currency);

	$output .= '<span class="currency">';

	if (preg_match('#\\,#', $currencyarr[1]))
	{

		$curr = explode(',', $currencyarr[1]);

		foreach ($curr as $c)
		{
			$output .= '&#x' . $c;
		}
	}
	else
	{
		$output .= '&#x' . $currencyarr[1];
	}

	$output .= '</span>';



	return $output;


}
