<?php

namespace App\Dto\Request;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class ProductDto implements RequestDTOInterface
{
    /**
     * @Assert\Uuid()
     */
    protected $uuid;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(max = 50)
     */
    protected $label;

    /**
     * @Assert\Type("string")
     */
    protected $description;

    /**
     * @Assert\NotBlank()
     * @Assert\Positive()
     * @Assert\AtLeastOneOf({
     *   @Assert\Type("integer"),
     *   @Assert\Sequentially({
     *     @Assert\Type("float"),
     *     @Assert\DivisibleBy(0.01),
     *   }),
     * })
     */
    protected $price;

    protected $customValue1;

    protected $customValue2;


    public function __construct(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        if (is_array($data)) {
            $this->uuid         = $data['uuid'] ?? null;
            $this->label        = $data['label'] ?? null;
            $this->description  = $data['description'] ?? null;
            $this->price        = $data['price'] ?? null;
            $this->customValue1 = $data['customValue1'] ?? null;
            $this->customValue2 = $data['customValue2'] ?? null;
        }
    }

    /**
     * @Assert\Callback
     * @param ExecutionContextInterface $context
     */
    public function validateCustomValues(ExecutionContextInterface $context)
    {
        if ($this->getCustomValue1() === null && $this->getCustomValue2() === null) {
            $context->buildViolation('At least customValue1 or customValue2 must be defined.')
                    ->atPath('customValues')
                    ->addViolation();
        }
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getCustomValue1(): ?string
    {
        return $this->customValue1;
    }

    public function getCustomValue2(): ?string
    {
        return $this->customValue2;
    }
}
