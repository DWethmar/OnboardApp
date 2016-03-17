<?php

use common\models\application\Chain;
use common\models\application\CommonChain;
use common\models\application\Page;
use common\models\step\ApplicationIdentityProgressLog;
use common\models\step\CommonStep;
use common\models\step\Step;
use yii\db\Schema;
use yii\db\Migration;

/**
 * Link Pages, chain and step to their Common record.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class m151116_122138_transfer_data extends Migration {

    public function safeUp() {

        foreach (Page::find()->with('application')->all() as $page) {
            $application = $page->application;
            $application_version = $application->getApplicationVersions()->one();
            if ($application_version) {
                $page->application_version_id = $application_version->id;
                $page->save();
            } else {
                throw exception('Common Chain could not be saved!');
            }
        }

        foreach (Chain::find()->all() as $chain) {
            //Seed initial common chains
            $common_chain = new CommonChain();
            $common_chain->application_id = $chain->application->id;
            if ($common_chain->save()) {
                $chain->common_chain_id = $common_chain->id;
                $chain->save();
            } else {
                throw exception('Common Chain could not be saved!');
            }
        }

        foreach (Step::find()->all() as $step) {
            //Seed initial common chains
            $common_step = new CommonStep();
            $common_step->application_id = $step->application->id;
            if ($common_step->save()) {
                $step->common_step_id = $common_step->id;
                $step->save();
            } else {
                throw exception('Common Step could not be saved!');
            }
        }

        foreach (ApplicationIdentityProgressLog::find()->all() as $log) {
            $log->common_step_id = $log->step->commonStep->id;
            $log->common_chain_id = $log->chain->commonChain->id;
            $log->save();
        }

        $this->execute('ALTER TABLE {{%page}} ALTER COLUMN "application_version_id" SET NOT NULL');
        $this->execute('ALTER TABLE {{%chain}} ALTER COLUMN "common_chain_id" SET NOT NULL');
        $this->execute('ALTER TABLE {{%step}} ALTER COLUMN "common_step_id" SET NOT NULL');

        $this->execute('ALTER TABLE {{%application_identity_progress_log}} ALTER COLUMN "common_step_id" SET NOT NULL');
        $this->execute('ALTER TABLE {{%application_identity_progress_log}} ALTER COLUMN "common_chain_id" SET NOT NULL');
    }

    public function safeDown() {
        $this->execute('ALTER TABLE {{%page}} ALTER COLUMN "application_version_id" DROP NOT NULL');
        $this->execute('ALTER TABLE {{%chain}} ALTER COLUMN "common_chain_id" DROP NOT NULL');
        $this->execute('ALTER TABLE {{%step}} ALTER COLUMN "common_step_id" DROP NOT NULL');

        $this->execute('ALTER TABLE {{%application_identity_progress_log}} ALTER COLUMN "common_step_id" DROP NOT NULL');
        $this->execute('ALTER TABLE {{%application_identity_progress_log}} ALTER COLUMN "common_chain_id" DROP NOT NULL');
    }

}
