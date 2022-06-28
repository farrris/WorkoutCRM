<?php

namespace App\Service;

use App\Entity\WorkoutType;
use App\Repository\WorkoutTypeRepository;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WorkoutTypeService {
  
  public function __construct(private WorkoutTypeRepository $workoutTypeRepository) {}

  public function getAll(): Array {
    $workout_types = $this->workoutTypeRepository->findAll();
    $data = [];

    foreach ($workout_types as $workout_type) {
      $data[] = $workout_type->serialize();
    }

    return $data;
  }

  public function getOne($id): Array {
    $workout_type = $this->workoutTypeRepository->findOneBy(['id' => $id]);

    if (empty($workout_type)) {
      throw new NotFoundHttpException('WorkoutType not found');
    }

    $data = $workout_type->serialize();

    return $data;
  }

  public function create(Request $request): Array {
    $json_data = json_decode($request->getContent(), true);

    if(empty($json_data['typeName'])) {
      return ['message' => 'Expecting mandatory parameters!'];
    }

    $type_name = $json_data['typeName'];

    $workout_type = new WorkoutType();
    $workout_type->setTypeName($type_name);

    $this->workoutTypeRepository->add($workout_type, true);

    $response = $workout_type->serialize();

    return $response;
  }

  public function update(Request $request, $id): Array {
    $workout_type = $this->workoutTypeRepository->findOneBy(['id' => $id]);

    if (empty($workout_type)) {
      throw new NotFoundHttpException('WorkoutType not found');
    }

    $json_data = json_decode($request->getContent(), true);

    if(empty($json_data['typeName'])) {
      return ['message' => 'Expecting mandatory parameters!'];
    }

    $type_name = $json_data['typeName'];

    $workout_type->setTypeName($type_name);

    if(empty($type_name)) {
      return ['message' => 'Expecting mandatory parameters!'];
    }

    $this->workoutTypeRepository->update($workout_type);

    $response = $workout_type->serialize();

    return $response;
  }

  public function delete($id): Array {
    $workout_type = $this->workoutTypeRepository->findOneBy(['id' => $id]);
    $this->workoutTypeRepository->remove($workout_type, true);

    return [];
  }
}