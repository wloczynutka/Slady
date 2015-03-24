<?php

namespace Wloczynutka\GpxTrackBundle;

class GpxReader {
	
	// ignore errorous speed (km/h)
	private $minAllowedSpeed = 3;
	private $maxAllowedSpeed = 150;
	
	private $upHill     = 0;
	private $downHill   = 0;
	private $distance   = 0; 
	private $movingTime = 0;
	private	$stopTime   = 0;
	private $maxSpeed   = 0; //km/sec
	
	private $gpxPoints;

	/**
	 * if you want change default values of spped which are tread as wrong,
	 * pass it while creating new distanceFromGpx object. values are in km/h.
	 * 
	 * example:
	 * $track = new distanceFromGpx(1, 200)
	 * 
	 * note:
	 * use $track = new distanceFromGpx(0, 99999) to switch off ignoring wrong gpx points.
	 */
	public function __construct($gpx, $minAllowedSpeed = null, $maxAllowedSpeed = null)
	{
		if(isset($minAllowedSpeed)) {
			$this->minAllowedSpeed = $minAllowedSpeed;
		}
		if(isset($maxAllowedSpeed)) {
			$this->minAllowedSpeed = $minAllowedSpeed;
		}
		$this->gpxPoints = $this->makePointsFromSimpleXml($gpx);
	}
	
	public function calculate() {
		date_default_timezone_set('Europe/Warsaw');
		$distance = $this->processGpxPoints($this->gpxPoints);
	}

	public function extractData4googleMapsPolilyne(){
		// var_dump($this->gpxPoints);
		foreach ($this->gpxPoints as $trackId=> $track) {
			foreach ($track as $trackPointNr => $trackPoint) {
				//var_dump($trackPoint); exit;
				$result[$trackId][] = array(
						'lon' => (float) $trackPoint->attributes()->lon,
						'lat' => (float) $trackPoint->attributes()->lat,
				);
			}
		}
		return $result;
	}

	public function getTrip($value='') {
		$result = new \stdClass;
		$result->upHill   = $this->upHill;
		$result->downHill = -$this->downHill;
		$result->distance = round($this->distance, 2);
		
		$result->movingTime = gmdate('H:i:s', $this->movingTime);
		$result->stopTime = gmdate('H:i:s', $this->stopTime);
		
		$result->avgSpeed = round($this->distance / ($this->movingTime/60/60),2);
		$result->maxSpeed = round($this->maxSpeed*60*60,2);
		return $result;
	}
	
	private function makePointsFromSimpleXml($gpx) {
		// print '<pre>';	
		// print_r($gpx);
		// exit;
		foreach ($gpx->trk as $trackId => $track) {
			$i = 0;
			while ($track->trkseg->trkpt[$i]) {
				$gpxPoints[$trackId][] = $gpx -> trk -> trkseg -> trkpt[$i];
				$i++;
			}
		}
		return $gpxPoints;
	}

	private function processGpxPoints($gpxPoints) {
		foreach ($gpxPoints as $trackId => $track) {
			foreach ($track as $trackPointNr => $trackPoint) {
				if ($trackPointNr != 0) {
					$time = (string) $trackPoint->time;
					$time = strtotime($time);
					$this->distance((float)$lat1, (float)$lon1, (float)$trackPoint->attributes()->lat, (float)$trackPoint->attributes()->lon, $time1, $time);
					$lon1 = $trackPoint->attributes()->lon;
					$lat1 = $trackPoint->attributes()->lat;
					$time1 = $time;
					$this->calculateUpDownHill($elevation1, (float)$trackPoint->ele);
					$elevation1 = (float)$trackPoint->ele;
					// print_r($trackPoint); exit;
				} else {
					$distance = 0;
					$upHill = 0;
					$downhill = 0;
					$lon1 = $trackPoint->attributes()->lon;
					$lat1 = $trackPoint->attributes()->lat;
					$elevation1 = (float) $trackPoint->ele;
					
					$time1 = (string) $trackPoint->time;
					$time1 = strtotime($time1);
				}
			}
		}
	}
	
	# Spherical Law of Cosines
	private function distance($lat1, $lon1, $lat2, $lon2, $time1, $time) {
		$delta_lat = $lat2 - $lat1;
		$delta_lon = $lon2 - $lon1;
		$distance = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($delta_lon));
		$distance = acos($distance);
		$distance = rad2deg($distance);
		$distance = $distance * 60 * 1.1515 * 1.609344;
		$this->distance += $distance; 

		//calculate the time
		$speed = $distance / ($time - $time1);
		if ($distance != 0 && ($speed*60*60) >= $this->minAllowedSpeed) {
			$this->movingTime += ($time - $time1);
		} else {
			$this->stopTime += ($time - $time1);
		}
		
		//check for maxspeed
		if ($speed > $this->maxSpeed && ($speed*60*60) < $this->maxAllowedSpeed ) $this->maxSpeed = $speed; 
	}

	private function calculateUpDownHill($ele1, $ele2) {
		if ($ele2>$ele1){	
			$this->upHill += ($ele2-$ele1);
		}
		if ($ele2<$ele1){
			$this->downHill += ($ele2-$ele1);
		}
	}

}





