# Session

Specialised session support for [Phico](https://github.com/phico-php/phico)

## Installation

Install using composer

```sh
composer require phico/session
```

## Usage

### Instantiating the Session

Use the session middleware to pass the session through the Request.

```php

```

If no ID is provided or the session id does not exist then a new session will be created.

### Accessing the Session ID

You can get (but not set) the session ID using `$session->id`.

```php
$id = $session->id;
```

### Storing Data

To store data in the session, use the `set` method.

```php
$session->set('key', 'value');
```

### Retrieving Data

To retrieve data from the session, use the `get` method. You can provide a default value that will be returned if the key does not exist.

```php
$value = $session->get('key', 'default');
```

### Checking for Data

To check if a key exists in the session, use the `has` method.

```php
$exists = $session->has('key');
```

### Flash Messages

Flash messages are used to store data that should be available for only the next request.

#### Setting Flash Messages

```php
$session->flash('flash_key', 'flash_value');
```

#### Retrieving Flash Messages

Flash messages are retrieved using the same `get` method.

```php
$flashValue = $session->get('flash_key');
```

### Deleting the Session

To delete a session, use the `delete` method. This removes the session data from the storage.

```php
$session->delete();
```

### Regenerating the Session ID

To regenerate the session ID, which is useful for preventing session fixation attacks, use the `regenerate` method.

```php
$session->regenerate();
```

### Saving the Session

To manually save the session data to the storage, use the `save` method. This is usually handled automatically by middleware.

```php
$session->save();
```

## Issues

If you discover any bugs or issues in behaviour or performance please create an issue, and if you are able a pull request with a fix.

Please make sure to update any tests as appropriate.

For major changes, please open an issue first to discuss what you would like to change.

## License

[BSD-3-Clause](https://choosealicense.com/licenses/bsd-3-clause/)
