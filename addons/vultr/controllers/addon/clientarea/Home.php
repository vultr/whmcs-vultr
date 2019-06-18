<?php

namespace MGModule\vultr\controllers\addon\clientarea;

use MGModule\vultr as main;

/**
 * Description of home
 *
 * @author Michal Czech <michael@modulesgarden.com>
 */
class Home extends main\mgLibs\process\AbstractController
{

	public function indexHTML($input = array())
	{

		$form = new main\mgLibs\forms\Creator('access');
		$form->addField('text', 'access[name]', array(
			'required' => true,
			'dataAttr' => array('error' => main\mgLibs\Lang::T('Field is required')),
			'id' => 'mg-access-name',
			'labelcolWidth' => 2,
			'colWidth' => 9,
		));

		$options = array(main\mgLibs\Lang::T("Unassign"));
		$repository = new main\models\categories\Categories();
		foreach ($repository->get() as $entity)
		{
			$options[$entity->getId()] = $entity->getName();
		}


		$form->addField('select', 'access[categoryId]', array(
			'options' => $options,
			'id' => 'mg-access-categoryId',
			'labelcolWidth' => 2,
			'colWidth' => 9,
			'select2' => true,
			'translateOptions' => false,
		));

		$form->addField('text', 'access[username]', array(
			'required' => true,
			'dataAttr' => array('error' => main\mgLibs\Lang::T('Field is required')),
			'id' => 'mg-access-name',
			'labelcolWidth' => 2,
			'colWidth' => 9,
		));

		$form->addField('password', 'access[password]', array(
			'required' => true,
			'dataAttr' => array('error' => main\mgLibs\Lang::T('Field is required')),
			'id' => 'mg-access-password',
			'labelcolWidth' => 2,
			'showPassword' => true,
			'colWidth' => 9,
		));


		$form->addField('text', 'access[websiteUrl]', array(
			'id' => 'mg-access-websiteUrl',
			'labelcolWidth' => 2,
			'colWidth' => 9,
		));

		$form->addField('text', 'access[loginUrl]', array(
			'id' => 'mg-access-loginUrl',
			'labelcolWidth' => 2,
			'colWidth' => 9,
		));

		$form->addField('checkbox', 'access[notfChangePass]', array(
			'options' => array('enable', 'notfChangeInsertPass'),
			'value' => "",
			'default' => 1,
			'id' => 'mg-access-notfChangePass',
//                'inline' => 'true'
		));


		$form->addField('text', 'access[reminderPeriod]', array(
			'id' => 'mg-access-reminderPeriod',
			'labelcolWidth' => 2,
			'colWidth' => 1,
			"continue" => true,
		));

		$options = array("disabled", "day", "week", "month");
		$form->addField('select', 'access[reminderUnit]', array(
			'options' => $options,
			'id' => 'mg-access-reminderUnit',
			'labelcolWidth' => 2,
			'colWidth' => 2,
			"continue" => true,
			'translateOptions' => true,
			"enableLabel" => false
		));

		$form->addField('checkbox', 'access[reminder]', array(
			'options' => array('reminderInsertPass'),
			'value' => "",
			'default' => 1,
			'id' => 'mg-access-reminder',
			"enableLabel" => false,
			'colWidth' => 5,
		));

		$form->addField('textarea', 'access[note]', array(
			'id' => 'mg-access-note',
			'labelcolWidth' => 2,
			'colWidth' => 9,
		));
		$vars['formAdd'] = $form->getHTML('modal');
		$vars['formEdit'] = $form->rebuildFieldIds('-edit')->getHTML('modal');


		unset($input);

		return array(
			'tpl' => 'home'
		, 'vars' => $vars
		);

	}
}
