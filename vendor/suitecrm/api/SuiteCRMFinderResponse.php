<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 6/28/2018
 * Time: 1:20 PM
 */

namespace SuiteCRM\api;

/**
 * Class SuiteCRMFinderResponse
 * @package SuiteCRM\api
 */
class SuiteCRMFinderResponse {
	/**
	 * @var int
	 */
	private $count = 0;

	/**
	 * @var array
	 */
	private $accounts = array();

	/**
	 * @var array
	 */
	private $contacts = array();

	/**
	 * @var array
	 */
	private $leads = array();

	/**
	 * @var array
	 */
	private $domains = array();

	/**
	 * @var array
	 */
	private $accountMap = array();

	/**
	 * @var null
	 */
	private $hasManyRecords = null;

	/**
	 * @var null
	 */
	private $canConvertLead = null;

	/**
	 * @var null
	 */
	private $hasDirectAccountMatch = null;

	/**
	 * @var null
	 */
	private $AccountId = null;

	/**
	 * SuiteCRMFinderResponse constructor.
	 *
	 * @param $repsonse
	 */
	public function __construct($repsonse)
	{
		// checkfor result
		if (isset($response->result))
		{
			// convert result to array if it is not one
			if(!is_array($response->result)) $response->result = array($response->result);

			// get count from result
			$this->count = count($response->result);

			// check each result to assign variables based upon found objects
			foreach ($response->result as $existingRecord)
			{
				switch ($existingRecord->RecordType)
				{
					case 'ACCOUNT':  $this->accounts[$existingRecord->RecordId__c] = $existingRecord; break;
					case 'DOMAIN':   $this->domains[$existingRecord->RecordId__c] = $existingRecord; break;
					case 'CONTACT':  $this->contacts[$existingRecord->RecordId__c] = $existingRecord; break;
					case 'LEAD':     $this->leads[$existingRecord->RecordId__c] = $existingRecord; break;
				}

				// if an existing account is present, map account
				if (isset($existingRecord->Account__c))
				{
					$this->accountMap[$existingRecord->Account__c][] = $existingRecord;
				}
			}
		}
	}

	/**
	 * Determines if a lead can be converted
	 *
	 * @return bool|null
	 */
	public function hasLead()
	{
		if (is_null($this->canConvertLead)) $this->canConvertLead = (count($this->leads) == 1);
		return $this->canConvertLead;
	}

	/**
	 * Determines if many records have been associated to this search request
	 *
	 * @return boolean
	 */
	public function hasManyLeads()
	{
		if (is_null($this->hasManyRecords))
		{
			$this->hasManyRecords = count($this->leads) > 1;
		}

		return $this->hasManyRecords;
	}

	/**
	 * Determines if there is a direct account match from a search
	 *
	 * @return bool|null
	 */
	public function hasDirectAccountMatch()
	{
		if (is_null($this->hasDirectAccountMatch))
		{
			$this->hasDirectAccountMatch = (count($this->getAccountMap()) == 1);

			if ($this->hasDirectAccountMatch) $this->AccountId = current(array_keys($this->getAccountMap()));
		}
		return $this->hasDirectAccountMatch;
	}

	/**
	 * Gets the account from a direct account match
	 *
	 * @return null
	 */
	public function getDirectAccountMatch()
	{
		return ($this->hasDirectAccountMatch()) ? $this->AccountId : null;
	}

	/**
	 * Assigns lead id if an existing lead exists
	 *
	 * @return null
	 */
	public function getConvertLeadId()
	{
		if ($this->hasLead())
		{
			$lead = current($this->getLeads());
			return $lead->RecordId__c;
		}
		return null;
	}

	
}