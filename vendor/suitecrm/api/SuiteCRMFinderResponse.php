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
class SuiteCRMFinderResponse
{
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
	private $trials = array();

	/**
	 * @var array
	 */
	private $emails = array();

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
		if (isset($response->entry_list))
		{
			// convert result to array if it is not one
			if (!is_array($response->entry_list)) $response->entry_list = array($response->entry_list);

			foreach ($response->entry_list as $entryList)
			{
				if (isset($entryList->records))
				{
					foreach ($entryList->records as $record)
					{
						switch ($entryList->name)
						{
							case 'Accounts':  $this->accounts[$record->id->value] = $record; break;
							case 'Contacts':  $this->contacts[$record->id->value] = $record; break;
							case 'Leads':     $this->leads[$record->id->value] = $record; break;

							case 'Trial_Trials':   $this->trials[$record->id->value] = $record; break;
							case 'Emails':   $this->emails[$record->id->values] = $record; break;
						}

						if (isset($record->id->value))
						{
							$this->accountMap[$record->id->value][] = $record;
						}

						$this->count++;
					}
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
			return $lead->id->value;
		}
		return null;
	}

	/**
	 * @return array
	 */
	public function getAccounts()
	{
		return $this->accounts;
	}

	/**
	 * @return array
	 */
	public function getContacts()
	{
		return $this->contacts;
	}

	/**
	 * @return array
	 */
	public function getLeads()
	{
		return $this->leads;
	}

	/**
	 * @return array
	 */
	public function getTrials()
	{
		return $this->trials;
	}

	/**
	 * @return array
	 */
	public function getEmails()
	{
		return $this->emails;
	}

	/**
	 * @return array
	 */
	public function getAccountMap()
	{
		return $this->accountMap;
	}

	/**
	 * @return int
	 */
	public function getCount()
	{
		return $this->count;
	}
	
}