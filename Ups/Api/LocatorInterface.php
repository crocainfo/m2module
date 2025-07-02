<?php 
namespace Footdistrict\Ups\Api;
 
 
interface LocatorInterface {


	/**
	 * GET for Locator api
	 * @param string $countryCode 
	 * @param string $city 
	 * @param string $postCode 
	 * @param string $addressLine 
	 * @param string $state 
	 * @return string
	 */
	
	public function getLocations($countryCode,$state, $city, $postCode, $addressLine);
}