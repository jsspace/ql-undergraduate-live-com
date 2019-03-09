<?php

namespace api\controllers;

use yii;
use yii\web\Controller;
use backend\models\Book;
use backend\models\BookOrder;

class BookController extends Controller
{
    public function actionList() {
        $books = Book::find()
        ->orderBy("publish_time DESC")
        ->all();
        $book_arr[] = array();
        foreach ($books as $key => $book) {
            $book_arry[] = array(
                'id' => $book->id,
                'pic' => $book->pictrue,
                'name' => $book->name,
                'price' => $book->price,
                'order_price' => $book->order_price
            );
        }
        return json_encode($book_arry);
    }

    public function actionDetail() {
        $params = Yii::$app->request->get();
        $id = $params['id'];
        $book = Book::find()
        ->where(['id' => $id])
        ->asArray()
        ->one();
        return json_encode($book);
    }

    public function actionOrder() {
        try {
            $params = Yii::$app->request->post();
            $access_token = $params['access_token'];
            $user = \common\models\User::findIdentityByAccessToken($access_token);
            $bookid = $params['bookid'];
            $userid = $user->id;
            $book_num = $params['book_num'];
            $book_name = $params['book_name'];
            $username = $params['username'];
            $phone = $params['phone'];
            $address = $params['address'];
        } catch(Exception $e) {  
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        } finally {
            if (count($params) < 7) {
                // return array($params);
                return json_encode(array(
                    'code' => -1,
                    'message' => "预定失败，信息不完善"
                )); 
            } else {
                $order = new BookOrder();
                $order->bookid = $bookid;
                $order->userid = $userid;
                $order->book_num = $book_num;
                $order->book_name = $book_name;
                $order->username = $username;
                $order->phone = $phone;
                $order->address = $address;
        
                if($order->save()) {
                    return json_encode(array(
                        'code' => 0,
                        'message' => "预定成功"
                    ));
                } else {
                    return json_encode(array(
                        'code' => -1,
                        'message' => "预定失败"
                    ));
                }
            }
        }
    }
}
