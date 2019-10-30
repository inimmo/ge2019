<?php
namespace Election;

use League\Csv\Reader;
use League\Csv\Statement;

class GEReader
{
    const COLUMN_CODE = 'Code';
    const COLUMN_YEAR = 'Year';
    const COLUMN_PARTY_ABBREV = 'Party Abbreviation';
    const COLUMN_CANDIDATE_VOTES = 'Candidate Votes';

    /** @var Reader */
    private $reader;

    public function __construct()
    {
        $path = ROOT . '/data/ge_results.csv';

        $this->reader = Reader::createFromPath($path);
        $this->reader->setHeaderOffset(0);
    }

    public function addVotes(Constituency $constituency)
    {
        $records = (new Statement())
            ->where(function (array $record) use ($constituency) {
                return
                    $record[self::COLUMN_CODE] == $constituency->getCode()
                ;
            })
            ->process($this->reader);

        foreach ($records as $record) {
            $constituency->addVoteHistory(
                $record[self::COLUMN_YEAR],
                $record[self::COLUMN_PARTY_ABBREV],
                str_replace(',', '', $record[self::COLUMN_CANDIDATE_VOTES])
            );
        }
    }
}
