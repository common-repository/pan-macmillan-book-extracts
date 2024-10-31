<?php
/*
Plugin Name: Pan Macmillan Book Extracts
Plugin URI: 
Description: This plugin will show the first chapter (or a selected extract) from books published by Pan Macmillan. Example usage: [extract title = "Book Title" author = "Author Name"]. See readme for all parameters.
Author: Pan Macmillan
Version: 1.03
Author URI: https://www.panmacmillan.com
*/
function getextract($params = array()) {

	// default parameters
	extract(shortcode_atts(array(
		'title' => '',
		'author' => '',
		'linktext' => '',
		'includetitleandauthor' => true,
		'viewer' => false,
		'images' => false,
		'lightbox' => false
		), $params));

	// get book info
	$data = file_get_contents("http://extracts.panmacmillan.com/getextracts?titlecontains=".urlencode($title)."&authorcontains=".urlencode($author));
	$json = json_decode($data,true);
	// Because no page total is available in API, this is the way we have to do this for now
	if ($json['NextPageUrl'] != "")
	{
		$datapage2 = file_get_contents("http://extracts.panmacmillan.com/getextracts?titlecontains=".urlencode($title)."&authorcontains=".urlencode($author)."&pagenumber=2");
		$jsonpage2 = json_decode($datapage2,true);
		foreach ($jsonpage2['Extracts'] as $extract)
		{
			array_push($json['Extracts'],$extract);
		}
		// Page 3
		if ($jsonpage2['NextPageUrl'] != "")
		{
			$datapage3 = file_get_contents("http://extracts.panmacmillan.com/getextracts?titlecontains=".urlencode($title)."&authorcontains=".urlencode($author)."&pagenumber=3");
			$jsonpage3 = json_decode($datapage3,true);
			foreach ($jsonpage3['Extracts'] as $extract)
			{
				array_push($json['Extracts'],$extract);
			}
		}
		// Page 4
			if ($jsonpage3['NextPageUrl'] != "")
			{
				$datapage4 = file_get_contents("http://extracts.panmacmillan.com/getextracts?titlecontains=".urlencode($title)."&authorcontains=".urlencode($author)."&pagenumber=4");
				$jsonpage4 = json_decode($datapage4,true);
				foreach ($jsonpage4['Extracts'] as $extract)
				{
					array_push($json['Extracts'],$extract);
				}
			}
			// Page 5
			if ($jsonpage4['NextPageUrl'] != "")
			{
				$datapage5 = file_get_contents("http://extracts.panmacmillan.com/getextracts?titlecontains=".urlencode($title)."&authorcontains=".urlencode($author)."&pagenumber=5");
				$jsonpage5 = json_decode($datapage5,true);
				foreach ($jsonpage5['Extracts'] as $extract)
				{
					array_push($json['Extracts'],$extract);
				}
			}
	}
	$data = $json;
	$html = str_replace("<html>","",$data['Extracts'][0]['extractHtml']);
	$html = str_replace("</html>","",$html);
	$html = str_replace("<body>","",$html);
	$html = str_replace("</body>","",$html);



	if ($includetitleandauthor = true)
	{
		$html = "<h2>".$data['Extracts'][0]['title']."</h2><h3>".$data['Extracts'][0]['author']."</h3>".$html;
	}
	// Display a single book
	if ($title != "")
	{
		if ($viewer == false && $lightbox == false)
		{
			return $html;
		}
		elseif ($viewer == true)
		{
			$html = "<div class = 'extract-viewer-pane'>".$html."</div>";
			return $html;
		}
		elseif ($lightbox = true && $viewer == false && $images == true)
		{
			$html = "<a href = '#' data-featherlight=\"".str_replace('"',"",$html)."\" target = '_blank'><img class = 'jacket' src = '".str_replace("http://biblioimages-uk.macmillan.co.uk","https://www.biblioimages.com/macmillanuk-dam/",$data['Extracts'][0]['jacketUrl'])."'/></a>";
			return $html;
		}
		elseif ($lightbox = true && $viewer == false && $images == false && $linktext != "")
		{
			$html = "<a href = '#' data-featherlight=\"".str_replace('"',"",$html)."\" target = '_blank'>".$linktext."</a>";
			return $html;
		}
	}
	// display a list of books
	elseif ($title == "" && $author != "")
	{	
		if ($images == true)
		{
			$html = "<ul class = 'extract-jackets'>"; 
		}
		else
		{
			$html = "<ul>";	
		}
		foreach ($data['Extracts'] as $extract)
		{
			if ($images != true && $lightbox == false)
			{
				$html .= "<li><a href = 'http://extracts.panmacmillan.com/extract?isbn=".$extract['isbn']."' target = '_blank'>".$extract['title']."</a></li>";
			}
			elseif ($images != true && $lightbox == true)
			{
				$html .= "<li><a href = '#' data-featherlight=\"".str_replace('"',"",$extract['extractHtml'])."\" target = '_blank'>".$extract['title']."</a></li>";
			}
			elseif ($images == true && $lightbox == false) 
			{
				$html .= "<li><a href = 'http://extracts.panmacmillan.com/extract?isbn=".$extract['isbn']."' target = '_blank'><img class = 'jacket' src = '".str_replace("http://biblioimages-uk.macmillan.co.uk","https://www.biblioimages.com/macmillanuk-dam/",$extract['jacketUrl'])."'/></a></li>";
			}
			elseif ($images == true && $lightbox == true) 
			{
				$html .= "<li><a href = '#' data-featherlight=\"".str_replace('"',"",$extract['extractHtml'])."\" target = '_blank'><img class = 'jacket' src = '".str_replace("http://biblioimages-uk.macmillan.co.uk","https://www.biblioimages.com/macmillanuk-dam/",$extract['jacketUrl'])."'/></a></li>";
			}
		}
		$html .= "</ul>";
		return $html;
	}
	else
	{
		$html = "Unable to fetch extract.<br>Example shortcode: [extract author = \"Jeffrey Archer\" title=\"Mightier Than The Sword\"]";
		return $html;
	}
}
function extractdependancy() {
	wp_register_style('extract-style', plugins_url('/css/style.css',__FILE__ ));
	wp_register_style('lightbox', plugins_url('/css/featherlight.min.css',__FILE__ ));
	wp_enqueue_style('extract-style');
	wp_enqueue_style('lightbox');
	wp_enqueue_script( 'lightbox', plugins_url('/js/featherlight.min.js',__FILE__ ),   array(), '1.3.5', true );
}
add_action( 'init','extractdependancy');
add_shortcode('extract', 'getextract');
?>