<?php

namespace App\Service;

use App\Entity\Workout;
use App\Entity\WorkoutType;
use App\Entity\Exercise;

use App\Repository\WorkoutRepository;
use App\Repository\WorkoutTypeRepository;
use App\Repository\ExerciseRepository;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WorkoutService {
  
  public function __construct(private WorkoutRepository $workoutRepository,
                              private WorkoutTypeRepository $workoutTypeRepository,
                              private ExerciseRepository $exerciseRepository) {}

  public function getAll(): Array {
    $workouts = $this->workoutRepository->findAll();
    $data = [];

    foreach ($workouts as $workout) {
      $exercises = $workout->getExercises();

      $exercise_array = [];

      foreach($exercises as $exercise) {
        $exercise_array[] = $exercise->serialize();
      }

      $data[] = $workout->serialize($exercise_array);
    }

    return $data;
  }

  public function getOne($id): Array {
    $workout = $this->workoutRepository->findOneBy(['id' => $id]);

    if (empty($workout)) {
      throw new NotFoundHttpException('Workout not found');
    }

    $exercises = $workout->getExercises();

      foreach($exercises as $exercise) {
        $exercise_array[] = $exercise->serialize();
      }

    $data = $workout->serialize($exercise_array);

    return $data;
  }

  public function create(Request $request): Array {
    $json_data = json_decode($request->getContent(), true);

    if(empty($json_data['workoutName']) || 
       empty($json_data['workoutTypeId']) || 
       empty($json_data['exerciseTimeout']) ||
       empty($json_data['setsCountTimeout']) ||
       empty($json_data['cyclesCountTimeout']) ||
       empty($json_data['cyclesCount']) ||
       empty($json_data['setsCount']) ||
       empty($json_data['exercises'])
       ) {
      return ['message' => 'Expecting mandatory parameters!'];
    }

    $workoutName = $json_data['workoutName'];
    $workoutTypeId = $json_data['workoutTypeId'];
    $exerciseTimeout = $json_data['exerciseTimeout'];
    $setsCountTimeout = $json_data['setsCountTimeout'];
    $cyclesCountTimeout = $json_data['cyclesCountTimeout'];
    $cyclesCount = $json_data['cyclesCount'];
    $setsCount = $json_data['setsCount'];
    $exercises = $json_data['exercises'];
    
    $workoutType = $this->workoutTypeRepository->findOneBy(['id' => $workoutTypeId]);

    $workout = new Workout();
    $workout->setWorkoutName($workoutName);
    $workout->setWorkoutType($workoutType);
    $workout->setExerciseTimeout($exerciseTimeout);
    $workout->setSetsCountTimeout($setsCountTimeout);
    $workout->setCyclesCountTimeout($cyclesCountTimeout);
    $workout->setCyclesCount($cyclesCount);
    $workout->setSetsCount($setsCount);

    $exercise_array = [];

    foreach($exercises as $exercise) 
    {  
      $exercise_db_id = $exercise["id"];
      $exercise_db = $this->exerciseRepository->findOneBy(['id' => $exercise_db_id]);
      
      $exercise_array[] = $exercise_db;
      $exercise_array_serialized[] = $exercise_db->serialize();;
    }

    $workout->setExercises($exercise_array);

    $this->workoutRepository->add($workout, true);

    $response = $workout->serialize($exercise_array_serialized);

    return $response;
  }

  public function update(Request $request, $id): Array {
    $workout = $this->workoutRepository->findOneBy(['id' => $id]);

    if (empty($workout)) {
      throw new NotFoundHttpException('Workout not found');
    }

    $json_data = json_decode($request->getContent(), true);

    if(empty($json_data['workoutName']) || 
       empty($json_data['workoutTypeId']) || 
       empty($json_data['exerciseTimeout']) ||
       empty($json_data['setsCountTimeout']) ||
       empty($json_data['cyclesCountTimeout']) ||
       empty($json_data['cyclesCount']) ||
       empty($json_data['setsCount']) ||
       empty($json_data['exercises'])
       ) {
      return ['message' => 'Expecting mandatory parameters!'];
    }

    $workoutName = $json_data['workoutName'];
    $workoutTypeId = $json_data['workoutTypeId'];
    $exerciseTimeout = $json_data['exerciseTimeout'];
    $setsCountTimeout = $json_data['setsCountTimeout'];
    $cyclesCountTimeout = $json_data['cyclesCountTimeout'];
    $cyclesCount = $json_data['cyclesCount'];
    $setsCount = $json_data['setsCount'];
    $exercises = $json_data['exercises'];
    
    $workoutType = $this->workoutTypeRepository->findOneBy(['id' => $workoutTypeId]);

    empty($workoutName) ? true : $workout->setWorkoutName($workoutName);
    empty($workoutType) ? true : $workout->setWorkoutType($workoutType);
    empty($exerciseTimeout) ? true : $workout->setExerciseTimeout($exerciseTimeout);
    empty($setsCountTimeout) ? true : $workout->setSetsCountTimeout($setsCountTimeout);
    empty($cyclesCountTimeout) ? true : $workout->setCyclesCountTimeout($cyclesCountTimeout);
    empty($cyclesCount) ? true : $workout->setCyclesCount($cyclesCount);
    empty($setsCount) ? true : $workout->setSetsCount($setsCount);

    $exercise_array = [];

    foreach($exercises as $exercise) 
    {  
      $exercise_db_id = $exercise["id"];
      $exercise_db = $this->exerciseRepository->findOneBy(['id' => $exercise_db_id]);

      $exercise_array[] = $exercise_db;
      $exercise_array_serialized[] = $exercise_db->serialize();
    }

    $workout->setExercises($exercise_array);

    $this->workoutRepository->update($workout);

    $response = $workout->serialize($exercise_array_serialized);

    return $response;
  }

  public function delete($id): Array {
    $workout = $this->workoutRepository->findOneBy(['id' => $id]);
    if (empty($workout)) {
      throw new NotFoundHttpException('Workout not found');
    }
    $this->workoutRepository->remove($workout, true);

    return [];
  }
}