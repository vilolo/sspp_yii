<?php

namespace backend\modules\v1\controllers\basic;

use backend\modules\v1\controllers\base\BackendBaseController;
use common\utils\JsonUtil;
use Yii;
use common\models\Template;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TemplateController implements the CRUD actions for Template model.
 */
class TemplateController extends BackendBaseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionDesc()
    {
        $result = Template::find()->where(['type' => 1])->select(['name', 'content'])->asArray()->all();
        return JsonUtil::success($result);
    }

    public function actionWord()
    {
        $result = Template::find()->where(['type' => 2])->select(['name', 'content'])->asArray()->all();
        return JsonUtil::success($result);
    }

    /**
     * Creates a new Template model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Template();

        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            return JsonUtil::success();
        }else{
            return JsonUtil::error('添加失败'.print_r($model->errors, true));
        }
    }

    /**
     * Updates an existing Template model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            return JsonUtil::success();
        }else{
            return JsonUtil::error('修改失败'.print_r($model->errors,true));
        }
    }

    /**
     * Deletes an existing Template model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return JsonUtil::success();
    }

    /**
     * Finds the Template model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Template the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Template::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
