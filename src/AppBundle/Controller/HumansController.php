<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Person;
use AppBundle\Exception\ValidationException;
use AppBundle\Resource\Filtering\Person\PersonFilterDefinitionFactory;
use AppBundle\Resource\Pagination\PageRequestFactory;
use AppBundle\Resource\Pagination\Person\PersonPagination;
use FOS\RestBundle\Controller\ControllerTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use FOS\RestBundle\Controller\Annotations as Rest;

class HumansController extends AbstractController
{
    use ControllerTrait;

    /**
     * @var PersonPagination
     */
    private $personPagination;

    public function __construct(PersonPagination $personPagination)
    {
        $this->personPagination = $personPagination;
    }

    /**
     * @Rest\View()
     */
    public function getHumansAction(Request $request)
    {
        $personFilterDefinitionFactory = new PersonFilterDefinitionFactory();
        $personFilterDefinition = $personFilterDefinitionFactory->factory($request);

        $pageRequestFactory = new PageRequestFactory();
        $page = $pageRequestFactory->fromRequest($request);

        return $this->personPagination->paginate($page, $personFilterDefinition);
    }

    /**
     * @Rest\View(statusCode=201)
     * @ParamConverter("person", converter="fos_rest.request_body")
     * @Rest\NoRoute()
     */
    public function postHumansAction(Person $person, ConstraintViolationListInterface $validationErrors)
    {
        if (count($validationErrors) > 0) {
            throw new ValidationException($validationErrors);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($person);
        $em->flush();

        return $person;
    }

    /**
     * @Rest\View()
     */
    public function deleteHumanAction(?Person $person)
    {
        if (null === $person) {
            return $this->view(null, 404);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($person);
        $em->flush();
    }

    /**
     * @Rest\View()
     */
    public function getHumanAction(?Person $person)
    {
        if (null === $person) {
            return $this->view(null, 404);
        }

        return $person;
    }
}