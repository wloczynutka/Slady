<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="gpxtrack")
 */
class GpxTrack
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="TrackPoint", mappedBy="gpxTrackId")
     */
    protected $trackPoints;

    public function __construct(){
        $this->trackPoints = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return GpxTrack
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add trackPoints
     *
     * @param \AppBundle\Entity\TrackPoint $trackPoints
     * @return GpxTrack
     */
    public function addTrackPoint(\AppBundle\Entity\TrackPoint $trackPoints)
    {
        $this->trackPoints[] = $trackPoints;

        return $this;
    }

    /**
     * Remove trackPoints
     *
     * @param \AppBundle\Entity\TrackPoint $trackPoints
     */
    public function removeTrackPoint(\AppBundle\Entity\TrackPoint $trackPoints)
    {
        $this->trackPoints->removeElement($trackPoints);
    }

    /**
     * Get trackPoints
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTrackPoints()
    {
        return $this->trackPoints;
    }
}
