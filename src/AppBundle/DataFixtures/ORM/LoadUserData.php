<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function load(ObjectManager $manager)
    {
        $passwordEncoder = $this->container->get('security.password_encoder');

        $user1 = new User();
        $user1->setUsername('john_doe');
        $user1->setPassword($passwordEncoder->encodePassword($user1, 'Secure123!'));
        $user1->setRoles([User::ROLE_ADMIN]);

        $manager->persist($user1);

        $user2 = new User();
        $user2->setUsername('jane_doe');
        $user2->setPassword($passwordEncoder->encodePassword($user2, 'ExampleSecure321!'));
        $user2->setRoles([User::ROLE_ADMIN]);

        $manager->persist($user2);

        $manager->flush();
    }

    /**
     * Sets the container.
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}