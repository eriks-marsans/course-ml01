<?php

declare(strict_types=1);

namespace Magebit\Faq\Api\Data;

use DateTimeInterface;

interface FaqInterface
{
    public const ID = 'faq_id';
    public const QUESTION = 'question';
    public const ANSWER = 'answer';
    public const STATUS = 'status';
    public const POSITION = 'position';
    public const UPDATED_AT = 'updated_at';

    public const STATUS_ENABLED = 1;
    public const STATUS_DISABLED = 0;

    /**
     * @return array<string,mixed> All fields in stringable form.
     */
    public function getAllData(): array;

    public function getId(): ?int;

    public function setQuestion(string $question): self;

    public function getQuestion(): string;

    public function setAnswer(string $answer): self;

    public function getAnswer(): string;

    public function setStatus(int $status): self;

    public function getStatus(): int;

    public function setPosition(int $position): self;

    public function getPosition(): int;

    public function getUpdatedAt(): DateTimeInterface;
}
