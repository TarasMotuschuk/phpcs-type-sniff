<?php

namespace Gskema\TypeSniff\Sniffs\CodeElement;

use Gskema\TypeSniff\Core\CodeElement\Element\ClassElement;
use Gskema\TypeSniff\Core\CodeElement\Element\CodeElementInterface;
use Gskema\TypeSniff\Core\SniffHelper;
use PHP_CodeSniffer\Files\File;

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
     * @param ClassElement $element
     */
    public function process(File $file, CodeElementInterface $element, CodeElementInterface $parentElement): void
    {
        if (empty($element->interfaceNames)) {
            return;
        }

        // We don't want to do reflection because it may do FatalError
        // which we don't want to do custom handlers or libs for now.
        // For now just check direct interface names with taking imports into account - collision chance is low-ish.
        // Also, it should be direct implementation, if it's parent implementation that various other template tags
        // can be used instead.
        $hasIteratorAggregate = in_array('\\IteratorAggregate', $element->interfaceNames)
            || in_array('IteratorAggregate', $element->interfaceNames);
        if (!$hasIteratorAggregate) {
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
