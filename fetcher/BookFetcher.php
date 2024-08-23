<?php

declare(strict_types=1);

namespace app\fetcher;

final class BookFetcher
{
    public function fetchYears(): array
    {
        // might be cached
        return \Yii::$app->db
            ->createCommand('SELECT issue_year FROM book GROUP BY issue_year')
            ->queryColumn();
    }
}
