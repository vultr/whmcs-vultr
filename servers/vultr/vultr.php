<?php
require 'loader.php';

//error_reporting(E_ALL);


function vultr_ConfigOptions($params)
{
	$vultr = new Vultr($params);
	return $vultr->getConfigOptions();
}

function vultr_CreateAccount($params)
{
	$vultr = new Vultr($params);
	return $vultr->createAccount();
}

function vultr_SuspendAccount($params)
{
	$vultr = new Vultr($params);
	return $vultr->suspendAccount();
}

function vultr_UnsuspendAccount($params)
{
	$vultr = new Vultr($params);
	return $vultr->unsuspendAccount();
}

function vultr_TerminateAccount($params)
{
	$vultr = new Vultr($params);
	return $vultr->terminateAccount();
}

function vultr_ChangePackage($params)
{
	$vultr = new Vultr($params);
	return $vultr->changePackage();
}

function vultr_ClientArea($params)
{
	$render = new Vultrender($params);
	return $render->render('ClientArea');
}

function vultr_AdminCustomButtonArray($params)
{
	$vultr = new Vultr($params);
	return $vultr->getAdminCustomButtonArray();
}

function vultr_start($params)
{
	$vultr = new Vultr($params);
	return $vultr->start();
}

function vultr_reboot($params)
{
	$vultr = new Vultr($params);
	return $vultr->reboot();
}

function vultr_halt($params)
{
	$vultr = new Vultr($params);
	return $vultr->halt();
}

function vultr_reinstall($params)
{
	$vultr = new Vultr($params);
	return $vultr->reinstall();
}

function vultr_AdminServicesTabFieldsSave(array $params)
{
	$vultr = new Vultr($params);
	$vultr->verifyAdminServiceSave();
}
