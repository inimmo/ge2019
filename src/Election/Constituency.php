<?php
namespace Election;

class Constituency
{
    /** @var string */
    private $code;

    /** @var array */
    private $votes;

    public function __construct(string $code)
    {
        $this->code = $code;
    }

    public static function get(string $code)
    {
        $constituency = new self($code);
        (new GEReader())->addVotes($constituency);

        return $constituency;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getName()
    {
        return ConstituencyData::getConstituencyName($this->code);
    }

    public function addVoteHistory(int $year, string $party, int $votes)
    {
        $this->votes[$year][$party] = $votes;
    }
}
