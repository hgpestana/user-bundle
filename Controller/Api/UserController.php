<?php


namespace HGPestana\UserBundle\Controller;


use Exception;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Response;

class UserController
{

    /**
     * API endpoint for obtaining a paginated list of all projects and its galleries through GET request.
     * Channel requesting the paginated list will only receive a list of the projects who chose to distribute with it.
     *
     *
     * @Rest\QueryParam(name="offset", requirements="\d+", default="0", description="Pagination offset for the
     *     requested list.", nullable=true)
     * @Rest\QueryParam(name="limit", requirements="\d+", default="10", description="Total channels to retrieve per
     *     request.", nullable=true)
     * @Rest\QueryParam(name="project", nullable=true, description="Project identifier for which you need to retrieve
     *     the existing galleries.")
     * @param ParamFetcher $paramFetcher
     *
     * @return Response
     * @throws HttpException
     * @throws Exception
     *
     * @ApiDoc(
     *  section="Distribution",
     *  resource="/distribution/channels",
     *  description="Gets a paginated list of projects and galleries that subscribed to the channel. Optionally, can
     *     filter by a specific project ID.", headers={
     *      {
     *          "name"="vdroom-api-key",
     *          "description"="vdroom-api-key:[Api Key]",
     *          "required" = true
     *      },
     *      {
     *          "name"="vdroom-api-secret",
     *          "description"="vdroom-api-secret:[Api Secret]",
     *          "required" = true
     *      },
     *      {
     *          "name"="Content-Type",
     *          "description"="application/json",
     *          "required" = true
     *      }
     *  },
     *  statusCodes={
     *      200="Returned when the projects' list was obtained successfully",
     *      401="Returned when the channel isn't authenticated.",
     *  }
     * )
     */
    public function userCreateAction(ParamFetcher $paramFetcher): Response
    {

    }

    public function userReadAction(): Response
    {

    }

    public function userUpdateAction(ParamFetcher $paramFetcher): Response
    {

    }

    public function userDeleteAction(): Response
    {

    }

    public function userListAction(): Response
    {

    }
}