<?php

namespace User\V1\Rest\Profile;

use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\ApiTools\Rest\AbstractResourceListener;
use User\Entity\UserProfile as UserProfileEntity;

class ProfileResource extends AbstractResourceListener
{
    /**
     * @var \User\Mapper\UserProfile
     */
    protected $userProfileMapper;

    /**
     * @var \User\V1\Service\Profile
     */
    protected $userProfileService;

    /**
     * @param  \User\Mapper\UserProfile  $userProfileMapper
     * @param  \User\V1\Service\Profile  $userProfileService
     */
    public function __construct(
        $userProfileMapper,
        $userProfileService
    ) {
        $this->userProfileMapper = $userProfileMapper;
        $this->userProfileService = $userProfileService;
    }

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        return new ApiProblem(405, 'The POST method has not been defined');
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for individual resources');
    }

    /**
     * Delete a collection, or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function deleteList($data)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for collections');
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        $userProfile = $this->userProfileMapper
            ->fetchOneBy(['uuid' => $id]);
        if (!($userProfile instanceof UserProfileEntity))
            return new ApiProblem(404, "User Profile not found");

        return $userProfile;
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        return new ApiProblem(405, 'The GET method has not been defined for collections');
    }

    /**
     * Patch (partial in-place update) a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        $userProfile = $this->userProfileMapper
            ->fetchOneBy(['uuid' => $id]);
        if (!($userProfile instanceof UserProfileEntity))
            return new ApiProblem(404, "User Profile not found");

        $input = $this->getInputFilter();
        $this->userProfileService
            ->update($userProfile, $input);

        return $userProfile;
    }

    /**
     * Patch (partial in-place update) a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patchList($data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for collections');
    }

    /**
     * Replace a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function replaceList($data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for collections');
    }

    /**
     * Update a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function update($id, $data)
    {
        return $this->patch($id, $data);
    }
}
