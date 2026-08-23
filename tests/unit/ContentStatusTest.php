<?php

use App\Services\ContentStatus;
use CodeIgniter\Test\CIUnitTestCase;

final class ContentStatusTest extends CIUnitTestCase
{
    public function testNormalizesSupportedStatuses(): void
    {
        $this->assertSame(ContentStatus::PUBLISHED, ContentStatus::normalize('Publicado'));
        $this->assertSame(ContentStatus::REVIEW, ContentStatus::normalize('Em aprovação'));
        $this->assertSame(ContentStatus::DRAFT, ContentStatus::normalize('Rascunho'));
    }

    public function testUnknownStatusFallsBackToDraft(): void
    {
        $this->assertSame(ContentStatus::DRAFT, ContentStatus::normalize('invalido'));
        $this->assertFalse(ContentStatus::isPubliclyListed('invalido'));
    }

    public function testOnlyPublishedContentIsListed(): void
    {
        $this->assertTrue(ContentStatus::isPubliclyListed('publicado'));
        $this->assertFalse(ContentStatus::isPubliclyListed('aprovacao'));
        $this->assertTrue(ContentStatus::isReview('aprovacao'));
    }
}
