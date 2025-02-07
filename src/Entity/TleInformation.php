<?php

namespace App\Entity;

use App\Entity\Attributes\TleOneToOneReference;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TleInformationRepository")
 */
class TleInformation
{
    use TleOneToOneReference;

    /**
     * @ORM\Column(type="float", precision=14, scale=12, nullable=true)
     */
    public ?float $eccentricity;

    /**
     * @ORM\Column(type="float", precision=16, scale=10, nullable=true)
     */
    public ?float $inclination;

    /**
     * @ORM\Column(type="float", precision=16, scale=10, nullable=true)
     */
    public ?float $raan;

    /**
     * @ORM\Column(type="float", precision=16, scale=10, nullable=true)
     */
    public ?float $semiMajorAxis;

    /**
     * Period for complete orbit in seconds
     *
     * @ORM\Column(type="float", name="`period`", precision=24, scale=10, nullable=true)
     */
    public ?float $period;

    /**
     * Period for complete orbit in seconds
     *
     * @ORM\Column(type="boolean", options={"default":"0"})
     */
    public bool $geostationary = false;

    public function __construct(Tle $tle)
    {
        $this->tle = $tle;
    }
}
