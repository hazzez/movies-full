<?php

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Person;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadPersonData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $person1 = new Person();
        $person1->setFirstName('Tom');
        $person1->setLastName('Hanks');
        $person1->setDateOfBirth(new \DateTime('1957-12-10'));

        $manager->persist($person1);
        $manager->flush();
    }
}