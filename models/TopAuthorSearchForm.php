<?php

declare(strict_types=1);

namespace app\models;

use app\dto\TopAuthorDto;
use app\fetcher\BookFetcher;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\helpers\ArrayHelper;

final class TopAuthorSearchForm extends Model
{
    public ?string $year = null;

    private const LIMIT = 10;

    public function __construct(private readonly BookFetcher $bookFetcher, $config = [])
    {
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            ['year', 'required'],
            ['year', 'validateYear']
        ];
    }

    public function validateYear(): void
    {
        if (!preg_match('|^\d{1,4}$|', $this->year)) {
            $this->addError('year', 'Значение не является годом.');
            return;
        }

        if (!in_array($this->year, $this->bookFetcher->fetchYears())) {
            $this->addError('year', 'Неотчётный год.');
        }
    }

    public function search(): DataProviderInterface
    {
        if (!$this->validate()) {
            $result = new ActiveDataProvider();
            $result->setModels([]);
            return $result;
        }

        $authorIdsWithBooksNumber = $this->findAuthorIdsWithBooksNumber();

        $authorIds = ArrayHelper::getColumn($authorIdsWithBooksNumber, 'id');
        $query = Author::find();
        $query->where(['in', 'id', $authorIds]);
        $authors = ArrayHelper::index($query->all(), 'id');

        $dtos = [];
        foreach ($authorIdsWithBooksNumber as $authorIdWithBooksCount) {
            if (isset($authors[$authorIdWithBooksCount['id']])) {
                $dtos[] = new TopAuthorDto($authors[$authorIdWithBooksCount['id']], $authorIdWithBooksCount['cnt']);
            }
        }
        return new ActiveDataProvider([
            'models' => $dtos
        ]);
    }

    private function findAuthorIdsWithBooksNumber(): array
    {
        return \Yii::$app->db->createCommand('select author_id as id, count(*) as cnt
            from book_author
            where book_id in (select id from book where issue_year = :year)
            group by author_id
            order by cnt DESC
            limit :limit', [
            ':year' => $this->year,
            ':limit' => self::LIMIT
        ])->queryAll();
    }
}
