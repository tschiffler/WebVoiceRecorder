# WebVoiceRecorder - Working with oauth2 based Login Mode
If you want to use the VoiceRecorder in something like an production mode of if you want to manage your users with an more secure system, I recommend to use the oauth2 based authentication flow. In this example I´ll show how to configure a flow based on an own keycloak instance. 

## Configuration
To use the keycloak based usermanagement flow, please open the config.inc.php configuration file and set the parameter "LOGINMODE" to the value "KEYCLOAK"

`define('LOGINMODE', 'KEYCLOAK');`

## Setting up Keycloak Realm
### Importing example Realm
If you are not used to work with keycloak, I just exported an simple example realm. This realm is already configured for the first steps, so you just can import this, create users with the different roles and do a login and logout. 

So please open your Keycloak instance and import the example Realm located in Documentation/03 KeyCloak

### manual configuration of the keycloak realm
If you are already using an keycloak instance you can create the required configuration by your own. The following configuration is required:

- Create a new Client used for the RecorderFrontend
-- client protocol - openid-connect
-- Root-URL - URL of the location where you will deploy the WebVoiceRecorder
-- Add the "groups" mapper to the client
- Add a new Realm Role 'VOICERECORDER_ADMIN'
- Add a new Realm Role 'VOICERECORDER_SPEAKER'

### Required Fields in User-Objects
The WebVoiceRecorder is using some Field of the user objects. So please fill the following Informations

- Firstname (for display only)
- Lastname (for display only)

Assign the requested role to the Users, if a User does not have one of the defined roles, the login will not work and the user will be directly redirected to the logout page.
- VOICERECORDER_ADMIN for admin users
- VOICERECORDER_SPEAKER for users that just should speak

## Configure Realm-Settings in WebVoiceRecorder
After you created the Configuration in your keycloak instance, please open the config.inc.php file again and fill the values with the information from your installation:

- `define('SYSTEM_URL', '<ownSystemUrl>');`
- `define('SYSTEM_KEYCLOAK_URL', '<urlToKeycloakInstanceIncludingPossibleSubDir>');`
- `define('KEYCLOAK_REALM', '<NameOfOwnRealm>');`
- `define('KEYCLOAK_CLIENT', '<NameOfClient>');`
- `define('KEYCLOAK_CLIENT_SECRET', '<ClientSecret>');`
- `define('KEYCLOAK_ROLE_ADMIN', '<RoleThatWillBeAssigendToAdminusers>'); // VOICERECORDER_ADMIN`
- `define('KEYCLOAK_ROLE_USER', '<RoleThatWillBeAssignedToSpeakers>'); // VOICERECORDER_SPEAKER`