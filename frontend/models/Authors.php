<?php

namespace frontend\models;

use Yii;
use frontend\models\Books;
/**
 * This is the model class for table "authors".
 *
 * @property integer $author_id
 * @property string $author_name
 * @property string $date_of_birth
 * @property string $created_at
 * @property string $modified_at
 */
class Authors extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $no_of_books;
    public static function tableName()
    {
        return 'authors';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['author_name', 'date_of_birth', 'author_email', 'author_password'], 'required'],
            [['date_of_birth', 'created_at', 'modified_at'], 'safe'],
            [['author_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'author_id' => 'Author ID',
            'author_name' => 'Author Name',
            'date_of_birth' => 'Date Of Birth',
            'created_at' => 'Created At',
            'modified_at' => 'Modified At',
        ];
    }
    public function afterFind() {
        $this->no_of_books = count($this->books);
        parent::afterFind();
    }
    public function getBooks()
    {
        return $this->hasMany(Books::className(), ['author_id' => 'author_id']);
    }
}
