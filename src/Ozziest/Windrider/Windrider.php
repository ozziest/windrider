<?php namespace Ozziest\Windrider;

class Windrider {

    /**
     * Error messages
     *
     * @var array
     */
    private static $messages = [
            'required'           => "The {1} field is required.",
            'valid_email'        => "The {1} field must contain a valid email address.",
            'min_length'         => "The {1} field must be at least {2} characters in length.",
            'max_length'         => "The {1} field can not exceed {2} characters in length.",
            'exact_length'       => "The {1} field must be exactly {2} characters in length.",
            'alpha'              => "The {1} field may only contain alphabetical characters.",
            'alpha_numeric'      => "The {1} field may only contain alpha-numeric characters.",
            'alpha_dash'         => "The {1} field may only contain alpha-numeric characters, underscores, and dashes.",
            'numeric'            => "The {1} field must contain only numbers.",
            'integer'            => "The {1} field must contain an integer.",
            'regex_match'        => "The {1} field is not in the correct format.",
            'matches'            => "The {1} field does not match the {2} field.",
            'is_natural'         => "The {1} field must contain only positive numbers.",
            'is_natural_no_zero' => "The {1} field must contain a number greater than zero.",
            'decimal'            => "The {1} field must contain a decimal number.",
            'less_than'          => "The {1} field must contain a number less than {2}.",
            'greater_than'       => "The {1} field must contain a number greater than {2}."
        ];

    /**
     * Data
     *
     * @var array
     */
    private static $data = [];

    /**
     * Error list 
     *
     * @var array
     */
    private static $errors = [];

    /**
     * This method returns the error array
     *
     * @return array
     */
    public static function getErrors()
    {
        return self::$errors;
    }

    /**
     * This method sets the error messages
     *
     * @param  array $message
     * @return null
     */
    public static function setErrors($messages)
    {
        self::$messages = $messages;
    }

    /**
     * Run the Validator
     *
     * This function does all the work.
     *
     * @return  bool
     */
    public static function run($data, $rules)
    {
        self::$errors = [];
        self::$data = $data;
        $status = true;
        foreach ($rules as $key => $value) 
        {
            // Temel ayarlamalar
            $field = $value[0];
            $name  = $value[1];
            $ruleArray = self::parseRules($value[2]);            
            $fieldValue = '';

            // Veri gönderilmiş mi?
            if (isset($data[$field]))
            {
                $fieldValue = $data[$field];
            }
            
            $defined = self::required($fieldValue);

            foreach ($ruleArray as $sub => $rule) 
            {
                // Kural çalıştırılır
                if (strlen($rule->name) > 0 && ($rule->name === 'required' || ($rule->name !== 'required' && $defined)))
                {
                    $result = call_user_func_array([__NAMESPACE__ .'\Windrider', $rule->name], [$fieldValue, $rule->arg]);
                    // Hata kontrol edilir
                    if ($result === false) 
                    {
                        $status = false;
                        $message = self::$messages[$rule->name];
                        $message = str_replace('{1}', $name, $message);
                        $message = str_replace('{2}', $rule->arg, $message);
                        array_push(self::$errors, $message);
                    }                    
                }
            }
        }
        return $status;
    }

    public static function runOrFail($data, $rules)
    {
        if (self::run($data, $rules) === false)
        {
            throw new ValidationException('Form validation error!');
        }
        return true;
    }

    /**
     * Required
     *
     * @param   string
     * @return  bool
     */
    public static function required($str)
    {
        return is_array($str) ? (bool) count($str) : (trim($str) !== '');
    }

    /**
     * Performs a Regular Expression match test.
     *
     * @param   string
     * @param   regex
     * @return  bool
     */
    public static function regex_match($str, $regex)
    {
        return (bool) preg_match($regex, $str);
    }

    /**
     * Match one field to another
     *
     * @param   string
     * @param   field
     * @return  bool
     */
    public static function matches($str, $field)
    {
        return isset(self::$data[$field], self::$data[$field])
                    ? ($str === self::$data[$field])
                    : FALSE;

    }

    /**
     * Minimum Length
     *
     * @param   string
     * @param   value
     * @return  bool
     */
    public static function min_length($str, $val)
    {
        if (!is_numeric($val))
        {
            return FALSE;
        }
        return ($val <= mb_strlen($str));
    }

    /**
     * Max Length
     *
     * @param   string
     * @param   value
     * @return  bool
     */
    public static function max_length($str, $val)
    {
        if ( ! is_numeric($val))
        {
            return FALSE;
        }
        return ($val >= mb_strlen($str));
    }

    /**
     * Exact Length
     *
     * @param   string
     * @param   value
     * @return  bool
     */
    public static function exact_length($str, $val)
    {
        if ( ! is_numeric($val))
        {
            return FALSE;
        }
        return (mb_strlen($str) === (int) $val);
    }

    /**
     * Valid Email
     *
     * @param   string
     * @return  bool
     */
    public static function valid_email($str)
    {
        if (function_exists('idn_to_ascii') && $atpos = strpos($str, '@'))
        {
            $str = substr($str, 0, ++$atpos).idn_to_ascii(substr($str, $atpos));
        }
        return (bool) filter_var($str, FILTER_VALIDATE_EMAIL);
    }

    /**
     * Alpha
     *
     * @param   string
     * @return  bool
     */
    public static function alpha($str)
    {
        return ctype_alpha($str);
    }

    /**
     * Alpha-numeric
     *
     * @param   string
     * @return  bool
     */
    public static function alpha_numeric($str)
    {
        return ctype_alnum((string) $str);
    }

    /**
     * Alpha-numeric with underscores and dashes
     *
     * @param   string
     * @return  bool
     */
    public static function alpha_dash($str)
    {
        return (bool) preg_match('/^[a-z0-9_-]+$/i', $str);
    }

    /**
     * Numeric
     *
     * @param   string
     * @return  bool
     */
    public static function numeric($str)
    {
        return (bool) preg_match('/^[\-+]?[0-9]*\.?[0-9]+$/', $str);
    }

    /**
     * Integer
     *
     * @param   string
     * @return  bool
     */
    public static function integer($str)
    {
        return (bool) preg_match('/^[\-+]?[0-9]+$/', $str);
    }

    /**
     * Decimal number
     *
     * @param   string
     * @return  bool
     */
    public static function decimal($str)
    {
        return (bool) preg_match('/^[\-+]?[0-9]+\.[0-9]+$/', $str);
    }

    /**
     * Greather than
     *
     * @param   string
     * @return  bool
     */
    public static function greater_than($str, $min)
    {
        return is_numeric($str) ? ($str > $min) : FALSE;
    }

    /**
     * Less than
     *
     * @param   string
     * @return  bool
     */
    public static function less_than($str, $max)
    {
        return is_numeric($str) ? ($str < $max) : FALSE;
    }

    /**
     * Is a Natural number  (0,1,2,3, etc.)
     *
     * @param   string
     * @return  bool
     */
    public static function is_natural($str)
    {
        return ctype_digit((string) $str);
    }

    /**
     * Is a Natural number, but not a zero  (1,2,3, etc.)
     *
     * @param   string
     * @return  bool
     */
    public static function is_natural_no_zero($str)
    {
        return ($str != 0 && ctype_digit((string) $str));
    }


    private static function parseRules($string)
    {
        $ruleArray = [];
        foreach (explode('|', $string) as $key => $value) 
        {
            $name = $value;
            $arg = '';
            if (strpos($value, '[') !== false)
            {
                $name = substr($value, 0, strpos($value, '['));
                $arg = substr(
                    $value, 
                    strpos($value, '[') + 1, 
                    strpos($value, ']') - strpos($value, '[') - 1
                );
            }
            array_push($ruleArray, (object) [
                'name' => $name, 
                'arg'  => $arg
            ]);
        }
        return $ruleArray;
    }    
    
}
