<?php

namespace Gskema\TypeSniff\Sniffs\CodeElement;

use Error;
use Gskema\TypeSniff\Core\CodeElement\Element\AbstractFqcnElement;
use Gskema\TypeSniff\Core\CodeElement\Element\ClassElement;
use Gskema\TypeSniff\Core\CodeElement\Element\CodeElementInterface;
use Gskema\TypeSniff\Core\SniffHelper;
use IteratorAggregate;
use PHP_CodeSniffer\Files\File;
use ReflectionClass;
use ReflectionException;

class IteratorItemTypeSniff implements CodeElementSniffInterface
{
    protected const CODE = 'IteratorItemTypeSniff';

    protected string $reportType = 'warning';
    protected bool $addViolationId = true;

    /**
     * @inheritDoc
     */
    public function configure(array $config): void
    {
        $this->reportType = (string)($config['reportType'] ?? 'warning');
        $this->addViolationId = (bool)($config['addViolationId'] ?? true);
    }

    /**
     * @inheritDoc
     */
    public function register(): array
    {
        return [
            ClassElement::class,
        ];
    }

    /**
     * @inheritDoc
     * @param AbstractFqcnElement $element
     */
    public function process(File $file, CodeElementInterface $element, CodeElementInterface $parentElement): void
    {
        try {
            $ref = new ReflectionClass($element->getFqcn());
        } catch (Error | ReflectionException) {
            return; // give up...
        }

        if ($ref->getParentClass() && $ref->getParentClass()->implementsInterface(IteratorAggregate::class)) {
            return; // we only check direct implementations for now
        }

        if (!in_array(IteratorAggregate::class, $ref->getInterfaceNames())) {
            return;
        }

        if ($element->getDocBlock()->getTagsByName('template-implements')) {
            return;
        } elseif ($element->getDocBlock()->getTagsByName('template-extends')) {
            return;
        } else {
            $originId = $this->addViolationId ? $element->getFqcn() : null;
            SniffHelper::addViolation(
                $file,
                'Classes which implement IteratorAggregate must have "@template-implements IteratorAggregate<?>"'
                . ' doc tag with a specified item type or template type',
                $element->getLine(),
                static::CODE,
                $this->reportType,
                $originId
            );
        }
    }
}
