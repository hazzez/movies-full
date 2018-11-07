<?php

namespace AppBundle\Controller;

use AppBundle\Controller\Pagination\Pagination;
use AppBundle\Entity\EntityMerger;
use AppBundle\Entity\Movie;
use AppBundle\Entity\Role;
use AppBundle\Exception\ValidationException;
use AppBundle\Resource\Filtering\Movie\MovieFilterDefinitionFactory;
use AppBundle\Resource\Filtering\Role\RoleFilterDefinitionFactory;
use AppBundle\Resource\Pagination\Movie\MoviePagination;
use AppBundle\Resource\Pagination\PageRequestFactory;
use AppBundle\Resource\Pagination\Role\RolePagination;
use FOS\HttpCacheBundle\Configuration\InvalidateRoute;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\ControllerTrait;
use Nelmio\ApiDocBundle\Annotation\Model;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * @Security("is_anonymous() or is_authenticated()")
 */
class MoviesController extends AbstractController
{
    use ControllerTrait;

    /**
     * @var EntityMerger
     */
    private $entityMerger;
    /**
     * @var MoviePagination
     */
    private $moviePagination;
    /**
     * @var RolePagination
     */
    private $rolePagination;

    /**
     * @param EntityMerger $entityMerger
     * @param Pagination $pagination
     */
    public function __construct(
        EntityMerger $entityMerger,
        MoviePagination $moviePagination,
        RolePagination $rolePagination
    ) {
        $this->entityMerger = $entityMerger;
        $this->moviePagination = $moviePagination;
        $this->rolePagination = $rolePagination;
    }

    /**
     * @Rest\View()
     */
    public function getMoviesAction(Request $request)
    {
        $pageRequestFactory = new PageRequestFactory();
        $page = $pageRequestFactory->fromRequest($request);

        $movieFilterDefinitionFactory = new MovieFilterDefinitionFactory();
        $movieFilterDefinition = $movieFilterDefinitionFactory->factory($request);

        return $this->moviePagination->paginate(
            $page,
            $movieFilterDefinition
        );
    }

    /**
     * @Rest\View(statusCode=201)
     * @ParamConverter("movie", converter="fos_rest.request_body")
     * @Rest\NoRoute()
     * @SWG\Post(
     *     tags={"Movie"},
     *     summary="Add a new movie resource",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(name="body", in="body", required=true,
     *                                 @SWG\Schema(type="array", @Model(type=Movie::class))),
     *     @SWG\Response(response="201", description="Returned when resource
     *                                   created", @SWG\Schema(type="array",
     *                                   @Model(type=Movie::class))),
     *     @SWG\Response(response="400", description="Returned when invalid
     *                                   date posted"),
     *     @SWG\Response(response="401", description="Returned when not
     *                                   authenticated"),
     *     @SWG\Response(response="403", description="Returned when token is
     *                                   invalid or expired")
     * )
     */
    public function postMoviesAction(
        Movie $movie, ConstraintViolationListInterface $validationErrors
    ) {
        if (count($validationErrors) > 0) {
            throw new ValidationException($validationErrors);
        }

        $em = $this->getDoctrine()
            ->getManager();
        $em->persist($movie);
        $em->flush();

        return $movie;
    }

    /**
     * @Rest\View()
     * @InvalidateRoute("get_movie", params={"movie" = {"expression" =
     *                               "movie.getId()"}})
     * @InvalidateRoute("get_movies")
     * @SWG\Delete()
     * @Security("is_granted('delete', movie)")
     */
    public function deleteMovieAction(?Movie $movie)
    {
        if (null === $movie) {
            return $this->view(
                null,
                404
            );
        }

        $em = $this->getDoctrine()
            ->getManager();
        $em->remove($movie);
        $em->flush();
    }

    /**
     * @Rest\View()
     * @Cache(public=true, maxage=3600, smaxage=3600)
     * @SWG\Get(
     *     tags={"Movie"},
     *     summary="Gets the movie",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(name="movie", in="path", type="integer",
     *                                  description="Movie id", required=true),
     *     @SWG\Response(response="200", description="Returned when
     *                                   successful", @SWG\Schema(type="array",
     *                                   @Model(type=Movie::class))),
     *     @SWG\Response(response="404", description="Returned when movie is
     *                                   not found")
     * )
     */
    public function getMovieAction(?Movie $movie)
    {
        if (null === $movie) {
            return $this->view(
                null,
                404
            );
        }

        return $movie;
    }

    /**
     * @Rest\View()
     */
    public function getMovieRolesAction(Request $request, Movie $movie)
    {
        $pageRequestFactory = new PageRequestFactory();
        $page = $pageRequestFactory->fromRequest($request);

        $roleFilterDefinitionFactory = new RoleFilterDefinitionFactory();
        $roleFilterDefinition = $roleFilterDefinitionFactory->factory(
            $request,
            $movie->getId()
        );

        return $this->rolePagination->paginate(
            $page,
            $roleFilterDefinition
        );
    }

    /**
     * @Rest\View(statusCode=201)
     * @ParamConverter("role", converter="fos_rest.request_body",
     *                         options={"deserializationContext"={"groups"={"Deserialize"}}})
     * @Rest\NoRoute()
     */
    public function postMovieRolesAction(
        Movie $movie, Role $role,
        ConstraintViolationListInterface $validationErrors
    ) {
        if (count($validationErrors) > 0) {
            throw new ValidationException($validationErrors);
        }

        $role->setMovie($movie);

        $em = $this->getDoctrine()
            ->getManager();

        $em->persist($role);
        $movie->getRoles()
            ->add($role);

        $em->persist($movie);
        $em->flush();

        return $role;
    }

    /**
     * @Rest\NoRoute()
     * @ParamConverter("modifiedMovie", converter="fos_rest.request_body",
     *     options={"validator" = {"groups" = {"Patch"}}}
     * )
     * @Security("is_authenticated()")
     * @SWG\Patch()
     */
    public function patchMovieAction(
        ?Movie $movie, Movie $modifiedMovie,
        ConstraintViolationListInterface $validationErrors
    ) {
        if (null === $movie) {
            return $this->view(
                null,
                404
            );
        }

        if (count($validationErrors) > 0) {
            throw new ValidationException($validationErrors);
        }

        // Merge entities
        $this->entityMerger->merge(
            $movie,
            $modifiedMovie
        );

        // Persist
        $em = $this->getDoctrine()
            ->getManager();
        $em->persist($movie);
        $em->flush();

        // Return
        return $movie;
    }
}