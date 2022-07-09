# cz-waste-api #
REST API for the Casa Zimbabwe Waste Information Website

Demo Server: https://cz-waste-api.herokuapp.com/

## API  Endpoints ##

### /session ###

***POST /session/create.php***

*Creates a session for the Content Administrator (the Waste Reduction Manager) and returns a token used for updating content. This is a demo so the credentials for logging in are provided here:*
* user: *wrm*
* passphrase: *wrm*

Takes two arguments in the form of a JSON object:
* user: *String* - Admins user name
* passphrase: *String* - Admins passphrase

Returns a JSON object:
* ok: *Number* - Indicates if the operation was succesfull on the backend (1 for success, 0 for failure)
* token (Optional): *String* - Session token created on login, it can be used to modify the data on the server

*Presumibly there is only one elected Waste Reduction Manager, so only one user is permitted to be logged in at a time. If a new session is created the current session is overwriten.*

### /waste ###

***GET /waste/read.php***

*Returns all of the stored waste information.*

No arguments.

Returns a JSON object:
* data: *Array* - Array of waste panel objects
  * name: *String* - Panel name
  * id: *String* - Panel id
  * description: *String* - Panel Description
  * entries: *Array* - Array of items associated with the panel
    * id: *String* - Item id
    * name: *String* - Item name
  * titleCardColor: *String* - Hex value for the top part of the waste panel
  * itemsListColor: *String* - Hex value for the bottom part of the waste panel

Example of returned object:

```
{
  "data": [
    {
      "name": "Panel name",
      "id": "0",
      "description": "Panel description",
      "entries": [
        {
          "id": "0",
          "name": "Item name"
        }
      ],
      "titleCardColor": "#000000",
      "itemsListColor": "#000000"
    }
  ]
}
```

***PUT /waste/update.php***

*Updates all of the stored waste information.*

Takes two arguments in the form of a JSON object:
* token: *String* - Session token created earlier on login
* object: *Object* - The new object containing all of the waste data, must be formatted in the same way as the object returned by *GET /waste/read.php*

Returns a JSON object:
* ok: *Number* - Indicates if the operation was succesfull on the backend (1 for success, 0 for failure)
* message (Optional): *String* - If there was an error when validating indicates it to the user

### /credentials ###

***PUT /credentials/update.php***

*Allows the user to change the login credentials*

Takes five arguments in the form of a JSON object:
* token: *String* - Session token created earlier on login
* oldUsername: *String* - Current user name
* oldPassphrase: *String* - Current passphrase
* newUsername: *String* - New user name
* newPassphrase: *String* - New passphrase

Returns a JSON object:
* ok: *Number* - Indicates if the operation was succesfull on the backend (1 for success, 0 for failure)

*The version of the API that is available to play around with has this feature disabled, it will always fail and return 0. This is to ensure that nobody playing around with the demo API itself or the demo Admin Client can change the credentials at a whim.*
