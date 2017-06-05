//Script to log transactions
<?php
require __DIR__ . '/vendor/autoload.php';
require_once("env.php");
use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;
use Coinbase\Wallet\Enum\Param;

function dump_transactions($transactions) {
	echo "<table class='pure-table' style='width: 100%;'>";
	
	echo "<th>Type</th><th>Status</th><th>BTC</th><th>USD</th><th>Description</th><th>Date</th>";
	
	foreach($transactions as $t) {
		echo "<tr>";
		echo "<td>{$t->getType()}</td>";
		echo "<td>{$t->getStatus()}</td>";
		echo "<td>{$t->getAmount()->getAmount()}</td>";
		echo "<td>{$t->getNativeAmount()->getAmount()}</td>";
		echo "<td>{$t->getDescription()}</td>";
		echo "<td>{$t->getCreatedAt()->format('m/d/Y G:i:s')}</td>";
		echo "</tr>";
	}
	
	echo "</table>";
}

$configuration = Configuration::apiKey($api_key, $api_secret);
$client = Client::create($configuration);
$account_id = 'bac160f0-05b9-5ecd-8752-2e6a63115ed8';
$account = $client->getAccount($account_id);
$transactions = $client->getAccountTransactions($account, [ Param::FETCH_ALL => true ] );

echo "Current BTC Balance: " . $account->getBalance()->getAmount() . $account->getBalance()->getCurrency() . "<br>";
echo "Current USD Value: " . $account->getNativeBalance()->getAmount() . $account->getNativeBalance()->getCurrency() . "<br>";

dump_transactions($transactions);
//var_dump($transactions);
?>

<!DOCTYPE html>
<head>
	<link rel="stylesheet" href="https://unpkg.com/purecss@0.6.2/build/pure-min.css" integrity="sha384-UQiGfs9ICog+LwheBSRCt1o5cbyKIHbwjWscjemyBMT9YCUMZffs6UqUTd0hObXD" crossorigin="anonymous">
</head>
</html>
