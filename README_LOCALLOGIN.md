# WebVoiceRecorder - Working with local Login Mode
The "local login mode" is based on a simple login with a md5 hashed password in the internal database. Please be careful by using this mode cause all passwords are directly saved in the local database. I strongly recommend to use the [oauth2 authentication flow](README_KEYCLOAK.md).

## Configuration
To use the local mysql based usermanagement flow, please open the config.inc.php configuration file and set the parameter "LOGINMODE" to the value "LOCAL"

`define('LOGINMODE', 'LOCAL');`

After you created the Database and the required tables (see section 'setup' in the [global readme](README.md)) you can create the demo users by insert the script 2_basedata.sql and login to the system.

## Login
Login as user that has been definied by adminarea (or directly in database)

![Login Screen](https://github.com/tschiffler/WebVoiceRecorder/raw/main/Documentation/00%20images/screen_login.png "Login Screen")

## Admin-Area

### User-Management
List of existing Users, new Users can be created by click on specified button. To edit a user just click on the requested row

![List of existing Users](https://github.com/tschiffler/WebVoiceRecorder/raw/main/Documentation/00%20images/usermanagement_list.png "List of existing Users")

Screen to create or edit a User. Only users with role "Speaker" are able to speak content.

![Create new User](https://github.com/tschiffler/WebVoiceRecorder/raw/main/Documentation/00%20images/usermanagement_create.png?raw=true "Create new User")

