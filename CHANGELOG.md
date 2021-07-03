# Change Log

## v2.0.5 (2021-04-21)
### Bug
* Fixes Doesn't show server details in client area [#88](https://github.com/vultr/whmcs-vultr/issues/88)
* Fixes After WHMCS 8 upgrade server creation failed [#91](https://github.com/vultr/whmcs-vultr/issues/91)
* Fixes WHMCS 8.0.2 successfully created the virtual machine, but failed to manage it [#92](https://github.com/vultr/whmcs-vultr/issues/92)
* Fixes Virtual machine ID [#105](https://github.com/vultr/whmcs-vultr/issues/105)
* Can't deploy server in WHMCS 8.1.1 [#106](https://github.com/vultr/whmcs-vultr/issues/106)
### Features
* Various bug fixes
* Quality of life improvements

### Changes
* Updated all deprecated
`use Illuminate\Database\Capsule\Manager as Capsule;`
To:
`use WHMCS\Database\Capsule;`

As recommended by WHMCS.
https://developers.whmcs.com/advanced/db-interaction/

Please NOTE: That I have incorporated some, but NOT all of the fixes from [#101](https://github.com/vultr/whmcs-vultr/issues/101)  
All original credit for those things should be attributed to @jazz7381 and that PR could most likely be closed as mine incorporates the working stuff from there and more.

Also included is a pretty extensive port of the VultrAPI class to V2 which is not in use yet, but is pretty close to being able to be used.

The main issue appears to have been in addVMCustomFields where it was failing to add the subid to tblcustomfieldsvalues
whattheserver@453c76e

This in turn causes the creation to fail and allows customers to keep trying to create servers they thought failed but are detached from the client area and costing the Reseller money and time wasted going to clean those up and reattaching only one to the account manually.

## v2.0.4 (2019-09-19)
### Bug
* Fixes UI Issue where OS would reset upon save [#36](https://github.com/vultr/whmcs-vultr/pull/36)

## v2.0.3 (2019-09-10)
### Enhancement
* Add lang support for update & change buttons [#33](https://github.com/vultr/whmcs-vultr/pull/33)

## v2.0.2 (2019-08-09)
### Fixes
* Fixes broken server icon in addon toolbar [#27](https://github.com/vultr/whmcs-vultr/issues/27)
* Fixes duplicate icons in addon toolbar

## v2.0.1 (2019-07-23)
### Fixes
* Version Mismatch issue


## v2.0.0 (2019-06-25)
### Features
* Various bug fixes
* Quality of life improvements
