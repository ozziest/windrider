## Windrider

[![Build Status](https://travis-ci.org/ozziest/windrider.svg)](https://travis-ci.org/ozziest/windrider)
[![Total Downloads](https://poser.pugx.org/ozziest/windrider/d/total.svg)](https://packagist.org/packages/ozziest/windrider)
[![Latest Stable Version](https://poser.pugx.org/ozziest/windrider/v/stable.svg)](https://packagist.org/packages/ozziest/windrider)
[![Latest Unstable Version](https://poser.pugx.org/ozziest/windrider/v/unstable.svg)](https://packagist.org/packages/ozziest/windrider)
[![License](https://poser.pugx.org/ozziest/windrider/license.svg)](https://packagist.org/packages/ozziest/windrider)

Windrider is a simple and useful validation library which you can use it on your projects.

#### Installation

```
$ composer require ozziest/windrider
```

#### Usage

```php
try
{
    $data = ['name' => ''];
    $rules = [
        ['name', 'Name', 'required'],
        ['email', 'E-Mail', 'required|valid_email']
    ];
    Ozziest\Windrider\Windrider::runOrFail($data, $rules);
}
catch (Exception $exception)
{
    var_dump(Ozziest\Windrider\Windrider::getErrors());
}
```

#### Methods

- `run($data, $rules)`
- `runOrFail($data, $rules)`
- `getErrors()`
- `setErrors($messages)`

#### Validations

- required
- valid_email
- min_length[n]
- max_length[n]
- exact_length[n]
- alpha
- alpha_numeric
- alpha_dash
- alpha_local (Turkish characters support)
- numeric
- integer
- is_natural
- is_natural_no_zero
- less_than[n]
- greater_than[n]

#### Exception

[ValidationException](src/Ozziest/Windrider/ValidationException.php)

#### License

[MIT](https://opensource.org/licenses/MIT)
