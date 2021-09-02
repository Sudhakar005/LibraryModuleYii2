<?php

namespace frontend\models;
use frontend\models\Books;
use Yii;

/**
 * This is the model class for table "libraries".
 *
 * @property integer $id
 * @property string $name
 * @property string $opening_time
 * @property string $closing_time
 * @property string $created_at
 * @property string $modified_at
 */
class Libraries extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $no_of_books;
    public $books_details;
    public $books_list;
    public static function tableName()
    {
        return 'libraries';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'opening_time', 'closing_time'], 'required'],
            [['opening_time', 'closing_time', 'created_at'], 'safe'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'opening_time' => 'Opening Time',
            'closing_time' => 'Closing Time',
            'created_at' => 'Created At',
            'No Of Books' => 'no_of_books',
            //'modified_at' => 'Modified At',
        ];
    }
    public function afterFind() {
        $this->no_of_books = count($this->books);
        $this->books_details = $this->books;
        $this->books_list = $this->booklist;
        parent::afterFind();
    }
    public function getBooks()
    {
        return $this->hasMany(Books::className(), ['library_id' => 'id']);
    }
    public function getBookList()
    {
        $data = Books::find()->where(['library_id' => null])->all();
        return $data;
    }
}
