<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Movie;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadMovieData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $movie1 = new Movie();
        $movie1->setTitle('Green Mile');
        $movie1->setDescription('The lives of guards on Death Row...');
        $movie1->setTime(189);
        $movie1->setYear(1999);

        $manager->persist($movie1);
        $manager->flush();
    }
}