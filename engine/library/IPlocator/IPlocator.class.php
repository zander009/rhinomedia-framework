<?php 

/*
	$ip = IPlocator::locate('122.3.159.143');
	
	echo '<pre>' . PHP_EOL;
	echo "IP Address => " . $ip->getIPaddress() . PHP_EOL;
	echo "IP Number => " . $ip->getIPnumber() . PHP_EOL;
	echo "IP Version => " . $ip->getIPversion() . PHP_EOL;
	echo "Country Name => " . $ip->getCountryName() . PHP_EOL;
	echo "Country Code => " . $ip->getCountryCode() . PHP_EOL;
	
	echo "Region Name => " . $ip->getRegionName() . PHP_EOL;
	echo "City Name => " . $ip->getCityName() . PHP_EOL;
	echo "Timezone => " . $ip->getTimeZone() . PHP_EOL;
	echo "Latitude => " . $ip->getLatitude() . PHP_EOL;
	echo "Longitude => " . $ip->getLongitude() . PHP_EOL;
	echo "Zip Code => " . $ip->getZipCode() . PHP_EOL;
	echo '</pre>';
*/

class IPlocator{

	private static $_instance = NULL;
	private $_db;
	private $_records;
	private $_lib = "IP2LOCATION-LITE-DB11.BIN";

	private function __construct($ip){
		$lib = $this->_lib;

		$this->_db = new \IP2Location\Database(VENDOR_DIR."ip2Location/ip2location-php/databases/$lib", \IP2Location\Database::FILE_IO);
		$this->_records = $this->_db->lookup($ip, \IP2Location\Database::ALL);
	}

	public static function locate($ip)	
	{
		if(!isset(self::$_instance)):	
		
			self::$_instance = new IPlocator($ip);		
		
		endif;

		return self::$_instance;															
	}

	public function getIPnumber(){return $this->_records['ipNumber'];}
	public function getIPversion(){return $this->_records['ipVersion'];}
	public function getIPaddress(){return $this->_records['ipAddress'];}
	public function getCountryCode(){return $this->_records['countryCode'];}
	public function getCountryName(){return $this->_records['countryName'];}
	public function getRegionName(){return $this->_records['regionName'];}
	public function getCityName(){return $this->_records['cityName'];}
	public function getLatitude(){return $this->_records['latitude'];}
	public function getLongitude(){return $this->_records['longitude'];}
	public function getAreaCode(){return $this->_records['areaCode'];}
	public function getIDDCode(){return $this->_records['iddCode'];}
	public function getWeatherStationCode(){return $this->_records['weatherStationCode'];}
	public function getWeatherStationName(){return $this->_records['weatherStationName'];}
	public function getMCC(){return $this->_records['mcc'];}
	public function getMNC(){return $this->_records['mnc'];}
	public function getMobileCarrierName(){return $this->_records['mobileCarrierName'];}
	public function getUsageType(){return $this->_records['usageType'];}
	public function getElevation(){return $this->_records['elevation'];}
	public function getNetSpeed(){return $this->_records['netSpeed'];}
	public function getTimeZone(){return $this->_records['timeZone'];}
	public function getZipCode(){return $this->_records['zipCode'];}
	public function getDomainName(){return $this->_records['domainName'];}
	public function getISPName(){return $this->_records['isp'];}

}