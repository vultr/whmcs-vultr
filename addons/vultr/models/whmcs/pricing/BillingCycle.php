<?php

/* * ********************************************************************
 * vultr product developed. (2015-12-08)
 * *
 *
 *  CREATED BY MODULESGARDEN       ->       http://modulesgarden.com
 *  CONTACT                        ->       contact@modulesgarden.com
 *
 *
 * This software is furnished under a license and may be used and copied
 * only  in  accordance  with  the  terms  of such  license and with the
 * inclusion of the above copyright notice.  This software  or any other
 * copies thereof may not be provided or otherwise made available to any
 * other person.  No title to and  ownership of the  software is  hereby
 * transferred.
 *
 *
 * ******************************************************************** */

namespace MGModule\vultr\models\whmcs\pricing;

/**
 * Description of BillingCycle
 *
 * @author Pawel Kopec <pawelk@modulesgarden.com>
 */
class BillingCycle
{

	//Product and Addons
	const FREE = 'free';
	const ONE_TIME = 'onetime';
	const MONTHLY = 'monthly';
	const QUARTERLY = 'quarterly';
	const SEMI_ANNUALLY = 'semiannually';
	const ANNUALLY = 'annually';
	const BIENNIALLY = 'biennially';
	CONST TRIENNIALLY = 'triennially';

	//Domains
	CONST YEAR = 'YEAR';
	CONST YEARS_2 = 'YEARS_2';
	CONST YEARS_3 = 'YEARS_3';
	CONST YEARS_4 = 'YEARS_4';
	CONST YEARS_5 = 'YEARS_5';
	CONST YEARS_6 = 'YEARS_6';
	CONST YEARS_7 = 'YEARS_7';
	CONST YEARS_8 = 'YEARS_8';
	CONST YEARS_9 = 'YEARS_9';
	CONST YEARS_10 = 'YEARS_10';


	static function convertPeriodToString($period)
	{
		if ($period == 1)
		{
			return 'YEAR';
		}

		if ($period > 1 && $period <= 10)
		{
			return 'YEARS_' . $period;
		}

		throw new \MGModule\vultr\mgLibs\exceptions\System('Inalid period: ' . $period);
	}
}

