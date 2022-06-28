<?php

namespace App\Entity;

use App\Repository\WorkoutRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WorkoutRepository::class)]
class Workout
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $workoutName;

    #[ORM\ManyToOne(targetEntity: WorkoutType::class, inversedBy: 'workouts')]
    #[ORM\JoinColumn(nullable: false)]
    private $workoutType;

    #[ORM\Column(type: 'string', length: 255)]
    private $exerciseTimeout;

    #[ORM\Column(type: 'string', length: 255)]
    private $setsCountTimeout;

    #[ORM\Column(type: 'string', length: 255)]
    private $cyclesCountTimeout;

    #[ORM\Column(type: 'integer')]
    private $cyclesCount;

    #[ORM\Column(type: 'integer')]
    private $setsCount;

    #[ORM\ManyToMany(targetEntity: Exercise::class, inversedBy: 'workouts', cascade: ['persist'])]
    private $exercises;

    public function __construct()
    {
        $this->exercises = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWorkoutName(): ?string
    {
        return $this->workoutName;
    }

    public function setWorkoutName(string $workoutName): self
    {
        $this->workoutName = $workoutName;

        return $this;
    }

    public function getWorkoutType(): ?WorkoutType
    {
        return $this->workoutType;
    }

    public function setWorkoutType(?WorkoutType $workoutType): self
    {
        $this->workoutType = $workoutType;

        return $this;
    }

    public function getExerciseTimeout(): ?string
    {
        return $this->exerciseTimeout;
    }

    public function setExerciseTimeout(string $exerciseTimeout): self
    {
        $this->exerciseTimeout = $exerciseTimeout;

        return $this;
    }

    public function getSetsCountTimeout(): ?string
    {
        return $this->setsCountTimeout;
    }

    public function setSetsCountTimeout(string $setsCountTimeout): self
    {
        $this->setsCountTimeout = $setsCountTimeout;

        return $this;
    }

    public function getCyclesCountTimeout(): ?string
    {
        return $this->cyclesCountTimeout;
    }

    public function setCyclesCountTimeout(string $cyclesCountTimeout): self
    {
        $this->cyclesCountTimeout = $cyclesCountTimeout;

        return $this;
    }

    public function getCyclesCount(): ?int
    {
        return $this->cyclesCount;
    }

    public function setCyclesCount(int $cyclesCount): self
    {
        $this->cyclesCount = $cyclesCount;

        return $this;
    }

    public function getSetsCount(): ?int
    {
        return $this->setsCount;
    }

    public function setSetsCount(int $setsCount): self
    {
        $this->setsCount = $setsCount;

        return $this;
    }

    /**
     * @return Collection<int, Exercise>
     */
    public function getExercises(): Collection
    {
        return $this->exercises;
    }

    public function setExercises(Array $exercises): self
    {
        $this->exercises = $exercises;

        return $this;
    }

    public function addExercise(Exercise $exercise): self
    {
        if (!$this->exercises->contains($exercise)) {
            $this->exercises[] = $exercise;
        }

        return $this;
    }

    public function removeExercise(Exercise $exercise): self
    {
        $this->exercises->removeElement($exercise);

        return $this;
    }

    public function serialize($exercise_array) {
        $serialize = [
            'id' => $this->getId(),
            'workoutName' => $this->getWorkoutName(),
            'workoutType' => [
              'id' => $this->getWorkoutType()->getId(),
              'typeName' => $this->getWorkoutType()->getTypeName(),
            ],
            'exerciseTimeout' => $this->getExerciseTimeout(),
            'setsCountTimeout' => $this->getSetsCountTimeout(),
            'cyclesCountTimeout' => $this->getCyclesCountTimeout(),
            'cyclesCount' => $this->getCyclesCount(),
            'setsCount' => $this->getSetsCount(),
            'exercises' => $exercise_array
          ];
      
          return $serialize;
    }
}
