<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="trackpoint")
 */
class TrackPoint
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @ORM\ManyToOne(targetEntity="GpxTrack", inversedBy="trackPoints")
     * @ORM\JoinColumn(name="gpxtrack_id", referencedColumnName="id")
     */
    protected $gpxTrackId;

    /**
     * @ORM\Column(type="float")
     */
    protected $latitude;

    /**
     * @ORM\Column(type="float")
     */
    protected $longitude;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $elevation;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $time;


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
     * Set latitude
     *
     * @param float $latitude
     * @return Trackpoint
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     * @return Trackpoint
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set elevation
     *
     * @param string $elevation
     * @return Trackpoint
     */
    public function setElevation($elevation)
    {
        $this->elevation = $elevation;

        return $this;
    }

    /**
     * Get elevation
     *
     * @return string 
     */
    public function getElevation()
    {
        return $this->elevation;
    }



    /**
     * Get time
     *
     * @return \DateTime 
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set gpxTrackId
     *
     * @param \AppBundle\Entity\GpxTrack $gpxTrackId
     * @return TrackPoint
     */
    public function setGpxTrackId(\AppBundle\Entity\GpxTrack $gpxTrackId = null)
    {
        $this->gpxTrackId = $gpxTrackId;

        return $this;
    }

    /**
     * Get gpxTrackId
     *
     * @return \AppBundle\Entity\GpxTrack 
     */
    public function getGpxTrackId()
    {
        return $this->gpxTrackId;
    }

    /**
     * Set time
     *
     * @param \DateTime $time
     * @return TrackPoint
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }
}
