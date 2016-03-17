<?php

namespace backend\modules\application\controllers;

use Yii;
use common\models\application\ChainRequirement;
use backend\models\application\ChainRequirementSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ChainRequirementController implements the CRUD actions for ChainRequirement model.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class ChainRequirementController extends Controller {

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
     * Lists all ChainRequirement models.
     * @return mixed
     */
    public function actionIndex() {
        $search_model = new ChainRequirementSearch();
        $data_provider = $search_model->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'search_model' => $search_model,
            'data_provider' => $data_provider,
        ]);
    }

    /**
     * Displays a single ChainRequirement model.
     * @param integer $parent_chain_id
     * @param integer $child_chain_id
     * @return mixed
     */
    public function actionView($parent_chain_id, $child_chain_id) {
        return $this->render('view', [
            'model' => $this->findModel($parent_chain_id, $child_chain_id),
        ]);
    }

    /**
     * Creates a new ChainRequirement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new ChainRequirement();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'parent_chain_id' => $model->parent_chain_id, 'child_chain_id' => $model->child_chain_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ChainRequirement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $parent_chain_id
     * @param integer $child_chain_id
     * @return mixed
     */
    public function actionUpdate($parent_chain_id, $child_chain_id) {
        $model = $this->findModel($parent_chain_id, $child_chain_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'parent_chain_id' => $model->parent_chain_id, 'child_chain_id' => $model->child_chain_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ChainRequirement model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $parent_chain_id
     * @param integer $child_chain_id
     * @return mixed
     */
    public function actionDelete($parent_chain_id, $child_chain_id) {
        $this->findModel($parent_chain_id, $child_chain_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ChainRequirement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $parent_chain_id
     * @param integer $child_chain_id
     * @return ChainRequirement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($parent_chain_id, $child_chain_id) {
        if (($model = ChainRequirement::findOne(['parent_chain_id' => $parent_chain_id, 'child_chain_id' => $child_chain_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}