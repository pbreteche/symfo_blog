<?php

namespace App\Tests\Service;

use App\Service\SearchQueryParser;
use PHPUnit\Framework\TestCase;

class SearchQueryParserTest extends TestCase
{

    /**
     * @dataProvider provideTestParse
     */
    public function testParse($input, $expected)
    {
        $parser = new SearchQueryParser();

        $term = $parser->parse($input);
        $this->assertEquals($expected, $term);
    }

    public function provideTestParse()
    {
        return [
            ['rugby poulet symfony', 'rugby'],
            ['KeBaB falafel aéèîù', 'kebab'],
            ['   PHP MySQL Linux', 'php'],
            ['', ''],
        ];
    }
}