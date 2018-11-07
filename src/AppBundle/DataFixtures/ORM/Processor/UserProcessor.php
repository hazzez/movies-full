<?php

namespace AppBundle\DataFixtures\ORM\Processor;

use AppBundle\Entity\User;
use Fidry\AliceDataFixtures\ProcessorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserProcessor implements ProcessorInterface
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function preProcess(string $id, $object)
    {
        if (!$object instanceof User) {
            return;
        }

        $password = $this->passwordEncoder->encodePassword($object, $object->getPassword());
        $object->setPassword($password);
    }

    public function postProcess(string $id, $object)
    {

    }
}