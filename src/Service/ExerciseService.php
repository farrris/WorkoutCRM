<?php

namespace App\Service;

use App\Entity\Exercise;
use App\Repository\ExerciseRepository;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExerciseService {
  
  public function __construct(private ExerciseRepository $exerciseRepository) {}

  public function getAll(): Array {
    $exercises = $this->exerciseRepository->findAll();
    $data = [];

    foreach ($exercises as $exercise) {
      $data[] = $exercise->serialize();
    }

    return $data;
  }

  public function getOne($id): Array {
    $exercise = $this->exerciseRepository->findOneBy(['id' => $id]);

    if (empty($exercise)) {
      throw new NotFoundHttpException('Exercise not found');
    }

    $data = $exercise->serialize();

    return $data;
  }

  public function create(Request $request): Array {
    $json_data = json_decode($request->getContent(), true);


    if(empty($json_data['exerciseName']) || empty($json_data['repeatsCount']) || empty($json_data['repeatsCountTimeout'])) {
      return ['message' => 'Expecting mandatory parameters!'];
    }

    $exerciseName = $json_data['exerciseName'];
    $repeatsCount = $json_data['repeatsCount'];
    $repeatsCountTimeout = $json_data['repeatsCountTimeout'];

    $exercise = new Exercise();
    $exercise->setExerciseName($exerciseName);
    $exercise->setRepeatsCount($repeatsCount);
    $exercise->setRepeatsCountTimeout($repeatsCountTimeout);

    $this->exerciseRepository->add($exercise, true);

    $response = $exercise->serialize();

    return $response;
  }

  public function update(Request $request, $id): Array {
    $exercise = $this->exerciseRepository->findOneBy(['id' => $id]);

    if (empty($exercise)) {
      throw new NotFoundHttpException('Exercise not found');
    }

    $json_data = json_decode($request->getContent(), true);

    if(empty($json_data['exerciseName']) || empty($json_data['repeatsCount']) || empty($json_data['repeatsCountTimeout'])) {
      return ['message' => 'Expecting mandatory parameters!'];
    }

    $exerciseName = $json_data['exerciseName'];
    $repeatsCount = $json_data['repeatsCount'];
    $repeatsCountTimeout = $json_data['repeatsCountTimeout'];

    empty($exerciseName) ? true : $exercise->setExerciseName($exerciseName);
    empty($repeatsCount) ? true : $exercise->setRepeatsCount($repeatsCount);
    empty($repeatsCountTimeout) ? true : $exercise->setRepeatsCountTimeout($repeatsCountTimeout);

    $this->exerciseRepository->update($exercise);

    $response = $exercise->serialize();

    return $response;
  }

  public function delete($id): Array {
    $exercise = $this->exerciseRepository->findOneBy(['id' => $id]);
    $this->exerciseRepository->remove($exercise, true);

    return [];
  }
}