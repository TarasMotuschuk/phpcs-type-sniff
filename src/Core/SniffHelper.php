<?php

namespace Gskema\TypeSniff\Core;

use PHP_CodeSniffer\Files\File;

class SniffHelper
{
    protected const string DEFAULT_STANDARD = 'TypeSniff';
    protected const string DEFAULT_CATEGORY = 'CodeElement';
    protected const string DEFAULT_MESSAGE = 'Violation';

    public static function addViolation(
        File $file,
        string $message,
        int $line,
        string $sniffCode,
        string $reportType,
        ?string $originId,
    ): void {
        if (null !== $originId) {
            $violationId = substr(md5($message . $originId), 0, 16);
            $message = sprintf('%s [%s]', $message, $violationId);
        }

        $sniffCode = static::normalizeSniffCode($sniffCode);

        if ('error' === $reportType) {
            $file->addErrorOnLine($message, $line, $sniffCode);
        } else {
            $file->addWarningOnLine($message, $line, $sniffCode);
        }
    }

    protected static function normalizeSniffCode(string $sniffCode): string
    {
        if (str_contains($sniffCode, '.')) {
            return $sniffCode;
        }

        return implode('.', [
            static::DEFAULT_STANDARD,
            static::DEFAULT_CATEGORY,
            $sniffCode,
            static::DEFAULT_MESSAGE,
        ]);
    }
}
