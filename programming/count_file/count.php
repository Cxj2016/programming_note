<?php
function count_file( $dir, &$total_file_num, &$total_line_num )
{
	$files = scandir( $dir );
	foreach ( $files as $key => $value ) {
		if ( '.' != substr( $value, 0, 1 ) ) {
			if ( is_dir( $dir . "/" . $value ) ) {
				count_file( $dir . "/" . $value, $total_file_num, $total_line_num );
			} else {
				++ $total_file_num;
				$total_line_num += count( file( $dir . "/" . $value ) );
			}
		}
	}
}

$total_file_num = $total_line_num = 0;
$dir            = "/Users/chenxj/Desktop/over";
count_file( $dir, $total_file_num, $total_line_num );
echo $total_file_num,"\n",$total_line_num,"\n";
?>
