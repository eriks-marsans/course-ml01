<?php

declare(strict_types=1);

namespace Magebit\Faq\Model;

use DateTimeImmutable;
use DateTimeInterface;
use Magebit\Faq\Api\Data\FaqInterface;
use Magento\Framework\Model\AbstractModel;
use Magebit\Faq\Model\ResourceModel\Faq as FaqResource;

class Faq extends AbstractModel implements FaqInterface
{
    protected function _construct()
    {
        $this->_init(FaqResource::class);
    }

    public function getAllData(): array
    {
        return $this->getData();
    }

    public function getId(): ?int
    {
        $id = $this->getData(FaqInterface::ID);

        return $id !== null ? (int)$id : null;
    }

    public function setQuestion(string $question): self
    {
        $this->setData(FaqInterface::QUESTION, $question);

        return $this;
    }

    public function getQuestion(): string
    {
        return $this->getData(FaqInterface::QUESTION);
    }

    public function setAnswer(string $answer): self
    {
        $this->setData(FaqInterface::ANSWER, $answer);

        return $this;
    }

    public function getAnswer(): string
    {
        return $this->getData(FaqInterface::ANSWER);
    }

    public function setStatus(int $status): self
    {
        $this->setData(FaqInterface::STATUS, $status);

        return $this;
    }

    public function getStatus(): int
    {
        return $this->getData(FaqInterface::STATUS);
    }

    public function setPosition(int $position): self
    {
        $this->setData(FaqInterface::POSITION, $position);

        return $this;
    }

    public function getPosition(): int
    {
        return $this->getData(FaqInterface::POSITION);
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return DateTimeImmutable::createFromFormat(
            FaqResource::FORMAT_CREATED_AT,
            $this->getData(FaqInterface::UPDATED_AT)
        );
    }
}
