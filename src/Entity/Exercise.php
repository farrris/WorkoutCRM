<?php

namespace App\Entity;

use App\Repository\ExerciseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExerciseRepository::class)]
class Exercise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $exerciseName;

    #[ORM\Column(type: 'integer')]
    private $repeatsCount;

    #[ORM\Column(type: 'string', length: 255)]
    private $repeatsCountTimeout;

    #[ORM\ManyToMany(targetEntity: Workout::class, mappedBy: 'exercises', cascade: ['persist'])]
    private $workouts;

    public function __construct()
    {
        $this->workouts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExerciseName(): ?string
    {
        return $this->exerciseName;
    }

    public function setExerciseName(string $exerciseName): self
    {
        $this->exerciseName = $exerciseName;

        return $this;
    }

    public function getRepeatsCount(): ?int
    {
        return $this->repeatsCount;
    }

    public function setRepeatsCount(int $repeatsCount): self
    {
        $this->repeatsCount = $repeatsCount;

        return $this;
    }

    public function getRepeatsCountTimeout(): ?string
    {
        return $this->repeatsCountTimeout;
    }

    public function setRepeatsCountTimeout(string $repeatsCountTimeout): self
    {
        $this->repeatsCountTimeout = $repeatsCountTimeout;

        return $this;
    }

    /**
     * @return Collection<int, Workout>
     */
    public function getWorkouts(): Collection
    {
        return $this->workouts;
    }

    public function addWorkout(Workout $workout): self
    {
        if (!$this->workouts->contains($workout)) {
            $this->workouts[] = $workout;
            $workout->addExercise($this);
        }

        return $this;
    }

    public function removeWorkout(Workout $workout): self
    {
        if ($this->workouts->removeElement($workout)) {
            $workout->removeExercise($this);
        }

        return $this;
    }

    public function serialize() {
        $serialize = [
            'id' => $this->getId(),
            'exerciseName' => $this->getExerciseName(),
            'repeatsCount' => $this->getRepeatsCount(),
            'repeatsCountTimeout' => $this->getRepeatsCountTimeout()
        ];
        
        return $serialize;
    }
}
