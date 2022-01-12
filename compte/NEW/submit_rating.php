<?php
$host = 'localhost';
$dbname = 'sut';
$username = 'root';
$password = '';
$table_command = "
CREATE TABLE `review_table` (
	`review_id` bigint unsigned NOT NULL AUTO_INCREMENT,
	`user_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
	`user_rating` int NOT NULL,
	`user_review` text COLLATE utf8mb4_unicode_ci NOT NULL,
	`datetime` datetime NOT NULL,
	PRIMARY KEY (`review_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
";
$connect = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
session_start();
	
if ($_POST['action'] == 'write_data') {
	$query = 'INSERT INTO review_table (user_name, user_rating, user_review, datetime, id_utilisateur) VALUES ("'.$_POST['user_name'].'", "'.$_POST["rating_data"].'", "'.$_POST["user_review"].'", NOW(),"'.$_SESSION['monid'].'")';
	$connect->query($query);
}
else {
	$total_review = 0;
	$review_content = [];
	$total_user_rating = 0;
	$star_reviews = [0, 0, 0, 0, 0, 0];

	$query = 'SELECT * FROM review_table WHERE id_utilisateur='.$_SESSION['monid'].'';
	$result = $connect->query($query, PDO::FETCH_ASSOC);

	foreach ($result as $row) {
		$total_user_rating = $total_user_rating + $row['user_rating'];
		$review_content[] = [
			'user_name' => $row['user_name'],
			'user_review' => $row['user_review'],
			'rating' => $row['user_rating'],
			'datetime' => $row['datetime']
		];
		$star_reviews[$row['user_rating']]++;
		$total_review++;
	}

	$average_rating = $total_user_rating / $total_review;

	$output = [
		'average_rating' => number_format($average_rating, 1),
		'total_review' => $total_review,
		'star_reviews' => $star_reviews,
		'review_data' => $review_content
	];

	echo json_encode($output);
}
?>