<?php


namespace App\Service;


class SearchQueryParser
{

    public function parse(string $query): string
    {
        $terms = explode(' ', trim($query));

        return mb_strtolower($terms[0]);
    }
}