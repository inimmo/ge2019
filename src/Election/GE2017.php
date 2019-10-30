<?php
namespace Election;

use League\Csv\Reader;
use League\Csv\Statement;

class GE2017
{
    const PARTY_CONSERVATIVE = 'C';
    const PARTY_LABOUR = 'Lab';
    const PARTY_LIBERAL_DEMOCRATS = 'LD';
    const PARTY_UKIP = 'UKIP';
    const PARTY_GREEN = 'Green';

    const COLUMN_CODE = 'Code';
    const COLUMN_CONSTITUENCY = 'Constituency';
    const COLUMN_PARTY_ABBREV = 'Party Abbreviation';
    const COLUMN_CANDIDATE_VOTES = 'Candidate Votes';
    const COLUMN_TOTAL_VOTES = 'Total constituency votes';

    /** @var Reader */
    private $reader;

    public function __construct(string $path)
    {
        $this->reader = Reader::createFromPath($path);
        $this->reader->setHeaderOffset(0);
    }

    public function getTotalVotes(string $code)
    {
        return (new Statement())
            ->where(function (array $record) use ($code) {
                return $record[self::COLUMN_CODE] === $code;
            })
            ->limit(1)
            ->process($this->reader)
            ->fetchOne()[self::COLUMN_TOTAL_VOTES];
    }

    public function getPartyVotes(string $code, string $party)
    {
        $record = (new Statement())
            ->where(function (array $record) use ($code, $party) {
                return
                    $record[self::COLUMN_CODE] === $code
                    &&
                    $record[self::COLUMN_PARTY_ABBREV] === $party;
            })
            ->limit(1)
            ->process($this->reader)
            ->fetchOne();

        return $record[self::COLUMN_CANDIDATE_VOTES] ?? 0;
    }

    public function getConstituencyName(string $code)
    {
        return (new Statement())
            ->where(function (array $record) use ($code) {
                return $record['Code'] === $code;
            })
            ->limit(1)
            ->process($this->reader)
            ->fetchOne()[self::COLUMN_CONSTITUENCY];
    }
}
