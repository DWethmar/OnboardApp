<?php

namespace common\queries\application;
use InvalidArgumentException;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\application\ApplicationVersion]].
 *
 * @see \common\models\application\ApplicationVersion
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class ApplicationVersionQuery extends ActiveQuery {

    /**
     * Get version by version numbers.
     *
     * @param integer $application_id   The application id.
     * @param integer $major_version    The Major version.
     * @param integer $minor_version    The Minor Version.
     * @param integer $patch_version    The Patch version.
     *
     * @return ActiveQuery The query.
     */
    public function byVersion($application_id, $major_version, $minor_version, $patch_version) {
        $this->andWhere([
            'application_id' =>     $application_id,
            'major_version' =>      $major_version,
            'minor_version' =>      $minor_version,
            'patch_version' =>      $patch_version
        ]);
        return $this;
    }

    /**
     * Get version by version string.
     *
     * @param integer $application_id The application id.
     * @param string $version The version to check
     * @return ActiveQuery The query.
     * @throws InvalidArgumentException
     */
    public function byStringVersion($application_id, $version) {
        $versions = explode('.', $version);
        if (count($versions) != 3) {
            throw new InvalidArgumentException('Invalid version! Valid example: 1.0.0');
        }

        return $this->byVersion($application_id, $versions[0], $versions[1], $versions[2]);
    }

    /**
     * @inheritdoc
     * @return \common\models\application\ApplicationVersion[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\application\ApplicationVersion|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}