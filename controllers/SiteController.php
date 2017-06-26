<?php

namespace app\controllers;

use app\models\MyForm;
use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\web\Response;

class SiteController extends Controller
{

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Потготавливает для отображения данные из базы данных,
     *
     * @return string
     */
    public function actionIndex()
    {
        // Потготовка данных для виджета GridView
        $dataProvider = new ActiveDataProvider([
            'query' => MyForm::find(),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        return $this->render('index',compact('dataProvider'));
    }

    /**
     * Метод удаляет конкретную запись таблицы
     * Если записи по полю id не было найдено, пользователю выводится уведомление, о некорректном срабатывании
     *
     * Если запись была успешно удалена, пользователю выводится уведомление, о корректном срабатывании
     * @param id - первичный ключ, для получения конкретной записи таблицы
     *
     * @return Response - редирект на предыдущую страницу
     */
    public function actionDelete($id)
    {
        try {
            $user = MyForm::findOne(['id' => $id]);
            $name = $user->firstName .' '. $user->lastName;

            $user->delete();

            Yii::$app->session->setFlash('success','Пользователь '.$name.' успешно удален');

        }catch (\Error $e){
            Yii::$app->session->setFlash('error','Ошибка при работе с базой данных');
        }
        return $this->goBack();
    }

    /**
     * Метод запускает событие для редактирования конкретной записи таблицы
     *
     * @return Response - запуск события actionDriver
     */
    public function actionUpdate()
    {
        return $this->runAction('form');
    }

    /**
     * Метод потготавливает для отображения данные формы
     * Если в url присутсвует GET параметр id, потготавливаются данные для вывода формы редактирования
     * конкретной записи таблицы (Если записи по полю id не было найдено, пользователю выводится уведомление,
     * о некорректном срабатывании)
     *
     * Если в url отсутствует GET параметр id, потготавливаются данные для вывода формы создания записи таблицы
     *
     * Если форма успешно отработана (данные прошли валидацию и были занесены в базу данных), производится редирект
     * на главную страницу, где выводится уведомление об успешном срабатывании
     *
     * @return string
     */
    public function actionForm()
    {

        if ($_GET['id'] === null) {
            $user = new MyForm();
            $this->view->title = 'Добавить Пользователя';
            $message = 'добавлена';
        }else{
            try {
                $user = MyForm::findOne(['id' => $_GET['id']]);
                $this->view->title = 'Редактировать Пользователя';
                $message = 'отредактирована';
            }catch (\Error $e){
                Yii::$app->session->setFlash('error','Ошибка при работе с базой данных');
                return $this->goBack();
            }

        }

        if ($user->load(Yii::$app->request->post())){
            $user->birthday = date('Y-m-d',strtotime($user->birthday));
           if($user->save()){
               Yii::$app->session->setFlash('success','Запись успешно '.$message);
               return $this->redirect('/');
           }else{
               Yii::$app->session->setFlash('error',$user->getFirstErrors());
           }
            return $this->refresh();
        }
        return $this->render('myForm',compact('user','title'));
    }
}
