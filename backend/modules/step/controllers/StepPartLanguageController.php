<?php

namespace backend\modules\step\controllers;

use backend\models\step\StepPartLanguageSearch;
use common\models\application\ApplicationLanguage;
use common\models\step\StepPart;
use common\models\step\StepPartLanguage;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * StepPartLanguageController implements the CRUD actions for StepPartLanguage model.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class StepPartLanguageController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all StepPartLanguage models.
     * @return mixed
     */
    public function actionIndex() {
        $search_model = new StepPartLanguageSearch();
        $data_provider = $search_model->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'search_model' => $search_model,
            'data_provider' => $data_provider,
        ]);
    }

    /**
     * Displays a single StepPartLanguage model.
     * @param integer $step_part_id
     * @param integer $application_language_id
     * @return mixed
     */
    public function actionView($step_part_id, $application_language_id) {
        return $this->render('view', [
            'model' => $this->findModel($step_part_id, $application_language_id),
        ]);
    }

    /**
     * Creates a new StepPartLanguage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new StepPartLanguage();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'step_part_id' => $model->step_part_id, 'application_language_id' => $model->application_language_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'step_parts' => StepPart::find()->all(),
                'application_languages' => ApplicationLanguage::find()->all(),
            ]);
        }
    }

    /**
     * Updates an existing StepPartLanguage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $step_part_id
     * @param integer $application_language_id
     * @return mixed
     */
    public function actionUpdate($step_part_id, $application_language_id) {
        $model = $this->findModel($step_part_id, $application_language_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'step_part_id' => $model->step_part_id, 'application_language_id' => $model->application_language_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'step_parts' => StepPart::find()->all(),
                'application_languages' => ApplicationLanguage::find()->all(),
            ]);
        }
    }

    /**
     * Deletes an existing StepPartLanguage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $step_part_id
     * @param integer $application_language_id
     * @return mixed
     */
    public function actionDelete($step_part_id, $application_language_id) {
        $this->findModel($step_part_id, $application_language_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the StepPartLanguage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $step_part_id
     * @param integer $application_language_id
     * @return StepPartLanguage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($step_part_id, $application_language_id) {
        if (($model = StepPartLanguage::findOne(['step_part_id' => $step_part_id, 'application_language_id' => $application_language_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}