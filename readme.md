## Windrider

[![Build Status](https://travis-ci.org/ozziest/windrider.svg)](https://travis-ci.org/ozziest/windrider)
[![Total Downloads](https://poser.pugx.org/ozziest/windrider/d/total.svg)](https://packagist.org/packages/ozziest/windrider)
[![Latest Stable Version](https://poser.pugx.org/ozziest/windrider/v/stable.svg)](https://la.org/packages/ozziest/windrider)
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
    $windrider = new Windrider();
    $result = $windrider->runOrFail($data, $rules);
}
catch (\Exception $exception)
{
    var_dump($windrider->getErrors());
}
```

#### Methods

- `run($data, $rules)`
- `runOrFail($data, $rules)`
- `getErrors()`
- `setErrors($messages)`


#### License

[MIT](https://opensource.org/licenses/MIT)