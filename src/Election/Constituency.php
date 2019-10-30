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
