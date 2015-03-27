<?php

namespace Wloczynutka\GpxTrackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Task;
use Symfony\Component\HttpFoundation\Request;
use Wloczynutka\GpxTrackBundle\GpxReader;

//use Symfony\Component\HttpFoundation\File\UploadedFile;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('GpxTrackBundle:Default:index.html.twig', array('name' => $name));
    }

    public function newAction(Request $request)
    {
        // create a task and give it some dummy data for this example
        $task = new Task();
        $task->setTask('Write a blog post');
        $task->setDueDate(new \DateTime('tomorrow'));

        $form = $this->createFormBuilder($task)
            ->add('task', 'text')
            ->add('dueDate', 'date')
            ->add('file','file', array('required' => true, 'data_class' => null))
            ->add('save', 'submit', array('label' => 'Create Task'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $gpxFile = $request->files->all();
            $gpxString = file_get_contents($gpxFile['form']['file']->getPath().'/'.$gpxFile['form']['file']->getFilename());
            $gpx = simplexml_load_string($gpxString);
            $tripObj = new GpxReader($this->getDoctrine());
            $tripObj->readAndStoreTracks($gpx);

            $tripObj->calculate();
            $result = $tripObj->getTrip();
            $googleMapArr = $tripObj->extractData4googleMapsPolilyne();

            $i = 1;
            foreach ($googleMapArr as $trackId => $track) {
                $polilyne[$i] = null;
                foreach ($track as $pointId=> $point) {
                    $polilyne[$i] .= 'new google.maps.LatLng('.$point['lat'].', '.$point['lon'].'),';
                }
                $i++;
            }

            d($result, $googleMapArr);
            $layoutVars = array(
                'upHill' => $result->upHill,
                'downHill' => $result->downHill,
                'distance' => $result->distance,
                'movingTime' => $result->movingTime,
                'stopTime' => $result->stopTime,
                'avgSpeed' => $result->avgSpeed,
                'maxSpeed' => $result->maxSpeed,
                'polyLine' => $polilyne[1],
            );
            return $this->render('GpxTrackBundle:Default:map.html.twig', $layoutVars);
        }

        return $this->render('default/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function displayMapAction()
    {
    }

    public function createAction()
    {


        $product = new Product();
        $product->setName('A Foo Bar');
        $product->setPrice('19.99');
        $product->setDescription('Lorem ipsum dolor');

        $em = $this->getDoctrine()->getManager();

        $em->persist($product);
        $em->flush();

        $result = new Response('Created product id '.$product->getId());

        d($result);

        return $result;
    }
}
