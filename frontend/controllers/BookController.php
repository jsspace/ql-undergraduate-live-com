<?php

namespace frontend\controllers;
use backend\models\Book;
use yii\data\Pagination;
use backend\models\BookOrder;
use backend\models\User;
use Yii;

class BookController extends \yii\web\Controller
{
    public function actionList()
    {
        $books = Book::find()
        ->orderBy('id desc');
        $pages = new Pagination(['totalCount' => $books->count(), 'pageSize' => '5']);
        $models = $books->offset($pages->offset)
        ->limit($pages->limit)
        ->all();
        return $this->render('list', ['books' => $models, 'pages' => $pages]);
    }
    public function actionDetail($bookid, $invite=0)
    {
        $book = Book::find()
        ->where(['id' => $bookid])
        ->one();
        return $this->render('detail', ['book' => $book]);
    }
    public function actionOrder()
    {
    	$data = Yii::$app->request->Post();
    	$book_id = $data['book_id'];
    	$book = Book::find()
    	->where(['id' => $book_id])
    	->one();
    	$userid = Yii::$app->user->id;
    	$user = User::find()
    	->where(['id' => $userid])
    	->one();
    	$order_book_num = $data['order_book_num'];
    	$book_order = new BookOrder();
    	$book_order->bookid = $book_id;
    	$book_order->userid = $userid;
    	$book_order->book_num = $order_book_num;
    	$book_order->username = $user->username;
    	$book_order->phone = $user->phone;
    	$book_order->book_name = $book->name;
    	if ($book_order->save()) {
    		$result = array(
    			'status' => '200',
    			'msg' => '预定成功'
    		);
    	} else {
    		$result = array(
    			'status' => 0,
    			'msg' => '预定失败'
    		);
    	}
    	return json_encode($result);
    }
}
