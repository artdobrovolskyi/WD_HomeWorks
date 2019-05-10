<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
	if ($_POST["function"] === "0") {
		indexPage();
	} else if ($_POST["function"] === "1") {
		chatPage();
	}
}

function indexPage()
{
	// variables
	$postUser = $_POST["user"];
	$postPassword = $_POST["password"];
	$_SESSION['user'] = $_POST['user'];


	$filePath = "../json/$postUser.json";

	// json object
	$object = (object)[
		"user" => $postUser,
		"password" => $postPassword,
		"massages" => []
	];

	if ($dir = opendir("../json")) {
		$found = false;
		while ($file = readdir($dir)) {
			if ($file === $postUser . ".json") {
				$found = true;
				break;
			}
		}
		if (!$found) {
			file_put_contents($filePath, json_encode($object), JSON_PRETTY_PRINT);
			header("Location: ../../public/chatWindow.php");
			return;
		}
		$buffer = file_get_contents($filePath);
		$data = json_decode($buffer, true);
		if ($data["password"] === $postPassword) {
			header("Location: ../../public/chatWindow.php");
			return;
		} else {
			$_SESSION['passError'] = "showError";
			header("Location: ../../public/index.php");
			return;
		}
	}

}

function chatPage()
{
	// variables
	$fileName = $_SESSION['user'];
	$filePath = "../json/$fileName.json";


}
