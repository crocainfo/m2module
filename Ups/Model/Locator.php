<?php 
namespace Footdistrict\Ups\Model;

use Footdistrict\Ups\Api\LocatorInterface;
use Magento\Framework\Serialize\SerializerInterface;

class Locator implements LocatorInterface{

    protected $scopeConfig;
    protected $curl;
    protected $serializer;
    protected $store;

	public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\HTTP\Client\Curl $curl,
        \Magento\Framework\Locale\Resolver $store,
        SerializerInterface $serializer
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->curl = $curl;
        $this->store = $store;
        $this->serializer = $serializer;
    }


    public function getAuthUpsToken() {
        $this->curl->addHeader("Content-Type", "application/x-www-form-urlencoded");

        $userName = $this->scopeConfig->getValue(
            'ups_configuration/credentials/client_id',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        $password =
            $this->scopeConfig->getValue(
            'ups_configuration/credentials/client_secret',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE);


        $this->curl->setCredentials($userName, $password);

        $urlBase = $this->scopeConfig->getValue(
            'ups_configuration/endpoints/base_url',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
        );
        $urlAuth = $this->scopeConfig->getValue(
            'ups_configuration/endpoints/auth',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
        );

        $url = $urlBase . $urlAuth;

        $this->curl->post($url , ["grant_type" => "client_credentials"]);

        // output of curl request
        if($this->curl->getStatus() === 200){
            $resultRequest = json_decode((string) $this->curl->getBody(), true);
            return $resultRequest["access_token"];
        }else{
            return;
        }
    }

    public function getLocatorUrl(){
        $urlBase = $this->scopeConfig->getValue(
            'ups_configuration/endpoints/base_url',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
        );
        $urlLocator = $this->scopeConfig->getValue(
            'ups_configuration/endpoints/locator',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
        );

        $currentStore = $this->store->getLocale();

        return $urlBase . $urlLocator . "64?Locale=".$currentStore;
    }

	/**
	 * {@inheritdoc}
	 */
	public function getLocations($countryCode, $state,$city, $postCode, $addressLine)
	{
    $out = [];

		$token = $this->getAuthUpsToken();
		$this->curl->addHeader("Content-Type", "application/json");
		$this->curl->addHeader("transactionSrc", "footdistrict.com");
		$this->curl->addHeader("transId", "idNeddedfromParam");
		$this->curl->addHeader("Authorization", "Bearer " . $token);


		$payload = array(
			"LocatorRequest" => array(
			  "Request" => array(
				"TransactionReference" => array(
				  "CustomerContext" => ""
				),
				"RequestAction" => "Locator",
				"RequestOption" => "56"
			  ),
			  "OriginAddress" => array(
				"AddressKeyFormat" => array(
				  "AddressLine" => $addressLine,
				  "PoliticalDivision2" => $city,
				  "PoliticalDivision1" => $state,
				  "PostcodePrimaryLow" => $postCode,
				  "CountryCode" => $countryCode
				),
				"MaximumListSize" => "10"
			  ),
			  "Translate" => array(
				"Locale" => "es_US"
			  ),
			  "UnitOfMeasurement" => array(
				"Code" => "KM"
			  )
			)
		  );

		$payload = $this->serializer->serialize($payload);

		$url= $this->getLocatorUrl();
		$this->curl->post($url, $payload);

		$response = $this->curl->getBody();

    try {

      $responseData = $this->serializer->unserialize($response);
      if(isset($responseData['response']))
      {
        $out['status'] = 'fail';
      }
      else
      {
        $out['status'] = 'ok';
        foreach($responseData['LocatorResponse']['SearchResults']['DropLocation'] as $location)
        {
          $locationData = [
            'id' => $location['AccessPointInformation']['PublicAccessPointID'],
            'name' => $location['AddressKeyFormat']['ConsigneeName'],
            'address' => [
              'addressline' => $location['AddressKeyFormat']['AddressLine'],
              'city' => $location['AddressKeyFormat']['PoliticalDivision2'],
              'postalCode' => $location['AddressKeyFormat']['PostcodePrimaryLow'],
              'countryCode' => $location['AddressKeyFormat']['CountryCode']
            ]
          ];

          $out['locations'][] = [
            'name' => strtolower((string) $location['AddressKeyFormat']['ConsigneeName']),
            'address' => strtolower((string) $location['AddressKeyFormat']['AddressLine']),
            'value' => $this->serializer->serialize($locationData)

          ];
        };
        
      };
  
    } catch (\Exception $e) {

      $out['status'] = 'fail';

    }


		return $this->serializer->serialize($out);

	}




}