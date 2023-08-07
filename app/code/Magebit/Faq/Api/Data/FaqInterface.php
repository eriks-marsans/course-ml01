<?php

declare(strict_types=1);

namespace Magebit\Faq\Api\Data;

use DateTimeInterface;

interface FaqInterface
{
    public const ID = 'id';
    public const QUESTION = 'question';
    public const ANSWER = 'answer';
    public const STATUS = 'status';
    public const POSITION = 'position';
    public const UPDATED_AT = 'updated_at';

    public const STATUS_ENABLED = 1;
    public const STATUS_DISABLED = 0;

    /**
     * @return int
     */
    public function getId(): ?int;

    /**
     * @param string $question
     * @return self
     */
    public function setQuestion(string $question): self;

    /**
     * @return string
     */
    public function getQuestion(): string;

    /**
     * @param string $answer
     * @return self
     */
    public function setAnswer(string $answer): self;

    /**
     * @return string
     */
    public function getAnswer(): string;

    /**
     * @param int $status
     * @return self
     */
    public function setStatus(int $status): self;

    /**
     * @return int
     */
    public function getStatus(): int;

    /**
     * @param int $position
     * @return self
     */
    public function setPosition(int $position): self;

    /**
     * @return int
     */
    public function getPosition(): int;

    /**
     * @return DateTimeInterface
     */
    public function getUpdatedAt(): DateTimeInterface;
}
