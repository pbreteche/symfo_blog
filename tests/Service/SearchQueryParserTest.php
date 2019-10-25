<?php

namespace App\Tests\Service;

use App\Service\SearchQueryParser;
use PHPUnit\Framework\TestCase;

class SearchQueryParserTest extends TestCase
{
    public function testParse()
    {
        $parser = new SearchQueryParser();

        $term = $parser->parse('rugby poulet symfony');
        $this->assertEquals('rugby', $term);
    }
}