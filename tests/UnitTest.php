<?php 

use Ozziest\Windrider\Windrider;

class UnitTest extends PHPUnit_Framework_TestCase {

    /**
     * @dataProvider falseDataProvider 
     * @expectedException \Exception
     * @expectedExceptionMessage Form validation error!
     */
    public function testFalseData($data, $rules)
    {
        $windrider = new Windrider();
        $result = $windrider->runOrFail($data, $rules);
    }

    /**
     * @dataProvider AcceptableDataProvider 
     */
    public function testAcceptable($data, $rules)
    {
        $windrider = new Windrider([]);
        $result = $windrider->runOrFail($data, $rules);
        $this->assertTrue($result);
    }


    public function AcceptableDataProvider()
    {
        return [

            [
                ['foo' => 'bar'],
                [
                    ['foo', 'Foo Field', 'required']
                ]
            ],

            [
                ['foo' => 'foo@bar.com'],
                [
                    ['foo', 'Foo Field', 'valid_email']
                ]
            ],

            [
                ['foo' => 'foo bar for bar foo bar'],
                [
                    ['foo', 'Foo Field', 'required|min_length[10]']
                ]
            ],

            [
                ['foo' => 'foo'],
                [
                    ['foo', 'Foo Field', 'required|max_length[5]']
                ]
            ],

            [
                ['foo' => 'foo bar'],
                [
                    ['foo', 'Foo Field', 'required|exact_length[7]']
                ]
            ],

            [
                ['foo' => 'foobar'],
                [
                    ['foo', 'Foo Field', 'alpha']
                ]
            ],

            [
                ['foo' => 'foobar123'],
                [
                    ['foo', 'Foo Field', 'alpha_numeric']
                ]
            ],

            [
                ['foo' => 'foo_bar'],
                [
                    ['foo', 'Foo Field', 'alpha_dash']
                ]
            ],

            [
                ['foo' => '12'],
                [
                    ['foo', 'Foo Field', 'numeric']
                ]
            ],

            [
                ['foo' => 666],
                [
                    ['foo', 'Foo Field', 'integer']
                ]
            ],

            [
                ['foo' => 666],
                [
                    ['foo', 'Foo Field', 'is_natural']
                ]
            ],

            [
                ['foo' => 666],
                [
                    ['foo', 'Foo Field', 'is_natural_no_zero']
                ]
            ],

            [
                ['foo' => '9'],
                [
                    ['foo', 'Foo Field', 'less_than[10]']
                ]
            ],

            [
                ['foo' => '11'],
                [
                    ['foo', 'Foo Field', 'greater_than[10]']
                ]
            ],

        ];
    }    


    public function falseDataProvider()
    {
        return [

            [
                ['foo' => ''],
                [
                    ['foo', 'Foo Field', 'required']
                ]
            ],

            [
                ['foo' => 'foo'],
                [
                    ['foo', 'Foo Field', 'valid_email']
                ]
            ],

            [
                ['foo' => 'foo'],
                [
                    ['foo', 'Foo Field', 'required|min_length[10]']
                ]
            ],

            [
                ['foo' => 'foo bar'],
                [
                    ['foo', 'Foo Field', 'required|max_length[5]']
                ]
            ],

            [
                ['foo' => 'foo bar'],
                [
                    ['foo', 'Foo Field', 'required|exact_length[5]']
                ]
            ],

            [
                ['foo' => 'foobar123'],
                [
                    ['foo', 'Foo Field', 'alpha']
                ]
            ],

            [
                ['foo' => 'foo bar123'],
                [
                    ['foo', 'Foo Field', 'alpha_numeric']
                ]
            ],

            [
                ['foo' => 'foo bar'],
                [
                    ['foo', 'Foo Field', 'alpha_dash']
                ]
            ],

            [
                ['foo' => 'foo bar'],
                [
                    ['foo', 'Foo Field', 'numeric']
                ]
            ],

            [
                ['foo' => 666.66],
                [
                    ['foo', 'Foo Field', 'integer']
                ]
            ],

            [
                ['foo' => -1],
                [
                    ['foo', 'Foo Field', 'is_natural']
                ]
            ],

            [
                ['foo' => 0],
                [
                    ['foo', 'Foo Field', 'is_natural_no_zero']
                ]
            ],

            [
                ['foo' => '11'],
                [
                    ['foo', 'Foo Field', 'less_than[10]']
                ]
            ],

            [
                ['foo' => '9'],
                [
                    ['foo', 'Foo Field', 'greater_than[10]']
                ]
            ],

        ];
    }    

}