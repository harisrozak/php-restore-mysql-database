<?php
/**
 * PHP Restore MySQL Database
 * @author harisrozak
 */

$get_key = isset($_GET['key']) ? $_GET['key'] : '';
$ResetDB = new ResetDB($get_key);
$ResetDB->do_reset();

Class ResetDB
{	
	function __construct($provided_key = '')
	{	
		$key = 'ecaekey';

		$this->cred['host']		= "localhost";
		$this->cred['user']		= "root";
		$this->cred['passwd'] 	= "root";
		$this->cred['dbName'] 	= "example_db";
		$this->cred['dumpdir'] 	= "/home/harishost/backups-db/example_db.sql";
		$this->cred['prefix']	= "wp_";

		$this->isValidKey = $provided_key == $key ? true : false;
		$this->mysqli = new mysqli($this->cred['host'],$this->cred['user'],$this->cred['passwd'],$this->cred['dbName']);
	}

	public function do_reset()
	{
		$connection = $this->connection();

		if($connection['status'])
		{
			$this->drop_tables();
			$this->restore_tables();

			echo "Restore database finished!";
		}
		else
		{
			echo $connection['message'];
		}
	}

	private function connection()
	{
		$return = array(
			'status' => true,
			'message' => 'Invalid credential'
		);

		// key check
		if(! $this->isValidKey) $return['status'] = false;

		// mysql connect check		
		if($this->mysqli->connect_errno) {
			$return['status'] = false;
			$return['message'] = "Connection failed: %s\n".$this->mysqli->connect_errno;			
		}

		return $return;
	}

	private function drop_tables()
	{
		$prefix = $this->cred['prefix']; // default wordpress
		$prefix_woo = $this->cred['prefix'].'woocommerce_'; // woocomerce

		$sql = "DROP TABLE IF EXISTS {$prefix}commentmeta,{$prefix}comments,{$prefix}links,
			{$prefix}options,{$prefix}postmeta,{$prefix}posts,{$prefix}terms,
			{$prefix}term_relationships,{$prefix}term_taxonomy,
			{$prefix}usermeta,{$prefix}users,
			{$prefix_woo}attribute_taxonomies,{$prefix_woo}downloadable_product_permissions,
			{$prefix_woo}order_itemmeta,{$prefix_woo}order_items,
			{$prefix_woo}tax_rates,{$prefix_woo}tax_rate_locations,
			{$prefix_woo}termmeta;";

		$this->mysqli->query($sql) or die($this->mysqli->error);
	}

	private function restore_tables()
	{
		$templine = '';
		$lines = file($this->cred['dumpdir']);
	
		foreach ($lines as $line)
		{
			if (substr($line, 0, 2) == '--' || $line == '')
			continue;

			$templine .= $line;
	
			if (substr(trim($line), -1, 1) == ';')
			{
				$this->mysqli->query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
				$templine = '';
			}
		}
	}
}