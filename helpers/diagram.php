<?php
// Create the image
header("Content-Type: image/png");
$img=ImageCreate(1000,400);

function Diagramm($img,$VALUES,$LEGEND) {
	GLOBAL $COLORS,$SHADOWS;

	$black=ImageColorAllocate($img,0,0,0);

    // Image dimensions
	$W=ImageSX($img);                 
	$H=ImageSY($img);

    // Legend ----------------------------------------------------------------------------

    // Count the number of legend items
	$legend_count=count($LEGEND);

    // Find the maximum item length and the longest legend string
	$max_length=0;
	$widest_label='';
	foreach($LEGEND as $v) {
		if ($max_length<strlen($v)) {
			$max_length=strlen($v);
			$widest_label=$v;
		}
	}

    // Font
	$font_path = '../fonts/Noto Sans ExtCond.ttf';
	$font_size = 16;
	$padding = 10; // Padding

    // Calculate width and height
	$bbox = imagettfbbox($font_size, 0, $font_path, $widest_label);
	$font_w = abs($bbox[4] - $bbox[2])+10;
	$font_h = abs($bbox[5] - $bbox[1]);


    // Legend boundaries
	$l_width=($font_w*$max_length)+$font_h+10+5+10;
	$l_height = $font_h * $legend_count + $padding * ($legend_count - 1) + 10 + 10;

    // Coordinates of the top-left corner of the legend
	$l_x1=$W-10-$l_width;
	$l_y1=($H-$l_height)/2;

    // Draw the legend rectangle
	ImageRectangle($img, $l_x1, $l_y1, $l_x1+$l_width, $l_y1+$l_height, $black);

    // Draw legend text and colored squares
	$text_x=$l_x1+10+5+$font_h;
	$square_x=$l_x1+10;
	$y=$l_y1+10;

	$i=0;
	foreach($LEGEND as $v) {
		$dy = $y + ($i * ($font_h + $padding));
		imagettftext($img, $font_size, 0, $text_x, $dy + $font_h, $black, $font_path, $v);
		ImageFilledRectangle($img,
                            $square_x+1,$dy+1,$square_x+$font_h-1,$dy+$font_h-1,
                            $COLORS[$i]);
		ImageRectangle($img,
                       $square_x+1,$dy+1,$square_x+$font_h-1,$dy+$font_h-1,
                       $black);
		$i++;
		}
	
    // Draw the pie chart -----------------------------------------------------------

	$total=array_sum($VALUES);
	$anglesum=$angle=Array(0);
	$i=1;

    // Calculate angles
	while ($i<count($VALUES)) {
		$part=$VALUES[$i-1]/$total;
		$angle[$i]=floor($part*360);
		$anglesum[$i]=array_sum($angle);
		$i++;
		}
	$anglesum[]=$anglesum[0];

    // Calculate diameter
	$diametr=$l_x1-10-10;

    // Calculate the coordinates of the ellipse center
	$circle_x=($diametr/2)+10;
	$circle_y=$H/2-10;

    // Adjust the diameter if the ellipse does not fit within the height
	if ($diametr>($H*2)-10-10) $diametr=($H*2)-20-20-40;

    // Draw the shadow
	for ($j=20;$j>0;$j--)
		for ($i=0;$i<count($anglesum)-1;$i++)
			ImageFilledArc($img,$circle_x,$circle_y+$j,
                               $diametr,$diametr/2,
                               $anglesum[$i],$anglesum[$i+1],
                               $SHADOWS[$i],IMG_ARC_PIE);

    // Draw the pie chart
	for ($i=0;$i<count($anglesum)-1;$i++)
		ImageFilledArc($img,$circle_x,$circle_y,
                           $diametr,$diametr/2,
                           $anglesum[$i],$anglesum[$i+1],
                           $COLORS[$i],IMG_ARC_PIE);
	}

// Get GET parameters and split them into arrays by removing commas
$VALUES = isset($_GET['year_counts']) ? explode(',', $_GET['year_counts']) : [];
$LEGEND = isset($_GET['year']) ? explode(',', $_GET['year']) : [];

if (count($VALUES) !== count($LEGEND)) {
    die('Invalid data: the number of years and counts do not match.');
}

// Transparent background
$bgcolor=ImageColorAllocate($img,255,255,200);
imagecolortransparent($img, $bgcolor);

// Colors and shadows arrays
// $COLORS = [];
// $SHADOWS = [];
// Generate random colors and shadows for each element
// foreach ($VALUES as $index => $value) {
//    // Generate a random primary color
//    $red = rand(150, 255);
//    $green = rand(150, 255);
//    $blue = rand(150, 255);
//
//    // Add the primary color to the $COLORS array
//    $COLORS[$index] = imagecolorallocate($img, $red, $green, $blue);
//
//    // Shadow color (darker than the primary color)
//    $shadowRed = max(0, $red - 50);
//    $shadowGreen = max(0, $green - 50);
//    $shadowBlue = max(0, $blue - 50);
//
//    // Add the shadow color to the $SHADOWS array
//    $SHADOWS[$index] = imagecolorallocate($img, $shadowRed, $shadowGreen, $shadowBlue);
//}


// Colors
$COLORS = [
    imagecolorallocate($img, 255, 203, 3),
    imagecolorallocate($img, 220, 101, 29),
    imagecolorallocate($img, 189, 24, 51),
    imagecolorallocate($img, 214, 0, 127),
    imagecolorallocate($img, 98, 1, 96),
    imagecolorallocate($img, 0, 62, 136),
	imagecolorallocate($img, 0, 102, 179),
	imagecolorallocate($img, 0, 145, 195),
	imagecolorallocate($img, 0, 115, 106),
	imagecolorallocate($img, 178, 210, 52),
	imagecolorallocate($img, 137, 91, 74),
	imagecolorallocate($img, 82, 56, 47),
	imagecolorallocate($img, 255, 157, 0),
    imagecolorallocate($img, 60, 179, 113),
    imagecolorallocate($img, 147, 112, 219),
    imagecolorallocate($img, 255, 99, 71),
    imagecolorallocate($img, 70, 130, 180)
];

$SHADOWS = [
	imagecolorallocate($img, 205, 153, 0),
	imagecolorallocate($img, 170, 51, 0),
	imagecolorallocate($img, 139, 0, 1),
	imagecolorallocate($img, 164, 0, 77),
	imagecolorallocate($img, 48, 0, 46),
	imagecolorallocate($img, 0, 12, 86),
	imagecolorallocate($img, 0, 52, 129),
	imagecolorallocate($img, 0, 95, 145),
	imagecolorallocate($img, 0, 65, 56),
	imagecolorallocate($img, 128, 160, 2),
	imagecolorallocate($img, 87, 41, 24),
	imagecolorallocate($img, 32, 6, 0),
	imagecolorallocate($img, 205, 107, 0),
    imagecolorallocate($img, 10, 129, 63),
    imagecolorallocate($img, 97, 62, 169),
    imagecolorallocate($img, 205, 49, 21),
    imagecolorallocate($img, 20, 80, 130)
];

// Call the function to build the diagram
Diagramm($img,$VALUES,$LEGEND);

// Generate the image
ImagePNG($img);
imagedestroy($img);
?>