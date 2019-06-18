# Vultr WHMCS Module

The Vultr platform offers a powerful, feature-rich API that allows users to control every aspect of their account. The Vultr WHMCS Module provides hosting providers with a fully automated solution that allows them to offer reliable Cloud Servers on the Vultr Platform to their customers.

***

## System Requirements
- WHMCS version 7.2.x or newer
- PHP version 7.1.x or newer
- MySQL 5.6, MariaDB 5.6, MariaDB 10.0, or MariaDB 10.1
- ionCube Loader
  
## Prerequisites
- Vultr API Key
- Your WHMCS Server IPs being whitelisted for API Access

## Installation
1. Download the latest release: [Releases](https://github.com/vultr/whmcs-vultr/releases)
2. Upload the module files to your WHMCS Server following the directory hierarchy defined below:
   * modules
     * addons
       * vultr
     * servers
       * vultr
3. Login to your WHMCS Admin Panel and navigate to `Setup -> Addon Modules`.
4. Next to `Vultr Module`, click the `Configure` button.
5. Tick the checkbox next to `Hooks Enabled`.
6. Enter your API key in the `API Key` field.
7. Setup `Access Control` for `Administrator` and other roles you wish to enable it for.
8. Click `Save Changes`.
9. Login to your WHMCS Admin Panel and navigate to `Addons -> Vultr Module` to configure your module options.

***For a more detailed set of instructions visit https://www.vultr.com/docs/vultr-whmcs-module***