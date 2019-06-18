<?php

/* * ********************************************************************
 * MGMF product developed. (2016-02-09)
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

namespace MGModule\vultr\models\whmcs\emails;

use MGModule\vultr as main;

/**
 * Description of Template
 *
 * @author Pawel Kopec <pawelk@modulesgarden.com>
 * @Table(name=tblemailtemplates,preventUpdate,prefixed=false)
 */
class Template extends main\mgLibs\models\Orm
{

	/**
	 *
	 * @Column(id)
	 * @var int
	 */
	protected $id;

	/**
	 *
	 * @Column()
	 * @var string
	 */
	protected $type;

	/**
	 *
	 * @Column()
	 * @var string
	 */
	protected $name;

	/**
	 *
	 * @Column()
	 * @var string
	 */
	protected $subject;

	/**
	 *
	 * @Column()
	 * @var string
	 */
	protected $message;

	/**
	 *
	 * @Column()
	 * @var string
	 */
	protected $attachments = "";

	/**
	 *
	 * @Column(name=fromname,as=fromName)
	 * @var string
	 */
	protected $fromName = "";

	/**
	 *
	 * @Column(name=fromEmail,as=fromEmail)
	 * @var string
	 */
	protected $fromEmail = "";

	/**
	 *
	 * @Column()
	 * @var string
	 */
	protected $disabled = 0;

	/**
	 *
	 * @Column()
	 * @var string
	 */
	protected $custom = 0;

	/**
	 *
	 * @Column()
	 * @var string
	 */
	protected $language = "";

	/**
	 *
	 * @Column(name=copyto,as=copyTo)
	 * @var string
	 */
	protected $copyTo = "";

	/**
	 *
	 * @Column(name=plaintext,as=plainText)
	 * @var string
	 */
	protected $plainText = 0;

	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param int $id
	 * @return \MGModule\vultr\models\whmcs\admins\Template
	 */
	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}

	public function getType()
	{
		return $this->type;
	}

	/**
	 *
	 * @param string $type
	 * @return \MGModule\vultr\models\whmcs\admins\Template
	 */
	public function setType($type)
	{
		$this->type = $type;
		return $this;
	}

	public function getName()
	{
		return $this->name;
	}

	/**
	 *
	 * @param string $name
	 * @return \MGModule\vultr\models\whmcs\admins\Template
	 */
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}

	public function getSubject()
	{
		return $this->subject;
	}

	/**
	 *
	 * @param string $subject
	 * @return \MGModule\vultr\models\whmcs\admins\Template
	 */
	public function setSubject($subject)
	{
		$this->subject = $subject;
		return $this;
	}

	public function getMessage()
	{
		return $this->message;
	}

	/**
	 *
	 * @param string $message
	 * @return \MGModule\vultr\models\whmcs\admins\Template
	 */
	public function setMessage($message)
	{
		$this->message = $message;
		return $this;
	}

	public function getAttachments()
	{
		return $this->attachments;
	}

	/**
	 *
	 * @param string $attachments
	 * @return \MGModule\vultr\models\whmcs\admins\Template\
	 */
	public function setAttachments($attachments)
	{
		$this->attachments = $attachments;
		return $this;
	}

	public function getFromName()
	{
		return $this->fromName;
	}

	/**
	 *
	 * @param string $fromName
	 * @return \MGModule\vultr\models\whmcs\admins\Template
	 */
	public function setFromName($fromName)
	{
		$this->fromName = $fromName;
		return $this;
	}

	public function getFromEmail()
	{
		return $this->fromEmail;
	}

	/**
	 *
	 * @param string $fromEmail
	 * @return \MGModule\vultr\models\whmcs\admins\Template
	 */
	public function setFromEmail($fromEmail)
	{
		$this->fromEmail = $fromEmail;
		return $this;
	}

	public function getDisabled()
	{
		return $this->disabled;
	}

	/**
	 *
	 * @param string $disabled
	 * @return \MGModule\vultr\models\whmcs\admins\Template
	 */
	public function setDisabled($disabled)
	{
		$this->disabled = $disabled;
		return $this;
	}

	public function getCustom()
	{
		return $this->custom;
	}

	/**
	 *
	 * @param string $custom
	 * @return \MGModule\vultr\models\whmcs\admins\Template
	 */
	public function setCustom($custom)
	{
		$this->custom = $custom;
		return $this;
	}

	public function getLanguage()
	{
		return $this->language;
	}

	/**
	 *
	 * @param string $language
	 * @return \MGModule\vultr\models\whmcs\admins\Template
	 */
	public function setLanguage($language)
	{
		$this->language = $language;
		return $this;
	}

	public function getCopyTo()
	{
		return $this->copyTo;
	}

	/**
	 *
	 * @param string $copyTo
	 * @return \MGModule\vultr\models\whmcs\admins\Template
	 */
	public function setCopyTo($copyTo)
	{
		$this->copyTo = $copyTo;
		return $this;
	}

	public function getPlainText()
	{
		return $this->plainText;
	}

	/**
	 *
	 * @param string $plainText
	 * @return \MGModule\vultr\models\whmcs\admins\Template
	 */
	public function setPlainText($plainText)
	{
		$this->plainText = $plainText;
		return $this;
	}


}
