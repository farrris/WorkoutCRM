<?php

namespace App\Controller;

use App\Service\WorkoutTypeService;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WorkoutTypeController extends AbstractController
{   

    public function __construct(private WorkoutTypeService $workoutTypeService)
    {

    }

    public function index(): JsonResponse
    {   
        $data = $this->workoutTypeService->getAll();
        $response = new JsonResponse($data, Response::HTTP_OK);
        $response->setEncodingOptions(JSON_UNESCAPED_UNICODE);
        return $response;
    }

    public function create(Request $request): JsonResponse
    {   
        $data = $this->workoutTypeService->create($request);
        $response = new JsonResponse($data, Response::HTTP_OK);
        $response->setEncodingOptions(JSON_UNESCAPED_UNICODE);
        return $response;
    }

    public function show($id): JsonResponse
    {   
        try {
            $data = $this->workoutTypeService->getOne($id);
            $response = new JsonResponse($data, Response::HTTP_OK);
            $response->setEncodingOptions(JSON_UNESCAPED_UNICODE);
            
            return $response;
        } catch (NotFoundHttpException $e) {
        return new JsonResponse(["message" => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $data = $this->workoutTypeService->update($request, $id);
            $response = new JsonResponse($data, Response::HTTP_OK);
            $response->setEncodingOptions(JSON_UNESCAPED_UNICODE);
            return $response;
            return new JsonResponse(['status' => 'workoutType updated!'], Response::HTTP_OK);
        } catch (NotFoundHttpException $e) {
            return new JsonResponse(["message" => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }

    public function delete($id): JsonResponse
    {
        try {
            $data = $this->workoutTypeService->delete($id);
            $response = new JsonResponse($data, Response::HTTP_OK);
            $response->setEncodingOptions(JSON_UNESCAPED_UNICODE);
            return $response;
        } catch (NotFoundHttpException $e) {
            return new JsonResponse(["message" => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }
}
