<?php


namespace HGPestana\UserBundle\Controller\Api;


use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcher;
use HGPestana\UserBundle\Manager\UserManager;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints;

class UserController extends AbstractFOSRestController
{

    /** @var UserManager */
    private $entityManager;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->entityManager = $this->get('hgpestana.user.manager.user');
    }

    /**
     * API endpoint for creating a new user in the bundle.
     *
     * @param ParamFetcher $paramFetcher
     *
     * @return  Response
     *
     * @Rest\Route("/api/user/create", methods={"POST"})
     *
     * @Rest\RequestParam(name="email", requirements=@Constraints\Email, description="The user email.", nullable=false)
     * @Rest\RequestParam(name="password", requirements=@Constraints\, description="The user password.", nullable=false)
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns the created user",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=User::class, groups={"full"}))
     *     )
     * )
     */
    public function userCreateAction(ParamFetcher $paramFetcher) : Response
    {
        $user = $this->entityManager->create(
            $paramFetcher->get('email'),
            $paramFetcher->get('password')
        );

        $user = $this->entityManager->save($user);
        $view = $this->view($user);

        return $this->handleView($view);
    }

    public function userReadAction() : Response
    {
        $user = $this->getUser();
        $view = $this->view($user);

        return $this->handleView($view);
    }

    public function userUpdateAction(ParamFetcher $paramFetcher) : Response
    {

    }

    public function userDeleteAction() : Response
    {

    }

    public function userListAction() : Response
    {

    }
}