<?php

namespace frontend\models;
use frontend\models\Authors;
use frontend\models\Libraries;
use Yii;

/**
 * This is the model class for table "books".
 *
 * @property integer $book_id
 * @property integer $library_id
 * @property integer $author_id
 * @property string $book_title
 * @property string $language
 * @property string $published_at
 * @property string $created_at
 * @property string $modified_at
 */
class Books extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $author_list;
    public $author_name;
    public static function tableName()
    {
        return 'books';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['book_title', 'language', 'published_at', 'author_id'], 'required'],
            [['library_id', 'author_id'], 'integer'],
            [['language'], 'string'],
            [['published_at', 'created_at', 'modified_at'], 'safe'],
            [['book_title'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'book_id' => 'Book ID',
            'library_id' => 'Library ID',
            'author_id' => 'Author List',
            'book_title' => 'Book Title',
            'language' => 'Language',
            'published_at' => 'Published At',
            'created_at' => 'Created At',
            'modified_at' => 'Modified At',
        ];
    }
    public function getAuthor()
    {
       return $this->hasOne(Authors::className(), ['author_id' => 'author_id']);
    }
    public function getAuthorList()
    {
        $data = Authors::find()->all();
        return $data;
    }
}
